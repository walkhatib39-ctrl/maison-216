{{-- Best Sellers Section --}}
@php
    $wh = \App\Models\Setting::get('contact.whatsapp');
    $whDigits = $wh ? preg_replace('/\D+/', '', (string)$wh) : null;
@endphp

@if($products->count() > 0)
<section class="py-12 lg:py-20 bg-gradient-to-b from-dark-50/50 to-white">
    <div class="container mx-auto px-4">
        {{-- Section Header --}}
        <div class="text-center mb-10 lg:mb-12">
            <span class="inline-block bg-amber-100 text-amber-700 text-sm font-semibold px-4 py-1.5 rounded-full mb-4">
                ⭐ Top Ventes
            </span>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-dark-900 mb-3">
                Nos <span class="text-primary-600">best-sellers</span>
            </h2>
            <p class="text-base lg:text-lg text-dark-600 max-w-2xl mx-auto">
                Les meubles préférés de nos clients tunisiens
            </p>
        </div>

        {{-- Products Carousel (Mobile) / Grid (Desktop) --}}
        <div class="relative">
            {{-- Desktop Grid --}}
            <div class="hidden lg:grid lg:grid-cols-4 gap-6">
                @foreach($products->take(4) as $product)
                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 overflow-hidden border border-dark-100">
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
                            
                            {{-- Best Seller Badge --}}
                            <div class="absolute top-3 left-3">
                                <span class="bg-gradient-to-r from-amber-500 to-orange-500 text-white text-xs font-bold px-3 py-1.5 rounded-full flex items-center gap-1.5 shadow-lg">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    Best-seller
                                </span>
                            </div>
                            
                            {{-- Discount Badge --}}
                            @if($product->compare_at_millimes && $product->compare_at_millimes > $product->price_millimes)
                                @php
                                    $discount = round((($product->compare_at_millimes - $product->price_millimes) / $product->compare_at_millimes) * 100);
                                @endphp
                                <div class="absolute top-3 right-3">
                                    <span class="bg-red-500 text-white text-xs font-bold px-2.5 py-1 rounded-full">
                                        -{{ $discount }}%
                                    </span>
                                </div>
                            @endif
                        </div>
                        
                        {{-- Product Info --}}
                        <div class="p-5">
                            <a href="{{ route('product.show', $product->slug) }}" 
                               class="block font-bold text-base text-dark-900 hover:text-primary-700 transition-colors duration-200 mb-2 line-clamp-2 min-h-[3rem]">
                                {{ $product->title }}
                            </a>
                            
                            {{-- Price --}}
                            <div class="flex items-center gap-2 mb-4">
                                <span class="text-xl font-bold text-primary-600">{{ $product->price_display }}</span>
                                @if($product->compare_at_display)
                                    <span class="text-sm line-through text-dark-400">{{ $product->compare_at_display }}</span>
                                @endif
                            </div>
                            
                            {{-- CTA Button --}}
                            @if($whDigits)
                                @php
                                    $msg = rawurlencode("Bonjour, je suis intéressé(e) par ce best-seller: {$product->title} - " . url(route('product.show', $product->slug, false)));
                                @endphp
                                <a href="https://wa.me/{{ $whDigits }}?text={{ $msg }}"
                                   target="_blank" rel="noopener"
                                   class="w-full flex items-center justify-center gap-2 bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 px-4 rounded-xl transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.886 3.75"/>
                                    </svg>
                                    Commander maintenant
                                </a>
                            @else
                                <a href="{{ route('product.show', $product->slug) }}"
                                   class="w-full flex items-center justify-center gap-2 bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 px-4 rounded-xl transition-colors duration-200">
                                    Voir le produit
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5-5 5M6 12h12"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            
            {{-- Mobile Horizontal Scroll --}}
            <div class="lg:hidden -mx-4 px-4">
                <div class="flex gap-4 overflow-x-auto scrollbar-hide pb-4 snap-x snap-mandatory">
                    @foreach($products->take(4) as $product)
                        <div class="flex-shrink-0 w-[75%] sm:w-[45%] snap-start">
                            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-dark-100 h-full">
                                <div class="relative bg-gradient-to-br from-dark-100 to-dark-200">
                                    <a href="{{ route('product.show', $product->slug) }}" class="block">
                                        @if($product->main_image)
                                            <img src="{{ asset($product->main_image) }}"
                                                 alt="{{ $product->title }}"
                                                 class="w-full aspect-square object-cover">
                                        @else
                                            <div class="w-full aspect-square bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                                                <svg class="w-10 h-10 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </a>
                                    <div class="absolute top-3 left-3">
                                        <span class="bg-gradient-to-r from-amber-500 to-orange-500 text-white text-xs font-bold px-2.5 py-1 rounded-full">
                                            ⭐ Best-seller
                                        </span>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <a href="{{ route('product.show', $product->slug) }}" 
                                       class="block font-bold text-sm text-dark-900 mb-2 line-clamp-2">
                                        {{ $product->title }}
                                    </a>
                                    <span class="text-lg font-bold text-primary-600">{{ $product->price_display }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif
