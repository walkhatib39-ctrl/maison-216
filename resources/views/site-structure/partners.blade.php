@extends('layouts.store')

@php
    $whatsappUrl = \App\Support\SiteSettings::whatsappUrl() ?? route('contact');
    $phoneDisplay = \App\Support\SiteSettings::phoneDisplay();
    $heroImage = asset('assets/home/amenagement-sur-mesure.jpg');
    $workshopImage = asset('assets/home/menuiserie-bois.webp');

    $proofs = [
        ['label' => 'Respect strict des plans d’exécution', 'icon' => 'fa-solid fa-ruler-combined'],
        ['label' => 'Devis sous 24h pour les professionnels', 'icon' => 'fa-regular fa-clock'],
        ['label' => 'Délais de fabrication contractualisés', 'icon' => 'fa-solid fa-calendar-check'],
        ['label' => 'SAV assuré en interne', 'icon' => 'fa-solid fa-screwdriver-wrench'],
    ];

    $crafts = [
        [
            'title' => 'Menuiserie bois',
            'href' => url('/menuiserie-bois'),
            'icon' => 'fa-solid fa-tree',
            'items' => [
                'Cuisines sur mesure',
                'Dressings et placards intégrés',
                'Meubles TV et bibliothèques',
                'Bureaux et aménagements professionnels',
                'Agencements de magasins, cafés et restaurants',
            ],
        ],
        [
            'title' => 'Menuiserie aluminium',
            'href' => url('/aluminium'),
            'icon' => 'fa-solid fa-border-all',
            'items' => [
                'Fenêtres aluminium',
                'Portes et baies coulissantes',
                'Volets roulants',
                'Brise-soleil',
                'Moustiquaires et garde-corps aluminium',
            ],
        ],
        [
            'title' => 'Fabrication métallique',
            'href' => url('/fer-metal'),
            'icon' => 'fa-solid fa-fire-flame-curved',
            'items' => [
                'Portails fer forgé et contemporains',
                'Pergolas métalliques',
                'Escaliers métalliques',
                'Garde-corps métalliques',
                'Structures sur mesure pour commerces',
            ],
        ],
    ];

    $professions = [
        'Architecte (inscrit à l’Ordre)',
        'Architecte d’intérieur / Designer d’espace',
        'Décorateur',
        'Maître d’œuvre / Bureau d’études',
        'Promoteur immobilier',
        'Entrepreneur général',
        'Agent immobilier / Apporteur d’affaires',
        'Autre professionnel du bâtiment',
    ];

    $faqs = [
        [
            'q' => 'Travaillez-vous sur fichiers DWG ?',
            'a' => 'Oui. Nous pouvons travailler sur DWG, DXF, PDF ou plans papier scannés. Si un détail technique doit être adapté avant fabrication, nous vous le signalons avant de lancer le travail.',
        ],
        [
            'q' => 'Quel est votre délai pour un devis professionnel ?',
            'a' => 'Pour une demande claire avec plans, dimensions ou photos, nous visons un retour sous 24h ouvrées. Pour les projets plus complexes ou multi-lots, le chiffrage peut prendre jusqu’à 48h.',
        ],
        [
            'q' => 'Intervenez-vous aux réunions de chantier ?',
            'a' => 'Oui, si le projet le nécessite. Nous pouvons intervenir pour clarifier nos lots : bois, aluminium ou métal, et coordonner les points techniques avec le chantier.',
        ],
        [
            'q' => 'Quelle est votre zone géographique d’intervention ?',
            'a' => 'Notre atelier est à Borj Cedria. Nous livrons et posons dans le Grand Tunis : Tunis, Ben Arous, Ariana et La Manouba.',
        ],
        [
            'q' => 'Peut-on visiter l’atelier ?',
            'a' => 'Oui. Vous pouvez nous visiter à l’atelier à Borj Cedria. Le plus simple est de nous appeler ou de nous envoyer un WhatsApp avant de passer pour vérifier qu’une personne est disponible.',
        ],
        [
            'q' => 'Comment gérez-vous le SAV des projets professionnels ?',
            'a' => 'Le SAV est suivi par notre équipe. Pour un projet transmis par un professionnel, nous coordonnons l’intervention avec lui avant de contacter le client final, sauf urgence.',
        ],
    ];

    $schema = [
        [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Accueil', 'item' => route('home')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Espace professionnels', 'item' => url('/partenaires')],
            ],
        ],
        [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => 'Maison216',
            'url' => route('home'),
            'hasOfferCatalog' => [
                '@type' => 'OfferCatalog',
                'name' => 'Fabrication professionnelle bois, aluminium et métal',
                'itemListElement' => collect(['Menuiserie bois', 'Menuiserie aluminium', 'Fabrication métallique', 'Sur mesure'])->map(fn ($name) => [
                    '@type' => 'Offer',
                    'itemOffered' => [
                        '@type' => 'Service',
                        'name' => $name,
                    ],
                ])->values()->all(),
            ],
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
    <div class="container mx-auto px-4 py-5">
        <nav class="flex flex-wrap items-center gap-2 text-sm font-semibold text-[#6a5a4c]" aria-label="Fil d'Ariane">
            <a href="{{ route('home') }}" class="transition hover:text-[#171411]">Accueil</a>
            <i class="fa-solid fa-angle-right text-[10px] text-[#b88a3b]"></i>
            <span class="text-[#171411]">Espace professionnels</span>
        </nav>
    </div>
</section>

<section class="relative overflow-hidden bg-[#f7f1e7]">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_16%_20%,rgba(184,138,59,0.16),transparent_34%),radial-gradient(circle_at_86%_14%,rgba(23,20,17,0.08),transparent_32%)]"></div>
    <div class="container relative mx-auto grid gap-12 px-4 py-16 lg:grid-cols-[0.96fr_0.84fr] lg:items-center lg:py-24">
        <div>
            <h1 class="font-display max-w-5xl text-4xl font-extrabold leading-[0.98] tracking-[-0.06em] text-[#171411] sm:text-5xl lg:text-7xl">
                L'atelier Maison216 au service des professionnels du bâtiment.
            </h1>

            <p class="mt-7 max-w-3xl text-lg leading-9 text-[#5f5146]">
                Architectes, maîtres d'œuvre, bureaux d'études, décorateurs, promoteurs et entrepreneurs : Maison216 est votre atelier de fabrication bois, aluminium et métal en Tunisie.
            </p>

            <div class="mt-9 flex flex-col gap-3 sm:flex-row">
                <a href="#contact-professionnel" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#171411] px-8 py-4 text-sm font-extrabold text-white shadow-[0_18px_45px_rgba(23,20,17,0.22)] transition hover:bg-[#a47834]">
                    <i class="fa-regular fa-calendar-check"></i>
                    Demander une visite de l'atelier
                </a>
                <a href="#contact-professionnel" class="inline-flex items-center justify-center gap-2 rounded-full border border-[#cdbb9f] bg-white/78 px-8 py-4 text-sm font-extrabold text-[#171411] transition hover:border-[#a47834] hover:bg-white">
                    <i class="fa-regular fa-file-lines"></i>
                    Nous transmettre un projet à chiffrer
                </a>
            </div>

            <div class="mt-9 grid gap-3 sm:grid-cols-2">
                @foreach($proofs as $proof)
                    <div class="flex items-center gap-3 rounded-2xl border border-[#eadfce] bg-white/72 px-4 py-3 text-sm font-bold text-[#3f352d]">
                        <i class="{{ $proof['icon'] }} text-[#a47834]"></i>
                        <span>{{ $proof['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="relative">
            <div class="relative overflow-hidden rounded-[42px] border border-[#ddcdb8] bg-white p-3 shadow-[0_35px_90px_rgba(23,20,17,0.16)]">
                <img src="{{ $heroImage }}" alt="Atelier Maison216 pour professionnels du bâtiment" class="h-[360px] w-full rounded-[32px] object-cover sm:h-[460px] lg:h-[620px]">
            </div>
        </div>
    </div>
</section>

<section class="bg-white py-16 lg:py-24">
    <div class="container mx-auto px-4">
        <div class="grid gap-12 lg:grid-cols-[0.9fr_0.8fr] lg:items-center">
            <div>
                <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#a47834]">Notre engagement</div>
                <h2 class="font-display mt-3 text-3xl font-extrabold leading-tight tracking-[-0.04em] text-[#171411] sm:text-5xl">Un atelier de fabrication, pas un sous-traitant approximatif.</h2>
                <div class="mt-7 space-y-6 text-base leading-8 text-[#5f5146] sm:text-lg">
                    <p>Maison216 est un atelier de fabrication intégré bois-aluminium-métal basé en Tunisie. Nous travaillons avec des architectes, des maîtres d'œuvre, des bureaux d'études, des décorateurs et des promoteurs sur des projets résidentiels et commerciaux.</p>
                    <p>Notre engagement principal vis-à-vis des professionnels du bâtiment est simple : fabriquer clairement, poser proprement et rester joignable après la livraison.</p>
                    <p class="font-extrabold text-[#171411]">Vous avez un interlocuteur clair, un devis exploitable et une équipe qui connaît le chantier du début à la fin.</p>
                </div>
            </div>
            <div class="overflow-hidden rounded-[38px] border border-[#eadfce] bg-[#fbf7ee] p-3 shadow-[0_24px_70px_rgba(23,20,17,0.10)]">
                <img src="{{ $workshopImage }}" alt="Atelier Maison216 à Borj Cedria" class="h-[360px] w-full rounded-[28px] object-cover lg:h-[500px]">
            </div>
        </div>
    </div>
</section>

<section class="bg-[#171411] py-16 text-white lg:py-24">
    <div class="container mx-auto px-4">
        <div class="grid gap-12 lg:grid-cols-[0.88fr_1.12fr] lg:items-start">
            <div>
                <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#d5b170]">Notre spécificité</div>
                <h2 class="font-display mt-3 text-3xl font-extrabold leading-tight tracking-[-0.04em] sm:text-5xl">Bois, aluminium et métal sous un même toit</h2>
            </div>
            <div class="space-y-6 text-base leading-8 text-white/72 sm:text-lg">
                <p>Sur un même projet, vous pouvez avoir besoin de bois pour les rangements, d’aluminium pour les ouvertures et de métal pour les portails, pergolas ou garde-corps.</p>
                <p>Maison216 regroupe ces trois métiers dans un même atelier. Cela simplifie les échanges, réduit les zones floues entre prestataires et facilite la coordination des poses.</p>
                <p class="font-extrabold text-white">Pour un professionnel, l’intérêt est direct : moins d’intermédiaires, moins de perte d’information, plus de visibilité sur l’exécution.</p>
            </div>
        </div>
    </div>
</section>

<section class="bg-[#fbf7ee] py-16 lg:py-24">
    <div class="container mx-auto px-4">
        <div class="mb-10 max-w-4xl">
            <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#a47834]">Notre gamme professionnelle</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold leading-tight tracking-[-0.04em] text-[#171411] sm:text-5xl">Trois métiers, une gamme complète.</h2>
        </div>

        <div class="grid gap-5 lg:grid-cols-3">
            @foreach($crafts as $craft)
                <a href="{{ $craft['href'] }}" class="group rounded-[34px] border border-[#eadfce] bg-white p-7 shadow-[0_20px_55px_rgba(23,20,17,0.06)] transition hover:-translate-y-1 hover:shadow-[0_28px_75px_rgba(23,20,17,0.10)]">
                    <span class="inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-[#171411] text-xl text-[#d5b170]">
                        <i class="{{ $craft['icon'] }}"></i>
                    </span>
                    <h3 class="font-display mt-6 text-2xl font-extrabold text-[#171411]">{{ $craft['title'] }}</h3>
                    <ul class="mt-6 space-y-3 text-sm leading-6 text-[#5f5146]">
                        @foreach($craft['items'] as $item)
                            <li class="flex gap-3">
                                <i class="fa-solid fa-check mt-1 text-xs text-[#a47834]"></i>
                                <span>{{ $item }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-7 text-sm font-extrabold text-[#8e6322]">Voir la page <i class="fa-solid fa-arrow-right ml-1 text-xs transition group-hover:translate-x-1"></i></div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section id="contact-professionnel" class="bg-white py-16 lg:py-24">
    <div class="container mx-auto px-4">
        <div class="grid gap-12 lg:grid-cols-[0.75fr_1.25fr] lg:items-start">
            <div>
                <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#a47834]">Prendre contact</div>
                <h2 class="font-display mt-3 text-3xl font-extrabold leading-tight tracking-[-0.04em] text-[#171411] sm:text-5xl">Présentez-vous. Nous revenons vers vous sous 24h.</h2>
                <p class="mt-5 text-base leading-8 text-[#5f5146]">Envoyez votre demande, vos plans ou votre besoin. Nous vous répondons avec les prochaines étapes.</p>
                <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="mt-7 inline-flex items-center gap-2 rounded-full border border-[#eadfce] bg-[#fbf7ee] px-5 py-3 text-sm font-extrabold text-[#171411]">
                    <i class="fa-brands fa-whatsapp text-[#a47834]"></i>
                    WhatsApp professionnels : {{ $phoneDisplay }}
                </a>
            </div>

            <form action="{{ route('contact.submit') }}" method="post" class="rounded-[34px] border border-[#eadfce] bg-[#fbf7ee] p-6 shadow-[0_20px_60px_rgba(23,20,17,0.07)] lg:p-8">
                @csrf
                <input type="hidden" name="subject" value="Demande espace professionnels">

                <div class="grid gap-4 md:grid-cols-2">
                    <label class="block">
                        <span class="text-sm font-bold text-[#171411]">Prénom & Nom *</span>
                        <input type="text" name="name" required value="{{ old('name') }}" class="mt-2 w-full rounded-2xl border border-[#eadfce] bg-white px-4 py-3 text-sm focus:border-[#a47834] focus:ring-0">
                    </label>
                    <label class="block">
                        <span class="text-sm font-bold text-[#171411]">Entreprise / Cabinet *</span>
                        <input type="text" name="company" required value="{{ old('company') }}" class="mt-2 w-full rounded-2xl border border-[#eadfce] bg-white px-4 py-3 text-sm focus:border-[#a47834] focus:ring-0">
                    </label>
                    <label class="block md:col-span-2">
                        <span class="text-sm font-bold text-[#171411]">Votre profession *</span>
                        <select name="profession" required class="mt-2 w-full rounded-2xl border border-[#eadfce] bg-white px-4 py-3 text-sm focus:border-[#a47834] focus:ring-0">
                            <option value="">Sélectionner votre profil</option>
                            @foreach($professions as $profession)
                                <option value="{{ $profession }}" @selected(old('profession') === $profession)>{{ $profession }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="block">
                        <span class="text-sm font-bold text-[#171411]">Téléphone / WhatsApp *</span>
                        <input type="tel" name="phone" required value="{{ old('phone') }}" placeholder="{{ $phoneDisplay }}" class="mt-2 w-full rounded-2xl border border-[#eadfce] bg-white px-4 py-3 text-sm focus:border-[#a47834] focus:ring-0">
                    </label>
                    <label class="block">
                        <span class="text-sm font-bold text-[#171411]">Email professionnel *</span>
                        <input type="email" name="email" required value="{{ old('email') }}" class="mt-2 w-full rounded-2xl border border-[#eadfce] bg-white px-4 py-3 text-sm focus:border-[#a47834] focus:ring-0">
                    </label>
                    <label class="block md:col-span-2">
                        <span class="text-sm font-bold text-[#171411]">Votre demande *</span>
                        <textarea name="message" rows="5" required class="mt-2 w-full rounded-2xl border border-[#eadfce] bg-white px-4 py-3 text-sm focus:border-[#a47834] focus:ring-0">{{ old('message') }}</textarea>
                    </label>
                </div>

                <button type="submit" class="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-full bg-[#171411] px-7 py-4 text-sm font-extrabold text-white transition hover:bg-[#a47834] sm:w-auto">
                    Envoyer ma demande
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </form>
        </div>
    </div>
</section>

<section class="bg-[#fbf7ee] py-16 lg:py-24">
    <div class="container mx-auto px-4">
        <div class="grid gap-10 lg:grid-cols-[0.7fr_1.3fr]">
            <div>
                <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#a47834]">Questions fréquentes</div>
                <h2 class="font-display mt-3 text-3xl font-extrabold leading-tight tracking-[-0.04em] text-[#171411] sm:text-5xl">Questions des professionnels du bâtiment.</h2>
            </div>
            <div class="space-y-3">
                @foreach($faqs as $faq)
                    <details class="group rounded-[24px] border border-[#eadfce] bg-white p-5">
                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-display text-base font-extrabold text-[#171411]">
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

<section class="bg-[#f7f1e7] py-16 lg:py-20">
    <div class="container mx-auto px-4 text-center">
        <div class="mx-auto max-w-3xl rounded-[38px] border border-[#eadfce] bg-white p-8 shadow-[0_24px_70px_rgba(23,20,17,0.08)] lg:p-10">
            <h2 class="font-display text-3xl font-extrabold leading-tight tracking-[-0.04em] text-[#171411] sm:text-5xl">Travaillons ensemble sur votre prochain projet.</h2>
            <p class="mt-5 text-lg leading-8 text-[#5f5146]">Envoyez votre demande ou passez par WhatsApp. Nous vous répondons avec un cadrage clair.</p>
            <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
                <a href="#contact-professionnel" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#171411] px-8 py-4 text-sm font-extrabold text-white transition hover:bg-[#a47834]">Prendre contact</a>
                <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center gap-2 rounded-full border border-[#cdbb9f] bg-white px-8 py-4 text-sm font-extrabold text-[#171411] transition hover:border-[#a47834]">
                    <i class="fa-brands fa-whatsapp"></i>
                    WhatsApp professionnels
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
