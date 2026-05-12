@extends('layouts.store')

@php
    $devisUrl = url('/devis');
    $contactUrl = route('contact');
    $whatsappUrl = \App\Support\SiteSettings::whatsappUrl() ?? $contactUrl;

    $heroImage = asset('assets/home/menuiserie-bois.webp');

    $breadcrumbs = [
        ['name' => 'Accueil', 'url' => route('home')],
        ['name' => 'Menuiserie bois', 'url' => url('/menuiserie-bois')],
    ];

    $reassurance = collect([
        ['value' => 'Atelier intégré', 'label' => 'Bois travaillé en interne, du débit à la pose.', 'icon' => 'fa-solid fa-industry'],
        ['value' => 'Fabrication interne', 'label' => 'Suivi de production plus clair, moins d\'intermédiaires.', 'icon' => 'fa-solid fa-hammer'],
        ['value' => 'Équipement atelier', 'label' => 'Découpe, assemblage, placage, ponçage et finition.', 'icon' => 'fa-solid fa-gears'],
        ['value' => 'Bois & panneaux', 'label' => 'Bois massifs, MDF, mélaminé, placages et finitions.', 'icon' => 'fa-solid fa-tree'],
    ]);

    $fabrications = collect([
        [
            'title' => 'Cuisines sur mesure',
            'copy' => 'Cuisines équipées en bois massif, mélaminé, MDF laqué ou plaqué. Fabrication intégrale en atelier.',
            'href' => url('/sur-mesure/cuisine-sur-mesure'),
            'image' => asset('assets/home/realizations/cuisine-sur-mesure.jpg'),
            'icon' => 'fa-solid fa-kitchen-set',
        ],
        [
            'title' => 'Dressings et placards',
            'copy' => 'Dressings sur mesure pour chambres et entrées, placards muraux et rangements optimisés.',
            'href' => url('/sur-mesure/dressing-sur-mesure'),
            'image' => asset('assets/home/realizations/dressing-sur-mesure.jpg'),
            'icon' => 'fa-solid fa-door-closed',
        ],
        [
            'title' => 'Meubles TV et bibliothèques',
            'copy' => 'Meubles TV sur mesure, bibliothèques murales et rangements salon adaptés à vos dimensions exactes.',
            'href' => url('/sur-mesure/meuble-tv-sur-mesure'),
            'image' => asset('assets/home/amenagement-sur-mesure.jpg'),
            'icon' => 'fa-solid fa-tv',
        ],
        [
            'title' => 'Bureaux et espaces de travail',
            'copy' => 'Bureaux sur mesure pour particuliers et professionnels : plans de travail, caissons et rangements.',
            'href' => url('/sur-mesure/bureau-sur-mesure'),
            'image' => asset('assets/home/amenagement-sur-mesure.jpg'),
            'icon' => 'fa-solid fa-briefcase',
        ],
        [
            'title' => 'Agencement professionnel',
            'copy' => 'Comptoirs, banques d\'accueil et mobilier sur mesure pour cafés, restaurants, boutiques et bureaux.',
            'href' => url('/projets/agencement-cafe-restaurant'),
            'image' => asset('assets/home/realizations/amenagement-restaurant.jpg'),
            'icon' => 'fa-solid fa-store',
        ],
        [
            'title' => 'Ouvrages d\'ébénisterie',
            'copy' => 'Pièces uniques, mobilier d\'exception, habillages bois et projets exigeants avec finitions soignées.',
            'href' => $devisUrl,
            'image' => asset('assets/home/menuiserie-bois.webp'),
            'icon' => 'fa-solid fa-ruler-combined',
        ],
    ]);

    $atelierProofs = collect([
        ['title' => 'Production interne', 'copy' => 'La fabrication bois est suivie dans notre atelier pour garder la maîtrise du rendu, du délai et des ajustements.'],
        ['title' => 'Équipement professionnel', 'copy' => 'Découpe, placage de chants, assemblage, ponçage et finition sont organisés comme une chaîne de production.'],
        ['title' => 'Visite possible', 'copy' => 'Clients et partenaires peuvent demander une visite de l\'atelier sur rendez-vous pour les projets importants.'],
    ]);

    $materials = collect([
        ['title' => 'Bois massifs', 'items' => ['Chêne européen', 'Hêtre', 'Noyer', 'Pin traité', 'Iroko pour extérieur']],
        ['title' => 'Panneaux dérivés', 'items' => ['MDF laqué ou peint', 'Mélaminé qualité européenne', 'Aggloméré stratifié', 'Multiplis pour ouvrages techniques']],
        ['title' => 'Placages bois', 'items' => ['Plaqué chêne', 'Plaqué noyer', 'Placage teinté sur mesure', 'Habillage décoratif bois']],
        ['title' => 'Finitions', 'items' => ['Vernis mat ou satiné', 'Laque polyuréthane', 'Huile naturelle', 'Cire teintée']],
    ]);

    $finishPillars = collect([
        ['title' => 'Précision d\'assemblage', 'copy' => 'Découpes calibrées, alignements propres, ajustements millimétriques et contrôle avant pose.', 'icon' => 'fa-solid fa-compass-drafting'],
        ['title' => 'Qualité des finitions', 'copy' => 'Ponçage, placage, laque, vernis et contrôle visuel pour un rendu stable et durable.', 'icon' => 'fa-solid fa-brush'],
        ['title' => 'Quincaillerie premium', 'copy' => 'Charnières, coulisses, amortisseurs et accessoires sélectionnés selon l\'usage et le niveau d\'exigence.', 'icon' => 'fa-solid fa-screwdriver-wrench'],
    ]);

    $audiences = collect([
        ['title' => 'Particuliers', 'copy' => 'Cuisine équipée, dressings, mobilier sur mesure pour maison ou appartement. Conseil, plans 3D et devis détaillé.', 'cta' => 'Lancer mon projet', 'href' => $devisUrl, 'icon' => 'fa-solid fa-house-chimney'],
        ['title' => 'Architectes & décorateurs', 'copy' => 'Vous concevez, nous fabriquons. Respect des plans, échanges techniques, finitions haut de gamme et interlocuteur dédié.', 'cta' => 'Espace professionnels', 'href' => url('/partenaires'), 'icon' => 'fa-solid fa-drafting-compass'],
        ['title' => 'Professionnels', 'copy' => 'Agencement de cafés, restaurants, boutiques et bureaux. Mobilier de série, coordination logistique et lots professionnels.', 'cta' => 'Dossier pro', 'href' => url('/partenaires'), 'icon' => 'fa-regular fa-building'],
    ]);

    $woodRealizations = collect([
        ['type' => 'Cuisine bois sur mesure', 'place' => 'Résidentiel', 'image' => asset('assets/home/realizations/cuisine-sur-mesure.jpg'), 'copy' => 'Rangements intégrés, plan de travail et finitions coordonnées.'],
        ['type' => 'Dressing sur mesure', 'place' => 'Chambre & rangement', 'image' => asset('assets/home/realizations/dressing-sur-mesure.jpg'), 'copy' => 'Façades propres, optimisation du volume et pose ajustée.'],
        ['type' => 'Coin dressing intégré', 'place' => 'Aménagement intérieur', 'image' => asset('assets/home/amenagement-sur-mesure.jpg'), 'copy' => 'Habillage bois, niches, assise et rangements sur mesure.'],
        ['type' => 'Agencement restaurant', 'place' => 'Projet professionnel', 'image' => asset('assets/home/realizations/amenagement-restaurant.jpg'), 'copy' => 'Mobilier, comptoir et ambiance en cohérence avec le lieu.'],
        ['type' => 'Atelier bois', 'place' => 'Fabrication interne', 'image' => asset('assets/home/menuiserie-bois.webp'), 'copy' => 'Production et contrôle dans notre propre atelier.'],
        ['type' => 'Aménagement extérieur bois', 'place' => 'Extérieur', 'image' => asset('assets/home/realizations/pergola.jpg'), 'copy' => 'Structure et habillage adaptés aux usages extérieurs.'],
    ]);

    $process = collect([
        ['step' => '01', 'title' => 'Étude & conception', 'copy' => 'Visite technique si nécessaire, prise de mesures, choix des matériaux et conception en plans techniques ou 3D.'],
        ['step' => '02', 'title' => 'Devis & validation', 'copy' => 'Devis détaillé sous 48h ouvrées pour les demandes complètes, validation du projet et acompte selon devis.'],
        ['step' => '03', 'title' => 'Fabrication atelier', 'copy' => 'Fabrication dans notre atelier bois avec suivi de production et délai annoncé selon la complexité.'],
        ['step' => '04', 'title' => 'Pose & finitions', 'copy' => 'Livraison, pose par notre équipe, ajustements si nécessaire et garantie atelier active.'],
    ]);

    $faqs = collect([
        ['q' => 'Quels types de bois travaillez-vous ?', 'a' => 'Nous travaillons les bois massifs comme le chêne, le hêtre, le noyer, le pin traité et l\'iroko, ainsi que les panneaux dérivés comme le MDF laqué, le mélaminé, le multiplis et les placages chêne ou noyer.'],
        ['q' => 'Combien coûte un meuble bois sur mesure ?', 'a' => 'Le prix dépend des dimensions, des matériaux, des finitions, de la quincaillerie et de la pose. Nous évitons les prix génériques trompeurs : chaque projet reçoit un devis détaillé après étude.'],
        ['q' => 'Quel est le délai de fabrication d\'un projet bois ?', 'a' => 'Le délai dépend de la taille du projet et des finitions. Un meuble simple est plus rapide qu\'une cuisine complète ou un agencement professionnel. Le délai exact est annoncé dans le devis.'],
        ['q' => 'Faites-vous la pose ou seulement la fabrication ?', 'a' => 'Nous assurons la fabrication et la pose. Pour les cuisines ou projets complexes, les contraintes techniques sont cadrées avant fabrication afin d\'éviter les mauvaises surprises sur site.'],
        ['q' => 'Travaillez-vous avec des architectes et décorateurs ?', 'a' => 'Oui. Nous pouvons fabriquer à partir de plans, échanger sur les détails techniques et accompagner les prescripteurs avec un interlocuteur dédié.'],
        ['q' => 'Le bois utilisé est-il garanti ?', 'a' => 'La structure et les finitions réalisées par l\'atelier sont couvertes par une garantie atelier. Les composants tiers comme charnières et coulisses suivent leur garantie fabricant.'],
        ['q' => 'Peut-on visiter votre atelier bois ?', 'a' => 'Oui, sur rendez-vous. La visite est recommandée pour les projets importants ou pour les professionnels qui veulent évaluer notre capacité de production.'],
    ]);

    $internalLinks = collect([
        ['title' => 'Cuisine sur mesure', 'href' => url('/sur-mesure/cuisine-sur-mesure'), 'copy' => 'Concevoir une cuisine adaptée à vos dimensions.'],
        ['title' => 'Dressing sur mesure', 'href' => url('/sur-mesure/dressing-sur-mesure'), 'copy' => 'Optimiser les rangements de chambre ou d\'entrée.'],
        ['title' => 'Placard sur mesure', 'href' => url('/sur-mesure/placard-sur-mesure'), 'copy' => 'Transformer un mur, une niche ou un couloir.'],
        ['title' => 'Meuble TV sur mesure', 'href' => url('/sur-mesure/meuble-tv-sur-mesure'), 'copy' => 'Créer un meuble salon adapté à votre mur.'],
        ['title' => 'Bureau sur mesure', 'href' => url('/sur-mesure/bureau-sur-mesure'), 'copy' => 'Aménager un espace de travail propre et durable.'],
    ]);
@endphp

@push('head')
<script type="application/ld+json">
{!! json_encode([
    '@' . 'context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Accueil', 'item' => route('home')],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Menuiserie bois', 'item' => url('/menuiserie-bois')],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
<script type="application/ld+json">
{!! json_encode([
    '@' . 'context' => 'https://schema.org',
    '@type' => 'Service',
    'serviceType' => 'Menuiserie bois',
    'name' => 'Menuiserie bois sur mesure en Tunisie',
    'provider' => [
        '@type' => 'LocalBusiness',
        'name' => 'Maison 216',
        'url' => url('/'),
    ],
    'areaServed' => [
        '@type' => 'Country',
        'name' => 'Tunisie',
    ],
    'description' => 'Atelier de menuiserie bois en Tunisie pour cuisines, dressings, meubles et agencements sur mesure.',
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
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_16%_20%,rgba(184,138,59,0.16),transparent_32%),radial-gradient(circle_at_88%_12%,rgba(23,20,17,0.08),transparent_30%)]"></div>
    <div class="container relative mx-auto grid gap-10 px-4 py-14 lg:grid-cols-[0.92fr_1.08fr] lg:items-center lg:py-20">
        <div>
            <div class="inline-flex items-center gap-2 rounded-full border border-[#d8c7af] bg-white/72 px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-[#8b6426]">
                <i class="fa-solid fa-tree"></i>
                Métier · Menuiserie bois
            </div>

            <h1 class="font-display mt-7 max-w-4xl text-4xl font-extrabold leading-[1.02] tracking-[-0.04em] text-[#171411] sm:text-5xl lg:text-6xl">
                Atelier de menuiserie bois en Tunisie.
                <span class="block text-[#a47834]">Cuisines, dressings, agencements sur mesure.</span>
            </h1>

            <p class="mt-6 max-w-3xl text-base leading-8 text-[#55473c] sm:text-lg">
                Notre atelier bois fabrique en interne mobilier sur mesure, agencements résidentiels et commerciaux. Bois massif, MDF laqué, plaqué chêne et noyer. Étude technique, plans 3D, fabrication et pose assurées par notre équipe.
            </p>

            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                <a href="{{ $devisUrl }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#171411] px-7 py-4 text-sm font-extrabold text-white shadow-[0_20px_45px_rgba(23,20,17,0.16)] transition hover:bg-[#a47834]">
                    <i class="fa-regular fa-pen-to-square"></i>
                    Demander un devis bois
                </a>
                <a href="#realisations-bois" class="inline-flex items-center justify-center gap-2 rounded-full border border-[#cdbb9f] bg-white/78 px-7 py-4 text-sm font-extrabold text-[#171411] transition hover:border-[#a47834] hover:bg-white">
                    <i class="fa-regular fa-images"></i>
                    Voir nos réalisations bois
                </a>
            </div>

            <div class="mt-8 flex flex-wrap gap-x-8 gap-y-3 text-sm font-bold text-[#4f4236]">
                @foreach(['Atelier visitable', 'Fabrication 100% interne', 'Devis sous 48h', 'Garantie atelier'] as $item)
                    <span class="inline-flex items-center gap-2">
                        <i class="fa-solid fa-check text-[#a47834]"></i>
                        {{ $item }}
                    </span>
                @endforeach
            </div>
        </div>

        <div class="relative">
            <div class="rounded-[40px] border border-[#d8c7af] bg-white p-3 shadow-[0_36px_90px_rgba(23,20,17,0.16)]">
                <div class="relative min-h-[360px] overflow-hidden rounded-[30px] bg-cover bg-center lg:min-h-[540px]" style="background-image: linear-gradient(180deg, rgba(23,20,17,0.02), rgba(23,20,17,0.34)), url('{{ $heroImage }}');">
                    <div class="absolute bottom-6 left-6 right-6 rounded-[26px] border border-white/18 bg-[#171411]/72 p-5 text-white backdrop-blur">
                        <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#d5b170]">Atelier bois</div>
                        <p class="mt-2 text-sm leading-6 text-white/78">Capacité de production, finitions maîtrisées et suivi de fabrication dans un même lieu.</p>
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
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Notre gamme bois</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">Tout le mobilier et l'agencement bois pour votre projet.</h2>
            <p class="mt-4 text-lg leading-8 text-[#5f5146]">De la cuisine équipée au mobilier de café, notre atelier bois prend en charge tous types d'ouvrages.</p>
        </div>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @foreach($fabrications as $item)
                <a href="{{ $item['href'] }}" class="group overflow-hidden rounded-[32px] border border-[#eadfce] bg-white shadow-[0_18px_45px_rgba(23,20,17,0.05)] transition hover:-translate-y-1 hover:shadow-[0_28px_70px_rgba(23,20,17,0.10)]">
                    <div class="relative min-h-[210px] bg-cover bg-center" style="background-image: linear-gradient(180deg, rgba(23,20,17,0.05), rgba(23,20,17,0.54)), url('{{ $item['image'] }}');">
                        <span class="absolute left-5 top-5 inline-flex h-12 w-12 items-center justify-center rounded-2xl border border-white/20 bg-white/12 text-[#f0d49a] backdrop-blur">
                            <i class="{{ $item['icon'] }}"></i>
                        </span>
                    </div>
                    <div class="p-6">
                        <h3 class="font-display text-xl font-extrabold text-[#171411]">{{ $item['title'] }}</h3>
                        <p class="mt-3 text-sm leading-7 text-[#5f5146]">{{ $item['copy'] }}</p>
                        <div class="mt-5 text-sm font-extrabold text-[#8e6322]">Explorer <i class="fa-solid fa-arrow-right ml-1 text-xs transition group-hover:translate-x-1"></i></div>
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
                <div class="min-h-[360px] bg-cover bg-center lg:min-h-[520px]" style="background-image: linear-gradient(180deg, rgba(23,20,17,0.04), rgba(23,20,17,0.26)), url('{{ $heroImage }}');"></div>
            </div>
        </div>
        <div>
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#d5b170]">L atelier</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold leading-tight sm:text-4xl">Fabriqué en interne, dans notre atelier en Tunisie.</h2>
            <div class="mt-6 space-y-5 text-base leading-8 text-white/72">
                <p>Notre atelier bois est organisé pour traiter l'intégralité d'un projet : étude, débit, usinage, assemblage, placage, ponçage, finition, préparation et pose.</p>
                <p>Nous ne vendons pas une promesse abstraite. Chaque commande bois est suivie de bout en bout avec un interlocuteur clair, un planning annoncé et des ajustements maîtrisés.</p>
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
                Visiter notre atelier
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>
    </div>
</section>

<section class="bg-[#fbf7ee] py-16 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-9 max-w-3xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Matériaux & essences</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">Le bois adapté à votre projet.</h2>
            <p class="mt-4 text-lg leading-8 text-[#5f5146]">Nous sélectionnons et travaillons une gamme d'essences et de panneaux adaptés à chaque usage, chaque rendu et chaque budget.</p>
        </div>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
            @foreach($materials as $material)
                <article class="rounded-[30px] border border-[#eadfce] bg-white p-6">
                    <h3 class="font-display text-xl font-extrabold text-[#171411]">{{ $material['title'] }}</h3>
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
        <div class="grid gap-10 lg:grid-cols-[0.82fr_1.18fr] lg:items-start">
            <div>
                <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Savoir-faire</div>
                <h2 class="font-display mt-3 text-3xl font-extrabold leading-tight text-[#171411] sm:text-4xl">Une exigence de finition rare en Tunisie.</h2>
                <p class="mt-5 text-base leading-8 text-[#5f5146]">La qualité d'un meuble bois se voit dans les détails que personne ne regarde au premier coup d'oeil : l'alignement des chants, la régularité d'une laque, la précision d'un assemblage et la souplesse d'une ouverture.</p>
            </div>

            <div class="grid gap-5 md:grid-cols-3">
                @foreach($finishPillars as $pillar)
                    <article class="rounded-[30px] border border-[#eadfce] bg-[#fbf7ee] p-6">
                        <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-[#171411] text-[#d5b170]">
                            <i class="{{ $pillar['icon'] }}"></i>
                        </div>
                        <h3 class="font-display mt-6 text-xl font-extrabold text-[#171411]">{{ $pillar['title'] }}</h3>
                        <p class="mt-4 text-sm leading-7 text-[#5f5146]">{{ $pillar['copy'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section class="bg-[#fbf7ee] py-16 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-9 max-w-3xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Nos clients bois</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">Particuliers, architectes, professionnels.</h2>
        </div>

        <div class="grid gap-5 lg:grid-cols-3">
            @foreach($audiences as $audience)
                <article class="rounded-[32px] border border-[#eadfce] bg-white p-7">
                    <div class="inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-[#171411] text-xl text-[#d5b170]">
                        <i class="{{ $audience['icon'] }}"></i>
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

<section id="realisations-bois" class="bg-[#171411] py-16 text-white lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-9 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-3xl">
                <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#d5b170]">Réalisations bois</div>
                <h2 class="font-display mt-3 text-3xl font-extrabold sm:text-4xl">Quelques projets bois récents.</h2>
            </div>
            <a href="#realisations-bois" class="text-sm font-extrabold text-[#d5b170]">Voir toutes nos réalisations bois</a>
        </div>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @foreach($woodRealizations as $realization)
                <article class="group relative min-h-[330px] overflow-hidden rounded-[34px] bg-cover bg-center p-6 shadow-[0_20px_55px_rgba(0,0,0,0.20)]" style="background-image: linear-gradient(180deg, rgba(23,20,17,0.04), rgba(23,20,17,0.78)), url('{{ $realization['image'] }}');">
                    <div class="relative z-10 flex h-full flex-col justify-between">
                        <span class="inline-flex w-max rounded-full border border-white/15 bg-white/10 px-3 py-1 text-xs font-bold text-[#e7c98d] backdrop-blur">{{ $realization['place'] }}</span>
                        <div>
                            <h3 class="font-display text-2xl font-extrabold">{{ $realization['type'] }}</h3>
                            <p class="mt-2 text-sm leading-6 text-white/76">{{ $realization['copy'] }}</p>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-white py-16 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-10 max-w-3xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Le processus</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">De votre idée au meuble livré, en 4 étapes.</h2>
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
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">Tout ce que vous voulez savoir sur la menuiserie bois.</h2>
        </div>

        <div class="mx-auto max-w-4xl divide-y divide-[#eadfce] rounded-[34px] border border-[#eadfce] bg-white p-2">
            @foreach($faqs as $faq)
                <details class="group rounded-[26px] px-5 py-4 open:bg-[#fbf7ee]">
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
        <h2 class="font-display text-3xl font-extrabold sm:text-5xl">Un projet en menuiserie bois ?</h2>
        <p class="mx-auto mt-4 max-w-2xl text-lg leading-8 text-white/72">Recevez un devis détaillé sous 48h pour une demande complète. Consultation, étude et plans 3D selon le projet.</p>
        <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
            <a href="{{ $devisUrl }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#d5b170] px-7 py-4 text-sm font-extrabold text-[#171411]">
                <i class="fa-regular fa-pen-to-square"></i>
                Demander un devis bois
            </a>
            <a href="{{ $whatsappUrl }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-white/15 px-7 py-4 text-sm font-extrabold text-white">
                <i class="fa-brands fa-whatsapp"></i>
                WhatsApp atelier bois
            </a>
        </div>
    </div>
</section>

<section class="bg-[#fbf7ee] py-14 lg:py-16">
    <div class="container mx-auto px-4">
        <div class="mb-7 max-w-3xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Explorer le sur-mesure bois</div>
            <h3 class="font-display mt-3 text-2xl font-extrabold text-[#171411] sm:text-3xl">Nos pages dédiées par type de projet.</h3>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-5">
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
