@php
    $siteStructure = app(\App\Support\SiteStructure::class);

    $wa = \App\Models\Setting::get('contact.whatsapp');
    $logo = \App\Models\Setting::get('ui.logo');
    $siteName = \App\Models\Setting::get('site.name', 'Maison 216');

    $node = fn (string $path): array => $siteStructure->find($path) ?? [];
    $children = fn (string $path): array => $node($path)['children'] ?? [];

    $homeUrl = route('home');
    $devisUrl = url('/devis');
    $searchUrl = route('search');
    $whatsappUrl = $wa ? 'https://wa.me/' . preg_replace('/\D+/', '', (string) $wa) : null;
    $topBarPhone = '96 813 203';
    $topBarWhatsappUrl = 'https://wa.me/21696813203';
    $logoUrl = $logo
        ? (\Illuminate\Support\Str::startsWith($logo, ['http://', 'https://', '/']) ? $logo : asset($logo))
        : null;

    $serviceNavigation = collect([
        [
            'title' => 'Menuiserie bois',
            'href' => url('/menuiserie-bois'),
            'description' => $node('menuiserie-bois')['description'] ?? 'Meubles et amenagements bois pour la maison et les espaces professionnels.',
            'children' => [],
        ],
        [
            'title' => 'Menuiserie alu',
            'href' => url('/aluminium'),
            'description' => $node('aluminium')['description'] ?? 'Fenêtres, portes, garde-corps et protections aluminium.',
            'children' => $children('aluminium'),
        ],
        [
            'title' => 'Fabrication métallique',
            'href' => url('/fer-metal'),
            'description' => $node('fer-metal')['description'] ?? 'Portails, pergolas, garde-corps et escaliers métalliques.',
            'children' => $children('fer-metal'),
        ],
        [
            'title' => 'Sur mesure',
            'href' => url('/sur-mesure'),
            'description' => $node('sur-mesure')['description'] ?? 'Cuisine, dressing, placard, meuble TV et bureau sur mesure.',
            'children' => $children('sur-mesure'),
        ],
    ]);

    $projectRoot = $node('projets');
    $projectNavigation = collect($projectRoot['children'] ?? []);
@endphp

<div class="border-b border-[#e8dcc7] bg-[#efe2cb] text-[#4f4236]">
    <div class="container mx-auto hidden items-center justify-between gap-4 px-4 py-2 text-sm font-semibold sm:flex">
        <div class="flex items-center gap-3 whitespace-nowrap">
            <span class="inline-flex items-center gap-2"><i class="fa-solid fa-screwdriver-wrench text-[#a47834]"></i>Atelier Maison216</span>
            <span class="text-[#b58b51]">|</span>
            <span>Devis gratuit</span>
            <span class="text-[#b58b51]">|</span>
            <span>Pose & SAV inclus</span>
        </div>

        <a href="{{ $topBarWhatsappUrl }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 whitespace-nowrap rounded-full bg-white/70 px-3 py-1 text-[#2b241e] transition hover:bg-white">
            <i class="fa-brands fa-whatsapp text-[#a47834]"></i>
            Téléphone/Whatsapp : {{ $topBarPhone }}
        </a>
    </div>

    <div class="container mx-auto flex items-center justify-center px-3 py-2 text-[11px] font-semibold leading-none text-[#4f4236] sm:hidden">
        <a href="{{ $topBarWhatsappUrl }}" target="_blank" rel="noopener" class="inline-flex min-w-0 items-center justify-center gap-2 whitespace-nowrap">
            <span>Devis gratuit</span>
            <span class="text-[#b58b51]">|</span>
            <span>Pose & SAV inclus</span>
            <span class="text-[#b58b51]">|</span>
            <span>{{ $topBarPhone }}</span>
        </a>
    </div>
</div>

<header class="sticky top-0 z-50 border-b border-[#eadfce] bg-[#fbf7f0]/96 backdrop-blur">
    <div class="container mx-auto px-4">
        <div class="flex items-center gap-4 py-4">
            <a href="{{ $homeUrl }}" class="flex shrink-0 items-center">
                @if($logoUrl)
                    <img src="{{ $logoUrl }}" alt="{{ $siteName }}" class="h-11 w-auto sm:h-12">
                @else
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#171411] text-lg font-bold text-white">M</div>
                @endif
                <span class="sr-only">{{ $siteName }}</span>
            </a>

            <form action="{{ $searchUrl }}" method="get" class="hidden min-w-[260px] flex-1 lg:flex xl:max-w-[430px]"
                  x-data="{
                    q: @js((string) request('q')),
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

            <nav class="hidden shrink-0 items-center gap-1 xl:flex" aria-label="Navigation ateliers et sur mesure">
                @foreach($serviceNavigation as $item)
                    @if(collect($item['children'] ?? [])->isNotEmpty())
                        <div class="group relative">
                            <a href="{{ $item['href'] }}" class="inline-flex items-center gap-2 rounded-full px-3 py-2 text-sm font-semibold text-[#2b241e] transition hover:bg-white hover:text-[#171411]">
                                {{ $item['title'] }}
                                <i class="fa-solid fa-chevron-down text-[10px] transition group-hover:rotate-180"></i>
                            </a>

                            <div class="invisible absolute left-1/2 top-full z-40 mt-4 w-[min(760px,calc(100vw-3rem))] -translate-x-1/2 translate-y-2 rounded-3xl border border-[#eadfce] bg-white p-6 opacity-0 shadow-[0_24px_70px_rgba(23,20,17,0.12)] transition-all duration-200 group-hover:visible group-hover:translate-y-0 group-hover:opacity-100">
                                <div class="grid gap-6 md:grid-cols-[0.8fr_1.2fr]">
                                    <div>
                                        <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#b88a3b]">{{ $item['title'] }}</div>
                                        <p class="mt-3 text-sm leading-7 text-[#5f5146]">{{ $item['description'] }}</p>
                                        <a href="{{ $item['href'] }}" class="mt-5 inline-flex items-center gap-2 rounded-full bg-[#171411] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#b88a3b]">
                                            Voir la rubrique
                                            <i class="fa-solid fa-arrow-right text-xs"></i>
                                        </a>
                                    </div>

                                    <div class="grid gap-3 sm:grid-cols-2">
                                        @foreach($item['children'] as $child)
                                            <a href="{{ $child['href'] }}" class="rounded-2xl border border-[#eee4d5] bg-[#faf7f1] p-4 transition hover:border-[#d8c3a0] hover:bg-white">
                                                <div class="font-display text-base font-bold text-[#171411]">{{ $child['title'] }}</div>
                                                <p class="mt-2 line-clamp-2 text-sm leading-6 text-[#66584d]">{{ $child['description'] }}</p>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ $item['href'] }}" class="rounded-full px-3 py-2 text-sm font-semibold text-[#2b241e] transition hover:bg-white hover:text-[#171411]">{{ $item['title'] }}</a>
                    @endif
                @endforeach
            </nav>

            <div class="ml-auto flex shrink-0 items-center gap-3">
                <a href="{{ $devisUrl }}" class="hidden items-center gap-2 whitespace-nowrap rounded-full bg-[#171411] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#b88a3b] lg:inline-flex">
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

    <div class="hidden border-t border-[#eadfce] bg-white/45 xl:block">
        <div class="container mx-auto px-4">
            <nav class="flex items-center justify-center gap-1 py-2.5" aria-label="Navigation projets">
                <a href="{{ $projectRoot['href'] ?? url('/projets') }}" class="rounded-full bg-white px-4 py-2 text-sm font-bold text-[#171411] shadow-sm ring-1 ring-[#eadfce]">
                    Projets
                </a>
                @foreach($projectNavigation as $item)
                    <a href="{{ $item['href'] }}" class="rounded-full px-4 py-2 text-sm font-semibold text-[#5f5146] transition hover:bg-white hover:text-[#171411]">
                        {{ $item['title'] }}
                    </a>
                @endforeach
            </nav>
        </div>
    </div>

</header>

<div id="mobile-menu" class="fixed inset-0 z-[100] hidden bg-[#171411]/55 backdrop-blur-sm xl:hidden" role="dialog" aria-modal="true" aria-label="Menu mobile">
    <div class="absolute inset-y-0 right-0 flex h-screen w-full max-w-[390px] flex-col overflow-hidden bg-[#fbf7f0] shadow-2xl">
        <div class="shrink-0 bg-[#171411] px-5 pb-5 pt-4 text-white">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <div class="text-[11px] font-bold uppercase tracking-[0.22em] text-[#d5b170]">Navigation</div>
                    <div class="mt-1 font-display text-xl font-bold leading-tight">Maison 216</div>
                </div>
                <button id="mobile-menu-close" class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-white/15 bg-white/8 text-white transition hover:bg-white/14" aria-label="Fermer le menu">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form action="{{ $searchUrl }}" method="get" class="mt-5 flex overflow-hidden rounded-full border border-white/10 bg-white">
                <input name="q" type="search" value="{{ request('q') }}" placeholder="Rechercher un meuble..."
                       class="min-w-0 flex-1 border-0 bg-transparent px-5 py-3 text-sm text-[#171411] placeholder:text-[#85796d] focus:ring-0">
                <button type="submit" class="inline-flex w-14 items-center justify-center bg-[#d5b170] text-[#171411]" aria-label="Rechercher">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>

            <div class="mt-4 grid grid-cols-2 gap-2">
                <a href="{{ $devisUrl }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-white px-4 py-3 text-sm font-bold text-[#171411]">
                    <i class="fa-regular fa-pen-to-square text-xs"></i>
                    Devis
                </a>
                @if($whatsappUrl)
                    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center gap-2 rounded-full border border-white/15 px-4 py-3 text-sm font-bold text-white">
                        <i class="fa-brands fa-whatsapp text-sm"></i>
                        WhatsApp
                    </a>
                @else
                    <a href="{{ route('contact') }}" class="inline-flex items-center justify-center gap-2 rounded-full border border-white/15 px-4 py-3 text-sm font-bold text-white">
                        <i class="fa-regular fa-message text-sm"></i>
                        Contact
                    </a>
                @endif
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto px-5 py-5" aria-label="Navigation mobile">
            <div class="space-y-7">
                <section>
                    <div class="mb-3 flex items-center justify-between">
                        <span class="text-[11px] font-bold uppercase tracking-[0.22em] text-[#b88a3b]">Métiers</span>
                        <span class="h-px flex-1 bg-[#eadfce] ml-4"></span>
                    </div>

                    <div class="overflow-hidden rounded-[26px] border border-[#eadfce] bg-white">
                        @foreach($serviceNavigation as $navItem)
                            @if(collect($navItem['children'] ?? [])->isNotEmpty())
                                <details class="group border-b border-[#f0e4d3] last:border-b-0">
                                    <summary class="flex cursor-pointer list-none items-center justify-between gap-3 px-4 py-4">
                                        <span class="font-semibold text-[#171411]">{{ $navItem['title'] }}</span>
                                        <i class="fa-solid fa-chevron-down text-xs text-[#b88a3b] transition group-open:rotate-180"></i>
                                    </summary>
                                    <div class="grid gap-1 bg-[#fbf7f0] px-4 pb-4 pt-1">
                                        <a href="{{ $navItem['href'] }}" class="rounded-xl px-3 py-2 text-sm font-bold text-[#8e6322]">Voir toute la rubrique</a>
                                        @foreach($navItem['children'] as $child)
                                            <a href="{{ $child['href'] }}" class="rounded-xl px-3 py-2 text-sm font-medium text-[#5f5146] transition hover:bg-white">{{ $child['title'] }}</a>
                                        @endforeach
                                    </div>
                                </details>
                            @else
                                <a href="{{ $navItem['href'] }}" class="flex items-center justify-between border-b border-[#f0e4d3] px-4 py-4 font-semibold text-[#171411] last:border-b-0">
                                    <span>{{ $navItem['title'] }}</span>
                                    <i class="fa-solid fa-arrow-right text-xs text-[#b88a3b]"></i>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </section>

                <section>
                    <div class="mb-3 flex items-center justify-between">
                        <span class="text-[11px] font-bold uppercase tracking-[0.22em] text-[#b88a3b]">Projets</span>
                        <span class="h-px flex-1 bg-[#eadfce] ml-4"></span>
                    </div>

                    <div class="grid gap-2">
                        <a href="{{ $projectRoot['href'] ?? url('/projets') }}" class="flex items-center justify-between rounded-2xl bg-[#171411] px-4 py-3 text-sm font-bold text-white">
                            <span>Tous les projets</span>
                            <i class="fa-solid fa-arrow-right text-xs text-[#d5b170]"></i>
                        </a>
                        @foreach($projectNavigation as $item)
                            <a href="{{ $item['href'] }}" class="rounded-2xl border border-[#eadfce] bg-white px-4 py-3 text-sm font-semibold leading-tight text-[#171411] transition hover:border-[#d5b170]">
                                {{ $item['title'] }}
                            </a>
                        @endforeach
                    </div>
                </section>

                <section>
                    <div class="mb-3 flex items-center justify-between">
                        <span class="text-[11px] font-bold uppercase tracking-[0.22em] text-[#b88a3b]">Aide</span>
                        <span class="h-px flex-1 bg-[#eadfce] ml-4"></span>
                    </div>

                    <div class="grid gap-2">
                        <a href="{{ $devisUrl }}" class="flex items-center justify-between rounded-2xl border border-[#eadfce] bg-white px-4 py-3 text-sm font-semibold text-[#171411]">
                            <span><i class="fa-regular fa-pen-to-square mr-2 text-[#b88a3b]"></i>Demander un devis</span>
                            <i class="fa-solid fa-arrow-right text-xs text-[#b88a3b]"></i>
                        </a>
                        <a href="{{ route('contact') }}" class="flex items-center justify-between rounded-2xl border border-[#eadfce] bg-white px-4 py-3 text-sm font-semibold text-[#171411]">
                            <span><i class="fa-regular fa-message mr-2 text-[#b88a3b]"></i>Contact</span>
                            <i class="fa-solid fa-arrow-right text-xs text-[#b88a3b]"></i>
                        </a>
                    </div>
                </section>
            </div>
        </nav>
    </div>
</div>

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
