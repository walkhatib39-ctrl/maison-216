{{-- Storefront layout for Maison 216 --}}
<!DOCTYPE html>
<html lang="fr" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        $siteName = \App\Models\Setting::get('site.name', config('app.name'));
        $currentPath = trim(request()->path(), '/');
        $seoPage = null;

        try {
            if ($currentPath !== '' && \Illuminate\Support\Facades\Schema::hasTable('site_pages')) {
                $seoPage = \App\Models\SitePage::query()
                    ->where('path', $currentPath)
                    ->where('is_obsolete', false)
                    ->first();
            }
        } catch (\Throwable $e) {
            $seoPage = null;
        }

        $resolvedTitle = $seoPage?->meta_title ?: ($title ?? null);
        $resolvedMetaDescription = $seoPage?->meta_description
            ?: ($metaDescription ?? 'Atelier Maison216 en Tunisie : menuiserie bois, aluminium, fabrication metallique et amenagement sur mesure. Devis gratuit, pose et SAV inclus.');
        $resolvedOgImage = $seoPage?->og_image
            ?: ($ogImage ?? \App\Models\Setting::get('seo.og_image') ?? \App\Models\Setting::get('ui.logo'));
        $resolvedRobots = $seoPage && !$seoPage->is_indexable ? 'noindex,nofollow' : ($robots ?? null);
    @endphp
    
    {{-- SEO Optimized Title --}}
    <title>{{ $resolvedTitle ? $resolvedTitle . ' | ' . $siteName : $siteName }}</title>
    
    {{-- Meta Description --}}
    <meta name="description" content="{{ $resolvedMetaDescription }}">
    
    {{-- SEO Keywords --}}
    <meta name="keywords" content="menuiserie bois tunisie, menuiserie aluminium tunisie, fabrication metallique tunisie, cuisine sur mesure tunisie, dressing sur mesure tunisie, portail fer forge tunisie">
    
    {{-- Canonical URL --}}
    <link rel="canonical" href="{{ $canonical ?? url()->current() }}">
    
    {{-- Open Graph Tags --}}
    <meta property="og:title" content="{{ $ogTitle ?? ($resolvedTitle ?? $siteName) }}">
    <meta property="og:description" content="{{ $ogDescription ?? $resolvedMetaDescription }}">
    <meta property="og:type" content="{{ $ogType ?? 'website' }}">
    <meta property="og:url" content="{{ $ogUrl ?? url()->current() }}">
    <meta property="og:image" content="{{ $resolvedOgImage }}">
    <meta property="og:locale" content="fr_TN">
    <meta property="og:site_name" content="{{ $siteName }}">
    
    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    @if(\App\Models\Setting::get('seo.twitter_site'))
        <meta name="twitter:site" content="{{ \App\Models\Setting::get('seo.twitter_site') }}">
    @endif
    @if(\App\Models\Setting::get('seo.twitter_creator'))
        <meta name="twitter:creator" content="{{ \App\Models\Setting::get('seo.twitter_creator') }}">
    @endif
    
    {{-- Robots --}}
    @if($resolvedRobots)
        <meta name="robots" content="{{ $resolvedRobots }}">
    @endif
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Sora:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" referrerpolicy="no-referrer">
    
    {{-- Favicon --}}
    @php $favicon = \App\Models\Setting::get('ui.favicon'); @endphp
    @if($favicon)
        <link rel="icon" type="image/x-icon" href="{{ $favicon }}">
    @endif
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Manrope', 'Figtree', sans-serif; background: #f7f3eb; }
        .font-display,
        .font-editorial { font-family: 'Sora', 'Manrope', sans-serif; }
        .bg-hero-pattern { background-image: radial-gradient(circle at 1px 1px, rgba(184, 138, 59, 0.12) 1px, transparent 0); background-size: 20px 20px; }
        ::selection { background: rgba(184, 138, 59, 0.2); color: #171411; }

        html { scroll-behavior: smooth; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }

        .parallax-bg {
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .line-clamp-1 { display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
    </style>
    @stack('head')
</head>
<body class="min-h-screen flex flex-col bg-[#f7f3eb] text-dark-900 antialiased">

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

    <main class="flex-1 bg-[#f7f3eb]">
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('layouts.partials._footer')

</body>
</html>
