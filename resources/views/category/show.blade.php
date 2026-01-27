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
        $category->parent ? [
            '@type' => 'ListItem',
            'position' => 2,
            'name' => $category->parent->name,
            'item' => url(route('category.show', $category->parent->slug, false)),
        ] : null,
        [
            '@type' => 'ListItem',
            'position' => $category->parent ? 3 : 2,
            'name' => $category->name,
            'item' => url()->current(),
        ],
    ])),
], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) !!}
</script>
@endpush
@push('head')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nouislider@15.7.0/dist/nouislider.min.css">
<script defer src="https://cdn.jsdelivr.net/npm/nouislider@15.7.0/dist/nouislider.min.js"></script>
@endpush
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
            @if($category->parent)
                <svg class="w-4 h-4 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <a href="{{ route('category.show', $category->parent->slug) }}" class="text-primary-600 hover:text-primary-800 font-medium transition-colors duration-200">
                    {{ $category->parent->name }}
                </a>
            @endif
            <svg class="w-4 h-4 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-dark-700 font-semibold">{{ $category->name }}</span>
        </nav>
    </div>
</section>

<!-- Category Header -->
<section class="bg-white py-8 lg:py-12 border-b border-dark-100">
    <div class="container mx-auto px-4">
        <div class="grid lg:grid-cols-2 gap-8 items-center">
            <!-- Category Info -->
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2-2v2m0-4.5V9a2 2 0 012-2h2a2 2 0 012 2v8.5M7 7h4"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl lg:text-4xl font-extrabold text-dark-900">{{ $category->name }}</h1>
                        @if($category->description)
                            <p class="text-dark-600 mt-2">{{ $category->description }}</p>
                        @endif
                    </div>
                </div>

                <!-- Sibling Categories -->
                @if($category->parent_id && $siblings->count() > 1)
                    <div class="mb-6">
                        <h3 class="text-sm font-semibold text-dark-700 mb-3">Autres catégories {{ $category->parent->name }} :</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($siblings as $sib)
                                <a href="{{ route('category.show', $sib->slug) }}" 
                                   class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ $sib->id === $category->id ? 'bg-primary-600 text-white' : 'bg-primary-100 text-primary-700 hover:bg-primary-200' }}">
                                    {{ $sib->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Quick Stats -->
                <div class="flex items-center gap-6 text-sm text-dark-600">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ $products->total() }} produits</span>
                    </div>
                    @if($children->count())
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-primary-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 4a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1V8zm8 0a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1V8z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ $children->count() }} sous-catégories</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Search Bar -->
            <div class="lg:justify-self-end">
                <form action="{{ route('category.show', $category->slug) }}" method="get" class="bg-dark-50 rounded-2xl p-6 border border-dark-200">
                    <div class="mb-4">
                        <h3 class="font-bold text-dark-900 mb-2">Rechercher dans {{ $category->name }}</h3>
                        <div class="relative">
                            <input type="search" name="q" value="{{ request('q') }}" 
                                   placeholder="Rechercher un produit..."
                                   class="w-full pl-12 pr-4 py-3 border-2 border-dark-200 rounded-xl bg-white text-dark-900 placeholder-dark-400 focus:border-primary-500 focus:ring-0 transition-all duration-200">
                            <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                    <button type="submit" 
                            class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 px-6 rounded-xl transition-colors duration-200">
                        Rechercher
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<div class="container mx-auto px-4 py-8 lg:py-12">
    <div class="grid lg:grid-cols-12 gap-8">
        <!-- Sidebar -->
        <aside class="lg:col-span-3 space-y-6">
            <!-- Sub-categories -->
            @if($children->count())
                <div class="bg-white rounded-2xl border border-dark-100 overflow-hidden shadow-sm">
                    <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-6 py-4">
                        <h3 class="font-bold text-white flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            Sous-catégories
                        </h3>
                    </div>
                    <div class="p-4">
                        <div class="space-y-2">
                            @foreach($children as $child)
                                <a href="{{ route('category.show', $child->slug) }}"
                                   class="group flex items-center justify-between p-3 rounded-xl hover:bg-primary-50 transition-all duration-200 {{ request()->route('slug') === $child->slug ? 'bg-primary-100 text-primary-800 font-semibold' : 'text-dark-700 hover:text-primary-700' }}">
                                    <span>{{ $child->name }}</span>
                                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Advanced Filters -->
            <div class="bg-white rounded-2xl border border-dark-100 overflow-hidden shadow-sm">
                <div class="bg-gradient-to-r from-dark-800 to-dark-900 px-6 py-4">
                    <h3 class="font-bold text-white flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"/>
                        </svg>
                        Filtres avancés
                    </h3>
                </div>
                <form action="{{ route('category.show', $category->slug) }}" method="get" class="p-6 space-y-6">
                    <!-- Keyword Search -->
                    <div>
                        <label class="block text-sm font-semibold text-dark-700 mb-2">Mot-clé</label>
                        <input type="search" name="q" value="{{ request('q') }}" 
                               placeholder="Ex: canapé, table..."
                               class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200">
                    </div>

                    <!-- Price Range -->
                    <div>
                        <label class="block text-sm font-semibold text-dark-700 mb-3">Gamme de prix (DT)</label>

                        <!-- Slider -->
                        <div class="space-y-3">
                            <div id="price-slider" class="px-2 py-4"></div>
                            <div class="text-sm text-dark-600">
                                <span class="font-semibold" id="price-range-display">
                                    {{ (int) request('min', 0) }} DT — {{ (int) request('max', $maxPriceDt ?? 1000) }} DT
                                </span>
                            </div>
                        </div>

                        <!-- Fallback/Accessible inputs -->
                        <div class="grid grid-cols-2 gap-3 mt-4">
                            <div>
                                <label class="text-xs text-dark-500 mb-1 block">Prix min</label>
                                <input type="number" name="min" id="price-min" value="{{ request('min') }}" min="0" placeholder="0"
                                       class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200">
                            </div>
                            <div>
                                <label class="text-xs text-dark-500 mb-1 block">Prix max</label>
                                <input type="number" name="max" id="price-max" value="{{ request('max', $maxPriceDt ?? 1000) }}" min="0" placeholder="{{ $maxPriceDt ?? 1000 }}"
                                       class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200">
                            </div>
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                try {
                                    const sliderEl = document.getElementById('price-slider');
                                    if (!sliderEl || typeof noUiSlider === 'undefined') return;

                                    const minInput = document.getElementById('price-min');
                                    const maxInput = document.getElementById('price-max');
                                    const display = document.getElementById('price-range-display');

                                    const minStart = Number('{{ (int) request('min', 0) }}') || 0;
                                    const maxBound = Number('{{ (int) ($maxPriceDt ?? 1000) }}') || 1000;
                                    const maxStart = Number('{{ (int) request('max', $maxPriceDt ?? 1000) }}') || maxBound;

                                    noUiSlider.create(sliderEl, {
                                        start: [minStart, maxStart],
                                        connect: true,
                                        step: 1,
                                        range: { min: 0, max: maxBound },
                                        tooltips: [true, true],
                                        format: {
                                            to: (v) => Math.round(v),
                                            from: (v) => Number(v)
                                        }
                                    });

                                    const updateDisplay = (vals) => {
                                        const a = Math.round(vals[0]);
                                        const b = Math.round(vals[1]);
                                        if (display) display.textContent = `${a} DT — ${b} DT`;
                                    };

                                    sliderEl.noUiSlider.on('update', (values) => {
                                        const [a, b] = values.map(v => Math.round(v));
                                        if (minInput) minInput.value = String(a);
                                        if (maxInput) maxInput.value = String(b);
                                        updateDisplay(values);
                                    });

                                    // When editing inputs manually, reflect to slider
                                    const syncFromInputs = () => {
                                        const a = Math.max(0, Number(minInput.value || 0));
                                        const b = Math.max(a, Number(maxInput.value || maxBound));
                                        sliderEl.noUiSlider.set([a, b]);
                                    };
                                    if (minInput) minInput.addEventListener('change', syncFromInputs);
                                    if (maxInput) maxInput.addEventListener('change', syncFromInputs);
                                } catch (e) { /* no-op */ }
                            });
                        </script>
                    </div>

                    <!-- Brand Filter -->
                    <div>
                        <label class="block text-sm font-semibold text-dark-700 mb-2">Marque</label>
                        <input type="text" name="brand" value="{{ request('brand') }}" 
                               placeholder="Ex: Ikea, Maisons du Monde..."
                               class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200">
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3 pt-4">
                        <button type="submit" 
                                class="flex-1 bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 px-4 rounded-xl transition-colors duration-200 shadow-lg">
                            Appliquer
                        </button>
                        <a href="{{ route('category.show', $category->slug) }}" 
                           class="flex-1 bg-dark-100 hover:bg-dark-200 text-dark-700 font-semibold py-3 px-4 rounded-xl transition-colors duration-200 text-center">
                            Réinitialiser
                        </a>
                    </div>
                </form>
            </div>

            <!-- Quick Contact -->
            @php
                $wh = \App\Models\Setting::get('contact.whatsapp');
                $whDigits = $wh ? preg_replace('/\D+/', '', (string)$wh) : null;
            @endphp
            @if($whDigits)
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white">
                    <h3 class="font-bold text-lg mb-2">Besoin d'aide ?</h3>
                    <p class="text-green-100 text-sm mb-4">Nos experts vous conseillent gratuitement</p>
                    <a href="https://wa.me/{{ $whDigits }}?text={{ rawurlencode('Bonjour, j\'ai besoin d\'aide pour choisir des meubles dans la catégorie: ' . $category->name) }}"
                       target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2 bg-white text-green-600 font-semibold px-4 py-3 rounded-xl hover:bg-green-50 transition-colors duration-200 w-full justify-center">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.886 3.75"/>
                        </svg>
                        Contacter un expert
                    </a>
                </div>
            @endif
        </aside>

        <!-- Products Section -->
        <section class="lg:col-span-9">
            <!-- Sort & View Options -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8 bg-white rounded-2xl border border-dark-100 p-6">
                <div class="flex items-center gap-4">
                    <h2 class="font-bold text-dark-900">
                        {{ $products->total() }} produit{{ $products->total() > 1 ? 's' : '' }} trouvé{{ $products->total() > 1 ? 's' : '' }}
                    </h2>
                    @if(request('q') || request('min') || request('max') || request('brand'))
                        <span class="inline-flex items-center gap-1 bg-primary-100 text-primary-700 text-xs font-medium px-3 py-1 rounded-full">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"/>
                            </svg>
                            Filtres actifs
                        </span>
                    @endif
                </div>
                
                <!-- Sort Options -->
                <div class="flex items-center gap-3">
                    <label class="text-sm font-medium text-dark-600">Trier par :</label>
                    <select name="sort" onchange="this.form.submit()" 
                            class="border-2 border-dark-200 rounded-xl px-4 py-2 text-sm focus:border-primary-500 focus:ring-0 transition-colors duration-200">
                        <option value="newest">Plus récent</option>
                        <option value="price_asc">Prix croissant</option>
                        <option value="price_desc">Prix décroissant</option>
                        <option value="name">Nom A-Z</option>
                    </select>
                </div>
            </div>

            <!-- Products Grid -->
            @if($products->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
                    @foreach($products as $product)
                        <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 overflow-hidden border border-dark-100">
                            <!-- Product Image -->
                            <div class="relative overflow-hidden">
                                <a href="{{ route('product.show', $product->slug) }}" class="block">
                                    <img src="{{ $product->main_image ? asset($product->main_image) : ($product->images->first() ? asset($product->images->first()->url) : 'https://images.unsplash.com/photo-1493663284031-b7e3aefcae8e?q=80&w=1200&auto=format&fit=crop') }}"
                                         alt="{{ $product->title }}"
                                         class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500" />
                                </a>
                                
                                <!-- Quick Action Buttons -->
                                <div class="absolute top-4 right-4 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <button class="w-10 h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-lg hover:bg-white transition-colors duration-200">
                                        <svg class="w-5 h-5 text-dark-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                    </button>
                                    <button class="w-10 h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-lg hover:bg-white transition-colors duration-200">
                                        <svg class="w-5 h-5 text-dark-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                </div>

                                <!-- Price Badge -->
                                @if($product->compare_at_display)
                                    <div class="absolute top-4 left-4">
                                        <span class="bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                                            Promo
                                        </span>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Product Info -->
                            <div class="p-6">
                                <a href="{{ route('product.show', $product->slug) }}" 
                                   class="block font-bold text-lg text-dark-900 hover:text-primary-700 transition-colors duration-200 mb-2 line-clamp-2">
                                    {{ $product->title }}
                                </a>

                                @if($product->brand)
                                    <p class="text-sm text-primary-600 font-medium mb-2">{{ $product->brand }}</p>
                                @endif
                                
                                <!-- Price -->
                                <div class="flex items-center gap-3 mb-4">
                                    <span class="text-2xl font-bold text-primary-600">{{ $product->price_display }}</span>
                                    @if($product->compare_at_display)
                                        <span class="text-lg line-through text-dark-400">{{ $product->compare_at_display }}</span>
                                    @endif
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="flex gap-2">
                                    <a href="{{ route('product.show', $product->slug) }}"
                                       class="flex-1 bg-dark-100 hover:bg-dark-200 text-dark-800 font-semibold py-3 px-4 rounded-xl transition-colors duration-200 text-center text-sm">
                                        Voir détails
                                    </a>
                                    @if($whDigits)
                                        @php
                                            $msg = rawurlencode("Bonjour, je souhaite commander: {$product->title} - " . url(route('product.show', $product->slug, false)));
                                        @endphp
                                        <a href="https://wa.me/{{ $whDigits }}?text={{ $msg }}"
                                           target="_blank" rel="noopener"
                                           class="flex-1 bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 px-4 rounded-xl transition-colors duration-200 text-center text-sm">
                                            Commander
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="flex justify-center">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-2xl border border-dark-100 p-12 text-center">
                    <div class="w-24 h-24 bg-dark-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-dark-700 mb-4">Aucun produit trouvé</h3>
                    <p class="text-dark-500 mb-6 max-w-md mx-auto">
                        Aucun produit ne correspond à vos critères de recherche. Essayez de modifier vos filtres ou parcourez d'autres catégories.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <a href="{{ route('category.show', $category->slug) }}" 
                           class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white font-semibold px-6 py-3 rounded-xl transition-colors duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Réinitialiser les filtres
                        </a>
                        <a href="{{ route('home') }}" 
                           class="inline-flex items-center gap-2 bg-dark-100 hover:bg-dark-200 text-dark-700 font-semibold px-6 py-3 rounded-xl transition-colors duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            Retour à l'accueil
                        </a>
                    </div>
                </div>
            @endif
        </section>
    </div>
</div>
@endsection
