<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class AutoCategorizeProducts extends Command
{
    protected $signature = 'app:auto-categorize-products';
    protected $description = 'Automatically assign categories to products based on precise title keywords mapping to Emob structure';

    public function handle()
    {
        $this->info('Starting precise auto-categorization...');

        // Precise Rules based on Emob structure slugs
        // Order matters: Specific terms first, generic terms last
        $rules = [
            // --- LITS & CHAMBRE ---
            'Lit voiture' => 'lits-voiture',
            'Lit princesse' => 'lits-princesse',
            'Lit pompier' => 'lits-pompier',
            'Lit cabane' => 'lits-cabane',
            'Lit tipi' => 'lits-tipi',
            'Lit maison' => 'lits-maison',
            'Lit gigogne' => 'lits-gigognes',
            'Lit banquette' => 'lits-banquette',
            'Lit gaming' => 'lits-gaming',
            'Lit mezzanine' => 'lits-mezzanines',
            'Lit superposé' => 'lits-superposes',
            'Lit mi-hauteur' => 'lits-mi-hauteur',
            'Lit bébé' => 'lits-bebe',
            'Lit double' => 'lits-doubles',
            'Lit boxspring' => 'lits-boxspring',
            'Lit capitonné' => 'lits-capitonnes',
            'Lit coffre' => 'lits-coffre',
            'Lit avec rangement' => 'lits-avec-rangement',
            'Tiroir-lit' => 'tiroirs-de-lit',
            'Chevet' => 'tables-de-chevet',
            'Table de nuit' => 'tables-de-chevet',
            'Commode' => 'commodes',
            'Chiffonnier' => 'chiffonniers',
            'Coiffeuse' => 'coiffeuses',
            'Garde-robe' => 'garde-robes',
            'Porte-vêtement' => 'porte-vetements',
            'Armoire' => 'garde-robes', // Default to wardrobe for armoire in bedroom context often
            'Matelas' => 'matelas',
            'Sommier' => 'sommiers',
            'Drap' => 'draps-housses',
            'Couette' => 'couettes',
            'Oreiller' => 'oreillers',

            // --- SALLE A MANGER / TABLES ---
            'Table à manger extensible' => 'tables-extensibles',
            'Table extensible' => 'tables-extensibles',
            'Table à manger ronde' => 'tables-rondes',
            'Table ronde' => 'tables-rondes',
            'Table ovale' => 'tables-ovales',
            'Table carrée' => 'tables-carrees',
            'Table haute' => 'tables-hautes-mange-debout',
            'Mange-debout' => 'tables-hautes-mange-debout',
            'Table à manger' => 'tables-a-manger', // Generic rollback
            'Chaise salle à manger' => 'chaises-salle-a-manger',
            'Chaise pliante' => 'chaises-pliantes',
            'Chaise' => 'chaises', // Generic
            'Tabouret de bar' => 'tabourets-de-bar',
            'Buffet' => 'buffets',
            'Bahut' => 'bahuts',
            'Vaisselier' => 'vaisseliers',
            'Vitrine' => 'vitrines',

            // --- SALON ---
            'Canapé d\'angle' => 'canapes-dangle',
            'Canapé lit' => 'canapes-lits',
            'Canapé-lit' => 'canapes-lits',
            'Canapé' => 'canapes',
            'Fauteuil relax' => 'fauteuils-relax',
            'Fauteuil' => 'fauteuils',
            'Meuble TV' => 'meubles-tv',
            'Table basse relevable' => 'tables-basses-relevables',
            'Table basse' => 'tables-basses',
            'Pouf' => 'poufs',

            // --- BUREAU ---
            'Bureau gamer' => 'bureaux-gamer',
            'Bureau d\'angle' => 'bureaux-dangle',
            'Bureau assis-debout' => 'bureaux-assis-debout',
            'Bureau enfant' => 'bureaux-enfant',
            'Bureau' => 'bureaux',
            'Chaise de bureau' => 'chaises-de-bureau',
            'Caisson' => 'caissons',
            'Classeur' => 'rangements-bureau',

            // --- CUISINE ---
            'Meuble haut' => 'meubles-hauts-de-cuisine',
            'Meuble bas' => 'meubles-bas-de-cuisine',
            'Sous-évier' => 'meubles-sous-evier',
            'Desserte' => 'dessertes-de-cuisine',
            'Ilôt' => 'ilots-de-cuisine',
            'Cuisine' => 'cuisines-en-kit', // Generic

            // --- RANGEMENT / DIVERS ---
            'Bibliothèque' => 'bibliotheques',
            'Étagère' => 'etageres',
            'Cube de rangement' => 'etageres',
            'Séparateur' => 'etageres',
            'Chaussure' => 'armoires-a-chaussures',
            'Vestiaire' => 'vestiaires',
            'Miroir' => 'miroirs',
            'Tapis' => 'tapis',
            'Lampe' => 'luminaires',
            'Suspension' => 'suspensions',
            'Plafonnier' => 'plafonniers',
            'Applique' => 'appliques-murales',

            // --- JARDIN ---
            'Salon de jardin' => 'salons-de-jardin',
            'Table de jardin' => 'tables-de-jardin',
            'Chaise de jardin' => 'chaises-de-jardin',
            'Parasol' => 'parasols',
            'Bain de soleil' => 'bains-de-soleil',
            'Transat' => 'transats',

            // Fallbacks intelligents
            'Table' => 'tables-a-manger', // Si rien d'autre ne matche, c'est souvent une table à manger
            'Lit' => 'lits',
        ];

        // Cache category IDs
        $categoryIds = [];
        $slugsNotFound = [];
        
        foreach ($rules as $keyword => $slug) {
            $cat = Category::where('slug', $slug)->first();
            if ($cat) {
                $categoryIds[$slug] = $cat->id;
            } else {
                if (!in_array($slug, $slugsNotFound)) {
                    $slugsNotFound[] = $slug;
                }
            }
        }
        
        if (!empty($slugsNotFound)) {
            $this->warn('Warning: The following slugs defined in rules were not found in DB:');
            foreach ($slugsNotFound as $s) $this->line(" - $s");
        }

        // Get orphan products
        $products = Product::whereNull('category_id')->get();
        if ($products->isEmpty()) {
            $this->info('No products found without categories.');
            return;
        }

        $count = 0;
        foreach ($products as $product) {
            $matched = false;
            foreach ($rules as $keyword => $slug) {
                // Case insensitive search
                if (stripos($product->title, $keyword) !== false) {
                    if (isset($categoryIds[$slug])) {
                        $product->category_id = $categoryIds[$slug];
                        $product->save();
                        $this->line("Assigned '{$product->title}' => '{$slug}'");
                        $count++;
                        $matched = true;
                        break; // Stop at first match (most specific first)
                    }
                }
            }
        }

        $this->info("Successfully categorized {$count} products.");
    }
}
