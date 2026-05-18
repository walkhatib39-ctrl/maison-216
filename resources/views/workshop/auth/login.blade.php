<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Connexion atelier — Maison216</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f7f4ee] font-sans text-[#171411] antialiased">
    <main class="flex min-h-screen items-center justify-center px-4 py-10">
        <section class="w-full max-w-md overflow-hidden rounded-[2rem] border border-[#e6dac8] bg-white shadow-xl shadow-black/5">
            <div class="border-b border-[#eadfce] bg-[#fbf7f0] p-8">
                <div class="text-xs font-extrabold uppercase tracking-[0.24em] text-[#a47834]">Maison216</div>
                <h1 class="mt-3 text-3xl font-extrabold tracking-tight">Gestion atelier</h1>
                <p class="mt-2 text-sm font-medium text-[#6a5a4c]">Carnet de commandes interne.</p>
            </div>

            <form method="POST" action="{{ route('workshop.login.store') }}" class="space-y-5 p-8">
                @csrf

                @if($errors->any())
                    <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-800">
                        {{ $errors->first() }}
                    </div>
                @endif

                <label class="block">
                    <span class="text-sm font-bold">Email</span>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-4 py-3 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4">
                </label>

                <label class="block">
                    <span class="text-sm font-bold">Mot de passe</span>
                    <input type="password" name="password" required autocomplete="current-password" class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-4 py-3 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4">
                </label>

                <label class="inline-flex items-center gap-2 text-sm font-semibold text-[#6a5a4c]">
                    <input type="checkbox" name="remember" value="1" class="rounded border-[#d8c7af] text-[#a47834] focus:ring-[#a47834]">
                    Rester connecté
                </label>

                <button class="w-full rounded-xl bg-[#171411] px-5 py-3 text-sm font-extrabold text-white transition hover:bg-[#a47834]">
                    Entrer
                </button>
            </form>
        </section>
    </main>
</body>
</html>
