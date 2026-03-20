@php
    $catalog = app(\App\Support\StorefrontCatalog::class);

    $wa = \App\Models\Setting::get('contact.whatsapp');
    $logo = \App\Models\Setting::get('ui.logo');
    $siteName = \App\Models\Setting::get('site.name', 'Maison 216');
    $navRooms = $catalog->showcaseRooms(6);
    $composerTypes = $catalog->composerTypes(4);

    $homeUrl = route('home');
    $catalogUrl = route('categories.index');
    $composeUrl = url('/#composer');
    $surMesureUrl = url('/#sur-mesure');
    $atelierUrl = url('/#atelier');
    $contactUrl = route('contact');
    $searchUrl = route('search');
    $whatsappUrl = $wa ? 'https://wa.me/' . preg_replace('/\D+/', '', (string) $wa) : null;
    $logoUrl = $logo
        ? (\Illuminate\Support\Str::startsWith($logo, ['http://', 'https://', '/']) ? $logo : asset($logo))
        : null;
    $imageUrl = fn (?string $path) => $path
        ? (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '/']) ? $path : asset($path))
        : null;
@endphp

<div class="border-b border-[#e8dcc7] bg-[#efe2cb] text-[#4f4236]">
    <div class="container mx-auto flex flex-wrap items-center justify-between gap-3 px-4 py-2 text-xs font-semibold sm:text-sm">
        <div class="flex flex-wrap items-center gap-x-4 gap-y-1">
            <span class="inline-flex items-center gap-2"><i class="fa-solid fa-screwdriver-wrench text-[#a47834]"></i>Ateliers bois, alu et fer</span>
            <span class="hidden items-center gap-2 sm:inline-flex"><i class="fa-solid fa-truck-fast text-[#a47834]"></i>Livraison partout en Tunisie</span>
            <span class="hidden items-center gap-2 lg:inline-flex"><i class="fa-brands fa-whatsapp text-[#a47834]"></i>Conseil rapide sur WhatsApp</span>
        </div>

        <div class="flex items-center gap-3">
            @if($whatsappUrl)
                <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full bg-white/70 px-3 py-1 text-[#2b241e] transition hover:bg-white">
                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                    WhatsApp
                </a>
            @endif
            <a href="{{ $contactUrl }}" class="text-[#4f4236] transition hover:text-[#171411]">Devis & accompagnement</a>
        </div>
    </div>
</div>

<header class="sticky top-0 z-50 border-b border-[#eadfce] bg-[#fbf7f0]/95 backdrop-blur">
    <div class="container mx-auto px-4">
        <div class="flex items-center gap-4 py-4">
            <a href="{{ $homeUrl }}" class="flex min-w-0 items-center gap-3">
                @if($logoUrl)
                    <img src="{{ $logoUrl }}" alt="{{ $siteName }}" class="h-11 w-auto sm:h-12">
                @else
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#171411] text-lg font-bold text-white">M</div>
                @endif
                <span class="sr-only">{{ $siteName }}</span>
            </a>

            <nav class="hidden xl:flex xl:flex-1 xl:items-center xl:justify-center xl:gap-2" aria-label="Navigation principale">
                <div class="group relative">
                    <button type="button" class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-sm font-semibold text-[#2b241e] transition hover:bg-white hover:text-[#171411]">
                        Catalogue
                        <svg class="h-4 w-4 transition group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div class="invisible absolute left-1/2 top-full z-40 mt-4 w-[min(1240px,calc(100vw-3rem))] -translate-x-1/2 translate-y-2 rounded-[32px] border border-[#eadfce] bg-white p-7 opacity-0 shadow-[0_24px_70px_rgba(23,20,17,0.12)] transition-all duration-200 group-hover:visible group-hover:-translate-x-1/2 group-hover:translate-y-0 group-hover:opacity-100">
                        <div class="grid gap-6 lg:grid-cols-[1.4fr_0.8fr]">
                            <div>
                                <div class="mb-5 flex items-end justify-between gap-4">
                                    <div>
                                        <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#b88a3b]">Explorer par univers</div>
                                        <h3 class="font-display mt-2 text-2xl font-bold text-[#171411]">Choisissez la pièce à aménager, puis découvrez les meubles faits pour elle.</h3>
                                    </div>
                                    <a href="{{ $catalogUrl }}" class="inline-flex items-center gap-2 text-sm font-semibold text-[#6d6156] transition hover:text-[#171411]"><i class="fa-solid fa-arrow-right text-xs"></i>Tout le catalogue</a>
                                </div>

                                <div class="grid gap-4 md:grid-cols-2">
                                    @foreach($navRooms as $room)
                                        <a href="{{ $room['href'] }}" class="group/room rounded-[26px] border border-[#eee4d5] bg-[#faf7f1] p-4 transition hover:-translate-y-1 hover:border-[#d8c3a0] hover:bg-white hover:shadow-[0_18px_40px_rgba(23,20,17,0.08)]">
                                            <div class="flex items-start gap-4">
                                                <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-2xl bg-[#e8dfd2]">
                                                    @if(!empty($room['image']))
                                                        <img src="{{ $imageUrl($room['image']) }}" alt="{{ $room['name'] }}" class="h-full w-full object-cover transition duration-500 group-hover/room:scale-105">
                                                    @else
                                                        <div class="flex h-full w-full items-center justify-center bg-[#efe5d7] font-display text-2xl font-bold text-[#8d7658]">{{ strtoupper(mb_substr($room['name'], 0, 1)) }}</div>
                                                    @endif
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <div class="flex items-center justify-between gap-3">
                                                        <h4 class="font-display text-lg font-semibold text-[#171411]">{{ $room['name'] }}</h4>
                                                        <span class="rounded-full bg-white px-2.5 py-1 text-[11px] font-bold text-[#876b43] ring-1 ring-[#eadfce]">{{ $room['count'] }}</span>
                                                    </div>
                                                    <p class="mt-1 text-sm leading-6 text-[#66584d]">{{ $room['tagline'] }}</p>
                                                    @if(collect($room['subitems'])->isNotEmpty())
                                                        <div class="mt-3 flex flex-wrap gap-2">
                                                            @foreach(collect($room['subitems'])->take(3) as $subitem)
                                                                <span class="rounded-full bg-white px-2.5 py-1 text-[11px] font-semibold text-[#57493f] ring-1 ring-[#efe4d6]">{{ $subitem }}</span>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>

                            <div class="rounded-[30px] bg-[#171411] p-5 text-white">
                                <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#d5b170]">Accès rapides</div>
                                <h3 class="font-display mt-2 text-2xl font-bold">Acheter un meuble, meubler une pièce ou lancer un projet.</h3>
                                <p class="mt-3 text-sm leading-7 text-white/72">
                                    Choisissez la manière qui vous convient le mieux: aller droit au produit, avancer pièce par pièce, ou demander une étude sur mesure.
                                </p>

                                <div class="mt-5 space-y-3">
                                    <a href="{{ $catalogUrl }}" class="block rounded-2xl bg-white/8 px-4 py-3 transition hover:bg-white/12">
                                        <div class="text-xs font-bold uppercase tracking-[0.18em] text-[#d5b170]">Catalogue</div>
                                        <div class="mt-1 flex items-center gap-2 text-base font-semibold"><i class="fa-solid fa-grid-2 text-sm"></i>Voir tous les meubles</div>
                                    </a>
                                    <a href="{{ $composeUrl }}" class="block rounded-2xl bg-white/8 px-4 py-3 transition hover:bg-white/12">
                                        <div class="text-xs font-bold uppercase tracking-[0.18em] text-[#d5b170]">Composer</div>
                                        <div class="mt-1 flex items-center gap-2 text-base font-semibold"><i class="fa-solid fa-layer-group text-sm"></i>Construire une chambre ou un salon</div>
                                    </a>
                                    <a href="{{ $surMesureUrl }}" class="block rounded-2xl bg-white/8 px-4 py-3 transition hover:bg-white/12">
                                        <div class="text-xs font-bold uppercase tracking-[0.18em] text-[#d5b170]">Sur mesure</div>
                                        <div class="mt-1 flex items-center gap-2 text-base font-semibold"><i class="fa-solid fa-ruler-combined text-sm"></i>Cuisine, dressing, aluminium, ferronnerie</div>
                                    </a>
                                </div>

                                @if($composerTypes->isNotEmpty())
                                    <div class="mt-5 border-t border-white/10 pt-5">
                                        <div class="text-xs font-bold uppercase tracking-[0.18em] text-white/45">Départs fréquents</div>
                                        <div class="mt-3 grid gap-2">
                                            @foreach($composerTypes as $entry)
                                                <a href="{{ $entry['href'] }}" class="rounded-2xl border border-white/10 px-4 py-3 text-sm font-semibold text-white/85 transition hover:bg-white/8">
                                                    {{ $entry['name'] }}
                                                    <span class="mt-1 block text-xs font-medium text-white/45">{{ $entry['badge'] }}</span>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <a href="{{ $composeUrl }}" class="rounded-full px-4 py-2 text-sm font-semibold text-[#2b241e] transition hover:bg-white hover:text-[#171411]">Composer</a>
                <a href="{{ $surMesureUrl }}" class="rounded-full px-4 py-2 text-sm font-semibold text-[#2b241e] transition hover:bg-white hover:text-[#171411]">Sur mesure</a>
                <a href="{{ $atelierUrl }}" class="rounded-full px-4 py-2 text-sm font-semibold text-[#2b241e] transition hover:bg-white hover:text-[#171411]">Ateliers</a>
                <a href="{{ $contactUrl }}" class="rounded-full px-4 py-2 text-sm font-semibold text-[#2b241e] transition hover:bg-white hover:text-[#171411]">Contact</a>
            </nav>

            <form action="{{ $searchUrl }}" method="get" class="hidden lg:flex lg:w-full lg:max-w-sm xl:max-w-md"
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
                      if (e.key === 'Enter' && this.highlighted >= 0 && this.results[this.highlighted]) {
                        e.preventDefault();
                        window.location.href = this.results[this.highlighted].url;
                      }
                      if (e.key === 'Escape') { this.open = false; }
                    }
                  }"
                  @keydown.window.escape="open = false"
                  @click.outside="open = false">
                <div class="relative w-full">
                    <input name="q" type="search" x-model="q" @input.debounce.200ms="fetchSuggest()" @keydown="onKeydown($event)" @focus="fetchSuggest()"
                           placeholder="Rechercher lit, dressing, meuble TV..."
                           class="w-full rounded-full border border-[#eadfce] bg-white px-5 py-3 pl-12 text-sm text-[#171411] placeholder:text-[#85796d] focus:border-[#c7a36a] focus:ring-0">
                    <svg class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-[#85796d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>

                    <div x-show="open" x-transition class="absolute z-50 mt-3 w-full overflow-hidden rounded-[26px] border border-[#eadfce] bg-white shadow-[0_24px_60px_rgba(23,20,17,0.14)]">
                        <template x-if="loading">
                            <div class="px-4 py-3 text-sm text-[#6d6156]">Recherche en cours...</div>
                        </template>
                        <ul role="listbox" class="max-h-80 overflow-auto divide-y divide-[#f1e7da]">
                            <template x-for="(item, i) in results" :key="item.slug">
                                <li :class="['flex cursor-pointer items-center gap-3 px-4 py-3 transition-colors', highlighted === i ? 'bg-[#f8f1e4]' : 'hover:bg-[#faf5ec]']"
                                    @mouseenter="highlighted = i"
                                    @mouseleave="highlighted = -1"
                                    @click="window.location.href = item.url">
                                    <img :src="item.image || 'https://via.placeholder.com/64x64?text=%20'" alt="" class="h-12 w-12 rounded-2xl border border-[#efe4d6] object-cover">
                                    <div class="min-w-0 flex-1">
                                        <div class="truncate text-sm font-semibold text-[#171411]" x-text="item.title"></div>
                                        <div class="text-xs font-bold text-[#a47834]" x-text="item.price || ''"></div>
                                    </div>
                                </li>
                            </template>
                            <template x-if="!loading && results.length === 0">
                                <li class="px-4 py-3 text-sm text-[#6d6156]">Aucun résultat trouvé</li>
                            </template>
                        </ul>
                    </div>
                </div>
            </form>

            <div class="ml-auto flex items-center gap-3">
                <a href="{{ $contactUrl }}" class="hidden lg:inline-flex items-center gap-2 whitespace-nowrap rounded-full bg-[#171411] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#b88a3b]">
                    <i class="fa-regular fa-pen-to-square text-sm"></i>
                    Demander un devis
                </a>

                <button id="mobile-menu-toggle" class="inline-flex h-12 w-12 items-center justify-center rounded-2xl border border-[#eadfce] bg-white text-[#171411] transition hover:bg-[#f6efe5] xl:hidden" aria-label="Ouvrir le menu">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div id="mobile-menu" class="fixed inset-0 z-[60] hidden bg-[#171411]/45 backdrop-blur-sm xl:hidden">
        <div class="absolute right-0 top-0 h-full w-full max-w-sm overflow-y-auto bg-[#fbf7f0] shadow-2xl">
            <div class="flex items-center justify-between border-b border-[#eadfce] px-5 py-4">
                <div>
                    <div class="text-xs font-bold uppercase tracking-[0.2em] text-[#b88a3b]">Maison 216</div>
                    <div class="font-display text-lg font-bold text-[#171411]">Catalogue, composition, sur mesure</div>
                </div>
                <button id="mobile-menu-close" class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-[#eadfce] bg-white text-[#171411]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="border-b border-[#eadfce] px-5 py-4">
                <form action="{{ $searchUrl }}" method="get" class="flex gap-2">
                    <input name="q" type="search" value="{{ request('q') }}" placeholder="Rechercher un meuble..."
                           class="min-w-0 flex-1 rounded-2xl border border-[#eadfce] bg-white px-4 py-3 text-sm focus:border-[#c7a36a] focus:ring-0">
                    <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-[#171411] px-4 text-white">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </form>
            </div>

            <div class="space-y-3 px-5 py-5">
                <a href="{{ $catalogUrl }}" class="block rounded-2xl border border-[#eadfce] bg-white px-4 py-3 font-semibold text-[#171411]">Catalogue</a>
                <a href="{{ $composeUrl }}" class="block rounded-2xl bg-[#171411] px-4 py-3 font-semibold text-white">Composer une pièce</a>
                <a href="{{ $surMesureUrl }}" class="block rounded-2xl bg-[#efe2cb] px-4 py-3 font-semibold text-[#171411]">Projet sur mesure</a>
                <a href="{{ $atelierUrl }}" class="block rounded-2xl border border-[#eadfce] bg-white px-4 py-3 font-semibold text-[#171411]">Nos ateliers</a>
                <a href="{{ $contactUrl }}" class="block rounded-2xl border border-[#eadfce] bg-white px-4 py-3 font-semibold text-[#171411]">Contact</a>
            </div>

            <div class="border-t border-[#eadfce] px-5 py-5">
                <div class="mb-3 text-xs font-bold uppercase tracking-[0.18em] text-[#7b6d5f]">Explorer les univers</div>
                <div class="space-y-3">
                    @foreach($navRooms as $room)
                        <details class="rounded-2xl border border-[#eadfce] bg-white">
                            <summary class="flex cursor-pointer list-none items-center justify-between gap-3 px-4 py-4">
                                <div>
                                    <div class="font-semibold text-[#171411]">{{ $room['name'] }}</div>
                                    <div class="mt-1 text-sm text-[#6d6156]">{{ $room['count'] }} produits</div>
                                </div>
                                <svg class="h-5 w-5 text-[#6d6156]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </summary>
                            <div class="space-y-3 px-4 pb-4">
                                <a href="{{ $room['href'] }}" class="block rounded-xl bg-[#f8f1e4] px-3 py-3 text-sm font-semibold text-[#8e6322]">Voir l’univers</a>
                                @foreach(collect($room['subitems'])->take(4) as $subitem)
                                    <div class="text-sm text-[#5f5146]">{{ $subitem }}</div>
                                @endforeach
                            </div>
                        </details>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('mobile-menu-toggle');
    const closeBtn = document.getElementById('mobile-menu-close');
    const mobileMenu = document.getElementById('mobile-menu');

    if (!toggleBtn || !mobileMenu) return;

    const closeMenu = () => {
        mobileMenu.classList.add('hidden');
        document.body.style.overflow = '';
    };

    toggleBtn.addEventListener('click', () => {
        mobileMenu.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    });

    closeBtn?.addEventListener('click', closeMenu);

    mobileMenu.addEventListener('click', (event) => {
        if (event.target === mobileMenu) {
            closeMenu();
        }
    });
});
</script>
