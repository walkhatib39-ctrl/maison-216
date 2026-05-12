<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin — {{ \App\Models\Setting::get('site.name', 'Maison216') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f7f4ee] font-sans text-[#171411] antialiased">
@php
    $mainNav = [
        [
            'label' => 'Tableau de bord',
            'route' => 'admin.dashboard',
            'active' => 'admin.dashboard',
            'icon' => 'dashboard',
        ],
        [
            'label' => 'Pages & SEO',
            'route' => 'admin.site-pages.index',
            'active' => 'admin.site-pages.*',
            'icon' => 'pages',
        ],
        [
            'label' => 'Parametres site',
            'route' => 'admin.settings.index',
            'active' => 'admin.settings.*',
            'icon' => 'settings',
        ],
        [
            'label' => 'SEO & outils',
            'route' => 'admin.seo.index',
            'active' => 'admin.seo.*',
            'icon' => 'search',
        ],
    ];

    $archiveNav = [
        ['label' => 'Produits', 'route' => 'admin.products.index', 'active' => 'admin.products.*'],
        ['label' => 'Commandes', 'route' => 'admin.orders.index', 'active' => 'admin.orders.*'],
        ['label' => 'Categories', 'route' => 'admin.categories.index', 'active' => 'admin.categories.*'],
        ['label' => 'Univers', 'route' => 'admin.rooms.index', 'active' => 'admin.rooms.*'],
        ['label' => 'Types', 'route' => 'admin.product-types.index', 'active' => 'admin.product-types.*'],
        ['label' => 'Collections', 'route' => 'admin.collections.index', 'active' => 'admin.collections.*'],
    ];

    $icon = function (string $name): string {
        return match ($name) {
            'dashboard' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 13h6V4H4v9Zm10 7h6V4h-6v16ZM4 20h6v-3H4v3Z"/>',
            'pages' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 3h7l5 5v13H7V3Zm7 0v5h5M10 13h6M10 17h6M10 9h2"/>',
            'settings' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.5 6.5 12 3l1.5 3.5 3.7-1.1-.8 3.8 3.2 2.1-3.2 2.1.8 3.8-3.7-1.1L12 20l-1.5-3.5-3.7 1.1.8-3.8-3.2-2.1 3.2-2.1-.8-3.8 3.7 1.1ZM12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6Z"/>',
            'search' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-5.2-5.2M10.8 18a7.2 7.2 0 1 1 0-14.4 7.2 7.2 0 0 1 0 14.4Z"/>',
            default => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14"/>',
        };
    };
@endphp

<div class="min-h-screen lg:flex">
    <aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-40 hidden w-72 border-r border-[#e6dac8] bg-[#171411] text-white lg:flex lg:flex-col">
        <div class="border-b border-white/10 p-6">
            <div class="text-xs font-bold uppercase tracking-[0.24em] text-[#d5b170]">Maison216</div>
            <div class="mt-2 text-xl font-extrabold">Cockpit admin</div>
        </div>

        <nav class="flex-1 overflow-y-auto p-4">
            <div class="space-y-1">
                @foreach($mainNav as $item)
                    <a href="{{ route($item['route']) }}"
                       class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-bold transition {{ request()->routeIs($item['active']) ? 'bg-[#d5b170] text-[#171411]' : 'text-white/78 hover:bg-white/8 hover:text-white' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $icon($item['icon']) !!}</svg>
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </div>

            <div class="mt-8">
                <div class="px-4 text-xs font-bold uppercase tracking-[0.18em] text-white/40">A venir</div>
                <div class="mt-2 space-y-1">
                    <div class="rounded-xl px-4 py-3 text-sm font-bold text-white/40">Realisations</div>
                    <div class="rounded-xl px-4 py-3 text-sm font-bold text-white/40">Demandes</div>
                </div>
            </div>

            <details class="mt-8 rounded-2xl border border-white/10 bg-white/5 p-2">
                <summary class="cursor-pointer select-none px-3 py-2 text-xs font-bold uppercase tracking-[0.16em] text-white/50">
                    Archive e-commerce
                </summary>
                <div class="mt-2 space-y-1">
                    @foreach($archiveNav as $item)
                        <a href="{{ route($item['route']) }}"
                           class="block rounded-xl px-3 py-2 text-sm font-semibold transition {{ request()->routeIs($item['active']) ? 'bg-white/12 text-white' : 'text-white/60 hover:bg-white/8 hover:text-white' }}">
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </div>
            </details>
        </nav>

        <div class="border-t border-white/10 p-4">
            <div class="mb-3 rounded-2xl bg-white/5 p-3">
                <div class="text-sm font-bold">{{ Auth::user()->name ?? 'Admin' }}</div>
                <div class="text-xs text-white/50">Administrateur</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full rounded-xl border border-white/10 px-4 py-2.5 text-sm font-bold text-white/75 transition hover:bg-white/8 hover:text-white">
                    Deconnexion
                </button>
            </form>
        </div>
    </aside>

    <div id="mobile-sidebar" class="fixed inset-0 z-50 hidden bg-black/45 lg:hidden">
        <div class="h-full w-72 bg-[#171411] p-4 text-white">
            <div class="mb-5 flex items-center justify-between">
                <div>
                    <div class="text-xs font-bold uppercase tracking-[0.24em] text-[#d5b170]">Maison216</div>
                    <div class="mt-1 text-lg font-extrabold">Cockpit admin</div>
                </div>
                <button type="button" data-close-sidebar class="rounded-xl border border-white/10 px-3 py-2 text-sm font-bold">Fermer</button>
            </div>
            <nav class="space-y-1">
                @foreach($mainNav as $item)
                    <a href="{{ route($item['route']) }}" class="block rounded-xl px-4 py-3 text-sm font-bold {{ request()->routeIs($item['active']) ? 'bg-[#d5b170] text-[#171411]' : 'text-white/78' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>
        </div>
    </div>

    <div class="min-h-screen flex-1 lg:pl-72">
        <header class="sticky top-0 z-30 border-b border-[#e6dac8] bg-[#fbf7f0]/95 px-4 py-4 backdrop-blur lg:px-8">
            <div class="flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <button type="button" data-open-sidebar class="rounded-xl border border-[#d8c7af] bg-white px-3 py-2 text-sm font-bold text-[#171411] lg:hidden">
                        Menu
                    </button>
                    @isset($header)
                        {{ $header }}
                    @else
                        <div>
                            <div class="text-lg font-extrabold text-[#171411]">Administration</div>
                            <div class="text-xs font-semibold text-[#6a5a4c]">Maison216</div>
                        </div>
                    @endisset
                </div>
                <a href="{{ route('home') }}" target="_blank" class="hidden rounded-xl border border-[#d8c7af] bg-white px-4 py-2.5 text-sm font-bold text-[#171411] transition hover:bg-[#f7f4ee] sm:inline-flex">
                    Voir le site
                </a>
            </div>
        </header>

        <main class="px-4 py-6 lg:px-8">
            <div class="mx-auto max-w-7xl">
                @yield('content')
            </div>
        </main>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const panel = document.getElementById('mobile-sidebar');
    document.querySelectorAll('[data-open-sidebar]').forEach((button) => {
        button.addEventListener('click', () => panel?.classList.remove('hidden'));
    });
    document.querySelectorAll('[data-close-sidebar]').forEach((button) => {
        button.addEventListener('click', () => panel?.classList.add('hidden'));
    });
    panel?.addEventListener('click', (event) => {
        if (event.target === panel) {
            panel.classList.add('hidden');
        }
    });
});
</script>
</body>
</html>
