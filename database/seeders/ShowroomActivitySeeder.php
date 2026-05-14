<?php

namespace Database\Seeders;

use App\Models\ShowroomActivity;
use Illuminate\Database\Seeder;

class ShowroomActivitySeeder extends Seeder
{
    public function run(): void
    {
        $activities = [
            [
                'name' => 'Pharmacies & parapharmacies',
                'slug' => 'pharmacies-parapharmacies',
                'headline' => 'Comptoirs, présentoirs et rangements pour pharmacies et parapharmacies.',
                'description' => 'Solutions d agencement sur mesure pour comptoirs, rayonnages, présentoirs, vitrines et zones de conseil.',
            ],
            [
                'name' => 'Restaurants, cafés & fast-foods',
                'slug' => 'restaurants-cafes-fast-foods',
                'headline' => 'Comptoirs, mobilier, banquettes, vitrines et terrasses couvertes.',
                'description' => 'Produits standards et agencements sur mesure pour ouvrir, rénover ou optimiser un espace CHR.',
            ],
            [
                'name' => 'Salons de beauté & esthétique',
                'slug' => 'salons-beaute-esthetique',
                'headline' => 'Mobilier et agencement pour salons de coiffure, beauté et esthétique.',
                'description' => 'Postes de coiffage, comptoirs, rangements, claustras et mobilier sur mesure pour espaces beauté.',
            ],
            [
                'name' => 'Boutiques & magasins',
                'slug' => 'boutiques-magasins',
                'headline' => 'Présentoirs, vitrines, comptoirs et mobilier retail.',
                'description' => 'Solutions bois, aluminium et métal pour mettre en valeur les produits et fluidifier le parcours client.',
            ],
            [
                'name' => 'Cabinets médicaux & cliniques',
                'slug' => 'cabinets-medicaux-cliniques',
                'headline' => 'Banques d accueil, rangements et mobilier professionnel pour espaces de santé.',
                'description' => 'Agencements propres, fonctionnels et durables pour cabinets médicaux, cliniques et espaces paramédicaux.',
            ],
            [
                'name' => 'Bureaux professionnels',
                'slug' => 'bureaux-professionnels',
                'headline' => 'Banques d accueil, bureaux, rangements et cloisons.',
                'description' => 'Mobilier professionnel sur mesure pour open spaces, salles de réunion, directions et espaces d accueil.',
            ],
            [
                'name' => 'Pâtisseries & boulangeries',
                'slug' => 'patisseries-boulangeries',
                'headline' => 'Comptoirs, vitrines, présentoirs et mobilier de vente.',
                'description' => 'Agencements pour boulangeries, pâtisseries et espaces de vente alimentaire avec finitions résistantes.',
            ],
            [
                'name' => 'Hôtels & maisons d hôtes',
                'slug' => 'hotels-maisons-hotes',
                'headline' => 'Mobilier, accueil, terrasses et aménagements complets.',
                'description' => 'Solutions d agencement pour chambres, lobby, réception, espaces communs et extérieurs.',
            ],
        ];

        foreach ($activities as $index => $activity) {
            ShowroomActivity::updateOrCreate(
                ['slug' => $activity['slug']],
                [
                    ...$activity,
                    'meta_title' => $activity['name'] . ' | Showroom Maison216',
                    'meta_description' => $activity['headline'],
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }
    }
}
