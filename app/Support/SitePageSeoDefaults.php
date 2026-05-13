<?php

namespace App\Support;

class SitePageSeoDefaults
{
    public function forPath(string $path, array $structurePage = []): array
    {
        $path = trim($path, '/');
        $defaults = $this->defaults()[$path] ?? [];

        return [
            'meta_title' => $defaults['title'] ?? ($structurePage['title'] ?? $path),
            'meta_description' => $defaults['description'] ?? ($structurePage['description'] ?? ''),
            'og_image' => $defaults['og_image'] ?? ($structurePage['og_image'] ?? $this->defaultOgImage($path)),
        ];
    }

    private function defaultOgImage(string $path): string
    {
        return match (true) {
            str_starts_with($path, 'aluminium') => 'assets/home/menuiserie-aluminium.jpg',
            str_starts_with($path, 'fer-metal') => 'assets/home/fabrication-metallique.jpg',
            str_starts_with($path, 'sur-mesure') => 'assets/home/amenagement-sur-mesure.jpg',
            str_starts_with($path, 'projets/agencement-cafe-restaurant') => 'assets/home/realizations/amenagement-restaurant.jpg',
            str_starts_with($path, 'projets/amenagement-exterieur') => 'assets/home/realizations/pergola.jpg',
            str_starts_with($path, 'projets') => 'assets/home/amenagement-sur-mesure.jpg',
            default => 'assets/home/menuiserie-bois.webp',
        };
    }

    private function defaults(): array
    {
        return [
            '' => [
                'title' => 'Accueil',
                'description' => 'Maison 216 est un atelier intégré bois, aluminium et métal en Tunisie pour cuisines, dressings, fenêtres, portails et projets d aménagement sur mesure.',
            ],
            'menuiserie-bois' => [
                'title' => 'Menuiserie bois en Tunisie | Atelier sur mesure',
                'description' => 'Atelier de menuiserie bois en Tunisie. Cuisines, dressings, mobilier sur mesure. Fabrication 100% interne, plans 3D, pose incluse. Devis sous 48h.',
                'og_image' => 'assets/home/menuiserie-bois.webp',
            ],
            'aluminium' => [
                'title' => 'Menuiserie aluminium en Tunisie | Atelier alu sur mesure',
                'description' => 'Atelier de menuiserie aluminium en Tunisie. Fenêtres, portes, garde-corps, volets roulants, moustiquaires et brise-soleil. Devis alu sous 48h.',
                'og_image' => 'assets/home/menuiserie-aluminium.jpg',
            ],
            'aluminium/fenetre-aluminium' => [
                'title' => 'Fenêtre aluminium sur mesure en Tunisie | Fabrication & pose',
                'description' => 'Fenêtres aluminium sur mesure fabriquées en atelier en Tunisie. Rupture de pont thermique, double vitrage, toutes teintes RAL. Métré gratuit, devis sous 48h, pose incluse.',
                'og_image' => 'assets/home/menuiserie-aluminium.jpg',
            ],
            'aluminium/porte-aluminium' => [
                'title' => 'Porte aluminium sur mesure en Tunisie | Entrée, baie, coulissant',
                'description' => 'Portes aluminium sur mesure fabriquées en atelier en Tunisie. Porte d’entrée, porte-fenêtre, baie coulissante. Toutes teintes RAL, serrurerie multipoints, pose incluse. Devis sous 48h.',
                'og_image' => 'assets/home/menuiserie-aluminium.jpg',
            ],
            'aluminium/garde-corps' => [
                'title' => 'Garde-corps aluminium sur mesure en Tunisie | Balcon, terrasse, escalier',
                'description' => 'Garde-corps aluminium sur mesure en Tunisie. Balcon, terrasse, escalier, mezzanine. Barreaux, verre ou lames. Devis sous 48h.',
                'og_image' => 'assets/home/menuiserie-aluminium.jpg',
            ],
            'aluminium/moustiquaire' => [
                'title' => 'Moustiquaire aluminium sur mesure en Tunisie | Enroulable, coulissante',
                'description' => 'Moustiquaires aluminium sur mesure en Tunisie. Enroulable, coulissante ou fixe. Fabriquée aux dimensions de vos fenêtres, posée par notre équipe.',
                'og_image' => 'assets/home/menuiserie-aluminium.jpg',
            ],
            'aluminium/volet-roulant' => [
                'title' => 'Volet roulant aluminium sur mesure en Tunisie | Manuel & motorisé',
                'description' => 'Volets roulants aluminium sur mesure en Tunisie. Manuel ou motorisé, pose en applique ou intégrée. Fabrication atelier, devis sous 48h.',
                'og_image' => 'assets/home/menuiserie-aluminium.jpg',
            ],
            'aluminium/brise-soleil' => [
                'title' => 'Brise-soleil aluminium sur mesure en Tunisie | Lames fixes & orientables',
                'description' => 'Brise-soleil aluminium sur mesure en Tunisie. Lames fixes, orientables ou motorisées. Protège du soleil sans bloquer la vue. Devis gratuit.',
                'og_image' => 'assets/home/menuiserie-aluminium.jpg',
            ],
            'fer-metal' => [
                'title' => 'Fabrication métallique en Tunisie | Portails et pergolas sur mesure',
                'description' => 'Atelier de ferronnerie et fabrication métallique en Tunisie. Portails fer forgé, pergolas, escaliers et garde-corps sur mesure. Devis sous 48h.',
                'og_image' => 'assets/home/fabrication-metallique.jpg',
            ],
            'fer-metal/portail-fer-forge' => [
                'title' => 'Portail fer forgé sur mesure en Tunisie | Battant, coulissant, motorisé',
                'description' => 'Portail fer forgé sur mesure en Tunisie. Battant ou coulissant, classique ou contemporain, manuel ou motorisé. Traitement anti-corrosion, pose incluse.',
                'og_image' => 'assets/home/fabrication-metallique.jpg',
            ],
            'fer-metal/pergola-metallique' => [
                'title' => 'Pergola métallique sur mesure en Tunisie | Terrasse & jardin',
                'description' => 'Pergola métallique sur mesure en Tunisie. Adossée, autoportée ou bioclimatique. Polycarbonate, bois ou lames orientables. Devis sous 48h.',
                'og_image' => 'assets/home/fabrication-metallique.jpg',
            ],
            'fer-metal/garde-corps' => [
                'title' => 'Garde-corps métallique sur mesure en Tunisie | Fer forgé, acier, inox',
                'description' => 'Garde-corps métallique sur mesure en Tunisie. Fer forgé, acier contemporain, inox, verre sécurisé. Balcon, escalier, mezzanine. Devis sous 48h.',
                'og_image' => 'assets/home/fabrication-metallique.jpg',
            ],
            'fer-metal/escalier-metallique' => [
                'title' => 'Escalier métallique sur mesure en Tunisie | Droit, hélicoïdal, suspendu',
                'description' => 'Escalier métallique sur mesure en Tunisie. Droit, hélicoïdal, tournant ou suspendu. Marches bois, verre ou métal, garde-corps assorti.',
                'og_image' => 'assets/home/fabrication-metallique.jpg',
            ],
            'sur-mesure' => [
                'title' => 'Meuble sur mesure en Tunisie | Cuisine, dressing, placard',
                'description' => 'Fabrication sur mesure en Tunisie : cuisine, dressing, placard, meuble TV, bureau. Plans 3D, fabrication atelier, pose incluse. Devis gratuit sous 48h.',
                'og_image' => 'assets/home/amenagement-sur-mesure.jpg',
            ],
            'sur-mesure/cuisine-sur-mesure' => [
                'title' => 'Cuisine sur mesure en Tunisie | Fabrication atelier, pose incluse',
                'description' => 'Cuisine sur mesure fabriquée en atelier en Tunisie. Plans 3D, choix des matériaux, quincaillerie premium, pose par notre équipe. Devis sous 48h.',
                'og_image' => 'assets/home/amenagement-sur-mesure.jpg',
            ],
            'sur-mesure/dressing-sur-mesure' => [
                'title' => 'Dressing sur mesure en Tunisie | Fabrication atelier, pose incluse',
                'description' => 'Dressing sur mesure fabriqué en atelier en Tunisie. Toutes configurations, aménagement intérieur personnalisé, portes battantes ou coulissantes.',
                'og_image' => 'assets/home/amenagement-sur-mesure.jpg',
            ],
            'sur-mesure/placard-sur-mesure' => [
                'title' => 'Placard sur mesure en Tunisie | Entrée, chambre, couloir',
                'description' => 'Placard sur mesure fabriqué en atelier en Tunisie. Entrée, chambre, couloir, sous escalier. Portes battantes ou coulissantes, devis sous 48h.',
                'og_image' => 'assets/home/amenagement-sur-mesure.jpg',
            ],
            'sur-mesure/meuble-tv-sur-mesure' => [
                'title' => 'Meuble TV sur mesure en Tunisie | Mural, suspendu, pleine hauteur',
                'description' => 'Meuble TV sur mesure fabriqué en atelier en Tunisie. Suspendu, pleine hauteur ou avec bibliothèque. LED, câbles invisibles, devis sous 48h.',
                'og_image' => 'assets/home/amenagement-sur-mesure.jpg',
            ],
            'sur-mesure/bureau-sur-mesure' => [
                'title' => 'Bureau sur mesure en Tunisie | Home office, étudiant, professionnel',
                'description' => 'Bureau sur mesure fabriqué en atelier en Tunisie. Droit, en L ou avec bibliothèque intégrée. Home office, étudiant, professionnel.',
                'og_image' => 'assets/home/amenagement-sur-mesure.jpg',
            ],
            'partenaires' => [
                'title' => 'Espace professionnels | Atelier de fabrication bois, alu, métal — Maison216 Tunisie',
                'description' => 'Atelier de fabrication intégré bois-aluminium-métal en Tunisie pour architectes, maîtres d’œuvre, décorateurs et promoteurs. Respect des plans, devis sous 24h, SAV interne. Visite atelier sur rendez-vous.',
                'og_image' => 'assets/home/amenagement-sur-mesure.jpg',
            ],
            'devis' => [
                'title' => 'Demander un devis | Maison216 Tunisie',
                'description' => 'Demandez un devis Maison216 pour cuisine, dressing, menuiserie aluminium, fabrication métallique ou projet complet. Réponse sous 48h.',
                'og_image' => 'assets/home/amenagement-sur-mesure.jpg',
            ],
            'contact' => [
                'title' => 'Contact',
                'description' => 'Contactez-nous par WhatsApp, Messenger ou via le formulaire. Réponse rapide 7j/7.',
                'og_image' => 'assets/home/amenagement-sur-mesure.jpg',
            ],
            'projets/agencement-immobilier-neuf' => [
                'title' => 'Agencement appartement neuf en Tunisie | Cuisine, dressings, menuiserie',
                'description' => 'Cuisine équipée, dressings, fenêtres alu pour appartements neufs en Tunisie. Un seul atelier pour tout l’aménagement. Promoteurs et particuliers. Devis sous 48h.',
                'og_image' => 'assets/home/amenagement-sur-mesure.jpg',
            ],
            'projets/agencement-cafe-restaurant' => [
                'title' => 'Agencement café et restaurant en Tunisie | Comptoir, mobilier, terrasse',
                'description' => 'Agencement complet de café et restaurant en Tunisie. Comptoir, mobilier sur mesure, vitrine, terrasse couverte. Bois, métal et alu. Devis sous 48h.',
                'og_image' => 'assets/home/realizations/amenagement-restaurant.jpg',
            ],
            'projets/agencement-bureau-entreprise' => [
                'title' => 'Agencement bureau entreprise en Tunisie | Mobilier sur mesure',
                'description' => 'Agencement de bureaux sur mesure en Tunisie. Open space, salle de réunion, banque d’accueil. Bois, aluminium, métal. Devis sous 48h.',
                'og_image' => 'assets/home/menuiserie-bois.webp',
            ],
            'projets/agencement-magasin' => [
                'title' => 'Agencement magasin et boutique sur mesure en Tunisie',
                'description' => 'Agencement de magasin et boutique en Tunisie. Vitrine, présentoirs, comptoir, étagères sur mesure. Bois, métal, aluminium. Devis gratuit sous 48h.',
                'og_image' => 'assets/home/menuiserie-bois.webp',
            ],
            'projets/amenagement-villa-maison' => [
                'title' => 'Aménagement villa et maison en Tunisie | Intégral bois, alu, métal',
                'description' => 'Aménagement intégral de villa et maison en Tunisie. Cuisine, dressings, fenêtres, portail, pergola. Un seul atelier. Un seul devis. Devis sous 48h.',
                'og_image' => 'assets/home/amenagement-sur-mesure.jpg',
            ],
            'projets/amenagement-exterieur' => [
                'title' => 'Aménagement extérieur sur mesure en Tunisie | Pergola, portail, garde-corps',
                'description' => 'Aménagement extérieur sur mesure en Tunisie. Pergola, portail, garde-corps, brise-soleil, volet roulant. Métal thermolaqué, aluminium traité. Devis sous 48h.',
                'og_image' => 'assets/home/realizations/pergola.jpg',
            ],
            'legal/cgv' => [
                'title' => 'Conditions générales de vente | Maison216',
                'description' => 'Consultez les conditions générales de vente Maison216.',
            ],
            'legal/confidentialite' => [
                'title' => 'Politique de confidentialité | Maison216',
                'description' => 'Consultez la politique de confidentialité Maison216.',
            ],
            'legal/livraison-retours' => [
                'title' => 'Livraison et retours | Maison216',
                'description' => 'Informations Maison216 sur la livraison, la pose, les retours et le service après-vente.',
            ],
        ];
    }
}
