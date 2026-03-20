{{-- Storefront layout for Maison 216 - Premium Design --}}
<!DOCTYPE html>
<html lang="fr" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    {{-- SEO Optimized Title --}}
    <title>@isset($title){{ $title }} | @endisset{{ \App\Models\Setting::get('site.name', config('app.name')) }} | Meuble Tunisie</title>
    
    {{-- Meta Description --}}
    <meta name="description" content="@isset($metaDescription){{ $metaDescription }}@else Vente de meubles en Tunisie. Découvrez notre collection de canapés, lits, tables et décoration. Livraison partout en Tunisie, paiement à la livraison. {{ \App\Models\Setting::get('site.tagline', 'Meubles & Décoration en Tunisie') }}@endisset">
    
    {{-- SEO Keywords --}}
    <meta name="keywords" content="meuble tunisie, vente meuble, vente meuble en ligne, meubles tunisie, canapé tunisie, lit tunisie, table tunisie, décoration tunisie, mobilier tunisie, achat meuble tunisie">
    
    {{-- Canonical URL --}}
    <link rel="canonical" href="{{ $canonical ?? url()->current() }}">
    
    {{-- Open Graph Tags --}}
    <meta property="og:title" content="{{ $ogTitle ?? ($title ?? \App\Models\Setting::get('site.name', config('app.name'))) }} | Meuble Tunisie">
    <meta property="og:description" content="{{ $ogDescription ?? ($metaDescription ?? 'Vente de meubles en Tunisie. Livraison partout en Tunisie, paiement à la livraison.') }}">
    <meta property="og:type" content="{{ $ogType ?? 'website' }}">
    <meta property="og:url" content="{{ $ogUrl ?? url()->current() }}">
    <meta property="og:image" content="{{ $ogImage ?? \App\Models\Setting::get('seo.og_image') ?? \App\Models\Setting::get('ui.logo') }}">
    <meta property="og:locale" content="fr_TN">
    <meta property="og:site_name" content="{{ \App\Models\Setting::get('site.name', 'Maison 216') }}">
    
    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    @if(\App\Models\Setting::get('seo.twitter_site'))
        <meta name="twitter:site" content="{{ \App\Models\Setting::get('seo.twitter_site') }}">
    @endif
    @if(\App\Models\Setting::get('seo.twitter_creator'))
        <meta name="twitter:creator" content="{{ \App\Models\Setting::get('seo.twitter_creator') }}">
    @endif
    
    {{-- Robots --}}
    @isset($robots)
        <meta name="robots" content="{{ $robots }}">
    @endisset
    
    {{-- Preconnect for performance --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;9..144,700;9..144,800&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    {{-- Favicon --}}
    @php $favicon = \App\Models\Setting::get('ui.favicon'); @endphp
    @if($favicon)
        <link rel="icon" type="image/x-icon" href="{{ $favicon }}">
    @endif
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Manrope', 'Inter', 'Figtree', sans-serif; }
        .font-editorial { font-family: 'Fraunces', Georgia, serif; }
        .bg-hero-pattern { background-image: radial-gradient(circle at 1px 1px, rgba(182, 147, 82, 0.15) 1px, transparent 0); background-size: 20px 20px; }
        
        /* Smooth scrolling for anchor links */
        html { scroll-behavior: smooth; }
        
        /* Hide scrollbar for carousel containers */
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        
        /* Parallax effect */
        .parallax-bg {
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        
        /* Glassmorphism utility */
        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        
        /* Line clamp utilities */
        .line-clamp-1 { display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
    </style>
    @stack('head')
</head>
<body class="min-h-screen flex flex-col text-dark-900 antialiased bg-white">

    {{-- Header with Mega-Menu Navigation --}}
    @include('layouts.partials._header')

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="container mx-auto px-4 pt-6">
            <div class="rounded-xl bg-emerald-50 border-2 border-emerald-200 text-emerald-800 px-6 py-4 flex items-center gap-3 animate-slide-up">
                <svg class="w-6 h-6 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif
    @if($errors->any())
        <div class="container mx-auto px-4 pt-6">
            <div class="rounded-xl bg-red-50 border-2 border-red-200 text-red-800 px-6 py-4 animate-slide-up">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-red-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <ul class="list-disc list-inside space-y-1 font-medium">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    {{-- Main Content --}}
    <main class="flex-1 bg-white">
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('layouts.partials._footer')

</body>
</html>
