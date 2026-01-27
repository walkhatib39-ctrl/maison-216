{{-- Categories Grid Section --}}
@php
    // Category icons mapping
    $categoryIcons = [
        'salon-sejour' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>',
        'chambre' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>',
        'salle-a-manger' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>',
        'cuisine' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z"/>',
    ];
    
    // Function to get category image from first product
    function getCategoryImage($category) {
        // Try to get an image from the category's products
        $product = \App\Models\Product::where('category_id', $category->id)
            ->whereNotNull('main_image')
            ->where('main_image', '!=', '')
            ->first();
        
        if ($product && $product->main_image) {
            return $product->main_image;
        }
        
        // Try children categories
        foreach ($category->children as $child) {
            $childProduct = \App\Models\Product::where('category_id', $child->id)
                ->whereNotNull('main_image')
                ->where('main_image', '!=', '')
                ->first();
            if ($childProduct && $childProduct->main_image) {
                return $childProduct->main_image;
            }
        }
        
        return null;
    }
@endphp


@if($categories->count())
<section class="py-12 lg:py-20 bg-gradient-to-b from-white to-dark-50/30">
    <div class="container mx-auto px-4">
        {{-- Section Header --}}
        <div class="text-center mb-10 lg:mb-14">
            <span class="inline-block bg-primary-100 text-primary-700 text-sm font-semibold px-4 py-1.5 rounded-full mb-4">
                Nos Collections
            </span>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-dark-900 mb-4">
                Explorez par <span class="text-primary-600">catégorie</span>
            </h2>
            <p class="text-base lg:text-lg text-dark-600 max-w-2xl mx-auto">
                Découvrez notre gamme complète de meubles et accessoires pour chaque pièce de votre maison
            </p>
        </div>
        
        {{-- Categories list to display --}}
        @php
            // Custom images mapping
            $customImages = [
                'lits' => 'images/lit-banquette-gigogne-thomas-200cm-avec-tiroirs-et-lit-d-appoint-white-wash/main.jpg',
                'armoires' => 'images/etagere-dallas-2-blanc/main.jpg',
                'bureaux' => 'images/coiffeuse-sweet-avec-miroir-chene-blanc/main.jpg',
                'tables' => 'images/table-basse-square-67x67-blanc-chene/main.jpg',
                'meubles-d-assises' => 'images/canape-lit-lena-blanc/main.jpg',
                'meubles-tv' => 'images/meuble-tv-wina-136cm-chene/main.jpg'
            ];
        @endphp

        {{-- Categories Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4 lg:gap-6">
            @foreach($categories as $index => $cat)
                <a href="{{ route('category.show', $cat->slug) }}"
                   class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 overflow-hidden border border-dark-100">
                    
                    {{-- Category Image --}}
                    <div class="aspect-[4/3] bg-gradient-to-br from-primary-100 to-primary-200 relative overflow-hidden">
                        @php 
                            // Priorité: Image personnalisée > Image dynamique > Placeholder
                            $catImage = $cat->featured_image ?: ($customImages[$cat->slug] ?? getCategoryImage($cat));
                        @endphp
                        
                        @if($catImage)
                            <img src="{{ asset($catImage) }}" 
                                 alt="{{ $cat->name }} - Meubles Tunisie"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            {{-- Gradient placeholder when no image --}}
                            <div class="w-full h-full bg-gradient-to-br from-primary-200 via-primary-300 to-primary-400 flex items-center justify-center">
                                <svg class="w-16 h-16 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    {!! $categoryIcons[$cat->slug] ?? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>' !!}
                                </svg>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-dark-900/70 via-dark-900/20 to-transparent"></div>
                        
                        {{-- Category Icon --}}
                        <div class="absolute top-3 right-3 lg:top-4 lg:right-4 w-10 h-10 lg:w-12 lg:h-12 bg-white/90 backdrop-blur-sm rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-5 h-5 lg:w-6 lg:h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {!! $categoryIcons[$cat->slug] ?? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>' !!}
                            </svg>
                        </div>
                        
                        {{-- Products Count Badge --}}
                        @if($cat->total_products_count > 0)
                            <div class="absolute top-3 left-3 lg:top-4 lg:left-4 bg-primary-600 text-white text-xs font-bold px-2.5 py-1 rounded-full">
                                {{ $cat->total_products_count }} produits
                            </div>
                        @endif
                    </div>
                    
                    {{-- Category Content --}}
                    <div class="absolute bottom-0 left-0 right-0 p-4 lg:p-6 text-white">
                        <h3 class="text-lg lg:text-xl font-bold mb-1 group-hover:text-primary-300 transition-colors duration-200">
                            {{ $cat->name }}
                        </h3>
                        
                        @if($cat->children->count())
                            <p class="text-xs lg:text-sm text-white/80 line-clamp-1 mb-2">
                                {{ $cat->children->pluck('name')->take(3)->join(' • ') }}
                            </p>
                        @endif
                        
                        <div class="flex items-center gap-2 text-primary-300 font-semibold text-sm opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <span>Explorer</span>
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5-5 5M6 12h12"/>
                            </svg>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        
        {{-- View All Categories Button --}}
        <div class="text-center mt-10">
            <a href="{{ route('categories.index') }}"
               class="inline-flex items-center gap-2 bg-dark-900 hover:bg-dark-800 text-white font-semibold px-8 py-4 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                Voir toutes les catégories
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5-5 5M6 12h12"/>
                </svg>
            </a>
        </div>
    </div>
</section>
@endif
