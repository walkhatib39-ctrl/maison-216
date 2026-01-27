@extends('layouts.store')

@section('content')
    <section class="py-12 lg:py-20 bg-gradient-to-b from-white to-dark-50/30">
        <div class="container mx-auto px-4">
            <div class="text-center mb-8 lg:mb-12">
                <span class="inline-block bg-primary-100 text-primary-700 text-sm font-semibold px-4 py-1.5 rounded-full mb-4">
                    Recherche
                </span>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-dark-900 mb-4">
                    @if(($q ?? '') !== '')
                        R&eacute;sultats pour <span class="text-primary-600">&ldquo;{{ $q }}&rdquo;</span>
                    @else
                        Tous les <span class="text-primary-600">produits</span>
                    @endif
                </h1>
                <p class="text-base lg:text-lg text-dark-600 max-w-2xl mx-auto">
                    @if(($q ?? '') !== '')
                        {{ $products->total() }} produit(s) trouv&eacute;(s).
                    @else
                        D&eacute;couvrez toute notre s&eacute;lection.
                    @endif
                </p>
            </div>

            <form action="{{ route('search') }}" method="get" class="max-w-2xl mx-auto mb-10">
                <div class="flex gap-2">
                    <input name="q" type="search"
                           value="{{ $q }}"
                           placeholder="Rechercher un produit..."
                           class="flex-1 px-4 py-3 border-2 border-dark-200 rounded-xl bg-white focus:border-primary-500 focus:ring-0 transition-colors" />
                    <button type="submit"
                            class="px-6 py-3 bg-primary-600 text-white font-semibold rounded-xl hover:bg-primary-700 transition-colors shadow-lg">
                        Rechercher
                    </button>
                </div>
            </form>

            @if($products->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($products as $product)
                        <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 overflow-hidden border border-dark-100">
                            <div class="relative overflow-hidden">
                                <a href="{{ route('product.show', $product->slug) }}" class="block">
                                    <img src="{{ $product->main_image ? asset($product->main_image) : ($product->images->first() ? asset($product->images->first()->url) : 'https://images.unsplash.com/photo-1493663284031-b7e3aefcae8e?q=80&w=1200&auto=format&fit=crop') }}"
                                         alt="{{ $product->title }}"
                                         class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500"
                                         loading="lazy" />
                                </a>
                            </div>

                            <div class="p-6">
                                <a href="{{ route('product.show', $product->slug) }}"
                                   class="block font-bold text-lg text-dark-900 hover:text-primary-700 transition-colors duration-200 mb-2 line-clamp-2">
                                    {{ $product->title }}
                                </a>

                                @if($product->category)
                                    <div class="text-xs text-dark-500 mb-2">{{ $product->category->name }}</div>
                                @endif

                                <div class="flex items-center gap-3 mb-4">
                                    <span class="text-2xl font-bold text-primary-600">{{ $product->price_display }}</span>
                                    @if($product->compare_at_display)
                                        <span class="text-lg line-through text-dark-400">{{ $product->compare_at_display }}</span>
                                    @endif
                                </div>

                                <a href="{{ route('product.show', $product->slug) }}"
                                   class="w-full inline-flex items-center justify-center gap-2 bg-dark-100 hover:bg-dark-200 text-dark-800 font-semibold py-3 px-4 rounded-xl transition-colors duration-200 text-center text-sm">
                                    Voir le produit
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5-5 5M6 12h12"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <div class="w-20 h-20 bg-dark-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-dark-700 mb-2">Aucun r&eacute;sultat</h3>
                    <p class="text-dark-500">Essayez avec un autre mot-cl&eacute;.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
