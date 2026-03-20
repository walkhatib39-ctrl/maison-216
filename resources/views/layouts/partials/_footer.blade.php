{{-- Premium Footer Component --}}
@php
    $catalog = app(\App\Support\StorefrontCatalog::class);
    $wa = \App\Models\Setting::get('contact.whatsapp');
    $ms = \App\Models\Setting::get('contact.messenger');
    $logo = \App\Models\Setting::get('ui.logo');
    $siteName = \App\Models\Setting::get('site.name', 'Maison 216');
    $tagline = \App\Models\Setting::get('site.tagline', 'Meubles & Décoration en Tunisie');
    
    $footerCategories = $catalog->footerCategories(6);
@endphp

<footer class="bg-dark-900 text-white mt-0 relative overflow-hidden">
    {{-- Top Wave --}}
    <div class="absolute top-0 left-0 right-0 transform -translate-y-full">
        <svg viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto">
            <path d="M0 60L60 55C120 50 240 40 360 35C480 30 600 30 720 32.5C840 35 960 40 1080 42.5C1200 45 1320 45 1380 45L1440 45V60H0V60Z" fill="#22201d"/>
        </svg>
    </div>
    
    <div class="container mx-auto px-4 py-16 lg:py-20 relative z-10">
        {{-- Main Footer Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12 lg:gap-8">
            
            {{-- Brand Section --}}
            <div class="lg:col-span-4">
                <div class="flex items-center gap-3 mb-6">
                    @if($logo)
                        <img src="{{ $logo }}" alt="{{ $siteName }}" class="h-12 w-auto">
                    @else
                        <div class="h-12 w-12 bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl flex items-center justify-center font-bold text-white text-lg shadow-lg">
                            M
                        </div>
                    @endif
                    <div>
                        <div class="text-xl font-bold text-white">{{ $siteName }}</div>
                        <div class="text-sm text-dark-200">{{ $tagline }}</div>
                    </div>
                </div>
                
                <p class="text-dark-200 leading-relaxed mb-6 max-w-sm">
                    Votre destination pour des meubles de qualité en Tunisie. Design moderne, prix compétitifs, et livraison rapide partout dans le pays.
                </p>
                
                {{-- Social Links --}}
                <div class="flex items-center gap-3">
                    @if(!empty($wa))
                        <a href="https://wa.me/{{ preg_replace('/\D+/', '', (string)$wa) }}" 
                           target="_blank" rel="noopener"
                           class="w-11 h-11 bg-dark-800 hover:bg-green-600 rounded-xl flex items-center justify-center transition-all duration-300 group">
                            <svg class="w-5 h-5 text-dark-200 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.886 3.75"/>
                            </svg>
                        </a>
                    @endif
                    @if(!empty($ms))
                        <a href="{{ $ms }}" target="_blank" rel="noopener"
                           class="w-11 h-11 bg-dark-800 hover:bg-blue-600 rounded-xl flex items-center justify-center transition-all duration-300 group">
                            <svg class="w-5 h-5 text-dark-200 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C5.374 0 0 4.975 0 11.111c0 3.497 1.745 6.616 4.472 8.652V24l4.086-2.242c1.09.301 2.246.464 3.442.464 6.626 0 12-4.974 12-11.111C24 4.975 18.626 0 12 0z"/>
                            </svg>
                        </a>
                    @endif
                    <a href="https://www.facebook.com/" target="_blank" rel="noopener"
                       class="w-11 h-11 bg-dark-800 hover:bg-blue-700 rounded-xl flex items-center justify-center transition-all duration-300 group">
                        <svg class="w-5 h-5 text-dark-200 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    <a href="https://www.instagram.com/" target="_blank" rel="noopener"
                       class="w-11 h-11 bg-dark-800 hover:bg-gradient-to-br hover:from-purple-600 hover:to-pink-500 rounded-xl flex items-center justify-center transition-all duration-300 group">
                        <svg class="w-5 h-5 text-dark-200 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Univers --}}
            <div class="lg:col-span-2">
                <h3 class="text-lg font-bold mb-6 text-primary-400">Univers</h3>
                <ul class="space-y-3">
                    @foreach($footerCategories as $cat)
                        <li>
                            <a class="text-dark-200 hover:text-white transition-colors duration-200 flex items-center gap-2 group" 
                               href="{{ $cat['href'] }}">
                                <span class="w-1.5 h-1.5 bg-primary-500 rounded-full group-hover:scale-125 transition-transform"></span>
                                {{ $cat['name'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Navigation --}}
            <div class="lg:col-span-2">
                <h3 class="text-lg font-bold mb-6 text-primary-400">Navigation</h3>
                <ul class="space-y-3">
                    <li>
                        <a class="text-dark-200 hover:text-white transition-colors duration-200 flex items-center gap-2 group" href="{{ route('home') }}">
                            <span class="w-1.5 h-1.5 bg-primary-500 rounded-full group-hover:scale-125 transition-transform"></span>
                            Accueil
                        </a>
                    </li>
                    <li>
                        <a class="text-dark-200 hover:text-white transition-colors duration-200 flex items-center gap-2 group" href="{{ url('/#univers') }}">
                            <span class="w-1.5 h-1.5 bg-primary-500 rounded-full group-hover:scale-125 transition-transform"></span>
                            Découvrir les univers
                        </a>
                    </li>
                    <li>
                        <a class="text-dark-200 hover:text-white transition-colors duration-200 flex items-center gap-2 group" href="{{ url('/#composer') }}">
                            <span class="w-1.5 h-1.5 bg-primary-500 rounded-full group-hover:scale-125 transition-transform"></span>
                            Composer une pièce
                        </a>
                    </li>
                    <li>
                        <a class="text-dark-200 hover:text-white transition-colors duration-200 flex items-center gap-2 group" href="{{ url('/#sur-mesure') }}">
                            <span class="w-1.5 h-1.5 bg-primary-500 rounded-full group-hover:scale-125 transition-transform"></span>
                            Projet sur mesure
                        </a>
                    </li>
                    <li>
                        <a class="text-dark-200 hover:text-white transition-colors duration-200 flex items-center gap-2 group" href="{{ route('contact') }}">
                            <span class="w-1.5 h-1.5 bg-primary-500 rounded-full group-hover:scale-125 transition-transform"></span>
                            Contact
                        </a>
                    </li>
                    <li>
                        <a class="text-dark-200 hover:text-white transition-colors duration-200 flex items-center gap-2 group" href="{{ route('legal.cgv') }}">
                            <span class="w-1.5 h-1.5 bg-primary-500 rounded-full group-hover:scale-125 transition-transform"></span>
                            Conditions Générales
                        </a>
                    </li>
                    <li>
                        <a class="text-dark-200 hover:text-white transition-colors duration-200 flex items-center gap-2 group" href="{{ route('legal.confidentialite') }}">
                            <span class="w-1.5 h-1.5 bg-primary-500 rounded-full group-hover:scale-125 transition-transform"></span>
                            Confidentialité
                        </a>
                    </li>
                    <li>
                        <a class="text-dark-200 hover:text-white transition-colors duration-200 flex items-center gap-2 group" href="{{ route('legal.livraison') }}">
                            <span class="w-1.5 h-1.5 bg-primary-500 rounded-full group-hover:scale-125 transition-transform"></span>
                            Livraison & Retours
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Contact & Payment Info --}}
            <div class="lg:col-span-4">
                <h3 class="text-lg font-bold mb-6 text-primary-400">Nous Contacter</h3>
                
                <div class="space-y-4 mb-6">
                    @if(!empty($wa))
                        <a href="https://wa.me/{{ preg_replace('/\D+/', '', (string)$wa) }}" 
                           target="_blank" rel="noopener"
                           class="flex items-center gap-3 text-dark-200 hover:text-white transition-colors group">
                            <div class="w-10 h-10 bg-dark-800 group-hover:bg-green-600 rounded-lg flex items-center justify-center transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.886 3.75"/>
                                </svg>
                            </div>
                            <span>{{ $wa }}</span>
                        </a>
                    @endif
                </div>

                {{-- Trust Badges --}}
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-dark-800/50 backdrop-blur rounded-xl p-4 text-center">
                        <svg class="w-8 h-8 mx-auto mb-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-xs text-dark-200 block">Qualité Garantie</span>
                    </div>
                    <div class="bg-dark-800/50 backdrop-blur rounded-xl p-4 text-center">
                        <svg class="w-8 h-8 mx-auto mb-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        <span class="text-xs text-dark-200 block">Paiement à la Livraison</span>
                    </div>
                    <div class="bg-dark-800/50 backdrop-blur rounded-xl p-4 text-center">
                        <svg class="w-8 h-8 mx-auto mb-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                        </svg>
                        <span class="text-xs text-dark-200 block">Livraison Tunisie</span>
                    </div>
                    <div class="bg-dark-800/50 backdrop-blur rounded-xl p-4 text-center">
                        <svg class="w-8 h-8 mx-auto mb-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span class="text-xs text-dark-200 block">Support 7j/7</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom Footer --}}
        <div class="border-t border-dark-800 mt-12 pt-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-dark-300 text-sm text-center md:text-left">
                    © {{ date('Y') }} {{ $siteName }}. Tous droits réservés. 
                    <span class="hidden sm:inline">| Meubles de qualité en Tunisie</span>
                </p>
                
                <div class="flex items-center gap-6 text-sm text-dark-300">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                        </svg>
                        Paiement sécurisé
                    </span>
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                            <path d="M3 4h1l.77 2.21.32.9H16l-1.5 6H5.05L3.73 8H2V6h3.33l.77 2.21"/>
                        </svg>
                        Livraison rapide
                    </span>
                </div>
            </div>
        </div>
    </div>
</footer>
