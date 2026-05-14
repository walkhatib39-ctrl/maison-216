@extends('layouts.store')

@section('content')
<section class="bg-[#fbf7f0]">
    <div class="container mx-auto px-4 py-14 lg:py-20">
        <div class="grid items-center gap-10 lg:grid-cols-[0.95fr_1.05fr]">
            <div>
                <h1 class="font-display max-w-4xl text-5xl font-extrabold leading-[0.98] tracking-[-0.04em] text-[#171411] md:text-6xl lg:text-7xl">
                    Le Showroom Maison216.
                </h1>
                <p class="mt-6 max-w-2xl text-lg leading-9 text-[#5f5146]">
                    Produits, modèles et solutions d’aménagement en bois, aluminium et métal pour commerces, espaces professionnels et projets sur mesure.
                </p>
                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <a href="#activites" class="inline-flex items-center justify-center rounded-full bg-[#171411] px-6 py-4 text-sm font-extrabold text-white transition hover:bg-[#b88a3b]">
                        Explorer par activité
                    </a>
                    <a href="{{ url('/devis') }}" class="inline-flex items-center justify-center rounded-full border border-[#d6c1a0] bg-white px-6 py-4 text-sm font-extrabold text-[#171411] transition hover:border-[#b88a3b]">
                        Demander un devis
                    </a>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div class="rounded-[34px] bg-[#171411] p-7 text-white shadow-[0_30px_80px_rgba(23,20,17,0.18)]">
                    <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#d5b170]">Commandable</div>
                    <p class="mt-4 font-display text-3xl font-extrabold leading-tight">Produits standards avec prix et commande directe.</p>
                </div>
                <div class="rounded-[34px] border border-[#e6d6bf] bg-white p-7 shadow-[0_20px_60px_rgba(23,20,17,0.08)]">
                    <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#b88a3b]">Sur devis</div>
                    <p class="mt-4 font-display text-3xl font-extrabold leading-tight text-[#171411]">Solutions sur mesure avec dimensions, plans et options.</p>
                </div>
                <div class="rounded-[34px] border border-[#e6d6bf] bg-white p-7 shadow-[0_20px_60px_rgba(23,20,17,0.08)] sm:col-span-2">
                    <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#b88a3b]">Packs métier</div>
                    <p class="mt-4 text-lg leading-8 text-[#5f5146]">Parapharmacie, café, boutique, cabinet médical, bureau ou hôtel : chaque activité a ses produits et ses solutions prêtes à chiffrer.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="activites" class="bg-white py-14 lg:py-18">
    <div class="container mx-auto px-4">
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#b88a3b]">Activités professionnelles</div>
                <h2 class="font-display mt-3 max-w-3xl text-4xl font-extrabold tracking-[-0.03em] text-[#171411] md:text-5xl">Choisissez votre activité, puis les solutions adaptées.</h2>
            </div>
            <a href="{{ url('/devis') }}" class="inline-flex w-fit items-center gap-2 rounded-full border border-[#d8c3a0] px-5 py-3 text-sm font-extrabold text-[#171411] transition hover:bg-[#fbf7f0]">
                Projet complet <i class="fa-solid fa-arrow-right text-xs text-[#b88a3b]"></i>
            </a>
        </div>

        <div class="mt-10 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            @foreach($activities as $activity)
                <a href="{{ route('showroom.activity.show', $activity) }}" class="group rounded-[28px] border border-[#eadfce] bg-[#fbf7f0] p-6 transition hover:-translate-y-1 hover:bg-white hover:shadow-[0_22px_60px_rgba(23,20,17,0.10)]">
                    <div class="flex items-start justify-between gap-4">
                        <div class="font-display text-xl font-extrabold leading-tight text-[#171411]">{{ $activity->name }}</div>
                        <span class="rounded-full bg-white px-3 py-1 text-xs font-extrabold text-[#8e6322]">{{ $activity->products_count }}</span>
                    </div>
                    <p class="mt-4 line-clamp-3 text-sm leading-7 text-[#62564b]">{{ $activity->headline ?: $activity->description }}</p>
                    <div class="mt-6 text-sm font-extrabold text-[#8e6322]">Voir les produits <i class="fa-solid fa-arrow-right ml-1 text-xs transition group-hover:translate-x-1"></i></div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-[#fbf7f0] py-14 lg:py-18">
    <div class="container mx-auto px-4">
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <div class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#b88a3b]">Produits récents</div>
                <h2 class="font-display mt-3 text-4xl font-extrabold tracking-[-0.03em] text-[#171411] md:text-5xl">Standards, sur mesure et packs.</h2>
            </div>
        </div>

        @if($products->isNotEmpty())
            <div class="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach($products as $product)
                    @include('showroom._product-card', ['product' => $product])
                @endforeach
            </div>
        @else
            <div class="mt-10 rounded-[30px] border border-dashed border-[#d8c3a0] bg-white p-10 text-center">
                <div class="font-display text-2xl font-extrabold text-[#171411]">Le Showroom est prêt.</div>
                <p class="mx-auto mt-3 max-w-xl text-sm leading-7 text-[#62564b]">Ajoutez des produits dans l’admin, assignez-les à une activité professionnelle, puis publiez-les ici.</p>
                <a href="{{ url('/devis') }}" class="mt-6 inline-flex rounded-full bg-[#171411] px-5 py-3 text-sm font-extrabold text-white">Demander une solution</a>
            </div>
        @endif
    </div>
</section>
@endsection
