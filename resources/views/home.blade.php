@extends('layouts.store')

@push('head')
<script type="application/ld+json">
{!! json_encode([
    '@' . 'context' => 'https://schema.org',
    '@type' => 'Organization',
    'name' => \App\Models\Setting::get('site.name', config('app.name')),
    'url' => url('/'),
    'logo' => \App\Models\Setting::get('ui.logo'),
    'description' => 'Maison 216 vend des meubles en Tunisie, accompagne la composition de pieces et traite les projets sur mesure en bois, aluminium et fer.',
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
    $searchUrl = route('search');
    $imageUrl = fn (?string $path) => $path
        ? (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '/']) ? $path : asset($path))
        : null;

    $entryModes = collect([
        [
            'label' => '01',
            'eyebrow' => 'Acheter vite',
            'title' => 'Trouver un meuble précis',
            'copy' => 'Vous savez déjà ce qu’il vous faut ? Accédez directement aux lits, armoires, tables, salons, bureaux et rangements les plus recherchés.',
            'href' => $categoriesUrl,
            'cta' => 'Voir le catalogue',
            'tone' => 'bg-white',
        ],
        [
            'label' => '02',
            'eyebrow' => 'Composer',
            'title' => 'Meubler une pièce complète',
            'copy' => 'Partez d’une chambre, d’un salon ou d’un espace rangement, puis découvrez les meubles qui fonctionnent bien ensemble.',
            'href' => '#composer',
            'cta' => 'Commencer par une pièce',
            'tone' => 'bg-[#171411] text-white',
        ],
        [
            'label' => '03',
            'eyebrow' => 'Sur mesure',
            'title' => 'Confier un projet à l’atelier',
            'copy' => 'Cuisine, dressing, aluminium, ferronnerie ou besoin spécifique : racontez-nous votre projet et recevez une réponse claire.',
            'href' => '#sur-mesure',
            'cta' => 'Demander une étude',
            'tone' => 'bg-[#efe2cb]',
        ],
    ]);

    $projectSteps = collect([
        'Choisir la pièce ou le besoin principal',
        'Sélectionner les modules ou le type de meuble',
        'Finaliser par achat direct ou demande de devis',
    ]);

    $trustRibbon = collect([
        ['icon' => 'fa-solid fa-truck-fast', 'label' => 'Livraison à domicile'],
        ['icon' => 'fa-solid fa-hand-holding-dollar', 'label' => 'Paiement à la livraison'],
        ['icon' => 'fa-solid fa-medal', 'label' => 'Made in Tunisia'],
    ]);

@endphp

<section class="border-b border-[#eadfce] bg-[#f6f1e8]">
    <div class="container mx-auto px-4 py-10 sm:py-12 lg:py-16">
        <div class="max-w-4xl">
            <h1 class="font-display max-w-4xl text-3xl font-bold leading-[1.04] text-[#171411] sm:text-4xl lg:text-6xl">
                Achetez le bon meuble.
                <span class="text-[#a47834]">Composez la bonne pièce.</span>
                Lancez le bon projet.
            </h1>

            <p class="mt-4 max-w-2xl text-base leading-7 text-[#5f5146] sm:mt-5 sm:text-[17px] sm:leading-8 lg:text-lg">
                Trouvez facilement le meuble qu’il vous faut, composez une pièce harmonieuse ou confiez-nous un projet entièrement adapté à votre espace. Tout est pensé pour vous aider à décider plus vite et plus sereinement.
            </p>

            <div class="mt-6 flex flex-col gap-3 sm:mt-8 sm:flex-row">
                <a href="#univers" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#171411] px-5 py-3.5 text-sm font-semibold text-white transition hover:bg-[#b88a3b] sm:px-6 sm:py-4">
                    <i class="fa-solid fa-compass text-sm"></i>
                    Voir les univers
                </a>
                <a href="{{ $contactUrl }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-[#d8c7af] bg-white px-5 py-3.5 text-sm font-semibold text-[#171411] transition hover:border-[#c7a36a] hover:bg-[#fffaf2] sm:px-6 sm:py-4">
                    <i class="fa-regular fa-pen-to-square text-sm"></i>
                    Demander un devis
                </a>
            </div>

            <div class="mt-6 flex flex-wrap items-center gap-x-5 gap-y-2 text-xs font-semibold text-[#5b4d42] sm:mt-8 sm:gap-x-8 sm:gap-y-3 sm:text-sm">
                @foreach($trustRibbon as $item)
                    <div class="inline-flex items-center gap-3">
                        <span class="text-[#a47834]">
                            <i class="{{ $item['icon'] }}"></i>
                        </span>
                        {{ $item['label'] }}
                    </div>
                    @if(!$loop->last)
                        <span class="hidden h-4 w-px bg-[#d8c7af] lg:block"></span>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</section>

<section class="bg-[#fbf7f0] py-12">
    <div class="container mx-auto px-4">
        <div class="mb-8 flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-3xl">
                <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Choisissez votre chemin</div>
                <h2 class="font-display mt-2 text-3xl font-bold text-[#171411] sm:text-4xl">Commencez exactement là où vous en êtes.</h2>
            </div>
            <a href="{{ $searchUrl }}" class="text-sm font-semibold text-[#5f5146] transition hover:text-[#171411]">Recherche rapide</a>
        </div>

        <div class="grid gap-5 lg:grid-cols-3">
            @foreach($entryModes as $mode)
                <a href="{{ $mode['href'] }}" class="group rounded-[30px] border border-[#eadfce] px-6 py-6 shadow-[0_16px_40px_rgba(23,20,17,0.05)] transition hover:-translate-y-1 hover:shadow-[0_24px_60px_rgba(23,20,17,0.09)] {{ $mode['tone'] }}">
                    <div class="flex items-center justify-between gap-3">
                        <div class="text-xs font-bold uppercase tracking-[0.22em] {{ str_contains($mode['tone'], 'text-white') ? 'text-[#d8b77d]' : 'text-[#a47834]' }}">{{ $mode['eyebrow'] }}</div>
                        <div class="font-display text-3xl font-bold {{ str_contains($mode['tone'], 'text-white') ? 'text-white/22' : 'text-[#e8dcc9]' }}">{{ $mode['label'] }}</div>
                    </div>
                    <h3 class="font-display mt-4 text-2xl font-bold {{ str_contains($mode['tone'], 'text-white') ? 'text-white' : 'text-[#171411]' }}">{{ $mode['title'] }}</h3>
                    <p class="mt-3 text-base leading-7 {{ str_contains($mode['tone'], 'text-white') ? 'text-white/74' : 'text-[#5f5146]' }}">{{ $mode['copy'] }}</p>
                    <div class="mt-6 text-sm font-semibold {{ str_contains($mode['tone'], 'text-white') ? 'text-white' : 'text-[#171411]' }}">
                        {{ $mode['cta'] }}
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section id="univers" class="bg-white py-14 lg:py-18">
    <div class="container mx-auto px-4">
        <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-3xl">
                <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Univers</div>
                <h2 class="font-display mt-2 text-3xl font-bold text-[#171411] sm:text-4xl">Choisissez d’abord votre pièce, puis les meubles qui vont vraiment avec.</h2>
                <p class="mt-3 text-lg leading-8 text-[#5f5146]">
                    Chambre adulte, chambre enfant, salon, rangement, cuisine ou bureau : chaque univers vous aide à voir plus vite ce qui correspond à votre style, à votre besoin et à votre budget.
                </p>
            </div>
            <a href="{{ $categoriesUrl }}" class="text-sm font-semibold text-[#5f5146] transition hover:text-[#171411]">Tout le catalogue</a>
        </div>

        <div class="grid auto-rows-[240px] gap-5 lg:grid-cols-12">
            @foreach($homeRooms as $room)
                @php
                    $cardClass = match ($loop->index) {
                        0 => 'lg:col-span-7 lg:row-span-2',
                        1 => 'lg:col-span-5',
                        2 => 'lg:col-span-5',
                        3 => 'lg:col-span-3',
                        4 => 'lg:col-span-4',
                        default => 'lg:col-span-5',
                    };
                @endphp
                <a href="{{ $room['href'] }}" class="group relative overflow-hidden rounded-[32px] border border-[#eadfce] {{ $cardClass }}">
                    @if(!empty($room['image']))
                        <img src="{{ $imageUrl($room['image']) }}" alt="{{ $room['name'] }}" class="h-full w-full object-cover transition duration-700 group-hover:scale-105">
                    @else
                        <div class="flex h-full w-full items-center justify-center bg-[radial-gradient(circle_at_top,_rgba(184,138,59,0.22),transparent_42%),linear-gradient(135deg,#f4ead8,#e7d4b8)] font-display text-5xl font-bold text-[#967b54]">
                            {{ strtoupper(mb_substr($room['name'], 0, 1)) }}
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-[#171411]/86 via-[#171411]/30 to-transparent"></div>
                    <div class="absolute inset-x-0 bottom-0 p-5 text-white">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <div class="font-display text-2xl font-bold">{{ $room['name'] }}</div>
                                <p class="mt-2 max-w-md text-sm leading-6 text-white/78">{{ $room['tagline'] }}</p>
                            </div>
                            <span class="rounded-full border border-white/15 bg-white/10 px-3 py-1 text-xs font-semibold">{{ $room['count'] }}</span>
                        </div>
                        @if(collect($room['subitems'])->isNotEmpty())
                            <div class="mt-4 flex flex-wrap gap-2">
                                @foreach(collect($room['subitems'])->take(4) as $item)
                                    <span class="rounded-full border border-white/10 bg-white/10 px-3 py-1 text-[11px] font-medium text-white/78">{{ $item }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section id="composer" class="bg-[#171411] py-16 text-white lg:py-20">
    <div class="container mx-auto px-4">
        <div class="grid gap-8 xl:grid-cols-[0.9fr_1.1fr] xl:items-start">
            <div class="max-w-2xl">
                <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#d8b77d]">Composer une pièce</div>
                <h2 class="font-display mt-3 text-3xl font-bold sm:text-4xl">Composez votre pièce sans vous perdre.</h2>
                <p class="mt-4 text-lg leading-8 text-white/72">
                    Commencez par la pièce que vous voulez aménager. Nous vous guidons ensuite vers les meubles essentiels, les bons compléments et, si besoin, vers un devis plus personnalisé.
                </p>

                <div class="mt-8 space-y-4">
                    @foreach($projectSteps as $step)
                        <div class="flex items-start gap-4 rounded-[26px] border border-white/10 bg-white/5 px-5 py-4">
                            <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-[#b88a3b] font-display text-lg font-bold text-[#171411]">{{ $loop->iteration }}</div>
                            <div class="pt-1 text-base leading-7 text-white/80">{{ $step }}</div>
                        </div>
                    @endforeach
                </div>

                <a href="{{ $contactUrl }}" class="mt-8 inline-flex items-center rounded-full bg-white px-6 py-4 text-sm font-semibold text-[#171411] transition hover:bg-[#efe2cb]">
                    Parler à un conseiller
                </a>
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                @foreach($composerEntries as $entry)
                    <a href="{{ $entry['href'] }}" class="group rounded-[30px] border border-white/10 bg-white px-6 py-6 text-[#171411] shadow-[0_20px_40px_rgba(0,0,0,0.12)] transition hover:-translate-y-1 hover:shadow-[0_28px_60px_rgba(0,0,0,0.18)]">
                        <div class="flex items-center justify-between gap-3">
                            <div class="text-xs font-bold uppercase tracking-[0.2em] text-[#a47834]">{{ $entry['eyebrow'] }}</div>
                            <span class="rounded-full bg-[#faf1e3] px-3 py-1 text-[11px] font-bold text-[#8a6528]">{{ $entry['badge'] }}</span>
                        </div>
                        <h3 class="font-display mt-4 text-2xl font-bold text-[#171411]">{{ $entry['name'] }}</h3>
                        <p class="mt-3 text-base leading-7 text-[#5f5146]">{{ $entry['description'] }}</p>
                        <div class="mt-6 text-sm font-semibold text-[#171411] transition group-hover:text-[#a47834]">Commencer</div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>

@if($featuredCollections->isNotEmpty())
<section class="bg-[#fbf7f0] py-14 lg:py-18">
    <div class="container mx-auto px-4">
        <div class="mb-8 max-w-3xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Collections</div>
            <h2 class="font-display mt-2 text-3xl font-bold text-[#171411] sm:text-4xl">Un même style, décliné sur plusieurs meubles.</h2>
        </div>

        <div class="grid gap-5 lg:grid-cols-3">
            @foreach($featuredCollections as $collection)
                <a href="{{ $collection['href'] }}" class="rounded-[30px] border border-[#eadfce] bg-white p-6 shadow-[0_16px_40px_rgba(23,20,17,0.05)] transition hover:-translate-y-1 hover:shadow-[0_24px_60px_rgba(23,20,17,0.08)]">
                    <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">{{ $collection['eyebrow'] }}</div>
                    <h3 class="font-display mt-3 text-2xl font-bold text-[#171411]">{{ $collection['name'] }}</h3>
                    @if(!empty($collection['family']))
                        <div class="mt-2 text-sm font-semibold text-[#7a6b5e]">{{ $collection['family'] }}</div>
                    @endif
                    <p class="mt-4 text-base leading-7 text-[#5f5146]">{{ $collection['description'] }}</p>
                    <div class="mt-6 flex items-center justify-between">
                        <span class="text-sm font-semibold text-[#171411]">Explorer la collection</span>
                        @if(!empty($collection['count']))
                            <span class="rounded-full bg-[#f8f1e4] px-3 py-1 text-[11px] font-bold text-[#8a6528]">{{ $collection['count'] }} produits</span>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="bg-white py-14 lg:py-18">
    <div class="container mx-auto px-4">
        <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-3xl">
                <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Sélection du moment</div>
                <h2 class="font-display mt-2 text-3xl font-bold text-[#171411] sm:text-4xl">Des pièces prêtes à commander dès maintenant.</h2>
                <p class="mt-3 text-lg leading-8 text-[#5f5146]">
                    Pour aller vite, retrouvez une sélection de meubles déjà prêts à commander, avec des fiches claires et un passage à l’action direct.
                </p>
            </div>
            <a href="{{ $searchUrl }}" class="text-sm font-semibold text-[#5f5146] transition hover:text-[#171411]">Tous les produits</a>
        </div>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @foreach($featuredProducts as $product)
                <article class="overflow-hidden rounded-[30px] border border-[#eadfce] bg-[#fbf7f0] shadow-[0_16px_40px_rgba(23,20,17,0.05)] transition hover:-translate-y-1 hover:shadow-[0_24px_60px_rgba(23,20,17,0.08)]">
                    <a href="{{ route('product.show', $product->slug) }}" class="block aspect-[4/3] overflow-hidden bg-[#efe4d6]">
                        @if($product->main_image)
                            <img src="{{ $imageUrl($product->main_image) }}" alt="{{ $product->title }}" class="h-full w-full object-cover transition duration-700 hover:scale-105">
                        @else
                            <div class="flex h-full w-full items-center justify-center bg-[linear-gradient(135deg,#f5eada,#e8d4b8)] font-display text-4xl font-bold text-[#8b724d]">{{ strtoupper(mb_substr($product->title, 0, 1)) }}</div>
                        @endif
                    </a>
                    <div class="space-y-4 p-6">
                        @if($product->category)
                            <div class="text-xs font-bold uppercase tracking-[0.18em] text-[#a47834]">{{ $product->category->name }}</div>
                        @endif
                        <h3 class="line-clamp-2 font-display text-2xl font-bold text-[#171411]">{{ $product->title }}</h3>
                        <div class="flex items-end justify-between gap-4">
                            <div>
                                <div class="text-sm text-[#7a6b5e]">Prix</div>
                                <div class="text-2xl font-extrabold text-[#a47834]">{{ $product->price_display }}</div>
                            </div>
                            <a href="{{ route('product.show', $product->slug) }}" class="inline-flex items-center rounded-full bg-[#171411] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#b88a3b]">
                                Voir la fiche
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section id="atelier" class="bg-[#f3ece2] py-14 lg:py-18">
    <div class="container mx-auto px-4">
        <div class="grid gap-8 xl:grid-cols-[1.05fr_0.95fr]">
            <div>
                <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Ateliers</div>
                <h2 class="font-display mt-2 text-3xl font-bold text-[#171411] sm:text-4xl">Besoin d’un projet adapté à votre maison ? Nos ateliers prennent le relais.</h2>
                <p class="mt-3 max-w-2xl text-lg leading-8 text-[#5f5146]">
                    Quand les dimensions, la finition ou l’usage demandent quelque chose de plus précis, vous n’êtes pas seul. Nous pouvons vous conseiller, adapter et fabriquer selon votre besoin.
                </p>

                <div class="mt-8 grid gap-5 md:grid-cols-3">
                    @foreach($atelierCapabilities as $capability)
                        <article class="rounded-[28px] border border-[#eadfce] bg-white p-6 shadow-[0_16px_40px_rgba(23,20,17,0.05)]">
                            <div class="text-xs font-bold uppercase tracking-[0.2em] text-[#a47834]">Savoir-faire</div>
                            <h3 class="font-display mt-3 text-2xl font-bold text-[#171411]">{{ $capability['title'] }}</h3>
                            <p class="mt-3 text-base leading-7 text-[#5f5146]">{{ $capability['copy'] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>

            <div id="sur-mesure" class="rounded-[34px] bg-[#171411] p-7 text-white shadow-[0_28px_70px_rgba(23,20,17,0.16)] lg:p-8">
                <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#d8b77d]">Sur mesure</div>
                <h2 class="font-display mt-3 text-3xl font-bold">Cuisine, dressing, aluminium ou ferronnerie : parlez-nous de votre projet.</h2>
                <p class="mt-4 text-base leading-8 text-white/72">
                    Si votre projet dépend des mesures, des finitions ou d’une contrainte particulière, nous préparons avec vous une réponse plus juste qu’un simple achat standard.
                </p>

                <div class="mt-6 space-y-3">
                    <div class="rounded-2xl border border-white/10 bg-white/6 px-4 py-4 text-sm text-white/80">1. Envoyez votre besoin, vos dimensions ou quelques photos.</div>
                    <div class="rounded-2xl border border-white/10 bg-white/6 px-4 py-4 text-sm text-white/80">2. Nous clarifions avec vous l’usage, le style et les contraintes.</div>
                    <div class="rounded-2xl border border-white/10 bg-white/6 px-4 py-4 text-sm text-white/80">3. Vous recevez une réponse plus précise, plus utile et plus crédible.</div>
                </div>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ $contactUrl }}" class="inline-flex items-center justify-center rounded-full bg-white px-5 py-3 text-sm font-semibold text-[#171411] transition hover:bg-[#efe2cb]">
                        Demander une étude
                    </a>
                    <a href="{{ $categoriesUrl }}" class="inline-flex items-center justify-center rounded-full border border-white/15 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/10">
                        Continuer vers le catalogue
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@if($latest->isNotEmpty())
<section class="bg-white py-14 lg:py-16">
    <div class="container mx-auto px-4">
        <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Nouveautés</div>
                <h2 class="font-display mt-2 text-3xl font-bold text-[#171411]">Ce qui vient d’entrer au catalogue</h2>
            </div>
            <a href="{{ $searchUrl }}" class="text-sm font-semibold text-[#5f5146] transition hover:text-[#171411]">Voir plus</a>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach($latest as $product)
                <a href="{{ route('product.show', $product->slug) }}" class="group overflow-hidden rounded-[26px] border border-[#eadfce] bg-[#fbf7f0] shadow-[0_12px_28px_rgba(23,20,17,0.04)] transition hover:-translate-y-1 hover:shadow-[0_20px_46px_rgba(23,20,17,0.08)]">
                    <div class="aspect-square overflow-hidden bg-[#efe4d6]">
                        @if($product->main_image)
                            <img src="{{ $imageUrl($product->main_image) }}" alt="{{ $product->title }}" class="h-full w-full object-cover transition duration-700 group-hover:scale-105">
                        @endif
                    </div>
                    <div class="space-y-2 p-4">
                        <div class="text-xs font-bold uppercase tracking-[0.18em] text-[#a47834]">{{ $product->category?->name ?? 'Produit' }}</div>
                        <div class="line-clamp-2 font-semibold text-[#171411]">{{ $product->title }}</div>
                        <div class="text-lg font-bold text-[#a47834]">{{ $product->price_display }}</div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
