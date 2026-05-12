@extends('layouts.store')

@php
    $devisUrl = url('/devis');
    $contactUrl = route('contact');
    $wa = \App\Models\Setting::get('contact.whatsapp');
    $whatsappUrl = $wa ? 'https://wa.me/' . preg_replace('/\D+/', '', (string) $wa) : $contactUrl;

    $heroImage = asset('assets/home/amenagement-sur-mesure.jpg');
    $kitchenImage = asset('assets/home/realizations/cuisine-sur-mesure.jpg');
    $dressingImage = asset('assets/home/realizations/dressing-sur-mesure.jpg');
    $aluminiumImage = asset('assets/home/menuiserie-aluminium.jpg');

    $proofs = [
        ['label' => 'Bois + aluminium + métal', 'icon' => 'fa-solid fa-layer-group'],
        ['label' => 'Un seul interlocuteur', 'icon' => 'fa-solid fa-user-check'],
        ['label' => 'Devis groupé', 'icon' => 'fa-regular fa-file-lines'],
        ['label' => 'Pose coordonnée', 'icon' => 'fa-solid fa-calendar-check'],
    ];

    $problemPoints = [
        'Trouver séparément un cuisiniste, un menuisier, un ferronnier et un poseur aluminium.',
        'Comparer plusieurs devis qui ne parlent pas le même langage.',
        'Faire cohabiter des plannings qui se chevauchent dans un appartement encore vide.',
        'Gérer plusieurs SAV si un réglage ou une finition doit être repris après la pose.',
    ];

    $scopeItems = [
        [
            'title' => 'Cuisine équipée sur mesure',
            'copy' => 'Fabriquée aux dimensions exactes de votre cuisine, dans le matériau et la finition de votre choix. Plans 3D avant fabrication, électroménager intégré à votre sélection, pose par notre équipe.',
            'href' => url('/sur-mesure/cuisine-sur-mesure'),
            'cta' => 'Cuisine sur mesure',
            'image' => $kitchenImage,
            'icon' => 'fa-solid fa-kitchen-set',
        ],
        [
            'title' => 'Dressings et placards',
            'copy' => 'Dressing de chambre principale, placards d’entrée et de couloir, placard de service. Du sol au plafond, toute la largeur disponible, aménagement intérieur personnalisé.',
            'href' => url('/sur-mesure/dressing-sur-mesure'),
            'cta' => 'Dressing & placards',
            'image' => $dressingImage,
            'icon' => 'fa-solid fa-door-closed',
        ],
        [
            'title' => 'Fenêtres et portes aluminium',
            'copy' => 'Si les fenêtres ne sont pas incluses ou si vous souhaitez monter en qualité : fenêtres à rupture de pont thermique, double vitrage, portes aluminium et toutes teintes RAL.',
            'href' => url('/aluminium/fenetre-aluminium'),
            'cta' => 'Fenêtre aluminium',
            'image' => $aluminiumImage,
            'icon' => 'fa-regular fa-window-maximize',
        ],
        [
            'title' => 'Meuble TV et bureau',
            'copy' => 'Meuble TV mural intégré dans le salon, bureau sur mesure dans une chambre ou dans une niche. Fabrication atelier, passages de câbles propres et pose nette.',
            'href' => url('/sur-mesure/meuble-tv-sur-mesure'),
            'cta' => 'Meuble TV & bureau',
            'image' => $heroImage,
            'icon' => 'fa-solid fa-tv',
        ],
    ];

    $promoterBenefits = [
        'Tarifs dégressifs sur les commandes de 10+ lots',
        'Interlocuteur commercial dédié',
        'Respect strict des plans fournis par l’architecte',
        'Livraisons coordonnées sur planning chantier',
        'Facturation adaptée aux flux immobiliers',
    ];

    $comparison = [
        ['classic' => '3 à 4 artisans à coordonner', 'maison216' => '1 seul interlocuteur'],
        ['classic' => '3 à 4 devis séparés', 'maison216' => '1 seul devis groupé'],
        ['classic' => '3 à 4 plannings qui se chevauchent', 'maison216' => '1 seul planning coordonné'],
        ['classic' => '3 à 4 SAV différents', 'maison216' => '1 seul SAV centralisé'],
    ];

    $process = [
        ['step' => '01', 'title' => 'Visite de l’appartement', 'copy' => 'Nous venons après la livraison des clés, prenons les cotes de toutes les pièces et établissons la liste complète des besoins.'],
        ['step' => '02', 'title' => 'Devis groupé sous 48h', 'copy' => 'Un seul devis qui couvre tous les postes : cuisine, dressings, placards, menuiserie alu si applicable. Acompte de 30% à la signature.'],
        ['step' => '03', 'title' => 'Fabrication coordonnée', 'copy' => 'Fabrication dans nos ateliers selon un planning qui permet une pose séquentielle sans interférence entre les corps de métier.'],
        ['step' => '04', 'title' => 'Pose & réception', 'copy' => 'Installation par notre équipe dans le bon ordre : alu d’abord si applicable, puis bois. Vérification finale, garantie atelier active.'],
    ];

    $faqs = [
        [
            'q' => 'Intervenez-vous pendant le chantier ou après la livraison ?',
            'a' => 'Nous intervenons de préférence après la livraison des clés, une fois le carrelage et la peinture terminés. Pour les fenêtres aluminium, nous pouvons intervenir en cours de second œuvre si le planning le permet.',
        ],
        [
            'q' => 'Pouvez-vous coordonner avec l’architecte ou le décorateur du projet ?',
            'a' => 'Oui. Nous travaillons fréquemment sur des plans fournis par des architectes. Nous respectons les dimensions, les matériaux spécifiés et les délais de chantier.',
        ],
        [
            'q' => 'Livrez-vous dans toute la Tunisie ?',
            'a' => 'Oui. Tunis, Ariana, Sousse, Sfax, Hammamet, Bizerte et principales villes. Les frais de déplacement sont précisés dans le devis pour les projets hors Grand Tunis.',
        ],
    ];

    $internalLinks = [
        ['title' => 'Cuisine sur mesure', 'href' => url('/sur-mesure/cuisine-sur-mesure'), 'copy' => 'Cuisine équipée, plans 3D, pose.'],
        ['title' => 'Dressing sur mesure', 'href' => url('/sur-mesure/dressing-sur-mesure'), 'copy' => 'Chambre principale, suite parentale.'],
        ['title' => 'Placard sur mesure', 'href' => url('/sur-mesure/placard-sur-mesure'), 'copy' => 'Entrée, couloir, service.'],
        ['title' => 'Fenêtre aluminium', 'href' => url('/aluminium/fenetre-aluminium'), 'copy' => 'RPT, double vitrage, pose.'],
        ['title' => 'Porte aluminium', 'href' => url('/aluminium/porte-aluminium'), 'copy' => 'Entrée, porte-fenêtre, baie.'],
        ['title' => 'Sur mesure', 'href' => url('/sur-mesure'), 'copy' => 'Retour au hub sur mesure.'],
    ];

    $schema = [
        [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Accueil', 'item' => route('home')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Projets', 'item' => url('/projets')],
                ['@type' => 'ListItem', 'position' => 3, 'name' => 'Agencement immobilier neuf', 'item' => url('/projets/agencement-immobilier-neuf')],
            ],
        ],
        [
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'serviceType' => 'Agencement appartement neuf',
            'name' => 'Agencement immobilier neuf en Tunisie',
            'description' => 'Cuisine équipée, dressings, placards et menuiserie aluminium pour appartements neufs en Tunisie.',
            'provider' => [
                '@type' => 'LocalBusiness',
                'name' => 'Maison216',
                'url' => route('home'),
            ],
            'areaServed' => [
                '@type' => 'Country',
                'name' => 'Tunisie',
            ],
        ],
        [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => collect($faqs)->map(fn ($faq) => [
                '@type' => 'Question',
                'name' => $faq['q'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq['a'],
                ],
            ])->values()->all(),
        ],
    ];
@endphp

@push('head')
    @foreach($schema as $entry)
        <script type="application/ld+json">
            {!! json_encode($entry, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
        </script>
    @endforeach
@endpush

@section('content')
<section class="border-b border-[#eadfce] bg-[#fbf7ee]">
    <div class="container mx-auto px-4 py-6">
        <nav class="flex flex-wrap items-center gap-2 text-sm font-semibold text-[#6a5a4c]" aria-label="Fil d'Ariane">
            <a href="{{ route('home') }}" class="transition hover:text-[#171411]">Accueil</a>
            <i class="fa-solid fa-angle-right text-[10px] text-[#b88a3b]"></i>
            <a href="{{ url('/projets') }}" class="transition hover:text-[#171411]">Projets</a>
            <i class="fa-solid fa-angle-right text-[10px] text-[#b88a3b]"></i>
            <span class="text-[#171411]">Agencement immobilier neuf</span>
        </nav>
    </div>
</section>

<section class="relative overflow-hidden bg-[#f7f1e7]">
    <div class="absolute inset-y-0 right-0 hidden w-[44%] bg-[radial-gradient(circle_at_center,rgba(184,138,59,0.18),transparent_62%)] lg:block"></div>
    <div class="container relative mx-auto px-4 py-16 lg:py-24">
        <div class="grid gap-12 lg:grid-cols-[0.96fr_0.84fr] lg:items-center">
            <div>
                <div class="inline-flex items-center gap-2 rounded-full border border-[#ddcdb8] bg-white/70 px-4 py-2 text-xs font-extrabold uppercase tracking-[0.22em] text-[#8e6322]">
                    <i class="fa-solid fa-building-circle-check"></i>
                    Projet · Immobilier neuf
                </div>

                <h1 class="font-display mt-7 max-w-4xl text-4xl font-extrabold leading-[0.98] tracking-[-0.06em] text-[#171411] sm:text-5xl lg:text-7xl">
                    AGENCEMENT IMMOBILIER NEUF
                </h1>

                <p class="mt-7 max-w-3xl text-lg leading-9 text-[#5f5146]">
                    Cuisine équipée, dressings, placards, fenêtres aluminium : nous intervenons après la livraison des clés pour transformer votre appartement brut en espace de vie complet et fonctionnel. Un seul atelier, un seul devis, un seul chantier.
                </p>

                <div class="mt-9">
                    <a href="{{ $devisUrl }}" class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-[#171411] px-8 py-4 text-sm font-extrabold text-white shadow-[0_18px_45px_rgba(23,20,17,0.22)] transition hover:bg-[#a47834] sm:w-auto">
                        <i class="fa-regular fa-pen-to-square"></i>
                        Demander un devis
                    </a>
                </div>

                <div class="mt-9 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                    @foreach($proofs as $proof)
                        <div class="flex items-center gap-3 rounded-2xl border border-[#eadfce] bg-white/70 px-4 py-3 text-sm font-bold text-[#3f352d]">
                            <i class="{{ $proof['icon'] }} text-[#a47834]"></i>
                            <span>{{ $proof['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="relative">
                <div class="absolute -left-7 top-12 hidden h-44 w-44 rounded-full bg-[#c7a36a]/20 blur-2xl lg:block"></div>
                <div class="relative overflow-hidden rounded-[38px] bg-[#171411] p-3 shadow-[0_35px_90px_rgba(23,20,17,0.18)]">
                    <div class="relative min-h-[470px] overflow-hidden rounded-[30px]">
                        <img src="{{ $heroImage }}" alt="Agencement d'un appartement neuf par Maison216" class="absolute inset-0 h-full w-full object-cover">
                        <div class="absolute inset-0 ring-1 ring-inset ring-white/10"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-white py-16 lg:py-24">
    <div class="container mx-auto px-4">
        <div class="grid gap-12 lg:grid-cols-[0.82fr_1.18fr] lg:items-start">
            <div>
                <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#a47834]">Le problème réel</div>
                <h2 class="font-display mt-3 text-3xl font-extrabold leading-tight tracking-[-0.04em] text-[#171411] sm:text-5xl">Un appartement neuf livré à l’état brut, c’est encore beaucoup de travail.</h2>
            </div>
            <div class="space-y-6 text-base leading-8 text-[#5f5146] sm:text-lg">
                <p>En Tunisie, la grande majorité des appartements neufs sont livrés à l’état brut ou semi-fini : carrelage posé, plomberie en attente, fenêtres parfois incluses, cuisine et placards à faire.</p>
                <p>Pour l’acquéreur, cela représente un chantier entier à gérer en parallèle d’un achat immobilier déjà complexe. Il faut trouver un cuisiniste, un menuisier, un ferronnier, un poseur d’aluminium, négocier 4 devis, gérer 4 plannings et coordonner 4 corps de métier qui ne se parlent pas entre eux.</p>
                <p class="font-bold text-[#171411]">Chez Maison216, vous avez un seul interlocuteur pour tout ce que nous fabriquons : cuisine, dressings, placards, fenêtres alu, portail, garde-corps. Un seul devis groupé. Un seul chantier coordonné.</p>
                <div class="grid gap-3 pt-2 sm:grid-cols-2">
                    @foreach($problemPoints as $point)
                        <div class="rounded-[24px] border border-[#eadfce] bg-[#fbf7ee] p-5 text-sm font-semibold leading-7 text-[#3f352d]">
                            <i class="fa-solid fa-xmark mr-2 text-[#a47834]"></i>{{ $point }}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-[#fbf7ee] py-16 lg:py-24">
    <div class="container mx-auto px-4">
        <div class="mb-10 max-w-4xl">
            <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#a47834]">Notre périmètre</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold leading-tight tracking-[-0.04em] text-[#171411] sm:text-5xl">Tout ce qu’un appartement neuf exige, fabriqué sous un même toit.</h2>
        </div>

        <div class="grid gap-5 lg:grid-cols-2">
            @foreach($scopeItems as $item)
                <a href="{{ $item['href'] }}" class="group overflow-hidden rounded-[34px] border border-[#eadfce] bg-white shadow-[0_18px_60px_rgba(23,20,17,0.07)] transition hover:-translate-y-1 hover:shadow-[0_28px_80px_rgba(23,20,17,0.12)]">
                    <div class="grid min-h-[390px] sm:grid-cols-[1.05fr_0.95fr]">
                        <div class="relative min-h-[280px] overflow-hidden bg-[#e8ddce]">
                            <img src="{{ $item['image'] }}" alt="{{ $item['title'] }} Maison216" loading="lazy" class="absolute inset-0 h-full w-full object-cover transition duration-700 group-hover:scale-105">
                        </div>
                        <div class="flex flex-col justify-between p-7">
                            <div>
                                <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl border border-[#eadfce] bg-[#fbf7ee] text-xl text-[#a47834]">
                                    <i class="{{ $item['icon'] }}"></i>
                                </span>
                                <h3 class="font-display mt-5 text-2xl font-extrabold leading-tight text-[#171411]">{{ $item['title'] }}</h3>
                            </div>
                            <p class="text-base leading-8 text-[#5f5146]">{{ $item['copy'] }}</p>
                            <div class="mt-7 inline-flex items-center gap-2 text-sm font-extrabold text-[#8e6322]">
                                {{ $item['cta'] }}
                                <i class="fa-solid fa-arrow-right text-xs transition group-hover:translate-x-1"></i>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-[#171411] py-16 text-white lg:py-24">
    <div class="container mx-auto px-4">
        <div class="grid gap-12 lg:grid-cols-[0.9fr_1.1fr] lg:items-start">
            <div>
                <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#d5b170]">Promoteurs & programmes neufs</div>
                <h2 class="font-display mt-3 text-3xl font-extrabold leading-tight tracking-[-0.04em] sm:text-5xl">Vous livrez des programmes entiers. Nous équipons les lots.</h2>
                <p class="mt-6 text-lg leading-9 text-white/72">Un appartement équipé d’une cuisine intégrée et de dressings sur mesure se vend plus vite et à un prix plus élevé qu’un appartement brut. Pour un promoteur, l’agencement n’est pas une finition : c’est un levier de valeur perçue.</p>
                <a href="{{ url('/partenaires') }}" class="mt-8 inline-flex items-center justify-center gap-2 rounded-full bg-[#d5b170] px-7 py-4 text-sm font-extrabold text-[#171411] transition hover:bg-white">
                    <i class="fa-regular fa-file-lines"></i>
                    Espace professionnels
                </a>
            </div>
            <div class="rounded-[36px] border border-white/10 bg-white/[0.055] p-7 lg:p-9">
                <p class="text-base leading-8 text-white/78">Nous travaillons avec des promoteurs sur des programmes de 10 à 100+ logements : cuisine de même gamme pour tous les lots, fenêtres aluminium uniformes sur la façade, dressings et placards selon les plans fournis. Tarifs dégressifs selon le volume, livraisons phasées selon l’avancement du chantier, interlocuteur dédié au programme.</p>
                <div class="mt-8 grid gap-3">
                    @foreach($promoterBenefits as $benefit)
                        <div class="flex items-start gap-3 rounded-2xl border border-white/10 bg-black/16 p-4 text-sm font-semibold leading-7 text-white/88">
                            <i class="fa-solid fa-check mt-1 text-[#d5b170]"></i>
                            <span>{{ $benefit }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-white py-16 lg:py-24">
    <div class="container mx-auto px-4">
        <div class="mb-10 max-w-3xl">
            <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#a47834]">Notre avantage</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold leading-tight tracking-[-0.04em] text-[#171411] sm:text-5xl">Bois, aluminium, métal : tout dans un seul atelier.</h2>
        </div>

        <div class="overflow-hidden rounded-[32px] border border-[#eadfce] bg-[#fbf7ee] shadow-[0_24px_70px_rgba(23,20,17,0.07)]">
            <div class="grid grid-cols-2 bg-[#171411] text-sm font-extrabold uppercase tracking-[0.16em] text-white">
                <div class="border-r border-white/12 p-5">Situation classique</div>
                <div class="p-5 text-[#d5b170]">Avec Maison216</div>
            </div>
            @foreach($comparison as $row)
                <div class="grid grid-cols-1 border-t border-[#eadfce] md:grid-cols-2">
                    <div class="border-[#eadfce] p-5 text-base font-semibold leading-7 text-[#6a5a4c] md:border-r">
                        <i class="fa-solid fa-minus mr-2 text-[#a47834]"></i>{{ $row['classic'] }}
                    </div>
                    <div class="bg-white p-5 text-base font-extrabold leading-7 text-[#171411]">
                        <i class="fa-solid fa-check mr-2 text-[#a47834]"></i>{{ $row['maison216'] }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-[#fbf7ee] py-16 lg:py-24">
    <div class="container mx-auto px-4">
        <div class="mb-10 max-w-3xl">
            <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#a47834]">Le processus</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold leading-tight tracking-[-0.04em] text-[#171411] sm:text-5xl">De la livraison des clés à la réception finale.</h2>
        </div>

        <div class="grid gap-4 lg:grid-cols-4">
            @foreach($process as $step)
                <div class="rounded-[30px] border border-[#eadfce] bg-white p-6 shadow-[0_18px_45px_rgba(23,20,17,0.05)]">
                    <div class="text-sm font-extrabold text-[#a47834]">ÉTAPE {{ $step['step'] }}</div>
                    <h3 class="font-display mt-4 text-2xl font-extrabold text-[#171411]">{{ $step['title'] }}</h3>
                    <p class="mt-4 text-sm leading-7 text-[#5f5146]">{{ $step['copy'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-white py-16 lg:py-24">
    <div class="container mx-auto px-4">
        <div class="grid gap-10 lg:grid-cols-[0.7fr_1.3fr]">
            <div>
                <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#a47834]">Questions fréquentes</div>
                <h2 class="font-display mt-3 text-3xl font-extrabold leading-tight tracking-[-0.04em] text-[#171411] sm:text-5xl">Avant d’aménager un appartement neuf.</h2>
            </div>
            <div class="space-y-3">
                @foreach($faqs as $faq)
                    <details class="group rounded-[24px] border border-[#eadfce] bg-[#fbf7ee] p-5">
                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 text-base font-extrabold text-[#171411]">
                            <span>{{ $faq['q'] }}</span>
                            <i class="fa-solid fa-plus text-[#a47834] transition group-open:rotate-45"></i>
                        </summary>
                        <p class="mt-4 text-sm leading-7 text-[#5f5146]">{{ $faq['a'] }}</p>
                    </details>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section class="bg-[#171411] py-16 text-white lg:py-20">
    <div class="container mx-auto px-4 text-center">
        <div class="mx-auto max-w-3xl">
            <h2 class="font-display text-3xl font-extrabold leading-tight tracking-[-0.04em] sm:text-5xl">Vous avez un appartement neuf à aménager ?</h2>
            <p class="mt-5 text-lg leading-8 text-white/72">Visite gratuite, devis groupé sous 48h.</p>
            <div class="mt-8 flex justify-center">
                <a href="{{ $devisUrl }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#d5b170] px-8 py-4 text-sm font-extrabold text-[#171411] transition hover:bg-white">
                    <i class="fa-regular fa-pen-to-square"></i>
                    Demander un devis
                </a>
            </div>
        </div>
    </div>
</section>

<section class="bg-[#fbf7ee] py-14 lg:py-16">
    <div class="container mx-auto px-4">
        <div class="mb-7 max-w-3xl">
            <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#a47834]">Nos services associés</div>
            <h3 class="font-display mt-3 text-2xl font-extrabold text-[#171411] sm:text-3xl">Les pages utiles pour préparer votre devis.</h3>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
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
