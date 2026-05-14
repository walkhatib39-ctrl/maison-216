@extends('layouts.store')

@php
    $devisUrl = url('/devis');
    $contactUrl = route('contact');
    $whatsappUrl = \App\Support\SiteSettings::whatsappUrl() ?? $contactUrl;

    $heroImage = asset('assets/home/amenagement-sur-mesure.jpg');
    $boisImage = asset('assets/home/menuiserie-bois.webp');
    $kitchenImage = asset('assets/home/realizations/cuisine-sur-mesure.jpg');
    $dressingImage = asset('assets/home/realizations/dressing-sur-mesure.jpg');
    $restaurantImage = asset('assets/home/realizations/amenagement-restaurant.jpg');

    $pages = [
        'kitchen' => [
            'path' => 'sur-mesure/cuisine-sur-mesure',
            'name' => 'Cuisine sur mesure',
            'eyebrow' => 'Sur mesure · Cuisine',
            'h1' => 'Cuisine sur mesure en Tunisie.',
            'h1Accent' => 'Fabriquée dans notre atelier. Posée par notre équipe.',
            'intro' => 'Pas un kit importé. Pas un catalogue à taille fixe. Une cuisine conçue pour vos dimensions exactes, dans les matériaux que vous choisissez, fabriquée dans notre atelier bois en Tunisie et posée par nos menuisiers. Linéaire, en L, en U ou avec îlot : devis gratuit sous 48h.',
            'primaryCta' => 'Demander un devis cuisine',
            'secondaryCta' => 'Voir nos réalisations',
            'heroImage' => $kitchenImage,
            'proofs' => ['Plans 3D inclus', 'Fabrication interne', 'Pose & SAV inclus', 'Devis sous 48h'],
            'band' => [
                ['value' => 'Cotes au millimètre', 'label' => 'Chaque meuble suit vos murs, angles et contraintes.', 'icon' => 'fa-solid fa-ruler-combined'],
                ['value' => 'Plans 3D', 'label' => 'Visualisation avant fabrication.', 'icon' => 'fa-solid fa-cube'],
                ['value' => 'Quincaillerie premium', 'label' => 'Ouvertures fluides, durables, bien réglées.', 'icon' => 'fa-solid fa-gears'],
                ['value' => 'Garantie atelier', 'label' => 'Pose et SAV suivis par notre équipe.', 'icon' => 'fa-solid fa-shield-halved'],
            ],
            'contextEyebrow' => 'Pourquoi le sur mesure',
            'contextTitle' => 'Une cuisine standard occupe votre espace. Une cuisine sur mesure le révèle.',
            'contextIntro' => 'Le sur mesure ne part pas du module, il part de votre pièce : longueur exacte, plafond, fenêtre, niche, pilier, évacuations et habitudes de cuisine.',
            'benefits' => [
                ['title' => 'Chaque centimètre compte', 'copy' => 'Les angles, niches, hauteurs et espaces résiduels deviennent du rangement utile au lieu de rester perdus.'],
                ['title' => 'Elle dure vraiment longtemps', 'copy' => 'Panneaux, chants, charnières, coulisses et pose déterminent la durée de vie réelle de la cuisine.'],
                ['title' => 'Elle est vraiment à vous', 'copy' => 'Façades, plan de travail, poignées, hauteurs, four, évier et rangements suivent vos habitudes.'],
            ],
            'configsEyebrow' => 'Les configurations',
            'configsTitle' => 'Quelle forme pour votre cuisine ?',
            'configsIntro' => 'La configuration dépend d’abord de la forme de votre espace et du triangle de circulation entre cuisson, évier et froid.',
            'configs' => [
                ['title' => 'Cuisine linéaire', 'copy' => 'Tous les éléments sur un seul mur. Simple, efficace, économique, idéale pour studios et espaces ouverts.'],
                ['title' => 'Cuisine en L', 'copy' => 'Deux murs adjacents, plus de plan de travail et un angle à optimiser correctement.'],
                ['title' => 'Cuisine en U', 'copy' => 'Trois murs équipés pour maximiser rangements et surface de préparation dans une grande cuisine.'],
                ['title' => 'Cuisine avec îlot', 'copy' => 'Plan central pour préparer, manger ou ranger, à prévoir avec assez de circulation autour.'],
                ['title' => 'Cuisine ouverte', 'copy' => 'Visible depuis le séjour : esthétique, hotte, alignements et finitions deviennent essentiels.'],
            ],
            'detailsEyebrow' => 'Matériaux & usage',
            'detailsTitle' => 'Les bons matériaux aux bons endroits.',
            'detailsIntro' => 'Une cuisine est l’aménagement le plus sollicité de la maison. Les matériaux doivent être choisis selon humidité, chaleur, nettoyage, budget et rendu attendu.',
            'details' => [
                ['title' => 'Mélaminé', 'copy' => 'Bon rapport qualité-prix pour carcasses et projets sobres, avec nombreux décors disponibles.'],
                ['title' => 'MDF laqué', 'copy' => 'Façade lisse, mate ou brillante, pour un rendu contemporain plus haut de gamme.'],
                ['title' => 'Plaqué bois', 'copy' => 'Aspect naturel chêne, noyer ou hêtre, chaleureux sans le prix du massif complet.'],
                ['title' => 'Plans de travail', 'copy' => 'Granit, quartz, céramique ou stratifié HPL selon budget, chaleur, rayures et rendu souhaité.'],
                ['title' => 'Électroménager', 'copy' => 'Nous intégrons four, plaques, hotte, lave-vaisselle, frigo ou éclairage selon les dimensions choisies.'],
            ],
            'process' => [
                ['step' => '01', 'title' => 'Visite technique', 'copy' => 'Prise de cotes, contraintes, arrivées d’eau, évacuations, prises, fenêtre et circulation.'],
                ['step' => '02', 'title' => 'Plans 3D & choix', 'copy' => 'Visualisation de la cuisine, choix des façades, plans de travail, poignées et rangements.'],
                ['step' => '03', 'title' => 'Devis détaillé', 'copy' => 'Chiffrage poste par poste : carcasses, façades, quincaillerie, plan de travail et pose.'],
                ['step' => '04', 'title' => 'Fabrication atelier', 'copy' => 'Lancement après validation, fabrication dans notre atelier bois et contrôle avant pose.'],
                ['step' => '05', 'title' => 'Pose & mise en service', 'copy' => 'Pose, niveaux, plan de travail, réglages d’ouvertures et réception.'],
            ],
            'faqTitle' => 'Vos questions sur la cuisine sur mesure.',
            'faqs' => [
                ['q' => 'Quel est le prix d’une cuisine sur mesure en Tunisie ?', 'a' => 'Le prix dépend des mètres linéaires, matériaux, plan de travail, quincaillerie, accessoires et contraintes de pose. Nous établissons un devis détaillé après visite technique.'],
                ['q' => 'Quelle différence entre cuisine sur mesure et cuisine en kit ?', 'a' => 'La cuisine en kit force votre espace à entrer dans des modules fixes. Le sur mesure découpe les meubles aux dimensions exactes de votre cuisine.'],
                ['q' => 'Combien de temps prend la fabrication ?', 'a' => 'Le délai dépend du volume, des finitions et du plan de travail. Il est annoncé dans le devis après validation.'],
                ['q' => 'Faites-vous les plans 3D avant fabrication ?', 'a' => 'Oui. Les plans 3D permettent de valider la disposition et les choix avant lancement atelier.'],
                ['q' => 'Livrez-vous et posez-vous partout en Tunisie ?', 'a' => 'Oui sur les principales villes, avec frais de déplacement précisés dans le devis si nécessaire.'],
                ['q' => 'Quelle garantie sur la cuisine ?', 'a' => 'Garantie atelier sur fabrication et pose, et garantie fabricant sur la quincaillerie ou composants tiers.'],
                ['q' => 'Travaillez-vous avec architectes et promoteurs ?', 'a' => 'Oui : cuisines en lots, phasage chantier, plans et interlocuteur dédié selon volume.'],
                ['q' => 'Gérez-vous plomberie et électricité ?', 'a' => 'Nous posons la cuisine et coordonnons les besoins. Les modifications techniques lourdes sont à prévoir avec les corps de métier adaptés.'],
            ],
            'finalTitle' => 'Un projet de cuisine sur mesure ?',
            'finalSubtitle' => 'Visite technique gratuite, plans 3D et devis sous 48h pour une demande complète.',
            'serviceType' => 'Cuisine sur mesure',
        ],
        'dressing' => [
            'path' => 'sur-mesure/dressing-sur-mesure',
            'name' => 'Dressing sur mesure',
            'eyebrow' => 'Sur mesure · Dressing',
            'h1' => 'Dressing sur mesure en Tunisie.',
            'h1Accent' => 'Chaque vêtement à sa place. Chaque centimètre utilisé.',
            'intro' => 'Un dressing sur mesure n’est pas une armoire plus grande. C’est un rangement conçu autour de vos vêtements, vos chaussures, vos accessoires et votre façon de vous habiller. Fabriqué aux dimensions exactes de votre espace, posé par notre équipe.',
            'primaryCta' => 'Demander un devis dressing',
            'secondaryCta' => 'Voir nos réalisations',
            'heroImage' => $dressingImage,
            'proofs' => ['Plans 3D inclus', 'Intérieur personnalisé', 'Fabrication interne', 'Pose & SAV inclus'],
            'band' => [
                ['value' => 'Cotes au millimètre', 'label' => 'D’un mur à l’autre, du sol au plafond.', 'icon' => 'fa-solid fa-ruler-combined'],
                ['value' => 'Pleine hauteur', 'label' => 'Valises, duvets et rangements saisonniers.', 'icon' => 'fa-solid fa-up-long'],
                ['value' => 'Portes au choix', 'label' => 'Battantes, coulissantes ou dressing ouvert.', 'icon' => 'fa-solid fa-door-open'],
                ['value' => 'Garantie atelier', 'label' => 'Rails, réglages, pose et suivi.', 'icon' => 'fa-solid fa-shield-halved'],
            ],
            'contextEyebrow' => 'Pourquoi le sur mesure',
            'contextTitle' => 'Un dressing standard range vos vêtements. Un dressing sur mesure organise votre quotidien.',
            'contextIntro' => 'Le sur mesure utilise exactement l’espace disponible, y compris hauteur, niches, angles, combles, couloirs et murs irréguliers.',
            'benefits' => [
                ['title' => 'Zéro espace perdu', 'copy' => 'Le haut, les angles, les niches et les espaces résiduels deviennent du rangement réel.'],
                ['title' => 'Organisé pour vous', 'copy' => 'Robes longues, costumes, chaussures, sacs, bijoux : l’intérieur dépend de ce que vous rangez vraiment.'],
                ['title' => 'Adapté aux espaces impossibles', 'copy' => 'Sous combles, niche, couloir, angle de chambre ou suite parentale.'],
            ],
            'configsEyebrow' => 'Les configurations',
            'configsTitle' => 'Quelle forme selon votre espace ?',
            'configsIntro' => 'Le bon dressing dépend de la pièce, du recul disponible et du volume à ranger.',
            'configs' => [
                ['title' => 'Dressing linéaire', 'copy' => 'Un seul mur équipé, efficace avec portes coulissantes dans une chambre standard.'],
                ['title' => 'Dressing en L', 'copy' => 'Deux murs en angle, plus de capacité avec un coin traité intelligemment.'],
                ['title' => 'Dressing en U', 'copy' => 'Trois murs équipés pour suite parentale ou pièce dressing dédiée.'],
                ['title' => 'Sous combles', 'copy' => 'Modules de hauteurs variables qui suivent la pente et récupèrent l’espace mort.'],
                ['title' => 'Niche ou couloir', 'copy' => 'Un espace étroit devient un rangement discret et utile.'],
            ],
            'detailsEyebrow' => 'L’intérieur du dressing',
            'detailsTitle' => 'C’est l’intérieur qui fait la différence. Pas juste la porte.',
            'detailsIntro' => 'Un dressing réussi commence par l’inventaire : combien de penderie, tiroirs, chaussures, accessoires et rangements hauts.',
            'details' => [
                ['title' => 'Penderies', 'copy' => 'Simple ou double hauteur selon robes, chemises, costumes, manteaux et pantalons.'],
                ['title' => 'Étagères', 'copy' => 'Fixes ou réglables pour pulls, sacs, jeans, linge et boîtes.'],
                ['title' => 'Tiroirs', 'copy' => 'Sous-vêtements, bijoux, chaussettes, accessoires et petits objets.'],
                ['title' => 'Porte-chaussures', 'copy' => 'Étagères horizontales ou inclinées, profondeur adaptée aux pointures.'],
                ['title' => 'Miroir & LED', 'copy' => 'Miroir pleine hauteur et éclairage intérieur selon besoin et arrivée électrique.'],
            ],
            'process' => [
                ['step' => '01', 'title' => 'Visite & mesures', 'copy' => 'Cotes exactes, contraintes, inventaire de vos besoins et volumes à ranger.'],
                ['step' => '02', 'title' => 'Plans 3D', 'copy' => 'Visualisation du dressing et de l’aménagement intérieur avant validation.'],
                ['step' => '03', 'title' => 'Devis sous 48h', 'copy' => 'Structure, portes, accessoires, pose et finitions détaillés.'],
                ['step' => '04', 'title' => 'Fabrication atelier', 'copy' => 'Découpe aux cotes et préparation des portes, caissons et accessoires.'],
                ['step' => '05', 'title' => 'Pose', 'copy' => 'Calage, réglage des portes, rails, niveaux et réception.'],
            ],
            'faqTitle' => 'Vos questions sur le dressing sur mesure.',
            'faqs' => [
                ['q' => 'Quel est le prix d’un dressing sur mesure en Tunisie ?', 'a' => 'Le prix dépend des dimensions, portes, matériaux, tiroirs, accessoires et éclairage. Le devis sur visite permet d’éviter les estimations trompeuses.'],
                ['q' => 'Dressing sur mesure ou armoire standard ?', 'a' => 'L’armoire suffit si l’espace est standard et le budget serré. Le sur mesure devient supérieur dès qu’il y a hauteur, niche, angle, couloir ou besoin d’organisation précise.'],
                ['q' => 'Combien de temps prend la fabrication ?', 'a' => 'Le délai dépend de la taille et des finitions. Il est annoncé dans le devis après validation des plans.'],
                ['q' => 'Peut-on modifier l’intérieur après la pose ?', 'a' => 'Les étagères réglables et certains accessoires peuvent évoluer. Les cloisons fixes nécessitent une intervention.'],
                ['q' => 'Faites-vous des dressings enfant ?', 'a' => 'Oui, avec éléments réglables et conception qui peut évoluer avec l’âge.'],
                ['q' => 'Peut-on intégrer un miroir pleine hauteur ?', 'a' => 'Oui, dans une porte ou en panneau dédié selon configuration.'],
                ['q' => 'L’éclairage LED peut-il être intégré ?', 'a' => 'Oui si l’alimentation électrique est prévue ou compatible. Cela se vérifie lors de la visite.'],
                ['q' => 'Intervenez-vous dans toute la Tunisie ?', 'a' => 'Oui sur les principales villes, avec frais éventuels indiqués au devis.'],
            ],
            'finalTitle' => 'Un projet de dressing sur mesure ?',
            'finalSubtitle' => 'Visite technique gratuite, plans 3D et devis sous 48h pour une demande complète.',
            'serviceType' => 'Dressing sur mesure',
        ],
        'closet' => [
            'path' => 'sur-mesure/placard-sur-mesure',
            'name' => 'Placard sur mesure',
            'eyebrow' => 'Sur mesure · Placard',
            'h1' => 'Placard sur mesure en Tunisie.',
            'h1Accent' => 'L’espace perdu derrière votre porte devient du rangement utile.',
            'intro' => 'Entrée, couloir, chambre, cuisine ou sous-escalier : nous transformons chaque recoin inutilisé en placard fonctionnel, fabriqué aux dimensions exactes, avec portes et aménagement intérieur adaptés à votre usage réel.',
            'primaryCta' => 'Demander un devis placard',
            'secondaryCta' => 'Voir nos réalisations',
            'heroImage' => $heroImage,
            'proofs' => ['Fabriqué sur mesure', 'Toutes configurations', 'Portes au choix', 'Pose & SAV inclus'],
            'band' => [
                ['value' => 'Cotes exactes', 'label' => 'Niche, couloir, entrée, chambre.', 'icon' => 'fa-solid fa-ruler-combined'],
                ['value' => 'Sol au plafond', 'label' => 'Tout le volume vertical est exploité.', 'icon' => 'fa-solid fa-up-long'],
                ['value' => 'Battant ou coulissant', 'label' => 'Selon recul disponible.', 'icon' => 'fa-solid fa-door-open'],
                ['value' => 'Garantie atelier', 'label' => 'Pose, réglages et SAV.', 'icon' => 'fa-solid fa-shield-halved'],
            ],
            'contextEyebrow' => 'Placard ou dressing ?',
            'contextTitle' => 'Pas la même chose. Voici comment choisir.',
            'contextIntro' => 'Le placard est un rangement fermé dans une niche, une entrée, un couloir ou une chambre. Le dressing est un espace plus dédié aux vêtements. Les deux sont utiles, mais pas pour la même situation.',
            'benefits' => [
                ['title' => 'Moins de 1,5 m de large', 'copy' => 'Souvent, c’est un placard : simple, fermé, très efficace pour récupérer un recoin.'],
                ['title' => 'Couloir ou entrée', 'copy' => 'Portes coulissantes et profondeur maîtrisée pour ne pas gêner la circulation.'],
                ['title' => 'Sous escalier', 'copy' => 'Portes et éléments intérieurs suivent la pente pour exploiter un espace souvent perdu.'],
            ],
            'configsEyebrow' => 'Les types',
            'configsTitle' => 'Un placard pour chaque espace de votre maison.',
            'configsIntro' => 'Chaque placard doit répondre à un usage précis : entrée, linge, chambre, ménage, cuisine ou sous-escalier.',
            'configs' => [
                ['title' => 'Placard d’entrée', 'copy' => 'Manteaux, chaussures, sacs et parapluies organisés dès l’entrée.'],
                ['title' => 'Placard de chambre', 'copy' => 'Encastré dans un renfoncement, du sol au plafond, sans espace perdu.'],
                ['title' => 'Placard de couloir', 'copy' => 'Rangement linge ou ménage avec portes coulissantes pour préserver la circulation.'],
                ['title' => 'Placard sous escalier', 'copy' => 'Rangement technique, valises, linge ou ménage dans la pente.'],
                ['title' => 'Colonne de cuisine', 'copy' => 'Rangement vertical pour provisions, appareils ou matériel ménager.'],
            ],
            'detailsEyebrow' => 'Portes & intérieur',
            'detailsTitle' => 'Ce qu’on met dedans dépend de ce qu’on range.',
            'detailsIntro' => 'Le bon placard n’est pas seulement une façade propre. Il doit être organisé selon objets, profondeur, accès et fréquence d’usage.',
            'details' => [
                ['title' => 'Portes battantes', 'copy' => 'Accès total, pratique si vous avez assez d’espace devant le placard.'],
                ['title' => 'Portes coulissantes', 'copy' => 'Indispensables pour couloir, entrée ou petite chambre.'],
                ['title' => 'Miroir intégré', 'copy' => 'Agrandit visuellement et reste pratique pour chambre ou entrée.'],
                ['title' => 'Aménagement linge', 'copy' => 'Étagères, penderie, tiroirs, casiers chaussures et rangements hauts.'],
                ['title' => 'Aménagement ménager', 'copy' => 'Niche aspirateur, balai, produits lourds et accessoires.'],
            ],
            'process' => [
                ['step' => '01', 'title' => 'Visite & mesures', 'copy' => 'Cotes exactes, prises, radiateurs, irrégularités de murs et type d’ouverture.'],
                ['step' => '02', 'title' => 'Devis sous 48h', 'copy' => 'Portes, carcasse, intérieur, matériaux et pose détaillés.'],
                ['step' => '03', 'title' => 'Fabrication atelier', 'copy' => 'Découpe aux cotes exactes dans notre atelier bois.'],
                ['step' => '04', 'title' => 'Pose', 'copy' => 'Calage, fixation, pose des portes, réglages et réception.'],
            ],
            'faqTitle' => 'Vos questions sur les placards sur mesure.',
            'faqs' => [
                ['q' => 'Quel est le prix d’un placard sur mesure en Tunisie ?', 'a' => 'Il dépend des dimensions, des portes, de l’intérieur et des finitions. Le devis sur visite permet de chiffrer juste.'],
                ['q' => 'Différence entre placard sur mesure et armoire standard ?', 'a' => 'Le placard utilise tout l’espace disponible, du sol au plafond, sans vides inutiles sur les côtés ou en hauteur.'],
                ['q' => 'Peut-on faire un placard sous escalier ?', 'a' => 'Oui. Les portes et rangements sont fabriqués pour suivre la pente et les contraintes du lieu.'],
                ['q' => 'Combien de temps prend la fabrication ?', 'a' => 'Le délai dépend des dimensions et finitions. Il est annoncé dans le devis.'],
                ['q' => 'Peut-on intégrer un miroir ?', 'a' => 'Oui, pleine hauteur ou partiel, sur porte battante ou coulissante selon projet.'],
                ['q' => 'Intervenez-vous partout en Tunisie ?', 'a' => 'Oui sur les principales villes, avec frais éventuels précisés au devis.'],
            ],
            'finalTitle' => 'Un projet de placard sur mesure ?',
            'finalSubtitle' => 'Visite gratuite, devis sous 48h pour une demande complète.',
            'serviceType' => 'Placard sur mesure',
        ],
        'tv' => [
            'path' => 'sur-mesure/meuble-tv-sur-mesure',
            'name' => 'Meuble TV sur mesure',
            'eyebrow' => 'Sur mesure · Meuble TV',
            'h1' => 'Meuble TV sur mesure en Tunisie.',
            'h1Accent' => 'Votre mur de salon comme vous l’avez imaginé.',
            'intro' => 'Pas une table TV de catalogue qui déborde d’un côté et laisse un vide de l’autre. Un meuble TV sur mesure occupe exactement la largeur souhaitée, intègre rangements, hifi, câbles, LED et finitions dans un résultat propre et cohérent.',
            'primaryCta' => 'Demander un devis meuble TV',
            'secondaryCta' => 'Voir nos réalisations',
            'heroImage' => $boisImage,
            'proofs' => ['Toute largeur de mur', 'Câbles invisibles', 'LED disponible', 'Pose & SAV inclus'],
            'band' => [
                ['value' => 'Largeur exacte', 'label' => 'Mur complet ou portion définie.', 'icon' => 'fa-solid fa-ruler-horizontal'],
                ['value' => 'Suspendu ou posé', 'label' => 'Selon mur, poids et style.', 'icon' => 'fa-solid fa-tv'],
                ['value' => 'Niches & rangements', 'label' => 'Box, console, hifi, livres, déco.', 'icon' => 'fa-solid fa-border-all'],
                ['value' => 'Garantie atelier', 'label' => 'Fixations, pose et réglages.', 'icon' => 'fa-solid fa-shield-halved'],
            ],
            'contextEyebrow' => 'Pourquoi le sur mesure',
            'contextTitle' => 'Un meuble TV standard est fait pour un mur standard. Le vôtre ne l’est pas.',
            'contextIntro' => 'Votre mur a une largeur réelle, des prises existantes, une hauteur de canapé et des appareils précis. Le meuble TV sur mesure part de ces contraintes au lieu de les subir.',
            'benefits' => [
                ['title' => 'TV bien centrée', 'copy' => 'La niche TV se place selon le mur, le canapé et la hauteur de vision.'],
                ['title' => 'Câbles invisibles', 'copy' => 'Passages prévus dès la fabrication pour alimentation, box, console et hifi.'],
                ['title' => 'Rangement pensé pour vos appareils', 'copy' => 'Niches ventilées et dimensions adaptées à votre box, barre de son ou console.'],
            ],
            'configsEyebrow' => 'Les configurations',
            'configsTitle' => 'Selon votre espace et votre style.',
            'configsIntro' => 'Le meuble TV peut être discret, suspendu, pleine hauteur, avec bibliothèque ou intégré dans une niche existante.',
            'configs' => [
                ['title' => 'Suspendu flottant', 'copy' => 'Fixé au mur, léger visuellement, facilite le nettoyage et donne un rendu contemporain.'],
                ['title' => 'Posé au sol', 'copy' => 'Plus stable pour charges lourdes, livres, enceintes ou rangements profonds.'],
                ['title' => 'Pleine hauteur', 'copy' => 'Un mur entier transformé en élément architectural avec rangements hauts et niches.'],
                ['title' => 'Avec bibliothèque latérale', 'copy' => 'TV au centre, colonnes ou étagères sur un côté ou deux.'],
                ['title' => 'Dans une niche', 'copy' => 'Le meuble occupe exactement l’espace prévu dans le mur.'],
            ],
            'detailsEyebrow' => 'Options & finitions',
            'detailsTitle' => 'Les détails qui font la différence.',
            'detailsIntro' => 'Un meuble TV réussi gère lumière, câbles, proportions, accès aux appareils et finitions visibles depuis tout le salon.',
            'details' => [
                ['title' => 'Éclairage LED', 'copy' => 'Rétroéclairage derrière TV ou sous étagères, selon arrivée électrique et rendu souhaité.'],
                ['title' => 'Panneau acoustique', 'copy' => 'Option textile ou décorative pour améliorer l’acoustique et intégrer une barre de son.'],
                ['title' => 'Push sans poignée', 'copy' => 'Façades épurées avec ouverture par pression.'],
                ['title' => 'MDF laqué', 'copy' => 'Mat ou brillant pour un rendu contemporain et propre.'],
                ['title' => 'Plaqué bois', 'copy' => 'Chêne, noyer ou hêtre pour un salon chaleureux.'],
            ],
            'process' => [
                ['step' => '01', 'title' => 'Visite & mesures', 'copy' => 'Cotes du mur, prises, emplacement box, hauteur TV et nature du support.'],
                ['step' => '02', 'title' => 'Plans 3D', 'copy' => 'Visualisation des niches, dimensions, proportions et finitions.'],
                ['step' => '03', 'title' => 'Devis sous 48h', 'copy' => 'Structure, façades, LED, accessoires et pose détaillés.'],
                ['step' => '04', 'title' => 'Fabrication', 'copy' => 'Découpe et préparation en atelier bois.'],
                ['step' => '05', 'title' => 'Pose', 'copy' => 'Fixation murale ou sol, câbles, LED et réglages.'],
            ],
            'faqTitle' => 'Vos questions sur les meubles TV sur mesure.',
            'faqs' => [
                ['q' => 'Quel est le prix d’un meuble TV sur mesure en Tunisie ?', 'a' => 'Le prix dépend de la largeur, de la hauteur, des matériaux, des niches, LED et type de pose. Le devis sur mesure donne le montant fiable.'],
                ['q' => 'Quelle hauteur pour un meuble TV suspendu ?', 'a' => 'Elle dépend du canapé et de la hauteur des yeux assis. La visite permet de positionner correctement la TV.'],
                ['q' => 'Peut-on intégrer box internet et décodeur ?', 'a' => 'Oui, avec niches ventilées et passages de câbles invisibles.'],
                ['q' => 'Le meuble suspendu est-il solide ?', 'a' => 'Oui si le mur est compatible et les fixations adaptées. Nous vérifions la nature du mur avant validation.'],
                ['q' => 'Peut-on intégrer des LED ?', 'a' => 'Oui, si l’alimentation est disponible ou prévue. L’option est intégrée au devis.'],
                ['q' => 'Combien de temps prend la fabrication ?', 'a' => 'Le délai dépend de la taille et des finitions. Il est annoncé dans le devis.'],
            ],
            'finalTitle' => 'Un projet de meuble TV sur mesure ?',
            'finalSubtitle' => 'Visite gratuite, plans 3D et devis sous 48h pour une demande complète.',
            'serviceType' => 'Meuble TV sur mesure',
        ],
        'desk' => [
            'path' => 'sur-mesure/bureau-sur-mesure',
            'name' => 'Bureau sur mesure',
            'eyebrow' => 'Sur mesure · Bureau',
            'h1' => 'Bureau sur mesure en Tunisie.',
            'h1Accent' => 'Un espace de travail qui s’adapte à vous. Pas l’inverse.',
            'intro' => 'Télétravail, cabinet professionnel ou bureau d’étudiant : nous fabriquons votre bureau aux dimensions exactes de votre espace, avec plan de travail, rangements et passages de câbles adaptés à votre usage réel.',
            'primaryCta' => 'Demander un devis bureau',
            'secondaryCta' => 'Voir nos réalisations',
            'heroImage' => $restaurantImage,
            'proofs' => ['Fabriqué sur mesure', 'Plan adapté', 'Câbles intégrés', 'Pose & SAV inclus'],
            'band' => [
                ['value' => 'Dimensions exactes', 'label' => 'Longueur, profondeur et hauteur adaptées.', 'icon' => 'fa-solid fa-ruler-combined'],
                ['value' => 'Home office & pro', 'label' => 'Maison, cabinet, entreprise, enfant.', 'icon' => 'fa-solid fa-briefcase'],
                ['value' => 'Câbles invisibles', 'label' => 'Passe-câbles et goulottes intégrés.', 'icon' => 'fa-solid fa-plug'],
                ['value' => 'Garantie atelier', 'label' => 'Pose et SAV suivis.', 'icon' => 'fa-solid fa-shield-halved'],
            ],
            'contextEyebrow' => 'Pour qui',
            'contextTitle' => 'Trois profils, trois besoins, une même solution sur mesure.',
            'contextIntro' => 'Un bureau efficace dépend de votre usage réel : écrans, documents, imprimante, clients, études, visioconférence ou travail intensif.',
            'benefits' => [
                ['title' => 'Télétravailleur', 'copy' => 'Un vrai home office, profondeur correcte, double écran, rangements et câbles maîtrisés.'],
                ['title' => 'Étudiant et adolescent', 'copy' => 'Espace de travail durable, étagères accessibles, rangements pour livres, cahiers et ordinateur.'],
                ['title' => 'Professionnel libéral', 'copy' => 'Bureau de direction, cabinet, banque d’accueil ou aménagement complet qui reflète votre image.'],
            ],
            'configsEyebrow' => 'Les configurations',
            'configsTitle' => 'Le bon format selon votre espace et votre usage.',
            'configsIntro' => 'Le bureau peut être simple, en L, intégré dans une bibliothèque, encastré ou partagé.',
            'configs' => [
                ['title' => 'Bureau droit', 'copy' => 'Plan rectangulaire avec ou sans caisson, simple et peu encombrant.'],
                ['title' => 'Bureau en L', 'copy' => 'Plus de surface pour double écran, imprimante ou espace de lecture.'],
                ['title' => 'Avec bibliothèque', 'copy' => 'Mur fonctionnel avec étagères, rangements fermés et niches ouvertes.'],
                ['title' => 'Encastré dans une niche', 'copy' => 'L’espace de travail disparaît proprement dans l’architecture.'],
                ['title' => 'Bureau partagé', 'copy' => 'Deux postes distincts pour couple, enfants ou équipe.'],
            ],
            'detailsEyebrow' => 'Ce qui le compose',
            'detailsTitle' => 'Un bureau sur mesure, c’est plus qu’un plateau.',
            'detailsIntro' => 'La qualité d’usage vient de la profondeur, du rangement, de la gestion des câbles et du matériau du plan de travail.',
            'details' => [
                ['title' => 'Plan de travail', 'copy' => 'Profondeur recommandée de 70 à 80 cm pour travailler confortablement sur écran.'],
                ['title' => 'Caissons', 'copy' => 'Tiroirs, dossiers, accessoires, clavier ou rangement latéral.'],
                ['title' => 'Étagères hautes', 'copy' => 'Livres, classeurs, documents et objets à portée de main.'],
                ['title' => 'Passages de câbles', 'copy' => 'Trous, garnitures et goulottes intégrées selon prises existantes.'],
                ['title' => 'Matériaux', 'copy' => 'Mélaminé, MDF laqué, plaqué bois ou stratifié compact selon usage.'],
            ],
            'process' => [
                ['step' => '01', 'title' => 'Visite & mesures', 'copy' => 'Cotes, équipement à intégrer, prises, écrans, imprimante et usage réel.'],
                ['step' => '02', 'title' => 'Plans & devis', 'copy' => 'Configuration, dimensions, rangements et finitions.'],
                ['step' => '03', 'title' => 'Fabrication', 'copy' => 'Fabrication en atelier bois selon dimensions validées.'],
                ['step' => '04', 'title' => 'Pose', 'copy' => 'Installation, fixations, passages de câbles et réception.'],
            ],
            'faqTitle' => 'Vos questions sur les bureaux sur mesure.',
            'faqs' => [
                ['q' => 'Quel est le prix d’un bureau sur mesure en Tunisie ?', 'a' => 'Le prix dépend de la configuration, des dimensions, du matériau, des caissons et rangements. Le devis personnalisé reste la base fiable.'],
                ['q' => 'Quelle profondeur de plan de travail choisir ?', 'a' => 'Pour écran et clavier, 70 à 80 cm est généralement confortable. Moins de 60 cm devient vite fatigant.'],
                ['q' => 'Peut-on intégrer des passages de câbles ?', 'a' => 'Oui, selon l’emplacement des prises et de vos équipements.'],
                ['q' => 'Faites-vous des bureaux pour entreprises ?', 'a' => 'Oui : direction, accueil, opérateurs, salles de réunion et cabinets.'],
                ['q' => 'Peut-on faire un bureau enfant évolutif ?', 'a' => 'Oui, avec éléments réglables et rangements pensés pour durer.'],
                ['q' => 'Combien de temps prend la fabrication ?', 'a' => 'Le délai dépend de la configuration et des finitions. Il est annoncé dans le devis.'],
                ['q' => 'Intervenez-vous dans toute la Tunisie ?', 'a' => 'Oui sur les principales villes, avec frais éventuels précisés dans le devis.'],
            ],
            'finalTitle' => 'Un projet de bureau sur mesure ?',
            'finalSubtitle' => 'Visite gratuite, devis sous 48h pour une demande complète.',
            'serviceType' => 'Bureau sur mesure',
        ],
    ];

    $data = $pages[$pageKey];
    $realizations = app(\App\Support\RealizationResolver::class)->forPage($data['path'], 3, 'sur-mesure');
    $breadcrumbs = [
        ['name' => 'Accueil', 'url' => route('home')],
        ['name' => 'Sur mesure', 'url' => url('/sur-mesure')],
        ['name' => $data['name'], 'url' => url('/' . $data['path'])],
    ];

    $allLinks = collect([
        ['title' => 'Cuisine sur mesure', 'href' => url('/sur-mesure/cuisine-sur-mesure'), 'copy' => 'Plans 3D, fabrication et pose.'],
        ['title' => 'Dressing sur mesure', 'href' => url('/sur-mesure/dressing-sur-mesure'), 'copy' => 'Pleine hauteur, intérieur personnalisé.'],
        ['title' => 'Placard sur mesure', 'href' => url('/sur-mesure/placard-sur-mesure'), 'copy' => 'Entrée, couloir, sous escalier.'],
        ['title' => 'Meuble TV sur mesure', 'href' => url('/sur-mesure/meuble-tv-sur-mesure'), 'copy' => 'Mural, suspendu, câbles invisibles.'],
        ['title' => 'Bureau sur mesure', 'href' => url('/sur-mesure/bureau-sur-mesure'), 'copy' => 'Home office, enfant, professionnel.'],
        ['title' => 'Sur mesure', 'href' => url('/sur-mesure'), 'copy' => 'Retour au hub sur mesure.'],
    ])->reject(fn ($link) => $link['href'] === url('/' . $data['path']))->values();
@endphp

@push('head')
<script type="application/ld+json">
{!! json_encode([
    '@' . 'context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Accueil', 'item' => route('home')],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Sur mesure', 'item' => url('/sur-mesure')],
        ['@type' => 'ListItem', 'position' => 3, 'name' => $data['name'], 'item' => url('/' . $data['path'])],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
<script type="application/ld+json">
{!! json_encode([
    '@' . 'context' => 'https://schema.org',
    '@type' => 'Service',
    'serviceType' => $data['serviceType'],
    'name' => $data['h1'],
    'provider' => [
        '@type' => 'LocalBusiness',
        'name' => 'Maison 216',
        'url' => url('/'),
    ],
    'areaServed' => [
        '@type' => 'Country',
        'name' => 'Tunisie',
    ],
    'description' => $data['intro'],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
<script type="application/ld+json">
{!! json_encode([
    '@' . 'context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => collect($data['faqs'])->map(fn ($faq) => [
        '@type' => 'Question',
        'name' => $faq['q'],
        'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => $faq['a'],
        ],
    ])->values()->all(),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endpush

@section('content')
<section class="border-b border-[#eadfce] bg-[#fbf7ee]">
    <div class="container mx-auto px-4 py-4">
        <nav class="flex flex-wrap items-center gap-2 text-sm font-semibold text-[#6a5a4c]" aria-label="Fil d'Ariane">
            @foreach($breadcrumbs as $crumb)
                @if(!$loop->first)
                    <i class="fa-solid fa-angle-right text-[10px] text-[#b88a3b]"></i>
                @endif
                @if(!$loop->last)
                    <a href="{{ $crumb['url'] }}" class="transition hover:text-[#171411]">{{ $crumb['name'] }}</a>
                @else
                    <span class="text-[#171411]">{{ $crumb['name'] }}</span>
                @endif
            @endforeach
        </nav>
    </div>
</section>

<section class="relative overflow-hidden border-b border-[#eadfce] bg-[#fbf7ee]">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_18%_18%,rgba(184,138,59,0.16),transparent_34%),radial-gradient(circle_at_86%_18%,rgba(80,58,35,0.12),transparent_30%)]"></div>
    <div class="container relative mx-auto grid gap-0 px-4 pb-12 pt-0 lg:grid-cols-[0.92fr_1.08fr] lg:items-center lg:gap-10 lg:py-20">
        <div class="order-2 py-10 lg:order-1 lg:py-0">
            <h1 class="font-display max-w-4xl text-4xl font-extrabold leading-[1.02] tracking-[-0.04em] text-[#171411] sm:text-5xl lg:text-6xl">
                {{ $data['h1'] }}
                <span class="block text-[#a47834]">{{ $data['h1Accent'] }}</span>
            </h1>

            <p class="mt-6 max-w-3xl text-base leading-8 text-[#55473c] sm:text-lg">{{ $data['intro'] }}</p>

            <div class="mt-8 flex flex-row gap-2 sm:gap-3">
                <a href="{{ $devisUrl }}" class="inline-flex flex-1 items-center justify-center gap-2 rounded-full bg-[#171411] px-4 py-3 text-xs font-extrabold text-white shadow-[0_20px_45px_rgba(23,20,17,0.16)] transition hover:bg-[#a47834] sm:flex-none sm:px-7 sm:py-4 sm:text-sm">
                    <i class="fa-regular fa-clipboard"></i>
                    {{ $data['primaryCta'] }}
                </a>
                @if($realizations->isNotEmpty())
                    <a href="#realisations-sur-mesure" class="inline-flex flex-1 items-center justify-center gap-2 rounded-full border border-[#cdbb9f] bg-white/78 px-4 py-3 text-xs font-extrabold text-[#171411] transition hover:border-[#a47834] hover:bg-white sm:flex-none sm:px-7 sm:py-4 sm:text-sm">
                        <i class="fa-regular fa-images"></i>
                        {{ $data['secondaryCta'] }}
                    </a>
                @endif
            </div>

            <div class="mt-8 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($data['proofs'] as $proof)
                    <span class="inline-flex items-center gap-2 text-sm font-bold text-[#4f4236]">
                        <i class="fa-solid fa-check text-[#a47834]"></i>
                        {{ $proof }}
                    </span>
                @endforeach
            </div>
        </div>

        <div class="order-1 -mx-4 lg:order-2 lg:mx-0">
            <div class="overflow-hidden bg-white lg:rounded-[40px] lg:border lg:border-[#d8c7af] lg:p-3">
                <img src="{{ $data['heroImage'] }}" alt="{{ $data['h1'] }}" class="h-[320px] w-full object-cover sm:h-[420px] lg:h-[540px] lg:rounded-[30px]">
            </div>
        </div>
    </div>
</section>

<section class="border-b border-[#eadfce] bg-white">
    <div class="container mx-auto grid gap-0 px-4 py-6 sm:grid-cols-2 lg:grid-cols-4">
        @foreach($data['band'] as $item)
            <div class="border-[#eadfce] py-5 lg:border-r lg:px-6 lg:last:border-r-0">
                <div class="flex items-start gap-4">
                    <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-[#f4ead8] text-[#a47834]">
                        <i class="{{ $item['icon'] }}"></i>
                    </span>
                    <div>
                        <div class="font-display text-xl font-extrabold text-[#171411]">{{ $item['value'] }}</div>
                        <div class="mt-1 text-sm leading-6 text-[#66584d]">{{ $item['label'] }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

<section class="bg-[#fbf7ee] py-16 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-9 max-w-4xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">{{ $data['contextEyebrow'] }}</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">{{ $data['contextTitle'] }}</h2>
            <p class="mt-4 text-lg leading-8 text-[#5f5146]">{{ $data['contextIntro'] }}</p>
        </div>

        <div class="grid gap-5 md:grid-cols-3">
            @foreach($data['benefits'] as $benefit)
                <article class="rounded-[30px] border border-[#eadfce] bg-white p-6">
                    <h3 class="font-display text-xl font-extrabold text-[#171411]">{{ $benefit['title'] }}</h3>
                    <p class="mt-4 text-sm leading-7 text-[#5f5146]">{{ $benefit['copy'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-white py-16 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-9 max-w-4xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">{{ $data['configsEyebrow'] }}</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">{{ $data['configsTitle'] }}</h2>
            <p class="mt-4 text-lg leading-8 text-[#5f5146]">{{ $data['configsIntro'] }}</p>
        </div>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-5">
            @foreach($data['configs'] as $config)
                <article class="rounded-[30px] border border-[#eadfce] bg-[#fbf7ee] p-6">
                    <h3 class="font-display text-xl font-extrabold text-[#171411]">{{ $config['title'] }}</h3>
                    <p class="mt-4 text-sm leading-7 text-[#5f5146]">{{ $config['copy'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-[#171411] py-16 text-white lg:py-20">
    <div class="container mx-auto px-4">
        <div class="grid gap-10 lg:grid-cols-[0.92fr_1.08fr] lg:items-start">
            <div>
                <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#d5b170]">{{ $data['detailsEyebrow'] }}</div>
                <h2 class="font-display mt-3 text-3xl font-extrabold sm:text-4xl">{{ $data['detailsTitle'] }}</h2>
                <p class="mt-5 text-lg leading-8 text-white/72">{{ $data['detailsIntro'] }}</p>
                <a href="{{ $devisUrl }}" class="mt-8 inline-flex items-center gap-2 rounded-full bg-[#d5b170] px-6 py-3 text-sm font-extrabold text-[#171411]">
                    Étudier mon projet
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                @foreach($data['details'] as $detail)
                    <article class="rounded-[28px] border border-white/10 bg-white/[0.06] p-6">
                        <h3 class="font-display text-xl font-extrabold text-white">{{ $detail['title'] }}</h3>
                        <p class="mt-4 text-sm leading-7 text-white/70">{{ $detail['copy'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
</section>

@if($realizations->isNotEmpty())
<section id="realisations-sur-mesure" class="bg-white py-16 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-9 max-w-3xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Réalisations sur mesure</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">Quelques projets liés à cette gamme.</h2>
        </div>

        <div class="grid gap-5 md:grid-cols-3">
            @foreach($realizations as $realization)
                <a href="{{ $realization['url'] }}" class="group relative min-h-[320px] overflow-hidden rounded-[34px] bg-cover bg-center p-6 transition hover:-translate-y-1" style="background-image: linear-gradient(180deg, rgba(23,20,17,0.04), rgba(23,20,17,0.82)), url('{{ $realization['image'] }}');">
                    <div class="relative z-10 flex h-full flex-col justify-between">
                        <span class="inline-flex w-max rounded-full border border-white/15 bg-white/10 px-3 py-1 text-xs font-bold text-[#e7c98d] backdrop-blur">{{ $realization['place'] }}</span>
                        <div class="text-white">
                            <h3 class="font-display text-2xl font-extrabold">{{ $realization['title'] }}</h3>
                            <p class="mt-2 text-sm leading-6 text-white/76">{{ $realization['copy'] }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="bg-[#fbf7ee] py-16 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-10 max-w-3xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Le processus</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">De l’idée à la pose, sans flou.</h2>
        </div>

        <div @class([
            'grid gap-5',
            'lg:grid-cols-4' => count($data['process']) === 4,
            'lg:grid-cols-5' => count($data['process']) !== 4,
        ])>
            @foreach($data['process'] as $step)
                <article class="rounded-[30px] border border-[#eadfce] bg-white p-6">
                    <div class="font-display text-5xl font-extrabold text-[#a47834]/20">{{ $step['step'] }}</div>
                    <h3 class="font-display mt-5 text-xl font-extrabold text-[#171411]">{{ $step['title'] }}</h3>
                    <p class="mt-4 text-sm leading-7 text-[#5f5146]">{{ $step['copy'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-white py-16 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-9 max-w-3xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Questions fréquentes</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">{{ $data['faqTitle'] }}</h2>
        </div>

        <div class="mx-auto max-w-4xl divide-y divide-[#eadfce] rounded-[34px] border border-[#eadfce] bg-[#fbf7ee] p-2">
            @foreach($data['faqs'] as $faq)
                <details class="group rounded-[26px] px-5 py-4 open:bg-white" @if($loop->first) open @endif>
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-display text-lg font-extrabold text-[#171411]">
                        {{ $faq['q'] }}
                        <i class="fa-solid fa-chevron-down shrink-0 text-sm text-[#a47834] transition group-open:rotate-180"></i>
                    </summary>
                    <p class="mt-4 max-w-3xl text-base leading-8 text-[#5f5146]">{{ $faq['a'] }}</p>
                </details>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-[#171411] py-16 text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="font-display text-3xl font-extrabold sm:text-5xl">{{ $data['finalTitle'] }}</h2>
        <p class="mx-auto mt-4 max-w-2xl text-lg leading-8 text-white/72">{{ $data['finalSubtitle'] }}</p>
        <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
            <a href="{{ $devisUrl }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#d5b170] px-7 py-4 text-sm font-extrabold text-[#171411]">
                <i class="fa-regular fa-clipboard"></i>
                {{ $data['primaryCta'] }}
            </a>
            <a href="{{ $whatsappUrl }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-white/15 px-7 py-4 text-sm font-extrabold text-white">
                <i class="fa-brands fa-whatsapp"></i>
                {{ \App\Support\SiteSettings::phoneDisplay() }}
            </a>
        </div>
    </div>
</section>

<section class="bg-[#fbf7ee] py-14 lg:py-16">
    <div class="container mx-auto px-4">
        <div class="mb-7 max-w-3xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Explorer le sur mesure</div>
            <h3 class="font-display mt-3 text-2xl font-extrabold text-[#171411] sm:text-3xl">Nos autres aménagements sur mesure.</h3>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-5">
            @foreach($allLinks as $link)
                <a href="{{ $link['href'] }}" class="group rounded-[26px] border border-[#eadfce] bg-white p-5 transition hover:-translate-y-1 hover:border-[#c7a36a] hover:shadow-[0_18px_45px_rgba(23,20,17,0.08)]">
                    <h4 class="font-display text-lg font-extrabold text-[#171411]">{{ $link['title'] }}</h4>
                    <p class="mt-3 text-sm leading-6 text-[#5f5146]">{{ $link['copy'] }}</p>
                    <div class="mt-5 text-sm font-extrabold text-[#8e6322]">Voir la page <i class="fa-solid fa-arrow-right ml-1 text-xs transition group-hover:translate-x-1"></i></div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endsection
