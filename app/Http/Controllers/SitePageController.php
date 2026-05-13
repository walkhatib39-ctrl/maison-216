<?php

namespace App\Http\Controllers;

use App\Support\SiteStructure;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SitePageController extends Controller
{
    public function show(Request $request, SiteStructure $structure): View
    {
        $section = trim((string) $request->route('section'), '/');
        $path = trim((string) ($request->route('path') ?? ''), '/');
        $fullPath = $path !== '' ? "{$section}/{$path}" : $section;

        $page = $structure->find($fullPath);

        abort_if(!$page, 404);

        if ($fullPath === 'menuiserie-bois') {
            return view('site-structure.menuiserie-bois', [
                'title' => 'Menuiserie bois en Tunisie | Atelier sur mesure',
                'metaDescription' => 'Atelier de menuiserie bois en Tunisie. Cuisines, dressings, mobilier sur mesure. Fabrication 100% interne, plans 3D, pose incluse. Devis sous 48h.',
                'canonical' => url('/menuiserie-bois'),
                'ogType' => 'website',
                'ogImage' => asset('assets/home/menuiserie-bois.webp'),
            ]);
        }

        if ($fullPath === 'aluminium') {
            return view('site-structure.aluminium', [
                'title' => 'Menuiserie aluminium en Tunisie | Atelier alu sur mesure',
                'metaDescription' => 'Atelier de menuiserie aluminium en Tunisie. Fenêtres, portes, garde-corps, volets roulants, moustiquaires et brise-soleil. Devis alu sous 48h.',
                'canonical' => url('/aluminium'),
                'ogType' => 'website',
                'ogImage' => asset('assets/home/menuiserie-aluminium.jpg'),
            ]);
        }

        if (in_array($fullPath, ['aluminium/fenetre-aluminium', 'aluminium/porte-aluminium'], true)) {
            $isWindow = $fullPath === 'aluminium/fenetre-aluminium';

            return view('site-structure.aluminium-detail', [
                'pageKey' => $isWindow ? 'window' : 'door',
                'title' => $isWindow
                    ? 'Fenêtre aluminium sur mesure en Tunisie | Fabrication & pose'
                    : 'Porte aluminium sur mesure en Tunisie | Entrée, baie, coulissant',
                'metaDescription' => $isWindow
                    ? 'Fenêtres aluminium sur mesure fabriquées en atelier en Tunisie. Rupture de pont thermique, double vitrage, toutes teintes RAL. Métré gratuit, devis sous 48h, pose incluse.'
                    : 'Portes aluminium sur mesure fabriquées en atelier en Tunisie. Porte d’entrée, porte-fenêtre, baie coulissante. Toutes teintes RAL, serrurerie multipoints, pose incluse. Devis sous 48h.',
                'canonical' => url('/' . $fullPath),
                'ogType' => 'website',
                'ogImage' => asset('assets/home/menuiserie-aluminium.jpg'),
            ]);
        }

        if (in_array($fullPath, ['aluminium/garde-corps', 'aluminium/moustiquaire', 'aluminium/volet-roulant', 'aluminium/brise-soleil'], true)) {
            $pageMeta = [
                'aluminium/garde-corps' => [
                    'key' => 'guardrail',
                    'title' => 'Garde-corps aluminium sur mesure en Tunisie | Balcon, terrasse, escalier',
                    'description' => 'Garde-corps aluminium sur mesure en Tunisie. Balcon, terrasse, escalier, mezzanine. Barreaux, verre ou lames. Devis sous 48h.',
                ],
                'aluminium/moustiquaire' => [
                    'key' => 'mosquito',
                    'title' => 'Moustiquaire aluminium sur mesure en Tunisie | Enroulable, coulissante',
                    'description' => 'Moustiquaires aluminium sur mesure en Tunisie. Enroulable, coulissante ou fixe. Fabriquée aux dimensions de vos fenêtres, posée par notre équipe.',
                ],
                'aluminium/volet-roulant' => [
                    'key' => 'shutter',
                    'title' => 'Volet roulant aluminium sur mesure en Tunisie | Manuel & motorisé',
                    'description' => 'Volets roulants aluminium sur mesure en Tunisie. Manuel ou motorisé, pose en applique ou intégrée. Fabrication atelier, devis sous 48h.',
                ],
                'aluminium/brise-soleil' => [
                    'key' => 'sunshade',
                    'title' => 'Brise-soleil aluminium sur mesure en Tunisie | Lames fixes & orientables',
                    'description' => 'Brise-soleil aluminium sur mesure en Tunisie. Lames fixes, orientables ou motorisées. Protège du soleil sans bloquer la vue. Devis gratuit.',
                ],
            ][$fullPath];

            return view('site-structure.aluminium-product', [
                'pageKey' => $pageMeta['key'],
                'title' => $pageMeta['title'],
                'metaDescription' => $pageMeta['description'],
                'canonical' => url('/' . $fullPath),
                'ogType' => 'website',
                'ogImage' => asset('assets/home/menuiserie-aluminium.jpg'),
            ]);
        }

        if ($fullPath === 'fer-metal') {
            return view('site-structure.fer-metal', [
                'title' => 'Fabrication métallique en Tunisie | Portails et pergolas sur mesure',
                'metaDescription' => 'Atelier de ferronnerie et fabrication métallique en Tunisie. Portails fer forgé, pergolas, escaliers et garde-corps sur mesure. Devis sous 48h.',
                'canonical' => url('/fer-metal'),
                'ogType' => 'website',
                'ogImage' => asset('assets/home/fabrication-metallique.jpg'),
            ]);
        }

        if (in_array($fullPath, ['fer-metal/portail-fer-forge', 'fer-metal/pergola-metallique', 'fer-metal/garde-corps', 'fer-metal/escalier-metallique'], true)) {
            $pageMeta = [
                'fer-metal/portail-fer-forge' => [
                    'key' => 'gate',
                    'title' => 'Portail fer forgé sur mesure en Tunisie | Battant, coulissant, motorisé',
                    'description' => 'Portail fer forgé sur mesure en Tunisie. Battant ou coulissant, classique ou contemporain, manuel ou motorisé. Traitement anti-corrosion, pose incluse.',
                ],
                'fer-metal/pergola-metallique' => [
                    'key' => 'pergola',
                    'title' => 'Pergola métallique sur mesure en Tunisie | Terrasse & jardin',
                    'description' => 'Pergola métallique sur mesure en Tunisie. Adossée, autoportée ou bioclimatique. Polycarbonate, bois ou lames orientables. Devis sous 48h.',
                ],
                'fer-metal/garde-corps' => [
                    'key' => 'guardrail',
                    'title' => 'Garde-corps métallique sur mesure en Tunisie | Fer forgé, acier, inox',
                    'description' => 'Garde-corps métallique sur mesure en Tunisie. Fer forgé, acier contemporain, inox, verre sécurisé. Balcon, escalier, mezzanine. Devis sous 48h.',
                ],
                'fer-metal/escalier-metallique' => [
                    'key' => 'staircase',
                    'title' => 'Escalier métallique sur mesure en Tunisie | Droit, hélicoïdal, suspendu',
                    'description' => 'Escalier métallique sur mesure en Tunisie. Droit, hélicoïdal, tournant ou suspendu. Marches bois, verre ou métal, garde-corps assorti.',
                ],
            ][$fullPath];

            return view('site-structure.fer-metal-product', [
                'pageKey' => $pageMeta['key'],
                'title' => $pageMeta['title'],
                'metaDescription' => $pageMeta['description'],
                'canonical' => url('/' . $fullPath),
                'ogType' => 'website',
                'ogImage' => asset('assets/home/fabrication-metallique.jpg'),
            ]);
        }

        if ($fullPath === 'sur-mesure') {
            return view('site-structure.sur-mesure', [
                'title' => 'Meuble sur mesure en Tunisie | Cuisine, dressing, placard',
                'metaDescription' => 'Fabrication sur mesure en Tunisie : cuisine, dressing, placard, meuble TV, bureau. Plans 3D, fabrication atelier, pose incluse. Devis gratuit sous 48h.',
                'canonical' => url('/sur-mesure'),
                'ogType' => 'website',
                'ogImage' => asset('assets/home/amenagement-sur-mesure.jpg'),
            ]);
        }

        if (in_array($fullPath, ['sur-mesure/cuisine-sur-mesure', 'sur-mesure/dressing-sur-mesure', 'sur-mesure/placard-sur-mesure', 'sur-mesure/meuble-tv-sur-mesure', 'sur-mesure/bureau-sur-mesure'], true)) {
            $pageMeta = [
                'sur-mesure/cuisine-sur-mesure' => [
                    'key' => 'kitchen',
                    'title' => 'Cuisine sur mesure en Tunisie | Fabrication atelier, pose incluse',
                    'description' => 'Cuisine sur mesure fabriquée en atelier en Tunisie. Plans 3D, choix des matériaux, quincaillerie premium, pose par notre équipe. Devis sous 48h.',
                ],
                'sur-mesure/dressing-sur-mesure' => [
                    'key' => 'dressing',
                    'title' => 'Dressing sur mesure en Tunisie | Fabrication atelier, pose incluse',
                    'description' => 'Dressing sur mesure fabriqué en atelier en Tunisie. Toutes configurations, aménagement intérieur personnalisé, portes battantes ou coulissantes.',
                ],
                'sur-mesure/placard-sur-mesure' => [
                    'key' => 'closet',
                    'title' => 'Placard sur mesure en Tunisie | Entrée, chambre, couloir',
                    'description' => 'Placard sur mesure fabriqué en atelier en Tunisie. Entrée, chambre, couloir, sous escalier. Portes battantes ou coulissantes, devis sous 48h.',
                ],
                'sur-mesure/meuble-tv-sur-mesure' => [
                    'key' => 'tv',
                    'title' => 'Meuble TV sur mesure en Tunisie | Mural, suspendu, pleine hauteur',
                    'description' => 'Meuble TV sur mesure fabriqué en atelier en Tunisie. Suspendu, pleine hauteur ou avec bibliothèque. LED, câbles invisibles, devis sous 48h.',
                ],
                'sur-mesure/bureau-sur-mesure' => [
                    'key' => 'desk',
                    'title' => 'Bureau sur mesure en Tunisie | Home office, étudiant, professionnel',
                    'description' => 'Bureau sur mesure fabriqué en atelier en Tunisie. Droit, en L ou avec bibliothèque intégrée. Home office, étudiant, professionnel.',
                ],
            ][$fullPath];

            return view('site-structure.sur-mesure-product', [
                'pageKey' => $pageMeta['key'],
                'title' => $pageMeta['title'],
                'metaDescription' => $pageMeta['description'],
                'canonical' => url('/' . $fullPath),
                'ogType' => 'website',
                'ogImage' => asset('assets/home/amenagement-sur-mesure.jpg'),
            ]);
        }

        if ($fullPath === 'partenaires') {
            return view('site-structure.partners', [
                'title' => 'Espace professionnels | Atelier de fabrication bois, alu, métal — Maison216 Tunisie',
                'metaDescription' => 'Atelier de fabrication intégré bois-aluminium-métal en Tunisie pour architectes, maîtres d’œuvre, décorateurs et promoteurs. Respect des plans, devis sous 24h, SAV interne. Visite atelier sur rendez-vous.',
                'canonical' => url('/partenaires'),
                'ogType' => 'website',
                'ogImage' => asset('assets/home/amenagement-sur-mesure.jpg'),
            ]);
        }

        if ($fullPath === 'devis') {
            return view('site-structure.devis', [
                'title' => 'Demander un devis | Maison216 Tunisie',
                'metaDescription' => 'Demandez un devis Maison216 pour cuisine, dressing, menuiserie aluminium, fabrication métallique ou projet complet. Réponse sous 48h.',
                'canonical' => url('/devis'),
                'ogType' => 'website',
                'ogImage' => asset('assets/home/amenagement-sur-mesure.jpg'),
            ]);
        }

        if ($fullPath === 'projets/agencement-immobilier-neuf') {
            return view('site-structure.project-real-estate-new', [
                'title' => 'Agencement appartement neuf en Tunisie | Cuisine, dressings, menuiserie',
                'metaDescription' => 'Cuisine équipée, dressings, fenêtres alu pour appartements neufs en Tunisie. Un seul atelier pour tout l’aménagement. Promoteurs et particuliers. Devis sous 48h.',
                'canonical' => url('/projets/agencement-immobilier-neuf'),
                'ogType' => 'website',
                'ogImage' => asset('assets/home/amenagement-sur-mesure.jpg'),
            ]);
        }

        if ($fullPath === 'projets/agencement-cafe-restaurant') {
            return view('site-structure.project-cafe-restaurant', [
                'title' => 'Agencement café et restaurant en Tunisie | Comptoir, mobilier, terrasse',
                'metaDescription' => 'Agencement complet de café et restaurant en Tunisie. Comptoir, mobilier sur mesure, vitrine, terrasse couverte. Bois, métal et alu. Devis sous 48h.',
                'canonical' => url('/projets/agencement-cafe-restaurant'),
                'ogType' => 'website',
                'ogImage' => asset('assets/home/realizations/amenagement-restaurant.jpg'),
            ]);
        }

        $strategicProjects = $this->strategicProjectPages();

        if (isset($strategicProjects[$fullPath])) {
            $project = $strategicProjects[$fullPath];

            return view('site-structure.project-strategic', [
                'project' => $project,
                'title' => $project['title'],
                'metaDescription' => $project['metaDescription'],
                'canonical' => url('/' . $fullPath),
                'ogType' => 'website',
                'ogImage' => $project['heroImage'],
            ]);
        }

        $children = $structure->childrenOf($fullPath);
        $ancestors = $structure->ancestorsOf($fullPath);
        $siblings = $ancestors->last()
            ? collect($ancestors->last()['children'] ?? [])->where('path', '!=', $page['path'])->values()
            : $structure->mainNavigation()->where('path', '!=', $page['path'])->values();

        return view('site-structure.show', [
            'page' => $page,
            'children' => $children,
            'ancestors' => $ancestors,
            'siblings' => $siblings,
            'mainNavigation' => $structure->mainNavigation(),
            'title' => $page['title'],
            'metaDescription' => $page['description'],
            'ogType' => 'website',
        ]);
    }

    private function strategicProjectPages(): array
    {
        $woodImage = asset('assets/home/menuiserie-bois.webp');
        $aluImage = asset('assets/home/menuiserie-aluminium.jpg');
        $metalImage = asset('assets/home/fabrication-metallique.jpg');
        $customImage = asset('assets/home/amenagement-sur-mesure.jpg');
        $restaurantImage = asset('assets/home/realizations/amenagement-restaurant.jpg');
        $pergolaImage = asset('assets/home/realizations/pergola.jpg');
        $kitchenImage = asset('assets/home/realizations/cuisine-sur-mesure.jpg');
        $dressingImage = asset('assets/home/realizations/dressing-sur-mesure.jpg');
        $shutterImage = asset('assets/home/realizations/volet-roulant-aluminium.webp');

        return [
            'projets/agencement-bureau-entreprise' => [
                'breadcrumb' => 'Agencement bureau entreprise',
                'eyebrow' => 'Projet · Bureau entreprise',
                'h1' => 'Agencement de bureaux Tunisie.',
                'subtitle' => 'Open space, salles de réunion, bureau de direction, zone d’accueil ou coworking : nous concevons et fabriquons l’agencement de vos espaces de travail en Tunisie. Mobilier sur mesure, cloisons, banque d’accueil, rangements. Un seul prestataire pour tout votre projet.',
                'cta' => 'Demander un devis',
                'heroImage' => $woodImage,
                'title' => 'Agencement bureau entreprise en Tunisie | Mobilier sur mesure',
                'metaDescription' => 'Agencement de bureaux sur mesure en Tunisie. Open space, salle de réunion, banque d’accueil. Bois, aluminium, métal. Devis sous 48h.',
                'proofs' => [
                    ['label' => 'Sur mesure selon vos plans', 'icon' => 'fa-solid fa-ruler-combined'],
                    ['label' => 'Bois + aluminium + métal', 'icon' => 'fa-solid fa-layer-group'],
                    ['label' => 'Interlocuteur dédié', 'icon' => 'fa-solid fa-user-check'],
                    ['label' => 'Pose à impact réduit', 'icon' => 'fa-solid fa-calendar-check'],
                ],
                'issue' => [
                    'eyebrow' => 'L’enjeu',
                    'h2' => 'Un bureau aménagé professionnellement, c’est un investissement, pas une dépense.',
                    'paragraphs' => [
                        'En Tunisie, beaucoup d’entreprises sous-estiment l’impact de leur espace de travail sur deux audiences qui comptent.',
                        'Les clients qui viennent vous voir jugent votre sérieux et votre niveau dès la réception. Un espace soigné inspire confiance. Un espace négligé interroge.',
                        'Les collaborateurs travaillent mieux, restent plus longtemps et sont plus productifs dans un environnement conçu pour eux : bonne luminosité, acoustique soignée, mobilier ergonomique, espaces de concentration et de collaboration distincts.',
                        'Nous ne vendons pas du mobilier de bureau. Nous aménageons des espaces de travail qui servent les objectifs de votre entreprise.',
                    ],
                ],
                'scope' => [
                    'eyebrow' => 'Notre gamme bureau',
                    'h2' => 'De la zone d’accueil aux postes opérateurs.',
                    'items' => [
                        ['title' => 'Banque d’accueil', 'copy' => 'Le premier contact physique entre votre entreprise et vos visiteurs. Elle doit refléter votre identité visuelle, être fonctionnelle pour la personne qui l’occupe et donner une impression de professionnalisme immédiate.', 'image' => $woodImage, 'icon' => 'fa-solid fa-building-user'],
                        ['title' => 'Bureaux et postes de travail', 'copy' => 'Bureau de direction, postes opérateurs, bureaux partagés en bench, bureau individuel cloisonné. Fabriqués sur mesure selon la surface disponible et le nombre de postes souhaités.', 'image' => $customImage, 'icon' => 'fa-solid fa-briefcase'],
                        ['title' => 'Cloisons et séparations', 'copy' => 'Cloisons bois pour délimiter les espaces sans fermer complètement, cloisons aluminium et verre pour salles de réunion et bureaux de direction. Acoustique travaillée pour réduire les nuisances.', 'image' => $aluImage, 'icon' => 'fa-solid fa-border-all'],
                        ['title' => 'Salles de réunion', 'copy' => 'Table de réunion sur mesure, meuble de présentation, mobilier de rangement et habillage mural cohérent pour accueillir vos équipes et vos clients.', 'image' => $restaurantImage, 'icon' => 'fa-solid fa-users-rectangle'],
                        ['title' => 'Espaces de rangement', 'copy' => 'Armoires de rangement, bibliothèques de dossiers, casiers et caissons mobiles. Conçus pour l’usage intensif et la durabilité sur 10+ ans.', 'image' => $dressingImage, 'icon' => 'fa-solid fa-box-archive'],
                    ],
                ],
                'audiences' => [
                    'eyebrow' => 'Pour qui',
                    'h2' => 'PME, professions libérales, grandes entreprises.',
                    'items' => [
                        ['title' => 'PME', 'copy' => 'Agencement complet d’un nouveau local, rénovation d’un espace existant, création d’un open space fonctionnel avec zones de concentration et espaces de collaboration distincts.', 'icon' => 'fa-solid fa-people-group'],
                        ['title' => 'Professions libérales', 'copy' => 'Cabinet d’accueil, salle d’attente, bureau de consultation ou de travail. L’espace de réception parle autant que les diplômes sur le mur.', 'icon' => 'fa-solid fa-user-tie'],
                        ['title' => 'Coworking et incubateurs', 'copy' => 'Postes flexibles, salles de réunion modulables, espace café et détente. Conçus pour s’adapter aux variations de l’occupation.', 'icon' => 'fa-solid fa-network-wired'],
                        ['title' => 'Siège social représentatif', 'copy' => 'Hall d’accueil, salle de conseil, bureau de direction haut de gamme. Un espace à la hauteur de vos partenaires et clients institutionnels.', 'icon' => 'fa-solid fa-landmark'],
                    ],
                ],
                'process' => [
                    ['step' => '01', 'title' => 'Brief & visite', 'copy' => 'Nous comprenons votre organisation, vos besoins de circulation et vos contraintes : budget, délai, nombre de postes.'],
                    ['step' => '02', 'title' => 'Plans & devis', 'copy' => 'Conception en plans 2D, devis détaillé par poste. Validation avant fabrication. Acompte de 30%.'],
                    ['step' => '03', 'title' => 'Fabrication', 'copy' => 'Fabrication dans nos ateliers bois et métal. Coordination avec vos corps de métier : électricien, réseau, climatisation.'],
                    ['step' => '04', 'title' => 'Pose & mise en service', 'copy' => 'Installation propre et rapide pour minimiser l’interruption de votre activité. Garantie atelier active.'],
                ],
                'faqs' => [
                    ['q' => 'Quel est le budget d’un agencement de bureaux en Tunisie ?', 'a' => 'Un agencement de bureau complet, open space 10 postes + salle de réunion + accueil, se situe généralement entre 20 000 et 60 000 DT selon les finitions et le niveau d’équipement. Devis personnalisé sur visite.'],
                    ['q' => 'Pouvez-vous travailler sur des plans fournis par notre architecte ?', 'a' => 'Oui. Nous sommes habitués à travailler sur des plans techniques fournis. Respect strict des dimensions, des matériaux spécifiés et des délais de livraison.'],
                    ['q' => 'Proposez-vous un espace professionnels pour les architectes d’intérieur ?', 'a' => 'Oui. Nous avons un espace professionnels avec interlocuteur dédié, chiffrage prioritaire, étude technique et conditions adaptées selon le profil professionnel.'],
                    ['q' => 'Intervenez-vous pendant les heures creuses pour ne pas perturber l’activité ?', 'a' => 'Oui. Nous planifions la pose pour minimiser l’impact sur votre activité : week-end, soirée ou phasage par zone si nécessaire.'],
                ],
                'finalCta' => ['h2' => 'Vous aménagez ou rénovez vos bureaux ?', 'subtitle' => 'Visite gratuite, devis détaillé sous 48h.', 'label' => 'Demander un devis'],
                'internalLinks' => [
                    ['title' => 'Menuiserie bois', 'href' => url('/menuiserie-bois'), 'copy' => 'Banques d’accueil, bureaux, rangements.'],
                    ['title' => 'Menuiserie aluminium', 'href' => url('/aluminium'), 'copy' => 'Cloisons vitrées et séparations.'],
                    ['title' => 'Bureau sur mesure', 'href' => url('/sur-mesure/bureau-sur-mesure'), 'copy' => 'Postes individuels et direction.'],
                    ['title' => 'Agencement magasin', 'href' => url('/projets/agencement-magasin'), 'copy' => 'Retail, présentation, caisse.'],
                    ['title' => 'Espace professionnels', 'href' => url('/partenaires'), 'copy' => 'Architectes, décorateurs et promoteurs.'],
                ],
            ],
            'projets/agencement-magasin' => [
                'breadcrumb' => 'Agencement magasin',
                'eyebrow' => 'Projet · Retail',
                'h1' => 'Agencement de magasin Tunisie.',
                'subtitle' => 'Vitrine, présentoirs, comptoir de caisse, mobilier de présentation, habillage mural : nous concevons et fabriquons l’agencement de votre boutique ou de votre commerce.',
                'cta' => 'Demander un devis',
                'heroImage' => $restaurantImage,
                'title' => 'Agencement magasin et boutique sur mesure en Tunisie',
                'metaDescription' => 'Agencement de magasin et boutique en Tunisie. Vitrine, présentoirs, comptoir, étagères sur mesure. Bois, métal, aluminium. Devis gratuit sous 48h.',
                'proofs' => [
                    ['label' => 'Conception & fabrication', 'icon' => 'fa-solid fa-drafting-compass'],
                    ['label' => 'Bois + métal + alu vitrine', 'icon' => 'fa-solid fa-layer-group'],
                    ['label' => 'Adapté au retail', 'icon' => 'fa-solid fa-store'],
                    ['label' => 'Pose avant ouverture', 'icon' => 'fa-solid fa-calendar-check'],
                ],
                'issue' => [
                    'eyebrow' => 'L’enjeu commercial',
                    'h2' => 'Un espace bien agencé vend plus. Ce n’est pas un avis, c’est une mécanique.',
                    'paragraphs' => [
                        'La disposition d’une boutique influence directement le parcours client, le temps qu’il passe dans l’espace et ce qu’il voit ou ne voit pas.',
                        'Un présentoir mal placé, une vitrine qui ne valorise pas les produits, un comptoir qui bloque la circulation : ce sont des ventes perdues chaque jour.',
                        'En Tunisie, le marché du retail devient de plus en plus exigeant. Les consommateurs comparent avec ce qu’ils voient en ligne et avec les standards internationaux.',
                        'Un espace soigné et cohérent donne immédiatement confiance dans la marque et dans les produits.',
                    ],
                ],
                'scope' => [
                    'eyebrow' => 'Notre gamme retail',
                    'h2' => 'De la vitrine au comptoir, tout l’agencement de votre commerce.',
                    'items' => [
                        ['title' => 'La vitrine', 'copy' => 'La première impression depuis la rue. Cadre aluminium ou bois, vitrages, éclairage intégré. Elle doit attirer le regard et donner envie d’entrer.', 'image' => $aluImage, 'icon' => 'fa-regular fa-window-maximize'],
                        ['title' => 'Les présentoirs', 'copy' => 'Présentoirs pour vêtements, chaussures, bijoux, cosmétiques, alimentation ou autre. En bois, métal ou mixte, aux dimensions adaptées à vos produits et à votre surface.', 'image' => $woodImage, 'icon' => 'fa-solid fa-table-cells-large'],
                        ['title' => 'Le comptoir de caisse', 'copy' => 'Zone de finalisation de l’achat, ergonomique pour vos vendeurs, pensée pour l’achat impulsif et cohérente avec votre identité de marque.', 'image' => $restaurantImage, 'icon' => 'fa-solid fa-cash-register'],
                        ['title' => 'Étagères murales et rangements', 'copy' => 'Étagères filantes, casiers de réserve, habillage de piliers. Chaque centimètre de mur peut servir la présentation.', 'image' => $dressingImage, 'icon' => 'fa-solid fa-boxes-stacked'],
                        ['title' => 'Habillage mural et finitions', 'copy' => 'Panneaux décoratifs, niches d’éclairage, signalétique intégrée, plafonds habillés. L’ambiance se construit autant dans les détails que dans les grandes pièces.', 'image' => $customImage, 'icon' => 'fa-solid fa-wand-magic-sparkles'],
                    ],
                ],
                'audiences' => [
                    'eyebrow' => 'Pour qui',
                    'h2' => 'Des commerces qui ont besoin de vendre mieux, pas seulement de remplir un local.',
                    'items' => [
                        ['title' => 'Boutique mode et accessoires', 'copy' => 'Portants, tables de pliage, vitrines, étagères chaussures, cabines d’essayage habillées, comptoir de caisse intégré.', 'icon' => 'fa-solid fa-shirt'],
                        ['title' => 'Pharmacie et parapharmacie', 'copy' => 'Linéaires de présentation, comptoir de conseil, zone de caisse sécurisée, rangements de réserve.', 'icon' => 'fa-solid fa-prescription-bottle-medical'],
                        ['title' => 'Épicerie fine et alimentaire', 'copy' => 'Étagères de présentation, réfrigérateurs intégrés, comptoir de dégustation, mobilier de service adapté aux normes d’hygiène.', 'icon' => 'fa-solid fa-basket-shopping'],
                        ['title' => 'Franchise et concept en chaîne', 'copy' => 'Si vous ouvrez plusieurs points de vente, nous reproduisons les mêmes éléments avec une cohérence visuelle parfaite d’une implantation à l’autre.', 'icon' => 'fa-solid fa-store'],
                    ],
                ],
                'process' => [
                    ['step' => '01', 'title' => 'Brief concept', 'copy' => 'Vous nous présentez votre marque, vos produits, votre clientèle cible et votre budget. Nous visitons le local.'],
                    ['step' => '02', 'title' => 'Conception & devis', 'copy' => 'Plans d’agencement, choix des matériaux et finitions cohérents avec votre identité. Devis détaillé sous 48h.'],
                    ['step' => '03', 'title' => 'Fabrication', 'copy' => 'Fabrication en atelier selon votre planning d’ouverture.'],
                    ['step' => '04', 'title' => 'Pose & ouverture', 'copy' => 'Installation par notre équipe. Nous terminons avant votre ouverture, garantie active.'],
                ],
                'faqs' => [
                    ['q' => 'Quel est le coût d’un agencement de boutique en Tunisie ?', 'a' => 'Un agencement de boutique de 50 à 100m², vitrine + présentoirs + comptoir, représente généralement un budget de 15 000 à 45 000 DT selon les finitions et le niveau d’équipement. Devis personnalisé.'],
                    ['q' => 'Travaillez-vous avec les franchises ?', 'a' => 'Oui. Nous pouvons reproduire un concept sur plusieurs implantations avec une cohérence garantie.'],
                    ['q' => 'Pouvez-vous intégrer un éclairage de mise en valeur ?', 'a' => 'Oui. LED intégrées dans les présentoirs, l’éclairage de vitrine et les niches murales sont planifiées lors de la conception et intégrées dans la fabrication.'],
                ],
                'finalCta' => ['h2' => 'Vous ouvrez ou rénovez une boutique ?', 'subtitle' => 'Visite et brief gratuits. Devis sous 48h.', 'label' => 'Demander un devis'],
                'internalLinks' => [
                    ['title' => 'Menuiserie bois', 'href' => url('/menuiserie-bois'), 'copy' => 'Présentoirs, comptoirs, rangements.'],
                    ['title' => 'Aluminium', 'href' => url('/aluminium'), 'copy' => 'Vitrines et devantures.'],
                    ['title' => 'Agencement café & restaurant', 'href' => url('/projets/agencement-cafe-restaurant'), 'copy' => 'CHR et terrasse.'],
                    ['title' => 'Agencement bureau entreprise', 'href' => url('/projets/agencement-bureau-entreprise'), 'copy' => 'Accueil, bureaux, open space.'],
                ],
            ],
            'projets/amenagement-villa-maison' => [
                'breadcrumb' => 'Aménagement villa & maison',
                'eyebrow' => 'Projet · Villa & maison',
                'h1' => 'Aménagement intégral de villa et maison Tunisie.',
                'subtitle' => 'Vous construisez ou rénovez votre villa ou votre maison. Vous avez besoin d’un cuisiniste, d’un menuisier aluminium, d’un ferronnier. Chez Maison216, ces trois métiers sont dans le même atelier. Un seul devis, un seul planning, un seul interlocuteur du premier rendez-vous à la remise des clés de votre intérieur.',
                'cta' => 'Demander un devis',
                'heroImage' => $customImage,
                'title' => 'Aménagement villa et maison en Tunisie | Intégral bois, alu, métal',
                'metaDescription' => 'Aménagement intégral de villa et maison en Tunisie. Cuisine, dressings, fenêtres, portail, pergola. Un seul atelier. Un seul devis. Devis sous 48h.',
                'proofs' => [
                    ['label' => 'Bois + aluminium + métal', 'icon' => 'fa-solid fa-layer-group'],
                    ['label' => 'Un seul interlocuteur', 'icon' => 'fa-solid fa-user-check'],
                    ['label' => 'Du devis à la pose', 'icon' => 'fa-solid fa-clipboard-check'],
                    ['label' => 'Planning coordonné', 'icon' => 'fa-solid fa-calendar-check'],
                ],
                'issue' => [
                    'eyebrow' => 'Notre différence',
                    'h2' => 'Aménager une villa, c’est coordonner trois corps de métier. Ou un seul.',
                    'paragraphs' => [
                        'Une villa ou une grande maison nécessite des interventions sur trois domaines distincts : la menuiserie bois, la menuiserie aluminium et la fabrication métallique.',
                        'La plupart des propriétaires gèrent ces trois corps de métier séparément : trois devis, trois négociations, trois plannings qui se chevauchent, trois SAV différents si quelque chose ne va pas.',
                        'Chez Maison216, ces trois métiers coexistent dans le même atelier. Vous avez un seul interlocuteur qui connaît l’ensemble de votre projet et coordonne toutes les fabrications et toutes les poses.',
                        'C’est ce que personne d’autre ne peut vous proposer en Tunisie.',
                    ],
                ],
                'scope' => [
                    'eyebrow' => 'Notre périmètre villa',
                    'h2' => 'De l’intérieur à l’extérieur, tout l’aménagement de votre propriété.',
                    'items' => [
                        ['title' => 'Cuisine équipée', 'copy' => 'Cuisine sur mesure aux dimensions exactes de votre pièce. Plans 3D, choix des matériaux et finitions, électroménager intégré, plan de travail, pose.', 'image' => $kitchenImage, 'icon' => 'fa-solid fa-kitchen-set', 'href' => url('/sur-mesure/cuisine-sur-mesure')],
                        ['title' => 'Dressings et placards', 'copy' => 'Dressing de chambre principale, dressings enfants, placards d’entrée et de couloir. Du sol au plafond, optimisation maximale.', 'image' => $dressingImage, 'icon' => 'fa-solid fa-door-closed', 'href' => url('/sur-mesure/dressing-sur-mesure')],
                        ['title' => 'Fenêtres et portes aluminium', 'copy' => 'Fenêtres à rupture de pont thermique, double vitrage, toutes teintes RAL. Portes d’entrée, baies coulissantes, portes-fenêtres.', 'image' => $aluImage, 'icon' => 'fa-regular fa-window-maximize', 'href' => url('/aluminium/fenetre-aluminium')],
                        ['title' => 'Portail', 'copy' => 'Portail battant ou coulissant, fer forgé classique ou contemporain, manuel ou motorisé avec télécommande.', 'image' => $metalImage, 'icon' => 'fa-solid fa-door-open', 'href' => url('/fer-metal/portail-fer-forge')],
                        ['title' => 'Pergola', 'copy' => 'Pergola de jardin ou de terrasse, adossée ou autoportée, couverture polycarbonate, bois ou lames orientables.', 'image' => $pergolaImage, 'icon' => 'fa-solid fa-umbrella-beach', 'href' => url('/fer-metal/pergola-metallique')],
                        ['title' => 'Escalier et garde-corps', 'copy' => 'Escalier métallique avec marches bois, garde-corps de balcon, terrasse et escalier extérieur.', 'image' => $woodImage, 'icon' => 'fa-solid fa-stairs', 'href' => url('/fer-metal/escalier-metallique')],
                    ],
                ],
                'audiences' => [
                    'eyebrow' => 'Pour qui',
                    'h2' => 'Villa neuve, rénovation ou projet prescrit par architecte.',
                    'items' => [
                        ['title' => 'Villa neuve en finition', 'copy' => 'Le gros œuvre est terminé. Il faut équiper l’intérieur et l’extérieur. Nous intervenons sur une base propre et coordonnons tout en une seule opération.', 'icon' => 'fa-solid fa-house-chimney'],
                        ['title' => 'Villa existante en rénovation', 'copy' => 'Cuisine à refaire, fenêtres à remplacer, portail à reprendre, pergola à ajouter. Chaque poste peut être séparé ou groupé.', 'icon' => 'fa-solid fa-hammer'],
                        ['title' => 'Villa haut de gamme', 'copy' => 'Votre architecte ou décorateur nous prescrit pour la fabrication. Respect des plans, matériaux spécifiés, délais de chantier.', 'icon' => 'fa-solid fa-compass-drafting'],
                    ],
                ],
                'process' => [
                    ['step' => '01', 'title' => 'Visite complète', 'copy' => 'Nous visitons toute la villa, mesurons chaque espace à équiper et dressons la liste complète des besoins par corps de métier.'],
                    ['step' => '02', 'title' => 'Devis intégral', 'copy' => 'Un seul devis qui couvre l’ensemble des postes avec un phasage de fabrication et de pose cohérent.'],
                    ['step' => '03', 'title' => 'Fabrication coordonnée', 'copy' => 'Fabrication dans nos ateliers bois, aluminium et métal selon un planning aligné sur votre calendrier de chantier.'],
                    ['step' => '04', 'title' => 'Pose phasée', 'copy' => 'Alu d’abord si applicable, puis bois intérieur, puis finitions extérieures. Garantie atelier active sur l’ensemble.'],
                ],
                'faqs' => [
                    ['q' => 'Pouvez-vous vraiment tout faire dans un seul devis ?', 'a' => 'Oui. Cuisine, dressings, fenêtres alu, portail, pergola, garde-corps, escalier : tout est chiffré dans un seul document. Vous avez la visibilité sur l’ensemble du budget avant de vous engager poste par poste.'],
                    ['q' => 'Dans quel ordre se fait la pose ?', 'a' => 'L’ordre standard : fenêtres et portes en premier, puis cuisine et mobilier intérieur, puis portail et ouvrages extérieurs. Nous planifions cet ordre avec votre entrepreneur principal.'],
                    ['q' => 'Quel est le budget pour l’aménagement complet d’une villa ?', 'a' => 'Pour une villa de taille moyenne, 300-500m², un aménagement complet cuisine + dressings + fenêtres + portail + pergola représente généralement entre 60 000 et 200 000 DT selon le niveau de finition et les options choisies.'],
                    ['q' => 'Travaillez-vous avec les architectes et les décorateurs ?', 'a' => 'Oui. Nous travaillons avec les architectes sur une base technique stricte : respect des plans, coordination chantier et qualité d’exécution. Les autres professionnels peuvent passer par notre espace professionnels.'],
                ],
                'finalCta' => ['h2' => 'Vous aménagez votre villa ou votre maison ?', 'subtitle' => 'Visite complète gratuite, devis intégral sous 48h.', 'label' => 'Demander un devis villa'],
                'internalLinks' => [
                    ['title' => 'Cuisine sur mesure', 'href' => url('/sur-mesure/cuisine-sur-mesure'), 'copy' => 'Cuisine équipée et plans 3D.'],
                    ['title' => 'Dressing sur mesure', 'href' => url('/sur-mesure/dressing-sur-mesure'), 'copy' => 'Suite parentale et chambres.'],
                    ['title' => 'Fenêtre aluminium', 'href' => url('/aluminium/fenetre-aluminium'), 'copy' => 'RPT, double vitrage, pose.'],
                    ['title' => 'Portail fer forgé', 'href' => url('/fer-metal/portail-fer-forge'), 'copy' => 'Battant, coulissant, motorisé.'],
                    ['title' => 'Pergola métallique', 'href' => url('/fer-metal/pergola-metallique'), 'copy' => 'Terrasse et jardin.'],
                    ['title' => 'Volet roulant', 'href' => url('/aluminium/volet-roulant'), 'copy' => 'Manuel ou motorisé.'],
                    ['title' => 'Garde-corps', 'href' => url('/fer-metal/garde-corps'), 'copy' => 'Balcon, terrasse, escalier.'],
                    ['title' => 'Espace professionnels', 'href' => url('/partenaires'), 'copy' => 'Architectes, décorateurs et promoteurs.'],
                ],
            ],
            'projets/amenagement-exterieur' => [
                'breadcrumb' => 'Aménagement extérieur',
                'eyebrow' => 'Projet · Extérieur',
                'h1' => 'Aménagement extérieur Tunisie.',
                'subtitle' => 'Votre espace extérieur mérite autant d’attention que votre intérieur. Pergola de terrasse, portail d’entrée, garde-corps de balcon, brise-soleil de façade : nous fabriquons tous vos ouvrages extérieurs.',
                'cta' => 'Demander un devis',
                'heroImage' => $pergolaImage,
                'title' => 'Aménagement extérieur sur mesure en Tunisie | Pergola, portail, garde-corps',
                'metaDescription' => 'Aménagement extérieur sur mesure en Tunisie. Pergola, portail, garde-corps, brise-soleil, volet roulant. Métal thermolaqué, aluminium traité. Devis sous 48h.',
                'proofs' => [
                    ['label' => 'Sur mesure', 'icon' => 'fa-solid fa-ruler-combined'],
                    ['label' => 'Pose & SAV inclus', 'icon' => 'fa-solid fa-screwdriver-wrench'],
                    ['label' => 'Rapidité', 'icon' => 'fa-solid fa-bolt'],
                    ['label' => 'Traitement extérieur', 'icon' => 'fa-solid fa-shield-halved'],
                ],
                'issue' => [
                    'eyebrow' => 'Le contexte',
                    'h2' => 'En Tunisie, l’extérieur subit des conditions difficiles. Les ouvrages doivent être faits pour ça.',
                    'paragraphs' => [
                        'Un ouvrage extérieur en Tunisie fait face à des conditions que beaucoup de matériaux et de traitements ne supportent pas : ensoleillement intense, variations de température, air salin des régions côtières et vents de sirocco.',
                        'Tous nos ouvrages extérieurs sont traités pour durer dans ces conditions : acier décapé, primaire zinc, thermolaquage four. Aluminium anodisé ou thermolaqué.',
                        'Ce n’est pas une option, c’est notre standard.',
                    ],
                ],
                'scope' => [
                    'eyebrow' => 'Nos ouvrages extérieurs',
                    'h2' => 'De la clôture au brise-soleil, tout l’extérieur de votre propriété.',
                    'items' => [
                        ['title' => 'Portail & portillon', 'copy' => 'Portail battant ou coulissant, manuel ou motorisé. Fer forgé classique, pleine tôle contemporain ou semi-ajouré. Portillon assorti fabriqué en même temps.', 'image' => $metalImage, 'icon' => 'fa-solid fa-door-open', 'href' => url('/fer-metal/portail-fer-forge')],
                        ['title' => 'Clôture et grillage', 'copy' => 'Clôture en fer forgé ou en métal laqué pour délimiter votre propriété en cohérence avec le style du portail.', 'image' => $metalImage, 'icon' => 'fa-solid fa-grip-lines'],
                        ['title' => 'Pergola et couverture de terrasse', 'copy' => 'Pergola adossée ou autoportée, couverture polycarbonate, bois ou lames orientables. Pour jardins, terrasses et espaces extérieurs commerciaux.', 'image' => $pergolaImage, 'icon' => 'fa-solid fa-umbrella-beach', 'href' => url('/fer-metal/pergola-metallique')],
                        ['title' => 'Garde-corps extérieur', 'copy' => 'Garde-corps de balcon, terrasse, toiture-terrasse et escalier extérieur. Métal thermolaqué, inox pour zones exposées à l’air salin.', 'image' => $aluImage, 'icon' => 'fa-solid fa-shield-halved', 'href' => url('/fer-metal/garde-corps')],
                        ['title' => 'Brise-soleil de façade', 'copy' => 'Lames aluminium fixes ou orientables sur les façades très exposées. Réduit la chaleur sans bloquer la lumière ni la vue.', 'image' => $aluImage, 'icon' => 'fa-solid fa-sun', 'href' => url('/aluminium/brise-soleil')],
                        ['title' => 'Volets roulants', 'copy' => 'Manuel ou motorisé, pour toutes les ouvertures de la façade.', 'image' => $shutterImage, 'icon' => 'fa-solid fa-window-maximize', 'href' => url('/aluminium/volet-roulant')],
                        ['title' => 'Escalier extérieur', 'copy' => 'Accès entre deux niveaux extérieurs, terrasse surélevée, toiture-terrasse. Métal traité avec marches antidérapantes ou en bois traité.', 'image' => $woodImage, 'icon' => 'fa-solid fa-stairs', 'href' => url('/fer-metal/escalier-metallique')],
                    ],
                ],
                'advantage' => [
                    'eyebrow' => 'Durabilité',
                    'h2' => 'Un ouvrage extérieur bien traité dure 20 ans. Un mal traité dure 3 ans.',
                    'paragraphs' => [
                        'La durabilité d’un ouvrage extérieur ne dépend pas du matériau, elle dépend du traitement de surface.',
                        'Notre processus sur tous les ouvrages acier : décapage chimique, dégraissage, primaire de protection au zinc, thermolaquage cuit en cabine four à 200°C.',
                        'Pour les zones très exposées à l’air salin, bord de mer ou zone côtière, nous recommandons en plus une galvanisation à chaud du support.',
                        'Nos ouvrages aluminium sont anodisés ou thermolaqués : l’aluminium ne rouille pas, mais un mauvais traitement peut faire tacher et oxyder la surface.',
                    ],
                ],
                'audiences' => [
                    'eyebrow' => 'Pour qui',
                    'h2' => 'Particuliers, cafés/restaurants, promoteurs immobiliers.',
                    'items' => [
                        ['title' => 'Particuliers', 'copy' => 'Portail d’entrée, garde-corps de balcon, pergola de jardin, clôture, brise-soleil de façade. Tout l’extérieur de votre propriété dans un seul projet coordonné.', 'icon' => 'fa-solid fa-house-chimney'],
                        ['title' => 'Cafés et restaurants', 'copy' => 'Pergola de terrasse, garde-corps de mezzanine extérieure, structure de signalétique extérieure.', 'icon' => 'fa-solid fa-utensils'],
                        ['title' => 'Promoteurs immobiliers', 'copy' => 'Portails et clôtures de programmes résidentiels, garde-corps de balcons en série, livraisons phasées selon l’avancement du chantier.', 'icon' => 'fa-solid fa-building'],
                    ],
                ],
                'process' => [
                    ['step' => '01', 'title' => 'Visite & conseil', 'copy' => 'Nous évaluons les ouvrages à réaliser, les contraintes du terrain et du sol, et conseillons sur les matériaux selon l’exposition.'],
                    ['step' => '02', 'title' => 'Devis sous 48h', 'copy' => 'Chiffrage par ouvrage, délai de fabrication par poste, devis global ou par lot.'],
                    ['step' => '03', 'title' => 'Fabrication', 'copy' => 'Acier ou aluminium traités en atelier. Contrôle qualité avant livraison.'],
                    ['step' => '04', 'title' => 'Pose', 'copy' => 'Installation par notre équipe, scellements, motorisation si applicable. Garantie atelier active.'],
                ],
                'faqs' => [
                    ['q' => 'Vos ouvrages extérieurs résistent-ils en bord de mer ?', 'a' => 'Oui, avec le bon traitement. Pour les propriétés en zone côtière, nous appliquons un traitement galvanisé avant thermolaquage pour l’acier et recommandons l’inox 316 pour les fixations aluminium.'],
                    ['q' => 'Peut-on motoriser un portail existant ?', 'a' => 'Oui dans la plupart des cas. Une visite technique permet d’évaluer la compatibilité et l’état structural.'],
                    ['q' => 'Peut-on faire portail + pergola + garde-corps dans un seul devis ?', 'a' => 'Oui. C’est même recommandé pour coordonner les finitions et la cohérence esthétique entre les ouvrages.'],
                    ['q' => 'Quel est le délai pour un aménagement extérieur complet ?', 'a' => 'Comptez 3 à 6 semaines selon le volume d’ouvrages. Chaque poste a son délai précisé dans le devis.'],
                ],
                'finalCta' => ['h2' => 'Un projet d’aménagement extérieur ?', 'subtitle' => 'Visite gratuite, devis sous 48h.', 'label' => 'Demander un devis', 'secondaryLabel' => 'telephone'],
                'internalLinks' => [
                    ['title' => 'Portail fer forgé', 'href' => url('/fer-metal/portail-fer-forge'), 'copy' => 'Entrée, clôture, motorisation.'],
                    ['title' => 'Pergola métallique', 'href' => url('/fer-metal/pergola-metallique'), 'copy' => 'Terrasse et jardin.'],
                    ['title' => 'Garde-corps métallique', 'href' => url('/fer-metal/garde-corps'), 'copy' => 'Balcon, terrasse, escalier.'],
                    ['title' => 'Brise-soleil', 'href' => url('/aluminium/brise-soleil'), 'copy' => 'Façades exposées.'],
                    ['title' => 'Volet roulant', 'href' => url('/aluminium/volet-roulant'), 'copy' => 'Ouvertures de façade.'],
                    ['title' => 'Escalier métallique', 'href' => url('/fer-metal/escalier-metallique'), 'copy' => 'Accès extérieurs.'],
                    ['title' => 'Aménagement villa & maison', 'href' => url('/projets/amenagement-villa-maison'), 'copy' => 'Projet global intérieur/extérieur.'],
                ],
            ],
        ];
    }
}
