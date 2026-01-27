{{-- Premium Header with Mega-Menu Navigation --}}
@php
    $wa = \App\Models\Setting::get('contact.whatsapp');
    $ms = \App\Models\Setting::get('contact.messenger');
    $logo = \App\Models\Setting::get('ui.logo');
    $siteName = \App\Models\Setting::get('site.name', 'Maison 216');
    $tagline = \App\Models\Setting::get('site.tagline', 'Meubles & Décoration en Tunisie');
    
    // Main navigation (fixed structure)
    $menuMeubles = [
        ['label' => 'Salon', 'slug' => 'salons-complets'],
        ['label' => 'Salle &agrave; manger', 'slug' => 'salles-a-manger-completes'],
        ['label' => 'Bureau', 'slug' => 'bureaux'],
        ['label' => 'Cuisine', 'slug' => 'cuisines-completes'],
        ['label' => 'Meuble Salle de bain', 'slug' => 'ensemble-salle-de-bains'],
        ['label' => 'Entr&eacute;e &amp; dressing', 'slug' => 'vestiaires-complets'],
    ];

    $menuChambre = [
        ['label' => 'Lits', 'slug' => 'lits'],
        ['label' => 'Literie', 'slug' => 'matelas'],
        ['label' => 'Accessoires de lit', 'slug' => 'accessoires-lits'],
    ];

    $menuDeco = [
        ['label' => 'D&eacute;coration murale', 'slug' => 'decoration-murale'],
        ['label' => '&Eacute;tag&egrave;res murales', 'slug' => 'etageres-murales-en-metal'],
        ['label' => 'Miroirs', 'slug' => 'miroirs'],
        ['label' => 'Objets d&eacute;co', 'slug' => 'objets-deco'],
        ['label' => 'Rangement &amp; entr&eacute;e', 'slug' => 'armoires-de-couloir'],
    ];

    $menuJardin = [
        ['label' => 'Salons ext&eacute;rieurs', 'slug' => 'ensembles-de-jardin'],
        ['label' => 'Tables jardin', 'slug' => 'tables-de-jardin-rondes'],
        ['label' => 'Tables de balcon', 'slug' => 'tables-de-balcon'],
        ['label' => 'Parasols d&eacute;port&eacute;s', 'slug' => 'parasols-deportes'],
        ['label' => 'Coffres de jardin', 'slug' => 'coffres-de-jardin'],
    ];

    $dealsSlug = 'seconde-chance';
@endphp

{{-- Top Announcement Bar --}}
<div class="bg-gradient-to-r from-dark-900 via-dark-800 to-dark-900 text-white text-sm relative overflow-hidden">
    <div class="absolute inset-0 bg-hero-pattern opacity-10"></div>
    <div class="container mx-auto px-4 py-2.5 relative z-10">
        <div class="flex items-center justify-between">
            {{-- Scrolling announcement on mobile, static on desktop --}}
            <div class="flex-1 overflow-hidden">
                <div class="flex items-center gap-3 text-sm font-medium animate-fade-in">
                    <span class="flex items-center gap-2 whitespace-nowrap">
                        <svg class="w-4 h-4 text-primary-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                            <path d="M3 4h1l.77 2.21.32.9H16l-1.5 6H5.05L3.73 8H2V6h3.33l.77 2.21"/>
                        </svg>
                        <span class="hidden sm:inline">Livraison partout en Tunisie •</span>
                        <span class="sm:hidden">Livraison Tunisie</span>
                    </span>
                    <span class="hidden md:flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Paiement à la livraison (COD)
                    </span>
                    <span class="hidden lg:flex items-center gap-2">
                        •
                        <svg class="w-4 h-4 text-primary-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 12a1 1 0 11-2 0 1 1 0 012 0zm-1-6a1 1 0 00-.993.883L9 9v3a1 1 0 001.993.117L11 12V9a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        Délai 3-7 jours ouvrés
                    </span>
                </div>
            </div>
            
            {{-- Contact Links --}}
            <div class="hidden sm:flex items-center gap-4 ml-4">
                @if(!empty($wa))
                    <a class="flex items-center gap-1.5 text-dark-300 hover:text-primary-400 transition-colors duration-200 text-xs" 
                       href="https://wa.me/{{ preg_replace('/\D+/', '', (string)$wa) }}" 
                       target="_blank" rel="noopener">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.886 3.75"/>
                        </svg>
                        <span class="hidden md:inline">WhatsApp</span>
                    </a>
                @endif
                @if(!empty($ms))
                    <a class="flex items-center gap-1.5 text-dark-300 hover:text-primary-400 transition-colors duration-200 text-xs" 
                       href="{{ $ms }}" target="_blank" rel="noopener">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0C5.374 0 0 4.975 0 11.111c0 3.497 1.745 6.616 4.472 8.652V24l4.086-2.242c1.09.301 2.246.464 3.442.464 6.626 0 12-4.974 12-11.111C24 4.975 18.626 0 12 0z"/>
                        </svg>
                        <span class="hidden md:inline">Messenger</span>
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Main Header --}}
<header class="bg-white shadow-lg shadow-dark-100/10 sticky top-0 z-50 border-b border-dark-100">
    <div class="container mx-auto px-4">
        {{-- Top Header Row: Logo + Search + Actions --}}
        <div class="flex items-center justify-between py-4 lg:py-5 gap-4">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3 group flex-shrink-0">
                @if($logo)
                    <img src="{{ $logo }}" alt="{{ $siteName }}" class="h-10 lg:h-12 w-auto group-hover:scale-105 transition-transform duration-200">
                @else
                    <div class="h-10 lg:h-12 w-10 lg:w-12 bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl flex items-center justify-center font-bold text-white text-lg shadow-lg group-hover:scale-105 transition-transform duration-200">
                        M
                    </div>
                @endif
                <span class="sr-only">{{ $siteName }}</span>
            </a>

            {{-- Search Bar (Desktop) --}}
            <form action="{{ route('search') }}" method="get"
                  class="hidden lg:flex items-center w-full max-w-xl"
                  x-data="{
                    q: '{{ request('q') }}',
                    open: false,
                    results: [],
                    highlighted: -1,
                    loading: false,
                    abort: null,
                    fetchSuggest() {
                      if (this.abort) { this.abort.abort(); this.abort = null; }
                      const q = (this.q || '').trim();
                      this.highlighted = -1;
                      if (q.length < 2) { this.results = []; this.open = false; return; }
                      this.loading = true;
                      const controller = new AbortController();
                      this.abort = controller;
                      fetch('{{ route('search.suggest') }}?q=' + encodeURIComponent(q), { signal: controller.signal })
                        .then(r => r.ok ? r.json() : [])
                        .then(json => {
                          this.results = Array.isArray(json) ? json : [];
                          this.open = this.results.length > 0;
                        })
                        .catch(() => {})
                        .finally(() => { this.loading = false; this.abort = null; });
                    },
                    onKeydown(e) {
                      if (!this.open) return;
                      if (e.key === 'ArrowDown') { e.preventDefault(); this.highlighted = (this.highlighted + 1) % this.results.length; }
                      if (e.key === 'ArrowUp') { e.preventDefault(); this.highlighted = (this.highlighted - 1 + this.results.length) % this.results.length; }
                      if (e.key === 'Enter') {
                        if (this.highlighted >= 0 && this.results[this.highlighted]) {
                          e.preventDefault();
                          window.location.href = this.results[this.highlighted].url;
                        }
                      }
                      if (e.key === 'Escape') { this.open = false; }
                    }
                  }"
                  @keydown.window.escape="open = false"
                  @click.outside="open = false">
                <div class="relative w-full">
                    <label for="search-desktop" class="sr-only">Rechercher un meuble</label>
                    <input name="q" id="search-desktop" type="search"
                           x-model="q"
                           @input.debounce.200ms="fetchSuggest()"
                           @keydown="onKeydown($event)"
                           @focus="fetchSuggest()"
                           placeholder="Rechercher canapé, table, lit..."
                           class="w-full pl-12 pr-4 py-3 border-2 border-dark-200 rounded-xl bg-dark-50/50 text-dark-900 placeholder-dark-400 focus:border-primary-500 focus:bg-white focus:ring-0 transition-all duration-200"
                           autocomplete="off">
                    <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>

                    {{-- Autosuggest Dropdown --}}
                    <div x-show="open" x-transition
                         class="absolute z-50 mt-2 w-full bg-white rounded-xl border border-dark-100 shadow-2xl overflow-hidden">
                        <template x-if="loading">
                            <div class="px-4 py-3 text-sm text-dark-500 flex items-center gap-2">
                                <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Recherche en cours...
                            </div>
                        </template>
                        <template x-if="!loading && results.length === 0">
                            <div class="px-4 py-3 text-sm text-dark-500">Aucun résultat trouvé</div>
                        </template>
                        <ul role="listbox" class="max-h-80 overflow-auto divide-y divide-dark-50">
                            <template x-for="(item, i) in results" :key="item.slug">
                                <li :class="['flex items-center gap-3 px-4 py-3 cursor-pointer transition-colors',
                                             highlighted === i ? 'bg-primary-50' : 'hover:bg-dark-50']"
                                    @mouseenter="highlighted = i"
                                    @mouseleave="highlighted = -1"
                                    @click="window.location.href = item.url"
                                    role="option"
                                    :aria-selected="highlighted === i">
                                    <img :src="item.image || 'https://via.placeholder.com/64x64?text=%20'" alt=""
                                         class="w-12 h-12 rounded-lg object-cover border border-dark-100">
                                    <div class="flex-1 min-w-0">
                                        <div class="text-sm font-semibold text-dark-900 line-clamp-1" x-text="item.title"></div>
                                        <div class="text-xs text-primary-600 font-medium" x-text="item.price || ''"></div>
                                    </div>
                                    <svg class="w-4 h-4 text-dark-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>
                <button type="submit"
                        class="ml-3 px-6 py-3 bg-primary-600 text-white font-semibold rounded-xl hover:bg-primary-700 focus:ring-4 focus:ring-primary-200 transition-all duration-200 shadow-lg hover:shadow-xl">
                    Chercher
                </button>
            </form>

            {{-- Mobile Menu Button --}}
            <button id="mobile-menu-toggle" 
                    class="lg:hidden p-3 rounded-xl border-2 border-dark-200 hover:bg-dark-50 transition-colors duration-200 focus:ring-4 focus:ring-primary-200" 
                    aria-label="Menu principal" 
                    aria-expanded="false">
                <svg class="h-6 w-6 text-dark-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        {{-- Desktop Navigation - Mega Menu --}}
        <nav class="hidden lg:block border-t border-dark-100" aria-label="Navigation principale">
            <ul class="flex items-center gap-1 py-3">
                {{-- 1) Meubles (mega-menu) --}}
                <li class="relative group">
                    <button type="button"
                            class="flex items-center gap-1.5 px-4 py-2 font-semibold text-dark-700 hover:text-primary-700 hover:bg-primary-50 rounded-lg transition-all duration-200 group-hover:text-primary-700"
                            aria-haspopup="true">
                        Meubles
                        <svg class="w-4 h-4 transform group-hover:rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div class="absolute left-0 top-full opacity-0 invisible group-hover:opacity-100 group-hover:visible bg-white rounded-2xl shadow-2xl border border-dark-100 mt-2 w-[720px] max-w-[90vw] z-40 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                        <div class="p-6">
                            <div class="flex items-center gap-3 mb-4 pb-4 border-b border-dark-100">
                                <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-dark-900">Meubles</h3>
                                    <p class="text-xs text-dark-500">Salon, salle &agrave; manger, bureau, cuisine...</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 lg:grid-cols-3 gap-2">
                                @foreach($menuMeubles as $item)
                                    <a href="{{ route('category.show', $item['slug']) }}"
                                       class="flex items-center gap-3 p-3 rounded-xl hover:bg-primary-50 transition-colors duration-200 group/item">
                                        <span class="w-2 h-2 bg-primary-500 rounded-full group-hover/item:scale-125 transition-transform duration-200"></span>
                                        <span class="text-dark-700 font-medium group-hover/item:text-primary-700 transition-colors duration-200">
                                            {!! $item['label'] !!}
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </li>

                {{-- 2) Chambre & Literie --}}
                <li class="relative group">
                    <button type="button"
                            class="flex items-center gap-1.5 px-4 py-2 font-semibold text-dark-700 hover:text-primary-700 hover:bg-primary-50 rounded-lg transition-all duration-200 group-hover:text-primary-700"
                            aria-haspopup="true">
                        Chambre &amp; Literie
                        <svg class="w-4 h-4 transform group-hover:rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div class="absolute left-0 top-full opacity-0 invisible group-hover:opacity-100 group-hover:visible bg-white rounded-2xl shadow-2xl border border-dark-100 mt-2 min-w-[280px] z-40 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                        <div class="p-4 space-y-1">
                            @foreach($menuChambre as $item)
                                <a href="{{ route('category.show', $item['slug']) }}"
                                   class="flex items-center gap-3 p-3 rounded-xl hover:bg-primary-50 transition-colors duration-200 group/item">
                                    <span class="w-2 h-2 bg-primary-500 rounded-full group-hover/item:scale-125 transition-transform duration-200"></span>
                                    <span class="text-dark-700 font-medium group-hover/item:text-primary-700 transition-colors duration-200">
                                        {!! $item['label'] !!}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </li>

                {{-- 3) Décoration & Accessoires --}}
                <li class="relative group">
                    <button type="button"
                            class="flex items-center gap-1.5 px-4 py-2 font-semibold text-dark-700 hover:text-primary-700 hover:bg-primary-50 rounded-lg transition-all duration-200 group-hover:text-primary-700"
                            aria-haspopup="true">
                        D&eacute;coration &amp; Accessoires
                        <svg class="w-4 h-4 transform group-hover:rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div class="absolute left-0 top-full opacity-0 invisible group-hover:opacity-100 group-hover:visible bg-white rounded-2xl shadow-2xl border border-dark-100 mt-2 min-w-[320px] z-40 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                        <div class="p-4 space-y-1">
                            @foreach($menuDeco as $item)
                                <a href="{{ route('category.show', $item['slug']) }}"
                                   class="flex items-center gap-3 p-3 rounded-xl hover:bg-primary-50 transition-colors duration-200 group/item">
                                    <span class="w-2 h-2 bg-primary-500 rounded-full group-hover/item:scale-125 transition-transform duration-200"></span>
                                    <span class="text-dark-700 font-medium group-hover/item:text-primary-700 transition-colors duration-200">
                                        {!! $item['label'] !!}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </li>

                {{-- 4) Jardin & Extérieur --}}
                <li class="relative group">
                    <button type="button"
                            class="flex items-center gap-1.5 px-4 py-2 font-semibold text-dark-700 hover:text-primary-700 hover:bg-primary-50 rounded-lg transition-all duration-200 group-hover:text-primary-700"
                            aria-haspopup="true">
                        Jardin &amp; Ext&eacute;rieur
                        <svg class="w-4 h-4 transform group-hover:rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div class="absolute left-0 top-full opacity-0 invisible group-hover:opacity-100 group-hover:visible bg-white rounded-2xl shadow-2xl border border-dark-100 mt-2 min-w-[320px] z-40 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                        <div class="p-4 space-y-1">
                            @foreach($menuJardin as $item)
                                <a href="{{ route('category.show', $item['slug']) }}"
                                   class="flex items-center gap-3 p-3 rounded-xl hover:bg-primary-50 transition-colors duration-200 group/item">
                                    <span class="w-2 h-2 bg-primary-500 rounded-full group-hover/item:scale-125 transition-transform duration-200"></span>
                                    <span class="text-dark-700 font-medium group-hover/item:text-primary-700 transition-colors duration-200">
                                        {!! $item['label'] !!}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </li>

                {{-- 5) Bonnes affaires --}}
                <li>
                    <a href="{{ route('category.show', $dealsSlug) }}"
                       class="flex items-center gap-1.5 px-4 py-2 font-semibold text-dark-700 hover:text-primary-700 hover:bg-primary-50 rounded-lg transition-all duration-200">
                        Bonnes affaires
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    {{-- Mobile Menu Drawer --}}
    <div id="mobile-menu" class="lg:hidden hidden fixed inset-0 z-[60] bg-dark-900/50 backdrop-blur-sm" x-data="{ openCategory: null }">
        <div class="absolute right-0 top-0 h-full w-full max-w-sm bg-white shadow-2xl overflow-y-auto">
            {{-- Mobile Menu Header --}}
            <div class="flex items-center justify-between p-4 border-b border-dark-100 bg-dark-50">
                <span class="font-bold text-lg text-dark-900">Menu</span>
                <button id="mobile-menu-close" class="p-2 rounded-lg hover:bg-dark-100 transition-colors">
                    <svg class="w-6 h-6 text-dark-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Mobile Search --}}
            <div class="p-4 border-b border-dark-100">
                <form action="{{ route('search') }}" method="get" class="flex gap-2">
                    <input name="q" type="search" placeholder="Rechercher un produit..."
                           class="flex-1 px-4 py-3 border-2 border-dark-200 rounded-xl bg-dark-50/50 focus:border-primary-500 focus:ring-0 transition-colors"
                           value="{{ request('q') }}">
                    <button type="submit" class="px-4 py-3 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </form>
            </div>

            {{-- Mobile Navigation Links --}}
            <div class="p-4">
                {{-- 1) Meubles --}}
                <div class="mb-2">
                    <button type="button"
                            @click="openCategory = openCategory === 'meubles' ? null : 'meubles'"
                            class="w-full flex items-center justify-between gap-3 p-3 rounded-xl hover:bg-primary-50 transition-colors">
                        <span class="flex items-center gap-3">
                            <span class="w-2 h-2 bg-primary-500 rounded-full"></span>
                            <span class="font-semibold text-dark-800">Meubles</span>
                        </span>
                        <svg class="w-5 h-5 text-dark-500 transition-transform duration-200"
                             :class="openCategory === 'meubles' ? 'rotate-180' : ''"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openCategory === 'meubles'" x-collapse class="ml-5 mt-2 space-y-1">
                        @foreach($menuMeubles as $item)
                            <a href="{{ route('category.show', $item['slug']) }}"
                               class="block p-2 pl-4 text-dark-700 hover:text-primary-700 hover:bg-primary-50 rounded-lg transition-colors text-sm">
                                {!! $item['label'] !!}
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- 2) Chambre & Literie --}}
                <div class="mb-2">
                    <button type="button"
                            @click="openCategory = openCategory === 'chambre' ? null : 'chambre'"
                            class="w-full flex items-center justify-between gap-3 p-3 rounded-xl hover:bg-primary-50 transition-colors">
                        <span class="flex items-center gap-3">
                            <span class="w-2 h-2 bg-primary-500 rounded-full"></span>
                            <span class="font-semibold text-dark-800">Chambre &amp; Literie</span>
                        </span>
                        <svg class="w-5 h-5 text-dark-500 transition-transform duration-200"
                             :class="openCategory === 'chambre' ? 'rotate-180' : ''"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openCategory === 'chambre'" x-collapse class="ml-5 mt-2 space-y-1">
                        @foreach($menuChambre as $item)
                            <a href="{{ route('category.show', $item['slug']) }}"
                               class="block p-2 pl-4 text-dark-700 hover:text-primary-700 hover:bg-primary-50 rounded-lg transition-colors text-sm">
                                {!! $item['label'] !!}
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- 3) D&eacute;coration & Accessoires --}}
                <div class="mb-2">
                    <button type="button"
                            @click="openCategory = openCategory === 'deco' ? null : 'deco'"
                            class="w-full flex items-center justify-between gap-3 p-3 rounded-xl hover:bg-primary-50 transition-colors">
                        <span class="flex items-center gap-3">
                            <span class="w-2 h-2 bg-primary-500 rounded-full"></span>
                            <span class="font-semibold text-dark-800">D&eacute;coration &amp; Accessoires</span>
                        </span>
                        <svg class="w-5 h-5 text-dark-500 transition-transform duration-200"
                             :class="openCategory === 'deco' ? 'rotate-180' : ''"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openCategory === 'deco'" x-collapse class="ml-5 mt-2 space-y-1">
                        @foreach($menuDeco as $item)
                            <a href="{{ route('category.show', $item['slug']) }}"
                               class="block p-2 pl-4 text-dark-700 hover:text-primary-700 hover:bg-primary-50 rounded-lg transition-colors text-sm">
                                {!! $item['label'] !!}
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- 4) Jardin & Ext&eacute;rieur --}}
                <div class="mb-2">
                    <button type="button"
                            @click="openCategory = openCategory === 'jardin' ? null : 'jardin'"
                            class="w-full flex items-center justify-between gap-3 p-3 rounded-xl hover:bg-primary-50 transition-colors">
                        <span class="flex items-center gap-3">
                            <span class="w-2 h-2 bg-primary-500 rounded-full"></span>
                            <span class="font-semibold text-dark-800">Jardin &amp; Ext&eacute;rieur</span>
                        </span>
                        <svg class="w-5 h-5 text-dark-500 transition-transform duration-200"
                             :class="openCategory === 'jardin' ? 'rotate-180' : ''"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openCategory === 'jardin'" x-collapse class="ml-5 mt-2 space-y-1">
                        @foreach($menuJardin as $item)
                            <a href="{{ route('category.show', $item['slug']) }}"
                               class="block p-2 pl-4 text-dark-700 hover:text-primary-700 hover:bg-primary-50 rounded-lg transition-colors text-sm">
                                {!! $item['label'] !!}
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- 5) Bonnes affaires --}}
                <a href="{{ route('category.show', $dealsSlug) }}"
                   class="flex items-center gap-3 p-3 rounded-xl hover:bg-primary-50 transition-colors mt-4">
                    <span class="w-2 h-2 bg-primary-500 rounded-full"></span>
                    <span class="font-semibold text-dark-800">Bonnes affaires</span>
                </a>
            </div>

            {{-- Mobile Contact Buttons --}}
            <div class="p-4 mt-auto border-t border-dark-100 space-y-3">
                @if(!empty($wa))
                    <a href="https://wa.me/{{ preg_replace('/\D+/', '', (string)$wa) }}" 
                       target="_blank" rel="noopener"
                       class="flex items-center justify-center gap-2 w-full py-3 bg-green-500 text-white font-semibold rounded-xl hover:bg-green-600 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.886 3.75"/>
                        </svg>
                        Nous contacter via WhatsApp
                    </a>
                @endif
            </div>
        </div>
    </div>
</header>

<script>
    // Mobile menu toggle
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('mobile-menu-toggle');
        const closeBtn = document.getElementById('mobile-menu-close');
        const mobileMenu = document.getElementById('mobile-menu');
        
        if (toggleBtn && mobileMenu) {
            toggleBtn.addEventListener('click', () => {
                mobileMenu.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            });
        }
        
        if (closeBtn && mobileMenu) {
            closeBtn.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
                document.body.style.overflow = '';
            });
            
            // Close when clicking backdrop
            mobileMenu.addEventListener('click', (e) => {
                if (e.target === mobileMenu) {
                    mobileMenu.classList.add('hidden');
                    document.body.style.overflow = '';
                }
            });
        }
    });
</script>
