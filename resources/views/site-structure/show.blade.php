@extends('layouts.store')

@section('content')
@php
    $isQuote = in_array($page['type'] ?? 'catalog', ['quote'], true);
    $ctaLabel = $isQuote ? 'Demander un devis' : 'Voir les meubles';
    $ctaHref = $isQuote ? url('/devis') : route('categories.index');
@endphp

<section class="border-b border-[#eadfce] bg-[#f6f1e8]">
    <div class="container mx-auto px-4 py-10 lg:py-14">
        <nav class="flex flex-wrap items-center gap-2 text-sm font-semibold text-[#6a5a4c]" aria-label="Fil d'Ariane">
            <a href="{{ route('home') }}" class="transition hover:text-[#171411]">Accueil</a>
            @foreach($ancestors as $ancestor)
                <i class="fa-solid fa-angle-right text-[10px] text-[#b88a3b]"></i>
                <a href="{{ $ancestor['href'] }}" class="transition hover:text-[#171411]">{{ $ancestor['title'] }}</a>
            @endforeach
            <i class="fa-solid fa-angle-right text-[10px] text-[#b88a3b]"></i>
            <span class="text-[#171411]">{{ $page['title'] }}</span>
        </nav>

        <div class="mt-8 max-w-4xl">
            <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">
                {{ $isQuote ? 'Projet sur mesure' : (($page['type'] ?? 'catalog') === 'guide' ? 'Guide Maison 216' : 'Catalogue Maison 216') }}
            </div>
            <h1 class="font-display mt-3 text-3xl font-bold leading-tight text-[#171411] sm:text-4xl lg:text-5xl">{{ $page['title'] }}</h1>
            <p class="mt-5 max-w-3xl text-base leading-8 text-[#5f5146] sm:text-lg">{{ $page['description'] }}</p>

            <div class="mt-7 flex flex-col gap-3 sm:flex-row">
                <a href="{{ $ctaHref }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#171411] px-6 py-4 text-sm font-semibold text-white transition hover:bg-[#b88a3b]">
                    <i class="{{ $isQuote ? 'fa-regular fa-pen-to-square' : 'fa-solid fa-border-all' }} text-sm"></i>
                    {{ $ctaLabel }}
                </a>
                <a href="{{ route('contact') }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-[#d8c7af] bg-white px-6 py-4 text-sm font-semibold text-[#171411] transition hover:border-[#c7a36a] hover:bg-[#fffaf2]">
                    <i class="fa-brands fa-whatsapp text-sm"></i>
                    Parler a un conseiller
                </a>
            </div>
        </div>
    </div>
</section>

@if($children->isNotEmpty())
    <section class="bg-white py-12 lg:py-16">
        <div class="container mx-auto px-4">
            <div class="mb-7 max-w-3xl">
                <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Explorer</div>
                <h2 class="font-display mt-2 text-2xl font-bold text-[#171411] sm:text-3xl">Choisissez le besoin le plus proche de votre projet.</h2>
            </div>

            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                @foreach($children as $child)
                    <a href="{{ $child['href'] }}" class="group rounded-lg border border-[#eadfce] bg-[#fbf7f0] p-5 transition hover:-translate-y-0.5 hover:border-[#c7a36a] hover:bg-white hover:shadow-[0_18px_40px_rgba(23,20,17,0.08)]">
                        <div class="flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <h3 class="font-display text-xl font-bold text-[#171411]">{{ $child['title'] }}</h3>
                                <p class="mt-3 text-sm leading-7 text-[#5f5146]">{{ $child['description'] }}</p>
                            </div>
                            <span class="mt-1 inline-flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-full bg-white text-[#a47834] ring-1 ring-[#eadfce] transition group-hover:bg-[#171411] group-hover:text-white">
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@else
    <section class="bg-white py-12 lg:py-16">
        <div class="container mx-auto px-4">
            <div class="grid gap-8 lg:grid-cols-[0.9fr_1.1fr] lg:items-start">
                <div>
                    <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Prochaine etape</div>
                    <h2 class="font-display mt-2 text-2xl font-bold text-[#171411] sm:text-3xl">
                        {{ $isQuote ? 'Envoyez-nous les dimensions ou une photo.' : 'Parcourez les produits disponibles.' }}
                    </h2>
                    <p class="mt-4 text-base leading-8 text-[#5f5146]">
                        {{ $isQuote ? 'Une demande claire permet de vous orienter plus vite sur la faisabilite, les options et le budget.' : 'Cette page est prete pour recevoir les produits et contenus dedies a cette categorie.' }}
                    </p>
                </div>

                <div class="grid gap-3 sm:grid-cols-2">
                    <a href="{{ $ctaHref }}" class="rounded-lg bg-[#171411] p-5 text-white transition hover:bg-[#b88a3b]">
                        <i class="{{ $isQuote ? 'fa-regular fa-pen-to-square' : 'fa-solid fa-border-all' }} text-lg"></i>
                        <div class="mt-4 font-display text-xl font-bold">{{ $ctaLabel }}</div>
                    </a>
                    <a href="{{ route('contact') }}" class="rounded-lg border border-[#eadfce] bg-[#fbf7f0] p-5 text-[#171411] transition hover:bg-white">
                        <i class="fa-solid fa-phone text-lg text-[#a47834]"></i>
                        <div class="mt-4 font-display text-xl font-bold">Contact</div>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endif

@if($siblings->isNotEmpty())
    <section class="border-t border-[#eadfce] bg-[#fbf7f0] py-10">
        <div class="container mx-auto px-4">
            <div class="mb-5 text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Autres entrees utiles</div>
            <div class="flex flex-wrap gap-3">
                @foreach($siblings->take(10) as $sibling)
                    <a href="{{ $sibling['href'] }}" class="rounded-full border border-[#eadfce] bg-white px-4 py-2 text-sm font-semibold text-[#5f5146] transition hover:border-[#c7a36a] hover:text-[#171411]">{{ $sibling['title'] }}</a>
                @endforeach
            </div>
        </div>
    </section>
@endif
@endsection
