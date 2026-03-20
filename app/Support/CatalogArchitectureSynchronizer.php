<?php

namespace App\Support;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Room;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use RuntimeException;

class CatalogArchitectureSynchronizer
{
    public function __construct(
        protected bool $force = false,
    ) {
    }

    public function ensurePrerequisites(): void
    {
        $missing = [];

        foreach (['rooms', 'product_types', 'collections', 'collection_product'] as $table) {
            if (!Schema::hasTable($table)) {
                $missing[] = $table;
            }
        }

        foreach (['room_id', 'product_type_id', 'category_kind', 'is_indexable'] as $column) {
            if (!Schema::hasColumn('categories', $column)) {
                $missing[] = 'categories.' . $column;
            }
        }

        foreach (['room_id', 'product_type_id', 'primary_collection_id', 'sale_mode'] as $column) {
            if (!Schema::hasColumn('products', $column)) {
                $missing[] = 'products.' . $column;
            }
        }

        if ($missing !== []) {
            throw new RuntimeException(
                'La nouvelle architecture catalogue n’est pas encore migrée. Lance d’abord `php artisan migrate` puis relance la synchronisation. Éléments manquants: '
                . implode(', ', $missing)
            );
        }
    }

    public function run(): array
    {
        $this->ensurePrerequisites();

        return DB::transaction(function () {
            $rooms = $this->syncRooms();
            $productTypes = $this->syncProductTypes($rooms);
            $categories = $this->syncCategories($rooms, $productTypes);
            $products = $this->syncProducts();

            return compact('categories', 'products') + [
                'rooms' => [
                    'count' => $rooms->count(),
                ],
                'product_types' => [
                    'count' => $productTypes->count(),
                ],
            ];
        });
    }

    protected function syncRooms(): Collection
    {
        $rooms = collect(config('catalog_architecture.rooms', []))->map(function (array $definition) {
            return Room::updateOrCreate(
                ['code' => $definition['code']],
                [
                    'name' => $definition['name'],
                    'slug' => $definition['slug'],
                    'tagline' => $definition['tagline'] ?? null,
                    'description' => $definition['description'] ?? null,
                    'position' => $definition['position'] ?? 0,
                    'is_active' => true,
                ]
            );
        });

        return $rooms->keyBy('code');
    }

    protected function syncProductTypes(Collection $roomsByCode): Collection
    {
        $types = collect(config('catalog_architecture.product_types', []))->map(function (array $definition) use ($roomsByCode) {
            $room = isset($definition['room_code']) ? $roomsByCode->get($definition['room_code']) : null;

            return ProductType::updateOrCreate(
                ['code' => $definition['code']],
                [
                    'room_id' => $room?->id,
                    'name' => $definition['name'],
                    'slug' => $definition['slug'],
                    'short_label' => $definition['short_label'] ?? null,
                    'description' => $definition['description'] ?? null,
                    'position' => $definition['position'] ?? 0,
                    'is_active' => true,
                ]
            );
        });

        return $types->keyBy('code');
    }

    protected function syncCategories(Collection $roomsByCode, Collection $typesByCode): array
    {
        $categories = Category::query()
            ->select([
                'id',
                'parent_id',
                'name',
                'slug',
                'room_id',
                'product_type_id',
                'category_kind',
                'is_indexable',
            ])
            ->get()
            ->keyBy('id');

        $cache = [];
        $stats = [
            'processed' => $categories->count(),
            'room_updates' => 0,
            'type_updates' => 0,
            'kind_updates' => 0,
            'indexable_updates' => 0,
            'unchanged' => 0,
        ];

        foreach ($categories as $category) {
            $classification = $this->classifyCategory($category, $categories, $cache);

            $desiredRoomId = $classification['room_code'] ? $roomsByCode->get($classification['room_code'])?->id : null;
            $desiredTypeId = $classification['type_code'] ? $typesByCode->get($classification['type_code'])?->id : null;
            $desiredKind = $classification['category_kind'] ?? 'catalog';
            $desiredIndexable = (bool) ($classification['is_indexable'] ?? true);

            $dirty = false;

            if (($this->force || !$category->room_id) && $category->room_id !== $desiredRoomId) {
                $category->room_id = $desiredRoomId;
                $stats['room_updates']++;
                $dirty = true;
            }

            if (($this->force || !$category->product_type_id) && $category->product_type_id !== $desiredTypeId) {
                $category->product_type_id = $desiredTypeId;
                $stats['type_updates']++;
                $dirty = true;
            }

            if (($this->force || empty($category->category_kind) || $category->category_kind === 'catalog') && $category->category_kind !== $desiredKind) {
                $category->category_kind = $desiredKind;
                $stats['kind_updates']++;
                $dirty = true;
            }

            if ($this->force && $category->is_indexable !== $desiredIndexable) {
                $category->is_indexable = $desiredIndexable;
                $stats['indexable_updates']++;
                $dirty = true;
            }

            if ($dirty) {
                $category->saveQuietly();
            } else {
                $stats['unchanged']++;
            }
        }

        return $stats;
    }

    protected function syncProducts(): array
    {
        $stats = [
            'processed' => 0,
            'room_updates' => 0,
            'type_updates' => 0,
            'sale_mode_updates' => 0,
            'unchanged' => 0,
        ];

        Product::query()
            ->with('category:id,room_id,product_type_id,category_kind')
            ->orderBy('id')
            ->chunkById(200, function ($products) use (&$stats) {
                foreach ($products as $product) {
                    $stats['processed']++;

                    $category = $product->category;
                    if (!$category) {
                        $stats['unchanged']++;
                        continue;
                    }

                    $dirty = false;

                    if (($this->force || !$product->room_id) && $category->room_id && $product->room_id !== $category->room_id) {
                        $product->room_id = $category->room_id;
                        $stats['room_updates']++;
                        $dirty = true;
                    }

                    if (($this->force || !$product->product_type_id) && $category->product_type_id && $product->product_type_id !== $category->product_type_id) {
                        $product->product_type_id = $category->product_type_id;
                        $stats['type_updates']++;
                        $dirty = true;
                    }

                    if (
                        $category->category_kind === 'bundle'
                        && ($this->force || ($product->sale_mode ?? 'catalog') === 'catalog')
                        && $product->sale_mode !== 'bundle'
                    ) {
                        $product->sale_mode = 'bundle';
                        $stats['sale_mode_updates']++;
                        $dirty = true;
                    }

                    if ($dirty) {
                        $product->saveQuietly();
                    } else {
                        $stats['unchanged']++;
                    }
                }
            });

        return $stats;
    }

    protected function classifyCategory(Category $category, Collection $categories, array &$cache): array
    {
        if (isset($cache[$category->id])) {
            return $cache[$category->id];
        }

        $classification = [
            'room_code' => null,
            'type_code' => null,
            'category_kind' => 'catalog',
            'is_indexable' => true,
        ];

        $classification = $this->applyClassification($classification, $this->exactCategoryRules()[$category->slug] ?? []);
        $classification = $this->applyClassification($classification, $this->inferFromSlug($category->slug));

        if ($category->parent_id && $categories->has($category->parent_id)) {
            $parentClassification = $this->classifyCategory($categories->get($category->parent_id), $categories, $cache);

            if (!$classification['room_code']) {
                $classification['room_code'] = $parentClassification['room_code'];
            }

            if (!$classification['type_code'] && $classification['category_kind'] !== 'bundle') {
                $classification['type_code'] = $parentClassification['type_code'];
            }
        }

        if ($classification['category_kind'] === 'catalog') {
            if ($classification['room_code'] && !$classification['type_code']) {
                $classification['category_kind'] = 'room';
            } elseif ($classification['type_code'] && !$category->parent_id) {
                $classification['category_kind'] = 'product_family';
            }
        }

        return $cache[$category->id] = $classification;
    }

    protected function exactCategoryRules(): array
    {
        return [
            'lits' => ['room_code' => 'chambre_adulte', 'type_code' => 'lit'],
            'armoires' => ['room_code' => 'chambre_adulte', 'type_code' => 'armoire'],
            'bureaux' => ['room_code' => 'bureau', 'type_code' => 'bureau'],
            'meubles-d-assises' => ['room_code' => 'salon_sejour'],
            'cuisine' => ['room_code' => 'cuisine_rangement', 'category_kind' => 'room'],
            'jardin' => ['room_code' => 'exterieur_jardin', 'category_kind' => 'room'],

            'chambres-enfant-completes' => ['room_code' => 'chambre_enfant', 'category_kind' => 'bundle'],
            'chambres-junior-completes' => ['room_code' => 'chambre_enfant', 'category_kind' => 'bundle'],
            'salons-complets' => ['room_code' => 'salon_sejour', 'category_kind' => 'bundle'],
            'salles-a-manger-completes' => ['room_code' => 'salle_a_manger', 'category_kind' => 'bundle'],
            'cuisines-completes' => ['room_code' => 'cuisine_rangement', 'category_kind' => 'bundle'],
            'ensemble-salle-de-bains' => ['room_code' => 'salle_de_bain', 'category_kind' => 'bundle'],
            'ensembles-de-jardin' => ['room_code' => 'exterieur_jardin', 'category_kind' => 'bundle'],
            'ensembles-de-balcon' => ['room_code' => 'exterieur_jardin', 'category_kind' => 'bundle'],
            'table-et-chaises-enfant' => ['room_code' => 'chambre_enfant', 'category_kind' => 'bundle'],
            'blocs-cuisine-avec-appareils' => ['room_code' => 'cuisine_rangement', 'category_kind' => 'bundle'],
            'blocs-cuisine-sans-appareils' => ['room_code' => 'cuisine_rangement', 'category_kind' => 'bundle'],
            'vestiaires-complets' => ['room_code' => 'entree_rangement', 'category_kind' => 'bundle'],

            'garde-robes' => ['room_code' => 'chambre_adulte', 'type_code' => 'dressing'],
            'penderies-ouvertes' => ['room_code' => 'chambre_adulte', 'type_code' => 'dressing'],
            'armoires-de-bureau' => ['room_code' => 'bureau', 'type_code' => 'rangement_bureau'],
            'chaises-pour-bureaux' => ['room_code' => 'bureau', 'type_code' => 'chaise'],
            'armoires-de-couloir' => ['room_code' => 'entree_rangement', 'type_code' => 'meuble_entree'],
            'armoires-a-chaussures' => ['room_code' => 'entree_rangement', 'type_code' => 'porte_chaussures'],
            'etageres-a-chaussures' => ['room_code' => 'entree_rangement', 'type_code' => 'porte_chaussures'],
            'portants-vetements' => ['room_code' => 'entree_rangement', 'type_code' => 'penderie'],
            'porte-vetements-enfants' => ['room_code' => 'chambre_enfant', 'type_code' => 'penderie'],
            'portemanteaux-muraux' => ['room_code' => 'entree_rangement', 'type_code' => 'penderie'],
            'portemanteaux-sur-pied' => ['room_code' => 'entree_rangement', 'type_code' => 'penderie'],
            'porte-parapluies' => ['room_code' => 'entree_rangement', 'type_code' => 'meuble_entree'],
            'separateurs-de-piece' => ['room_code' => 'entree_rangement', 'type_code' => 'separation'],

            'meubles-bas' => ['room_code' => 'cuisine_rangement', 'type_code' => 'meuble_bas_cuisine'],
            'meubles-hauts' => ['room_code' => 'cuisine_rangement', 'type_code' => 'meuble_haut_cuisine'],
            'armoires-a-provisions' => ['room_code' => 'cuisine_rangement', 'type_code' => 'colonne_cuisine'],
            'armoires-pour-micro-ondes' => ['room_code' => 'cuisine_rangement', 'type_code' => 'colonne_cuisine'],
            'ilots-de-cuisine' => ['room_code' => 'cuisine_rangement'],
            'dessertes' => ['room_code' => 'cuisine_rangement'],
            'etageres-de-cuisine' => ['room_code' => 'cuisine_rangement', 'type_code' => 'etagere'],
            'chaises-de-cuisine' => ['room_code' => 'cuisine_rangement', 'type_code' => 'chaise'],

            'meubles-sous-evier' => ['room_code' => 'salle_de_bain', 'type_code' => 'meuble_sous_vasque'],
            'meubles-sous-lavabo-simple' => ['room_code' => 'salle_de_bain', 'type_code' => 'meuble_sous_vasque'],
            'meubles-sous-lavabo-double' => ['room_code' => 'salle_de_bain', 'type_code' => 'meuble_sous_vasque'],
            'meubles-vasque-simple' => ['room_code' => 'salle_de_bain', 'type_code' => 'meuble_sous_vasque'],
            'meubles-vasque-double' => ['room_code' => 'salle_de_bain', 'type_code' => 'meuble_sous_vasque'],
            'meubles-vasques-flottants' => ['room_code' => 'salle_de_bain', 'type_code' => 'meuble_sous_vasque'],
            'colonnes-salle-de-bains' => ['room_code' => 'salle_de_bain', 'type_code' => 'colonne_salle_de_bain'],
            'miroirs-salle-de-bains' => ['room_code' => 'salle_de_bain', 'type_code' => 'miroir'],
            'armoires-a-medicaments' => ['room_code' => 'salle_de_bain', 'type_code' => 'colonne_salle_de_bain'],
            'meubles-pour-toilettes' => ['room_code' => 'salle_de_bain'],

            'tables-de-balcon' => ['room_code' => 'exterieur_jardin', 'type_code' => 'table_de_jardin'],
            'chaises-de-balcon' => ['room_code' => 'exterieur_jardin', 'type_code' => 'chaise'],
            'tables-de-jardin-carrees' => ['room_code' => 'exterieur_jardin', 'type_code' => 'table_de_jardin'],
            'tables-de-jardin-ovales' => ['room_code' => 'exterieur_jardin', 'type_code' => 'table_de_jardin'],
            'tables-de-jardin-rondes' => ['room_code' => 'exterieur_jardin', 'type_code' => 'table_de_jardin'],
            'tables-basses-exterieur' => ['room_code' => 'exterieur_jardin', 'type_code' => 'table_de_jardin'],
            'tables-d-appoint-exterieur' => ['room_code' => 'exterieur_jardin', 'type_code' => 'table_de_jardin'],
            'tables-d-appoint-rondes-de-jardin' => ['room_code' => 'exterieur_jardin', 'type_code' => 'table_de_jardin'],
            'tables-d-appoint-carrees-pour-le-jardin' => ['room_code' => 'exterieur_jardin', 'type_code' => 'table_de_jardin'],
            'bains-de-soleil' => ['room_code' => 'exterieur_jardin', 'type_code' => 'salon_de_jardin'],
            'coffres-de-jardin' => ['room_code' => 'exterieur_jardin', 'type_code' => 'rangement_exterieur'],
            'barbecues' => ['room_code' => 'exterieur_jardin', 'type_code' => 'barbecue'],
            'braseros' => ['room_code' => 'exterieur_jardin', 'type_code' => 'barbecue'],
            'bols-de-feu' => ['room_code' => 'exterieur_jardin', 'type_code' => 'barbecue'],
            'cheminees-d-exterieur' => ['room_code' => 'exterieur_jardin', 'type_code' => 'barbecue'],
        ];
    }

    protected function inferFromSlug(string $slug): array
    {
        $classification = [
            'room_code' => null,
            'type_code' => null,
            'category_kind' => null,
            'is_indexable' => true,
        ];

        $slug = Str::of($slug)->lower()->value();
        $isLighting = Str::contains($slug, [
            'lampes',
            'plafonniers',
            'suspensions',
            'ampoules',
            'veilleuses',
            'liseuses',
            'lampadaires',
            'appliques-murales',
        ]);
        $isBedAccessory = in_array($slug, [
            'accessoires-lits',
            'matelas',
            'matelas-enfant',
            'matelas-simples',
            'matelas-doubles',
            'oreillers',
            'sommiers',
            'surmatelas',
            'couettes',
            'couettes-doubles',
            'draps-housses',
            'protege-matelas',
            'barrieres-de-lit',
            'tiroirs-de-lit',
            'tunnels-de-lit',
            'ponts-de-lit',
            'tentes-de-lit',
            'sacs-de-rangement',
        ], true);

        if (
            Str::contains($slug, ['completes', 'complets', 'ensemble-'])
            || in_array($slug, ['ensembles-de-jardin', 'ensembles-de-balcon', 'table-et-chaises-enfant'], true)
        ) {
            $classification['category_kind'] = 'bundle';
        }

        if (!$isBedAccessory && Str::contains($slug, ['superposes', 'mezzanines'])) {
            $classification['room_code'] ??= 'chambre_enfant';
            $classification['type_code'] = 'lit_superpose';
        } elseif (!$isBedAccessory && Str::contains($slug, 'gigognes')) {
            $classification['room_code'] ??= 'chambre_enfant';
            $classification['type_code'] = 'lit_gigogne';
        } elseif (!$isBedAccessory && Str::contains($slug, ['lit', 'lits-'])) {
            $classification['type_code'] ??= 'lit';
        }

        if (Str::contains($slug, ['enfant', 'junior', 'tipi', 'princesse', 'maison'])) {
            $classification['room_code'] ??= 'chambre_enfant';
        }

        if (!$isLighting && Str::contains($slug, ['chevet'])) {
            $classification['room_code'] ??= 'chambre_adulte';
            $classification['type_code'] = 'table_de_nuit';
        }

        if (Str::contains($slug, ['coiffeuse'])) {
            $classification['room_code'] ??= 'chambre_adulte';
            $classification['type_code'] = 'coiffeuse';
        }

        if (Str::contains($slug, ['commode'])) {
            $classification['room_code'] ??= $classification['room_code'] ?: 'chambre_adulte';
            $classification['type_code'] = 'commode';
        }

        if (Str::contains($slug, ['garde-robe', 'dressing'])) {
            $classification['room_code'] ??= 'chambre_adulte';
            $classification['type_code'] = 'dressing';
        } elseif (Str::contains($slug, ['penderie', 'portants-vetements', 'portemanteaux', 'vestiaire'])) {
            $classification['room_code'] ??= 'entree_rangement';
            $classification['type_code'] = 'penderie';
        } elseif (Str::contains($slug, ['armoires', 'armoire'])) {
            $classification['type_code'] ??= 'armoire';
            $classification['room_code'] ??= 'chambre_adulte';
        }

        if (
            !$isLighting
            && (Str::startsWith($slug, 'bureaux') || in_array($slug, ['tables-de-bureau', 'tables-ordinateur-portable', 'tables-a-dessin'], true))
        ) {
            $classification['room_code'] ??= 'bureau';
            $classification['type_code'] ??= 'bureau';
        } elseif (Str::contains($slug, ['bureau'])) {
            $classification['room_code'] ??= 'bureau';
        }

        if (Str::contains($slug, ['canape'])) {
            $classification['room_code'] ??= 'salon_sejour';
            $classification['type_code'] = 'canape';
        }

        if (Str::contains($slug, ['fauteuil'])) {
            $classification['room_code'] ??= 'salon_sejour';
            $classification['type_code'] = 'fauteuil';
        }

        if (Str::contains($slug, ['salontafels', 'tables-basses', 'table-basse'])) {
            $classification['room_code'] ??= 'salon_sejour';
            $classification['type_code'] = 'table_basse';
        }

        if (Str::contains($slug, ['meubles-tv', 'unites-murales-tv'])) {
            $classification['room_code'] ??= 'salon_sejour';
            $classification['type_code'] = 'meuble_tv';
        }

        if (Str::contains($slug, ['bibliothe'])) {
            $classification['room_code'] ??= 'salon_sejour';
            $classification['type_code'] = 'bibliotheque';
        } elseif (Str::contains($slug, ['etagere', 'tablettes-murales'])) {
            $classification['room_code'] ??= $classification['room_code'] ?: 'salon_sejour';
            $classification['type_code'] ??= 'etagere';
        }

        if (Str::contains($slug, ['buffet'])) {
            $classification['room_code'] ??= 'salle_a_manger';
            $classification['type_code'] = 'buffet';
        }

        if (Str::contains($slug, ['bahut'])) {
            $classification['room_code'] ??= 'salle_a_manger';
            $classification['type_code'] = 'bahut';
        }

        if (Str::contains($slug, ['vaisselier'])) {
            $classification['room_code'] ??= 'salle_a_manger';
            $classification['type_code'] = 'vaisselier';
        }

        if (Str::contains($slug, ['tables-a-manger', 'tables a manger'])) {
            $classification['room_code'] ??= 'salle_a_manger';
            $classification['type_code'] = 'table_a_manger';
        }

        if (Str::contains($slug, ['tabourets'])) {
            $classification['room_code'] ??= 'salle_a_manger';
            $classification['type_code'] = 'tabouret_haut';
        } elseif (Str::contains($slug, ['tables-de-bar', 'meubles-de-bar'])) {
            $classification['room_code'] ??= 'salle_a_manger';
            $classification['type_code'] = 'bar';
        } elseif (Str::contains($slug, ['chaises'])) {
            $classification['room_code'] ??= $classification['room_code'] ?: 'salle_a_manger';
            $classification['type_code'] ??= 'chaise';
        } elseif (Str::contains($slug, ['bancs'])) {
            $classification['room_code'] ??= $classification['room_code'] ?: 'salle_a_manger';
            $classification['type_code'] ??= 'banc';
        }

        if (
            Str::contains($slug, ['cuisine', 'kitchenette', 'ilots-de-cuisine', 'micro-ondes', 'provisions'])
            || in_array($slug, ['meubles-bas', 'meubles-hauts'], true)
        ) {
            $classification['room_code'] ??= 'cuisine_rangement';
        }

        if (Str::contains($slug, ['meubles-bas'])) {
            $classification['type_code'] = 'meuble_bas_cuisine';
        } elseif (Str::contains($slug, ['meubles-hauts'])) {
            $classification['type_code'] = 'meuble_haut_cuisine';
        } elseif (Str::contains($slug, ['colonne', 'colonnes'])) {
            $classification['type_code'] ??= $classification['room_code'] === 'salle_de_bain'
                ? 'colonne_salle_de_bain'
                : 'colonne_cuisine';
        } elseif (Str::contains($slug, ['plan-de-travail', 'plans-de-travail'])) {
            $classification['type_code'] = 'plan_de_travail';
        }

        if (Str::contains($slug, ['chaussures', 'couloir', 'entree', 'consoles', 'porte-parapluies'])) {
            $classification['room_code'] ??= 'entree_rangement';
        }

        if (Str::contains($slug, ['chaussures'])) {
            $classification['type_code'] = 'porte_chaussures';
        } elseif (Str::contains($slug, ['consoles'])) {
            $classification['type_code'] = 'console';
        } elseif (Str::contains($slug, ['separateurs', 'cloisons'])) {
            $classification['type_code'] = 'separation';
        } elseif (Str::contains($slug, ['porte-parapluies'])) {
            $classification['type_code'] = 'meuble_entree';
        }

        if (
            Str::contains($slug, ['salle-de-bains', 'salle-de-bain', 'lavabo', 'vasque', 'evier', 'toilettes', 'medicaments'])
            || in_array($slug, ['meubles-sous-evier', 'meubles-pour-toilettes'], true)
        ) {
            $classification['room_code'] ??= 'salle_de_bain';
        }

        if (Str::contains($slug, ['vasque', 'lavabo', 'evier'])) {
            $classification['type_code'] = 'meuble_sous_vasque';
        } elseif (Str::contains($slug, ['miroirs'])) {
            $classification['type_code'] ??= 'miroir';
        }

        if (
            Str::contains($slug, ['jardin', 'balcon', 'parasol', 'barbecue', 'brasero', 'cheminees-d-exterieur', 'buches', 'bains-de-soleil', 'mobilier-jardin'])
            || in_array($slug, ['barbecues', 'braseros', 'bols-de-feu', 'coffres-de-jardin'], true)
        ) {
            $classification['room_code'] ??= 'exterieur_jardin';
        }

        if (Str::contains($slug, ['tables-de-jardin', 'tables-de-balcon'])) {
            $classification['type_code'] = 'table_de_jardin';
        } elseif (Str::contains($slug, ['salons-de-jardin', 'ensembles-de-jardin', 'ensembles-de-balcon', 'bains-de-soleil'])) {
            $classification['type_code'] = 'salon_de_jardin';
        } elseif (Str::contains($slug, ['parasol'])) {
            $classification['type_code'] = 'parasol';
        } elseif (Str::contains($slug, ['barbecue', 'brasero', 'cheminees-d-exterieur', 'bols-de-feu'])) {
            $classification['type_code'] = 'barbecue';
        } elseif (Str::contains($slug, ['coffres-de-jardin'])) {
            $classification['type_code'] = 'rangement_exterieur';
        }

        if (
            $isLighting
            || Str::contains($slug, [
                'deconoel',
                'bougies',
                'cadres-photo',
                'vases',
                'verres',
                'assiettes',
                'plats-a-servir',
                'objets-',
            ])
        ) {
            $classification['is_indexable'] = false;
        }

        return $classification;
    }

    protected function applyClassification(array $base, array $patch): array
    {
        foreach (['room_code', 'type_code', 'category_kind', 'is_indexable'] as $key) {
            if (array_key_exists($key, $patch) && $patch[$key] !== null && $patch[$key] !== '') {
                $base[$key] = $patch[$key];
            }
        }

        return $base;
    }
}
