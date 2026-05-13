@extends('layouts.store')

@php
    $devisUrl = url('/devis');
    $phoneDisplay = \App\Support\SiteSettings::phoneDisplay();
    $whatsappUrl = \App\Support\SiteSettings::whatsappUrl() ?? $devisUrl;

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

<section class="relative overflow-hidden bg-[#f7f1e7] py-16 lg:py-24">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_16%_18%,rgba(184,138,59,0.18),transparent_30%),radial-gradient(circle_at_88%_10%,rgba(23,20,17,0.08),transparent_28%)]"></div>
    <div class="container relative mx-auto px-4">
        <div class="max-w-5xl">
            <h1 class="font-display text-4xl font-extrabold leading-[0.98] tracking-[-0.06em] text-[#171411] sm:text-5xl lg:text-7xl">
                Réalisations Maison216.
                <span class="block text-[#a47834]">Bois, aluminium, métal et projets complets.</span>
            </h1>
            <p class="mt-6 max-w-3xl text-lg leading-9 text-[#5f5146]">
                Une sélection de projets livrés ou présentés par Maison216 : cuisines, dressings, menuiserie aluminium, portails, pergolas et agencements professionnels.
            </p>
            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                <a href="{{ $devisUrl }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#171411] px-7 py-4 text-sm font-extrabold text-white transition hover:bg-[#a47834]">
                    <i class="fa-regular fa-pen-to-square"></i>
                    Demander un devis
                </a>
                <a href="{{ $whatsappUrl }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-[#cdbb9f] bg-white px-7 py-4 text-sm font-extrabold text-[#171411] transition hover:border-[#a47834]">
                    <i class="fa-brands fa-whatsapp"></i>
                    {{ $phoneDisplay }}
                </a>
            </div>
        </div>
    </div>
</section>

<section class="bg-white py-12 lg:py-16">
    <div class="container mx-auto px-4">
        <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#a47834]">Portfolio</div>
                <h2 class="font-display mt-3 text-3xl font-extrabold text-[#171411] sm:text-4xl">Tous les projets publiés.</h2>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('realizations.index') }}" class="rounded-full border px-4 py-2 text-sm font-extrabold transition {{ $activeSilo === '' ? 'border-[#171411] bg-[#171411] text-white' : 'border-[#d8c7af] bg-[#fbf7f0] text-[#171411] hover:bg-white' }}">
                    Tous
                    <span class="ml-1 text-xs opacity-70">{{ $counts->sum() }}</span>
                </a>
                @foreach($siloLabels as $silo => $label)
                    @if(($counts[$silo] ?? 0) > 0)
                        <a href="{{ route('realizations.index', ['silo' => $silo]) }}" class="rounded-full border px-4 py-2 text-sm font-extrabold transition {{ $activeSilo === $silo ? 'border-[#171411] bg-[#171411] text-white' : 'border-[#d8c7af] bg-[#fbf7f0] text-[#171411] hover:bg-white' }}">
                            {{ $label }}
                            <span class="ml-1 text-xs opacity-70">{{ $counts[$silo] }}</span>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>

        @if($realizations->isNotEmpty())
            <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                @foreach($realizations as $realization)
                    <a href="{{ route('realizations.show', $realization) }}" class="group overflow-hidden rounded-[34px] border border-[#eadfce] bg-[#171411] shadow-[0_20px_55px_rgba(23,20,17,0.10)] transition hover:-translate-y-1 hover:shadow-[0_28px_80px_rgba(23,20,17,0.16)]">
                        <div class="relative min-h-[330px] bg-cover bg-center" style="background-image: linear-gradient(180deg, rgba(23,20,17,0.04), rgba(23,20,17,0.82)), url('{{ $realization->coverImageUrl() }}');">
                            <div class="absolute inset-0 flex flex-col justify-between p-6 text-white">
                                <span class="inline-flex w-max rounded-full border border-white/15 bg-white/10 px-3 py-1 text-xs font-bold text-[#e7c98d] backdrop-blur">{{ $realization->project_type ?: $realization->siloLabel() }}</span>
                                <div>
                                    <div class="text-xs font-bold uppercase tracking-[0.2em] text-[#e7c98d]">{{ $realization->siloLabel() }}</div>
                                    <h3 class="font-display mt-2 text-2xl font-extrabold">{{ $realization->title }}</h3>
                                    @if($realization->short_description)
                                        <p class="mt-2 text-sm leading-6 text-white/76">{{ $realization->short_description }}</p>
                                    @endif
                                </div>
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
                <p class="mt-3 text-base text-[#5f5146]">Revenez à tous les projets ou ajoutez des réalisations depuis l'admin.</p>
                <a href="{{ route('realizations.index') }}" class="mt-6 inline-flex rounded-full bg-[#171411] px-6 py-3 text-sm font-extrabold text-white">Voir tous les projets</a>
            </div>
        @endif
    </div>
</section>
@endsection
