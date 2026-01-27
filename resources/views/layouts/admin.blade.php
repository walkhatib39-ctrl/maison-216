<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin — {{ config('app.name', 'Maison 216') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .admin-gradient {
            background: linear-gradient(135deg, #22201d 0%, #2d2b26 100%);
        }
        .admin-sidebar-active {
            background: linear-gradient(135deg, #b69352, #a87f3d);
            color: white;
        }
        .admin-sidebar-active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 4px;
            height: 100%;
            background: #b69352;
            border-radius: 0 2px 2px 0;
        }
    </style>
</head>
<body class="font-sans antialiased bg-dark-50 text-dark-900">
<div class="min-h-screen flex">
    <!-- Sidebar -->
    <aside class="w-72 admin-gradient shadow-2xl flex flex-col">
        <!-- Logo Section -->
        <div class="p-6 border-b border-white/10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2-2v2m0-4.5V9a2 2 0 012-2h2a2 2 0 012 2v8.5M7 7h4"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-white font-bold text-lg">Admin</h2>
                    <p class="text-white/70 text-sm">{{ \App\Models\Setting::get('site.name', 'Maison 216') }}</p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 p-4 space-y-2">
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}"
               class="relative flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'admin-sidebar-active' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2H3a2 2 0 00-2 2v10z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5h8"/>
                </svg>
                Tableau de bord
            </a>

            <!-- Products Section -->
            <div class="space-y-1">
                <a href="{{ route('admin.products.index') }}"
                   class="relative flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.products.*') && !request()->routeIs('admin.products.import*') ? 'admin-sidebar-active' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    Produits
                    <span class="ml-auto bg-white/20 px-2 py-1 rounded-full text-xs">
                        {{ \App\Models\Product::count() }}
                    </span>
                </a>
                <a href="{{ route('admin.products.import') }}"
                   class="relative flex items-center gap-3 px-4 py-2 ml-6 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.products.import*') ? 'admin-sidebar-active' : 'text-white/70 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                    </svg>
                    Import JSON
                </a>
            </div>

            <!-- Categories -->
            <a href="{{ route('admin.categories.index') }}"
               class="relative flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.categories.*') ? 'admin-sidebar-active' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                </svg>
                Catégories
            </a>

            <!-- Orders -->
            <a href="{{ route('admin.orders.index') }}"
               class="relative flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.orders.*') ? 'admin-sidebar-active' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                Commandes
                @php
                    $pendingOrders = \App\Models\Order::where('status', 'pending')->count();
                @endphp
                @if($pendingOrders > 0)
                    <span class="ml-auto bg-red-500 text-white px-2 py-1 rounded-full text-xs font-bold animate-pulse">
                        {{ $pendingOrders }}
                    </span>
                @endif
            </a>

            <!-- Settings -->
            <a href="{{ route('admin.settings.index') }}"
               class="relative flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.settings.*') ? 'admin-sidebar-active' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Paramètres
            </a>

            <!-- SEO -->
            <a href="{{ route('admin.seo.index') }}"
               class="relative flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.seo.*') ? 'admin-sidebar-active' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                SEO & Analytics
            </a>

            <!-- Quick Links Section -->
            <div class="pt-6">
                <h3 class="text-white/50 text-xs font-semibold uppercase tracking-wider mb-3 px-4">Liens rapides</h3>
                <a href="{{ route('home') }}" target="_blank"
                   class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm font-medium text-white/70 hover:text-white hover:bg-white/5 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    Voir le site
                </a>
            </div>
        </nav>

        <!-- User Section -->
        <div class="p-4 border-t border-white/10">
            <div class="flex items-center gap-3 p-3 bg-white/5 rounded-xl">
                <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-700 rounded-full flex items-center justify-center">
                    <span class="text-white font-semibold text-sm">
                        {{ substr(Auth::user()->name ?? 'A', 0, 2) }}
                    </span>
                </div>
                <div class="flex-1">
                    <p class="text-white font-medium text-sm">{{ Auth::user()->name ?? 'Admin' }}</p>
                    <p class="text-white/60 text-xs">Administrateur</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-white/60 hover:text-red-400 transition-colors duration-200" title="Déconnexion">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-h-screen">
        <!-- Top Bar -->
        <header class="bg-white border-b border-dark-100 px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <!-- Mobile menu button -->
                    <button id="mobile-menu-btn" class="lg:hidden p-2 rounded-lg hover:bg-dark-50 transition-colors duration-200">
                        <svg class="w-6 h-6 text-dark-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                    @isset($header)
                        <div class="flex items-center gap-3">
                            {{ $header }}
                        </div>
                    @else
                        <h1 class="text-2xl font-bold text-dark-900">Administration</h1>
                    @endisset
                </div>

                <div class="flex items-center gap-4">
                    <!-- Notifications -->
                    <div class="relative">
                        <button class="p-2 text-dark-500 hover:text-dark-700 hover:bg-dark-50 rounded-lg transition-colors duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM12 17.586V19a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2h5.586l4.707-4.707A1 1 0 0118 6.586V9"/>
                            </svg>
                        </button>
                        @if($pendingOrders > 0)
                            <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold">
                                {{ $pendingOrders }}
                            </span>
                        @endif
                    </div>

                    <!-- Quick Actions -->
                    <div class="hidden sm:flex items-center gap-2">
                        <a href="{{ route('admin.products.create') }}" 
                           class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Nouveau produit
                        </a>
                    </div>

                    <!-- User Avatar -->
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-primary-500 to-primary-700 rounded-full flex items-center justify-center">
                            <span class="text-white font-semibold text-sm">
                                {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-1 p-6">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>
    </div>
</div>

<!-- Mobile Sidebar Overlay -->
<div id="mobile-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden lg:hidden">
    <aside class="w-72 h-full admin-gradient shadow-2xl flex flex-col">
        <!-- Same sidebar content as desktop -->
        <div class="p-6 border-b border-white/10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2-2v2m0-4.5V9a2 2 0 012-2h2a2 2 0 012 2v8.5M7 7h4"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-white font-bold text-lg">Admin</h2>
                    <p class="text-white/70 text-sm">{{ \App\Models\Setting::get('site.name', 'Maison 216') }}</p>
                </div>
                <button id="close-mobile-menu" class="ml-auto text-white/60 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
        <!-- Same nav content -->
    </aside>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileOverlay = document.getElementById('mobile-overlay');
    const closeMobileMenu = document.getElementById('close-mobile-menu');
    
    if (mobileMenuBtn && mobileOverlay) {
        mobileMenuBtn.addEventListener('click', function() {
            mobileOverlay.classList.remove('hidden');
        });
        
        mobileOverlay.addEventListener('click', function(e) {
            if (e.target === mobileOverlay) {
                mobileOverlay.classList.add('hidden');
            }
        });
        
        if (closeMobileMenu) {
            closeMobileMenu.addEventListener('click', function() {
                mobileOverlay.classList.add('hidden');
            });
        }
    }
});
</script>
</body>
</html>
