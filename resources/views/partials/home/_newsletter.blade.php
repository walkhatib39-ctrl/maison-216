{{-- Newsletter Subscription Section --}}
<section class="py-12 lg:py-16 bg-gradient-to-r from-primary-600 to-primary-800 relative overflow-hidden">
    {{-- Background Pattern --}}
    <div class="absolute inset-0 bg-hero-pattern opacity-10"></div>
    
    {{-- Decorative Elements --}}
    <div class="absolute top-0 left-0 w-64 h-64 bg-white/5 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-white/5 rounded-full translate-x-1/3 translate-y-1/3"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-3xl mx-auto text-center">
            {{-- Icon --}}
            <div class="w-16 h-16 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center mx-auto mb-6">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            
            {{-- Content --}}
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-4">
                Restez informé des nouveautés
            </h2>
            <p class="text-lg text-white/80 mb-8 max-w-xl mx-auto">
                Inscrivez-vous pour recevoir nos offres exclusives et être les premiers informés des nouvelles collections
            </p>
            
            {{-- Form --}}
            <form class="flex flex-col sm:flex-row gap-3 max-w-lg mx-auto" onsubmit="return false;">
                <input type="email" 
                       placeholder="Votre adresse email"
                       class="flex-1 px-5 py-4 rounded-xl bg-white/10 backdrop-blur-sm border-2 border-white/20 text-white placeholder-white/60 focus:border-white focus:ring-0 transition-colors">
                <button type="submit" 
                        class="px-8 py-4 bg-white text-primary-700 font-bold rounded-xl hover:bg-primary-50 transition-colors duration-200 shadow-lg hover:shadow-xl whitespace-nowrap">
                    S'inscrire
                </button>
            </form>
            
            {{-- Privacy Note --}}
            <p class="text-sm text-white/60 mt-4">
                En vous inscrivant, vous acceptez de recevoir nos emails. Désabonnement possible à tout moment.
            </p>
        </div>
    </div>
</section>
