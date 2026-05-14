@extends('layouts.store')

@php
    $devisUrl = url('/devis');
    $phoneDisplay = \App\Support\SiteSettings::phoneDisplay();
    $whatsappUrl = \App\Support\SiteSettings::whatsappUrl() ?? $devisUrl;
    $totalCount = $counts->sum();

    $schema = [
        [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Accueil', 'item' => route('home')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Réalisations', 'item' => route('realizations.index')],
            ],
        ],
        [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => 'Réalisations Maison216',
            'description' => $metaDescription ?? null,
            'url' => route('realizations.index'),
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
            <span class="text-[#171411]">Réalisations</span>
        </nav>
    </div>
</section>

<section class="relative overflow-hidden bg-[#f7f1e7] py-14 lg:py-24">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_16%_18%,rgba(184,138,59,0.18),transparent_30%),radial-gradient(circle_at_88%_10%,rgba(23,20,17,0.08),transparent_28%)]"></div>
    <div class="container relative mx-auto px-4">
        <div class="max-w-5xl">
            <h1 class="font-display text-4xl font-extrabold leading-[1.02] tracking-[-0.06em] text-[#171411] sm:text-5xl lg:text-7xl lg:leading-[0.98]">
                Réalisations Maison216.
                <span class="block text-[#a47834]">Bois, aluminium, métal et projets complets.</span>
            </h1>
            <p class="mt-5 max-w-3xl text-base leading-8 text-[#5f5146] sm:text-lg sm:leading-9">
                Une sélection de projets livrés ou présentés par Maison216 : cuisines, dressings, menuiserie aluminium, portails, pergolas et agencements professionnels.
            </p>
            <div class="mt-8 flex flex-row gap-2 sm:gap-3">
                <a href="{{ $devisUrl }}" class="inline-flex flex-1 items-center justify-center gap-2 rounded-full bg-[#171411] px-4 py-3 text-xs font-extrabold text-white transition hover:bg-[#a47834] sm:flex-none sm:px-7 sm:py-4 sm:text-sm">
                    <i class="fa-regular fa-pen-to-square"></i>
                    Demander un devis
                </a>
                <a href="{{ $whatsappUrl }}" class="inline-flex flex-1 items-center justify-center gap-2 rounded-full border border-[#cdbb9f] bg-white px-4 py-3 text-xs font-extrabold text-[#171411] transition hover:border-[#a47834] sm:flex-none sm:px-7 sm:py-4 sm:text-sm">
                    <i class="fa-brands fa-whatsapp"></i>
                    {{ $phoneDisplay }}
                </a>
            </div>
        </div>
    </div>
</section>

<section class="overflow-hidden bg-white py-10 lg:py-16">
    <div class="container mx-auto px-4">
        <div class="mb-7 lg:mb-9">
            <div class="flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-2xl">
                    <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Portfolio</div>
                    <h2 class="font-display mt-2 text-3xl font-extrabold leading-tight tracking-[-0.04em] text-[#171411] sm:text-4xl">Tous les projets publiés.</h2>
                </div>
                <div class="hidden rounded-full border border-[#eadfce] bg-[#fbf7f0] px-4 py-2 text-sm font-extrabold text-[#5f5146] lg:block">
                    {{ $totalCount }} projet{{ $totalCount > 1 ? 's' : '' }} publié{{ $totalCount > 1 ? 's' : '' }}
                </div>
            </div>

            <div class="relative mt-5">
                <div class="pointer-events-none absolute inset-y-0 left-0 z-10 w-6 bg-gradient-to-r from-white to-transparent lg:hidden"></div>
                <div class="pointer-events-none absolute inset-y-0 right-0 z-10 w-10 bg-gradient-to-l from-white to-transparent lg:hidden"></div>
                <nav class="scrollbar-hide -mx-4 flex flex-nowrap gap-2 overflow-x-auto px-4 pb-2 [scroll-snap-type:x_mandatory] lg:mx-0 lg:flex-wrap lg:overflow-visible lg:px-0 lg:pb-0" aria-label="Filtrer les réalisations par métier">
                    <a href="{{ route('realizations.index') }}" class="inline-flex shrink-0 scroll-ml-4 items-center gap-2 whitespace-nowrap rounded-full border px-3.5 py-2 text-[13px] font-extrabold transition [scroll-snap-align:start] sm:px-4 sm:py-2.5 sm:text-sm {{ $activeSilo === '' ? 'border-[#171411] bg-[#171411] text-white shadow-[0_14px_30px_rgba(23,20,17,0.16)]' : 'border-[#d8c7af] bg-[#fbf7f0] text-[#171411] hover:bg-white' }}">
                        Tous
                        <span class="rounded-full px-1.5 py-0.5 text-[11px] leading-none {{ $activeSilo === '' ? 'bg-white/16 text-white/80' : 'bg-[#eadfce] text-[#6a4a16]' }}">{{ $totalCount }}</span>
                    </a>
                    @foreach($siloLabels as $silo => $label)
                        @if(($counts[$silo] ?? 0) > 0)
                            <a href="{{ route('realizations.index', ['silo' => $silo]) }}" class="inline-flex shrink-0 scroll-ml-4 items-center gap-2 whitespace-nowrap rounded-full border px-3.5 py-2 text-[13px] font-extrabold transition [scroll-snap-align:start] sm:px-4 sm:py-2.5 sm:text-sm {{ $activeSilo === $silo ? 'border-[#171411] bg-[#171411] text-white shadow-[0_14px_30px_rgba(23,20,17,0.16)]' : 'border-[#d8c7af] bg-[#fbf7f0] text-[#171411] hover:bg-white' }}">
                                {{ $label }}
                                <span class="rounded-full px-1.5 py-0.5 text-[11px] leading-none {{ $activeSilo === $silo ? 'bg-white/16 text-white/80' : 'bg-[#eadfce] text-[#6a4a16]' }}">{{ $counts[$silo] }}</span>
                            </a>
                        @endif
                    @endforeach
                </nav>
            </div>
        </div>

        @if($realizations->isNotEmpty())
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3 xl:gap-5">
                @foreach($realizations as $realization)
                    <a href="{{ route('realizations.show', $realization) }}" class="group flex h-full flex-col overflow-hidden rounded-[28px] border border-[#eadfce] bg-white shadow-[0_16px_45px_rgba(23,20,17,0.10)] transition hover:-translate-y-1 hover:shadow-[0_28px_80px_rgba(23,20,17,0.16)] sm:rounded-[34px]">
                        <div class="relative overflow-hidden bg-[#eadfce]">
                            <img src="{{ $realization->coverImageUrl() }}" alt="{{ $realization->cover_alt ?: $realization->title }}" loading="lazy" decoding="async" class="block h-64 w-full object-cover transition duration-700 group-hover:scale-105 sm:h-72 lg:h-80">
                            <div class="absolute inset-x-0 top-0 h-20 bg-gradient-to-b from-[#171411]/42 to-transparent"></div>
                            <span class="absolute left-4 top-4 inline-flex max-w-[calc(100%-2rem)] rounded-full border border-white/25 bg-[#171411]/62 px-3 py-1 text-xs font-bold text-[#f0d49a] shadow-sm backdrop-blur">
                                <span class="truncate">{{ $realization->project_type ?: $realization->siloLabel() }}</span>
                            </span>
                        </div>
                        <div class="flex flex-1 flex-col justify-between p-5 text-[#171411] sm:p-6">
                            <div>
                                <div class="text-[11px] font-bold uppercase tracking-[0.2em] text-[#a47834]">{{ $realization->siloLabel() }}</div>
                                <h3 class="font-display mt-2 text-2xl font-extrabold leading-tight">{{ $realization->title }}</h3>
                                @if($realization->short_description)
                                    <p class="mt-2 line-clamp-2 text-sm leading-6 text-[#5f5146]">{{ $realization->short_description }}</p>
                                @endif
                            </div>
                            <div class="mt-5 inline-flex items-center gap-2 text-sm font-extrabold text-[#8e6322]">
                                Voir le projet
                                <i class="fa-solid fa-arrow-right text-xs transition group-hover:translate-x-1"></i>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $realizations->links() }}
            </div>
        @else
            <div class="rounded-[34px] border border-[#eadfce] bg-[#fbf7ee] p-8 text-center">
                <h3 class="font-display text-2xl font-extrabold text-[#171411]">Aucune réalisation publiée pour ce filtre.</h3>
                <p class="mt-3 text-base text-[#5f5146]">Changez de filtre ou revenez à l’ensemble des projets.</p>
                <a href="{{ route('realizations.index') }}" class="mt-6 inline-flex rounded-full bg-[#171411] px-6 py-3 text-sm font-extrabold text-white">Voir toutes les réalisations</a>
            </div>
        @endif
    </div>
</section>
@endsection
