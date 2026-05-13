<?php

namespace Database\Seeders;

use App\Models\Realization;
use App\Models\SitePage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RealizationSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title' => 'Cuisine sur mesure',
                'project_type' => 'Cuisine sur mesure',
                'silo' => 'menuiserie-bois',
                'short_description' => 'Cuisine équipée, rangements intégrés et finitions propres.',
                'cover_image' => 'assets/home/realizations/cuisine-sur-mesure.jpg',
                'cover_alt' => 'Cuisine sur mesure réalisée par Maison216',
                'page_paths' => ['menuiserie-bois', 'sur-mesure', 'sur-mesure/cuisine-sur-mesure', 'projets/agencement-immobilier-neuf', 'projets/amenagement-villa-maison'],
            ],
            [
                'title' => 'Dressing sur mesure',
                'project_type' => 'Dressing sur mesure',
                'silo' => 'sur-mesure',
                'short_description' => 'Dressing optimisé, façades soignées et pose ajustée.',
                'cover_image' => 'assets/home/realizations/dressing-sur-mesure.jpg',
                'cover_alt' => 'Dressing sur mesure réalisé par Maison216',
                'page_paths' => ['menuiserie-bois', 'sur-mesure', 'sur-mesure/dressing-sur-mesure', 'projets/agencement-immobilier-neuf', 'projets/amenagement-villa-maison'],
            ],
            [
                'title' => 'Volet roulant aluminium',
                'project_type' => 'Volet roulant aluminium',
                'silo' => 'aluminium',
                'short_description' => 'Protection solaire, confort et finition aluminium.',
                'cover_image' => 'assets/home/realizations/volet-roulant-aluminium.webp',
                'cover_alt' => 'Volet roulant aluminium posé par Maison216',
                'page_paths' => ['aluminium', 'aluminium/volet-roulant', 'projets/amenagement-exterieur', 'projets/amenagement-villa-maison'],
            ],
            [
                'title' => 'Portail métallique',
                'project_type' => 'Portail métallique',
                'silo' => 'fer-metal',
                'short_description' => 'Structure métal, finition durable et installation sur site.',
                'cover_image' => 'assets/home/realizations/portail-metal.jpg',
                'cover_alt' => 'Portail métallique fabriqué par Maison216',
                'page_paths' => ['fer-metal', 'fer-metal/portail-fer-forge', 'projets/amenagement-exterieur', 'projets/amenagement-villa-maison'],
            ],
            [
                'title' => 'Agencement restaurant',
                'project_type' => 'Agencement restaurant',
                'silo' => 'projets',
                'short_description' => 'Mobilier, comptoir et ambiance coordonnée.',
                'cover_image' => 'assets/home/realizations/amenagement-restaurant.jpg',
                'cover_alt' => 'Agencement restaurant réalisé par Maison216',
                'page_paths' => ['menuiserie-bois', 'projets', 'projets/agencement-cafe-restaurant', 'projets/agencement-magasin'],
            ],
            [
                'title' => 'Pergola extérieure',
                'project_type' => 'Pergola extérieure',
                'silo' => 'fer-metal',
                'short_description' => 'Structure extérieure adaptée au lieu et aux usages.',
                'cover_image' => 'assets/home/realizations/pergola.jpg',
                'cover_alt' => 'Pergola extérieure réalisée par Maison216',
                'page_paths' => ['fer-metal', 'fer-metal/pergola-metallique', 'projets/amenagement-exterieur', 'projets/agencement-cafe-restaurant', 'projets/amenagement-villa-maison'],
            ],
        ];

        foreach ($items as $index => $item) {
            $paths = $item['page_paths'];
            unset($item['page_paths']);

            $realization = Realization::query()->updateOrCreate(
                ['slug' => Str::slug($item['title'])],
                array_merge($item, [
                    'status' => Realization::STATUS_PUBLISHED,
                    'is_featured' => true,
                    'sort_order' => $index + 1,
                ])
            );

            $pages = SitePage::query()
                ->whereIn('path', $paths)
                ->pluck('id')
                ->values();

            $sync = $pages->mapWithKeys(fn (int $id, int $pageIndex) => [
                $id => ['sort_order' => $pageIndex + 1, 'is_featured_on_page' => false],
            ])->all();

            $realization->pages()->sync($sync);
        }
    }
}
