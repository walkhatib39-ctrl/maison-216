<?php

namespace App\Support;

use App\Models\Realization;
use App\Models\Setting;
use App\Models\SitePage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class SitePageSyncer
{
    public function __construct(
        private readonly SiteStructure $structure,
        private readonly SitePageSeoDefaults $seoDefaults,
    )
    {
    }

    public function sync(): array
    {
        $pages = $this->syncablePages();
        $seenPaths = $pages->pluck('path')->all();
        $created = 0;
        $updated = 0;

        $pages->each(function (array $page, int $index) use (&$created, &$updated): void {
            $path = trim((string) $page['path'], '/');
            $existing = SitePage::query()->where('path', $path)->first();

            $attributes = [
                'silo' => (string) ($page['silo'] ?? (Str::before($path, '/') ?: 'site')),
                'parent_path' => $this->parentPath($path),
                'page_type' => (string) ($page['type'] ?? 'quote'),
                'public_title' => (string) ($page['title'] ?? $path),
                'description_snapshot' => (string) ($page['description'] ?? ''),
                'sort_order' => $index + 1,
                'is_obsolete' => false,
            ];
            $seoDefaults = $this->seoDefaults->forPath($path, $page);

            if (!$existing) {
                SitePage::query()->create(array_merge($attributes, [
                    'path' => $path,
                    'admin_title' => (string) ($page['title'] ?? $path),
                    'meta_title' => $seoDefaults['meta_title'],
                    'meta_description' => $seoDefaults['meta_description'],
                    'og_image' => $seoDefaults['og_image'],
                    'is_indexable' => true,
                ]));
                $created++;

                return;
            }

            if (!filled($existing->admin_title)) {
                $attributes['admin_title'] = (string) ($page['title'] ?? $path);
            }

            if (!$existing->last_seo_reviewed_at || !filled($existing->meta_title)) {
                $attributes['meta_title'] = $seoDefaults['meta_title'];
            }

            if (!$existing->last_seo_reviewed_at || !filled($existing->meta_description)) {
                $attributes['meta_description'] = $seoDefaults['meta_description'];
            }

            if (!$existing->last_seo_reviewed_at || !filled($existing->og_image)) {
                $attributes['og_image'] = $seoDefaults['og_image'];
            }

            $existing->fill($attributes);
            if ($existing->isDirty()) {
                $existing->save();
                $updated++;
            }
        });

        $obsolete = SitePage::query()
            ->whereNotIn('path', $seenPaths)
            ->where('is_obsolete', false)
            ->update(['is_obsolete' => true]);

        return [
            'created' => $created,
            'updated' => $updated,
            'obsolete' => $obsolete,
            'total' => SitePage::query()->count(),
        ];
    }

    public function silos(): Collection
    {
        return $this->syncablePages()
            ->pluck('path')
            ->map(fn (string $path) => Str::before($path, '/'))
            ->map(fn (string $silo) => $silo ?: 'site')
            ->unique()
            ->values();
    }

    private function syncablePages(): Collection
    {
        return collect()
            ->push(...$this->fixedPages())
            ->merge($this->structure->flat()->values())
            ->merge($this->realizationPages())
            ->unique('path')
            ->values();
    }

    private function fixedPages(): array
    {
        return [
            [
                'title' => 'Accueil',
                'path' => '',
                'description' => 'Maison 216 est un atelier intégré bois, aluminium et métal en Tunisie pour cuisines, dressings, fenêtres, portails et projets d aménagement sur mesure.',
                'type' => 'home',
                'silo' => 'site',
                'og_image' => Setting::get('seo.og_image') ?: Setting::get('ui.logo') ?: 'assets/home/amenagement-sur-mesure.jpg',
            ],
            [
                'title' => 'Conditions générales de vente',
                'path' => 'legal/cgv',
                'description' => 'Consultez les conditions générales de vente Maison216.',
                'type' => 'legal',
                'silo' => 'legal',
            ],
            [
                'title' => 'Politique de confidentialité',
                'path' => 'legal/confidentialite',
                'description' => 'Consultez la politique de confidentialité Maison216.',
                'type' => 'legal',
                'silo' => 'legal',
            ],
            [
                'title' => 'Livraison et retours',
                'path' => 'legal/livraison-retours',
                'description' => 'Informations Maison216 sur la livraison, la pose, les retours et le service après-vente.',
                'type' => 'legal',
                'silo' => 'legal',
            ],
            [
                'title' => 'Réalisations',
                'path' => 'realisations',
                'description' => 'Découvrez les réalisations Maison216 en Tunisie : cuisines, dressings, menuiserie aluminium, portails, pergolas et projets d’agencement.',
                'type' => 'portfolio',
                'silo' => 'realisations',
                'og_image' => 'assets/home/realizations/cuisine-sur-mesure.jpg',
            ],
        ];
    }

    private function realizationPages(): Collection
    {
        try {
            if (!Schema::hasTable('realizations')) {
                return collect();
            }

            return Realization::query()
                ->published()
                ->orderBy('sort_order')
                ->get()
                ->map(fn (Realization $realization) => [
                    'title' => $realization->title,
                    'path' => 'realisations/' . $realization->slug,
                    'description' => $realization->short_description ?: Str::limit((string) $realization->description, 155),
                    'type' => 'realization',
                    'silo' => 'realisations',
                    'og_image' => $realization->cover_image,
                ]);
        } catch (\Throwable) {
            return collect();
        }
    }

    private function parentPath(string $path): ?string
    {
        return $path !== '' && str_contains($path, '/') ? Str::beforeLast($path, '/') : null;
    }
}
