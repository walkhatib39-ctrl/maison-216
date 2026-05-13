<?php

namespace App\Support;

use App\Models\Realization;
use App\Models\SitePage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class RealizationResolver
{
    public function forHome(int $limit = 6): Collection
    {
        if (!$this->tablesReady()) {
            return $this->fallback(null, $limit);
        }

        $items = Realization::query()
            ->published()
            ->where('is_featured', true)
            ->ordered()
            ->limit($limit)
            ->get();

        if ($items->isEmpty()) {
            $items = Realization::query()
                ->published()
                ->ordered()
                ->limit($limit)
                ->get();
        }

        return $items->map->toCardArray();
    }

    public function forCurrentPage(int $limit = 6, ?string $fallbackSilo = null): Collection
    {
        $path = trim((string) request()->path(), '/');

        return $path === ''
            ? $this->forHome($limit)
            : $this->forPage($path, $limit, $fallbackSilo);
    }

    public function forPage(string $path, int $limit = 6, ?string $fallbackSilo = null): Collection
    {
        $path = trim($path, '/');

        if (!$this->tablesReady()) {
            return $this->fallback($fallbackSilo ?: $this->siloFromPath($path), $limit);
        }

        $page = SitePage::query()
            ->active()
            ->where('path', $path)
            ->first();

        if (!$page) {
            return collect();
        }

        $assigned = $page->realizations()
            ->published()
            ->withPivot(['sort_order', 'is_featured_on_page'])
            ->orderByDesc('realization_site_page.is_featured_on_page')
            ->orderBy('realization_site_page.sort_order')
            ->limit($limit)
            ->get();

        return $assigned->map->toCardArray();
    }

    private function tablesReady(): bool
    {
        return Schema::hasTable('realizations')
            && Schema::hasTable('site_pages')
            && Schema::hasTable('realization_site_page');
    }

    private function siloFromPath(string $path): string
    {
        return str_contains($path, '/') ? str($path)->before('/')->toString() : $path;
    }

    private function fallback(?string $silo, int $limit): Collection
    {
        $items = collect([
            [
                'title' => 'Cuisine sur mesure',
                'type' => 'Cuisine sur mesure',
                'place' => 'Menuiserie bois',
                'note' => 'Cuisine équipée, rangements intégrés et finitions propres',
                'copy' => 'Cuisine équipée, rangements intégrés et finitions propres',
                'image' => asset('assets/home/realizations/cuisine-sur-mesure.jpg'),
                'image_url' => asset('assets/home/realizations/cuisine-sur-mesure.jpg'),
                'alt' => 'Cuisine sur mesure réalisée par Maison216',
                'silo' => 'menuiserie-bois',
                'url' => '#',
            ],
            [
                'title' => 'Dressing sur mesure',
                'type' => 'Dressing sur mesure',
                'place' => 'Rangement intégré',
                'note' => 'Dressing optimisé, façades soignées et pose ajustée',
                'copy' => 'Dressing optimisé, façades soignées et pose ajustée',
                'image' => asset('assets/home/realizations/dressing-sur-mesure.jpg'),
                'image_url' => asset('assets/home/realizations/dressing-sur-mesure.jpg'),
                'alt' => 'Dressing sur mesure réalisé par Maison216',
                'silo' => 'sur-mesure',
                'url' => '#',
            ],
            [
                'title' => 'Volet roulant aluminium',
                'type' => 'Volet roulant aluminium',
                'place' => 'Menuiserie aluminium',
                'note' => 'Protection solaire, confort et finition aluminium',
                'copy' => 'Protection solaire, confort et finition aluminium',
                'image' => asset('assets/home/realizations/volet-roulant-aluminium.webp'),
                'image_url' => asset('assets/home/realizations/volet-roulant-aluminium.webp'),
                'alt' => 'Volet roulant aluminium posé par Maison216',
                'silo' => 'aluminium',
                'url' => '#',
            ],
            [
                'title' => 'Portail métallique',
                'type' => 'Portail métallique',
                'place' => 'Fabrication métallique',
                'note' => 'Structure métal, finition durable et installation sur site',
                'copy' => 'Structure métal, finition durable et installation sur site',
                'image' => asset('assets/home/realizations/portail-metal.jpg'),
                'image_url' => asset('assets/home/realizations/portail-metal.jpg'),
                'alt' => 'Portail métallique fabriqué par Maison216',
                'silo' => 'fer-metal',
                'url' => '#',
            ],
            [
                'title' => 'Agencement restaurant',
                'type' => 'Agencement restaurant',
                'place' => 'Projet professionnel',
                'note' => 'Mobilier, comptoir et ambiance coordonnée',
                'copy' => 'Mobilier, comptoir et ambiance coordonnée',
                'image' => asset('assets/home/realizations/amenagement-restaurant.jpg'),
                'image_url' => asset('assets/home/realizations/amenagement-restaurant.jpg'),
                'alt' => 'Agencement restaurant réalisé par Maison216',
                'silo' => 'projets',
                'url' => '#',
            ],
            [
                'title' => 'Pergola extérieure',
                'type' => 'Pergola extérieure',
                'place' => 'Aménagement extérieur',
                'note' => 'Structure extérieure adaptée au lieu et aux usages',
                'copy' => 'Structure extérieure adaptée au lieu et aux usages',
                'image' => asset('assets/home/realizations/pergola.jpg'),
                'image_url' => asset('assets/home/realizations/pergola.jpg'),
                'alt' => 'Pergola extérieure réalisée par Maison216',
                'silo' => 'fer-metal',
                'url' => '#',
            ],
        ]);

        if ($silo) {
            $filtered = $items->where('silo', $silo)->values();

            if ($filtered->isNotEmpty()) {
                return $filtered->take($limit);
            }
        }

        return $items->take($limit)->values();
    }
}
