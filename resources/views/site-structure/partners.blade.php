@extends('layouts.store')

@php
    $devisUrl = url('/devis');
    $contactUrl = route('contact');
    $whatsappUrl = 'https://wa.me/21696813203';
    $heroImage = asset('assets/home/amenagement-sur-mesure.jpg');

    $proofs = [
        ['label' => 'Respect strict des plans d’exécution', 'icon' => 'fa-solid fa-ruler-combined'],
        ['label' => 'Devis sous 24h pour les professionnels', 'icon' => 'fa-regular fa-clock'],
        ['label' => 'Délais de fabrication contractualisés', 'icon' => 'fa-solid fa-calendar-check'],
        ['label' => 'SAV assuré en interne', 'icon' => 'fa-solid fa-screwdriver-wrench'],
    ];

    $engagementPillars = [
        ['title' => 'Respect strict des plans d’exécution', 'copy' => 'Nous travaillons sur fichiers DWG, DXF, PDF ou plans papier scannés. Chaque cote est vérifiée avant lancement en atelier. Si une contrainte technique empêche l’exécution exacte d’un détail, nous vous contactons avant de fabriquer, jamais après.', 'icon' => 'fa-solid fa-drafting-compass'],
        ['title' => 'Délais contractualisés', 'copy' => 'Chaque devis inclut un délai de fabrication et une date de pose précise. Nous planifions nos ateliers en fonction de votre calendrier de chantier et signalons immédiatement toute contrainte de planning.', 'icon' => 'fa-solid fa-file-signature'],
        ['title' => 'Interlocuteur unique du devis au SAV', 'copy' => 'Vous avez un seul interlocuteur dédié qui suit votre dossier de bout en bout. Pas de standard, pas de redirection, pas de confusion entre fabrication, pose et SAV.', 'icon' => 'fa-solid fa-user-check'],
        ['title' => 'SAV assuré par notre équipe interne', 'copy' => 'Toute intervention SAV est gérée directement par l’atelier qui a fabriqué le projet. Délai d’intervention pour les demandes courantes : 5 jours ouvrés maximum.', 'icon' => 'fa-solid fa-shield-heart'],
    ];

    $crafts = [
        [
            'title' => 'Menuiserie bois',
            'href' => url('/menuiserie-bois'),
            'icon' => 'fa-solid fa-tree',
            'items' => [
                'Cuisines sur mesure : mélaminé, MDF laqué, plaqué bois, massif',
                'Dressings et placards intégrés',
                'Meubles TV et bibliothèques sur mesure',
                'Bureaux et aménagements professionnels',
                'Portes intérieures et précadres',
                'Agencements de magasins, cafés, restaurants',
            ],
        ],
        [
            'title' => 'Menuiserie aluminium',
            'href' => url('/aluminium'),
            'icon' => 'fa-solid fa-border-all',
            'items' => [
                'Fenêtres aluminium à rupture de pont thermique, double vitrage',
                'Portes et baies coulissantes',
                'Volets roulants manuels ou motorisés',
                'Brise-soleil fixes ou orientables',
                'Moustiquaires sur mesure',
                'Garde-corps aluminium et inox',
            ],
        ],
        [
            'title' => 'Fabrication métallique',
            'href' => url('/fer-metal'),
            'icon' => 'fa-solid fa-fire-flame-curved',
            'items' => [
                'Portails fer forgé et contemporains, manuels ou motorisés',
                'Pergolas métalliques et bioclimatiques',
                'Escaliers métalliques droits, hélicoïdaux, suspendus',
                'Garde-corps métalliques intérieur et extérieur',
                'Structures sur mesure pour CHR et commerces',
                'Charpente légère et habillages',
            ],
        ],
    ];

    $architectServices = [
        ['title' => 'Devis chiffré sous 24h', 'copy' => 'Sur la base de vos plans d’exécution, DWG ou PDF, nous transmettons un devis détaillé sous 24h ouvrées pour vous permettre de répondre rapidement à vos clients.'],
        ['title' => 'Étude technique préalable gratuite', 'copy' => 'Notre bureau d’études revoit vos plans avant fabrication pour identifier les contraintes de mise en œuvre et proposer une alternative si un détail doit être adapté.'],
        ['title' => 'Visite de chantier sur demande', 'copy' => 'Pour les projets complexes, notre chef d’atelier ou notre technicien de pose peut se déplacer aux réunions techniques concernant nos fabrications.'],
        ['title' => 'Accès prioritaire à l’atelier', 'copy' => 'Vous pouvez visiter notre atelier avec votre client : choix des matériaux, validation des prototypes, contrôle de fabrication. Sur rendez-vous, en semaine.'],
        ['title' => 'Photos professionnelles des réalisations livrées', 'copy' => 'Après livraison, nous pouvons organiser une session photo du résultat final. Les photos vous appartiennent pour votre portfolio et ne sont utilisées par Maison216 qu’avec votre accord écrit.'],
        ['title' => 'Coordination avec les autres corps de métier', 'copy' => 'Sur les projets multi-lots, nous coordonnons l’enchaînement de nos interventions avec l’entrepreneur général ou le maître d’œuvre.'],
        ['title' => 'Confidentialité totale vis-à-vis de votre client', 'copy' => 'Vous restez l’interlocuteur principal. Maison216 ne contacte jamais votre client sans votre accord préalable et aucune information commerciale n’est échangée sans validation.'],
    ];

    $architectSteps = [
        ['title' => 'Visite de l’atelier', 'copy' => 'Vous prenez rendez-vous pour visiter nos installations et évaluer notre capacité de production. Visite gratuite, en semaine, 9h-17h.'],
        ['title' => 'Transmission d’un projet à chiffrer', 'copy' => 'Vous nous transmettez les plans d’un projet en cours pour évaluation technique et chiffrage sous 24h ouvrées.'],
        ['title' => 'Premier projet test', 'copy' => 'Nous fabriquons selon vos plans et nous livrons dans le délai contractualisé.'],
        ['title' => 'Évaluation et continuation', 'copy' => 'Après livraison, vous évaluez la qualité du travail et nous ajustons notre collaboration selon votre retour.'],
    ];

    $businessOffers = [
        ['title' => 'Rémunération d’apport d’affaires', 'copy' => 'Convention écrite définissant les conditions applicables selon le volume de projets apportés, avec versement à la livraison de chaque projet selon les modalités prévues.'],
        ['title' => 'Tarifs préférentiels', 'copy' => 'Accès à une grille négociée pour vos projets personnels : rénovation de votre logement, projets familiaux ou besoins internes.'],
        ['title' => 'Devis prioritaire', 'copy' => 'Devis sous 24h ouvrées pour vos clients prescrits. Vous recevez le devis avant transmission au client final, avec une présentation adaptée à votre marque.'],
        ['title' => 'Photos professionnelles', 'copy' => 'Sessions photo offertes après chaque projet livré. Les photos vous appartiennent pour votre portfolio.'],
        ['title' => 'Étude technique gratuite', 'copy' => 'Nos techniciens étudient vos plans ou vos idées avant chiffrage pour valider la faisabilité technique.'],
        ['title' => 'Sans engagement minimum', 'copy' => 'Aucun volume minimum exigé et aucune exclusivité demandée. Vous restez libre de travailler avec d’autres ateliers.'],
    ];

    $businessSteps = [
        ['title' => 'Premier contact', 'copy' => 'Vous nous contactez par formulaire ou WhatsApp. Nous fixons un rendez-vous à l’atelier.'],
        ['title' => 'Visite et convention', 'copy' => 'Vous visitez l’atelier, nous présentons nos capacités et la convention d’apport d’affaires.'],
        ['title' => 'Signature', 'copy' => 'La convention est signée en deux exemplaires et définit les conditions, les modalités et les engagements réciproques.'],
        ['title' => 'Premier projet', 'copy' => 'Dès le premier projet livré, la relation est activée selon les termes de la convention.'],
    ];

    $promoterOffers = [
        ['title' => 'Tarifs dégressifs selon le volume', 'copy' => 'À partir de 5 lots équipés : tarifs préférentiels. À partir de 15 lots : conditions programme dédiées. À partir de 30 lots : contrat-cadre annuel négocié.'],
        ['title' => 'Chef de projet dédié au programme', 'copy' => 'Un interlocuteur unique coordonne l’ensemble du programme, les livraisons phasées et votre planning chantier.'],
        ['title' => 'Livraisons phasées', 'copy' => 'Nous adaptons nos cycles de fabrication à votre calendrier : cuisines après peinture, avant remise des clés, et lots selon avancement.'],
        ['title' => 'Facturation B2B adaptée', 'copy' => 'Délais de paiement standard du secteur immobilier, facturation par lot ou par tranche selon votre comptabilité.'],
        ['title' => 'Référencement fournisseur', 'copy' => 'Sur demande, nous fournissons les éléments administratifs nécessaires : attestations, RC, CNSS, capacité, références.'],
        ['title' => 'Argument commercial pour vos lots', 'copy' => 'Un appartement livré avec cuisine intégrée et dressings sur mesure se vend plus vite et à un prix supérieur qu’un appartement brut.'],
    ];

    $contractorOffers = [
        ['title' => 'Sous-traitance complète', 'copy' => 'Lot menuiserie bois, lot aluminium ou lot métallerie selon vos besoins, avec possibilité de prendre plusieurs lots sur un même chantier.'],
        ['title' => 'Devis rapide sur plans', 'copy' => 'Sur la base de plans d’exécution ou de métrés fournis, devis sous 24-48h selon la complexité.'],
        ['title' => 'Coordination chantier', 'copy' => 'Présence aux réunions pour nos lots, respect du planning général et coordination avec les autres corps de métier.'],
        ['title' => 'Conditions B2B', 'copy' => 'Facturation entreprise avec délais 30/60 jours, attestations administratives complètes, tarifs nets négociés au cas par cas.'],
        ['title' => 'Référencement fournisseur', 'copy' => 'Dossier de référencement complet disponible sur simple demande.'],
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
        ['q' => 'Travaillez-vous sur fichiers DWG ?', 'a' => 'Oui. Nous travaillons sur DWG, DXF, PDF ou plans papier scannés. Nos techniciens lisent les plans d’architecture et les plans d’exécution. Si une contrainte technique empêche l’exécution exacte d’un détail, nous vous contactons avant de commencer la fabrication.'],
        ['q' => 'Quel est votre délai pour un devis professionnel ?', 'a' => '24 heures ouvrées pour un devis sur plans transmis par un professionnel. Pour les projets complexes ou multi-lots, le délai peut aller jusqu’à 48h avec une étude technique préalable.'],
        ['q' => 'Intervenez-vous aux réunions de chantier ?', 'a' => 'Oui, sur demande. Notre chef d’atelier ou notre technicien de pose peut se déplacer à vos réunions de chantier pour les sujets concernant nos fabrications. Service inclus dans notre prestation pour les sujets techniques liés à nos lots.'],
        ['q' => 'Quelle est votre zone géographique d’intervention ?', 'a' => 'Nous intervenons sur le Grand Tunis, Sousse, Sfax, Hammamet, Bizerte, Nabeul et les principales villes tunisiennes. Pour les programmes immobiliers importants, nous étudions toute zone en Tunisie.'],
        ['q' => 'Peut-on visiter l’atelier ?', 'a' => 'Oui. Nous encourageons fortement la visite avant tout projet. Vous voyez nos capacités réelles, notre équipement et notre niveau de finition. Visite sur rendez-vous, en semaine, 9h-17h.'],
        ['q' => 'Que comprend la convention d’apport d’affaires ?', 'a' => 'Une convention écrite de deux à trois pages définit les conditions de rémunération, les modalités de paiement, les obligations de confidentialité et les conditions de résiliation. Le document est remis lors de la visite atelier.'],
        ['q' => 'Comment gérez-vous le SAV des projets professionnels ?', 'a' => 'Le SAV est centralisé sur notre équipe interne. Pour les projets transmis par un professionnel, nous coordonnons avec ce professionnel avant toute intervention chez son client final, sauf urgence avérée.'],
        ['q' => 'Pratiquez-vous une exclusivité avec les professionnels ?', 'a' => 'Non. Nous n’exigeons aucune exclusivité. Vous restez libre de travailler avec d’autres ateliers selon les besoins de vos projets et de vos clients.'],
    ];

    $serviceLinks = [
        ['title' => 'Menuiserie bois', 'href' => url('/menuiserie-bois')],
        ['title' => 'Menuiserie aluminium', 'href' => url('/aluminium')],
        ['title' => 'Fabrication métallique', 'href' => url('/fer-metal')],
        ['title' => 'Sur mesure', 'href' => url('/sur-mesure')],
    ];

    $projectLinks = [
        ['title' => 'Aménagement villa & maison', 'href' => url('/projets/amenagement-villa-maison')],
        ['title' => 'Agencement immobilier neuf', 'href' => url('/projets/agencement-immobilier-neuf')],
        ['title' => 'Agencement café & restaurant', 'href' => url('/projets/agencement-cafe-restaurant')],
        ['title' => 'Agencement magasin', 'href' => url('/projets/agencement-magasin')],
        ['title' => 'Agencement bureau entreprise', 'href' => url('/projets/agencement-bureau-entreprise')],
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
            <div class="inline-flex items-center gap-2 rounded-full border border-[#ddcdb8] bg-white/70 px-4 py-2 text-xs font-extrabold uppercase tracking-[0.22em] text-[#8e6322]">
                <i class="fa-solid fa-user-tie"></i>
                Espace professionnels · Maison216
            </div>

            <h1 class="font-display mt-7 max-w-5xl text-4xl font-extrabold leading-[0.98] tracking-[-0.06em] text-[#171411] sm:text-5xl lg:text-7xl">
                L'atelier de fabrication au service des professionnels du bâtiment.
            </h1>

            <p class="mt-7 max-w-3xl text-lg leading-9 text-[#5f5146]">
                Architectes, maîtres d'œuvre, bureaux d'études, décorateurs, promoteurs et entrepreneurs : Maison216 est votre atelier de fabrication bois, aluminium et métal en Tunisie. Respect strict des plans d'exécution, devis chiffré sous 24h, délais contractualisés, SAV interne. Visite de l'atelier sur rendez-vous.
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
                <img src="{{ $heroImage }}" alt="Atelier de fabrication Maison216 pour professionnels" class="h-[360px] w-full rounded-[32px] object-cover sm:h-[460px] lg:h-[620px]">
            </div>
        </div>
    </div>
</section>

<section class="bg-white py-16 lg:py-24">
    <div class="container mx-auto px-4">
        <div class="grid gap-12 lg:grid-cols-[0.8fr_1.2fr]">
            <div>
                <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#a47834]">Notre engagement</div>
                <h2 class="font-display mt-3 text-3xl font-extrabold leading-tight tracking-[-0.04em] text-[#171411] sm:text-5xl">Un atelier de fabrication, pas un sous-traitant approximatif.</h2>
            </div>
            <div class="space-y-6 text-base leading-8 text-[#5f5146] sm:text-lg">
                <p>Maison216 est un atelier de fabrication intégré bois-aluminium-métal basé en Tunisie. Nous travaillons quotidiennement avec des architectes, des maîtres d'œuvre, des bureaux d'études, des décorateurs et des promoteurs sur des projets résidentiels et commerciaux.</p>
                <p>Notre engagement principal vis-à-vis des professionnels du bâtiment est simple : fabriquer exactement ce qui a été conçu, dans les délais convenus, avec une qualité d'exécution constante.</p>
                <p class="font-extrabold text-[#171411]">Pas d'improvisation sur les cotes. Pas de réinterprétation des plans. Pas de glissement de planning sans information préalable. Pas de SAV qui disparaît une fois la facture payée.</p>
            </div>
        </div>

        <div class="mt-12 grid gap-5 md:grid-cols-2 xl:grid-cols-4">
            @foreach($engagementPillars as $pillar)
                <article class="rounded-[30px] border border-[#eadfce] bg-[#fbf7ee] p-6">
                    <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-[#171411] text-xl text-[#d5b170]">
                        <i class="{{ $pillar['icon'] }}"></i>
                    </span>
                    <h3 class="font-display mt-6 text-xl font-extrabold text-[#171411]">{{ $pillar['title'] }}</h3>
                    <p class="mt-4 text-sm leading-7 text-[#5f5146]">{{ $pillar['copy'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-[#171411] py-16 text-white lg:py-24">
    <div class="container mx-auto px-4">
        <div class="grid gap-12 lg:grid-cols-[0.88fr_1.12fr] lg:items-start">
            <div>
                <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#d5b170]">Notre spécificité</div>
                <h2 class="font-display mt-3 text-3xl font-extrabold leading-tight tracking-[-0.04em] sm:text-5xl">Bois, aluminium et métal sous un même toit. C'est rare en Tunisie.</h2>
            </div>
            <div class="space-y-6 text-base leading-8 text-white/72 sm:text-lg">
                <p>La plupart des ateliers en Tunisie sont spécialisés sur un seul matériau. Vous voulez une cuisine, un portail et des fenêtres alu sur le même projet ? Trois prestataires, trois devis, trois plannings, trois interlocuteurs SAV différents. Et la charge de coordination retombe sur vous.</p>
                <p>Maison216 fabrique les trois métiers dans le même atelier, avec la même équipe de direction technique. Un seul devis pour l'ensemble du projet, un seul planning de fabrication, une seule équipe de pose, un seul SAV.</p>
                <p class="font-extrabold text-white">Pour un architecte ou un maître d'œuvre qui livre un projet résidentiel complet, c'est une économie de temps de coordination estimée à 30-40% sur la phase finition.</p>
            </div>
        </div>

        <div class="mt-12 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            @foreach(['Un seul devis pour cuisine + dressings + fenêtres alu + portail + pergola + garde-corps.', 'Un seul planning de fabrication aligné sur votre calendrier de chantier.', 'Une seule équipe de pose qui intervient dans l’ordre logique.', 'Un seul interlocuteur SAV pour l’ensemble des fabrications livrées.'] as $item)
                <div class="rounded-[26px] border border-white/10 bg-white/[0.06] p-5 text-sm font-semibold leading-7 text-white/84">
                    <i class="fa-solid fa-check mr-2 text-[#d5b170]"></i>{{ $item }}
                </div>
            @endforeach
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

<section class="bg-[#f7fbf6] py-16 lg:py-24">
    <div class="container mx-auto px-4">
        <div class="grid gap-12 lg:grid-cols-[0.82fr_1.18fr]">
            <div>
                <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#3f7a5f]">Architectes — collaboration technique</div>
                <h2 class="font-display mt-3 text-3xl font-extrabold leading-tight tracking-[-0.04em] text-[#171411] sm:text-5xl">Une relation atelier-architecte fondée sur la qualité d'exécution.</h2>
            </div>
            <div class="space-y-6 text-base leading-8 text-[#4e6257] sm:text-lg">
                <p>La collaboration entre un architecte et un atelier de fabrication se mesure en qualité d'exécution des plans, en respect des délais et en capacité de l'atelier à protéger l'image professionnelle de l'architecte vis-à-vis de son client.</p>
                <p>Notre approche avec les architectes est strictement technique. Nous fabriquons ce que vous avez conçu, selon vos plans d'exécution, dans les délais convenus avec votre client.</p>
            </div>
        </div>

        <div class="mt-12 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @foreach($architectServices as $service)
                <article class="rounded-[30px] border border-[#cfe1d2] bg-white p-6">
                    <h3 class="font-display text-xl font-extrabold text-[#171411]">{{ $service['title'] }}</h3>
                    <p class="mt-4 text-sm leading-7 text-[#4e6257]">{{ $service['copy'] }}</p>
                </article>
            @endforeach
        </div>

        <div class="mt-10 rounded-[34px] border border-[#bcd9c4] bg-white p-7 lg:p-9">
            <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#3f7a5f]">Notre engagement déontologique</div>
            <p class="mt-4 max-w-5xl text-base leading-8 text-[#4e6257]">Conformément aux règles d'indépendance professionnelle qui encadrent la profession d'architecte en Tunisie, notre relation avec les architectes inscrits à l'Ordre est strictement technique. <span class="font-extrabold text-[#171411]">Notre seule contrepartie : être l'atelier dont vous savez que la qualité d'exécution ne mettra jamais votre signature en risque.</span></p>
        </div>

        <div class="mt-10 grid gap-5 lg:grid-cols-4">
            @foreach($architectSteps as $step)
                <article class="rounded-[28px] border border-[#cfe1d2] bg-white p-6">
                    <div class="font-display text-5xl font-extrabold text-[#3f7a5f]/18">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                    <h3 class="font-display mt-5 text-xl font-extrabold text-[#171411]">{{ $step['title'] }}</h3>
                    <p class="mt-4 text-sm leading-7 text-[#4e6257]">{{ $step['copy'] }}</p>
                </article>
            @endforeach
        </div>

        <div class="mt-10 flex flex-col gap-3 sm:flex-row">
            <a href="#contact-professionnel" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#173b2b] px-7 py-4 text-sm font-extrabold text-white transition hover:bg-[#255d42]">
                Demander une visite de l'atelier
            </a>
            <a href="#contact-professionnel" class="inline-flex items-center justify-center gap-2 rounded-full border border-[#bcd9c4] bg-white px-7 py-4 text-sm font-extrabold text-[#173b2b] transition hover:border-[#173b2b]">
                Transmettre un projet à chiffrer
            </a>
        </div>
    </div>
</section>

<section class="bg-[#fff8ea] py-16 lg:py-24">
    <div class="container mx-auto px-4">
        <div class="grid gap-12 lg:grid-cols-[0.82fr_1.18fr]">
            <div>
                <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#a36d1f]">Décorateurs, designers, apporteurs d'affaires</div>
                <h2 class="font-display mt-3 text-3xl font-extrabold leading-tight tracking-[-0.04em] text-[#171411] sm:text-5xl">Une convention d'apport d'affaires claire et contractualisée.</h2>
            </div>
            <div class="space-y-6 text-base leading-8 text-[#674f2f] sm:text-lg">
                <p>Les décorateurs, designers d'espace, agences immobilières, apporteurs d'affaires et professionnels indépendants peuvent collaborer avec Maison216 dans le cadre d'une convention d'apport d'affaires clairement contractualisée.</p>
                <p>Nous établissons avec vous une relation commerciale transparente et formalisée, adaptée à votre activité et à votre volume d'apport.</p>
            </div>
        </div>

        <div class="mt-12 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @foreach($businessOffers as $offer)
                <article class="rounded-[30px] border border-[#efd8aa] bg-white p-6">
                    <h3 class="font-display text-xl font-extrabold text-[#171411]">{{ $offer['title'] }}</h3>
                    <p class="mt-4 text-sm leading-7 text-[#674f2f]">{{ $offer['copy'] }}</p>
                </article>
            @endforeach
        </div>

        <div class="mt-10 grid gap-5 lg:grid-cols-4">
            @foreach($businessSteps as $step)
                <article class="rounded-[28px] border border-[#efd8aa] bg-white p-6">
                    <div class="font-display text-5xl font-extrabold text-[#d5b170]/35">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                    <h3 class="font-display mt-5 text-xl font-extrabold text-[#171411]">{{ $step['title'] }}</h3>
                    <p class="mt-4 text-sm leading-7 text-[#674f2f]">{{ $step['copy'] }}</p>
                </article>
            @endforeach
        </div>

        <div class="mt-10 flex flex-col gap-3 sm:flex-row">
            <a href="#contact-professionnel" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#8e6322] px-7 py-4 text-sm font-extrabold text-white transition hover:bg-[#171411]">
                Demander la convention d'apport d'affaires
            </a>
            <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center gap-2 rounded-full border border-[#d8bc86] bg-white px-7 py-4 text-sm font-extrabold text-[#171411] transition hover:border-[#8e6322]">
                <i class="fa-brands fa-whatsapp"></i>
                WhatsApp dédié professionnels
            </a>
        </div>
    </div>
</section>

<section class="bg-[#f2f4f8] py-16 lg:py-24">
    <div class="container mx-auto px-4">
        <div class="grid gap-12 lg:grid-cols-[0.82fr_1.18fr]">
            <div>
                <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#52617a]">Promoteurs immobiliers</div>
                <h2 class="font-display mt-3 text-3xl font-extrabold leading-tight tracking-[-0.04em] text-[#171411] sm:text-5xl">Équipement de programmes résidentiels : un seul fournisseur pour tout.</h2>
            </div>
            <div class="space-y-6 text-base leading-8 text-[#4f5b6d] sm:text-lg">
                <p>Vous livrez des programmes résidentiels neufs et vous cherchez un fournisseur unique capable de prendre en charge l'ensemble de l'équipement des lots : cuisines, dressings, menuiseries aluminium, portails, garde-corps.</p>
                <p>Pour les promoteurs immobiliers, notre relation est commerciale et contractuelle, définie par un contrat-cadre adapté au volume du programme.</p>
            </div>
        </div>

        <div class="mt-12 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @foreach($promoterOffers as $offer)
                <article class="rounded-[30px] border border-[#d9dfeb] bg-white p-6">
                    <h3 class="font-display text-xl font-extrabold text-[#171411]">{{ $offer['title'] }}</h3>
                    <p class="mt-4 text-sm leading-7 text-[#4f5b6d]">{{ $offer['copy'] }}</p>
                </article>
            @endforeach
        </div>

        <div class="mt-10 flex flex-col gap-3 sm:flex-row">
            <a href="#contact-professionnel" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#26384f] px-7 py-4 text-sm font-extrabold text-white transition hover:bg-[#171411]">
                Demander un dossier promoteur
            </a>
            <a href="#contact-professionnel" class="inline-flex items-center justify-center gap-2 rounded-full border border-[#cbd4e1] bg-white px-7 py-4 text-sm font-extrabold text-[#26384f] transition hover:border-[#26384f]">
                Prendre rendez-vous avec le chef de projet
            </a>
        </div>
    </div>
</section>

<section class="bg-[#f7f1e7] py-16 lg:py-24">
    <div class="container mx-auto px-4">
        <div class="grid gap-12 lg:grid-cols-[0.82fr_1.18fr]">
            <div>
                <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#8e6322]">Entrepreneurs & bureaux d'études</div>
                <h2 class="font-display mt-3 text-3xl font-extrabold leading-tight tracking-[-0.04em] text-[#171411] sm:text-5xl">Sous-traitance menuiserie et métallerie : un partenaire technique fiable.</h2>
            </div>
            <div class="space-y-6 text-base leading-8 text-[#5f5146] sm:text-lg">
                <p>Vous êtes entrepreneur général sur des chantiers tous corps de métier ou bureau d'études techniques. Vous avez besoin d'un sous-traitant menuiserie et métallerie qui respecte les plans, les délais de chantier et les conditions de facturation B2B.</p>
                <p>Nous travaillons régulièrement comme sous-traitant spécialisé sur des lots menuiserie bois, menuiserie aluminium et métallerie.</p>
            </div>
        </div>

        <div class="mt-12 grid gap-5 md:grid-cols-2 xl:grid-cols-5">
            @foreach($contractorOffers as $offer)
                <article class="rounded-[30px] border border-[#eadfce] bg-white p-6">
                    <h3 class="font-display text-xl font-extrabold text-[#171411]">{{ $offer['title'] }}</h3>
                    <p class="mt-4 text-sm leading-7 text-[#5f5146]">{{ $offer['copy'] }}</p>
                </article>
            @endforeach
        </div>

        <div class="mt-10 flex flex-col gap-3 sm:flex-row">
            <a href="#contact-professionnel" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#171411] px-7 py-4 text-sm font-extrabold text-white transition hover:bg-[#8e6322]">
                Référencer Maison216 comme fournisseur
            </a>
            <a href="#contact-professionnel" class="inline-flex items-center justify-center gap-2 rounded-full border border-[#cdbb9f] bg-white px-7 py-4 text-sm font-extrabold text-[#171411] transition hover:border-[#8e6322]">
                Transmettre un appel d'offres ou un métré
            </a>
        </div>
    </div>
</section>

<section id="contact-professionnel" class="bg-white py-16 lg:py-24">
    <div class="container mx-auto px-4">
        <div class="grid gap-12 lg:grid-cols-[0.75fr_1.25fr] lg:items-start">
            <div>
                <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#a47834]">Prendre contact</div>
                <h2 class="font-display mt-3 text-3xl font-extrabold leading-tight tracking-[-0.04em] text-[#171411] sm:text-5xl">Présentez-vous. Nous revenons vers vous sous 24h.</h2>
                <p class="mt-5 text-base leading-8 text-[#5f5146]">Selon votre profil, nous vous transmettons les informations adaptées et nous fixons une visite de l'atelier dans les jours qui suivent.</p>
                <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="mt-7 inline-flex items-center gap-2 rounded-full border border-[#eadfce] bg-[#fbf7ee] px-5 py-3 text-sm font-extrabold text-[#171411]">
                    <i class="fa-brands fa-whatsapp text-[#a47834]"></i>
                    WhatsApp professionnels : +216 96 813 203
                </a>
            </div>

            <form action="{{ route('contact.submit') }}" method="post" class="rounded-[34px] border border-[#eadfce] bg-[#fbf7ee] p-6 shadow-[0_20px_60px_rgba(23,20,17,0.07)] lg:p-8">
                @csrf
                <input type="hidden" name="subject" value="Demande espace professionnels">
                <input type="hidden" name="message" value="Demande envoyée depuis la page Espace professionnels. Merci de traiter selon le profil professionnel sélectionné.">

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
                        <input type="tel" name="phone" required value="{{ old('phone') }}" placeholder="96 813 203" class="mt-2 w-full rounded-2xl border border-[#eadfce] bg-white px-4 py-3 text-sm focus:border-[#a47834] focus:ring-0">
                    </label>
                    <label class="block">
                        <span class="text-sm font-bold text-[#171411]">Email professionnel *</span>
                        <input type="email" name="email" required value="{{ old('email') }}" class="mt-2 w-full rounded-2xl border border-[#eadfce] bg-white px-4 py-3 text-sm focus:border-[#a47834] focus:ring-0">
                    </label>
                    <label class="block">
                        <span class="text-sm font-bold text-[#171411]">Localisation principale d'activité</span>
                        <input type="text" name="location" value="{{ old('location') }}" class="mt-2 w-full rounded-2xl border border-[#eadfce] bg-white px-4 py-3 text-sm focus:border-[#a47834] focus:ring-0">
                    </label>
                    <label class="block">
                        <span class="text-sm font-bold text-[#171411]">Projet en cours à chiffrer ?</span>
                        <select name="has_project" class="mt-2 w-full rounded-2xl border border-[#eadfce] bg-white px-4 py-3 text-sm focus:border-[#a47834] focus:ring-0">
                            <option value="">Sélectionner</option>
                            <option value="Oui" @selected(old('has_project') === 'Oui')>Oui</option>
                            <option value="Non" @selected(old('has_project') === 'Non')>Non</option>
                        </select>
                    </label>
                    <label class="block md:col-span-2">
                        <span class="text-sm font-bold text-[#171411]">Type de projets sur lesquels vous travaillez</span>
                        <textarea name="project_type" rows="4" class="mt-2 w-full rounded-2xl border border-[#eadfce] bg-white px-4 py-3 text-sm focus:border-[#a47834] focus:ring-0">{{ old('project_type') }}</textarea>
                    </label>
                </div>

                <button type="submit" class="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-full bg-[#171411] px-7 py-4 text-sm font-extrabold text-white transition hover:bg-[#a47834] sm:w-auto">
                    Envoyer ma demande
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>

                <p class="mt-5 text-sm leading-7 text-[#5f5146]">Selon votre profil professionnel, nous adaptons notre réponse : techniquement pour les architectes, commercialement pour les autres métiers. Toutes les informations échangées sont strictement confidentielles.</p>
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

<section class="bg-[#171411] py-16 text-white lg:py-20">
    <div class="container mx-auto px-4 text-center">
        <div class="mx-auto max-w-3xl">
            <h2 class="font-display text-3xl font-extrabold leading-tight tracking-[-0.04em] sm:text-5xl">Travaillons ensemble sur votre prochain projet.</h2>
            <p class="mt-5 text-lg leading-8 text-white/72">Selon votre profession, nous adaptons notre approche. Visitez notre atelier, ou transmettez-nous un projet à chiffrer.</p>
            <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
                <a href="#contact-professionnel" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#d5b170] px-8 py-4 text-sm font-extrabold text-[#171411] transition hover:bg-white">Prendre contact</a>
                <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center gap-2 rounded-full border border-white/15 px-8 py-4 text-sm font-extrabold text-white transition hover:bg-white hover:text-[#171411]">
                    <i class="fa-brands fa-whatsapp"></i>
                    WhatsApp professionnels
                </a>
            </div>
        </div>
    </div>
</section>

<section class="bg-[#fbf7ee] py-14 lg:py-16">
    <div class="container mx-auto px-4">
        <div class="grid gap-8 lg:grid-cols-2">
            <div>
                <div class="mb-6 text-xs font-extrabold uppercase tracking-[0.22em] text-[#a47834]">Nos silos de services</div>
                <div class="grid gap-4 sm:grid-cols-2">
                    @foreach($serviceLinks as $link)
                        <a href="{{ $link['href'] }}" class="rounded-[24px] border border-[#eadfce] bg-white p-5 font-display text-lg font-extrabold text-[#171411] transition hover:border-[#c7a36a]">{{ $link['title'] }}</a>
                    @endforeach
                </div>
            </div>
            <div>
                <div class="mb-6 text-xs font-extrabold uppercase tracking-[0.22em] text-[#a47834]">Pages projets utiles</div>
                <div class="grid gap-4 sm:grid-cols-2">
                    @foreach($projectLinks as $link)
                        <a href="{{ $link['href'] }}" class="rounded-[24px] border border-[#eadfce] bg-white p-5 font-display text-lg font-extrabold text-[#171411] transition hover:border-[#c7a36a]">{{ $link['title'] }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
