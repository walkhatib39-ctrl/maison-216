<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ShowroomActivity;
use Illuminate\Database\Seeder;

class ShowroomBeautyProductSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(ShowroomActivitySeeder::class);

        $activities = ShowroomActivity::whereIn('slug', $this->activitySlugs())
            ->get()
            ->keyBy('slug');

        foreach ($this->products() as $index => $item) {
            $quoteOnly = $item['type'] !== 'commandable';

            $product = Product::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'category_id' => null,
                    'room_id' => null,
                    'product_type_id' => null,
                    'primary_collection_id' => null,
                    'title' => $item['title'],
                    'price_millimes' => $this->price($item['price'] ?? null),
                    'compare_at_millimes' => $this->price($item['compare_at'] ?? null),
                    'stock' => $quoteOnly ? 0 : 10,
                    'sku' => null,
                    'brand' => null,
                    'sale_mode' => $quoteOnly ? 'sur_mesure' : 'catalog',
                    'quote_only' => $quoteOnly,
                    'is_starting_price' => (bool) ($item['starting_price'] ?? false),
                    'is_customizable' => $quoteOnly || !empty($item['options']),
                    'showroom_badge' => $item['badge'],
                    'main_image' => null,
                    'material_summary' => $item['materials'],
                    'dimension_summary' => $item['dimensions'],
                    'availability_label' => $item['availability'],
                    'delivery_note' => $item['delivery'],
                    'finish_summary' => $item['finishes'],
                    'short_description' => $item['short_description'],
                    'long_description' => $item['long_description'],
                    'attributes' => null,
                    'custom_options' => $item['options'],
                    'is_active' => true,
                ]
            );

            $payload = [];
            foreach ($item['activities'] as $activitySlug) {
                if (!$activities->has($activitySlug)) {
                    continue;
                }

                $payload[$activities[$activitySlug]->id] = [
                    'sort_order' => $activitySlug === 'salons-beaute-esthetique' ? $index + 1 : 1000 + $index,
                ];
            }

            $product->showroomActivities()->sync($payload);
            $product->images()->delete();
        }
    }

    private function price(?int $dinars): ?int
    {
        return $dinars === null ? null : $dinars * 1000;
    }

    /**
     * @return array<int, string>
     */
    private function activitySlugs(): array
    {
        return [
            'salons-beaute-esthetique',
            'pharmacies-parapharmacies',
            'boutiques-magasins',
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function products(): array
    {
        return [
            [
                'title' => 'Comptoir accueil salon de beauté',
                'slug' => 'comptoir-accueil-salon-beaute',
                'type' => 'quote',
                'badge' => 'Sur mesure, Pro, Premium',
                'price' => null,
                'compare_at' => null,
                'starting_price' => false,
                'availability' => 'Sur commande',
                'delivery' => 'Livraison et pose sur devis',
                'activities' => ['salons-beaute-esthetique'],
                'materials' => 'MDF, bois, métal, aluminium, LED optionnel',
                'dimensions' => 'Sur mesure',
                'finishes' => 'Blanc, beige, rose poudré, bois clair, noir mat, RAL au choix',
                'short_description' => 'Comptoir d’accueil sur mesure pour salon de beauté, institut esthétique, coiffure ou espace onglerie.',
                'long_description' => 'Ce comptoir d’accueil est conçu pour donner une première impression professionnelle dès l’entrée du salon. Il peut intégrer une zone caisse, des rangements, un espace ordinateur, un logo en façade, un éclairage LED et une finition adaptée à l’identité du salon. Il convient aux salons de beauté, instituts esthétiques, salons de coiffure, espaces onglerie, maquillage ou soins.',
                'options' => [
                    'Dimensions' => ['Sur mesure'],
                    'Usage' => ['Accueil', 'Caisse', 'Réservation', 'Conseil client'],
                    'Options' => ['Logo en façade', 'Logo lumineux', 'LED', 'Tiroirs', 'Rangements', 'Passe-câbles', 'Espace ordinateur'],
                    'Finitions' => ['Blanc', 'Beige', 'Rose poudré', 'Bois clair', 'Noir mat', 'RAL au choix'],
                ],
            ],
            [
                'title' => 'Comptoir compact institut beauté',
                'slug' => 'comptoir-compact-institut-beaute',
                'type' => 'commandable',
                'badge' => 'Standard, Pro',
                'price' => 950,
                'compare_at' => 1150,
                'starting_price' => false,
                'availability' => 'Sur commande',
                'delivery' => 'Grand Tunis, pose sur devis',
                'activities' => ['salons-beaute-esthetique'],
                'materials' => 'MDF, bois mélaminé, métal',
                'dimensions' => '120 x 55 x 105 cm',
                'finishes' => 'Blanc, bois clair, beige, noir mat',
                'short_description' => 'Comptoir compact pour petit salon de beauté, onglerie, maquillage ou institut esthétique.',
                'long_description' => 'Ce comptoir compact est adapté aux petits espaces beauté qui ont besoin d’un accueil propre sans lancer un projet complet sur mesure. Il peut servir de zone caisse, réception, rangement léger et point de contact client.',
                'options' => [
                    'Dimensions' => ['120 x 55 x 105 cm'],
                    'Finitions' => ['Blanc', 'Bois clair', 'Beige', 'Noir mat'],
                    'Options' => ['Rangement intérieur', 'Passe-câbles', 'Tiroir caisse', 'Façade personnalisable'],
                ],
            ],
            [
                'title' => 'Poste coiffure mural avec miroir',
                'slug' => 'poste-coiffure-mural-miroir',
                'type' => 'commandable',
                'badge' => 'Standard, Pro',
                'price' => 680,
                'compare_at' => 790,
                'starting_price' => false,
                'availability' => 'Sur commande',
                'delivery' => 'Grand Tunis, pose sur devis',
                'activities' => ['salons-beaute-esthetique'],
                'materials' => 'MDF, bois, miroir, métal optionnel',
                'dimensions' => '90 x 25 x 180 cm',
                'finishes' => 'Blanc, bois clair, noir mat, doré optionnel',
                'short_description' => 'Poste mural avec miroir pour salon de coiffure, brushing, coloration ou espace beauté.',
                'long_description' => 'Ce poste coiffure mural permet d’équiper un salon avec une zone de travail propre et élégante. Il peut intégrer un miroir, une tablette, un petit rangement et une finition adaptée à l’ambiance du salon.',
                'options' => [
                    'Dimensions' => ['80 cm', '90 cm', '100 cm'],
                    'Finitions' => ['Blanc', 'Bois clair', 'Noir mat', 'Doré optionnel'],
                    'Options' => ['Tablette', 'Petit tiroir', 'Éclairage miroir', 'Support sèche-cheveux'],
                ],
            ],
            [
                'title' => 'Double poste coiffure mural',
                'slug' => 'double-poste-coiffure-mural',
                'type' => 'quote',
                'badge' => 'Sur mesure, Pro',
                'price' => null,
                'compare_at' => null,
                'starting_price' => false,
                'availability' => 'Sur commande',
                'delivery' => 'Livraison et pose sur devis',
                'activities' => ['salons-beaute-esthetique'],
                'materials' => 'MDF, bois, miroir, métal, LED optionnel',
                'dimensions' => 'Sur mesure',
                'finishes' => 'Blanc, bois clair, noir, doré, RAL au choix',
                'short_description' => 'Double poste coiffure sur mesure pour optimiser deux zones de travail sur un même mur.',
                'long_description' => 'Ce double poste coiffure est pensé pour les salons qui veulent structurer plusieurs postes de travail avec une identité homogène. Il peut intégrer deux miroirs, tablettes, rangements, éclairage, supports accessoires et finitions coordonnées.',
                'options' => [
                    'Dimensions' => ['Sur mesure'],
                    'Nombre de postes' => ['2 postes', '3 postes', '4 postes'],
                    'Options' => ['Miroirs', 'LED', 'Tablettes', 'Tiroirs', 'Supports accessoires', 'Prises intégrées sur devis'],
                    'Finitions' => ['Blanc', 'Bois clair', 'Noir', 'Doré', 'RAL au choix'],
                ],
            ],
            [
                'title' => 'Table manucure compacte',
                'slug' => 'table-manucure-compacte',
                'type' => 'commandable',
                'badge' => 'Standard, Onglerie',
                'price' => 520,
                'compare_at' => 620,
                'starting_price' => false,
                'availability' => 'Sur commande',
                'delivery' => 'Grand Tunis',
                'activities' => ['salons-beaute-esthetique'],
                'materials' => 'MDF, bois mélaminé, métal',
                'dimensions' => '100 x 45 x 75 cm',
                'finishes' => 'Blanc, rose poudré, bois clair, noir',
                'short_description' => 'Table compacte pour manucure, pose vernis semi-permanent, gel ou soins des mains.',
                'long_description' => 'Cette table manucure est conçue pour les espaces onglerie et petits salons de beauté. Elle offre une surface de travail confortable avec des rangements simples pour produits, accessoires et outils de pose.',
                'options' => [
                    'Dimensions' => ['100 x 45 x 75 cm', '120 x 50 x 75 cm'],
                    'Finitions' => ['Blanc', 'Rose poudré', 'Bois clair', 'Noir'],
                    'Options' => ['Tiroirs', 'Étagère latérale', 'Passe-câbles', 'Support lampe'],
                ],
            ],
            [
                'title' => 'Table manucure premium avec rangement',
                'slug' => 'table-manucure-premium-rangement',
                'type' => 'quote',
                'badge' => 'Premium, Sur mesure, Onglerie',
                'price' => null,
                'compare_at' => null,
                'starting_price' => false,
                'availability' => 'Sur commande',
                'delivery' => 'Livraison et pose sur devis',
                'activities' => ['salons-beaute-esthetique'],
                'materials' => 'MDF laqué, bois, métal, verre optionnel',
                'dimensions' => 'Sur mesure',
                'finishes' => 'Blanc premium, beige, rose poudré, noir mat, RAL au choix',
                'short_description' => 'Table manucure sur mesure avec rangements, espace produits et finition premium.',
                'long_description' => 'Cette table est destinée aux espaces onglerie qui veulent une zone de travail plus professionnelle et plus esthétique. Elle peut intégrer plusieurs tiroirs, rangements latéraux, espace lampe, zone produits, passe-câbles et finition alignée avec l’identité du salon.',
                'options' => [
                    'Dimensions' => ['Sur mesure'],
                    'Options' => ['Tiroirs', 'Rangements latéraux', 'Support lampe', 'Passe-câbles', 'Présentoir vernis intégré', 'Logo'],
                    'Finitions' => ['Blanc premium', 'Beige', 'Rose poudré', 'Noir mat', 'RAL au choix'],
                ],
            ],
            [
                'title' => 'Présentoir vernis mural',
                'slug' => 'presentoir-vernis-mural',
                'type' => 'commandable',
                'badge' => 'Standard, Onglerie',
                'price' => 240,
                'compare_at' => 290,
                'starting_price' => false,
                'availability' => 'En stock, sur commande',
                'delivery' => 'Grand Tunis',
                'activities' => ['salons-beaute-esthetique'],
                'materials' => 'MDF, bois mélaminé, plexi optionnel',
                'dimensions' => '80 x 8 x 90 cm',
                'finishes' => 'Blanc, noir, bois clair, rose poudré',
                'short_description' => 'Présentoir mural pour exposer vernis, gels, couleurs, soins ongles et petits accessoires.',
                'long_description' => 'Ce présentoir mural permet de montrer clairement les couleurs et produits d’onglerie. Il est utile dans les espaces manucure, salons de beauté, instituts esthétiques et coins nail bar.',
                'options' => [
                    'Dimensions' => ['60 cm', '80 cm', '100 cm'],
                    'Finitions' => ['Blanc', 'Noir', 'Bois clair', 'Rose poudré'],
                    'Options' => ['Niveaux supplémentaires', 'Bandeau logo', 'Protection plexi'],
                ],
            ],
            [
                'title' => 'Meuble produits cosmétiques',
                'slug' => 'meuble-produits-cosmetiques-salon',
                'type' => 'commandable',
                'badge' => 'Standard, Pro',
                'price' => 690,
                'compare_at' => 820,
                'starting_price' => false,
                'availability' => 'Sur commande',
                'delivery' => 'Grand Tunis, pose sur devis',
                'activities' => ['salons-beaute-esthetique', 'pharmacies-parapharmacies'],
                'materials' => 'MDF, bois mélaminé, métal optionnel',
                'dimensions' => '90 x 35 x 180 cm',
                'finishes' => 'Blanc, bois clair, noir, beige',
                'short_description' => 'Meuble vertical pour exposer produits capillaires, soins visage, cosmétiques ou produits revente.',
                'long_description' => 'Ce meuble permet au salon de présenter les produits utilisés ou vendus aux clientes : soins capillaires, shampoings, crèmes, sérums, produits visage, accessoires ou cosmétiques. Il aide à structurer la zone de vente additionnelle.',
                'options' => [
                    'Dimensions' => ['90 x 35 x 180 cm', '120 x 35 x 200 cm'],
                    'Finitions' => ['Blanc', 'Bois clair', 'Noir', 'Beige'],
                    'Options' => ['Étagères réglables', 'Bandeau marque', 'LED', 'Portes basses'],
                ],
            ],
            [
                'title' => 'Meuble rangement coiffure',
                'slug' => 'meuble-rangement-coiffure',
                'type' => 'commandable',
                'badge' => 'Standard, Pro',
                'price' => 580,
                'compare_at' => 690,
                'starting_price' => false,
                'availability' => 'Sur commande',
                'delivery' => 'Grand Tunis',
                'activities' => ['salons-beaute-esthetique'],
                'materials' => 'MDF, bois mélaminé, quincaillerie métal',
                'dimensions' => '80 x 45 x 180 cm',
                'finishes' => 'Blanc, bois clair, noir, gris',
                'short_description' => 'Meuble de rangement pour serviettes, produits, appareils coiffure et accessoires de salon.',
                'long_description' => 'Ce meuble permet d’organiser les produits et accessoires utilisés au quotidien dans un salon de coiffure ou un institut beauté. Il peut servir au rangement des serviettes, brosses, produits capillaires, petits appareils et consommables.',
                'options' => [
                    'Dimensions' => ['80 x 45 x 180 cm', '100 x 45 x 200 cm'],
                    'Finitions' => ['Blanc', 'Bois clair', 'Noir', 'Gris'],
                    'Options' => ['Portes', 'Tiroirs', 'Étagères ouvertes', 'Serrure'],
                ],
            ],
            [
                'title' => 'Chariot beauté bois/métal',
                'slug' => 'chariot-beaute-bois-metal',
                'type' => 'commandable',
                'badge' => 'Standard, Mobile',
                'price' => 260,
                'compare_at' => 320,
                'starting_price' => false,
                'availability' => 'En stock, sur commande',
                'delivery' => 'Grand Tunis',
                'activities' => ['salons-beaute-esthetique'],
                'materials' => 'MDF, bois, métal, roulettes',
                'dimensions' => '45 x 35 x 80 cm',
                'finishes' => 'Blanc, noir, bois clair',
                'short_description' => 'Chariot mobile pour produits, accessoires, soins visage, coiffure, maquillage ou onglerie.',
                'long_description' => 'Ce chariot permet de garder les accessoires et produits à portée de main pendant les prestations. Il convient aux soins visage, maquillage, coiffure, onglerie, cils ou microblading.',
                'options' => [
                    'Dimensions' => ['45 x 35 x 80 cm'],
                    'Finitions' => ['Blanc', 'Noir', 'Bois clair'],
                    'Options' => ['3 niveaux', 'Tiroir', 'Roulettes freinées', 'Poignée latérale'],
                ],
            ],
            [
                'title' => 'Meuble maquillage avec miroir',
                'slug' => 'meuble-maquillage-miroir',
                'type' => 'quote',
                'badge' => 'Sur mesure, Maquillage, Premium',
                'price' => null,
                'compare_at' => null,
                'starting_price' => false,
                'availability' => 'Sur commande',
                'delivery' => 'Livraison et pose sur devis',
                'activities' => ['salons-beaute-esthetique'],
                'materials' => 'MDF, bois, miroir, LED, métal optionnel',
                'dimensions' => 'Sur mesure',
                'finishes' => 'Blanc, beige, noir, rose poudré, doré, RAL au choix',
                'short_description' => 'Meuble maquillage sur mesure avec miroir, lumière et rangement pour produits make-up.',
                'long_description' => 'Ce meuble est pensé pour les espaces maquillage, forfaits mariée, make-up professionnel ou corners beauté. Il peut intégrer un grand miroir, un éclairage adapté, des tiroirs, des rangements produits et une finition premium.',
                'options' => [
                    'Dimensions' => ['Sur mesure'],
                    'Options' => ['Miroir lumineux', 'LED périphérique', 'Tiroirs', 'Rangement pinceaux', 'Présentoir produits', 'Plan de travail renforcé'],
                    'Finitions' => ['Blanc', 'Beige', 'Noir', 'Rose poudré', 'Doré', 'RAL au choix'],
                ],
            ],
            [
                'title' => 'Meuble microblading / cils',
                'slug' => 'meuble-microblading-cils',
                'type' => 'commandable',
                'badge' => 'Standard, Esthétique',
                'price' => 480,
                'compare_at' => 580,
                'starting_price' => false,
                'availability' => 'Sur commande',
                'delivery' => 'Grand Tunis',
                'activities' => ['salons-beaute-esthetique'],
                'materials' => 'MDF, bois mélaminé, métal',
                'dimensions' => '80 x 45 x 90 cm',
                'finishes' => 'Blanc, beige, noir, bois clair',
                'short_description' => 'Meuble de travail compact pour microblading, extensions de cils, brow lift ou soins ciblés.',
                'long_description' => 'Ce meuble est conçu pour organiser les outils et consommables des prestations précises : microblading, cils, sourcils, brow lift ou soins du regard. Il peut être utilisé près d’un fauteuil, d’un lit de soin ou d’une zone esthétique.',
                'options' => [
                    'Dimensions' => ['80 x 45 x 90 cm', '100 x 45 x 90 cm'],
                    'Finitions' => ['Blanc', 'Beige', 'Noir', 'Bois clair'],
                    'Options' => ['Tiroirs', 'Rangement consommables', 'Plateau supérieur', 'Roulettes'],
                ],
            ],
            [
                'title' => 'Armoire serviettes et consommables',
                'slug' => 'armoire-serviettes-consommables-salon',
                'type' => 'commandable',
                'badge' => 'Standard, Pro',
                'price' => 640,
                'compare_at' => 760,
                'starting_price' => false,
                'availability' => 'Sur commande',
                'delivery' => 'Grand Tunis',
                'activities' => ['salons-beaute-esthetique'],
                'materials' => 'MDF, bois mélaminé',
                'dimensions' => '100 x 45 x 200 cm',
                'finishes' => 'Blanc, gris, bois clair, beige',
                'short_description' => 'Armoire de stockage pour serviettes, produits, consommables et accessoires professionnels.',
                'long_description' => 'Cette armoire permet d’organiser les consommables utilisés dans un salon ou institut : serviettes, produits, accessoires, linge, petits outils et réserves. Elle convient aux zones arrière, cabines et espaces techniques.',
                'options' => [
                    'Dimensions' => ['100 x 45 x 200 cm', '120 x 45 x 220 cm'],
                    'Finitions' => ['Blanc', 'Gris', 'Bois clair', 'Beige'],
                    'Options' => ['Portes', 'Étagères réglables', 'Serrure', 'Tiroirs bas'],
                ],
            ],
            [
                'title' => 'Habillage mural salon avec logo',
                'slug' => 'habillage-mural-salon-beaute-logo',
                'type' => 'quote',
                'badge' => 'Sur mesure, Premium, Déco',
                'price' => null,
                'compare_at' => null,
                'starting_price' => false,
                'availability' => 'Sur commande',
                'delivery' => 'Livraison et pose sur devis',
                'activities' => ['salons-beaute-esthetique'],
                'materials' => 'MDF, bois, métal, aluminium, LED',
                'dimensions' => 'Sur mesure',
                'finishes' => 'Blanc, beige, rose poudré, noir, bois naturel, RAL au choix',
                'short_description' => 'Habillage mural décoratif avec logo pour renforcer l’identité d’un salon de beauté ou institut.',
                'long_description' => 'L’habillage mural transforme un espace simple en zone de marque professionnelle. Il peut être placé derrière l’accueil, dans une zone photo, un coin maquillage ou une zone de vente produits. Il peut intégrer logo, relief, éclairage, panneaux décoratifs et niches produits.',
                'options' => [
                    'Dimensions' => ['Sur mesure'],
                    'Options' => ['Logo découpé', 'Logo lumineux', 'LED indirecte', 'Niches produits', 'Panneaux décoratifs', 'Relief 3D'],
                    'Finitions' => ['Blanc', 'Beige', 'Rose poudré', 'Noir', 'Bois naturel', 'RAL au choix'],
                ],
            ],
            [
                'title' => 'Séparation cabine esthétique',
                'slug' => 'separation-cabine-esthetique',
                'type' => 'quote',
                'badge' => 'Sur mesure, Cabine, Pro',
                'price' => null,
                'compare_at' => null,
                'starting_price' => false,
                'availability' => 'Sur commande',
                'delivery' => 'Livraison et pose sur devis',
                'activities' => ['salons-beaute-esthetique'],
                'materials' => 'Bois, MDF, métal, aluminium, panneaux décoratifs',
                'dimensions' => 'Sur mesure',
                'finishes' => 'Blanc, beige, bois clair, noir, RAL au choix',
                'short_description' => 'Séparation sur mesure pour créer une cabine soin, épilation, massage ou esthétique dans un salon.',
                'long_description' => 'Cette séparation permet d’aménager une cabine ou une zone semi-fermée dans un institut esthétique, salon de beauté ou espace bien-être. Elle peut être utilisée pour les soins visage, épilation, massage, cils, microblading ou prestations nécessitant plus d’intimité.',
                'options' => [
                    'Dimensions' => ['Sur mesure'],
                    'Usage' => ['Cabine soin', 'Épilation', 'Massage', 'Cils', 'Microblading', 'Zone privée'],
                    'Options' => ['Porte', 'Claustra', 'Panneaux pleins', 'Partie vitrée', 'Rangement intégré'],
                    'Finitions' => ['Blanc', 'Beige', 'Bois clair', 'Noir', 'RAL au choix'],
                ],
            ],
            [
                'title' => 'Claustra décoratif salon beauté',
                'slug' => 'claustra-decoratif-salon-beaute',
                'type' => 'commandable',
                'badge' => 'Standard, Déco',
                'price' => 480,
                'compare_at' => 590,
                'starting_price' => false,
                'availability' => 'Sur commande',
                'delivery' => 'Grand Tunis, pose sur devis',
                'activities' => ['salons-beaute-esthetique'],
                'materials' => 'Bois, MDF, métal',
                'dimensions' => '100 x 220 cm',
                'finishes' => 'Bois naturel, blanc, noir, beige',
                'short_description' => 'Claustra décoratif pour séparer une zone coiffure, onglerie, attente ou esthétique.',
                'long_description' => 'Ce claustra permet de structurer un salon sans fermer complètement l’espace. Il peut servir à séparer un coin attente, un poste beauté, une zone onglerie ou une partie plus intime.',
                'options' => [
                    'Dimensions' => ['100 x 220 cm', '120 x 220 cm'],
                    'Motifs' => ['Lignes verticales', 'Géométrique', 'Minimaliste'],
                    'Finitions' => ['Bois naturel', 'Blanc', 'Noir', 'Beige'],
                    'Options' => ['Structure métal', 'Fixation sol/plafond'],
                ],
            ],
            [
                'title' => 'Banc attente salon beauté',
                'slug' => 'banc-attente-salon-beaute',
                'type' => 'commandable',
                'badge' => 'Standard, Accueil',
                'price' => 420,
                'compare_at' => 520,
                'starting_price' => false,
                'availability' => 'Sur commande',
                'delivery' => 'Grand Tunis',
                'activities' => ['salons-beaute-esthetique'],
                'materials' => 'Bois, MDF, métal, assise optionnelle',
                'dimensions' => '120 x 45 x 45 cm',
                'finishes' => 'Bois clair, blanc, beige, noir',
                'short_description' => 'Banc d’attente compact pour salon de beauté, coiffure, onglerie ou institut esthétique.',
                'long_description' => 'Ce banc permet de créer une zone d’attente simple et propre dans un salon. Il peut être placé près de l’accueil, dans une entrée ou à côté d’un poste de travail.',
                'options' => [
                    'Dimensions' => ['100 cm', '120 cm', '150 cm'],
                    'Finitions' => ['Bois clair', 'Blanc', 'Beige', 'Noir'],
                    'Options' => ['Assise rembourrée', 'Rangement sous assise', 'Structure métal'],
                ],
            ],
            [
                'title' => 'Présentoir accessoires cheveux',
                'slug' => 'presentoir-accessoires-cheveux',
                'type' => 'commandable',
                'badge' => 'Standard, Retail',
                'price' => 320,
                'compare_at' => 390,
                'starting_price' => false,
                'availability' => 'En stock, sur commande',
                'delivery' => 'Grand Tunis',
                'activities' => ['salons-beaute-esthetique', 'boutiques-magasins'],
                'materials' => 'MDF, bois, métal, crochets',
                'dimensions' => '80 x 30 x 160 cm',
                'finishes' => 'Blanc, bois clair, noir',
                'short_description' => 'Présentoir pour accessoires cheveux, brosses, peignes, pinces, bandeaux et produits légers.',
                'long_description' => 'Ce présentoir est utile pour les salons qui vendent aussi des accessoires ou produits complémentaires. Il permet de créer une petite zone retail sans encombrer l’espace de travail.',
                'options' => [
                    'Dimensions' => ['80 x 30 x 160 cm', '100 x 35 x 180 cm'],
                    'Finitions' => ['Blanc', 'Bois clair', 'Noir'],
                    'Options' => ['Crochets', 'Étagères', 'Bandeau logo', 'Roulettes'],
                ],
            ],
        ];
    }
}
