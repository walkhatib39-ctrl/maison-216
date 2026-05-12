@php
    $ms = \App\Models\Setting::get('contact.messenger');
    $siteName = \App\Models\Setting::get('site.name', 'Maison 216');
    $logoUrl = \App\Support\SiteSettings::logoUrl();
    $whatsappUrl = \App\Support\SiteSettings::whatsappUrl();
    $phoneDisplay = \App\Support\SiteSettings::phoneDisplay();
    $publicEmail = \App\Support\SiteSettings::publicEmail();
    $address = \App\Support\SiteSettings::address();
    $serviceArea = \App\Support\SiteSettings::serviceArea();

    $socialLinks = collect([
        ['label' => 'Facebook', 'href' => \App\Models\Setting::get('social.facebook'), 'icon' => 'fa-brands fa-facebook-f'],
        ['label' => 'Instagram', 'href' => \App\Models\Setting::get('social.instagram'), 'icon' => 'fa-brands fa-instagram'],
        ['label' => 'TikTok', 'href' => \App\Models\Setting::get('social.tiktok'), 'icon' => 'fa-brands fa-tiktok'],
        ['label' => 'LinkedIn', 'href' => \App\Models\Setting::get('social.linkedin'), 'icon' => 'fa-brands fa-linkedin-in'],
        ['label' => 'YouTube', 'href' => \App\Models\Setting::get('social.youtube'), 'icon' => 'fa-brands fa-youtube'],
        ['label' => 'Messenger', 'href' => $ms, 'icon' => 'fa-brands fa-facebook-messenger'],
        ['label' => 'WhatsApp', 'href' => $whatsappUrl, 'icon' => 'fa-brands fa-whatsapp'],
    ])->filter(fn ($link) => filled($link['href']));

    $craftLinks = collect([
        ['title' => 'Menuiserie bois', 'href' => url('/menuiserie-bois')],
        ['title' => 'Menuiserie aluminium', 'href' => url('/aluminium')],
        ['title' => 'Fabrication métallique', 'href' => url('/fer-metal')],
        ['title' => 'Sur mesure', 'href' => url('/sur-mesure')],
    ]);

    $projectLinks = collect([
        ['title' => 'Agencement immobilier neuf', 'href' => url('/projets/agencement-immobilier-neuf')],
        ['title' => 'Agencement café & restaurant', 'href' => url('/projets/agencement-cafe-restaurant')],
        ['title' => 'Agencement bureau entreprise', 'href' => url('/projets/agencement-bureau-entreprise')],
        ['title' => 'Agencement magasin', 'href' => url('/projets/agencement-magasin')],
        ['title' => 'Aménagement villa & maison', 'href' => url('/projets/amenagement-villa-maison')],
        ['title' => 'Aménagement extérieur', 'href' => url('/projets/amenagement-exterieur')],
    ]);

    $resourceLinks = collect([
        ['title' => 'Réalisations', 'href' => url('/#realisations')],
        ['title' => 'Questions fréquentes', 'href' => url('/#faq')],
        ['title' => 'Espace professionnels', 'href' => url('/partenaires')],
        ['title' => 'Demander un devis', 'href' => url('/devis')],
        ['title' => 'Contact', 'href' => route('contact')],
    ]);
@endphp

<footer class="border-t border-[#2c2620] bg-[#171411] text-white">
    <div class="container mx-auto px-4 py-14 lg:py-16">
        <div class="grid gap-10 lg:grid-cols-[1.35fr_0.8fr_1fr_0.85fr_0.75fr]">
            <div class="max-w-md">
                @if($logoUrl)
                    <img src="{{ $logoUrl }}" alt="{{ $siteName }}" class="h-12 w-auto opacity-95">
                @else
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-lg font-bold text-[#171411]">M</div>
                @endif

                <p class="mt-6 text-base leading-8 text-white/72">
                    Atelier intégré bois, aluminium et métal en Tunisie. Cuisines, dressings, fenêtres, portails, pergolas et agencements sur mesure.
                </p>

                <div class="mt-7 space-y-3 text-sm text-white/70">
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-location-dot mt-1 text-[#d5b170]"></i>
                        <span>{{ $address }} · {{ $serviceArea }}</span>
                    </div>
                    @if($whatsappUrl)
                        <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="flex items-center gap-3 transition hover:text-white">
                            <i class="fa-brands fa-whatsapp text-[#d5b170]"></i>
                            <span>{{ $phoneDisplay }}</span>
                        </a>
                    @endif
                    @if($publicEmail)
                        <a href="mailto:{{ $publicEmail }}" class="flex items-center gap-3 transition hover:text-white">
                            <i class="fa-regular fa-envelope text-[#d5b170]"></i>
                            <span>{{ $publicEmail }}</span>
                        </a>
                    @endif
                </div>

                <div class="mt-7 flex flex-wrap gap-3">
                    @foreach($socialLinks as $socialLink)
                        <a href="{{ $socialLink['href'] }}" target="_blank" rel="noopener" class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-white/12 text-white/70 transition hover:bg-white hover:text-[#171411]" aria-label="{{ $socialLink['label'] }}">
                            <i class="{{ $socialLink['icon'] }}"></i>
                        </a>
                    @endforeach
                </div>
            </div>

            <div>
                <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#d5b170]">Métiers</div>
                <ul class="mt-5 space-y-3.5">
                    @foreach($craftLinks as $link)
                        <li>
                            <a href="{{ $link['href'] }}" class="inline-flex items-center gap-2 text-sm text-white/72 transition hover:text-white">
                                <i class="fa-solid fa-angle-right text-[11px] text-[#8f7351]"></i>
                                {{ $link['title'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#d5b170]">Projets</div>
                <ul class="mt-5 space-y-3.5">
                    @foreach($projectLinks as $link)
                        <li>
                            <a href="{{ $link['href'] }}" class="inline-flex items-center gap-2 text-sm text-white/72 transition hover:text-white">
                                <i class="fa-solid fa-angle-right text-[11px] text-[#8f7351]"></i>
                                {{ $link['title'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#d5b170]">Ressources</div>
                <ul class="mt-5 space-y-3.5">
                    @foreach($resourceLinks as $link)
                        <li>
                            <a href="{{ $link['href'] }}" class="inline-flex items-center gap-2 text-sm text-white/72 transition hover:text-white">
                                <i class="fa-solid fa-angle-right text-[11px] text-[#8f7351]"></i>
                                {{ $link['title'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <div class="text-xs font-bold uppercase tracking-[0.22em] text-[#d5b170]">Mentions</div>
                <ul class="mt-5 space-y-3.5">
                    <li>
                        <a href="{{ route('legal.cgv') }}" class="inline-flex items-center gap-2 text-sm text-white/72 transition hover:text-white">
                            <i class="fa-solid fa-angle-right text-[11px] text-[#8f7351]"></i>
                            CGV
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('legal.confidentialite') }}" class="inline-flex items-center gap-2 text-sm text-white/72 transition hover:text-white">
                            <i class="fa-solid fa-angle-right text-[11px] text-[#8f7351]"></i>
                            Confidentialité
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('legal.livraison') }}" class="inline-flex items-center gap-2 text-sm text-white/72 transition hover:text-white">
                            <i class="fa-solid fa-angle-right text-[11px] text-[#8f7351]"></i>
                            Livraison & retours
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="mt-12 flex flex-col gap-3 border-t border-white/10 pt-6 text-sm text-white/42 md:flex-row md:items-center md:justify-between">
            <p>&copy; {{ date('Y') }} {{ $siteName }} — Atelier d'aménagement intégré en Tunisie. Tous droits réservés.</p>
            <p>Bois · aluminium · métal · sur mesure</p>
        </div>
    </div>
</footer>
