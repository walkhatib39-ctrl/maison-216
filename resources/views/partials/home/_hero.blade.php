{{-- Static Hero Section --}}
<section class="relative h-[600px] lg:h-[700px] flex items-center justify-center overflow-hidden bg-dark-900 text-white">
    
    {{-- Background Image --}}
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?q=80&w=2000&auto=format&fit=crop" 
             alt="Mobilier de luxe Maison 216" 
             class="w-full h-full object-cover opacity-90">
        
        {{-- Premium Gradient Overlay --}}
        <div class="absolute inset-0 bg-gradient-to-t from-dark-900 via-dark-900/50 to-dark-900/30"></div>
        <div class="absolute inset-0 bg-black/20 backdrop-blur-[1px]"></div>
    </div>

    {{-- Content --}}
    <div class="container mx-auto px-4 relative z-10 text-center">
        
        {{-- Badge --}}
        <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md border border-white/20 px-5 py-2 rounded-full text-sm font-medium text-white mb-8 animate-fade-in-up">
            <span class="w-2 h-2 rounded-full bg-primary-500"></span>
            <span>Nouvelle Collection 2025</span>
        </div>

        {{-- Main Title --}}
        <h1 class="text-4xl sm:text-5xl lg:text-7xl font-serif font-bold mb-6 leading-tight tracking-tight animate-fade-in-up delay-100">
            Mobilier & Décoration <br/>
            <span class="bg-gradient-to-r from-primary-200 via-primary-400 to-primary-200 bg-clip-text text-transparent bg-300% animate-gradient">
                d'Excellence
            </span>
        </h1>

        {{-- Subtitle --}}
        <p class="text-lg sm:text-xl text-gray-200 mb-10 max-w-2xl mx-auto leading-relaxed animate-fade-in-up delay-200">
            Créez l'intérieur de vos rêves avec nos pièces uniques, alliant design contemporain et confort absolu.
        </p>

        {{-- CTA Buttons --}}
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 animate-fade-in-up delay-300">
            @if(isset($categories) && $categories->isNotEmpty())
                <a href="{{ route('category.show', $categories->first()->slug) }}" 
                   class="group min-w-[200px] bg-primary-600 hover:bg-primary-700 text-white px-8 py-4 rounded-full font-semibold transition-all duration-300 shadow-lg hover:shadow-primary-600/30 flex items-center justify-center gap-2">
                    <span>Voir la collection</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            @endif
            
            <a href="#nouveautes" 
               class="group min-w-[200px] bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/30 text-white px-8 py-4 rounded-full font-semibold transition-all duration-300 hover:border-white/50 flex items-center justify-center gap-2">
                <span>Nos nouveautés</span>
            </a>
        </div>

    </div>

    {{-- Bottom Fade --}}
    <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-gray-50 to-transparent z-10"></div>

</section>
