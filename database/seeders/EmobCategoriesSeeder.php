<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EmobCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $structure = [
            'Lits' => [
                'Lits boxspring' => ['Lits boxspring double 140x200', 'Lits boxspring double 160x200', 'Lits boxspring double 180x200', 'Lits boxspring double 200x200'],
                'Lits doubles' => ['Lits doubles 140x200', 'Lits doubles 160x200', 'Lits doubles 180x200'],
                'Lits capitonnés' => ['Lits capitonnés simple 90x200', 'Lits capitonnés 120x200', 'Lits capitonnés double 140x200', 'Lits capitonnés double 160x200', 'Lits capitonnés double 180x200'],
                'Lits avec rangement' => ['Lits avec rangement simple', 'Lits avec rangement double', 'Lits coffre', 'Lits avec tiroirs'],
                'Lits adultes 120x200' => [],
                'Lits en bois' => [],
                'Lits en métal' => [],
                'Lits enfants' => ['Lits enfant', 'Lits gigognes', 'Lits voiture', 'Lits princesse', 'Lits pompier', 'Lits gaming', 'Lits banquette', 'Lits maison', 'Lits cabane', 'Lits tipi', 'Lits à baldaquin', 'Lits avec barrières'],
                'Lits superposés' => ['Lits superposés 2 places', 'Lits superposés 3 places', 'Lits superposés avec bureau', 'Lits superposés avec rangement'],
                'Lits mezzanines' => ['Lits mezzanines avec bureau', 'Lits mezzanines avec toboggan', 'Lits mi-hauteur'],
                'Lits bébé' => ['Lits bébé 60x120', 'Lits bébé évolutifs 70x140'],
                'Lits junior' => [],
            ],
            'Accessoires pour lits' => [
                'Matelas' => ['Matelas mousse polyéther', 'Matelas mousse à froid HR', 'Matelas à ressorts ensachés', 'Matelas à mémoire de forme', 'Matelas enfant', 'Matelas bébé'],
                'Sommiers' => ['Sommiers à lattes lits adultes', 'Sommiers à lattes lits enfants'],
                'Literie' => ['Couettes', 'Oreillers', 'Draps-housses', 'Housses de couette', 'Protège-matelas', 'Accessoires literie'],
                'Décoration de lit' => ['Tentes de lit', 'Tunnels de lit', 'Tours de lits', 'Barrières de lit', 'Tiroirs de lit', 'Tables de chevet à pincer'],
            ],
            'Armoires' => [
                'Chambre' => ['Garde-robes', 'Garde-robes portes battantes', 'Garde-robes portes coulissantes', 'Tables de chevet', 'Commodes', 'Chiffonniers', 'Armoires vestiaires'],
                'Chambre enfant' => ['Garde-robes enfant', 'Porte-vêtements', 'Armoires de rangement', 'Bibliothèques', 'Coffres à jouets', 'Tables de chevet enfant', 'Commodes enfant', 'Tables à langer', 'Chiffonniers enfant'],
                'Salon / Salle à manger' => ['Bahuts', 'Buffet', 'Vaisseliers', 'Meubles TV', 'Bibliothèques', 'Étagères', 'Meubles bar', 'Vitrines', 'Commodes'],
                'Cuisine' => ['Meubles hauts de cuisine', 'Meubles bas de cuisine', 'Meubles sous-évier', 'Armoires de cuisine', 'Dessertes de cuisine', 'Meubles micro-ondes', 'Ilôts de cuisine', 'Buffets de cuisine'],
                'Salle de bains / WC' => ['Meubles sous vasque', 'Armoires de toilette', 'Armoires de salle de bains', 'Colonnes salle de bains', 'Meubles WC'],
                'Bureau' => ['Caissons à tiroirs', 'Bibliothèques bureau', 'Classeurs à rideaux', 'Armoires métalliques', 'Armoires à dossiers'],
                'Divers' => ['Armoires à chaussures', 'Meubles d\'entrée', 'Vestiaires', 'Armoires vitrées', 'Portants', 'Valets de nuit'],
            ],
            'Meubles d\'assises' => [
                'Canapés' => ['Canapés droits', 'Canapés d\'angle', 'Canapés panoramiques (en U)', 'Canapés-lits', 'Canapés 1 place', 'Canapés 2 places', 'Canapés 3 places'],
                'Fauteuils' => ['Fauteuils relax', 'Fauteuils pivotants', 'Fauteuils papillon', 'Fauteuils à bascule', 'Causeuses', 'Fauteuils-lits'],
                'Chaises' => ['Chaises en bois', 'Chaises en métal', 'Chaises en plastique', 'Chaises capitonnées', 'Chaises avec accoudoirs', 'Chaises salle à manger', 'Chaises pliantes', 'Tabourets'],
                'Chaises de bureau' => ['Chaises de bureau ergonomiques', 'Chaises de bureau design', 'Chaises gamer', 'Tabourets de bureau', 'Chaises de bureau enfant'],
                'Tabourets de bar' => ['Tabourets de bar avec dossier', 'Tabourets de bar sans dossier', 'Tabourets de bar réglables'],
                'Bancs' => ['Bancs d\'entrée', 'Bancs de table', 'Bancs coffre'],
                'Poufs' => ['Poufs coffre', 'Poufs tricotés', 'Poufs en velours'],
            ],
            'Tables' => [
                'Tables à manger' => ['Tables rondes', 'Tables ovales', 'Tables carrées', 'Tables rectangulaires', 'Tables extensibles', 'Tables en verre', 'Tables hautes / Mange-debout', 'Tables murales rabattables'],
                'Tables basses' => ['Tables basses', 'Tables d\'appoint', 'Lot de tables', 'Tables basses marbre', 'Tables basses verre', 'Tables basses relevables'],
                'Consoles' => ['Consoles extensibles', 'Consoles avec tiroirs'],
                'Tables à plantes' => [],
                'Tables enfant' => ['Bureaux enfant', 'Coiffeuses enfant', 'Ensembles table et chaises enfant'],
            ],
            'Luminaires & Accessoires' => [
                'Luminaires' => ['Suspensions', 'Plafonniers', 'Lampadaires', 'Lampes à poser', 'Appliques murales', 'Spots', 'Guirlandes lumineuses', 'Veilleuses', 'Luminaires enfant'],
                'Accessoires Maison' => ['Décorations de Noël', 'Miroirs', 'Horloges', 'Tapis', 'Cadres photo', 'Bougies', 'Plantes artificielles', 'Accessoires salle de bain', 'Accessoires WC', 'Accessoires cuisine', 'Accessoires bureau'],
                'Vases / Vaisselle' => ['Vases', 'Plats', 'Plateaux', 'Sous-verres', 'Vaisselle'],
            ],
            'Bureau à domicile' => [
                'Bureaux' => ['Bureaux droits', 'Bureaux d\'angle', 'Bureaux assis-debout', 'Bureaux avec rangement', 'Secrétaires', 'Bureaux gamer', 'Tables de réunion'],
                'Rangements bureau' => ['Caissons', 'Armoires', 'Bibliothèques', 'Rayonnages'],
            ],
            'Jardin' => [
                'Salons de jardin' => ['Salons de jardin bas', 'Salons de jardin repas'],
                'Chaises de jardin' => ['Chaises de jardin', 'Fauteuils de jardin', 'Bancs de jardin'],
                'Tables de jardin' => ['Tables de jardin', 'Tables basses de jardin', 'Tables d\'appoint de jardin'],
                'Détente' => ['Bains de soleil', 'Transats', 'Hamacs', 'Balancelles'],
                'Parasols & Ombrage' => ['Parasols', 'Voiles d\'ombrage', 'Pieds de parasol'],
                'Rangement jardin' => ['Coffres de jardin', 'Armoires de jardin', 'Abris bûches'],
                'Accessoires jardin' => ['Coussins d\'extérieur', 'Tapis d\'extérieur', 'Éclairage extérieur', 'Braséros'],
                'Jardinage' => ['Serres', 'Potagers sur pied', 'Composteurs'],
            ],
            'Espaces' => [
                'Chambre' => [],
                'Séjour' => [],
                'Salle à manger' => [],
                'Cuisine' => [],
                'Bureau' => [],
                'Salle de bains' => [],
                'Entrée' => [],
                'Jardin' => [],
            ],
        ];

        $this->createCategories($structure);
    }

    private function createCategories(array $categories, $parentId = null)
    {
        foreach ($categories as $key => $value) {
            $name = is_string($key) ? $key : $value;
            $slug = Str::slug($name);

            // Avoid duplicate slugs at the same level if possible, 
            // but for simplicity we rely on unique slugs globally or simple update
            $category = Category::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $name,
                    'parent_id' => $parentId,

                ]
            );

            if (is_array($value) && !empty($value)) {
                $this->createCategories($value, $category->id);
            }
        }
    }
}
