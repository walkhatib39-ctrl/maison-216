@extends('layouts.store')

@php
    $devisUrl = url('/devis');
    $contactUrl = route('contact');
    $whatsappUrl = \App\Support\SiteSettings::whatsappUrl() ?? $contactUrl;

    $heroImage = asset('assets/home/menuiserie-aluminium.jpg');
    $voletImage = asset('assets/home/realizations/volet-roulant-aluminium.webp');
    $pergolaImage = asset('assets/home/realizations/pergola.jpg');
    $restaurantImage = asset('assets/home/realizations/amenagement-restaurant.jpg');
    $surMesureImage = asset('assets/home/amenagement-sur-mesure.jpg');

    $pages = [
        'window' => [
            'path' => 'aluminium/fenetre-aluminium',
            'name' => 'Fenêtre aluminium',
            'parentName' => 'Menuiserie aluminium',
            'eyebrow' => 'Menuiserie alu · Fenêtre aluminium',
            'h1' => 'Fenêtre aluminium sur mesure en Tunisie.',
            'h1Accent' => 'Fabriquée dans notre atelier, posée par notre équipe.',
            'intro' => 'Fenêtres battantes, oscillo-battantes, coulissantes ou fixes. Profilés à rupture de pont thermique, double vitrage isolant, thermolaquage toutes teintes RAL. Fabrication sur cotes exactes, devis sous 48h.',
            'primaryCta' => 'Demander un devis fenêtre',
            'secondaryCta' => 'Voir nos réalisations',
            'proofs' => ['Rupture de pont thermique', 'Double vitrage isolant', 'Fabrication sur mesure', 'Pose & SAV inclus'],
            'band' => [
                ['value' => 'Sur mesure au mm', 'label' => 'Chaque fenêtre est fabriquée selon vos baies.', 'icon' => 'fa-solid fa-ruler-combined'],
                ['value' => 'Double vitrage', 'label' => 'Standard ou renforcé selon l’exposition.', 'icon' => 'fa-regular fa-square'],
                ['value' => 'Teintes RAL', 'label' => 'Blanc, anthracite, noir, crème et plus.', 'icon' => 'fa-solid fa-palette'],
                ['value' => 'Pose incluse', 'label' => 'Calfeutrement, réglage et réception.', 'icon' => 'fa-solid fa-screwdriver-wrench'],
            ],
            'typesEyebrow' => 'Nos types de fenêtres',
            'typesTitle' => 'Le bon type d’ouverture pour chaque pièce et chaque usage.',
            'typesIntro' => 'Nous fabriquons tous les types de fenêtres aluminium, sur les dimensions exactes de vos baies.',
            'types' => [
                ['title' => 'Fenêtre battante', 'copy' => 'L’ouverture classique, à un ou deux vantaux. Idéale pour les chambres, cuisines et espaces où une ventilation naturelle complète est souhaitée.', 'icon' => 'fa-regular fa-window-maximize', 'image' => $heroImage],
                ['title' => 'Fenêtre oscillo-battante', 'copy' => 'S’ouvre en basculant vers l’intérieur pour une ventilation douce, ou complètement comme une fenêtre battante. Idéale pour chambres et salles de bain.', 'icon' => 'fa-solid fa-arrows-rotate', 'image' => $heroImage],
                ['title' => 'Fenêtre coulissante', 'copy' => 'Deux ou trois vantaux qui glissent sur rail horizontal. Parfaite pour grandes baies, séjours et espaces où l’ouverture extérieure est contrainte.', 'icon' => 'fa-solid fa-arrows-left-right', 'image' => $heroImage],
                ['title' => 'Baie coulissante grande largeur', 'copy' => 'Pour grandes ouvertures de séjour, villas et terrasses. Deux, trois ou quatre vantaux, avec option galandage selon projet.', 'icon' => 'fa-solid fa-up-right-and-down-left-from-center', 'image' => $surMesureImage],
                ['title' => 'Fenêtre fixe', 'copy' => 'Vitrage fixe sans ouverture pour maximiser la lumière naturelle. Souvent combinée avec une fenêtre ouvrante adjacente.', 'icon' => 'fa-regular fa-square', 'image' => $heroImage],
                ['title' => 'Formes spéciales', 'copy' => 'Fenêtres cintrées, trapézoïdales, triangulaires ou formes dictées par l’architecture, fabriquées sur plan technique.', 'icon' => 'fa-solid fa-draw-polygon', 'image' => $heroImage],
            ],
            'argumentEyebrow' => 'Pourquoi l’aluminium',
            'argumentTitle' => 'L’aluminium : le meilleur choix pour le climat tunisien.',
            'argumentIntro' => 'En Tunisie, les fenêtres subissent chaleur intense, variations thermiques, vent de sable et air salin en bord de mer. L’aluminium résiste à ces contraintes sans entretien lourd et sans se déformer dans le temps.',
            'arguments' => [
                ['title' => 'Durabilité sans entretien', 'copy' => 'Une fenêtre aluminium thermolaquée conserve son aspect sans entretien lourd. Elle ne gonfle pas à l’humidité et ne se fissure pas comme certains matériaux exposés.'],
                ['title' => 'Profilés fins, plus de lumière', 'copy' => 'À résistance égale, les profilés aluminium sont plus fins que beaucoup d’alternatives. Résultat : plus de vitrage et plus de lumière naturelle.'],
                ['title' => 'Rupture de pont thermique', 'copy' => 'Les profilés RPT limitent la transmission de chaleur entre extérieur et intérieur, ce qui améliore le confort en été et réduit la charge de climatisation.'],
                ['title' => 'Compatibilité vitrages', 'copy' => 'Double vitrage, contrôle solaire, feuilleté de sécurité ou vitrage acoustique : vous choisissez le niveau de performance selon exposition et budget.'],
            ],
            'technicalSections' => [
                [
                    'eyebrow' => 'Les vitrages',
                    'title' => 'Le vitrage adapté à votre exposition et votre usage.',
                    'intro' => 'Le choix du vitrage est aussi important que le choix du profilé. Il détermine votre confort thermique et acoustique.',
                    'items' => [
                        ['title' => 'Double vitrage standard 4/16/4', 'copy' => 'Deux verres séparés par une lame d’air. Une base fiable pour la majorité des situations en Tunisie.'],
                        ['title' => 'Double vitrage argon', 'copy' => 'Le gaz argon améliore l’isolation thermique. Recommandé pour les pièces très exposées.'],
                        ['title' => 'Vitrage à contrôle solaire', 'copy' => 'Réfléchit une partie du rayonnement solaire tout en laissant passer la lumière. Utile sur façades plein sud.'],
                        ['title' => 'Vitrage feuilleté sécurité', 'copy' => 'En cas de casse, le verre reste maintenu par un film intérieur. Recommandé en rez-de-chaussée et zones sensibles.'],
                        ['title' => 'Vitrage acoustique', 'copy' => 'Composition asymétrique pour mieux réduire les nuisances sonores proches de routes ou axes bruyants.'],
                    ],
                ],
                [
                    'eyebrow' => 'Finitions',
                    'title' => 'Toutes les teintes, tous les effets.',
                    'intro' => 'Les profilés aluminium sont thermolaqués dans les teintes adaptées à votre architecture, avec possibilité de bicoloration selon projet.',
                    'items' => [
                        ['title' => 'Toutes teintes RAL', 'copy' => 'Blanc, gris anthracite, noir mat, crème, sable, beige, vert ou teintes spécifiques selon disponibilité.'],
                        ['title' => 'Mat, satiné ou brillant', 'copy' => 'Rendu sobre, contemporain ou plus lumineux selon la façade et l’intérieur.'],
                        ['title' => 'Effet bois sur demande', 'copy' => 'Plaxage ou rendu bois lorsque le projet exige une apparence plus chaleureuse.'],
                        ['title' => 'Bicoloration intérieur / extérieur', 'copy' => 'Une couleur côté façade, une autre côté intérieur pour accorder chaque environnement.'],
                        ['title' => 'Teintes demandées', 'copy' => 'Blanc RAL 9016, gris anthracite RAL 7016, noir mat RAL 9005, sable et crème.'],
                    ],
                ],
            ],
            'process' => [
                ['step' => '01', 'title' => 'Métré sur place', 'copy' => 'Prise de cotes exactes, analyse du tableau, feuillure, mur et conseil sur ouverture et vitrage.'],
                ['step' => '02', 'title' => 'Devis détaillé', 'copy' => 'Chiffrage fenêtre par fenêtre avec profilé, vitrage et finition. Devis sous 48h pour une demande complète.'],
                ['step' => '03', 'title' => 'Fabrication atelier', 'copy' => 'Découpe des profilés, assemblage, pose du vitrage, étanchéité et contrôle qualité.'],
                ['step' => '04', 'title' => 'Pose & réception', 'copy' => 'Dépose si nécessaire, mise en place, calfeutrement, vérification d’ouverture et d’étanchéité.'],
            ],
            'faqTitle' => 'Vos questions sur les fenêtres aluminium.',
            'faqs' => [
                ['q' => 'Quel est le prix d’une fenêtre aluminium sur mesure en Tunisie ?', 'a' => 'Le prix dépend des dimensions, du type d’ouverture, du profilé choisi, de la rupture de pont thermique et du vitrage. Un devis personnalisé après métré reste la base fiable.'],
                ['q' => 'La rupture de pont thermique est-elle utile en Tunisie ?', 'a' => 'Oui. Elle limite la chaleur transmise par le cadre en été et améliore le confort intérieur, surtout dans les pièces exposées au soleil.'],
                ['q' => 'Quelle différence entre fenêtre avec et sans RPT ?', 'a' => 'Sans RPT, l’aluminium conduit directement la chaleur entre extérieur et intérieur. Avec RPT, une barrette isolante coupe cette conduction et améliore le confort.'],
                ['q' => 'Peut-on remplacer des fenêtres existantes sans casser les murs ?', 'a' => 'Dans la plupart des cas, oui. Le métré permet de vérifier si une pose en rénovation suffit ou si une dépose complète est préférable.'],
                ['q' => 'Combien de temps prend la fabrication et la pose ?', 'a' => 'Comptez généralement 2 à 4 semaines selon le nombre de fenêtres et les finitions. Pour les programmes neufs, le délai est phasé avec le chantier.'],
                ['q' => 'Posez-vous les fenêtres dans toute la Tunisie ?', 'a' => 'Oui. Nous intervenons sur les principales villes tunisiennes. Les frais éventuels de déplacement sont précisés dans le devis.'],
                ['q' => 'Quelle garantie sur les fenêtres aluminium ?', 'a' => 'Garantie atelier sur la fabrication et l’étanchéité à la pose. La quincaillerie suit la garantie fabricant.'],
                ['q' => 'Travaillez-vous avec les promoteurs ?', 'a' => 'Oui. Lots multiples, tarifs adaptés au volume, livraisons phasées et coordination avec calendrier de chantier.'],
            ],
            'finalTitle' => 'Un projet de fenêtres aluminium ?',
            'finalSubtitle' => 'Métré gratuit sur place, devis détaillé sous 48h pour une demande complète.',
            'serviceType' => 'Fenêtre aluminium sur mesure',
            'schemaDescription' => 'Fenêtres aluminium sur mesure en Tunisie avec rupture de pont thermique, double vitrage, fabrication atelier et pose.',
            'internalLinks' => [
                ['title' => 'Porte aluminium', 'href' => url('/aluminium/porte-aluminium'), 'copy' => 'Entrée, porte-fenêtre, baie coulissante.'],
                ['title' => 'Garde-corps aluminium', 'href' => url('/aluminium/garde-corps'), 'copy' => 'Balcon, terrasse, escalier.'],
                ['title' => 'Volet roulant', 'href' => url('/aluminium/volet-roulant'), 'copy' => 'Manuel ou motorisé.'],
                ['title' => 'Moustiquaire aluminium', 'href' => url('/aluminium/moustiquaire'), 'copy' => 'Enroulable ou plissée.'],
                ['title' => 'Brise-soleil', 'href' => url('/aluminium/brise-soleil'), 'copy' => 'Protection solaire de façade.'],
                ['title' => 'Menuiserie aluminium', 'href' => url('/aluminium'), 'copy' => 'Retour au hub aluminium.'],
            ],
        ],
        'door' => [
            'path' => 'aluminium/porte-aluminium',
            'name' => 'Porte aluminium',
            'parentName' => 'Menuiserie aluminium',
            'eyebrow' => 'Menuiserie alu · Porte aluminium',
            'h1' => 'Porte aluminium sur mesure en Tunisie.',
            'h1Accent' => 'Belle à l’entrée. Solide pour durer.',
            'intro' => 'Porte d’entrée, porte-fenêtre ou baie coulissante : nous fabriquons votre porte aluminium aux dimensions exactes de votre ouverture, dans la couleur de votre choix, avec la serrurerie adaptée à votre usage. Fabrication atelier, pose par notre équipe.',
            'primaryCta' => 'Demander un devis porte',
            'secondaryCta' => 'Voir nos réalisations',
            'proofs' => ['Fabrication sur mesure', 'Toutes teintes RAL', 'Serrurerie multipoints', 'Pose & SAV inclus'],
            'band' => [
                ['value' => 'Sur mesure au mm', 'label' => 'Porte adaptée à l’ouverture réelle.', 'icon' => 'fa-solid fa-ruler-combined'],
                ['value' => 'Isolation soignée', 'label' => 'Joints, vitrage et profilés selon usage.', 'icon' => 'fa-solid fa-temperature-half'],
                ['value' => 'Serrurerie sécurisée', 'label' => 'Multipoints selon configuration choisie.', 'icon' => 'fa-solid fa-lock'],
                ['value' => 'Pose incluse', 'label' => 'Réglage, étanchéité et réception.', 'icon' => 'fa-solid fa-screwdriver-wrench'],
            ],
            'typesEyebrow' => 'Nos types de portes',
            'typesTitle' => 'La bonne porte pour chaque ouverture.',
            'typesIntro' => 'Entrée principale, accès terrasse ou grande baie de séjour : chaque configuration a sa solution.',
            'types' => [
                ['title' => 'Porte d’entrée aluminium', 'copy' => 'La première impression de votre maison. Robuste, isolante, sécurisée, en version pleine, vitrée ou semi-vitrée.', 'icon' => 'fa-solid fa-door-open', 'image' => $heroImage],
                ['title' => 'Porte-fenêtre', 'copy' => 'Une ouverture lumineuse vers la terrasse ou le jardin, à un ou deux vantaux, avec ou sans partie fixe.', 'icon' => 'fa-regular fa-window-maximize', 'image' => $heroImage],
                ['title' => 'Baie coulissante', 'copy' => 'Deux ou trois vantaux pour dégager un passage généreux. La solution phare des villas contemporaines.', 'icon' => 'fa-solid fa-arrows-left-right', 'image' => $surMesureImage],
                ['title' => 'Baie coulissante à galandage', 'copy' => 'Les vantaux disparaissent dans l’épaisseur du mur pour effacer la frontière entre séjour et terrasse.', 'icon' => 'fa-solid fa-up-right-and-down-left-from-center', 'image' => $surMesureImage],
                ['title' => 'Porte de service', 'copy' => 'Accès secondaire, local technique ou garage vitré, fabriqué avec le même soin que la porte principale.', 'icon' => 'fa-solid fa-warehouse', 'image' => $heroImage],
            ],
            'argumentEyebrow' => 'Ce qui compte vraiment',
            'argumentTitle' => 'Ce qu’on ne vous dit pas toujours quand vous achetez une porte.',
            'argumentIntro' => 'Une porte aluminium se juge sur trois choses : comment elle s’ouvre dans 15 ans, comment elle isole été comme hiver, et ce qui se passe si on essaie de la forcer.',
            'arguments' => [
                ['title' => 'La longévité', 'copy' => 'Profilés solides, charnières, serrures et mécanismes choisis pour un usage quotidien intensif. Une porte bien fabriquée ne s’affaisse pas et ne frotte pas.'],
                ['title' => 'L’isolation', 'copy' => 'Joint périphérique, profilé adapté et vitrage isolant limitent les infiltrations de chaleur, de froid et de bruit.'],
                ['title' => 'La sécurité', 'copy' => 'Les portes d’entrée peuvent intégrer une serrurerie multipoints, plus résistante qu’une serrure simple à point unique.'],
            ],
            'technicalSections' => [
                [
                    'eyebrow' => 'Finitions',
                    'title' => 'La couleur qui correspond à votre façade.',
                    'intro' => 'Les portes aluminium sont thermolaquées dans la teinte qui s’intègre à votre maison, avec bicoloration possible selon projet.',
                    'items' => [
                        ['title' => 'Toutes teintes RAL', 'copy' => 'Blanc, gris anthracite, noir mat, crème, sable ou teintes spécifiques selon disponibilité.'],
                        ['title' => 'Mat, satiné ou brillant', 'copy' => 'Rendu sobre, contemporain ou plus lumineux selon le style de façade.'],
                        ['title' => 'Effet bois', 'copy' => 'Un rendu chaleureux sans l’entretien du bois, sur demande et selon gamme disponible.'],
                        ['title' => 'Bicoloration', 'copy' => 'Une teinte côté rue, une autre côté intérieur pour accorder chaque ambiance.'],
                    ],
                ],
                [
                    'eyebrow' => 'Les vitrages',
                    'title' => 'Du vitrage selon votre priorité : lumière, sécurité ou intimité.',
                    'intro' => 'La partie vitrée d’une porte doit être choisie selon la luminosité, la sécurité et l’intimité attendues.',
                    'items' => [
                        ['title' => 'Vitrage transparent', 'copy' => 'Fait entrer la lumière naturelle dans l’entrée ou le séjour.'],
                        ['title' => 'Vitrage dépoli ou sablé', 'copy' => 'Laisse passer la lumière sans exposer l’intérieur aux regards.'],
                        ['title' => 'Vitrage feuilleté sécurité', 'copy' => 'En cas de choc, le verre reste maintenu. Recommandé pour portes d’entrée et rez-de-chaussée.'],
                        ['title' => 'Vitrage à contrôle solaire', 'copy' => 'Limite la surchauffe des baies et portes-fenêtres très exposées au soleil.'],
                    ],
                ],
            ],
            'process' => [
                ['step' => '01', 'title' => 'Métré & conseil', 'copy' => 'Prise de cotes, conseil sur type d’ouverture, couleur, vitrage et serrurerie.'],
                ['step' => '02', 'title' => 'Devis sous 48h', 'copy' => 'Chiffrage détaillé avec profilé, vitrage et finition. Valable selon conditions du devis.'],
                ['step' => '03', 'title' => 'Fabrication atelier', 'copy' => 'Fabrication sur cotes exactes, assemblage, vitrage, thermolaquage et contrôle.'],
                ['step' => '04', 'title' => 'Pose & réception', 'copy' => 'Dépose si nécessaire, pose, réglages, vérification d’étanchéité et garantie atelier.'],
            ],
            'faqTitle' => 'Vos questions sur les portes aluminium.',
            'faqs' => [
                ['q' => 'Quel est le prix d’une porte d’entrée aluminium sur mesure en Tunisie ?', 'a' => 'Le prix dépend des dimensions, du design, du vitrage, de la serrurerie et des finitions. Le devis après métré permet de chiffrer précisément.'],
                ['q' => 'Combien coûte une baie coulissante aluminium ?', 'a' => 'Le prix dépend de la largeur, du nombre de vantaux, du vitrage, du profilé et de la pose. Nous chiffrons selon vos dimensions exactes.'],
                ['q' => 'Peut-on remplacer une ancienne porte sans casser le mur ?', 'a' => 'Dans beaucoup de cas, oui. Le métré permet de vérifier si le tableau existant peut être conservé ou si une reprise est nécessaire.'],
                ['q' => 'La porte aluminium est-elle sécurisée contre l’effraction ?', 'a' => 'Une porte d’entrée peut être équipée d’une serrure multipoints, qui verrouille plusieurs zones simultanément et améliore la résistance.'],
                ['q' => 'Peut-on motoriser une baie coulissante ?', 'a' => 'Oui, selon dimensions, poids et configuration. C’est à préciser lors de la demande de devis.'],
                ['q' => 'Combien de temps faut-il pour fabriquer et poser une porte ?', 'a' => 'Comptez généralement 2 à 3 semaines pour une porte standard, et davantage pour une grande baie ou un projet multi-ouvertures.'],
                ['q' => 'Faites-vous des portes pour les promoteurs ?', 'a' => 'Oui. Lots de logements, tarifs adaptés au volume, livraisons phasées et coordination chantier.'],
                ['q' => 'Quelle garantie sur les portes aluminium ?', 'a' => 'Garantie atelier sur la fabrication et la pose. Serrurerie et quincaillerie suivent la garantie fabricant.'],
            ],
            'finalTitle' => 'Un projet de porte aluminium ?',
            'finalSubtitle' => 'Métré gratuit sur place, devis détaillé sous 48h pour une demande complète.',
            'serviceType' => 'Porte aluminium sur mesure',
            'schemaDescription' => 'Portes aluminium sur mesure en Tunisie : porte d’entrée, porte-fenêtre, baie coulissante, fabrication atelier et pose.',
            'internalLinks' => [
                ['title' => 'Fenêtre aluminium', 'href' => url('/aluminium/fenetre-aluminium'), 'copy' => 'RPT, double vitrage, sur mesure.'],
                ['title' => 'Garde-corps aluminium', 'href' => url('/aluminium/garde-corps'), 'copy' => 'Balcon, terrasse, escalier.'],
                ['title' => 'Volet roulant', 'href' => url('/aluminium/volet-roulant'), 'copy' => 'Manuel ou motorisé.'],
                ['title' => 'Moustiquaire aluminium', 'href' => url('/aluminium/moustiquaire'), 'copy' => 'Enroulable ou plissée.'],
                ['title' => 'Brise-soleil', 'href' => url('/aluminium/brise-soleil'), 'copy' => 'Protection solaire de façade.'],
                ['title' => 'Menuiserie aluminium', 'href' => url('/aluminium'), 'copy' => 'Retour au hub aluminium.'],
            ],
        ],
    ];

    $data = $pages[$pageKey];
    $realizations = app(\App\Support\RealizationResolver::class)->forPage($data['path'], 3, 'aluminium');
    $breadcrumbs = [
        ['name' => 'Accueil', 'url' => route('home')],
        ['name' => 'Menuiserie aluminium', 'url' => url('/aluminium')],
        ['name' => $data['name'], 'url' => url('/' . $data['path'])],
    ];
@endphp

@push('head')
<script type="application/ld+json">
{!! json_encode([
    '@' . 'context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Accueil', 'item' => route('home')],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Menuiserie aluminium', 'item' => url('/aluminium')],
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
    'description' => $data['schemaDescription'],
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
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_18%_18%,rgba(184,138,59,0.15),transparent_34%),radial-gradient(circle_at_86%_18%,rgba(40,62,62,0.12),transparent_30%)]"></div>
    <div class="container relative mx-auto grid gap-10 px-4 py-14 lg:grid-cols-[0.9fr_1.1fr] lg:items-center lg:py-20">
        <div>
            <div class="inline-flex items-center gap-2 rounded-full border border-[#d8c7af] bg-white/72 px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-[#8b6426]">
                <i class="fa-solid fa-border-all"></i>
                {{ $data['eyebrow'] }}
            </div>

            <h1 class="font-display mt-7 max-w-4xl text-4xl font-extrabold leading-[1.02] tracking-[-0.04em] text-[#171411] sm:text-5xl lg:text-6xl">
                {{ $data['h1'] }}
                <span class="block text-[#a47834]">{{ $data['h1Accent'] }}</span>
            </h1>

            <p class="mt-6 max-w-3xl text-base leading-8 text-[#55473c] sm:text-lg">{{ $data['intro'] }}</p>

            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                <a href="{{ $devisUrl }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#171411] px-7 py-4 text-sm font-extrabold text-white shadow-[0_20px_45px_rgba(23,20,17,0.16)] transition hover:bg-[#a47834]">
                    <i class="fa-regular fa-clipboard"></i>
                    {{ $data['primaryCta'] }}
                </a>
                @if($realizations->isNotEmpty())
                    <a href="#realisations-aluminium" class="inline-flex items-center justify-center gap-2 rounded-full border border-[#cdbb9f] bg-white/78 px-7 py-4 text-sm font-extrabold text-[#171411] transition hover:border-[#a47834] hover:bg-white">
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

        <div class="relative">
            <div class="rounded-[40px] border border-[#d8c7af] bg-white p-3 shadow-[0_36px_90px_rgba(23,20,17,0.16)]">
                <div class="relative min-h-[360px] overflow-hidden rounded-[30px] bg-cover bg-center lg:min-h-[540px]" style="background-image: linear-gradient(180deg, rgba(23,20,17,0.02), rgba(23,20,17,0.58)), url('{{ $heroImage }}');">
                    <div class="absolute bottom-6 left-6 right-6 rounded-[26px] border border-white/18 bg-[#171411]/72 p-5 text-white backdrop-blur">
                        <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#d5b170]">Fabrication aluminium</div>
                        <p class="mt-2 text-sm leading-6 text-white/78">Métré, fabrication sur cotes, finition, pose et réglages dans un parcours suivi.</p>
                    </div>
                </div>
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
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">{{ $data['typesEyebrow'] }}</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">{{ $data['typesTitle'] }}</h2>
            <p class="mt-4 text-lg leading-8 text-[#5f5146]">{{ $data['typesIntro'] }}</p>
        </div>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @foreach($data['types'] as $type)
                <article class="overflow-hidden rounded-[32px] border border-[#eadfce] bg-white shadow-[0_18px_45px_rgba(23,20,17,0.05)]">
                    <div class="relative min-h-[210px] bg-cover bg-center" style="background-image: linear-gradient(180deg, rgba(23,20,17,0.05), rgba(23,20,17,0.60)), url('{{ $type['image'] }}');">
                        <span class="absolute left-5 top-5 inline-flex h-12 w-12 items-center justify-center rounded-2xl border border-white/20 bg-white/12 text-[#f0d49a] backdrop-blur">
                            <i class="{{ $type['icon'] }}"></i>
                        </span>
                    </div>
                    <div class="p-6">
                        <h3 class="font-display text-xl font-extrabold text-[#171411]">{{ $type['title'] }}</h3>
                        <p class="mt-3 text-sm leading-7 text-[#5f5146]">{{ $type['copy'] }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-white py-16 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-9 max-w-4xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">{{ $data['argumentEyebrow'] }}</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">{{ $data['argumentTitle'] }}</h2>
            <p class="mt-4 text-lg leading-8 text-[#5f5146]">{{ $data['argumentIntro'] }}</p>
        </div>

        <div @class([
            'grid gap-5 md:grid-cols-2',
            'xl:grid-cols-3' => count($data['arguments']) === 3,
            'xl:grid-cols-4' => count($data['arguments']) !== 3,
        ])>
            @foreach($data['arguments'] as $argument)
                <article class="rounded-[30px] border border-[#eadfce] bg-[#fbf7ee] p-6">
                    <h3 class="font-display text-xl font-extrabold text-[#171411]">{{ $argument['title'] }}</h3>
                    <p class="mt-4 text-sm leading-7 text-[#5f5146]">{{ $argument['copy'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

@foreach($data['technicalSections'] as $section)
    <section class="{{ $loop->odd ? 'bg-[#fbf7ee]' : 'bg-white' }} py-16 lg:py-20">
        <div class="container mx-auto px-4">
            <div class="mb-9 max-w-4xl">
                <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">{{ $section['eyebrow'] }}</div>
                <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">{{ $section['title'] }}</h2>
                <p class="mt-4 text-lg leading-8 text-[#5f5146]">{{ $section['intro'] }}</p>
            </div>

            <div @class([
                'grid gap-5 md:grid-cols-2',
                'xl:grid-cols-5' => count($section['items']) >= 5,
                'xl:grid-cols-4' => count($section['items']) < 5,
            ])>
                @foreach($section['items'] as $item)
                    <article class="rounded-[28px] border border-[#eadfce] bg-white p-6 {{ $loop->parent->even ? 'xl:bg-[#fbf7ee]' : '' }}">
                        <h3 class="font-display text-lg font-extrabold text-[#171411]">{{ $item['title'] }}</h3>
                        <p class="mt-4 text-sm leading-7 text-[#5f5146]">{{ $item['copy'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endforeach

@if($realizations->isNotEmpty())
<section id="realisations-aluminium" class="bg-[#171411] py-16 text-white lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-9 max-w-3xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#d5b170]">Réalisations aluminium</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold sm:text-4xl">Quelques réalisations liées à cette gamme.</h2>
        </div>

        <div class="grid gap-5 md:grid-cols-3">
            @foreach($realizations as $realization)
                <a href="{{ $realization['url'] }}" class="group relative min-h-[320px] overflow-hidden rounded-[34px] bg-cover bg-center p-6 transition hover:-translate-y-1" style="background-image: linear-gradient(180deg, rgba(23,20,17,0.04), rgba(23,20,17,0.82)), url('{{ $realization['image'] }}');">
                    <div class="relative z-10 flex h-full flex-col justify-between">
                        <span class="inline-flex w-max rounded-full border border-white/15 bg-white/10 px-3 py-1 text-xs font-bold text-[#e7c98d] backdrop-blur">{{ $realization['place'] }}</span>
                        <div>
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

<section class="bg-white py-16 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-10 max-w-3xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Le processus</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">Du métré à la pose, en 4 étapes.</h2>
        </div>

        <div class="grid gap-5 lg:grid-cols-4">
            @foreach($data['process'] as $step)
                <article class="rounded-[30px] border border-[#eadfce] bg-[#fbf7ee] p-6">
                    <div class="font-display text-5xl font-extrabold text-[#a47834]/20">{{ $step['step'] }}</div>
                    <h3 class="font-display mt-5 text-xl font-extrabold text-[#171411]">{{ $step['title'] }}</h3>
                    <p class="mt-4 text-sm leading-7 text-[#5f5146]">{{ $step['copy'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-[#fbf7ee] py-16 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-9 max-w-3xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Questions fréquentes</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">{{ $data['faqTitle'] }}</h2>
        </div>

        <div class="mx-auto max-w-4xl divide-y divide-[#eadfce] rounded-[34px] border border-[#eadfce] bg-white p-2">
            @foreach($data['faqs'] as $faq)
                <details class="group rounded-[26px] px-5 py-4 open:bg-[#fbf7ee]" @if($loop->first) open @endif>
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
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Explorer la menuiserie aluminium</div>
            <h3 class="font-display mt-3 text-2xl font-extrabold text-[#171411] sm:text-3xl">Nos autres produits aluminium.</h3>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-6">
            @foreach($data['internalLinks'] as $link)
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
