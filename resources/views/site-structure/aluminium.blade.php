@extends('layouts.store')

@php
    $devisUrl = url('/devis');
    $contactUrl = route('contact');
    $whatsappUrl = \App\Support\SiteSettings::whatsappUrl() ?? $contactUrl;

    $heroImage = asset('assets/home/menuiserie-aluminium.jpg');
    $voletImage = asset('assets/home/realizations/volet-roulant-aluminium.webp');
    $pergolaImage = asset('assets/home/realizations/pergola.jpg');
    $portailImage = asset('assets/home/realizations/portail-metal.jpg');
    $restaurantImage = asset('assets/home/realizations/amenagement-restaurant.jpg');
    $surMesureImage = asset('assets/home/amenagement-sur-mesure.jpg');

    $breadcrumbs = [
        ['name' => 'Accueil', 'url' => route('home')],
        ['name' => 'Menuiserie aluminium', 'url' => url('/aluminium')],
    ];

    $heroProofs = collect([
        ['label' => 'Profilés à RPT', 'icon' => 'fa-solid fa-temperature-half'],
        ['label' => 'Double vitrage isolant', 'icon' => 'fa-regular fa-square'],
        ['label' => 'Pose par notre équipe', 'icon' => 'fa-solid fa-screwdriver-wrench'],
        ['label' => 'Garantie atelier', 'icon' => 'fa-solid fa-shield-halved'],
    ]);

    $technicalBadges = collect([
        ['eyebrow' => 'Fabrication alu', 'title' => 'Découpe profilés', 'icon' => 'fa-solid fa-scissors'],
        ['eyebrow' => 'Vitrage', 'title' => 'Double isolant', 'icon' => 'fa-regular fa-window-maximize'],
        ['eyebrow' => 'Thermolaquage', 'title' => 'Teintes RAL', 'icon' => 'fa-solid fa-spray-can-sparkles'],
        ['eyebrow' => 'RPT', 'title' => 'Rupture pont thermique', 'icon' => 'fa-solid fa-temperature-half'],
    ]);

    $reassurance = collect([
        ['value' => 'Profilés certifiés', 'label' => 'Gammes aluminium conformes aux standards fabricant.', 'icon' => 'fa-solid fa-certificate'],
        ['value' => 'Double vitrage', 'label' => 'Solutions isolantes selon contraintes du projet.', 'icon' => 'fa-regular fa-square'],
        ['value' => 'Atelier alu dédié', 'label' => 'Découpe, assemblage, vitrage et finition suivis.', 'icon' => 'fa-solid fa-industry'],
        ['value' => 'Équipement complet', 'label' => 'Cisaille, sertissage, presse et contrôle qualité.', 'icon' => 'fa-solid fa-gears'],
    ]);

    $products = collect([
        [
            'eyebrow' => 'Fenêtre',
            'title' => 'Fenêtres aluminium',
            'copy' => 'Fenêtres battantes, oscillo-battantes, coulissantes. Profilés à rupture de pont thermique, double vitrage isolant.',
            'href' => url('/aluminium/fenetre-aluminium'),
            'image' => $heroImage,
            'icon' => 'fa-regular fa-window-maximize',
        ],
        [
            'eyebrow' => 'Porte',
            'title' => 'Portes aluminium',
            'copy' => 'Portes d’entrée, portes-fenêtres, baies coulissantes. Sécurité renforcée, isolation thermique et acoustique.',
            'href' => url('/aluminium/porte-aluminium'),
            'image' => $heroImage,
            'icon' => 'fa-solid fa-door-open',
        ],
        [
            'eyebrow' => 'B2B',
            'title' => 'Vitrines de magasin',
            'copy' => 'Vitrines commerciales, devantures et façades vitrées pour boutiques, cafés, restaurants et agences.',
            'href' => $devisUrl,
            'image' => $restaurantImage,
            'icon' => 'fa-solid fa-store',
        ],
        [
            'eyebrow' => 'Garde-corps',
            'title' => 'Garde-corps aluminium',
            'copy' => 'Garde-corps balcon, terrasse ou escalier. Aluminium plein, à barreaux ou avec vitrage sécurisé.',
            'href' => url('/aluminium/garde-corps'),
            'image' => $pergolaImage,
            'icon' => 'fa-solid fa-grip-lines-vertical',
        ],
        [
            'eyebrow' => 'Volet',
            'title' => 'Volets roulants',
            'copy' => 'Volets roulants manuels ou motorisés. Lames aluminium isolées, coffres en applique ou intégrés.',
            'href' => url('/aluminium/volet-roulant'),
            'image' => $voletImage,
            'icon' => 'fa-solid fa-bars-staggered',
        ],
        [
            'eyebrow' => 'Protection',
            'title' => 'Moustiquaires & brise-soleil',
            'copy' => 'Moustiquaires enroulables ou plissées, brise-soleil fixes ou orientables. Protection insectes et solaire.',
            'href' => url('/aluminium/moustiquaire'),
            'image' => $heroImage,
            'icon' => 'fa-solid fa-shield-halved',
        ],
    ]);

    $atelierProofs = collect([
        ['title' => 'Fabrication interne', 'copy' => 'Découpe, assemblage, vitrage, étanchéité et contrôle qualité sont suivis par notre atelier.'],
        ['title' => 'Profilés techniques', 'copy' => 'Rupture de pont thermique, profils renforcés, vitrages adaptés et finitions selon usage.'],
        ['title' => 'Pose par notre équipe', 'copy' => 'Métré, calfeutrement, étanchéité, réglages et SAV sont gérés avec un interlocuteur clair.'],
    ]);

    $performance = collect([
        ['title' => 'Rupture de pont thermique', 'eyebrow' => 'Isolation thermique', 'copy' => 'Profilés RPT avec barrette isolante selon besoin. Objectif : réduire les déperditions et améliorer le confort intérieur.', 'icon' => 'fa-solid fa-temperature-half'],
        ['title' => 'Double vitrage isolant', 'eyebrow' => 'Vitrage', 'copy' => 'Solutions double vitrage 4/16/4 ou équivalent selon projet. Options possibles : sécurité, acoustique ou contrôle solaire.', 'icon' => 'fa-regular fa-square'],
        ['title' => 'Étanchéité A·E·V', 'eyebrow' => 'Étanchéité', 'copy' => 'Choix de profilés et pose adaptés à la perméabilité à l’air, à l’étanchéité à l’eau et à la résistance au vent.', 'icon' => 'fa-solid fa-wind'],
        ['title' => 'Quincaillerie durable', 'eyebrow' => 'Quincaillerie', 'copy' => 'Crémones, paumelles, poignées, ferrures et accessoires sélectionnés selon la fréquence d’usage.', 'icon' => 'fa-solid fa-screwdriver-wrench'],
    ]);

    $materials = collect([
        ['title' => 'Profilés', 'items' => ['Avec rupture pont thermique', 'Sans rupture pour budgets maîtrisés', 'Profilés renforcés', 'Profilés grande hauteur']],
        ['title' => 'Types d’ouverture', 'items' => ['Battant', 'Oscillo-battant', 'Coulissant 2 ou 3 vantaux', 'Coulissant à galandage', 'Fixe']],
        ['title' => 'Vitrages', 'items' => ['Double vitrage 4/16/4', 'Double vitrage argon selon projet', 'Vitrage feuilleté sécurité', 'Vitrage à contrôle solaire', 'Vitrage acoustique']],
        ['title' => 'Finitions', 'items' => ['Thermolaquage RAL au choix', 'Effet bois selon disponibilité', 'Anodisation selon gamme', 'Mat, satiné, brillant', 'Bicoloration intérieur / extérieur']],
    ]);

    $audiences = collect([
        ['title' => 'Promoteurs & entrepreneurs', 'eyebrow' => 'B2B prioritaire', 'copy' => 'Programmes neufs, lots multiples, contrats-cadres. Coordination chantier, livraisons phasées, planning aligné sur le bâti.', 'cta' => 'Dossier promoteur', 'href' => url('/projets/agencement-immobilier-neuf'), 'icon' => 'fa-regular fa-building'],
        ['title' => 'Particuliers', 'eyebrow' => 'Maison & rénovation', 'copy' => 'Construction neuve, rénovation, remplacement de menuiseries existantes. Visite technique, conseil et devis détaillé sous 48h.', 'cta' => 'Lancer mon projet', 'href' => $devisUrl, 'icon' => 'fa-solid fa-house-chimney'],
        ['title' => 'Commerces & boutiques', 'eyebrow' => 'Façades vitrées', 'copy' => 'Vitrines de magasin, devantures de café, façades vitrées de restaurant. Pose organisée pour réduire l’impact sur l’exploitation.', 'cta' => 'Devis vitrine', 'href' => $devisUrl, 'icon' => 'fa-solid fa-shop'],
    ]);

    $realizations = collect([
        ['type' => 'Fenêtres RPT', 'place' => 'Programme neuf', 'image' => $heroImage, 'copy' => 'Menuiseries aluminium pour logements avec isolation renforcée.'],
        ['type' => 'Vitrine commerciale', 'place' => 'Boutique', 'image' => $restaurantImage, 'copy' => 'Devanture vitrée et accès aluminium pour local professionnel.'],
        ['type' => 'Baie coulissante', 'place' => 'Villa', 'image' => $heroImage, 'copy' => 'Grande ouverture, vitrage isolant et réglage précis à la pose.'],
        ['type' => 'Garde-corps aluminium', 'place' => 'Terrasse', 'image' => $pergolaImage, 'copy' => 'Protection propre pour extérieur, terrasse et escalier.'],
        ['type' => 'Volets roulants', 'place' => 'Maison familiale', 'image' => $voletImage, 'copy' => 'Protection solaire et confort quotidien, manuel ou motorisé.'],
        ['type' => 'Structure extérieure', 'place' => 'Aménagement extérieur', 'image' => $portailImage, 'copy' => 'Ouvrage coordonné avec aluminium, métal et finitions atelier.'],
    ]);
    $realizations = app(\App\Support\RealizationResolver::class)->forPage('aluminium', 6, 'aluminium');

    $process = collect([
        ['step' => '01', 'title' => 'Métré sur place', 'copy' => 'Visite technique, prise de cotes précises, conseil sur profilés, vitrages et types d’ouverture.'],
        ['step' => '02', 'title' => 'Devis détaillé', 'copy' => 'Chiffrage poste par poste sous 48h pour une demande complète. Validation, signature et acompte selon devis.'],
        ['step' => '03', 'title' => 'Fabrication atelier', 'copy' => 'Découpe, assemblage, vitrage, finition et contrôle qualité. Délai annoncé selon le volume.'],
        ['step' => '04', 'title' => 'Pose & étanchéité', 'copy' => 'Pose par notre équipe, calfeutrement, étanchéité, réglages, finitions et garantie atelier active.'],
    ]);

    $faqs = collect([
        ['q' => 'Pourquoi choisir la menuiserie aluminium plutôt que PVC ou bois ?', 'a' => 'L’aluminium combine durabilité, finesse des profilés, résistance climatique et liberté de finition. Avec rupture de pont thermique et double vitrage, il permet de très bonnes performances d’isolation tout en autorisant de grandes ouvertures.'],
        ['q' => 'Quel est le prix d’une fenêtre aluminium en Tunisie ?', 'a' => 'Le prix dépend des dimensions, du type d’ouverture, du vitrage, de la rupture de pont thermique, de la couleur et des contraintes de pose. Le devis poste par poste reste la seule base fiable.'],
        ['q' => 'Qu’est-ce que la rupture de pont thermique ?', 'a' => 'La rupture de pont thermique consiste à séparer les faces intérieure et extérieure du profilé par une barrette isolante. Elle limite les transferts de chaleur et améliore le confort intérieur.'],
        ['q' => 'Quelles marques de profilés et de quincaillerie utilisez-vous ?', 'a' => 'Nous sélectionnons les profilés, vitrages et quincailleries selon le niveau de performance attendu, le budget et la disponibilité. Les références précises sont indiquées dans le devis.'],
        ['q' => 'Quel est le délai pour des fenêtres ou portes aluminium sur mesure ?', 'a' => 'Le délai dépend du volume, de la finition, du vitrage et des contraintes chantier. Une petite commande est plus rapide qu’un lot complet pour programme neuf. Le délai est annoncé dans le devis.'],
        ['q' => 'Travaillez-vous avec les promoteurs et programmes neufs ?', 'a' => 'Oui. Nous pouvons organiser les lots, phaser les livraisons, coordonner les métrés et travailler sur planning chantier avec un interlocuteur dédié.'],
        ['q' => 'Pouvez-vous remplacer mes anciennes menuiseries sans casser le mur ?', 'a' => 'Dans beaucoup de cas, oui. Une visite technique permet de vérifier l’état du dormant, les dimensions, les reprises nécessaires et le type de pose le plus propre.'],
        ['q' => 'Quelle garantie offrez-vous sur la menuiserie alu et la pose ?', 'a' => 'Les fabrications et la pose sont couvertes par une garantie atelier. Les composants tiers comme quincaillerie, moteurs et accessoires suivent leur garantie fabricant.'],
    ]);

    $internalLinks = collect([
        ['title' => 'Fenêtre aluminium', 'href' => url('/aluminium/fenetre-aluminium'), 'copy' => 'RPT, double vitrage, rénovation ou neuf.'],
        ['title' => 'Porte aluminium', 'href' => url('/aluminium/porte-aluminium'), 'copy' => 'Entrée, porte-fenêtre, baie coulissante.'],
        ['title' => 'Garde-corps alu', 'href' => url('/aluminium/garde-corps'), 'copy' => 'Balcon, terrasse, escalier.'],
        ['title' => 'Volet roulant', 'href' => url('/aluminium/volet-roulant'), 'copy' => 'Manuel ou motorisé.'],
        ['title' => 'Moustiquaire alu', 'href' => url('/aluminium/moustiquaire'), 'copy' => 'Enroulable, plissée, discrète.'],
        ['title' => 'Brise-soleil', 'href' => url('/aluminium/brise-soleil'), 'copy' => 'Orientable ou fixe selon façade.'],
    ]);
@endphp

@push('head')
<script type="application/ld+json">
{!! json_encode([
    '@' . 'context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Accueil', 'item' => route('home')],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Menuiserie aluminium', 'item' => url('/aluminium')],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
<script type="application/ld+json">
{!! json_encode([
    '@' . 'context' => 'https://schema.org',
    '@type' => 'Service',
    'serviceType' => 'Menuiserie aluminium',
    'name' => 'Menuiserie aluminium sur mesure en Tunisie',
    'provider' => [
        '@type' => 'LocalBusiness',
        'name' => 'Maison 216',
        'url' => url('/'),
    ],
    'areaServed' => [
        '@type' => 'Country',
        'name' => 'Tunisie',
    ],
    'description' => 'Atelier de menuiserie aluminium en Tunisie pour fenêtres, portes, garde-corps, volets roulants, moustiquaires et brise-soleil.',
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
<script type="application/ld+json">
{!! json_encode([
    '@' . 'context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => $faqs->map(fn ($faq) => [
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
                Métier · Menuiserie aluminium
            </div>

            <h1 class="font-display mt-7 max-w-4xl text-4xl font-extrabold leading-[1.02] tracking-[-0.04em] text-[#171411] sm:text-5xl lg:text-6xl">
                Menuiserie aluminium en Tunisie.
                <span class="block text-[#a47834]">Fenêtres, portes, vitrines sur mesure, fabriquées en atelier.</span>
            </h1>

            <p class="mt-6 max-w-3xl text-base leading-8 text-[#55473c] sm:text-lg">
                Notre atelier aluminium produit l'ensemble de la menuiserie alu de votre projet : fenêtres à rupture de pont thermique, portes vitrées, vitrines de magasin, garde-corps, volets roulants, moustiquaires et brise-soleil. Profilés haut de gamme, double vitrage et finitions coordonnées.
            </p>

            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                <a href="{{ $devisUrl }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#171411] px-7 py-4 text-sm font-extrabold text-white shadow-[0_20px_45px_rgba(23,20,17,0.16)] transition hover:bg-[#a47834]">
                    <i class="fa-regular fa-clipboard"></i>
                    Demander un devis alu
                </a>
                @if($realizations->isNotEmpty())
                    <a href="#realisations-alu" class="inline-flex items-center justify-center gap-2 rounded-full border border-[#cdbb9f] bg-white/78 px-7 py-4 text-sm font-extrabold text-[#171411] transition hover:border-[#a47834] hover:bg-white">
                        <i class="fa-regular fa-images"></i>
                        Voir nos réalisations alu
                    </a>
                @endif
            </div>

            <div class="mt-8 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($heroProofs as $proof)
                    <span class="inline-flex items-center gap-2 text-sm font-bold text-[#4f4236]">
                        <i class="{{ $proof['icon'] }} text-[#a47834]"></i>
                        {{ $proof['label'] }}
                    </span>
                @endforeach
            </div>
        </div>

        <div class="relative">
            <div class="rounded-[40px] border border-[#d8c7af] bg-white p-3 shadow-[0_36px_90px_rgba(23,20,17,0.16)]">
                <div class="relative min-h-[360px] overflow-hidden rounded-[30px] bg-cover bg-center lg:min-h-[540px]" style="background-image: linear-gradient(180deg, rgba(23,20,17,0.02), rgba(23,20,17,0.52)), url('{{ $heroImage }}');">
                    <div class="absolute inset-x-5 bottom-5 grid gap-3 sm:grid-cols-2">
                        @foreach($technicalBadges as $badge)
                            <div class="rounded-[22px] border border-white/16 bg-[#171411]/70 p-4 text-white backdrop-blur">
                                <i class="{{ $badge['icon'] }} text-lg text-[#d5b170]"></i>
                                <div class="mt-4 text-[11px] font-bold uppercase tracking-[0.18em] text-[#d5b170]">{{ $badge['eyebrow'] }}</div>
                                <div class="mt-1 font-display text-lg font-extrabold">{{ $badge['title'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="border-b border-[#eadfce] bg-white">
    <div class="container mx-auto grid gap-0 px-4 py-6 sm:grid-cols-2 lg:grid-cols-4">
        @foreach($reassurance as $item)
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
        <div class="mb-9 max-w-3xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Notre gamme aluminium</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">Toute la menuiserie alu pour votre projet.</h2>
            <p class="mt-4 text-lg leading-8 text-[#5f5146]">Du logement neuf à la rénovation, de la villa au commerce : nous fabriquons les ouvrages aluminium dont votre projet a besoin.</p>
        </div>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @foreach($products as $item)
                <a href="{{ $item['href'] }}" class="group overflow-hidden rounded-[32px] border border-[#eadfce] bg-white shadow-[0_18px_45px_rgba(23,20,17,0.05)] transition hover:-translate-y-1 hover:shadow-[0_28px_70px_rgba(23,20,17,0.10)]">
                    <div class="relative min-h-[220px] bg-cover bg-center" style="background-image: linear-gradient(180deg, rgba(23,20,17,0.04), rgba(23,20,17,0.62)), url('{{ $item['image'] }}');">
                        <span class="absolute left-5 top-5 rounded-full border border-white/20 bg-white/12 px-3 py-1 text-xs font-extrabold uppercase tracking-[0.18em] text-[#f0d49a] backdrop-blur">{{ $item['eyebrow'] }}</span>
                        <span class="absolute bottom-5 left-5 inline-flex h-12 w-12 items-center justify-center rounded-2xl border border-white/20 bg-white/12 text-[#f0d49a] backdrop-blur">
                            <i class="{{ $item['icon'] }}"></i>
                        </span>
                    </div>
                    <div class="p-6">
                        <h3 class="font-display text-xl font-extrabold text-[#171411]">{{ $item['title'] }}</h3>
                        <p class="mt-3 text-sm leading-7 text-[#5f5146]">{{ $item['copy'] }}</p>
                        <div class="mt-5 text-sm font-extrabold text-[#8e6322]">Découvrir <i class="fa-solid fa-arrow-right ml-1 text-xs transition group-hover:translate-x-1"></i></div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-[#171411] py-16 text-white lg:py-20">
    <div class="container mx-auto grid gap-10 px-4 lg:grid-cols-[1.25fr_0.75fr] lg:items-center">
        <div>
            <div class="overflow-hidden rounded-[38px] border border-white/10">
                <div class="min-h-[360px] bg-cover bg-center lg:min-h-[520px]" style="background-image: linear-gradient(180deg, rgba(23,20,17,0.04), rgba(23,20,17,0.38)), url('{{ $heroImage }}');"></div>
            </div>
            <div class="mt-4 grid gap-4 sm:grid-cols-3">
                @foreach(['Cisaille · sertisseuse · presse', 'Découpe et pose vitrage', 'Finitions et teintes coordonnées'] as $label)
                    <div class="rounded-[22px] border border-white/10 bg-white/6 p-4 text-sm font-bold text-white/76">{{ $label }}</div>
                @endforeach
            </div>
        </div>
        <div>
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#d5b170]">L atelier alu</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold leading-tight sm:text-4xl">Fabrication alu intégrale, dans notre atelier.</h2>
            <div class="mt-6 space-y-5 text-base leading-8 text-white/72">
                <p>Notre atelier aluminium prend en charge le processus : débit des profilés, usinage, sertissage, pose des vitrages, étanchéité, réglages et contrôle qualité.</p>
                <p>Nous travaillons sur cotes précises après visite technique, avec des profilés adaptés au niveau d’isolation attendu, à l’usage et au budget.</p>
            </div>

            <div class="mt-8 grid gap-4">
                @foreach($atelierProofs as $proof)
                    <div class="rounded-[24px] border border-white/10 bg-white/6 p-5">
                        <h3 class="font-display text-lg font-extrabold text-white">{{ $proof['title'] }}</h3>
                        <p class="mt-2 text-sm leading-7 text-white/66">{{ $proof['copy'] }}</p>
                    </div>
                @endforeach
            </div>

            <a href="{{ $contactUrl }}" class="mt-8 inline-flex items-center gap-2 rounded-full border border-white/15 px-6 py-4 text-sm font-extrabold text-white transition hover:bg-white hover:text-[#171411]">
                Visiter l'atelier alu
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>
    </div>
</section>

<section class="bg-white py-16 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-9 max-w-3xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Performance technique</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">Une menuiserie alu qui tient ses promesses techniques.</h2>
            <p class="mt-4 text-lg leading-8 text-[#5f5146]">L’aluminium n’est pas qu’une question de profilé. C’est l’isolation, l’étanchéité, le vitrage, la quincaillerie et surtout la précision de pose.</p>
        </div>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
            @foreach($performance as $item)
                <article class="rounded-[30px] border border-[#eadfce] bg-[#fbf7ee] p-6">
                    <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-[#171411] text-[#d5b170]">
                        <i class="{{ $item['icon'] }}"></i>
                    </div>
                    <div class="mt-6 text-xs font-bold uppercase tracking-[0.18em] text-[#a47834]">{{ $item['eyebrow'] }}</div>
                    <h3 class="font-display mt-2 text-xl font-extrabold text-[#171411]">{{ $item['title'] }}</h3>
                    <p class="mt-4 text-sm leading-7 text-[#5f5146]">{{ $item['copy'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-[#fbf7ee] py-16 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-9 max-w-3xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Matériaux & finitions</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">L’aluminium adapté à votre projet.</h2>
            <p class="mt-4 text-lg leading-8 text-[#5f5146]">Profilés, types d’ouverture, vitrages et finitions : le choix technique doit être cohérent avec le lieu, l’usage et le budget.</p>
        </div>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
            @foreach($materials as $index => $material)
                <article class="rounded-[30px] border border-[#eadfce] bg-white p-6">
                    <div class="text-xs font-bold uppercase tracking-[0.18em] text-[#a47834]">Catégorie {{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</div>
                    <h3 class="font-display mt-2 text-xl font-extrabold text-[#171411]">{{ $material['title'] }}</h3>
                    <ul class="mt-5 space-y-3 text-sm font-semibold text-[#5f5146]">
                        @foreach($material['items'] as $materialItem)
                            <li class="flex gap-3">
                                <i class="fa-solid fa-check mt-1 text-xs text-[#a47834]"></i>
                                <span>{{ $materialItem }}</span>
                            </li>
                        @endforeach
                    </ul>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-white py-16 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-9 max-w-3xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Nos clients alu</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">Promoteurs, particuliers, commerces.</h2>
        </div>

        <div class="grid gap-5 lg:grid-cols-3">
            @foreach($audiences as $audience)
                <article class="rounded-[32px] border border-[#eadfce] bg-[#fbf7ee] p-7">
                    <div class="flex items-start justify-between gap-4">
                        <div class="inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-[#171411] text-xl text-[#d5b170]">
                            <i class="{{ $audience['icon'] }}"></i>
                        </div>
                        <span class="rounded-full border border-[#d8c7af] bg-white px-3 py-1 text-[11px] font-bold uppercase tracking-[0.16em] text-[#8e6322]">{{ $audience['eyebrow'] }}</span>
                    </div>
                    <h3 class="font-display mt-6 text-2xl font-extrabold text-[#171411]">{{ $audience['title'] }}</h3>
                    <p class="mt-4 text-base leading-8 text-[#5f5146]">{{ $audience['copy'] }}</p>
                    <a href="{{ $audience['href'] }}" class="mt-7 inline-flex items-center gap-2 text-sm font-extrabold text-[#8e6322]">
                        {{ $audience['cta'] }}
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </article>
            @endforeach
        </div>
    </div>
</section>

@if($realizations->isNotEmpty())
<section id="realisations-alu" class="bg-[#171411] py-16 text-white lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-9 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-3xl">
                <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#d5b170]">Réalisations alu</div>
                <h2 class="font-display mt-3 text-3xl font-extrabold sm:text-4xl">Quelques chantiers aluminium récents.</h2>
            </div>
            <a href="{{ route('realizations.index', ['silo' => 'aluminium']) }}" class="text-sm font-extrabold text-[#d5b170]">Voir toutes nos réalisations alu</a>
        </div>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @foreach($realizations as $realization)
                <a href="{{ $realization['url'] }}" class="group relative min-h-[330px] overflow-hidden rounded-[34px] bg-cover bg-center p-6 shadow-[0_20px_55px_rgba(0,0,0,0.20)] transition hover:-translate-y-1 hover:shadow-[0_28px_80px_rgba(0,0,0,0.25)]" style="background-image: linear-gradient(180deg, rgba(23,20,17,0.04), rgba(23,20,17,0.80)), url('{{ $realization['image'] }}');">
                    <div class="relative z-10 flex h-full flex-col justify-between">
                        <span class="inline-flex w-max rounded-full border border-white/15 bg-white/10 px-3 py-1 text-xs font-bold text-[#e7c98d] backdrop-blur">{{ $realization['place'] }}</span>
                        <div>
                            <h3 class="font-display text-2xl font-extrabold">{{ $realization['type'] }}</h3>
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
            @foreach($process as $step)
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
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">Tout ce que vous voulez savoir sur la menuiserie alu.</h2>
        </div>

        <div class="mx-auto max-w-4xl divide-y divide-[#eadfce] rounded-[34px] border border-[#eadfce] bg-white p-2">
            @foreach($faqs as $faq)
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
        <h2 class="font-display text-3xl font-extrabold sm:text-5xl">Un projet en menuiserie aluminium ?</h2>
        <p class="mx-auto mt-4 max-w-2xl text-lg leading-8 text-white/72">Recevez un devis détaillé sous 48h pour une demande complète. Métré, conseil technique et choix des profilés inclus.</p>
        <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
            <a href="{{ $devisUrl }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#d5b170] px-7 py-4 text-sm font-extrabold text-[#171411]">
                <i class="fa-regular fa-clipboard"></i>
                Demander un devis alu
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
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Explorer la menuiserie alu</div>
            <h3 class="font-display mt-3 text-2xl font-extrabold text-[#171411] sm:text-3xl">Nos pages dédiées par produit aluminium.</h3>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-6">
            @foreach($internalLinks as $link)
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
