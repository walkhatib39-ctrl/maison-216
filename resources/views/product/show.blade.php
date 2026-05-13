@extends('layouts.store')

@section('content')
@push('head')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => array_values(array_filter([
        [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'Accueil',
            'item' => url(route('home', [], false)),
        ],
        $product->category ? [
            '@type' => 'ListItem',
            'position' => 2,
            'name' => $product->category->name,
            'item' => url(route('category.show', $product->category->slug, false)),
        ] : null,
        [
            '@type' => 'ListItem',
            'position' => $product->category ? 3 : 2,
            'name' => $product->title,
            'item' => url()->current(),
        ],
    ])),
], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) !!}
</script>
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Product',
    'name' => $product->title,
    'image' => array_values(array_filter(array_unique(array_merge(
        [$product->main_image],
        $product->images->pluck('url')->toArray()
    )))),
    'description' => $product->short_description ? strip_tags($product->short_description) : ($product->long_description ? strip_tags($product->long_description) : $product->title),
    'sku' => $product->sku,
    'brand' => $product->brand,
    'category' => $product->category?->name,
    'offers' => [
        '@type' => 'Offer',
        'priceCurrency' => 'TND',
        'price' => $product->price_dinars,
        'availability' => $product->inStock() ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
        'url' => url()->current(),
    ],
], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) !!}
</script>
@endpush
@php
    $shippingFeeDt = (int) floor((\App\Models\Setting::get('shipping.fee_millimes', 20000) ?? 20000) / 1000);
    $wh = \App\Models\Setting::get('contact.whatsapp');
    $whDigits = $wh ? preg_replace('/\D+/', '', (string)$wh) : null;
    $ms = \App\Models\Setting::get('contact.messenger');
@endphp

<!-- Breadcrumb Premium -->
<section class="bg-gradient-to-r from-primary-50 to-primary-100/50 border-b border-primary-200">
    <div class="container mx-auto px-4 py-6">
        <nav class="flex items-center gap-2 text-sm" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="text-primary-600 hover:text-primary-800 font-medium transition-colors duration-200">
                <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                </svg>
                Accueil
            </a>
            @if($product->category)
                <svg class="w-4 h-4 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <a href="{{ route('category.show', $product->category->slug) }}" class="text-primary-600 hover:text-primary-800 font-medium transition-colors duration-200">
                    {{ $product->category->name }}
                </a>
            @endif
            <svg class="w-4 h-4 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-dark-700 font-semibold">{{ $product->title }}</span>
        </nav>
    </div>
</section>

<div class="container mx-auto px-4 py-8 lg:py-12">
    <div class="grid lg:grid-cols-12 gap-8 lg:gap-12">
        <!-- Product Gallery -->
        <div class="lg:col-span-7">
            <!-- Main Image -->
            <div class="relative group">
                <div class="aspect-[4/3] w-full rounded-2xl overflow-hidden border-2 border-dark-100 bg-white shadow-xl">
                    <img id="mainImage" 
                         src="{{ $product->main_image ? asset($product->main_image) : ($product->images->first() ? asset($product->images->first()->url) : 'https://images.unsplash.com/photo-1493663284031-b7e3aefcae8e?q=80&w=1200&auto=format&fit=crop') }}"
                         alt="{{ $product->title }}" 
                         class="h-full w-full object-cover cursor-zoom-in hover:scale-105 transition-transform duration-500">
                </div>
                
                <!-- Zoom Overlay -->
                <div class="absolute inset-0 bg-black bg-opacity-50 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                    <div class="text-white text-center">
                        <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <p class="text-sm font-medium">Cliquer pour agrandir</p>
                    </div>
                </div>

                <!-- Image Navigation -->
                @if($product->images->count() > 1)
                    <button class="absolute left-4 top-1/2 transform -translate-y-1/2 w-12 h-12 bg-white/90 backdrop-blur-sm rounded-full shadow-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 hover:bg-white">
                        <svg class="w-6 h-6 text-dark-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <button class="absolute right-4 top-1/2 transform -translate-y-1/2 w-12 h-12 bg-white/90 backdrop-blur-sm rounded-full shadow-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 hover:bg-white">
                        <svg class="w-6 h-6 text-dark-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                @endif

                <!-- Image Counter -->
                @if($product->images->count() > 1)
                    <div class="absolute top-4 right-4 bg-dark-900/80 text-white px-3 py-1 rounded-full text-sm font-medium backdrop-blur-sm">
                        1 / {{ $product->images->count() }}
                    </div>
                @endif

                <!-- Quality Badge -->
                <div class="absolute top-4 left-4 bg-primary-600 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    Premium
                </div>
            </div>

            <!-- Thumbnail Gallery -->
            @if($product->images->count() > 1)
                <div class="mt-6 grid grid-cols-5 lg:grid-cols-6 gap-3">
                    @foreach($product->images->take(12) as $index => $img)
                        <button class="thumbnail-btn aspect-[4/3] rounded-xl overflow-hidden border-2 border-dark-200 hover:border-primary-500 transition-colors duration-200 {{ $index === 0 ? 'border-primary-500' : '' }}"
                                data-image="{{ asset($img->url) }}"
                                data-index="{{ $index }}">
                            <img src="{{ asset($img->url) }}" alt="{{ $product->title }} - Image {{ $index + 1 }}" 
                                 class="h-full w-full object-cover">
                        </button>
                    @endforeach
                    @if($product->images->count() > 12)
                        <div class="aspect-[4/3] rounded-xl border-2 border-dark-200 bg-dark-100 flex items-center justify-center">
                            <span class="text-dark-600 font-semibold text-sm">+{{ $product->images->count() - 12 }}</span>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Product Description -->
            @if($product->long_description)
                <div class="mt-8 bg-white rounded-2xl border border-dark-100 p-8 shadow-sm">
                    <h3 class="text-2xl font-bold text-dark-900 mb-6 flex items-center gap-3">
                        <div class="w-8 h-8 bg-primary-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        Description détaillée
                    </h3>
                    <div class="prose prose-lg max-w-none text-dark-700 leading-relaxed">
                        {!! $product->long_description !!}
                    </div>
                </div>
            @endif

            <!-- Product Specifications -->
            @if(is_array($product->attributes) && count($product->attributes))
                <div class="mt-8 bg-white rounded-2xl border border-dark-100 p-8 shadow-sm">
                    <h3 class="text-2xl font-bold text-dark-900 mb-6 flex items-center gap-3">
                        <div class="w-8 h-8 bg-primary-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        Caractéristiques techniques
                    </h3>
                    <div class="grid lg:grid-cols-2 gap-4">
                        @foreach($product->attributes as $k => $v)
                            <div class="flex items-center justify-between p-4 bg-dark-50 rounded-xl border border-dark-100">
                                <span class="font-semibold text-dark-700">{{ $k }}</span>
                                <span class="text-dark-900 font-medium">{{ $v }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Product Information & Order -->
        <div class="lg:col-span-5">
            <!-- Sticky Product Summary -->
            <div class="lg:sticky lg:top-8">
                <!-- Product Header -->
                <div class="bg-white rounded-2xl border border-dark-100 p-8 shadow-xl">
                    <!-- Product Title & Brand -->
                    <div class="mb-6">
                        @if($product->brand)
                            <div class="inline-flex items-center gap-2 bg-primary-100 text-primary-700 px-3 py-1 rounded-full text-sm font-medium mb-3">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                {{ $product->brand }}
                            </div>
                        @endif
                        
                        <h1 class="text-3xl lg:text-4xl font-extrabold text-dark-900 leading-tight mb-3">
                            {{ $product->title }}
                        </h1>
                        
                        @if($product->category)
                            <p class="text-dark-600 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                <a href="{{ route('category.show', $product->category->slug) }}" 
                                   class="hover:text-primary-600 transition-colors duration-200 font-medium">
                                    {{ $product->category->name }}
                                </a>
                            </p>
                        @endif
                    </div>

                    <!-- Pricing -->
                    <div class="mb-6 p-6 bg-gradient-to-r from-primary-50 to-primary-100/50 rounded-2xl border border-primary-200">
                        <div class="flex items-center gap-4 mb-3">
                            <div class="text-4xl font-extrabold text-primary-700">{{ $product->price_display }}</div>
                            @if($product->compare_at_display)
                                <div class="flex flex-col">
                                    <span class="text-xl line-through text-dark-400">{{ $product->compare_at_display }}</span>
                                    @php
                                        $savings = (int) (($product->compare_at_millimes - $product->price_millimes) / 1000);
                                    @endphp
                                    <span class="text-sm font-bold text-red-600">Économisez {{ $savings }} DT</span>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Trust Indicators -->
                        <div class="flex flex-wrap items-center gap-4 text-sm text-primary-700">
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                </svg>
                                Paiement sécurisé
                            </div>
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                                </svg>
                                Livraison rapide
                            </div>
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                Support expert
                            </div>
                        </div>
                    </div>

                    <!-- Product Description -->
                    @if($product->short_description)
                        <div class="mb-6 text-dark-700 leading-relaxed">
                            {!! $product->short_description !!}
                        </div>
                    @endif

                    <!-- Shipping Info -->
                    <div class="mb-8 p-6 bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl border border-green-200">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-green-800 mb-1">Livraison gratuite dès 500 DT</h4>
                                <p class="text-sm text-green-700">
                                    <strong>Livraison partout en Tunisie (3-7 jours)</strong><br>
                                    Frais de livraison: {{ $shippingFeeDt }} DT • Paiement à la livraison
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Achat: redirection vers Checkout + contacts rapides -->
                    <div class="space-y-6">
                        <div class="text-center">
                            <h3 class="text-2xl font-bold text-dark-900 mb-2">Prêt à commander ?</h3>
                            <p class="text-dark-600">Cliquez ci-dessous pour finaliser sur la page Checkout</p>
                        </div>

                        <div class="space-y-4 pt-2">
                            <a href="{{ route('checkout.create', $product->slug) }}?qty=1"
                               class="w-full inline-flex items-center justify-center gap-3 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-bold py-4 px-8 rounded-xl transition-all duration-300 shadow-xl hover:shadow-2xl hover:scale-[1.01]">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                Commander maintenant
                            </a>

                            <div class="text-center text-sm text-dark-600">ou contactez-nous directement</div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @if($whDigits)
                                    @php
                                        $whatsappMsg = rawurlencode("Bonjour, je souhaite commander: {$product->title} - " . url(route('product.show', $product->slug, false)));
                                    @endphp
                                    <a href="https://wa.me/{{ $whDigits }}?text={{ $whatsappMsg }}"
                                       target="_blank" rel="noopener"
                                       class="flex items-center justify-center gap-3 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-xl transition-colors duration-200 shadow-lg">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.886 3.75"/>
                                        </svg>
                                        {{ \App\Support\SiteSettings::phoneDisplay() }}
                                    </a>
                                @endif
                                
                                @if($ms)
                                    <a href="{{ $ms }}" target="_blank" rel="noopener"
                                       class="flex items-center justify-center gap-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-xl transition-colors duration-200 shadow-lg">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 0C5.374 0 0 4.975 0 11.111c0 3.497 1.745 6.616 4.472 8.652V24l4.086-2.242c1.09.301 2.246.464 3.442.464 6.626 0 12-4.974 12-11.111C24 4.975 18.626 0 12 0z"/>
                                        </svg>
                                        Messenger
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Stock Info -->
                        @if(!$product->inStock())
                            <div class="mt-4 p-4 bg-amber-50 border border-amber-200 rounded-xl">
                                <div class="flex items-center gap-2 text-amber-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                    <span class="text-sm font-medium">Stock à confirmer lors de la prise de contact</span>
                                </div>
                            </div>
                        @endif

                        <!-- Security Badges -->
                        <div class="mt-6 pt-6 border-t border-dark-100">
                            <div class="grid grid-cols-3 gap-4 text-center">
                                <div class="text-center">
                                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <p class="text-xs font-medium text-dark-700">Paiement à la livraison</p>
                                </div>
                                <div class="text-center">
                                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                    <p class="text-xs font-medium text-dark-700">Livraison 3-7 jours</p>
                                </div>
                                <div class="text-center">
                                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                                        </svg>
                                    </div>
                                    <p class="text-xs font-medium text-dark-700">Support 7j/7</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sticky CTA Mobile -->
<div class="lg:hidden fixed inset-x-0 bottom-0 z-50 bg-white/95 backdrop-blur border-t border-dark-100 px-4 py-3" style="padding-bottom: calc(env(safe-area-inset-bottom) + 12px);">
    <div class="container mx-auto flex items-center justify-between gap-3">
        <div class="flex items-baseline gap-2">
            <span class="text-lg font-extrabold text-primary-700">{{ $product->price_display }}</span>
            @if($product->compare_at_display)
                <span class="text-sm line-through text-dark-400">{{ $product->compare_at_display }}</span>
            @endif
        </div>
        <a href="{{ route('checkout.create', $product->slug) }}?qty=1"
           class="flex-1 text-center bg-primary-600 hover:bg-primary-700 text-white font-bold py-3 px-5 rounded-xl transition-colors">
            Commander
        </a>
    </div>
</div>

<!-- JavaScript for interactions -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Thumbnail gallery functionality
    const mainImage = document.getElementById('mainImage');
    const thumbnails = document.querySelectorAll('.thumbnail-btn');
    
    thumbnails.forEach((thumbnail, index) => {
        thumbnail.addEventListener('click', function() {
            const newImageSrc = this.getAttribute('data-image');
            mainImage.src = newImageSrc;
            
            // Update active thumbnail
            thumbnails.forEach(thumb => thumb.classList.remove('border-primary-500'));
            thumbnails.forEach(thumb => thumb.classList.add('border-dark-200'));
            this.classList.remove('border-dark-200');
            this.classList.add('border-primary-500');
            
            // Update counter
            const counter = document.querySelector('.absolute.top-4.right-4');
            if (counter) {
                counter.textContent = `${index + 1} / {{ $product->images->count() }}`;
            }
        });
    });
});
</script>
@endsection
