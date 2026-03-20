@php
    $catalog = app(\App\Support\StorefrontCatalog::class);

    $wa = \App\Models\Setting::get('contact.whatsapp');
    $logo = \App\Models\Setting::get('ui.logo');
    $siteName = \App\Models\Setting::get('site.name', 'Maison 216');
    $tagline = \App\Models\Setting::get('site.tagline', 'Fabriqué pour la Tunisie');

    $navRooms = $catalog->showcaseRooms(6);
    $composerTypes = $catalog->composerTypes(4);

    $homeUrl = route('home');
    $composeUrl = url('/#composer');
    $surMesureUrl = url('/#sur-mesure');
    $atelierUrl = url('/#atelier');
    $contactUrl = route('contact');
@endphp

<div class="relative overflow-hidden bg-dark-950 text-white">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(182,147,82,0.16),_transparent_30%),radial-gradient(circle_at_bottom_right,_rgba(255,255,255,0.08),_transparent_30%)]"></div>
    <div class="container relative z-10 mx-auto flex flex-wrap items-center justify-between gap-3 px-4 py-2 text-xs font-medium sm:text-sm">
        <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-white/85">
            <span>Atelier bois, alu & fer</span>
            <span class="hidden sm:inline">Livraison partout en Tunisie</span>
            <span class="hidden lg:inline">Paiement à la livraison selon le produit</span>
        </div>

        <div class="flex items-center gap-3">
            @if($wa)
                <a href="https://wa.me/{{ preg_replace('/\D+/', '', (string) $wa) }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-white hover:bg-white/20">
                    <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                    WhatsApp
                </a>
            @endif
            <a href="{{ $contactUrl }}" class="text-white/80 hover:text-white">Conseil & devis</a>
        </div>
    </div>
</div>

<header class="sticky top-0 z-50 border-b border-dark-100 bg-white/95 shadow-sm backdrop-blur">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between gap-4 py-4">
            <a href="{{ $homeUrl }}" class="flex items-center gap-3">
                @if($logo)
                    <img src="{{ $logo }}" alt="{{ $siteName }}" class="h-11 w-auto">
                @else
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-dark-900 text-lg font-bold text-white">M</div>
                @endif
                <div class="hidden sm:block">
                    <div class="text-base font-bold text-dark-900">{{ $siteName }}</div>
                    <div class="text-xs text-dark-500">{{ $tagline }}</div>
                </div>
            </a>

            <nav class="hidden xl:flex items-center gap-2" aria-label="Navigation principale">
                <div class="group relative">
                    <button type="button" class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-sm font-semibold text-dark-800 transition hover:bg-dark-50 hover:text-primary-700">
                        Découvrir
                        <svg class="h-4 w-4 transition group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div class="invisible absolute left-0 top-full z-40 mt-4 w-[920px] max-w-[90vw] translate-y-2 rounded-[28px] border border-dark-100 bg-white p-6 opacity-0 shadow-2xl transition-all duration-200 group-hover:visible group-hover:translate-y-0 group-hover:opacity-100">
                        <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_280px]">
                            <div>
                                <div class="mb-4 flex items-center justify-between">
                                    <div>
                                        <div class="text-sm font-semibold uppercase tracking-[0.18em] text-primary-600">Univers</div>
                                        <h3 class="text-2xl font-bold text-dark-900">Entrer par la pièce, pas par le bruit du catalogue.</h3>
                                    </div>
                                    <a href="{{ route('categories.index') }}" class="text-sm font-semibold text-dark-500 hover:text-primary-700">Voir tout</a>
                                </div>

                                <div class="grid gap-4 md:grid-cols-2">
                                    @foreach($navRooms as $room)
                                        <a href="{{ $room['href'] }}" class="group/room overflow-hidden rounded-3xl border border-dark-100 bg-dark-50 transition hover:-translate-y-1 hover:border-primary-300 hover:bg-white hover:shadow-xl">
                                            <div class="aspect-[16/9] overflow-hidden bg-dark-100">
                                                @if(!empty($room['image']))
                                                    <img src="{{ \Illuminate\Support\Str::startsWith($room['image'], ['http://', 'https://']) ? $room['image'] : asset($room['image']) }}" alt="{{ $room['name'] }}" class="h-full w-full object-cover transition duration-500 group-hover/room:scale-105">
                                                @else
                                                    <div class="flex h-full w-full items-center justify-center bg-[radial-gradient(circle_at_top,_rgba(182,147,82,0.25),transparent_50%),linear-gradient(135deg,#f7f2e8,#ece6d8)] text-4xl font-bold text-dark-300">{{ strtoupper(mb_substr($room['name'], 0, 1)) }}</div>
                                                @endif
                                            </div>
                                            <div class="space-y-3 p-5">
                                                <div class="flex items-start justify-between gap-4">
                                                    <div>
                                                        <h4 class="text-lg font-bold text-dark-900">{{ $room['name'] }}</h4>
                                                        <p class="mt-1 text-sm leading-6 text-dark-600">{{ $room['tagline'] }}</p>
                                                    </div>
                                                    <span class="rounded-full bg-primary-100 px-3 py-1 text-xs font-semibold text-primary-700">{{ $room['count'] }} produits</span>
                                                </div>
                                                @if(collect($room['subitems'])->isNotEmpty())
                                                    <div class="flex flex-wrap gap-2">
                                                        @foreach(collect($room['subitems'])->take(4) as $subitem)
                                                            <span class="rounded-full bg-white px-3 py-1 text-xs font-medium text-dark-700 ring-1 ring-dark-100">{{ $subitem }}</span>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>

                            <div class="rounded-3xl bg-dark-900 p-5 text-white">
                                <div class="text-sm font-semibold uppercase tracking-[0.18em] text-primary-300">Parcours</div>
                                <h3 class="mt-2 text-2xl font-bold">Composer plus vite</h3>
                                <p class="mt-3 text-sm leading-6 text-white/75">
                                    Commencez par un type de meuble, puis affinez vers la composition, la collection ou le devis.
                                </p>

                                <div class="mt-5 space-y-3">
                                    @foreach($composerTypes as $entry)
                                        <a href="{{ $entry['href'] }}" class="block rounded-2xl border border-white/10 bg-white/5 p-4 transition hover:bg-white/10">
                                            <div class="text-xs font-semibold uppercase tracking-[0.16em] text-primary-300">{{ $entry['eyebrow'] }}</div>
                                            <div class="mt-1 text-base font-semibold">{{ $entry['name'] }}</div>
                                            <div class="mt-1 text-sm text-white/70">{{ $entry['badge'] }}</div>
                                        </a>
                                    @endforeach
                                </div>

                                <a href="{{ $contactUrl }}" class="mt-5 inline-flex items-center gap-2 rounded-full bg-primary-500 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-400">
                                    Demander un devis
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5-5 5M6 12h12" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="{{ $composeUrl }}" class="rounded-full px-4 py-2 text-sm font-semibold text-dark-800 transition hover:bg-dark-50 hover:text-primary-700">Composer</a>
                <a href="{{ $surMesureUrl }}" class="rounded-full px-4 py-2 text-sm font-semibold text-dark-800 transition hover:bg-dark-50 hover:text-primary-700">Sur mesure</a>
                <a href="{{ $atelierUrl }}" class="rounded-full px-4 py-2 text-sm font-semibold text-dark-800 transition hover:bg-dark-50 hover:text-primary-700">Ateliers</a>
                <a href="{{ $contactUrl }}" class="rounded-full px-4 py-2 text-sm font-semibold text-dark-800 transition hover:bg-dark-50 hover:text-primary-700">Contact</a>
            </nav>

            <form action="{{ route('search') }}" method="get" class="hidden lg:flex items-center w-full max-w-md xl:max-w-lg"
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
                           class="w-full rounded-full border border-dark-200 bg-dark-50 px-5 py-3 pl-12 text-sm text-dark-900 placeholder:text-dark-400 focus:border-primary-500 focus:bg-white focus:ring-0">
                    <svg class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>

                    <div x-show="open" x-transition class="absolute z-50 mt-3 w-full overflow-hidden rounded-3xl border border-dark-100 bg-white shadow-2xl">
                        <template x-if="loading">
                            <div class="px-4 py-3 text-sm text-dark-500">Recherche en cours...</div>
                        </template>
                        <ul role="listbox" class="max-h-80 overflow-auto divide-y divide-dark-50">
                            <template x-for="(item, i) in results" :key="item.slug">
                                <li :class="['flex cursor-pointer items-center gap-3 px-4 py-3 transition-colors', highlighted === i ? 'bg-primary-50' : 'hover:bg-dark-50']"
                                    @mouseenter="highlighted = i"
                                    @mouseleave="highlighted = -1"
                                    @click="window.location.href = item.url">
                                    <img :src="item.image || 'https://via.placeholder.com/64x64?text=%20'" alt="" class="h-12 w-12 rounded-2xl border border-dark-100 object-cover">
                                    <div class="min-w-0 flex-1">
                                        <div class="truncate text-sm font-semibold text-dark-900" x-text="item.title"></div>
                                        <div class="text-xs font-medium text-primary-600" x-text="item.price || ''"></div>
                                    </div>
                                </li>
                            </template>
                            <template x-if="!loading && results.length === 0">
                                <li class="px-4 py-3 text-sm text-dark-500">Aucun résultat trouvé</li>
                            </template>
                        </ul>
                    </div>
                </div>
            </form>

            <div class="flex items-center gap-3">
                <a href="{{ $contactUrl }}" class="hidden lg:inline-flex items-center gap-2 rounded-full bg-dark-900 px-4 py-3 text-sm font-semibold text-white hover:bg-primary-700">
                    Demander un devis
                </a>

                <button id="mobile-menu-toggle" class="inline-flex h-12 w-12 items-center justify-center rounded-2xl border border-dark-200 text-dark-800 transition hover:bg-dark-50 xl:hidden" aria-label="Ouvrir le menu">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div id="mobile-menu" class="fixed inset-0 z-[60] hidden bg-dark-950/60 backdrop-blur-sm xl:hidden">
        <div class="absolute right-0 top-0 h-full w-full max-w-sm overflow-y-auto bg-white shadow-2xl">
            <div class="flex items-center justify-between border-b border-dark-100 px-5 py-4">
                <div>
                    <div class="text-sm font-semibold uppercase tracking-[0.18em] text-primary-600">Maison 216</div>
                    <div class="text-lg font-bold text-dark-900">Découvrir, composer, demander</div>
                </div>
                <button id="mobile-menu-close" class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-dark-200 text-dark-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="border-b border-dark-100 px-5 py-4">
                <form action="{{ route('search') }}" method="get" class="flex gap-2">
                    <input name="q" type="search" value="{{ request('q') }}" placeholder="Rechercher un meuble..."
                           class="min-w-0 flex-1 rounded-2xl border border-dark-200 bg-dark-50 px-4 py-3 text-sm focus:border-primary-500 focus:ring-0">
                    <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-dark-900 px-4 text-white">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </form>
            </div>

            <div class="space-y-3 px-5 py-5">
                <a href="{{ $composeUrl }}" class="block rounded-2xl bg-dark-900 px-4 py-3 font-semibold text-white">Composer une pièce</a>
                <a href="{{ $surMesureUrl }}" class="block rounded-2xl bg-primary-50 px-4 py-3 font-semibold text-primary-700">Projet sur mesure</a>
                <a href="{{ $atelierUrl }}" class="block rounded-2xl border border-dark-200 px-4 py-3 font-semibold text-dark-800">Nos ateliers</a>
                <a href="{{ $contactUrl }}" class="block rounded-2xl border border-dark-200 px-4 py-3 font-semibold text-dark-800">Contact</a>
            </div>

            <div class="border-t border-dark-100 px-5 py-5">
                <div class="mb-3 text-sm font-semibold uppercase tracking-[0.16em] text-dark-500">Découvrir</div>
                <div class="space-y-3">
                    @foreach($navRooms as $room)
                        <details class="rounded-2xl border border-dark-100 bg-dark-50">
                            <summary class="flex cursor-pointer list-none items-center justify-between gap-3 px-4 py-4">
                                <div>
                                    <div class="font-semibold text-dark-900">{{ $room['name'] }}</div>
                                    <div class="mt-1 text-sm text-dark-500">{{ $room['count'] }} produits</div>
                                </div>
                                <svg class="h-5 w-5 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </summary>
                            <div class="space-y-3 px-4 pb-4">
                                <a href="{{ $room['href'] }}" class="block rounded-xl bg-white px-3 py-3 text-sm font-medium text-primary-700 ring-1 ring-dark-100">Voir l’univers</a>
                                @foreach(collect($room['subitems'])->take(4) as $subitem)
                                    <div class="text-sm text-dark-600">{{ $subitem }}</div>
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
