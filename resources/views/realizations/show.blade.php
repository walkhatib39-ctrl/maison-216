@extends('layouts.store')

@php
    $devisUrl = url('/devis');
    $whatsappUrl = \App\Support\SiteSettings::whatsappUrl() ?? $devisUrl;
    $relatedPages = $realization->pages;
    $gallery = $realization->images;

    $schema = [
        [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Accueil', 'item' => route('home')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Réalisations', 'item' => url('/#realisations')],
                ['@type' => 'ListItem', 'position' => 3, 'name' => $realization->title, 'item' => route('realizations.show', $realization)],
            ],
        ],
        [
            '@context' => 'https://schema.org',
            '@type' => 'CreativeWork',
            'name' => $realization->title,
            'description' => $realization->short_description ?: $realization->description,
            'image' => $realization->coverImageUrl(),
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'Maison216',
                'url' => route('home'),
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
    <div class="container mx-auto px-4 py-6">
        <nav class="flex flex-wrap items-center gap-2 text-sm font-semibold text-[#6a5a4c]" aria-label="Fil d'Ariane">
            <a href="{{ route('home') }}" class="transition hover:text-[#171411]">Accueil</a>
            <i class="fa-solid fa-angle-right text-[10px] text-[#b88a3b]"></i>
            <a href="{{ url('/#realisations') }}" class="transition hover:text-[#171411]">Réalisations</a>
            <i class="fa-solid fa-angle-right text-[10px] text-[#b88a3b]"></i>
            <span class="text-[#171411]">{{ $realization->title }}</span>
        </nav>
    </div>
</section>

<section class="bg-[#f7f1e7] py-16 lg:py-24">
    <div class="container mx-auto px-4">
        <div class="grid gap-12 lg:grid-cols-[0.86fr_1.14fr] lg:items-center">
            <div>
                <div class="inline-flex rounded-full border border-[#ddcdb8] bg-white/70 px-4 py-2 text-xs font-extrabold uppercase tracking-[0.22em] text-[#8e6322]">
                    {{ $realization->siloLabel() }}
                </div>
                <h1 class="font-display mt-7 text-4xl font-extrabold leading-[0.98] tracking-[-0.06em] text-[#171411] sm:text-5xl lg:text-7xl">
                    {{ $realization->title }}
                </h1>
                @if($realization->short_description)
                    <p class="mt-7 max-w-3xl text-lg leading-9 text-[#5f5146]">{{ $realization->short_description }}</p>
                @endif
                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ $devisUrl }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#171411] px-7 py-4 text-sm font-extrabold text-white transition hover:bg-[#a47834]">
                        <i class="fa-regular fa-pen-to-square"></i>
                        Demander un devis similaire
                    </a>
                    <a href="{{ $whatsappUrl }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-[#cdbb9f] bg-white px-7 py-4 text-sm font-extrabold text-[#171411] transition hover:border-[#a47834]">
                        <i class="fa-brands fa-whatsapp"></i>
                        WhatsApp
                    </a>
                </div>
            </div>

            <div class="overflow-hidden rounded-[38px] border border-[#eadfce] bg-white p-3 shadow-[0_35px_90px_rgba(23,20,17,0.14)]">
                <img src="{{ $realization->coverImageUrl() }}" alt="{{ $realization->cover_alt ?: $realization->title }}" class="h-[320px] w-full rounded-[30px] object-cover sm:h-[520px]">
            </div>
        </div>
    </div>
</section>

@if($realization->description)
    <section class="bg-white py-16 lg:py-20">
        <div class="container mx-auto px-4">
            <div class="mx-auto max-w-4xl rounded-[34px] border border-[#eadfce] bg-[#fbf7ee] p-7 text-lg leading-9 text-[#5f5146] lg:p-10">
                {!! nl2br(e($realization->description)) !!}
            </div>
        </div>
    </section>
@endif

@if($gallery->isNotEmpty())
    <section class="bg-[#fbf7ee] py-16 lg:py-20">
        <div class="container mx-auto px-4">
            <div class="mb-9 max-w-3xl">
                <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#a47834]">Galerie</div>
                <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">Images du projet.</h2>
            </div>
            <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                @foreach($gallery as $image)
                    <figure class="overflow-hidden rounded-[30px] border border-[#eadfce] bg-white">
                        <img src="{{ $image->imageUrl() }}" alt="{{ $image->alt_text ?: $realization->title }}" class="h-72 w-full object-cover">
                        @if($image->caption)
                            <figcaption class="p-4 text-sm font-semibold text-[#5f5146]">{{ $image->caption }}</figcaption>
                        @endif
                    </figure>
                @endforeach
            </div>
        </div>
    </section>
@endif

@if($relatedPages->isNotEmpty())
    <section class="bg-white py-16 lg:py-20">
        <div class="container mx-auto px-4">
            <div class="mb-7 max-w-3xl">
                <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#a47834]">Pages associées</div>
                <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">Voir les services liés à cette réalisation.</h2>
            </div>
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                @foreach($relatedPages as $page)
                    <a href="{{ url('/' . $page->path) }}" class="group rounded-[26px] border border-[#eadfce] bg-[#fbf7ee] p-5 transition hover:-translate-y-1 hover:border-[#c7a36a] hover:bg-white">
                        <div class="text-xs font-extrabold uppercase tracking-[0.18em] text-[#a47834]">{{ $page->silo }}</div>
                        <h3 class="font-display mt-3 text-xl font-extrabold text-[#171411]">{{ $page->admin_title }}</h3>
                        <div class="mt-5 text-sm font-extrabold text-[#8e6322]">Voir la page <i class="fa-solid fa-arrow-right ml-1 text-xs transition group-hover:translate-x-1"></i></div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endif

<section class="bg-[#fbf7ee] py-16 lg:py-20">
    <div class="container mx-auto px-4 text-center">
        <div class="mx-auto max-w-3xl rounded-[36px] border border-[#eadfce] bg-white p-8 shadow-[0_20px_65px_rgba(23,20,17,0.08)] lg:p-10">
            <h2 class="font-display text-3xl font-extrabold text-[#171411] sm:text-4xl">Vous voulez un projet similaire ?</h2>
            <p class="mt-4 text-lg leading-8 text-[#5f5146]">Envoyez-nous vos dimensions, photos ou plans. Nous revenons vers vous avec un devis clair.</p>
            <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
                <a href="{{ $devisUrl }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#171411] px-8 py-4 text-sm font-extrabold text-white transition hover:bg-[#a47834]">
                    Demander un devis
                </a>
                <a href="{{ $whatsappUrl }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-[#cdbb9f] px-8 py-4 text-sm font-extrabold text-[#171411] transition hover:border-[#a47834]">
                    WhatsApp
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
