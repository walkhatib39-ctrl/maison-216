@extends('layouts.store')

@php
    $devisUrl = url('/devis');
    $contactUrl = route('contact');
    $whatsappUrl = \App\Support\SiteSettings::whatsappUrl() ?? $contactUrl;

    $heroImage = asset('assets/home/fabrication-metallique.jpg');
    $portailImage = asset('assets/home/realizations/portail-metal.jpg');
    $pergolaImage = asset('assets/home/realizations/pergola.jpg');
    $restaurantImage = asset('assets/home/realizations/amenagement-restaurant.jpg');
    $boisImage = asset('assets/home/menuiserie-bois.webp');
    $surMesureImage = asset('assets/home/amenagement-sur-mesure.jpg');
    $metalRealizations = app(\App\Support\RealizationResolver::class)->forPage('fer-metal', 6, 'fer-metal');

    $breadcrumbs = [
        ["name" => "Accueil", "url" => route('home')],
        ["name" => "Fabrication métallique", "url" => url('/fer-metal')],
    ];

    $heroProofs = collect([
        ["label" => "Fabrication interne", "icon" => "fa-solid fa-industry"],
        ["label" => "Traitement anti-corrosion", "icon" => "fa-solid fa-shield-halved"],
        ["label" => "Pose incluse selon projet", "icon" => "fa-solid fa-screwdriver-wrench"],
        ["label" => "Garantie atelier", "icon" => "fa-solid fa-certificate"],
    ]);

    $reassurance = collect([
        ["value" => "Atelier métal dédié", "label" => "Découpe, assemblage, soudure, finition et contrôle.", "icon" => "fa-solid fa-fire-flame-curved"],
        ["value" => "Fabrication sur mesure", "label" => "Dimensions, style, usage et contraintes du lieu.", "icon" => "fa-solid fa-ruler-combined"],
        ["value" => "Anti-corrosion traité", "label" => "Préparation de surface et finition adaptées à l’exposition.", "icon" => "fa-solid fa-shield-halved"],
        ["value" => "Pose & SAV inclus", "label" => "Installation, réglages et suivi avec un seul interlocuteur.", "icon" => "fa-solid fa-helmet-safety"],
    ]);

    $products = collect([
        [
            "title" => "Portails fer forgé & métalliques",
            "copy" => "Portails battants ou coulissants, manuels ou motorisés. Design classique fer forgé, contemporain pleine tôle, semi-ajouré ou avec soubassement. Fabriqué sur mesure selon vos dimensions et votre style.",
            "href" => url('/fer-metal/portail-fer-forge'),
            "image" => $portailImage,
            "tags" => ["Battant", "Coulissant", "Motorisé", "Fer forgé"],
            "icon" => "fa-solid fa-door-open",
        ],
        [
            "title" => "Pergolas métalliques",
            "copy" => "Pergolas adossées ou autoportées, terrasses couvertes et structures extérieures pour jardins de villa, restaurants et espaces commerciaux.",
            "href" => url('/fer-metal/pergola-metallique'),
            "image" => $pergolaImage,
            "tags" => ["Adossée", "Autoportée", "Terrasse CHR"],
            "icon" => "fa-solid fa-warehouse",
        ],
        [
            "title" => "Escaliers métalliques",
            "copy" => "Escaliers droits, hélicoïdaux ou suspendus, avec marches bois, métal ou verre selon le style recherché. Pour mezzanines, duplex, villas et espaces professionnels.",
            "href" => url('/fer-metal/escalier-metallique'),
            "image" => $heroImage,
            "tags" => ["Droit", "Hélicoïdal", "Suspendu"],
            "icon" => "fa-solid fa-stairs",
        ],
        [
            "title" => "Garde-corps métalliques",
            "copy" => "Garde-corps pour balcons, terrasses, escaliers intérieurs ou extérieurs. Fer forgé classique, acier laqué contemporain, inox ou combinaison verre et métal.",
            "href" => url('/fer-metal/garde-corps'),
            "image" => $surMesureImage,
            "tags" => ["Balcon", "Terrasse", "Escalier", "Inox"],
            "icon" => "fa-solid fa-grip-lines-vertical",
        ],
    ]);

    $atelierProofs = collect([
        ["title" => "Fabrication interne complète", "copy" => "La conception, le façonnage, l’assemblage, la finition et la pose sont suivis avec un interlocuteur clair."],
        ["title" => "Traitement anti-corrosion intégré", "copy" => "Préparation de surface, primaire de protection et finition sont choisis selon l’exposition de l’ouvrage."],
        ["title" => "Visite possible", "copy" => "Pour les projets importants, vous pouvez demander une visite de l’atelier ou un point de suivi sur rendez-vous."],
    ]);

    $durability = collect([
        ["title" => "Préparation de la surface", "copy" => "Avant toute finition, chaque pièce est préparée, décapée ou dégraissée selon son état. C’est cette étape qui permet à la protection finale d’adhérer correctement.", "icon" => "fa-solid fa-brush"],
        ["title" => "Traitement anti-corrosion", "copy" => "Une couche primaire protectrice est appliquée avant finition. Pour les ouvrages très exposés, nous orientons vers des traitements renforcés adaptés au climat et au site.", "icon" => "fa-solid fa-shield-halved"],
        ["title" => "Thermolaquage", "copy" => "La finition thermolaquée forme une couche résistante et régulière, disponible dans de nombreuses teintes RAL, en rendu mat, satiné ou brillant.", "icon" => "fa-solid fa-spray-can-sparkles"],
    ]);

    $materials = collect([
        ["title" => "Métaux travaillés", "items" => ["Acier doux pour la majorité des ouvrages", "Acier galvanisé pour protection renforcée", "Inox pour espaces humides ou finitions haut de gamme", "Fer forgé traditionnel pour portails et garde-corps classiques"]],
        ["title" => "Finitions esthétiques", "items" => ["Teintes RAL au choix", "Mat, satiné ou brillant", "Effet martelé ou texturé", "Bicoloration sur demande"]],
        ["title" => "Protection anti-corrosion", "items" => ["Primaire d’accroche", "Thermolaquage four", "Galvanisation à chaud sur demande", "Peinture époxy pour certains usages intérieurs"]],
        ["title" => "Combinaisons matériaux", "items" => ["Métal + bois pour pergolas et escaliers", "Métal + verre pour garde-corps design", "Métal + aluminium pour structures extérieures complexes"]],
    ]);

    $audiences = collect([
        ["title" => "Particuliers villa & maison", "copy" => "Portail d’entrée, garde-corps de balcon et terrasse, escalier intérieur ou extérieur, pergola de jardin : nous prenons en charge les ouvrages métalliques de votre maison.", "cta" => "Lancer mon projet villa", "href" => url('/projets/amenagement-villa-maison'), "icon" => "fa-solid fa-house-chimney"],
        ["title" => "Cafés, restaurants, hôtels", "copy" => "Pergolas de terrasse, structures extérieures, garde-corps de mezzanine, escaliers d’accès. Des finitions pensées pour une exploitation commerciale intensive.", "cta" => "Devis terrasse", "href" => url('/projets/agencement-cafe-restaurant'), "icon" => "fa-solid fa-utensils"],
        ["title" => "Promoteurs & entrepreneurs", "copy" => "Garde-corps de programmes neufs, escaliers de service et structures métalliques sur plan. Lots multiples et livraison coordonnée sur planning chantier.", "cta" => "Dossier promoteur", "href" => url('/projets/agencement-immobilier-neuf'), "icon" => "fa-regular fa-building"],
    ]);

    $process = collect([
        ["step" => "01", "title" => "Étude technique", "copy" => "Visite sur place, prise de cotes, conseil sur le design, les matériaux et plan technique si nécessaire."],
        ["step" => "02", "title" => "Devis détaillé", "copy" => "Chiffrage poste par poste sous 48h pour une demande complète. Validation du projet, signature et acompte selon devis."],
        ["step" => "03", "title" => "Fabrication & finition", "copy" => "Fabrication dans notre atelier, traitement anti-corrosion, thermolaquage et contrôle qualité. Délai annoncé selon projet."],
        ["step" => "04", "title" => "Pose & mise en service", "copy" => "Pose par notre équipe. Motorisation et raccordements si applicable. Réglages et garantie atelier active."],
    ]);

    $faqs = collect([
        ["q" => "Comment éviter qu’un portail ou une pergola ne rouille rapidement en Tunisie ?", "a" => "La rouille apparaît souvent quand l’acier est mal préparé ou mal protégé avant peinture. Notre process commence par la préparation de surface, puis l’application d’une protection adaptée et d’une finition résistante. Pour les ouvrages extérieurs très exposés, un traitement renforcé peut être recommandé."],
        ["q" => "Quel est le prix d’un portail fer forgé sur mesure en Tunisie ?", "a" => "Le prix dépend des dimensions, du design, du type d’ouverture, de la motorisation, du traitement de surface et de la pose. Un portail simple n’a pas le même coût qu’un portail travaillé ou motorisé. Nous établissons un devis détaillé après dimensions et choix techniques."],
        ["q" => "Combien coûte une pergola métallique pour terrasse ?", "a" => "Le prix dépend des dimensions, du type de structure, de la couverture choisie, du traitement anti-corrosion et de la finition. Une pergola adossée standard est plus accessible qu’une structure autoportée avec couverture technique."],
        ["q" => "Vos garde-corps respectent-ils les normes de sécurité ?", "a" => "Nous concevons les garde-corps selon les contraintes de sécurité du lieu : hauteur, espacement, fixation et usage. Pour les projets professionnels, les exigences spécifiques sont cadrées dès l’étude."],
        ["q" => "Pouvez-vous motoriser un portail existant ?", "a" => "Oui, si le portail existant est en bon état structurel. Une visite technique permet de vérifier le poids, l’équerrage, les fixations et la faisabilité de la motorisation."],
        ["q" => "Faites-vous des escaliers métalliques pour mezzanines et duplex ?", "a" => "Oui. Nous fabriquons des escaliers droits, hélicoïdaux ou suspendus, adaptés aux espaces résidentiels et professionnels. Chaque escalier est dimensionné selon la hauteur, l’emprise disponible et le style recherché."],
        ["q" => "Quelles couleurs et finitions sont possibles ?", "a" => "Les teintes RAL sont possibles selon finition choisie, avec rendus mat, satiné ou brillant. Des effets texturés ou martelés peuvent être proposés selon l’ouvrage et le niveau de résistance attendu."],
        ["q" => "Quel délai pour la fabrication et la pose d’un ouvrage métallique ?", "a" => "Le délai dépend du type d’ouvrage, du volume, de la finition et de la disponibilité des accessoires comme motorisation ou vitrage. Le délai exact est annoncé dans le devis."],
    ]);

    $internalLinks = collect([
        ["title" => "Portail fer forgé", "href" => url('/fer-metal/portail-fer-forge'), "copy" => "Battant, coulissant, motorisé."],
        ["title" => "Pergola métallique", "href" => url('/fer-metal/pergola-metallique'), "copy" => "Terrasse, jardin, CHR."],
        ["title" => "Escalier métallique", "href" => url('/fer-metal/escalier-metallique'), "copy" => "Droit, hélicoïdal, suspendu."],
        ["title" => "Garde-corps métal", "href" => url('/fer-metal/garde-corps'), "copy" => "Balcon, terrasse, escalier."],
    ]);
@endphp

@push('head')
<script type="application/ld+json">
{!! json_encode([
    '@' . 'context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Accueil', 'item' => route('home')],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Fabrication métallique', 'item' => url('/fer-metal')],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
<script type="application/ld+json">
{!! json_encode([
    '@' . 'context' => 'https://schema.org',
    '@type' => 'Service',
    'serviceType' => 'Fabrication métallique',
    'name' => 'Ferronnerie et fabrication métallique sur mesure en Tunisie',
    'provider' => [
        '@type' => 'LocalBusiness',
        'name' => 'Maison 216',
        'url' => url('/'),
    ],
    'areaServed' => [
        '@type' => 'Country',
        'name' => 'Tunisie',
    ],
    'description' => 'Atelier de ferronnerie et fabrication métallique en Tunisie pour portails, pergolas, escaliers et garde-corps sur mesure.',
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
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_18%_18%,rgba(184,138,59,0.15),transparent_34%),radial-gradient(circle_at_86%_18%,rgba(72,54,35,0.14),transparent_30%)]"></div>
    <div class="container relative mx-auto grid gap-10 px-4 py-14 lg:grid-cols-[0.9fr_1.1fr] lg:items-center lg:py-20">
        <div>
            <div class="inline-flex items-center gap-2 rounded-full border border-[#d8c7af] bg-white/72 px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-[#8b6426]">
                <i class="fa-solid fa-fire-flame-curved"></i>
                Métier · Fabrication métallique
            </div>

            <h1 class="font-display mt-7 max-w-4xl text-4xl font-extrabold leading-[1.02] tracking-[-0.04em] text-[#171411] sm:text-5xl lg:text-6xl">
                Atelier de ferronnerie et fabrication métallique en Tunisie.
                <span class="block text-[#a47834]">Portails, pergolas, escaliers et garde-corps sur mesure.</span>
            </h1>

            <p class="mt-6 max-w-3xl text-base leading-8 text-[#55473c] sm:text-lg">
                Notre atelier métal conçoit et fabrique vos ouvrages en fer forgé et en acier : portails, pergolas, escaliers sur mesure et garde-corps. Traitement anti-corrosion, finition adaptée et pose par notre équipe partout en Tunisie.
            </p>

            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                <a href="{{ $devisUrl }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#171411] px-7 py-4 text-sm font-extrabold text-white shadow-[0_20px_45px_rgba(23,20,17,0.16)] transition hover:bg-[#a47834]">
                    <i class="fa-regular fa-clipboard"></i>
                    Demander un devis métal
                </a>
                @if($metalRealizations->isNotEmpty())
                    <a href="#realisations-metal" class="inline-flex items-center justify-center gap-2 rounded-full border border-[#cdbb9f] bg-white/78 px-7 py-4 text-sm font-extrabold text-[#171411] transition hover:border-[#a47834] hover:bg-white">
                        <i class="fa-regular fa-images"></i>
                        Voir nos réalisations métal
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
                <div class="relative min-h-[360px] overflow-hidden rounded-[30px] bg-cover bg-center lg:min-h-[540px]" style="background-image: linear-gradient(180deg, rgba(23,20,17,0.02), rgba(23,20,17,0.58)), url('{{ $heroImage }}');">
                    <div class="absolute bottom-6 left-6 right-6 rounded-[26px] border border-white/18 bg-[#171411]/72 p-5 text-white backdrop-blur">
                        <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#d5b170]">Atelier métal</div>
                        <p class="mt-2 text-sm leading-6 text-white/78">Soudure, assemblage, traitement de surface, finition et pose dans un parcours suivi.</p>
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
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Notre gamme métal</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">Quatre familles d'ouvrages. Un seul atelier.</h2>
            <p class="mt-4 text-lg leading-8 text-[#5f5146]">De l’entrée de votre villa à la terrasse de votre restaurant, nous fabriquons les ouvrages métalliques de votre projet.</p>
        </div>

        <div class="grid gap-5 lg:grid-cols-2">
            @foreach($products as $item)
                <a href="{{ $item['href'] }}" class="group overflow-hidden rounded-[34px] border border-[#eadfce] bg-white shadow-[0_18px_45px_rgba(23,20,17,0.05)] transition hover:-translate-y-1 hover:shadow-[0_28px_70px_rgba(23,20,17,0.10)]">
                    <div class="grid min-h-[360px] md:grid-cols-[0.95fr_1.05fr]">
                        <div class="relative min-h-[240px] bg-cover bg-center" style="background-image: linear-gradient(180deg, rgba(23,20,17,0.04), rgba(23,20,17,0.72)), url('{{ $item['image'] }}');">
                            <span class="absolute left-5 top-5 inline-flex h-12 w-12 items-center justify-center rounded-2xl border border-white/20 bg-white/12 text-[#f0d49a] backdrop-blur">
                                <i class="{{ $item['icon'] }}"></i>
                            </span>
                            <div class="absolute bottom-6 left-6 right-6">
                                <h3 class="font-display text-2xl font-extrabold text-white">{{ $item['title'] }}</h3>
                            </div>
                        </div>
                        <div class="flex flex-col justify-between p-6">
                            <div>
                                <p class="text-sm leading-7 text-[#5f5146]">{{ $item['copy'] }}</p>
                                <div class="mt-5 flex flex-wrap gap-2">
                                    @foreach($item['tags'] as $tag)
                                        <span class="rounded-full border border-[#eadfce] bg-[#fbf7ee] px-3 py-1 text-xs font-bold text-[#6d5c4d]">{{ $tag }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="mt-7 text-sm font-extrabold text-[#8e6322]">Découvrir <i class="fa-solid fa-arrow-right ml-1 text-xs transition group-hover:translate-x-1"></i></div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-[#171411] py-16 text-white lg:py-20">
    <div class="container mx-auto grid gap-10 px-4 lg:grid-cols-[1.15fr_0.85fr] lg:items-center">
        <div>
            <div class="overflow-hidden rounded-[38px] border border-white/10">
                <div class="min-h-[360px] bg-cover bg-center lg:min-h-[540px]" style="background-image: linear-gradient(180deg, rgba(23,20,17,0.04), rgba(23,20,17,0.38)), url('{{ $heroImage }}');"></div>
            </div>
        </div>
        <div>
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#d5b170]">L'atelier</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold leading-tight sm:text-4xl">Fabriqué dans notre atelier. Pas commandé à un sous-traitant.</h2>
            <div class="mt-6 space-y-5 text-base leading-8 text-white/72">
                <p>La fabrication métallique demande un vrai suivi : qualité des soudures, traitement de surface, résistance des fixations, précision de pose. Chez Maison216, chaque portail, pergola, escalier ou garde-corps est suivi dans notre atelier métal.</p>
                <p>Vous avez un seul interlocuteur, du devis à la pose, avec une fabrication adaptée au lieu, au climat et à l’usage réel de l’ouvrage.</p>
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

<section class="bg-white py-16 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-9 max-w-3xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Durabilité</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">Du métal prévu pour durer, pas pour être repeint chaque saison.</h2>
            <p class="mt-4 text-lg leading-8 text-[#5f5146]">Un ouvrage métallique de mauvaise qualité se voit vite : rouille aux soudures, peinture qui cloque, pièces qui se déforment. La différence vient de la fabrication et du traitement de surface.</p>
        </div>

        <div class="grid gap-5 lg:grid-cols-3">
            @foreach($durability as $pillar)
                <article class="rounded-[30px] border border-[#eadfce] bg-[#fbf7ee] p-7">
                    <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-[#171411] text-[#d5b170]">
                        <i class="{{ $pillar['icon'] }}"></i>
                    </div>
                    <h3 class="font-display mt-6 text-xl font-extrabold text-[#171411]">{{ $pillar['title'] }}</h3>
                    <p class="mt-4 text-sm leading-7 text-[#5f5146]">{{ $pillar['copy'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-[#fbf7ee] py-16 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-9 max-w-3xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Matériaux & finitions</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">Le métal adapté à votre projet et à votre climat.</h2>
            <p class="mt-4 text-lg leading-8 text-[#5f5146]">Aciers, finitions de surface et traitements anti-corrosion : une palette complète pour les contraintes intérieures, extérieures et professionnelles.</p>
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
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Nos clients métal</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">Particuliers, restaurateurs, professionnels.</h2>
        </div>

        <div class="grid gap-5 lg:grid-cols-3">
            @foreach($audiences as $audience)
                <article class="rounded-[32px] border border-[#eadfce] bg-[#fbf7ee] p-7">
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

@if($metalRealizations->isNotEmpty())
<section id="realisations-metal" class="bg-[#171411] py-16 text-white lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-9 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-3xl">
                <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#d5b170]">Réalisations métal</div>
                <h2 class="font-display mt-3 text-3xl font-extrabold sm:text-4xl">Quelques ouvrages métalliques récents.</h2>
            </div>
            <a href="{{ route('realizations.index', ['silo' => 'fer-metal']) }}" class="text-sm font-extrabold text-[#d5b170]">Voir toutes nos réalisations métal</a>
        </div>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @foreach($metalRealizations as $realization)
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
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">Du dimensionnement à la pose, en 4 étapes.</h2>
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
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">Tout ce que vous voulez savoir sur la fabrication métallique.</h2>
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
        <h2 class="font-display text-3xl font-extrabold sm:text-5xl">Un projet en fabrication métallique ?</h2>
        <p class="mx-auto mt-4 max-w-2xl text-lg leading-8 text-white/72">Recevez un devis détaillé sous 48h pour une demande complète. Étude technique et plans selon projet inclus.</p>
        <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
            <a href="{{ $devisUrl }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#d5b170] px-7 py-4 text-sm font-extrabold text-[#171411]">
                <i class="fa-regular fa-clipboard"></i>
                Demander un devis métal
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
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Explorer par type d'ouvrage</div>
            <h3 class="font-display mt-3 text-2xl font-extrabold text-[#171411] sm:text-3xl">Nos pages dédiées par type d'ouvrage métallique.</h3>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
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
