{{-- Category Spotlight: Salle à Manger --}}
@if($products->count() > 0)
<section class="py-12 lg:py-20 bg-white">
    <div class="container mx-auto px-4">
        {{-- Section Header --}}
        <div class="text-center mb-10 lg:mb-12">
            <span class="inline-block bg-emerald-100 text-emerald-700 text-sm font-semibold px-4 py-1.5 rounded-full mb-4">
                🍽️ Collection Salle à Manger
            </span>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-dark-900 mb-3">
                Salle à <span class="text-primary-600">Manger</span>
            </h2>
            <p class="text-base lg:text-lg text-dark-600 max-w-2xl mx-auto">
                Tables, chaises et buffets pour des repas conviviaux en famille. 
                Design moderne ou classique selon vos goûts.
            </p>
        </div>
        
        {{-- Products Carousel --}}
        <div class="relative" x-data="{ scrollContainer: null }" x-init="scrollContainer = $refs.container">
            {{-- Desktop: Static Grid / Mobile: Carousel --}}
            <div x-ref="container" 
                 class="flex lg:grid lg:grid-cols-3 gap-6 overflow-x-auto lg:overflow-visible scrollbar-hide pb-4 lg:pb-0 snap-x snap-mandatory lg:snap-none -mx-4 px-4 lg:mx-0 lg:px-0">
                @foreach($products->take(3) as $product)
                    <div class="flex-shrink-0 w-[85%] sm:w-[60%] lg:w-auto snap-start">
                        <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl overflow-hidden border border-dark-100 transition-all duration-300 hover:-translate-y-2">
                            {{-- Product Image --}}
                            <div class="relative overflow-hidden">
                                <a href="{{ route('product.show', $product->slug) }}" class="block">
                                    <img src="{{ isset($product->main_image) ? asset($product->main_image) : 'https://images.unsplash.com/photo-1617806118233-18e1de247200?q=80&w=800&auto=format&fit=crop' }}"
                                         alt="{{ $product->title }}"
                                         class="w-full aspect-[4/3] object-cover group-hover:scale-110 transition-transform duration-500">
                                </a>
                                
                                {{-- Category Badge --}}
                                <div class="absolute top-4 left-4">
                                    <span class="bg-emerald-500 text-white text-xs font-bold px-3 py-1.5 rounded-full">
                                        Salle à manger
                                    </span>
                                </div>
                            </div>
                            
                            {{-- Product Info --}}
                            <div class="p-5 lg:p-6">
                                <a href="{{ route('product.show', $product->slug) }}" 
                                   class="block font-bold text-lg text-dark-900 hover:text-primary-700 transition-colors duration-200 mb-3 line-clamp-2">
                                    {{ $product->title }}
                                </a>
                                
                                {{-- Price & CTA --}}
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="text-2xl font-bold text-primary-600">{{ $product->price_display }}</span>
                                        @if($product->compare_at_display)
                                            <span class="block text-sm line-through text-dark-400">{{ $product->compare_at_display }}</span>
                                        @endif
                                    </div>
                                    <a href="{{ route('product.show', $product->slug) }}"
                                       class="w-12 h-12 bg-dark-900 hover:bg-primary-600 rounded-xl flex items-center justify-center transition-colors duration-200 group/btn">
                                        <svg class="w-5 h-5 text-white group-hover/btn:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5-5 5M6 12h12"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            {{-- Mobile Scroll Indicator --}}
            <div class="flex justify-center gap-2 mt-4 lg:hidden">
                @foreach($products->take(3) as $index => $product)
                    <div class="w-2 h-2 rounded-full bg-dark-300"></div>
                @endforeach
            </div>
        </div>
        
        {{-- View All Button --}}
        <div class="text-center mt-10">
            <a href="{{ route('category.show', 'salles-a-manger-completes') }}" 
               class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-8 py-4 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                Voir toute la collection
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5-5 5M6 12h12"/>
                </svg>
            </a>
        </div>
    </div>
</section>
@endif
