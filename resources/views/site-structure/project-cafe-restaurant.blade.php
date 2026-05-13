@extends('layouts.store')

@php
    $devisUrl = url('/devis');
    $heroImage = asset('assets/home/realizations/amenagement-restaurant.jpg');
    $woodImage = asset('assets/home/menuiserie-bois.webp');
    $metalImage = asset('assets/home/fabrication-metallique.jpg');
    $aluImage = asset('assets/home/menuiserie-aluminium.jpg');
    $pergolaImage = asset('assets/home/realizations/pergola.jpg');

    $proofs = [
        ['label' => 'Conception & fabrication intégrées', 'icon' => 'fa-solid fa-drafting-compass'],
        ['label' => 'Bois + métal + alu', 'icon' => 'fa-solid fa-layer-group'],
        ['label' => 'Un seul interlocuteur', 'icon' => 'fa-solid fa-user-check'],
        ['label' => 'Planning d’ouverture respecté', 'icon' => 'fa-solid fa-calendar-check'],
    ];

    $scopeItems = [
        [
            'title' => 'Le comptoir',
            'copy' => 'La pièce centrale de tout café. Il est vu par tous les clients, structure la circulation et doit résister à un usage intensif quotidien. Nous le fabriquons en bois, en métal ou en combinaison des deux, avec habillage, étagères et rangements intégrés.',
            'image' => $heroImage,
            'icon' => 'fa-solid fa-shop',
        ],
        [
            'title' => 'Le mobilier',
            'copy' => 'Tables sur mesure aux dimensions qui optimisent votre surface, banquettes murales rembourrées ou en bois selon votre style, étagères de présentation et éléments décoratifs.',
            'image' => $woodImage,
            'icon' => 'fa-solid fa-chair',
        ],
        [
            'title' => 'Les vitrines et façades',
            'copy' => 'Vitrine de présentation pour pâtisseries et produits à emporter, façade vitrée aluminium pour les concepts ouverts sur la rue, devanture avec identité visuelle intégrée.',
            'image' => $aluImage,
            'icon' => 'fa-regular fa-window-maximize',
        ],
        [
            'title' => 'La terrasse couverte',
            'copy' => 'Une pergola métallique ou bioclimatique transforme votre terrasse en surface d’exploitation à part entière, utilisable plus longtemps, avec une expérience client plus confortable.',
            'image' => $pergolaImage,
            'icon' => 'fa-solid fa-umbrella-beach',
        ],
        [
            'title' => 'L’éclairage et les petites menuiseries',
            'copy' => 'Niches d’éclairage intégrées, tablettes, panneaux décoratifs, habillages de piliers et caissons de plafond en bois pour donner une vraie cohérence au concept.',
            'image' => $metalImage,
            'icon' => 'fa-regular fa-lightbulb',
        ],
    ];

    $audiences = [
        [
            'title' => 'Café & salon de thé',
            'copy' => 'Comptoir, mobilier, vitrine de présentation et terrasse. Concept industriel, scandinave, marocain moderne ou contemporain épuré : nous fabriquons dans le style de votre concept.',
            'icon' => 'fa-solid fa-mug-saucer',
        ],
        [
            'title' => 'Restaurant',
            'copy' => 'Tables et chaises sur mesure, banquettes murales, buffet de service, habillage des murs et des poteaux, zone de caisse intégrée.',
            'icon' => 'fa-solid fa-utensils',
        ],
        [
            'title' => 'Hôtel & riad',
            'copy' => 'Hall d’accueil, mobilier de lobby, comptoir de réception, mobilier de chambre si applicable, terrasse couverte et éléments décoratifs coordonnés.',
            'icon' => 'fa-solid fa-hotel',
        ],
        [
            'title' => 'Franchise & concept en expansion',
            'copy' => 'Si vous ouvrez plusieurs implantations, nous pouvons reproduire les mêmes éléments en série avec une cohérence visuelle parfaite d’un espace à l’autre.',
            'icon' => 'fa-solid fa-store',
        ],
    ];

    $process = [
        ['step' => '01', 'title' => 'Visite & brief', 'copy' => 'Nous venons voir votre espace, local nu ou en rénovation, comprenons votre concept et votre budget, et conseillons sur les priorités.'],
        ['step' => '02', 'title' => 'Conception & devis', 'copy' => 'Plans de l’agencement, choix des matériaux et des finitions, devis détaillé. Acompte de 30% à la signature.'],
        ['step' => '03', 'title' => 'Fabrication', 'copy' => 'Fabrication en atelier selon votre planning d’ouverture. Priorité aux éléments structurants comme le comptoir et la pergola pour libérer le chantier.'],
        ['step' => '04', 'title' => 'Pose & ouverture', 'copy' => 'Installation coordonnée, finitions, mise en place. Respect du planning d’ouverture. Garantie atelier active.'],
    ];

    $faqs = [
        [
            'q' => 'Quel est le budget moyen pour l’agencement d’un café en Tunisie ?',
            'a' => 'Un café de 80-150m² avec comptoir, mobilier standard et terrasse couverte représente généralement un budget de 25 000 à 80 000 DT selon les finitions et le niveau d’équipement. Devis personnalisé selon votre surface et votre concept.',
        ],
        [
            'q' => 'Pouvez-vous travailler sur un local vide comme sur une rénovation ?',
            'a' => 'Oui dans les deux cas. Pour un local vide, nous intervenons après les travaux de gros œuvre : plomberie, électricité, carrelage. Pour une rénovation, nous pouvons déposer l’ancien agencement et remodeler l’espace entièrement.',
        ],
        [
            'q' => 'Respectez-vous les délais d’ouverture ?',
            'a' => 'Le délai d’ouverture est contractualisé. Nous planifions la fabrication et la pose en fonction de votre date d’ouverture, pas l’inverse. C’est un engagement pris à la signature du devis.',
        ],
        [
            'q' => 'Faites-vous aussi les terrasses couvertes ?',
            'a' => 'Oui. Pergola métallique adossée ou autoportée, avec couverture polycarbonate, bois ou lames orientables. Nous pouvons intégrer cette partie dans le même devis que le comptoir et le mobilier.',
        ],
    ];

    $internalLinks = [
        ['title' => 'Menuiserie bois', 'href' => url('/menuiserie-bois'), 'copy' => 'Comptoirs, mobilier, habillages.'],
        ['title' => 'Fabrication métallique', 'href' => url('/fer-metal'), 'copy' => 'Structures, pieds, pergolas.'],
        ['title' => 'Menuiserie aluminium', 'href' => url('/aluminium'), 'copy' => 'Façades vitrées et devantures.'],
        ['title' => 'Pergola métallique', 'href' => url('/fer-metal/pergola-metallique'), 'copy' => 'Terrasse couverte exploitable.'],
        ['title' => 'Agencement magasin', 'href' => url('/projets/agencement-magasin'), 'copy' => 'Boutique, showroom, présentoirs.'],
        ['title' => 'Agencement bureau entreprise', 'href' => url('/projets/agencement-bureau-entreprise'), 'copy' => 'Bureaux, accueil, rangements.'],
    ];
    $projectRealizations = app(\App\Support\RealizationResolver::class)->forPage('projets/agencement-cafe-restaurant', 6, 'projets');

    $schema = [
        [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Accueil', 'item' => route('home')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Projets', 'item' => url('/projets')],
                ['@type' => 'ListItem', 'position' => 3, 'name' => 'Agencement café & restaurant', 'item' => url('/projets/agencement-cafe-restaurant')],
            ],
        ],
        [
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'serviceType' => 'Agencement café et restaurant',
            'name' => 'Agencement café et restaurant sur mesure en Tunisie',
            'description' => 'Comptoir, mobilier, banquettes, vitrines et terrasse couverte pour cafés et restaurants en Tunisie.',
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
            <span class="text-[#171411]">Agencement café & restaurant</span>
        </nav>
    </div>
</section>

<section class="relative overflow-hidden bg-[#f7f1e7]">
    <div class="absolute inset-y-0 right-0 hidden w-[44%] bg-[radial-gradient(circle_at_center,rgba(184,138,59,0.18),transparent_62%)] lg:block"></div>
    <div class="container relative mx-auto px-4 py-16 lg:py-24">
        <div class="grid gap-12 lg:grid-cols-[0.96fr_0.84fr] lg:items-center">
            <div>
                <div class="inline-flex items-center gap-2 rounded-full border border-[#ddcdb8] bg-white/70 px-4 py-2 text-xs font-extrabold uppercase tracking-[0.22em] text-[#8e6322]">
                    <i class="fa-solid fa-utensils"></i>
                    Projet · Café & restaurant
                </div>

                <h1 class="font-display mt-7 max-w-4xl text-4xl font-extrabold leading-[0.98] tracking-[-0.06em] text-[#171411] sm:text-5xl lg:text-7xl">
                    Agencement café et restaurant sur mesure en Tunisie.
                </h1>

                <p class="mt-7 max-w-3xl text-lg leading-9 text-[#5f5146]">
                    Comptoir, mobilier, banquettes, vitrines, terrasse couverte : nous concevons et fabriquons l’agencement complet de votre café ou restaurant en Tunisie.
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
                        <img src="{{ $heroImage }}" alt="Agencement café restaurant réalisé par Maison216" class="absolute inset-0 h-full w-full object-cover">
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
                <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#a47834]">La réalité du marché</div>
                <h2 class="font-display mt-3 text-3xl font-extrabold leading-tight tracking-[-0.04em] text-[#171411] sm:text-5xl">En Tunisie, les clients choisissent un café sur une photo Instagram avant d’y entrer.</h2>
            </div>
            <div class="space-y-6 text-base leading-8 text-[#5f5146] sm:text-lg">
                <p>Ce n’est plus simplement vrai à Paris ou à Dubaï. Ça l’est aussi à La Marsa, aux Berges du Lac, à Gammarth, à Hammamet et à Sousse. Les nouveaux cafés et restaurants tunisiens qui remplissent sont ceux dont l’espace est aussi bien pensé que le menu.</p>
                <p>Un espace qui raconte un concept, qui crée une atmosphère cohérente entre le comptoir, les tables, les murs et la terrasse, c’est un espace qui se photographie, qui se partage, qui fait revenir.</p>
                <p class="font-bold text-[#171411]">Nous ne fabriquons pas des meubles pour café. Nous fabriquons des espaces qui travaillent pour votre établissement.</p>
            </div>
        </div>
    </div>
</section>

<section class="bg-[#fbf7ee] py-16 lg:py-24">
    <div class="container mx-auto px-4">
        <div class="mb-10 max-w-4xl">
            <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#a47834]">Notre gamme CHR</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold leading-tight tracking-[-0.04em] text-[#171411] sm:text-5xl">Du comptoir à la terrasse, tout sous un même atelier.</h2>
        </div>

        <div class="grid gap-5 lg:grid-cols-2">
            @foreach($scopeItems as $item)
                <article class="group overflow-hidden rounded-[34px] border border-[#eadfce] bg-white shadow-[0_18px_60px_rgba(23,20,17,0.07)] transition hover:-translate-y-1 hover:shadow-[0_28px_80px_rgba(23,20,17,0.12)]">
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
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-white py-16 lg:py-24">
    <div class="container mx-auto px-4">
        <div class="mb-10 max-w-4xl">
            <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#a47834]">Pour qui</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold leading-tight tracking-[-0.04em] text-[#171411] sm:text-5xl">Tout type d’établissement CHR en Tunisie.</h2>
        </div>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
            @foreach($audiences as $audience)
                <div class="rounded-[30px] border border-[#eadfce] bg-[#fbf7ee] p-6">
                    <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-[#171411] text-xl text-[#d5b170]">
                        <i class="{{ $audience['icon'] }}"></i>
                    </span>
                    <h3 class="font-display mt-5 text-2xl font-extrabold text-[#171411]">{{ $audience['title'] }}</h3>
                    <p class="mt-4 text-sm leading-7 text-[#5f5146]">{{ $audience['copy'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-[#171411] py-16 text-white lg:py-24">
    <div class="container mx-auto px-4">
        <div class="grid gap-12 lg:grid-cols-[0.86fr_1.14fr] lg:items-center">
            <div>
                <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#d5b170]">Notre valeur ajoutée</div>
                <h2 class="font-display mt-3 text-3xl font-extrabold leading-tight tracking-[-0.04em] sm:text-5xl">Bois, métal et aluminium dans un seul atelier.</h2>
            </div>
            <div class="rounded-[36px] border border-white/10 bg-white/[0.055] p-7 lg:p-9">
                <div class="space-y-6 text-base leading-8 text-white/76">
                    <p>Pour un café, vous avez besoin de bois pour le comptoir et le mobilier, de métal pour les structures, les étagères et les pieds, et parfois d’aluminium pour la façade vitrée ou la terrasse.</p>
                    <p>La plupart du temps, les restaurateurs font appel à 2 ou 3 artisans différents qui ne se coordonnent pas. Résultat : des délais qui glissent, des finitions qui ne s’accordent pas, et une ouverture repoussée.</p>
                    <p class="font-extrabold text-white">Notre atelier fabrique les trois matériaux. Un seul devis, un seul planning, une seule équipe de pose.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-[#fbf7ee] py-16 lg:py-24">
    <div class="container mx-auto px-4">
        <div class="mb-10 max-w-3xl">
            <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#a47834]">Le processus</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold leading-tight tracking-[-0.04em] text-[#171411] sm:text-5xl">Du brief à l’ouverture, en 4 étapes.</h2>
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

@include('site-structure.partials.realization-showcase', [
    'realizations' => $projectRealizations,
    'eyebrow' => 'Réalisations CHR',
    'title' => 'Quelques projets livrés pour cafés, restaurants et espaces commerciaux.',
    'description' => 'Comptoirs, mobilier, pergolas, façades et agencements coordonnés dans un seul atelier.',
    'linkHref' => route('realizations.index', ['silo' => 'projets']),
    'linkLabel' => 'Voir toutes les réalisations projet',
])

<section class="bg-white py-16 lg:py-24">
    <div class="container mx-auto px-4">
        <div class="grid gap-10 lg:grid-cols-[0.7fr_1.3fr]">
            <div>
                <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#a47834]">Questions fréquentes</div>
                <h2 class="font-display mt-3 text-3xl font-extrabold leading-tight tracking-[-0.04em] text-[#171411] sm:text-5xl">Avant d’agencer un café ou restaurant.</h2>
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
            <h2 class="font-display text-3xl font-extrabold leading-tight tracking-[-0.04em] sm:text-5xl">Vous ouvrez ou rénovez un café, un restaurant ?</h2>
            <p class="mt-5 text-lg leading-8 text-white/72">Visite et brief gratuits. Devis sous 48h.</p>
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
            <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#a47834]">Maillage interne</div>
            <h3 class="font-display mt-3 text-2xl font-extrabold text-[#171411] sm:text-3xl">Les pages utiles pour cadrer votre projet CHR.</h3>
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
