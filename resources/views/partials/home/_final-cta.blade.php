{{-- Final Call-to-Action Section --}}
@php
    $wh = \App\Models\Setting::get('contact.whatsapp');
    $ms = \App\Models\Setting::get('contact.messenger');
    $whDigits = $wh ? preg_replace('/\D+/', '', (string)$wh) : null;
@endphp

<section class="py-12 lg:py-20 bg-gradient-to-b from-white to-dark-50/50">
    <div class="container mx-auto px-4">
        <div class="bg-gradient-to-br from-dark-900 via-dark-800 to-primary-900 rounded-3xl p-8 lg:p-12 relative overflow-hidden">
            {{-- Background Pattern --}}
            <div class="absolute inset-0 bg-hero-pattern opacity-10"></div>
            
            {{-- Content --}}
            <div class="relative z-10 max-w-3xl mx-auto text-center text-white">
                {{-- Icon --}}
                <div class="w-20 h-20 bg-gradient-to-br from-primary-500 to-primary-700 rounded-2xl flex items-center justify-center mx-auto mb-8 shadow-xl">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-4">
                    Besoin de conseils ? Contactez-nous !
                </h2>
                <p class="text-lg text-white/80 mb-10 max-w-xl mx-auto">
                    Notre équipe est disponible pour vous aider à choisir les meubles parfaits pour votre intérieur
                </p>
                
                {{-- Contact Buttons --}}
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @if($whDigits)
                        <a href="https://wa.me/{{ $whDigits }}?text={{ rawurlencode('Bonjour, j\'aimerais avoir des conseils pour mon projet d\'aménagement.') }}"
                           target="_blank" rel="noopener"
                           class="group inline-flex items-center justify-center gap-3 bg-green-500 hover:bg-green-600 text-white font-bold px-8 py-4 rounded-xl transition-all duration-300 shadow-xl hover:shadow-2xl">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.886 3.75"/>
                            </svg>
                            Contacter via WhatsApp
                        </a>
                    @endif
                    
                    @if(!empty($ms))
                        <a href="{{ $ms }}" target="_blank" rel="noopener"
                           class="group inline-flex items-center justify-center gap-3 bg-blue-600 hover:bg-blue-700 text-white font-bold px-8 py-4 rounded-xl transition-all duration-300 shadow-xl hover:shadow-2xl">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C5.374 0 0 4.975 0 11.111c0 3.497 1.745 6.616 4.472 8.652V24l4.086-2.242c1.09.301 2.246.464 3.442.464 6.626 0 12-4.974 12-11.111C24 4.975 18.626 0 12 0z"/>
                            </svg>
                            Contacter via Messenger
                        </a>
                    @endif
                    
                    <a href="{{ route('contact') }}" 
                       class="group inline-flex items-center justify-center gap-3 bg-white/10 hover:bg-white/20 text-white font-semibold px-8 py-4 rounded-xl border-2 border-white/30 hover:border-white/50 transition-all duration-300 backdrop-blur-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Formulaire de contact
                    </a>
                </div>
                
                {{-- Contact Info --}}
                <div class="mt-10 pt-8 border-t border-white/10 flex flex-wrap items-center justify-center gap-6 text-sm text-white/60">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Réponse rapide garantie
                    </span>
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        Devis gratuit
                    </span>
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8"/>
                        </svg>
                        Livraison Tunisie entière
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>
