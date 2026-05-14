@extends('layouts.store')

@section('content')
@php
    $whatsappUrl = \App\Support\SiteSettings::whatsappUrl() ?? route('contact');
    $phoneDisplay = \App\Support\SiteSettings::phoneDisplay();
    $serviceArea = \App\Support\SiteSettings::serviceArea();
    $projectTypes = [
        'Cuisine sur mesure',
        'Dressing / placard',
        'Fenêtres ou portes aluminium',
        'Portail / pergola / garde-corps',
        'Aménagement villa ou maison',
        'Agencement café, restaurant, magasin ou bureau',
        'Autre demande',
    ];
@endphp

<section class="border-b border-[#eadfce] bg-[#fbf7ee]">
    <div class="container mx-auto px-4 py-5">
        <nav class="flex flex-wrap items-center gap-2 text-sm font-semibold text-[#6a5a4c]" aria-label="Fil d'Ariane">
            <a href="{{ route('home') }}" class="transition hover:text-[#171411]">Accueil</a>
            <i class="fa-solid fa-angle-right text-[10px] text-[#b88a3b]"></i>
            <span class="text-[#171411]">Devis</span>
        </nav>
    </div>
</section>

<section class="bg-[#f7f1e7] py-14 lg:py-20">
    <div class="container mx-auto grid gap-10 px-4 lg:grid-cols-[0.8fr_1.05fr] lg:items-start">
        <div>
            <h1 class="font-display text-4xl font-extrabold leading-tight tracking-[-0.05em] text-[#171411] sm:text-6xl">
                Expliquez votre projet. Nous vous répondons avec un cadrage clair.
            </h1>
            <p class="mt-6 max-w-2xl text-lg leading-9 text-[#5f5146]">
                Cuisine, dressing, fenêtres aluminium, portail, pergola ou projet complet : envoyez vos dimensions, photos ou plans. Nous revenons vers vous sous 48h pour cadrer la faisabilité, le budget et la prochaine étape.
            </p>

            <div class="mt-8 grid gap-3 sm:grid-cols-2">
                @foreach(['Devis gratuit', 'Pose & SAV inclus', 'Atelier à Borj Cedria', $serviceArea] as $item)
                    <div class="rounded-2xl border border-[#eadfce] bg-white px-4 py-3 text-sm font-bold text-[#3f352d]">
                        <i class="fa-solid fa-check mr-2 text-[#a47834]"></i>{{ $item }}
                    </div>
                @endforeach
            </div>

            <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="mt-8 inline-flex items-center gap-2 rounded-full border border-[#d8c7af] bg-white px-5 py-3 text-sm font-extrabold text-[#171411] transition hover:border-[#a47834]">
                <i class="fa-brands fa-whatsapp text-[#a47834]"></i>
                {{ $phoneDisplay }}
            </a>
        </div>

        <div class="rounded-[34px] border border-[#eadfce] bg-white p-6 shadow-[0_24px_70px_rgba(23,20,17,0.08)] lg:p-8">
            @if(session('success'))
                <div class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-bold text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-bold text-rose-800">
                    Corrigez les champs signales.
                </div>
            @endif

            <form action="{{ route('contact.submit') }}" method="post" class="space-y-5">
                @csrf
                <input type="hidden" name="subject" value="Demande de devis">
                <input type="hidden" name="has_project" value="yes">

                <div class="grid gap-4 md:grid-cols-2">
                    <label class="block">
                        <span class="text-sm font-bold text-[#171411]">Nom *</span>
                        <input name="name" required value="{{ old('name') }}" class="mt-2 w-full rounded-2xl border border-[#eadfce] bg-white px-4 py-3 text-sm focus:border-[#a47834] focus:ring-0">
                        @error('name')<span class="mt-1 block text-sm text-rose-700">{{ $message }}</span>@enderror
                    </label>
                    <label class="block">
                        <span class="text-sm font-bold text-[#171411]">Téléphone / WhatsApp *</span>
                        <input name="phone" required value="{{ old('phone') }}" placeholder="{{ $phoneDisplay }}" class="mt-2 w-full rounded-2xl border border-[#eadfce] bg-white px-4 py-3 text-sm focus:border-[#a47834] focus:ring-0">
                        @error('phone')<span class="mt-1 block text-sm text-rose-700">{{ $message }}</span>@enderror
                    </label>
                    <label class="block">
                        <span class="text-sm font-bold text-[#171411]">Email</span>
                        <input type="email" name="email" value="{{ old('email') }}" class="mt-2 w-full rounded-2xl border border-[#eadfce] bg-white px-4 py-3 text-sm focus:border-[#a47834] focus:ring-0">
                        @error('email')<span class="mt-1 block text-sm text-rose-700">{{ $message }}</span>@enderror
                    </label>
                    <label class="block">
                        <span class="text-sm font-bold text-[#171411]">Type de projet *</span>
                        <select name="project_type" required class="mt-2 w-full rounded-2xl border border-[#eadfce] bg-white px-4 py-3 text-sm focus:border-[#a47834] focus:ring-0">
                            <option value="">Selectionner</option>
                            @foreach($projectTypes as $type)
                                <option value="{{ $type }}" @selected(old('project_type') === $type)>{{ $type }}</option>
                            @endforeach
                        </select>
                        @error('project_type')<span class="mt-1 block text-sm text-rose-700">{{ $message }}</span>@enderror
                    </label>
                    <label class="block md:col-span-2">
                        <span class="text-sm font-bold text-[#171411]">Localisation du projet</span>
                        <input name="location" value="{{ old('location') }}" placeholder="Ex: La Marsa, Ennasr, Ben Arous..." class="mt-2 w-full rounded-2xl border border-[#eadfce] bg-white px-4 py-3 text-sm focus:border-[#a47834] focus:ring-0">
                        @error('location')<span class="mt-1 block text-sm text-rose-700">{{ $message }}</span>@enderror
                    </label>
                    <label class="block md:col-span-2">
                        <span class="text-sm font-bold text-[#171411]">Votre demande *</span>
                        <textarea name="message" rows="6" required class="mt-2 w-full rounded-2xl border border-[#eadfce] bg-white px-4 py-3 text-sm focus:border-[#a47834] focus:ring-0" placeholder="Dimensions, photos disponibles, delai souhaite, materiaux, contraintes...">{{ old('message') }}</textarea>
                        @error('message')<span class="mt-1 block text-sm text-rose-700">{{ $message }}</span>@enderror
                    </label>
                </div>

                <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-[#171411] px-7 py-4 text-sm font-extrabold text-white transition hover:bg-[#a47834] sm:w-auto">
                    Envoyer ma demande
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </form>
        </div>
    </div>
</section>
@endsection
