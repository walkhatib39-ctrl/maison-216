@php
    $items = collect($realizations ?? []);
    $dark = ($theme ?? 'light') === 'dark';
    $sectionClasses = $dark ? 'bg-[#171411] text-white' : 'bg-white text-[#171411]';
    $eyebrowClasses = $dark ? 'text-[#d5b170]' : 'text-[#a47834]';
    $headingClasses = $dark ? 'text-white' : 'text-[#171411]';
    $bodyClasses = $dark ? 'text-white/72' : 'text-[#5f5146]';
@endphp

@if($items->isNotEmpty())
    <section class="{{ $sectionClasses }} py-16 lg:py-20">
        <div class="container mx-auto px-4">
            <div class="mb-9 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-3xl">
                    <div class="text-xs font-extrabold uppercase tracking-[0.22em] {{ $eyebrowClasses }}">{{ $eyebrow ?? 'Réalisations' }}</div>
                    <h2 class="font-display mt-3 text-3xl font-extrabold leading-tight tracking-[-0.04em] {{ $headingClasses }} sm:text-5xl">{{ $title ?? 'Quelques réalisations récentes.' }}</h2>
                    @isset($description)
                        <p class="mt-4 text-base leading-8 {{ $bodyClasses }}">{{ $description }}</p>
                    @endisset
                </div>
                @isset($linkHref)
                    <a href="{{ $linkHref }}" class="inline-flex items-center gap-2 text-sm font-extrabold {{ $dark ? 'text-[#d5b170]' : 'text-[#8e6322]' }}">
                        {{ $linkLabel ?? 'Voir toutes les réalisations' }}
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                @endisset
            </div>

            <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                @foreach($items as $realization)
                    <a href="{{ $realization['url'] }}" class="group relative min-h-[320px] overflow-hidden rounded-[34px] bg-cover bg-center p-6 shadow-[0_20px_65px_rgba(23,20,17,0.12)] transition hover:-translate-y-1 hover:shadow-[0_28px_80px_rgba(23,20,17,0.18)]" style="background-image: linear-gradient(180deg, rgba(23,20,17,0.04), rgba(23,20,17,0.84)), url('{{ $realization['image'] }}');">
                        <div class="relative z-10 flex h-full flex-col justify-between">
                            <span class="inline-flex w-max rounded-full border border-white/15 bg-white/10 px-3 py-1 text-xs font-bold text-[#e7c98d] backdrop-blur">{{ $realization['place'] }}</span>
                            <div class="text-white">
                                <h3 class="font-display text-2xl font-extrabold">{{ $realization['title'] }}</h3>
                                <p class="mt-2 text-sm leading-6 text-white/78">{{ $realization['copy'] }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endif
