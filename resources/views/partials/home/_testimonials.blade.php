{{-- Customer Testimonials Section --}}
<section class="py-12 lg:py-20 bg-white">
    <div class="container mx-auto px-4">
        {{-- Section Header --}}
        <div class="text-center mb-10 lg:mb-12">
            <span class="inline-block bg-amber-100 text-amber-700 text-sm font-semibold px-4 py-1.5 rounded-full mb-4">
                ⭐ Témoignages
            </span>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-dark-900 mb-3">
                Ce que disent nos <span class="text-primary-600">clients</span>
            </h2>
            <p class="text-base lg:text-lg text-dark-600 max-w-2xl mx-auto">
                La satisfaction de nos clients est notre meilleure publicité
            </p>
        </div>
        
        {{-- Testimonials Grid --}}
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            {{-- Testimonial 1 --}}
            <div class="bg-gradient-to-br from-dark-50 to-white rounded-2xl p-6 lg:p-8 shadow-lg border border-dark-100 relative">
                {{-- Quote Icon --}}
                <div class="absolute -top-4 left-6 w-10 h-10 bg-primary-600 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                    </svg>
                </div>
                
                {{-- Rating --}}
                <div class="flex items-center gap-1 mb-4 mt-2">
                    @for($i = 0; $i < 5; $i++)
                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @endfor
                </div>
                
                {{-- Testimonial Text --}}
                <p class="text-dark-700 mb-6 leading-relaxed">
                    "Excellent service ! J'ai commandé un canapé et une table basse. La qualité est au rendez-vous et la livraison a été rapide. Je recommande vivement Maison 216."
                </p>
                
                {{-- Customer Info --}}
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary-400 to-primary-600 rounded-full flex items-center justify-center text-white font-bold">
                        SK
                    </div>
                    <div>
                        <div class="font-semibold text-dark-900">Sami K.</div>
                        <div class="text-sm text-dark-500">Tunis • Client vérifié</div>
                    </div>
                </div>
            </div>
            
            {{-- Testimonial 2 --}}
            <div class="bg-gradient-to-br from-dark-50 to-white rounded-2xl p-6 lg:p-8 shadow-lg border border-dark-100 relative">
                <div class="absolute -top-4 left-6 w-10 h-10 bg-primary-600 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                    </svg>
                </div>
                
                <div class="flex items-center gap-1 mb-4 mt-2">
                    @for($i = 0; $i < 5; $i++)
                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @endfor
                </div>
                
                <p class="text-dark-700 mb-6 leading-relaxed">
                    "Ma chambre à coucher est transformée ! Le lit et l'armoire sont magnifiques. Le paiement à la livraison m'a vraiment rassurée. Merci beaucoup !"
                </p>
                
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold">
                        FB
                    </div>
                    <div>
                        <div class="font-semibold text-dark-900">Fatma B.</div>
                        <div class="text-sm text-dark-500">Sousse • Cliente vérifiée</div>
                    </div>
                </div>
            </div>
            
            {{-- Testimonial 3 --}}
            <div class="bg-gradient-to-br from-dark-50 to-white rounded-2xl p-6 lg:p-8 shadow-lg border border-dark-100 relative md:col-span-2 lg:col-span-1">
                <div class="absolute -top-4 left-6 w-10 h-10 bg-primary-600 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                    </svg>
                </div>
                
                <div class="flex items-center gap-1 mb-4 mt-2">
                    @for($i = 0; $i < 5; $i++)
                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    @endfor
                </div>
                
                <p class="text-dark-700 mb-6 leading-relaxed">
                    "Rapport qualité-prix imbattable ! J'ai meublé tout mon salon pour un budget raisonnable. L'équipe est très réactive sur WhatsApp. Je reviendrai sûrement !"
                </p>
                
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-full flex items-center justify-center text-white font-bold">
                        AM
                    </div>
                    <div>
                        <div class="font-semibold text-dark-900">Ahmed M.</div>
                        <div class="text-sm text-dark-500">Sfax • Client vérifié</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
