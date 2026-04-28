@extends('layouts.store')

@push('head')
<script type="application/ld+json">
{!! json_encode([
    '@' . 'context' => 'https://schema.org',
    '@type' => 'LocalBusiness',
    'name' => \App\Models\Setting::get('site.name', config('app.name')),
    'url' => url('/'),
    'logo' => \App\Models\Setting::get('ui.logo'),
    'description' => 'Atelier intégré bois, aluminium et métal en Tunisie pour cuisines, dressings, fenêtres, portails et projets d aménagement sur mesure.',
    'address' => [
        '@type' => 'PostalAddress',
        'addressCountry' => 'TN',
    ],
], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) !!}
</script>
@endpush

@section('content')
@php
    $wa = \App\Models\Setting::get('contact.whatsapp');
    $adminEmail = \App\Models\Setting::get('contact.admin_email', 'contact@maison216.tn');
    $whatsappUrl = $wa ? 'https://wa.me/' . preg_replace('/\D+/', '', (string) $wa) : route('contact');
    $devisUrl = url('/devis');

    $trustFacts = collect([
        ['icon' => 'fa-solid fa-industry', 'value' => 'Atelier intégré', 'label' => 'Bois, aluminium et métal sous le même toit'],
        ['icon' => 'fa-regular fa-clock', 'value' => '48h', 'label' => 'Objectif de retour pour les demandes complètes'],
        ['icon' => 'fa-solid fa-user-gear', 'value' => 'Pose & SAV', 'label' => 'Un interlocuteur jusqu à la fin du projet'],
        ['icon' => 'fa-solid fa-location-dot', 'value' => 'Tunisie', 'label' => 'Fabrication locale et projets coordonnés'],
    ]);

    $audiences = collect([
        [
            'icon' => 'fa-solid fa-house-chimney',
            'title' => 'Particuliers',
            'copy' => 'Vous construisez, rénovez ou aménagez votre maison ou votre appartement. Cuisine, dressings, fenêtres, portail, pergola : nous cadrons l ensemble de votre projet.',
            'cta' => 'Lancer mon projet',
            'href' => $devisUrl,
        ],
        [
            'icon' => 'fa-solid fa-drafting-compass',
            'title' => 'Architectes & décorateurs',
            'copy' => 'Vous concevez, nous fabriquons. Atelier intégré bois + aluminium + métal, respect des plans, finitions soignées et échanges techniques clairs.',
            'cta' => 'Découvrir le programme partenaire',
            'href' => '#partenaires',
        ],
        [
            'icon' => 'fa-regular fa-building',
            'title' => 'Promoteurs & professionnels',
            'copy' => 'Programmes neufs, cafés, restaurants, boutiques et bureaux. Interlocuteur unique, lots coordonnés et chiffrage exploitable.',
            'cta' => 'Demander un dossier pro',
            'href' => '#partenaires',
        ],
    ]);

    $crafts = collect([
        [
            'kicker' => 'Bois',
            'title' => 'Menuiserie bois',
            'copy' => 'Cuisines, dressings, placards, meubles sur mesure et ouvrages d ébénisterie. MDF laqué, mélaminé, bois massif, plaqué chêne et noyer.',
            'href' => url('/menuiserie-bois'),
            'cta' => 'Découvrir l atelier bois',
            'icon' => 'fa-solid fa-tree',
            'image' => 'assets/home/menuiserie-bois.webp',
            'imageAlt' => 'Atelier de menuiserie bois Maison 216',
        ],
        [
            'kicker' => 'Aluminium',
            'title' => 'Menuiserie aluminium',
            'copy' => 'Fenêtres, portes, garde-corps, volets roulants, brise-soleil et moustiquaires. Profilés propres, poses nettes, finitions durables.',
            'href' => url('/aluminium'),
            'cta' => 'Découvrir l atelier aluminium',
            'icon' => 'fa-solid fa-border-all',
            'image' => 'assets/home/menuiserie-aluminium.jpg',
            'imageAlt' => 'Menuiserie aluminium Maison 216',
        ],
        [
            'kicker' => 'Métal',
            'title' => 'Fabrication métallique',
            'copy' => 'Portails fer forgé, pergolas, escaliers, garde-corps et structures métalliques. Assemblages solides, finitions propres et pose maîtrisée.',
            'href' => url('/fer-metal'),
            'cta' => 'Découvrir l atelier métal',
            'icon' => 'fa-solid fa-fire-flame-curved',
            'image' => 'assets/home/fabrication-metallique.jpg',
            'imageAlt' => 'Fabrication métallique Maison 216',
        ],
        [
            'kicker' => 'Sur mesure',
            'title' => 'Aménagements sur mesure',
            'copy' => 'Cuisine, dressing, placard, meuble TV, bureau. Étude technique, plans selon projet, fabrication atelier, pose et SAV par notre équipe.',
            'href' => url('/sur-mesure'),
            'cta' => 'Voir nos aménagements',
            'icon' => 'fa-solid fa-ruler-combined',
            'image' => 'assets/home/amenagement-sur-mesure.jpg',
            'imageAlt' => 'Aménagement sur mesure Maison 216',
        ],
    ]);

    $projects = collect([
        ['title' => 'Agencement immobilier neuf', 'href' => url('/projets/agencement-immobilier-neuf'), 'copy' => 'Cuisine équipée, dressings, placards et fenêtres pour appartements et programmes neufs.', 'icon' => 'fa-regular fa-building'],
        ['title' => 'Agencement café & restaurant', 'href' => url('/projets/agencement-cafe-restaurant'), 'copy' => 'Comptoirs, mobilier, banquettes, vitrines et éléments cohérents avec votre identité.', 'icon' => 'fa-solid fa-mug-saucer'],
        ['title' => 'Agencement bureau entreprise', 'href' => url('/projets/agencement-bureau-entreprise'), 'copy' => 'Open space, salles de réunion, mobilier sur mesure, cloisons aluminium et bois.', 'icon' => 'fa-solid fa-briefcase'],
        ['title' => 'Agencement magasin', 'href' => url('/projets/agencement-magasin'), 'copy' => 'Vitrines, présentoirs, comptoirs, rangements et signalétique intérieure.', 'icon' => 'fa-solid fa-store'],
        ['title' => 'Aménagement villa & maison', 'href' => url('/projets/amenagement-villa-maison'), 'copy' => 'Cuisine, dressings, fenêtres alu, portail, pergola et escalier avec un seul atelier.', 'icon' => 'fa-solid fa-house'],
        ['title' => 'Aménagement extérieur', 'href' => url('/projets/amenagement-exterieur'), 'copy' => 'Pergolas, portails, garde-corps, brise-soleil, terrasses et ouvrages extérieurs.', 'icon' => 'fa-solid fa-seedling'],
    ]);

    $reasons = collect([
        ['title' => 'Atelier intégré bois + alu + métal', 'copy' => 'Trois métiers réunis dans un seul atelier. Un seul devis, un seul planning, un seul SAV pour votre projet d aménagement.'],
        ['title' => 'Fabrication en Tunisie', 'copy' => 'Une production locale, plus contrôlable et plus transparente. La visite de l atelier peut être organisée sur rendez-vous.'],
        ['title' => 'Étude, chiffrage et pose cadrés', 'copy' => 'De la prise de mesures à la pose finale : étude technique, options claires et chiffrage détaillé selon le projet.'],
        ['title' => 'Engagement de suivi et SAV', 'copy' => 'Délais annoncés par projet, contrôle à la pose et suivi après livraison pour éviter le flou post-chantier.'],
    ]);

    $realizations = collect([
        ['type' => 'Cuisine sur mesure', 'place' => 'Projet résidentiel', 'note' => 'Étude, fabrication bois et pose'],
        ['type' => 'Dressing & placards', 'place' => 'Villa privée', 'note' => 'Rangements intégrés et finitions propres'],
        ['type' => 'Fenêtres aluminium', 'place' => 'Appartement neuf', 'note' => 'Menuiserie aluminium et pose coordonnée'],
        ['type' => 'Portail métallique', 'place' => 'Maison individuelle', 'note' => 'Structure métal, finition et installation'],
        ['type' => 'Agencement restaurant', 'place' => 'Projet professionnel', 'note' => 'Mobilier, comptoir et éléments sur mesure'],
        ['type' => 'Pergola extérieure', 'place' => 'Espace extérieur', 'note' => 'Ouvrage extérieur adapté au lieu'],
    ]);

    $reviewProofs = collect([
        ['icon' => 'fa-regular fa-star', 'title' => 'Avis vérifiés', 'copy' => 'Les témoignages publiés doivent être reliés à un vrai projet, avec accord client et contexte clair.'],
        ['icon' => 'fa-solid fa-location-dot', 'title' => 'Lieu et type de projet', 'copy' => 'Chaque avis utile précise le type de réalisation et la zone d intervention pour rassurer les futurs clients.'],
        ['icon' => 'fa-solid fa-link', 'title' => 'Google Reviews à connecter', 'copy' => 'Le lien vers les avis Google devient la preuve externe à afficher dès que la fiche est prête.'],
    ]);

    $process = collect([
        ['title' => 'Consultation gratuite', 'copy' => 'Vous décrivez votre projet par WhatsApp, formulaire ou rendez-vous. Nous clarifions l intention, les contraintes et la prochaine étape.'],
        ['title' => 'Étude & devis détaillé', 'copy' => 'Visite technique si nécessaire, options de matériaux et chiffrage détaillé avec délai annoncé.'],
        ['title' => 'Fabrication en atelier', 'copy' => 'Validation, acompte, lancement de la fabrication et suivi du planning jusqu à la préparation de pose.'],
        ['title' => 'Livraison, pose & SAV', 'copy' => 'Pose par l équipe, vérification de conformité et suivi après installation en cas de besoin.'],
    ]);

    $faqs = collect([
        ['q' => 'Combien coûte une cuisine sur mesure chez Maison 216 ?', 'a' => 'Le tarif dépend des dimensions, des matériaux, des finitions, des accessoires et de l électroménager intégré. Nous préférons chiffrer après mesures plutôt que donner un prix générique trompeur.'],
        ['q' => 'Quel est le délai moyen de fabrication et de pose ?', 'a' => 'Le délai varie selon le projet : cuisine, dressing, aluminium ou métal. Il est annoncé clairement dans le devis après validation des dimensions et finitions.'],
        ['q' => 'Travaillez-vous partout en Tunisie ?', 'a' => 'Nous traitons les demandes en Tunisie avec une organisation adaptée au lieu, au volume du projet et aux contraintes de pose.'],
        ['q' => 'Peut-on visiter l atelier ?', 'a' => 'Oui, les visites peuvent être organisées sur rendez-vous pour les projets importants ou professionnels.'],
        ['q' => 'Comment se passe le paiement ?', 'a' => 'Les projets sur mesure fonctionnent généralement avec acompte à la commande puis solde selon avancement ou pose. Les modalités sont précisées dans le devis.'],
        ['q' => 'Quelle garantie sur les fabrications ?', 'a' => 'Nous distinguons la garantie atelier sur nos fabrications et la garantie fabricant sur les composants tiers. Le SAV est suivi par notre équipe.'],
        ['q' => 'Travaillez-vous avec architectes et promoteurs ?', 'a' => 'Oui. Nous pouvons intervenir sur plans, lots coordonnés, programmes neufs, commerces et bureaux avec un interlocuteur dédié.'],
        ['q' => 'Faites-vous aussi les petits projets ?', 'a' => 'Oui. Un placard, un meuble TV, une fenêtre ou une moustiquaire peuvent être traités avec le même sérieux qu un grand projet.'],
    ]);
@endphp

<section class="relative isolate overflow-hidden border-b border-[#eadfce] bg-[#f6f1e8]">
    <div class="absolute inset-0 -z-10 bg-[radial-gradient(circle_at_18%_20%,rgba(184,138,59,0.18),transparent_30%),radial-gradient(circle_at_82%_15%,rgba(23,20,17,0.08),transparent_28%)]"></div>
    <div class="container mx-auto px-4 py-16 lg:py-24">
        <div class="max-w-6xl">
            <div class="inline-flex items-center gap-2 rounded-full border border-[#d8c7af] bg-white/72 px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-[#8b6426]">
                <i class="fa-solid fa-industry"></i>
                Atelier intégré en Tunisie
            </div>

            <h1 class="font-display mt-7 max-w-5xl text-4xl font-extrabold leading-[0.98] tracking-[-0.04em] text-[#171411] sm:text-5xl lg:text-7xl">
                Cuisines, dressings, fenêtres, portails.
                <span class="block text-[#a47834]">Un seul atelier pour tout votre aménagement.</span>
            </h1>

            <p class="mt-6 max-w-3xl text-lg leading-8 text-[#53463c] lg:text-xl lg:leading-9">
                Bois, aluminium et métal fabriqués sur mesure dans notre atelier en Tunisie. Particuliers, architectes et promoteurs : un seul interlocuteur, du devis à la pose.
            </p>

            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                <a href="{{ $devisUrl }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#171411] px-7 py-4 text-sm font-extrabold text-white shadow-[0_20px_45px_rgba(23,20,17,0.18)] transition hover:bg-[#a47834]">
                    <i class="fa-regular fa-pen-to-square"></i>
                    Demander un devis gratuit
                </a>
                <a href="#realisations" class="inline-flex items-center justify-center gap-2 rounded-full border border-[#cdbb9f] bg-white/72 px-7 py-4 text-sm font-extrabold text-[#171411] transition hover:border-[#a47834] hover:bg-white">
                    <i class="fa-regular fa-images"></i>
                    Voir nos réalisations
                </a>
            </div>

            <div class="mt-8 flex flex-wrap gap-x-10 gap-y-3 text-sm font-bold text-[#4f4236]">
                @foreach(['Atelier visitable', 'Devis sous 48h', 'Pose incluse', 'Garantie atelier'] as $item)
                    <div class="inline-flex items-center gap-2">
                        <i class="fa-solid fa-check text-[#a47834]"></i>
                        {{ $item }}
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section class="border-b border-[#eadfce] bg-white">
    <div class="container mx-auto grid gap-0 px-4 py-6 sm:grid-cols-2 lg:grid-cols-4">
        @foreach($trustFacts as $fact)
            <div class="border-[#eadfce] py-5 lg:border-r lg:px-6 lg:last:border-r-0">
                <div class="flex items-start gap-4">
                    <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-[#f4ead8] text-[#a47834]">
                        <i class="{{ $fact['icon'] }}"></i>
                    </span>
                    <div>
                        <div class="font-display text-xl font-extrabold text-[#171411]">{{ $fact['value'] }}</div>
                        <div class="mt-1 text-sm leading-6 text-[#66584d]">{{ $fact['label'] }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

<section class="bg-[#fbf7f0] py-16 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-9 max-w-3xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Pour qui</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">Trois profils, une seule équipe.</h2>
        </div>

        <div class="grid gap-5 lg:grid-cols-3">
            @foreach($audiences as $audience)
                <article class="rounded-[32px] border border-[#eadfce] bg-white p-7 shadow-[0_18px_45px_rgba(23,20,17,0.05)]">
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

<section class="bg-white py-16 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-9 max-w-3xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Nos métiers</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">Trois métiers, un seul atelier.</h2>
            <p class="mt-4 text-lg leading-8 text-[#5f5146]">Nous fabriquons en interne ce qu un projet d aménagement exige : mobilier bois, menuiserie aluminium et ouvrages métalliques.</p>
        </div>

        <div class="grid gap-5 lg:grid-cols-2">
            @foreach($crafts as $craft)
                <a href="{{ $craft['href'] }}" class="group overflow-hidden rounded-[34px] border border-[#eadfce] bg-[#171411] text-white shadow-[0_20px_55px_rgba(23,20,17,0.10)]">
                    <div class="grid min-h-[360px] md:grid-cols-[1fr_1.08fr]">
                        <div class="relative min-h-[260px] overflow-hidden bg-cover bg-center transition duration-700 group-hover:scale-[1.02] md:min-h-full"
                             style="background-image: linear-gradient(180deg, rgba(23, 20, 17, 0.04), rgba(23, 20, 17, 0.52)), url('{{ asset($craft['image']) }}');">
                            <div class="relative z-10 flex h-full flex-col justify-between p-7">
                                <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl border border-white/20 bg-white/12 text-xl text-[#f0d49a] backdrop-blur">
                                    <i class="{{ $craft['icon'] }}"></i>
                                </span>
                                <div>
                                    <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#f0d49a]">{{ $craft['kicker'] }}</div>
                                    <div class="font-display mt-2 text-3xl font-extrabold text-white">{{ $craft['title'] }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col justify-between bg-[#fbf7f0] p-7 text-[#171411]">
                            <p class="text-base leading-8 text-[#5f5146]">{{ $craft['copy'] }}</p>
                            <div class="mt-7 inline-flex items-center gap-2 text-sm font-extrabold text-[#8e6322]">
                                {{ $craft['cta'] }}
                                <i class="fa-solid fa-arrow-right text-xs transition group-hover:translate-x-1"></i>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-[#f3ece2] py-16 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-9 max-w-3xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Types de projets</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">Vous avez un projet ? Nous l avons probablement déjà réalisé.</h2>
            <p class="mt-4 text-lg leading-8 text-[#5f5146]">Du logement neuf à équiper jusqu au café à agencer, nous prenons en charge des projets complets en Tunisie.</p>
        </div>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @foreach($projects as $project)
                <a href="{{ $project['href'] }}" class="group rounded-[32px] border border-[#eadfce] bg-white p-7 shadow-[0_18px_45px_rgba(23,20,17,0.05)] transition hover:-translate-y-1 hover:shadow-[0_28px_70px_rgba(23,20,17,0.10)]">
                    <div class="mb-7 flex h-16 w-16 items-center justify-center rounded-2xl bg-[#171411] text-2xl text-[#d5b170]">
                        <i class="{{ $project['icon'] }}"></i>
                    </div>
                    <h3 class="font-display text-2xl font-extrabold text-[#171411]">{{ $project['title'] }}</h3>
                    <p class="mt-4 text-base leading-8 text-[#5f5146]">{{ $project['copy'] }}</p>
                    <div class="mt-7 text-sm font-extrabold text-[#8e6322]">Voir les projets <i class="fa-solid fa-arrow-right ml-1 text-xs transition group-hover:translate-x-1"></i></div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-[#171411] py-16 text-white lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-10 max-w-3xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#d5b170]">Pourquoi Maison 216</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold sm:text-4xl">Pourquoi nos clients nous choisissent.</h2>
        </div>

        <div class="grid gap-4 lg:grid-cols-4">
            @foreach($reasons as $reason)
                <article class="rounded-[30px] border border-white/10 bg-white/6 p-6">
                    <div class="font-display text-5xl font-extrabold text-white/12">0{{ $loop->iteration }}</div>
                    <h3 class="font-display mt-5 text-xl font-extrabold text-white">{{ $reason['title'] }}</h3>
                    <p class="mt-4 text-sm leading-7 text-white/72">{{ $reason['copy'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section id="realisations" class="bg-white py-16 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-9 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-3xl">
                <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Réalisations</div>
                <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">Nos dernières réalisations.</h2>
                <p class="mt-4 text-lg leading-8 text-[#5f5146]">Des projets concrets livrés en Tunisie. Cuisines, dressings, pergolas, agencements complets.</p>
            </div>
            <a href="{{ url('/projets') }}" class="text-sm font-extrabold text-[#8e6322]">Voir toutes nos réalisations</a>
        </div>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @foreach($realizations as $realization)
                <article class="group relative min-h-[310px] overflow-hidden rounded-[34px] bg-[#171411] p-6 text-white shadow-[0_20px_55px_rgba(23,20,17,0.10)]">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_28%_18%,rgba(213,177,112,0.35),transparent_30%),linear-gradient(145deg,#33281f,#171411)] transition duration-500 group-hover:scale-105"></div>
                    <div class="relative z-10 flex h-full flex-col justify-between">
                        <div class="inline-flex w-max rounded-full border border-white/15 bg-white/8 px-3 py-1 text-xs font-bold text-[#e7c98d]">{{ $realization['place'] }}</div>
                        <div>
                            <h3 class="font-display text-2xl font-extrabold">{{ $realization['type'] }}</h3>
                            <p class="mt-2 text-sm text-white/72">{{ $realization['note'] }}</p>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-[#fbf7f0] py-16 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-9 max-w-3xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Avis clients</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">Des avis vérifiables, pas des slogans.</h2>
            <p class="mt-4 text-lg leading-8 text-[#5f5146]">Chaque retour client publié doit rester utile : type de projet, zone d intervention, détail concret et accord du client.</p>
        </div>

        <div class="grid gap-5 lg:grid-cols-3">
            @foreach($reviewProofs as $proof)
                <article class="rounded-[32px] border border-[#eadfce] bg-white p-7">
                    <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-[#171411] text-[#d5b170]">
                        <i class="{{ $proof['icon'] }}"></i>
                    </div>
                    <h3 class="font-display mt-6 text-xl font-extrabold text-[#171411]">{{ $proof['title'] }}</h3>
                    <p class="mt-4 text-base leading-8 text-[#5f5146]">{{ $proof['copy'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-white py-16 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-10 max-w-3xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Process</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">Votre projet en 4 étapes.</h2>
        </div>

        <div class="grid gap-5 lg:grid-cols-4">
            @foreach($process as $step)
                <article class="rounded-[30px] border border-[#eadfce] bg-[#fbf7f0] p-6">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-[#171411] font-display text-lg font-extrabold text-[#d5b170]">{{ $loop->iteration }}</div>
                    <h3 class="font-display mt-6 text-xl font-extrabold text-[#171411]">{{ $step['title'] }}</h3>
                    <p class="mt-4 text-sm leading-7 text-[#5f5146]">{{ $step['copy'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section id="partenaires" class="bg-[#d5b170]">
    <div class="container mx-auto flex flex-col gap-5 px-4 py-8 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <div class="text-sm font-extrabold uppercase tracking-[0.18em] text-[#4b3618]">Architecte, décorateur, promoteur, entrepreneur ?</div>
            <p class="mt-2 text-lg font-bold text-[#171411]">Découvrez notre programme partenaire et nos conditions dédiées aux professionnels.</p>
        </div>
        <a href="{{ $devisUrl }}" class="inline-flex items-center justify-center rounded-full bg-[#171411] px-6 py-4 text-sm font-extrabold text-white">Devenir partenaire</a>
    </div>
</section>

<section id="faq" class="bg-[#fbf7f0] py-16 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-9 max-w-3xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">FAQ</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">Questions fréquentes.</h2>
        </div>

        <div class="mx-auto max-w-4xl divide-y divide-[#eadfce] rounded-[34px] border border-[#eadfce] bg-white p-2">
            @foreach($faqs as $faq)
                <details class="group rounded-[26px] px-5 py-4 open:bg-[#fbf7f0]">
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
        <h2 class="font-display text-3xl font-extrabold sm:text-5xl">Prêt à lancer votre projet ?</h2>
        <p class="mx-auto mt-4 max-w-2xl text-lg leading-8 text-white/72">Recevez un devis gratuit et détaillé. Vous pouvez passer par le formulaire ou nous écrire directement sur WhatsApp.</p>
        <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
            <a href="{{ $devisUrl }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-white px-7 py-4 text-sm font-extrabold text-[#171411]">
                <i class="fa-regular fa-pen-to-square"></i>
                Demander un devis
            </a>
            <a href="{{ $whatsappUrl }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-white/15 px-7 py-4 text-sm font-extrabold text-white">
                <i class="fa-brands fa-whatsapp"></i>
                WhatsApp direct
            </a>
        </div>
    </div>
</section>
@endsection
