@php
    $siteStructure = app(\App\Support\SiteStructure::class);
    $wa = \App\Models\Setting::get('contact.whatsapp');
    $ms = \App\Models\Setting::get('contact.messenger');
    $logo = \App\Models\Setting::get('ui.logo');
    $siteName = \App\Models\Setting::get('site.name', 'Maison 216');

    $footerNavigation = $siteStructure->mainNavigation();
    $logoUrl = $logo
        ? (\Illuminate\Support\Str::startsWith($logo, ['http://', 'https://', '/']) ? $logo : asset($logo))
        : null;
    $whatsappUrl = $wa ? 'https://wa.me/' . preg_replace('/\D+/', '', (string) $wa) : null;
    $footerHighlights = collect([
        ['icon' => 'fa-solid fa-truck-fast', 'label' => 'Livraison à domicile'],
        ['icon' => 'fa-solid fa-hand-holding-dollar', 'label' => 'Paiement à la livraison'],
        ['icon' => 'fa-solid fa-medal', 'label' => 'Made in Tunisia'],
    ]);
@endphp

<footer class="border-t border-[#2c2620] bg-[#171411] text-white">
    <div class="container mx-auto px-4 py-14 lg:py-16">
        <div class="grid gap-12 lg:grid-cols-[1.25fr_0.75fr_0.75fr_0.8fr]">
            <div class="max-w-md">
                @if($logoUrl)
                    <img src="{{ $logoUrl }}" alt="{{ $siteName }}" class="h-12 w-auto opacity-95">
                @else
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-lg font-bold text-[#171411]">M</div>
                @endif

                <p class="mt-6 text-base leading-8 text-white/72">
                    Maison 216 vous aide à meubler votre intérieur, à harmoniser chaque pièce et à lancer un projet sur mesure avec plus de clarté, de goût et d’accompagnement.
                </p>

                <div class="mt-7 flex flex-wrap gap-3">
                    <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 rounded-full bg-white px-5 py-3 text-sm font-semibold text-[#171411] transition hover:bg-[#efe2cb]">
                        <i class="fa-regular fa-pen-to-square text-sm"></i>
                        Demander un devis
                    </a>
                    @if($whatsappUrl)
                        <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full border border-white/15 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/10">
                            <i class="fa-brands fa-whatsapp text-base"></i>
                            WhatsApp
                        </a>
                    @endif
                </div>

                <div class="mt-8 flex flex-wrap items-center gap-x-6 gap-y-3 text-sm font-semibold text-white/72">
                    @foreach($footerHighlights as $item)
                        <div class="inline-flex items-center gap-3">
                            <span class="text-[#d5b170]">
                                <i class="{{ $item['icon'] }}"></i>
                            </span>
                            {{ $item['label'] }}
                        </div>
                        @if(!$loop->last)
                            <span class="hidden h-4 w-px bg-white/12 lg:block"></span>
                        @endif
                    @endforeach
                </div>
            </div>

            <div>
                <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#d5b170]">Structure</div>
                <ul class="mt-5 space-y-3.5">
                    @foreach($footerNavigation->take(7) as $item)
                        <li>
                            <a href="{{ $item['href'] }}" class="inline-flex items-center gap-2 text-sm text-white/72 transition hover:text-white">
                                <i class="fa-solid fa-angle-right text-[11px] text-[#8f7351]"></i>
                                {{ $item['title'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#d5b170]">Découvrir</div>
                <ul class="mt-5 space-y-3.5 text-sm text-white/72">
                    <li><a href="{{ url('/meubles') }}" class="inline-flex items-center gap-2 transition hover:text-white"><i class="fa-solid fa-angle-right text-[11px] text-[#8f7351]"></i>Meubles</a></li>
                    <li><a href="{{ url('/menuiserie-bois') }}" class="inline-flex items-center gap-2 transition hover:text-white"><i class="fa-solid fa-angle-right text-[11px] text-[#8f7351]"></i>Menuiserie bois</a></li>
                    <li><a href="{{ url('/aluminium') }}" class="inline-flex items-center gap-2 transition hover:text-white"><i class="fa-solid fa-angle-right text-[11px] text-[#8f7351]"></i>Menuiserie Alu</a></li>
                    <li><a href="{{ url('/fer-metal') }}" class="inline-flex items-center gap-2 transition hover:text-white"><i class="fa-solid fa-angle-right text-[11px] text-[#8f7351]"></i>Fabrication métallique</a></li>
                    <li><a href="{{ url('/cuisine-dressing') }}" class="inline-flex items-center gap-2 transition hover:text-white"><i class="fa-solid fa-angle-right text-[11px] text-[#8f7351]"></i>Sur mesure</a></li>
                    <li><a href="{{ route('search') }}" class="inline-flex items-center gap-2 transition hover:text-white"><i class="fa-solid fa-angle-right text-[11px] text-[#8f7351]"></i>Recherche</a></li>
                    <li><a href="{{ url('/devis') }}" class="inline-flex items-center gap-2 transition hover:text-white"><i class="fa-solid fa-angle-right text-[11px] text-[#8f7351]"></i>Devis</a></li>
                </ul>
            </div>

            <div>
                <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#d5b170]">Infos utiles</div>
                <div class="mt-5 space-y-3.5 text-sm text-white/72">
                    @if($wa)
                        <div class="inline-flex items-center gap-2">
                            <i class="fa-brands fa-whatsapp text-[#8f7351]"></i>
                            {{ $wa }}
                        </div>
                    @endif
                    @if($ms)
                        <a href="{{ $ms }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 transition hover:text-white">
                            <i class="fa-brands fa-facebook-messenger text-[#8f7351]"></i>
                            Messenger
                        </a>
                    @endif
                    <a href="{{ route('legal.cgv') }}" class="inline-flex items-center gap-2 transition hover:text-white">
                        <i class="fa-solid fa-angle-right text-[11px] text-[#8f7351]"></i>
                        Conditions générales
                    </a>
                    <a href="{{ route('legal.confidentialite') }}" class="inline-flex items-center gap-2 transition hover:text-white">
                        <i class="fa-solid fa-angle-right text-[11px] text-[#8f7351]"></i>
                        Confidentialité
                    </a>
                    <a href="{{ route('legal.livraison') }}" class="inline-flex items-center gap-2 transition hover:text-white">
                        <i class="fa-solid fa-angle-right text-[11px] text-[#8f7351]"></i>
                        Livraison & retours
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-12 flex flex-col gap-3 border-t border-white/10 pt-6 text-sm text-white/42 md:flex-row md:items-center md:justify-between">
            <p>&copy; {{ date('Y') }} {{ $siteName }}. Mobilier et projets atelier pour la Tunisie.</p>
            <p>Du meuble prêt à commander au projet pensé pour votre maison.</p>
        </div>
    </div>
</footer>
