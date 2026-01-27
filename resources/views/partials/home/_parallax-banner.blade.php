{{-- Parallax Promotional Banner --}}
@php
    $wh = \App\Models\Setting::get('contact.whatsapp');
    $whDigits = $wh ? preg_replace('/\D+/', '', (string)$wh) : null;
@endphp

<section class="relative py-20 lg:py-32 overflow-hidden">
    {{-- Parallax Background --}}
    <div class="absolute inset-0 parallax-bg" 
         style="background-image: url('https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?q=80&w=1920&auto=format&fit=crop');">
    </div>
    
    {{-- Dark Overlay --}}
    <div class="absolute inset-0 bg-gradient-to-r from-dark-900/90 via-dark-900/70 to-dark-900/90"></div>
    
    {{-- Pattern Overlay --}}
    <div class="absolute inset-0 bg-hero-pattern opacity-20"></div>
    
    {{-- Content --}}
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-3xl mx-auto text-center text-white">
            {{-- Badge --}}
            <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm text-white px-5 py-2.5 rounded-full text-sm font-medium mb-6 border border-white/20">
                <svg class="w-5 h-5 text-primary-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                    <path d="M3 4h1l.77 2.21.32.9H16l-1.5 6H5.05L3.73 8H2V6h3.33l.77 2.21"/>
                </svg>
                <span>Livraison partout en Tunisie</span>
            </div>
            
            {{-- Main Text --}}
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold mb-6 leading-tight">
                Transformez votre intérieur en 
                <span class="bg-gradient-to-r from-primary-400 to-primary-600 bg-clip-text text-transparent">espace de rêve</span>
            </h2>
            
            <p class="text-lg lg:text-xl text-white/80 mb-10 leading-relaxed max-w-2xl mx-auto">
                Plus de 500 meubles de qualité premium à des prix accessibles. 
                Livraison rapide 3-7 jours et paiement à la livraison.
            </p>
            
            {{-- Stats --}}
            <div class="grid grid-cols-3 gap-6 mb-10 max-w-lg mx-auto">
                <div class="text-center">
                    <div class="text-3xl lg:text-4xl font-bold text-primary-400 mb-1">500+</div>
                    <div class="text-sm text-white/60">Produits</div>
                </div>
                <div class="text-center border-x border-white/20">
                    <div class="text-3xl lg:text-4xl font-bold text-primary-400 mb-1">24</div>
                    <div class="text-sm text-white/60">Gouvernorats</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl lg:text-4xl font-bold text-primary-400 mb-1">3-7j</div>
                    <div class="text-sm text-white/60">Livraison</div>
                </div>
            </div>
            
            {{-- CTA Buttons --}}
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @if($whDigits)
                    <a href="https://wa.me/{{ $whDigits }}?text={{ rawurlencode('Bonjour, je souhaite avoir des informations sur vos meubles.') }}"
                       target="_blank" rel="noopener"
                       class="group inline-flex items-center justify-center gap-3 bg-primary-600 hover:bg-primary-700 text-white font-bold px-8 py-4 rounded-xl transition-all duration-300 shadow-xl hover:shadow-2xl">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.886 3.75"/>
                        </svg>
                        Demander un devis gratuit
                    </a>
                @endif
                
                <a href="{{ route('search') }}" 
                   class="group inline-flex items-center justify-center gap-3 bg-white/10 hover:bg-white/20 text-white font-semibold px-8 py-4 rounded-xl border-2 border-white/30 hover:border-white/50 transition-all duration-300 backdrop-blur-sm">
                    <span>Parcourir le catalogue</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5-5 5M6 12h12"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>
