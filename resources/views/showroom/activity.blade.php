@extends('layouts.store')

@section('content')
<section class="border-b border-[#eadfce] bg-[#fbf7f0]">
    <div class="container mx-auto px-4 py-12 lg:py-16">
        <nav class="mb-8 text-sm font-semibold text-[#7a6b5a]">
            <a href="{{ route('home') }}" class="hover:text-[#171411]">Accueil</a>
            <span class="mx-2 text-[#b88a3b]">›</span>
            <a href="{{ route('showroom.index') }}" class="hover:text-[#171411]">Showroom</a>
            <span class="mx-2 text-[#b88a3b]">›</span>
            <span class="text-[#171411]">{{ $activity->name }}</span>
        </nav>

        <div class="max-w-4xl">
            <h1 class="font-display text-5xl font-extrabold leading-tight tracking-[-0.04em] text-[#171411] md:text-6xl">
                {{ $activity->name }}
            </h1>
            @if($activity->headline || $activity->description)
                <p class="mt-6 max-w-3xl text-lg leading-9 text-[#5f5146]">{{ $activity->headline ?: $activity->description }}</p>
            @endif
        </div>
    </div>
</section>

<section class="bg-white py-8">
    <div class="container mx-auto px-4">
        <form method="get" class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex max-w-full gap-2 overflow-x-auto pb-1 scrollbar-hide">
                @foreach([
                    'all' => 'Tous',
                    'commandable' => 'Commandables',
                    'sur-devis' => 'Sur devis',
                ] as $value => $label)
                    <a href="{{ route('showroom.activity.show', ['activity' => $activity, 'vente' => $value]) }}"
                       class="inline-flex shrink-0 rounded-full border px-4 py-2.5 text-sm font-extrabold {{ $saleType === $value ? 'border-[#171411] bg-[#171411] text-white' : 'border-[#d8c3a0] bg-[#fbf7f0] text-[#171411]' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            <div class="flex gap-2">
                <input name="q" value="{{ $search }}" type="search" placeholder="Rechercher un produit..."
                       class="min-w-0 rounded-full border border-[#d8c3a0] bg-white px-5 py-3 text-sm focus:border-[#b88a3b] focus:ring-0 sm:w-80">
                <input type="hidden" name="vente" value="{{ $saleType }}">
                <button class="rounded-full bg-[#171411] px-5 py-3 text-sm font-extrabold text-white">Filtrer</button>
            </div>
        </form>
    </div>
</section>

<section class="bg-[#fbf7f0] py-12 lg:py-16">
    <div class="container mx-auto px-4">
        @if($products->isNotEmpty())
            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach($products as $product)
                    @include('showroom._product-card', ['product' => $product])
                @endforeach
            </div>

            <div class="mt-10">
                {{ $products->links() }}
            </div>
        @else
            <div class="rounded-[30px] border border-dashed border-[#d8c3a0] bg-white p-10 text-center">
                <div class="font-display text-2xl font-extrabold text-[#171411]">Aucun produit publié pour cette activité.</div>
                <p class="mx-auto mt-3 max-w-xl text-sm leading-7 text-[#62564b]">Ajoutez un produit dans l’admin et assignez-le à cette activité Showroom.</p>
                <a href="{{ url('/devis') }}" class="mt-6 inline-flex rounded-full bg-[#171411] px-5 py-3 text-sm font-extrabold text-white">Demander une solution sur mesure</a>
            </div>
        @endif
    </div>
</section>
@endsection
