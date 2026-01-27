{{-- Category Spotlight: Salon & Séjour --}}
@php
    $wh = \App\Models\Setting::get('contact.whatsapp');
    $whDigits = $wh ? preg_replace('/\D+/', '', (string)$wh) : null;
@endphp

@if($products->count() > 0)
<section class="py-12 lg:py-20 bg-white overflow-hidden">
    <div class="container mx-auto px-4">
        <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-center">
            {{-- Image Side --}}
            <div class="relative order-2 lg:order-1">
                <div class="relative z-10">
                    <div class="aspect-[4/3] rounded-2xl overflow-hidden shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1555041469-a586c61ea9bc?q=80&w=1200&auto=format&fit=crop" 
                             alt="Salon moderne - Meubles Tunisie"
                             class="w-full h-full object-cover hover:scale-105 transition-transform duration-700"
                             loading="lazy">
                    </div>
                    
                    {{-- Floating Card --}}
                    <div class="absolute -bottom-4 -right-4 lg:-bottom-6 lg:-right-6 bg-white rounded-xl shadow-xl p-4 lg:p-5 max-w-[200px]">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14"/>
                                </svg>
                            </div>
                            <div>
                                <div class="font-bold text-dark-900">+50 modèles</div>
                                <div class="text-xs text-dark-500">En stock</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Decorative Elements --}}
                <div class="absolute top-8 -left-8 w-32 h-32 bg-primary-100 rounded-full -z-10"></div>
                <div class="absolute -bottom-8 left-1/4 w-20 h-20 bg-primary-200 rounded-full -z-10"></div>
            </div>
            
            {{-- Content Side --}}
            <div class="order-1 lg:order-2">
                <span class="inline-block bg-primary-100 text-primary-700 text-sm font-semibold px-4 py-1.5 rounded-full mb-4">
                    🛋️ Collection Salon
                </span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-dark-900 mb-4">
                    Salon & <span class="text-primary-600">Séjour</span>
                </h2>
                <p class="text-base lg:text-lg text-dark-600 mb-8 leading-relaxed">
                    Créez un espace de vie chaleureux avec notre collection de canapés, fauteuils et meubles TV. 
                    Design moderne et confort optimal pour toute la famille.
                </p>
                
                {{-- Product Quick List --}}
                <div class="space-y-4 mb-8">
                    @foreach($products->take(3) as $product)
                        <a href="{{ route('product.show', $product->slug) }}" 
                           class="flex items-center gap-4 p-3 rounded-xl hover:bg-dark-50 transition-colors duration-200 group">
                            <img src="{{ isset($product->main_image) ? asset($product->main_image) : 'https://via.placeholder.com/80' }}"
                                 alt="{{ $product->title }}"
                                 class="w-16 h-16 lg:w-20 lg:h-20 rounded-xl object-cover flex-shrink-0 group-hover:scale-105 transition-transform duration-200">
                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-dark-900 group-hover:text-primary-700 transition-colors line-clamp-1">
                                    {{ $product->title }}
                                </div>
                                <div class="text-lg font-bold text-primary-600">{{ $product->price_display }}</div>
                            </div>
                            <svg class="w-5 h-5 text-dark-400 group-hover:text-primary-600 group-hover:translate-x-1 transition-all duration-200 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    @endforeach
                </div>
                
                {{-- CTA Button --}}
                <a href="{{ route('category.show', 'salons-complets') }}" 
                   class="inline-flex items-center gap-2 bg-dark-900 hover:bg-dark-800 text-white font-semibold px-6 py-3 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                    Explorer la collection Salon
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5-5 5M6 12h12"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>
@endif
