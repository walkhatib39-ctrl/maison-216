@extends('layouts.store')

@section('content')
@php
    $gallery = collect([$product->main_image])
        ->merge($product->images->pluck('url'))
        ->filter()
        ->unique()
        ->map(fn ($url) => \Illuminate\Support\Str::startsWith($url, ['http://', 'https://']) ? $url : asset(ltrim($url, '/')))
        ->values();
    $mainImage = $gallery->first() ?: null;
    $primaryUrl = $product->isDirectlyOrderable()
        ? route('checkout.create', $product->slug)
        : url('/devis?produit=' . urlencode($product->slug));
@endphp

<section class="bg-[#fbf7f0]">
    <div class="container mx-auto px-4 py-10 lg:py-16">
        <nav class="mb-8 text-sm font-semibold text-[#7a6b5a]">
            <a href="{{ route('home') }}" class="hover:text-[#171411]">Accueil</a>
            <span class="mx-2 text-[#b88a3b]">›</span>
            <a href="{{ route('showroom.index') }}" class="hover:text-[#171411]">Showroom</a>
            @if($product->showroomActivities->first())
                <span class="mx-2 text-[#b88a3b]">›</span>
                <a href="{{ route('showroom.activity.show', $product->showroomActivities->first()) }}" class="hover:text-[#171411]">{{ $product->showroomActivities->first()->name }}</a>
            @endif
            <span class="mx-2 text-[#b88a3b]">›</span>
            <span class="text-[#171411]">{{ $product->title }}</span>
        </nav>

        <div class="grid gap-10 lg:grid-cols-[1.05fr_0.95fr] lg:items-start">
            <div class="order-1 lg:order-none">
                <div class="overflow-hidden rounded-[34px] border border-[#eadfce] bg-white p-3 shadow-[0_24px_70px_rgba(23,20,17,0.10)]">
                    @if($mainImage)
                        <img src="{{ $mainImage }}" alt="{{ $product->title }}" class="aspect-[4/3] w-full rounded-[26px] object-cover">
                    @else
                        <div class="flex aspect-[4/3] w-full items-center justify-center rounded-[26px] bg-[radial-gradient(circle_at_30%_20%,#f7ead3,#e7dac8)] text-[#a47834]">
                            <i class="fa-solid fa-couch text-6xl opacity-70"></i>
                        </div>
                    @endif
                </div>

                @if($gallery->count() > 1)
                    <div class="mt-4 grid grid-cols-4 gap-3">
                        @foreach($gallery->skip(1)->take(8) as $image)
                            <img src="{{ $image }}" alt="{{ $product->title }}" loading="lazy" class="aspect-square rounded-2xl border border-[#eadfce] object-cover">
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="order-2 lg:sticky lg:top-32">
                <div class="rounded-[34px] border border-[#eadfce] bg-white p-6 shadow-[0_24px_70px_rgba(23,20,17,0.08)] lg:p-8">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="rounded-full bg-[#f3e6cf] px-3 py-1.5 text-xs font-extrabold uppercase tracking-[0.14em] text-[#8e6322]">{{ $product->showroom_badge_label }}</span>
                        @if($product->showroomActivities->first())
                            <span class="rounded-full border border-[#eadfce] px-3 py-1.5 text-xs font-bold text-[#6b5c50]">{{ $product->showroomActivities->first()->name }}</span>
                        @endif
                    </div>

                    <h1 class="font-display mt-5 text-4xl font-extrabold leading-tight tracking-[-0.035em] text-[#171411] md:text-5xl">
                        {{ $product->title }}
                    </h1>

                    @if($product->short_description)
                        <p class="mt-5 text-base leading-8 text-[#5f5146]">{{ strip_tags($product->short_description) }}</p>
                    @endif

                    <div class="mt-6 rounded-[24px] bg-[#fbf7f0] p-5">
                        <div class="text-sm font-bold text-[#7a6b5a]">Prix</div>
                        <div class="mt-1 font-display text-3xl font-extrabold text-[#171411]">{{ $product->showroom_price_label }}</div>
                        @if($product->compare_at_display && !$product->isQuoteOnly())
                            <div class="mt-1 text-sm text-[#8f8276] line-through">{{ $product->compare_at_display }}</div>
                        @endif
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-3">
                        <a href="{{ $primaryUrl }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#171411] px-4 py-4 text-sm font-extrabold text-white transition hover:bg-[#b88a3b]">
                            <i class="fa-regular fa-pen-to-square text-xs"></i>
                            {{ $product->isDirectlyOrderable() ? 'Commander' : 'Devis' }}
                        </a>
                        @if($whatsappUrl)
                            <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center gap-2 rounded-full border border-[#d8c3a0] px-4 py-4 text-sm font-extrabold text-[#171411] transition hover:bg-[#fbf7f0]">
                                <i class="fa-brands fa-whatsapp text-xs"></i>
                                {{ $phone }}
                            </a>
                        @endif
                    </div>

                    <dl class="mt-7 grid gap-3 text-sm">
                        @foreach([
                            'Matériaux' => $product->material_summary,
                            'Dimensions' => $product->dimension_summary,
                            'Finitions' => $product->finish_summary,
                            'Disponibilité' => $product->availability_label,
                            'Livraison' => $product->delivery_note,
                        ] as $label => $value)
                            @if($value)
                                <div class="flex justify-between gap-4 rounded-2xl border border-[#efe3d3] px-4 py-3">
                                    <dt class="font-bold text-[#171411]">{{ $label }}</dt>
                                    <dd class="text-right text-[#62564b]">{{ $value }}</dd>
                                </div>
                            @endif
                        @endforeach
                    </dl>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-white py-12 lg:py-16">
    <div class="container mx-auto px-4">
        <div class="grid gap-8 lg:grid-cols-[1fr_0.8fr]">
            <div class="rounded-[30px] border border-[#eadfce] bg-[#fbf7f0] p-7 lg:p-9">
                <h2 class="font-display text-3xl font-extrabold text-[#171411]">Description</h2>
                <div class="prose prose-stone mt-5 max-w-none leading-8 text-[#5f5146]">
                    @if($product->long_description)
                        {!! $product->long_description !!}
                    @elseif($product->short_description)
                        <p>{{ strip_tags($product->short_description) }}</p>
                    @else
                        <p>Produit disponible dans le Showroom Maison216. Contactez-nous pour confirmer les dimensions, finitions et disponibilités.</p>
                    @endif
                </div>
            </div>

            <div class="rounded-[30px] border border-[#eadfce] bg-white p-7 shadow-[0_18px_50px_rgba(23,20,17,0.08)]">
                <h2 class="font-display text-2xl font-extrabold text-[#171411]">{{ $product->isDirectlyOrderable() ? 'Commande directe' : 'Demande sur devis' }}</h2>
                <p class="mt-4 text-sm leading-7 text-[#62564b]">
                    {{ $product->isDirectlyOrderable()
                        ? 'Ce produit peut être commandé directement. Nous vous contactons ensuite pour confirmer la disponibilité et la livraison.'
                        : 'Ce produit nécessite un chiffrage selon les dimensions, matériaux, finitions ou contraintes du projet.' }}
                </p>
                <a href="{{ $primaryUrl }}" class="mt-6 inline-flex w-full items-center justify-center rounded-full bg-[#171411] px-5 py-4 text-sm font-extrabold text-white transition hover:bg-[#b88a3b]">
                    {{ $product->isDirectlyOrderable() ? 'Commander maintenant' : 'Demander un devis' }}
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
