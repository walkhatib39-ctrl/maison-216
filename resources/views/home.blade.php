@extends('layouts.store')

@push('head')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Organization',
    'name' => \App\Models\Setting::get('site.name', config('app.name')),
    'url' => url('/'),
    'logo' => \App\Models\Setting::get('ui.logo'),
    'description' => 'Fabricant et vendeur de meubles en Tunisie. Achetez par élément, composez votre pièce ou demandez un projet sur mesure.',
    'address' => [
        '@type' => 'PostalAddress',
        'addressCountry' => 'TN',
    ],
], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) !!}
</script>
@endpush

@section('content')
@php
    $contactUrl = route('contact');
    $categoriesUrl = route('categories.index');
@endphp

<section class="relative overflow-hidden bg-[linear-gradient(135deg,#171512_0%,#22201d_45%,#3f3629_100%)] text-white">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(182,147,82,0.32),transparent_28%),radial-gradient(circle_at_bottom_right,rgba(255,255,255,0.12),transparent_22%)]"></div>
    <div class="container relative mx-auto grid min-h-[78vh] gap-12 px-4 py-14 lg:grid-cols-[1.05fr_0.95fr] lg:items-center lg:py-20">
        <div class="max-w-3xl">
            <div class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-2 text-sm font-medium text-white/90 backdrop-blur">
                <span class="h-2 w-2 rounded-full bg-primary-400"></span>
                Atelier réel en Tunisie: bois, aluminium, fer
            </div>

            <h1 class="font-editorial mt-6 max-w-4xl text-4xl font-black leading-[0.95] sm:text-5xl lg:text-7xl">
                Composez votre intérieur,
                <span class="text-primary-300">module par module</span>,
                ou lancez votre projet sur mesure.
            </h1>

            <p class="mt-6 max-w-2xl text-lg leading-8 text-white/78 sm:text-xl">
                Maison 216 ne se limite pas à un catalogue classique. Vous pouvez acheter un meuble précis,
                construire une pièce cohérente, ou nous confier une fabrication complète adaptée à votre espace.
            </p>

            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                <a href="#composer" class="inline-flex items-center justify-center gap-2 rounded-full bg-primary-500 px-6 py-4 text-base font-semibold text-white transition hover:bg-primary-400">
                    Composer une pièce
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5-5 5M6 12h12" />
                    </svg>
                </a>
                <a href="#univers" class="inline-flex items-center justify-center gap-2 rounded-full border border-white/20 bg-white/10 px-6 py-4 text-base font-semibold text-white transition hover:bg-white/15">
                    Découvrir nos univers
                </a>
                <a href="#sur-mesure" class="inline-flex items-center justify-center gap-2 rounded-full border border-white/20 px-6 py-4 text-base font-semibold text-white transition hover:bg-white/10">
                    Projet sur mesure
                </a>
            </div>

            <div class="mt-10 grid gap-4 sm:grid-cols-3">
                @foreach($trustHighlights as $highlight)
                    <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-4 text-sm font-medium text-white/85 backdrop-blur">
                        {{ $highlight }}
                    </div>
                @endforeach
            </div>
        </div>

        <div class="relative">
            <div class="absolute -left-6 top-8 hidden h-24 w-24 rounded-full bg-primary-400/25 blur-3xl lg:block"></div>
            <div class="absolute right-0 top-0 hidden h-32 w-32 rounded-full bg-white/10 blur-3xl lg:block"></div>

            <div class="grid gap-4 md:grid-cols-2">
                <article class="md:col-span-2 overflow-hidden rounded-[32px] border border-white/10 bg-white/8 shadow-2xl backdrop-blur">
                    <div class="grid gap-0 md:grid-cols-[1fr_1.15fr]">
                        <div class="flex flex-col justify-between p-6 md:p-8">
                            <div>
                                <div class="text-sm font-semibold uppercase tracking-[0.18em] text-primary-300">Parcours signature</div>
                <h2 class="font-editorial mt-3 text-3xl font-bold leading-tight">Une expérience plus claire que le catalogue meuble classique.</h2>
                                <p class="mt-4 text-sm leading-7 text-white/72">
                                    Vous entrez par la pièce, le type de meuble ou le projet. Pas par une liste infinie de références sans logique.
                                </p>
                            </div>
                            <div class="mt-6 grid gap-3 sm:grid-cols-3">
                                <div class="rounded-2xl bg-black/15 px-4 py-3">
                                    <div class="text-xs uppercase tracking-[0.16em] text-white/55">Mode 1</div>
                                    <div class="mt-1 font-semibold">Acheter vite</div>
                                </div>
                                <div class="rounded-2xl bg-black/15 px-4 py-3">
                                    <div class="text-xs uppercase tracking-[0.16em] text-white/55">Mode 2</div>
                                    <div class="mt-1 font-semibold">Composer</div>
                                </div>
                                <div class="rounded-2xl bg-black/15 px-4 py-3">
                                    <div class="text-xs uppercase tracking-[0.16em] text-white/55">Mode 3</div>
                                    <div class="mt-1 font-semibold">Sur mesure</div>
                                </div>
                            </div>
                        </div>
                        <div class="min-h-[320px] bg-[linear-gradient(145deg,rgba(255,255,255,0.09),rgba(255,255,255,0.02)),url('https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?q=80&w=1800&auto=format&fit=crop')] bg-cover bg-center"></div>
                    </div>
                </article>

                <article class="rounded-[28px] border border-white/10 bg-white/8 p-6 backdrop-blur">
                    <div class="text-sm font-semibold uppercase tracking-[0.16em] text-primary-300">Atelier</div>
                    <h3 class="mt-2 text-2xl font-bold">Fabrication locale</h3>
                    <p class="mt-3 text-sm leading-7 text-white/72">Une offre construite autour de vrais savoir-faire, pas uniquement d’un import catalogue.</p>
                </article>
                <article class="rounded-[28px] border border-white/10 bg-white/8 p-6 backdrop-blur">
                    <div class="text-sm font-semibold uppercase tracking-[0.16em] text-primary-300">Orientation</div>
                    <h3 class="mt-2 text-2xl font-bold">Par intention</h3>
                    <p class="mt-3 text-sm leading-7 text-white/72">Découvrir, composer, demander un devis: le site oriente clairement au lieu d’encombrer.</p>
                </article>
            </div>
        </div>
    </div>
</section>

<section class="bg-white py-12 lg:py-16">
    <div class="container mx-auto px-4">
        <div class="grid gap-5 md:grid-cols-3">
            <article class="rounded-[28px] border border-dark-100 bg-[#f7f2e8] p-6 shadow-sm">
                <div class="text-sm font-semibold uppercase tracking-[0.16em] text-primary-700">1. Acheter vite</div>
                <h2 class="font-editorial mt-3 text-2xl font-bold text-dark-900">Choisir un meuble précis</h2>
                <p class="mt-3 text-base leading-7 text-dark-600">Pour le client qui sait déjà ce qu’il cherche: lit, commode, dressing, meuble TV, table, etc.</p>
                <a href="{{ $categoriesUrl }}" class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-primary-700 hover:text-primary-800">
                    Voir les catégories
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5-5 5M6 12h12" />
                    </svg>
                </a>
            </article>

            <article class="rounded-[28px] border border-dark-100 bg-dark-900 p-6 text-white shadow-sm">
                <div class="text-sm font-semibold uppercase tracking-[0.16em] text-primary-300">2. Composer</div>
                <h2 class="font-editorial mt-3 text-2xl font-bold">Construire une pièce cohérente</h2>
                <p class="mt-3 text-base leading-7 text-white/72">Entrer par l’univers puis choisir les bons modules: chambre, salon, cuisine, dressing, bureau.</p>
                <a href="#composer" class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-primary-300 hover:text-primary-200">
                    Voir les parcours
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5-5 5M6 12h12" />
                    </svg>
                </a>
            </article>

            <article class="rounded-[28px] border border-dark-100 bg-[#eef4f0] p-6 shadow-sm">
                <div class="text-sm font-semibold uppercase tracking-[0.16em] text-emerald-700">3. Sur mesure</div>
                <h2 class="font-editorial mt-3 text-2xl font-bold text-dark-900">Lancer un vrai projet</h2>
                <p class="mt-3 text-base leading-7 text-dark-600">Cuisine, aluminium, ferronnerie, dressing, mobilier spécifique: on bascule sur un tunnel de devis clair.</p>
                <a href="#sur-mesure" class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-emerald-700 hover:text-emerald-800">
                    Demander une étude
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5-5 5M6 12h12" />
                    </svg>
                </a>
            </article>
        </div>
    </div>
</section>

<section id="univers" class="bg-[#faf8f3] py-14 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-10 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-3xl">
                <div class="text-sm font-semibold uppercase tracking-[0.18em] text-primary-700">Univers</div>
                <h2 class="mt-2 text-3xl font-black text-dark-900 sm:text-4xl">Entrer par la pièce pour comprendre l’offre en 10 secondes.</h2>
                <p class="mt-3 text-lg leading-8 text-dark-600">Chaque univers devient un hub de découverte, de composition et de conversion, au lieu d’une simple page catégorie plate.</p>
            </div>
            <a href="{{ $categoriesUrl }}" class="inline-flex items-center gap-2 text-sm font-semibold text-dark-700 hover:text-primary-700">
                Explorer tout le catalogue
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5-5 5M6 12h12" />
                </svg>
            </a>
        </div>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @foreach($homeRooms as $index => $room)
                <a href="{{ $room['href'] }}" class="group overflow-hidden rounded-[30px] border border-dark-100 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-2xl">
                    <div class="relative aspect-[5/3] overflow-hidden bg-dark-100">
                        @if(!empty($room['image']))
                            <img src="{{ \Illuminate\Support\Str::startsWith($room['image'], ['http://', 'https://']) ? $room['image'] : asset($room['image']) }}" alt="{{ $room['name'] }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                        @else
                            <div class="flex h-full w-full items-center justify-center bg-[linear-gradient(135deg,#f7f2e8,#ece5d8)] text-6xl font-black text-dark-300">{{ strtoupper(mb_substr($room['name'], 0, 1)) }}</div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-dark-950/70 to-transparent"></div>
                        <div class="absolute left-5 top-5 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-dark-800">{{ $room['count'] }} produits</div>
                    </div>
                    <div class="space-y-4 p-6">
                        <div>
                            <h3 class="text-2xl font-bold text-dark-900">{{ $room['name'] }}</h3>
                            <p class="mt-2 text-base leading-7 text-dark-600">{{ $room['tagline'] }}</p>
                        </div>
                        @if(collect($room['subitems'])->isNotEmpty())
                            <div class="flex flex-wrap gap-2">
                                @foreach(collect($room['subitems'])->take(4) as $item)
                                    <span class="rounded-full bg-dark-50 px-3 py-1 text-xs font-medium text-dark-700 ring-1 ring-dark-100">{{ $item }}</span>
                                @endforeach
                            </div>
                        @endif
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-semibold text-primary-700">Voir l’univers</span>
                            <svg class="h-5 w-5 text-primary-700 transition group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5-5 5M6 12h12" />
                            </svg>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section id="composer" class="bg-white py-14 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-10 max-w-3xl">
            <div class="text-sm font-semibold uppercase tracking-[0.18em] text-primary-700">Composer</div>
            <h2 class="mt-2 text-3xl font-black text-dark-900 sm:text-4xl">Planifiez votre pièce en quelques choix lisibles.</h2>
            <p class="mt-3 text-lg leading-8 text-dark-600">
                Le builder final viendra ensuite. Cette couche pose déjà les bonnes entrées: commencer par un type de meuble cohérent, pas par un chaos de références.
            </p>
        </div>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @foreach($composerEntries as $entry)
                <a href="{{ $entry['href'] }}" class="group rounded-[28px] border border-dark-100 bg-[#f8f7f2] p-6 shadow-sm transition hover:-translate-y-1 hover:border-primary-300 hover:bg-white hover:shadow-xl">
                    <div class="flex items-center justify-between gap-3">
                        <div class="text-xs font-semibold uppercase tracking-[0.18em] text-primary-700">{{ $entry['eyebrow'] }}</div>
                        <span class="rounded-full bg-white px-3 py-1 text-xs font-semibold text-dark-700 ring-1 ring-dark-100">{{ $entry['badge'] }}</span>
                    </div>
                    <h3 class="mt-4 text-2xl font-bold text-dark-900">{{ $entry['name'] }}</h3>
                    <p class="mt-3 text-base leading-7 text-dark-600">{{ $entry['description'] }}</p>
                    <div class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-dark-900 group-hover:text-primary-700">
                        Commencer
                        <svg class="h-4 w-4 transition group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5-5 5M6 12h12" />
                        </svg>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

@if($featuredCollections->isNotEmpty())
<section class="bg-dark-950 py-14 text-white lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-10 max-w-3xl">
            <div class="text-sm font-semibold uppercase tracking-[0.18em] text-primary-300">Collections</div>
            <h2 class="mt-2 text-3xl font-black sm:text-4xl">Des lignes esthétiques lisibles, pas juste des produits isolés.</h2>
            <p class="mt-3 text-lg leading-8 text-white/72">
                Les collections serviront à vendre un style complet, puis à faire descendre le visiteur vers la composition ou le module individuel.
            </p>
        </div>

        <div class="grid gap-5 lg:grid-cols-3">
            @foreach($featuredCollections as $collection)
                <a href="{{ $collection['href'] }}" class="rounded-[30px] border border-white/10 bg-white/5 p-6 transition hover:bg-white/10">
                    <div class="text-xs font-semibold uppercase tracking-[0.18em] text-primary-300">{{ $collection['eyebrow'] }}</div>
                    <h3 class="mt-3 text-3xl font-bold">{{ $collection['name'] }}</h3>
                    @if(!empty($collection['family']))
                        <p class="mt-3 text-sm font-medium text-white/55">{{ $collection['family'] }}</p>
                    @endif
                    <p class="mt-4 text-base leading-7 text-white/72">{{ $collection['description'] }}</p>
                    <div class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-white">
                        Explorer la collection
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5-5 5M6 12h12" />
                        </svg>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="bg-[#faf8f3] py-14 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-10 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-3xl">
                <div class="text-sm font-semibold uppercase tracking-[0.18em] text-primary-700">Pièces prêtes</div>
                <h2 class="mt-2 text-3xl font-black text-dark-900 sm:text-4xl">Toujours vendre vite en parallèle du futur builder.</h2>
                <p class="mt-3 text-lg leading-8 text-dark-600">
                    La migration ne doit pas casser le chiffre. On garde des produits prêts à convertir immédiatement pendant qu’on construit les parcours plus avancés.
                </p>
            </div>
            <a href="{{ route('search') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-dark-700 hover:text-primary-700">
                Voir tous les produits
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5-5 5M6 12h12" />
                </svg>
            </a>
        </div>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @foreach($featuredProducts as $product)
                <article class="overflow-hidden rounded-[30px] border border-dark-100 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-2xl">
                    <a href="{{ route('product.show', $product->slug) }}" class="block aspect-[4/3] overflow-hidden bg-dark-100">
                        @if($product->main_image)
                            <img src="{{ asset($product->main_image) }}" alt="{{ $product->title }}" class="h-full w-full object-cover transition duration-500 hover:scale-105">
                        @else
                            <div class="flex h-full w-full items-center justify-center bg-[linear-gradient(135deg,#f7f2e8,#ece5d8)] text-5xl font-black text-dark-300">{{ strtoupper(mb_substr($product->title, 0, 1)) }}</div>
                        @endif
                    </a>
                    <div class="space-y-4 p-6">
                        @if($product->category)
                            <div class="text-xs font-semibold uppercase tracking-[0.16em] text-primary-700">{{ $product->category->name }}</div>
                        @endif
                        <h3 class="text-xl font-bold text-dark-900 line-clamp-2">{{ $product->title }}</h3>
                        <div class="flex items-end justify-between gap-4">
                            <div>
                                <div class="text-sm text-dark-500">Prix</div>
                                <div class="text-2xl font-black text-primary-700">{{ $product->price_display }}</div>
                            </div>
                            <a href="{{ route('product.show', $product->slug) }}" class="inline-flex items-center gap-2 rounded-full bg-dark-900 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-700">
                                Voir
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section id="atelier" class="bg-white py-14 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-10 max-w-3xl">
            <div class="text-sm font-semibold uppercase tracking-[0.18em] text-primary-700">Ateliers</div>
            <h2 class="mt-2 text-3xl font-black text-dark-900 sm:text-4xl">La différence n’est pas seulement visuelle. Elle est industrielle.</h2>
            <p class="mt-3 text-lg leading-8 text-dark-600">
                Maison 216 doit montrer qu’elle sait fabriquer, adapter, poser et accompagner. C’est ce qui justifie une expérience plus ambitieuse que le simple drop de fiches produits.
            </p>
        </div>

        <div class="grid gap-5 lg:grid-cols-3">
            @foreach($atelierCapabilities as $capability)
                <article class="rounded-[30px] border border-dark-100 bg-[#f8f7f2] p-6 shadow-sm">
                    <div class="text-sm font-semibold uppercase tracking-[0.16em] text-primary-700">Savoir-faire</div>
                    <h3 class="mt-3 text-2xl font-bold text-dark-900">{{ $capability['title'] }}</h3>
                    <p class="mt-4 text-base leading-7 text-dark-600">{{ $capability['copy'] }}</p>
                </article>
            @endforeach
        </div>

        <div class="mt-8 grid gap-4 rounded-[32px] border border-dark-100 bg-dark-900 p-6 text-white lg:grid-cols-[1.1fr_0.9fr] lg:p-8">
            <div>
                <div class="text-sm font-semibold uppercase tracking-[0.18em] text-primary-300">Process</div>
                <h3 class="mt-3 text-3xl font-black">Un tunnel plus crédible pour vendre plus.</h3>
                <p class="mt-4 max-w-2xl text-base leading-8 text-white/72">
                    Diagnostic besoin, proposition claire, validation des dimensions, puis fabrication ou commande. Le site doit vendre, mais aussi rassurer sur l’exécution réelle.
                </p>
            </div>
            <div class="grid gap-3 sm:grid-cols-2">
                <div class="rounded-2xl bg-white/5 px-4 py-4 text-sm font-medium text-white/85">Échange rapide par WhatsApp</div>
                <div class="rounded-2xl bg-white/5 px-4 py-4 text-sm font-medium text-white/85">Étude dimensions et finitions</div>
                <div class="rounded-2xl bg-white/5 px-4 py-4 text-sm font-medium text-white/85">Livraison et installation selon besoin</div>
                <div class="rounded-2xl bg-white/5 px-4 py-4 text-sm font-medium text-white/85">Passage simple du standard au sur mesure</div>
            </div>
        </div>
    </div>
</section>

<section id="sur-mesure" class="bg-[linear-gradient(135deg,#171512_0%,#22201d_45%,#3f3629_100%)] py-16 text-white lg:py-24">
    <div class="container mx-auto grid gap-10 px-4 lg:grid-cols-[1fr_420px] lg:items-center">
        <div class="max-w-3xl">
            <div class="text-sm font-semibold uppercase tracking-[0.18em] text-primary-300">Sur mesure</div>
            <h2 class="mt-3 text-4xl font-black leading-tight sm:text-5xl">Quand le projet dépasse le catalogue, le site doit l’assumer au lieu de le cacher.</h2>
            <p class="mt-5 text-lg leading-8 text-white/72">
                Cuisine, dressing, aluminium, ferronnerie, mobilier spécifique: on ne force pas un faux panier. On oriente vers un devis clair, rapide et crédible.
            </p>
            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                <a href="{{ $contactUrl }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-primary-500 px-6 py-4 text-base font-semibold text-white hover:bg-primary-400">
                    Demander un devis
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5-5 5M6 12h12" />
                    </svg>
                </a>
                <a href="{{ $categoriesUrl }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-white/20 px-6 py-4 text-base font-semibold text-white hover:bg-white/10">
                    Continuer vers le catalogue
                </a>
            </div>
        </div>

        <div class="rounded-[34px] border border-white/10 bg-white/8 p-6 backdrop-blur">
            <div class="text-sm font-semibold uppercase tracking-[0.18em] text-primary-300">Préparer le futur funnel</div>
            <div class="mt-5 space-y-4">
                <div class="rounded-2xl bg-black/15 px-4 py-4">
                    <div class="font-semibold">Cuisine</div>
                    <div class="mt-1 text-sm text-white/70">Modules, implantation, finitions, devis.</div>
                </div>
                <div class="rounded-2xl bg-black/15 px-4 py-4">
                    <div class="font-semibold">Dressing & rangement</div>
                    <div class="mt-1 text-sm text-white/70">Mesures, portes, accessoires, optimisation de l’espace.</div>
                </div>
                <div class="rounded-2xl bg-black/15 px-4 py-4">
                    <div class="font-semibold">Aluminium & fer</div>
                    <div class="mt-1 text-sm text-white/70">Portes, fenêtres, garde-corps, structures et chantiers techniques.</div>
                </div>
            </div>
        </div>
    </div>
</section>

@if($latest->isNotEmpty())
<section class="bg-white py-14 lg:py-20">
    <div class="container mx-auto px-4">
        <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <div class="text-sm font-semibold uppercase tracking-[0.18em] text-primary-700">Dernières arrivées</div>
                <h2 class="mt-2 text-3xl font-black text-dark-900 sm:text-4xl">Ce qui vient d’entrer au catalogue</h2>
            </div>
            <a href="{{ route('search') }}" class="text-sm font-semibold text-dark-700 hover:text-primary-700">Voir plus</a>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach($latest as $product)
                <a href="{{ route('product.show', $product->slug) }}" class="group overflow-hidden rounded-[26px] border border-dark-100 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                    <div class="aspect-square overflow-hidden bg-dark-100">
                        @if($product->main_image)
                            <img src="{{ asset($product->main_image) }}" alt="{{ $product->title }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                        @endif
                    </div>
                    <div class="space-y-2 p-4">
                        <div class="text-xs font-semibold uppercase tracking-[0.16em] text-primary-700">{{ $product->category?->name ?? 'Produit' }}</div>
                        <div class="line-clamp-2 font-semibold text-dark-900">{{ $product->title }}</div>
                        <div class="text-lg font-bold text-primary-700">{{ $product->price_display }}</div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
