@php
    $imageUrl = $product->main_image_url;
    $activity = $product->showroomActivities->first();
    $detailsUrl = route('showroom.product.show', $product->slug);
    $primaryUrl = $product->isDirectlyOrderable()
        ? route('checkout.create', $product->slug)
        : url('/devis?produit=' . urlencode($product->slug));
@endphp

<article class="group overflow-hidden rounded-[28px] border border-[#eadfce] bg-white shadow-[0_20px_50px_rgba(23,20,17,0.08)] transition hover:-translate-y-1 hover:shadow-[0_24px_70px_rgba(23,20,17,0.14)]">
    <a href="{{ $detailsUrl }}" class="block">
        <div class="relative aspect-[4/3] overflow-hidden bg-[#e9dfcf]">
            @if($imageUrl)
                <img src="{{ $imageUrl }}" alt="{{ $product->title }}" loading="lazy" class="h-full w-full object-cover transition duration-700 group-hover:scale-105">
            @else
                <div class="flex h-full w-full items-center justify-center bg-[radial-gradient(circle_at_30%_20%,#f7ead3,#e7dac8)] text-[#a47834]">
                    <i class="fa-solid fa-couch text-4xl opacity-70"></i>
                </div>
            @endif

            <div class="absolute left-4 top-4 inline-flex items-center gap-2 rounded-full border border-white/45 bg-white/88 px-3 py-1.5 text-xs font-extrabold text-[#8e6322] shadow-sm backdrop-blur">
                {{ $product->showroom_badge_label }}
            </div>
        </div>
    </a>

    <div class="p-5">
        <div class="text-[11px] font-extrabold uppercase tracking-[0.18em] text-[#b88a3b]">
            {{ $activity?->name ?? $product->category?->name ?? 'Showroom' }}
        </div>
        <a href="{{ $detailsUrl }}" class="mt-2 block font-display text-xl font-extrabold leading-tight text-[#171411] transition hover:text-[#8e6322]">
            {{ $product->title }}
        </a>
        @if($product->short_description)
            <p class="mt-3 line-clamp-2 text-sm leading-6 text-[#62564b]">{{ strip_tags($product->short_description) }}</p>
        @endif

        <div class="mt-5 flex items-end justify-between gap-4">
            <div>
                <div class="text-lg font-extrabold text-[#171411]">{{ $product->showroom_price_label }}</div>
                @if($product->availability_label)
                    <div class="mt-1 text-xs font-bold text-[#7a6b5a]">{{ $product->availability_label }}</div>
                @endif
            </div>
            <a href="{{ $detailsUrl }}" class="shrink-0 text-sm font-extrabold text-[#8e6322]">
                Détails <i class="fa-solid fa-arrow-right ml-1 text-xs"></i>
            </a>
        </div>

        <div class="mt-5 grid grid-cols-2 gap-2">
            <a href="{{ $detailsUrl }}" class="inline-flex items-center justify-center rounded-full border border-[#d9c7aa] px-4 py-3 text-sm font-extrabold text-[#171411] transition hover:bg-[#fbf7f0]">
                Voir détails
            </a>
            <a href="{{ $primaryUrl }}" class="inline-flex items-center justify-center rounded-full bg-[#171411] px-4 py-3 text-sm font-extrabold text-white transition hover:bg-[#b88a3b]">
                {{ $product->isDirectlyOrderable() ? 'Commander' : 'Demander un devis' }}
            </a>
        </div>
    </div>
</article>
