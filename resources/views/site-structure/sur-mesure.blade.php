@extends('layouts.store')

@php
    $devisUrl = url('/devis');
    $contactUrl = route('contact');
    $whatsappUrl = \App\Support\SiteSettings::whatsappUrl() ?? $contactUrl;

    $heroImage = asset('assets/home/amenagement-sur-mesure.jpg');
    $cuisineImage = asset('assets/home/realizations/cuisine-sur-mesure.jpg');
    $dressingImage = asset('assets/home/realizations/dressing-sur-mesure.jpg');
    $boisImage = asset('assets/home/menuiserie-bois.webp');
    $restaurantImage = asset('assets/home/realizations/amenagement-restaurant.jpg');
    $surMesureRealizations = app(\App\Support\RealizationResolver::class)->forPage('sur-mesure', 6, 'sur-mesure');

    $breadcrumbs = [
        ["name" => "Accueil", "url" => route('home')],
        ["name" => "Sur mesure", "url" => url('/sur-mesure')],
    ];

    $heroProofs = collect([
        ["label" => "Plans 3D inclus", "icon" => "fa-solid fa-cube"],
        ["label" => "Fabrication interne", "icon" => "fa-solid fa-industry"],
        ["label" => "Pose & SAV inclus", "icon" => "fa-solid fa-screwdriver-wrench"],
        ["label" => "Devis sous 48h", "icon" => "fa-regular fa-clock"],
    ]);

    $products = collect([
        [
            "title" => "Cuisine sur mesure",
            "copy" => "Linéaire, en L, en U ou avec îlot. Mélaminé, MDF laqué, plaqué bois, électroménager intégré, plan de travail et crédence. Entièrement fabriquée dans notre atelier bois.",
            "price" => "À partir de 6 500 DT",
            "priceNote" => "Linéaire 3m, mélaminé standard",
            "href" => url('/sur-mesure/cuisine-sur-mesure'),
            "image" => $cuisineImage,
            "icon" => "fa-solid fa-kitchen-set",
        ],
        [
            "title" => "Dressing sur mesure",
            "copy" => "Pleine hauteur, en angle, en U ou sous combles. Tringles, étagères, tiroirs, miroirs et éclairage LED intégré selon besoin.",
            "price" => "À partir de 3 500 DT",
            "priceNote" => "2m linéaire, pleine hauteur",
            "href" => url('/sur-mesure/dressing-sur-mesure'),
            "image" => $dressingImage,
            "icon" => "fa-solid fa-door-closed",
        ],
        [
            "title" => "Placard sur mesure",
            "copy" => "Placard mural, sous escalier ou encastré dans une niche. Portes battantes ou coulissantes, aménagement intérieur modulable.",
            "price" => "À partir de 1 800 DT",
            "priceNote" => "1,5m, portes battantes",
            "href" => url('/sur-mesure/placard-sur-mesure'),
            "image" => $heroImage,
            "icon" => "fa-solid fa-table-columns",
        ],
        [
            "title" => "Meuble TV sur mesure",
            "copy" => "Mural intégré, suspendu, avec bibliothèque ou panneau décoratif. Passe-câbles, niches hifi et éclairage indirect.",
            "price" => "À partir de 1 200 DT",
            "priceNote" => "Modèle suspendu simple",
            "href" => url('/sur-mesure/meuble-tv-sur-mesure'),
            "image" => $boisImage,
            "icon" => "fa-solid fa-tv",
        ],
        [
            "title" => "Bureau sur mesure",
            "copy" => "Home office, bureau d’angle, espace enfant ou bureau partagé. Plan de travail aux bonnes dimensions, caissons et passage de câbles discret.",
            "price" => "À partir de 1 500 DT",
            "priceNote" => "Bureau standard avec caisson",
            "href" => url('/sur-mesure/bureau-sur-mesure'),
            "image" => $boisImage,
            "icon" => "fa-solid fa-briefcase",
        ],
    ]);

    $comparison = [
        "standard" => [
            "Dimensions imposées : on perd souvent de l’espace utile.",
            "Matériaux limités à ce qui est disponible.",
            "Finitions figées : couleurs, poignées et plans de travail non négociables.",
            "Qualité variable selon fabricant et série.",
            "SAV souvent opaque quand une pièce lâche après quelques années.",
        ],
        "custom" => [
            "Cotes exactes au millimètre : l’espace est utilisé intelligemment.",
            "Matériaux au choix : massif, plaqué, MDF laqué, mélaminé qualité européenne.",
            "Finitions, couleurs, poignées et plans de travail adaptés au projet.",
            "Quincaillerie premium type Blum, Hettich ou équivalent selon devis.",
            "SAV interne géré par l’atelier qui a fabriqué et posé.",
        ],
    ];

    $process = collect([
        ["step" => "01", "title" => "Vous nous contactez", "copy" => "Par WhatsApp, formulaire ou à l’atelier. Vous décrivez votre projet, nous cadrons l’orientation immédiatement."],
        ["step" => "02", "title" => "Visite technique", "copy" => "Un technicien prend les cotes au millimètre et conseille sur les matériaux, finitions et contraintes du lieu."],
        ["step" => "03", "title" => "Plans 3D & devis", "copy" => "Conception 3D pour visualiser le résultat, puis devis détaillé sous 48h pour une demande complète."],
        ["step" => "04", "title" => "Fabrication atelier", "copy" => "Acompte, validation finale et lancement dans notre atelier bois avec délai annoncé selon projet."],
        ["step" => "05", "title" => "Pose & SAV", "copy" => "Pose par notre équipe, vérification de conformité, ajustements si nécessaire et garantie atelier active."],
    ]);

    $prices = collect([
        ["product" => "Cuisine sur mesure", "price" => "À partir de 6 500 DT", "details" => "Linéaire 3m, mélaminé standard"],
        ["product" => "Dressing sur mesure", "price" => "À partir de 3 500 DT", "details" => "2m linéaire, pleine hauteur"],
        ["product" => "Placard sur mesure", "price" => "À partir de 1 800 DT", "details" => "1,5m, portes battantes"],
        ["product" => "Meuble TV sur mesure", "price" => "À partir de 1 200 DT", "details" => "Modèle suspendu simple"],
        ["product" => "Bureau sur mesure", "price" => "À partir de 1 500 DT", "details" => "Bureau standard avec caisson"],
    ]);

    $audiences = collect([
        [
            "title" => "Particuliers exigeants",
            "copy" => "Vous emménagez dans un appartement neuf, vous rénovez votre maison ou vous équipez votre villa. Vous voulez un résultat adapté à votre espace, sans compromis sur la qualité ni sur le style.",
            "tags" => ["Villa", "Appartement neuf", "Rénovation"],
            "cta" => "Lancer mon projet",
            "href" => $devisUrl,
            "icon" => "fa-solid fa-house-chimney",
        ],
        [
            "title" => "Architectes & décorateurs",
            "copy" => "Vos projets exigent des solutions fabriquées selon plans, cotes, matériaux et finitions. Nous fabriquons en atelier et organisons un échange technique clair.",
            "tags" => ["Plans respectés", "Délais suivis", "Conditions professionnelles"],
            "cta" => "Espace professionnels",
            "href" => url('/partenaires'),
            "icon" => "fa-solid fa-drafting-compass",
        ],
        [
            "title" => "Promoteurs & professionnels",
            "copy" => "Programmes neufs à équiper, appartements en lots multiples ou agencements professionnels. Tarifs adaptés au volume, livraisons phasées et interlocuteur dédié.",
            "tags" => ["Volumes", "Contrats-cadres", "Lots multiples"],
            "cta" => "Dossier promoteur",
            "href" => url('/projets/agencement-immobilier-neuf'),
            "icon" => "fa-regular fa-building",
        ],
    ]);

    $faqs = collect([
        ["q" => "Le sur mesure est-il vraiment plus cher que le standard ?", "a" => "Pas forcément. Pour des dimensions courantes, les prix peuvent rester proches des grandes enseignes, avec une fabrication adaptée et une durée de vie supérieure. Le sur mesure devient surtout rentable quand l’espace est atypique ou quand vous voulez exploiter chaque centimètre."],
        ["q" => "Quel est le délai entre la commande et la pose ?", "a" => "Comptez généralement 3 à 5 semaines pour une cuisine ou un dressing, et 2 à 3 semaines pour un placard, un meuble TV ou un bureau. Le délai exact est annoncé et validé dans chaque devis."],
        ["q" => "Faut-il un acompte pour démarrer ?", "a" => "Oui. Un acompte est demandé à la signature du bon de commande. Le solde est réglé à la livraison ou organisé selon l’ampleur du projet."],
        ["q" => "Faites-vous des plans 3D avant la fabrication ?", "a" => "Oui. La conception 3D fait partie du processus pour les projets qui le nécessitent. Elle permet de visualiser le résultat avant la validation finale et avant le lancement en atelier."],
        ["q" => "Peut-on modifier le projet après le démarrage de la fabrication ?", "a" => "Les modifications majeures deviennent difficiles une fois la fabrication lancée. Des ajustements mineurs peuvent être étudiés selon l’avancement. La validation des plans est donc une étape essentielle."],
        ["q" => "Peut-on combiner plusieurs sur-mesure dans un même devis ?", "a" => "Oui. C’est même recommandé pour les appartements, villas ou projets complets : un seul devis, un seul planning, une pose coordonnée."],
        ["q" => "Quelle garantie sur la fabrication et la pose ?", "a" => "La structure et les ouvrages fabriqués par l’atelier sont couverts par une garantie atelier. La quincaillerie bénéficie de la garantie fabricant. Le SAV est suivi par notre équipe."],
        ["q" => "Travaillez-vous pour des projets professionnels ?", "a" => "Oui. Comptoirs, mobilier sur mesure, bureaux, présentoirs, rangements et agencements : nous fabriquons aussi pour cafés, bureaux, boutiques et espaces professionnels."],
    ]);

    $internalLinks = collect([
        ["title" => "Cuisine sur mesure", "href" => url('/sur-mesure/cuisine-sur-mesure'), "copy" => "Linéaire, en L, en U ou avec îlot."],
        ["title" => "Dressing sur mesure", "href" => url('/sur-mesure/dressing-sur-mesure'), "copy" => "Pleine hauteur, angle, sous combles."],
        ["title" => "Placard sur mesure", "href" => url('/sur-mesure/placard-sur-mesure'), "copy" => "Mural, niche, sous escalier."],
        ["title" => "Meuble TV sur mesure", "href" => url('/sur-mesure/meuble-tv-sur-mesure'), "copy" => "Suspendu, mural, bibliothèque intégrée."],
        ["title" => "Bureau sur mesure", "href" => url('/sur-mesure/bureau-sur-mesure'), "copy" => "Home office, enfant, professionnel."],
    ]);
@endphp

@push('head')
<script type="application/ld+json">
{!! json_encode([
    '@' . 'context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Accueil', 'item' => route('home')],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Sur mesure', 'item' => url('/sur-mesure')],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
<script type="application/ld+json">
{!! json_encode([
    '@' . 'context' => 'https://schema.org',
    '@type' => 'Service',
    'serviceType' => 'Fabrication sur mesure',
    'name' => 'Fabrication de meubles sur mesure en Tunisie',
    'provider' => [
        '@type' => 'LocalBusiness',
        'name' => 'Maison 216',
        'url' => url('/'),
    ],
    'areaServed' => [
        '@type' => 'Country',
        'name' => 'Tunisie',
    ],
    'description' => 'Cuisine, dressing, placard, meuble TV et bureau sur mesure fabriqués en atelier avec plans 3D et pose.',
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
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_18%_18%,rgba(184,138,59,0.16),transparent_34%),radial-gradient(circle_at_86%_18%,rgba(23,20,17,0.09),transparent_32%)]"></div>
    <div class="container relative mx-auto grid gap-0 px-4 pb-12 pt-0 lg:grid-cols-[0.9fr_1.1fr] lg:items-center lg:gap-10 lg:py-20">
        <div class="order-2 py-10 lg:order-1 lg:py-0">
            <h1 class="font-display max-w-4xl text-4xl font-extrabold leading-[1.02] tracking-[-0.04em] text-[#171411] sm:text-5xl lg:text-6xl">
                Le meuble sur mesure pensé pour votre espace.
                <span class="block text-[#a47834]">Pas l’inverse.</span>
            </h1>

            <p class="mt-6 max-w-3xl text-base leading-8 text-[#55473c] sm:text-lg">
                Cuisine, dressing, placard, meuble TV, bureau : nous fabriquons exactement ce que votre espace exige, aux dimensions exactes, dans les matériaux que vous choisissez. Étude, plans 3D, fabrication en atelier et pose incluses.
            </p>

            <div class="mt-8 flex flex-row gap-2 sm:gap-3">
                <a href="{{ $devisUrl }}" class="inline-flex flex-1 items-center justify-center gap-2 rounded-full bg-[#171411] px-4 py-3 text-xs font-extrabold text-white shadow-[0_20px_45px_rgba(23,20,17,0.16)] transition hover:bg-[#a47834] sm:flex-none sm:px-7 sm:py-4 sm:text-sm">
                    <i class="fa-regular fa-pen-to-square"></i>
                    Lancer mon projet sur mesure
                </a>
                @if($surMesureRealizations->isNotEmpty())
                    <a href="#realisations-sur-mesure" class="inline-flex flex-1 items-center justify-center gap-2 rounded-full border border-[#cdbb9f] bg-white/78 px-4 py-3 text-xs font-extrabold text-[#171411] transition hover:border-[#a47834] hover:bg-white sm:flex-none sm:px-7 sm:py-4 sm:text-sm">
                        <i class="fa-regular fa-images"></i>
                        Voir nos réalisations
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

        <div class="order-1 -mx-4 lg:order-2 lg:mx-0">
            <div class="overflow-hidden bg-white lg:rounded-[40px] lg:border lg:border-[#d8c7af] lg:p-3">
                <img src="{{ $heroImage }}" alt="Aménagement sur mesure Maison216" class="h-[320px] w-full object-cover sm:h-[420px] lg:h-[540px] lg:rounded-[30px]">
            </div>
        </div>
    </div>
</section>

<section class="bg-[#fbf7ee] py-16 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-9 max-w-4xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Nos aménagements sur mesure</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">Cinq familles. Une seule logique : votre espace, vos dimensions, votre style.</h2>
            <p class="mt-4 text-lg leading-8 text-[#5f5146]">Chaque pièce fabriquée dans notre atelier est unique. Pensée pour votre projet, adaptée à vos contraintes, posée par notre équipe.</p>
        </div>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @foreach($products as $item)
                <a href="{{ $item['href'] }}" class="group overflow-hidden rounded-[32px] border border-[#eadfce] bg-white shadow-[0_18px_45px_rgba(23,20,17,0.05)] transition hover:-translate-y-1 hover:shadow-[0_28px_70px_rgba(23,20,17,0.10)]">
                    <div class="relative min-h-[220px] bg-cover bg-center" style="background-image: linear-gradient(180deg, rgba(23,20,17,0.05), rgba(23,20,17,0.62)), url('{{ $item['image'] }}');">
                        <span class="absolute left-5 top-5 inline-flex h-12 w-12 items-center justify-center rounded-2xl border border-white/20 bg-white/12 text-[#f0d49a] backdrop-blur">
                            <i class="{{ $item['icon'] }}"></i>
                        </span>
                    </div>
                    <div class="p-6">
                        <h3 class="font-display text-xl font-extrabold text-[#171411]">{{ $item['title'] }}</h3>
                        <p class="mt-3 text-sm leading-7 text-[#5f5146]">{{ $item['copy'] }}</p>
                        <div class="mt-5 rounded-2xl bg-[#fbf7ee] px-4 py-3">
                            <div class="text-sm font-extrabold text-[#8e6322]">{{ $item['price'] }}</div>
                            <div class="mt-1 text-xs font-semibold text-[#6d5c4d]">{{ $item['priceNote'] }}</div>
                        </div>
                        <div class="mt-5 text-sm font-extrabold text-[#8e6322]">Découvrir <i class="fa-solid fa-arrow-right ml-1 text-xs transition group-hover:translate-x-1"></i></div>
                    </div>
                </a>
            @endforeach

            <a href="{{ url('/projets/amenagement-villa-maison') }}" class="group overflow-hidden rounded-[32px] border border-[#2b241e] bg-[#171411] p-7 text-white shadow-[0_24px_60px_rgba(23,20,17,0.15)] transition hover:-translate-y-1">
                <div class="inline-flex h-14 w-14 items-center justify-center rounded-2xl border border-white/15 bg-white/8 text-[#d5b170]">
                    <i class="fa-solid fa-layer-group text-xl"></i>
                </div>
                <h3 class="font-display mt-8 text-2xl font-extrabold">Vous avez un projet complet ?</h3>
                <p class="mt-4 text-base leading-8 text-white/72">Cuisine + dressings + placards dans le même appartement ou la même villa : nous regroupons tout dans un seul devis coordonné.</p>
                <div class="mt-8 text-sm font-extrabold text-[#d5b170]">Voir aménagement villa <i class="fa-solid fa-arrow-right ml-1 text-xs transition group-hover:translate-x-1"></i></div>
            </a>
        </div>
    </div>
</section>

<section class="bg-white py-16 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-9 max-w-4xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Sur mesure vs standard</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">Pourquoi le sur mesure change tout.</h2>
            <p class="mt-4 text-lg leading-8 text-[#5f5146]">Un meuble standard est conçu pour s’adapter à tous les espaces, donc à aucun en particulier. Le sur mesure inverse la logique : c’est le meuble qui s’adapte à votre pièce, à votre usage et à votre budget.</p>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <article class="rounded-[34px] border border-[#eadfce] bg-[#fbf7ee] p-7">
                <h3 class="font-display text-2xl font-extrabold text-[#171411]">Meuble standard</h3>
                <ul class="mt-6 space-y-4">
                    @foreach($comparison['standard'] as $item)
                        <li class="flex gap-3 text-sm leading-7 text-[#5f5146]">
                            <i class="fa-solid fa-xmark mt-1 text-[#b05a45]"></i>
                            <span>{{ $item }}</span>
                        </li>
                    @endforeach
                </ul>
            </article>
            <article class="rounded-[34px] border border-[#d5b170] bg-[#171411] p-7 text-white">
                <h3 class="font-display text-2xl font-extrabold">Sur mesure Maison216</h3>
                <ul class="mt-6 space-y-4">
                    @foreach($comparison['custom'] as $item)
                        <li class="flex gap-3 text-sm leading-7 text-white/76">
                            <i class="fa-solid fa-check mt-1 text-[#d5b170]"></i>
                            <span>{{ $item }}</span>
                        </li>
                    @endforeach
                </ul>
            </article>
        </div>

        <div class="mt-6 rounded-[28px] border border-[#eadfce] bg-[#fbf7ee] p-6">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">À retenir</div>
            <p class="mt-3 max-w-4xl text-base leading-8 text-[#4f4236]">À budget équivalent, le sur mesure permet souvent une meilleure exploitation de l’espace et une meilleure longévité. Et il n’est pas aussi inaccessible qu’on l’imagine : nos placards démarrent à 1 800 DT, nos meubles TV à 1 200 DT.</p>
        </div>
    </div>
</section>

<section class="bg-[#fbf7ee] py-16 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-10 max-w-4xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Comment ça marche</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">De votre idée au meuble livré, en 5 étapes.</h2>
            <p class="mt-4 text-lg leading-8 text-[#5f5146]">Un processus transparent, sans surprise, avec un délai annoncé à chaque projet.</p>
        </div>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-5">
            @foreach($process as $step)
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
        <div class="mb-9 max-w-4xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Combien ça coûte</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">Prix indicatifs : ce que démarre chaque type de projet.</h2>
            <p class="mt-4 text-lg leading-8 text-[#5f5146]">Nous publions nos prix de départ pour cadrer votre budget avant même de nous contacter. Le tarif final dépend des dimensions, matériaux et finitions choisis.</p>
        </div>

        <div class="overflow-hidden rounded-[34px] border border-[#eadfce] bg-white shadow-[0_18px_45px_rgba(23,20,17,0.05)]">
            @foreach($prices as $price)
                <div class="grid gap-3 border-b border-[#eadfce] p-5 last:border-b-0 md:grid-cols-[1fr_0.7fr_1.1fr] md:items-center">
                    <div class="font-display text-lg font-extrabold text-[#171411]">{{ $price['product'] }}</div>
                    <div class="text-base font-extrabold text-[#a47834]">{{ $price['price'] }}</div>
                    <div class="text-sm leading-6 text-[#5f5146]">{{ $price['details'] }}</div>
                </div>
            @endforeach
        </div>

        <div class="mt-6 rounded-[28px] border border-[#eadfce] bg-[#fbf7ee] p-6">
            <h3 class="font-display text-xl font-extrabold text-[#171411]">Ce qui fait varier le prix</h3>
            <p class="mt-3 max-w-4xl text-base leading-8 text-[#5f5146]">Les dimensions finales, le matériau choisi, les finitions, les poignées, plans de travail, éclairage LED, quincaillerie et l’électroménager intégré pour les cuisines.</p>
        </div>
    </div>
</section>

<section class="bg-[#fbf7ee] py-16 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-9 max-w-3xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Pour qui</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">Particuliers, architectes, promoteurs.</h2>
        </div>

        <div class="grid gap-5 lg:grid-cols-3">
            @foreach($audiences as $audience)
                <article class="rounded-[32px] border border-[#eadfce] bg-white p-7">
                    <div class="inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-[#171411] text-xl text-[#d5b170]">
                        <i class="{{ $audience['icon'] }}"></i>
                    </div>
                    <h3 class="font-display mt-6 text-2xl font-extrabold text-[#171411]">{{ $audience['title'] }}</h3>
                    <p class="mt-4 text-base leading-8 text-[#5f5146]">{{ $audience['copy'] }}</p>
                    <div class="mt-5 flex flex-wrap gap-2">
                        @foreach($audience['tags'] as $tag)
                            <span class="rounded-full border border-[#eadfce] bg-[#fbf7ee] px-3 py-1 text-xs font-bold text-[#6d5c4d]">{{ $tag }}</span>
                        @endforeach
                    </div>
                    <a href="{{ $audience['href'] }}" class="mt-7 inline-flex items-center gap-2 text-sm font-extrabold text-[#8e6322]">
                        {{ $audience['cta'] }}
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </article>
            @endforeach
        </div>
    </div>
</section>

@if($surMesureRealizations->isNotEmpty())
<section id="realisations-sur-mesure" class="bg-[#171411] py-16 text-white lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-9 max-w-3xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#d5b170]">Réalisations sur mesure</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold sm:text-4xl">Des aménagements conçus autour de vraies contraintes.</h2>
        </div>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @foreach($surMesureRealizations as $realization)
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

<section class="bg-[#fbf7ee] py-16 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-9 max-w-3xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Questions fréquentes</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">Tout savoir sur le sur mesure.</h2>
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
        <h2 class="font-display text-3xl font-extrabold sm:text-5xl">Un projet sur mesure ?</h2>
        <p class="mx-auto mt-4 max-w-2xl text-lg leading-8 text-white/72">Recevez un devis détaillé sous 48h pour une demande complète. Visite technique, plans 3D et chiffrage inclus selon projet.</p>
        <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
            <a href="{{ $devisUrl }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#d5b170] px-7 py-4 text-sm font-extrabold text-[#171411]">
                <i class="fa-regular fa-pen-to-square"></i>
                Lancer mon projet sur mesure
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
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Explorer par type de meuble</div>
            <h3 class="font-display mt-3 text-2xl font-extrabold text-[#171411] sm:text-3xl">Nos pages dédiées par type d’aménagement sur mesure.</h3>
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
