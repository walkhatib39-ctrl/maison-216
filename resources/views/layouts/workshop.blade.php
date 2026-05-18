<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Gestion atelier — {{ \App\Models\Setting::get('site.name', 'Maison216') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f7f4ee] font-sans text-[#171411] antialiased">
@php
    $nav = [
        ['label' => 'Aujourd’hui', 'route' => 'workshop.today', 'active' => 'workshop.today'],
        ['label' => 'Commandes', 'route' => 'workshop.orders.index', 'active' => 'workshop.orders.*'],
        ['label' => 'Clients', 'route' => 'workshop.clients.index', 'active' => 'workshop.clients.*'],
    ];
@endphp

<div class="min-h-screen">
    <header class="sticky top-0 z-40 border-b border-[#e6dac8] bg-[#fbf7f0]/95 backdrop-blur">
        <div class="mx-auto flex max-w-7xl flex-col gap-4 px-4 py-4 lg:px-8">
            <div class="flex items-center justify-between gap-4">
                <a href="{{ route('workshop.today') }}" class="min-w-0">
                    <div class="text-xs font-extrabold uppercase tracking-[0.24em] text-[#a47834]">Maison216</div>
                    <div class="mt-1 text-xl font-extrabold tracking-tight text-[#171411]">Gestion atelier</div>
                </a>
                <div class="flex items-center gap-2">
                    <a href="{{ route('workshop.orders.create') }}" class="hidden rounded-xl bg-[#171411] px-4 py-2.5 text-sm font-bold text-white transition hover:bg-[#a47834] sm:inline-flex">+ Commande</a>
                    <form method="POST" action="{{ route('workshop.logout') }}">
                        @csrf
                        <button class="rounded-xl border border-[#d8c7af] bg-white px-4 py-2.5 text-sm font-bold text-[#171411] transition hover:bg-[#f7f4ee]">
                            Sortir
                        </button>
                    </form>
                </div>
            </div>

            <nav class="flex gap-2 overflow-x-auto pb-1">
                @foreach($nav as $item)
                    <a href="{{ route($item['route']) }}"
                       class="whitespace-nowrap rounded-full border px-4 py-2 text-sm font-bold transition {{ request()->routeIs($item['active']) ? 'border-[#171411] bg-[#171411] text-white' : 'border-[#d8c7af] bg-white text-[#171411] hover:bg-[#f7f4ee]' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
                <a href="{{ route('workshop.orders.create') }}" class="whitespace-nowrap rounded-full border border-[#171411] bg-[#171411] px-4 py-2 text-sm font-bold text-white sm:hidden">
                    + Commande
                </a>
            </nav>
        </div>
    </header>

    <main class="px-4 py-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
            @yield('content')
        </div>
    </main>
</div>
</body>
</html>
