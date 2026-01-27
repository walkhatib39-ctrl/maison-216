{{-- Nouveautés / New Arrivals Section --}}
@php
    $wh = \App\Models\Setting::get('contact.whatsapp');
    $whDigits = $wh ? preg_replace('/\D+/', '', (string)$wh) : null;
@endphp

<section id="nouveautes" class="py-12 lg:py-20 bg-white">
    <div class="container mx-auto px-4">
        {{-- Section Header --}}
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4 mb-10 lg:mb-12">
            <div>
                <span class="inline-block bg-primary-100 text-primary-700 text-sm font-semibold px-4 py-1.5 rounded-full mb-4">
                    Vient d'arriver
                </span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-dark-900 mb-3">
                    Nos <span class="text-primary-600">nouveautés</span>
                </h2>
                <p class="text-base lg:text-lg text-dark-600 max-w-xl">
                    Découvrez les dernières pièces ajoutées à notre collection
                </p>
            </div>
            
            @if($products->count() > 4)
                <a href="{{ route('search') }}" 
                   class="group inline-flex items-center gap-2 text-primary-600 hover:text-primary-700 font-semibold transition-colors duration-200">
                    <span>Voir tous les produits</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5-5 5M6 12h12"/>
                    </svg>
                </a>
            @endif
        </div>

        {{-- Products Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-6">
            @forelse($products->take(8) as $product)
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 overflow-hidden border border-dark-100">
                    {{-- Product Image --}}
                    <div class="relative overflow-hidden aspect-square bg-gradient-to-br from-dark-100 to-dark-200">
                        <a href="{{ route('product.show', $product->slug) }}" class="block w-full h-full">
                            @if($product->main_image)
                                <img src="{{ asset($product->main_image) }}"
                                     alt="{{ $product->title }}"
                                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-br from-primary-100 to-primary-200 items-center justify-center hidden">
                                    <svg class="w-12 h-12 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @else
                                <div class="absolute inset-0 bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </a>
                        
                        {{-- Quick Actions --}}
                        <div class="absolute top-3 right-3 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <button class="w-9 h-9 lg:w-10 lg:h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-lg hover:bg-white hover:scale-110 transition-all duration-200">
                                <svg class="w-4 h-4 lg:w-5 lg:h-5 text-dark-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                            </button>
                            <a href="{{ route('product.show', $product->slug) }}" 
                               class="w-9 h-9 lg:w-10 lg:h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-lg hover:bg-white hover:scale-110 transition-all duration-200">
                                <svg class="w-4 h-4 lg:w-5 lg:h-5 text-dark-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                        </div>
                        
                        {{-- NEW Badge --}}
                        <div class="absolute top-3 left-3">
                            <span class="bg-emerald-500 text-white text-xs font-bold px-2.5 py-1 rounded-full uppercase tracking-wide">
                                Nouveau
                            </span>
                        </div>
                        
                        {{-- Category Badge (Mobile visible, desktop on hover) --}}
                        @if($product->category)
                            <div class="absolute bottom-3 left-3 lg:opacity-0 lg:group-hover:opacity-100 transition-opacity duration-300">
                                <span class="bg-dark-900/80 backdrop-blur-sm text-white text-xs font-medium px-2.5 py-1 rounded-full">
                                    {{ $product->category->name }}
                                </span>
                            </div>
                        @endif
                    </div>
                    
                    {{-- Product Info --}}
                    <div class="p-4 lg:p-5">
                        <a href="{{ route('product.show', $product->slug) }}" 
                           class="block font-bold text-sm lg:text-base text-dark-900 hover:text-primary-700 transition-colors duration-200 mb-2 line-clamp-2 min-h-[2.5rem] lg:min-h-[3rem]">
                            {{ $product->title }}
                        </a>
                        
                        {{-- Price --}}
                        <div class="flex items-center gap-2 mb-4">
                            <span class="text-lg lg:text-xl font-bold text-primary-600">{{ $product->price_display }}</span>
                            @if($product->compare_at_display)
                                <span class="text-sm line-through text-dark-400">{{ $product->compare_at_display }}</span>
                            @endif
                        </div>
                        
                        {{-- Action Buttons --}}
                        <div class="flex gap-2">
                            <a href="{{ route('product.show', $product->slug) }}"
                               class="flex-1 bg-dark-100 hover:bg-dark-200 text-dark-800 font-semibold py-2.5 px-3 rounded-xl transition-colors duration-200 text-center text-xs lg:text-sm">
                                Détails
                            </a>
                            @if($whDigits)
                                @php
                                    $msg = rawurlencode("Bonjour, je suis intéressé(e) par: {$product->title} - " . url(route('product.show', $product->slug, false)));
                                @endphp
                                <a href="https://wa.me/{{ $whDigits }}?text={{ $msg }}"
                                   target="_blank" rel="noopener"
                                   class="flex-1 bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2.5 px-3 rounded-xl transition-colors duration-200 text-center text-xs lg:text-sm flex items-center justify-center gap-1.5">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.886 3.75"/>
                                    </svg>
                                    <span class="hidden sm:inline">Commander</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16">
                    <div class="w-20 h-20 bg-dark-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-dark-700 mb-2">Aucun produit disponible</h3>
                    <p class="text-dark-500">Les nouveaux produits seront bientôt disponibles.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
