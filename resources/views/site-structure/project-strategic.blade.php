@extends('layouts.store')

@php
    $devisUrl = url('/devis');
    $contactUrl = route('contact');
    $whatsappUrl = \App\Support\SiteSettings::whatsappUrl() ?? $contactUrl;
    $projectRealizations = app(\App\Support\RealizationResolver::class)->forCurrentPage(6, 'projets');

    $schema = [
        [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Accueil', 'item' => route('home')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Projets', 'item' => url('/projets')],
                ['@type' => 'ListItem', 'position' => 3, 'name' => $project['breadcrumb'], 'item' => $canonical ?? url()->current()],
            ],
        ],
        [
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'serviceType' => $project['breadcrumb'],
            'name' => $project['h1'],
            'description' => $project['metaDescription'],
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
            'mainEntity' => collect($project['faqs'])->map(fn ($faq) => [
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
            <span class="text-[#171411]">{{ $project['breadcrumb'] }}</span>
        </nav>
    </div>
</section>

<section class="relative overflow-hidden bg-[#f7f1e7]">
    <div class="absolute inset-y-0 right-0 hidden w-[44%] bg-[radial-gradient(circle_at_center,rgba(184,138,59,0.18),transparent_62%)] lg:block"></div>
    <div class="container relative mx-auto px-4 py-16 lg:py-24">
        <div class="grid gap-12 lg:grid-cols-[0.96fr_0.84fr] lg:items-center">
            <div>
                <div class="inline-flex items-center gap-2 rounded-full border border-[#ddcdb8] bg-white/70 px-4 py-2 text-xs font-extrabold uppercase tracking-[0.22em] text-[#8e6322]">
                    <i class="fa-solid fa-diagram-project"></i>
                    {{ $project['eyebrow'] }}
                </div>

                <h1 class="font-display mt-7 max-w-4xl text-4xl font-extrabold leading-[0.98] tracking-[-0.06em] text-[#171411] sm:text-5xl lg:text-7xl">
                    {{ $project['h1'] }}
                </h1>

                <p class="mt-7 max-w-3xl text-lg leading-9 text-[#5f5146]">
                    {{ $project['subtitle'] }}
                </p>

                <div class="mt-9">
                    <a href="{{ $devisUrl }}" class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-[#171411] px-8 py-4 text-sm font-extrabold text-white shadow-[0_18px_45px_rgba(23,20,17,0.22)] transition hover:bg-[#a47834] sm:w-auto">
                        <i class="fa-regular fa-pen-to-square"></i>
                        {{ $project['cta'] }}
                    </a>
                </div>

                <div class="mt-9 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                    @foreach($project['proofs'] as $proof)
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
                        <img src="{{ $project['heroImage'] }}" alt="{{ $project['breadcrumb'] }} Maison216" class="absolute inset-0 h-full w-full object-cover">
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
                <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#a47834]">{{ $project['issue']['eyebrow'] }}</div>
                <h2 class="font-display mt-3 text-3xl font-extrabold leading-tight tracking-[-0.04em] text-[#171411] sm:text-5xl">{{ $project['issue']['h2'] }}</h2>
            </div>
            <div class="space-y-6 text-base leading-8 text-[#5f5146] sm:text-lg">
                @foreach($project['issue']['paragraphs'] as $paragraph)
                    <p @class(['font-bold text-[#171411]' => $loop->last])>{{ $paragraph }}</p>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section class="bg-[#fbf7ee] py-16 lg:py-24">
    <div class="container mx-auto px-4">
        <div class="mb-10 max-w-4xl">
            <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#a47834]">{{ $project['scope']['eyebrow'] }}</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold leading-tight tracking-[-0.04em] text-[#171411] sm:text-5xl">{{ $project['scope']['h2'] }}</h2>
        </div>

        <div class="grid gap-5 lg:grid-cols-2">
            @foreach($project['scope']['items'] as $item)
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
                            @isset($item['href'])
                                <a href="{{ $item['href'] }}" class="mt-7 inline-flex items-center gap-2 text-sm font-extrabold text-[#8e6322]">
                                    Voir la page
                                    <i class="fa-solid fa-arrow-right text-xs transition group-hover:translate-x-1"></i>
                                </a>
                            @endisset
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

@isset($project['advantage'])
    <section class="bg-[#171411] py-16 text-white lg:py-24">
        <div class="container mx-auto px-4">
            <div class="grid gap-12 lg:grid-cols-[0.86fr_1.14fr] lg:items-start">
                <div>
                    <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#d5b170]">{{ $project['advantage']['eyebrow'] }}</div>
                    <h2 class="font-display mt-3 text-3xl font-extrabold leading-tight tracking-[-0.04em] sm:text-5xl">{{ $project['advantage']['h2'] }}</h2>
                </div>
                <div class="rounded-[36px] border border-white/10 bg-white/[0.055] p-7 lg:p-9">
                    <div class="space-y-6 text-base leading-8 text-white/76">
                        @foreach($project['advantage']['paragraphs'] as $paragraph)
                            <p @class(['font-extrabold text-white' => $loop->last])>{{ $paragraph }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endisset

<section class="bg-white py-16 lg:py-24">
    <div class="container mx-auto px-4">
        <div class="mb-10 max-w-4xl">
            <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#a47834]">{{ $project['audiences']['eyebrow'] }}</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold leading-tight tracking-[-0.04em] text-[#171411] sm:text-5xl">{{ $project['audiences']['h2'] }}</h2>
        </div>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
            @foreach($project['audiences']['items'] as $audience)
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

<section class="bg-[#fbf7ee] py-16 lg:py-24">
    <div class="container mx-auto px-4">
        <div class="mb-10 max-w-3xl">
            <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#a47834]">Le processus</div>
            <h2 class="font-display mt-3 text-3xl font-extrabold leading-tight tracking-[-0.04em] text-[#171411] sm:text-5xl">Un projet cadré, fabriqué, posé.</h2>
        </div>

        <div class="grid gap-4 lg:grid-cols-4">
            @foreach($project['process'] as $step)
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
    'eyebrow' => 'Réalisations projet',
    'title' => 'Quelques réalisations liées à ce type de projet.',
    'description' => 'Des ouvrages livrés par Maison216, filtrés selon le silo projet et les pages associées.',
])

<section class="bg-white py-16 lg:py-24">
    <div class="container mx-auto px-4">
        <div class="grid gap-10 lg:grid-cols-[0.7fr_1.3fr]">
            <div>
                <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#a47834]">Questions fréquentes</div>
                <h2 class="font-display mt-3 text-3xl font-extrabold leading-tight tracking-[-0.04em] text-[#171411] sm:text-5xl">Avant de lancer le projet.</h2>
            </div>
            <div class="space-y-3">
                @foreach($project['faqs'] as $faq)
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
            <h2 class="font-display text-3xl font-extrabold leading-tight tracking-[-0.04em] sm:text-5xl">{{ $project['finalCta']['h2'] }}</h2>
            <p class="mt-5 text-lg leading-8 text-white/72">{{ $project['finalCta']['subtitle'] }}</p>
            <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
                <a href="{{ $devisUrl }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#d5b170] px-8 py-4 text-sm font-extrabold text-[#171411] transition hover:bg-white">
                    <i class="fa-regular fa-pen-to-square"></i>
                    {{ $project['finalCta']['label'] }}
                </a>
                @isset($project['finalCta']['secondaryLabel'])
                    <a href="{{ $whatsappUrl }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-white/20 px-8 py-4 text-sm font-extrabold text-white transition hover:bg-white hover:text-[#171411]">
                        <i class="fa-brands fa-whatsapp"></i>
                        {{ $project['finalCta']['secondaryLabel'] }}
                    </a>
                @endisset
            </div>
        </div>
    </div>
</section>

<section class="bg-[#fbf7ee] py-14 lg:py-16">
    <div class="container mx-auto px-4">
        <div class="mb-7 max-w-3xl">
            <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#a47834]">Maillage interne</div>
            <h3 class="font-display mt-3 text-2xl font-extrabold text-[#171411] sm:text-3xl">Les pages utiles pour préparer votre devis.</h3>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @foreach($project['internalLinks'] as $link)
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
