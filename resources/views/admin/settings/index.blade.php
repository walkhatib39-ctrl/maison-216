@extends('layouts.admin')

@section('content')
@php
    $input = 'mt-2 w-full rounded-2xl border border-[#e8ddce] bg-white px-4 py-3 text-sm text-[#171411] focus:border-[#b88a3b] focus:ring-2 focus:ring-[#b88a3b]/15';
    $label = 'block text-sm font-bold text-[#171411]';
    $help = 'mt-1 text-xs text-[#6a5a4c]';
    $section = 'rounded-[28px] border border-[#e8ddce] bg-white p-6 shadow-[0_18px_50px_rgba(23,20,17,0.05)]';
@endphp

<div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
    <div>
        <h1 class="text-3xl font-extrabold tracking-[-0.03em] text-[#171411]">Parametres site</h1>
        <p class="mt-1 text-sm text-[#6a5a4c]">Identite, contact, reseaux sociaux et outils SEO.</p>
    </div>
    <a href="{{ route('home') }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center gap-2 rounded-full border border-[#d8c7ad] bg-white px-5 py-3 text-sm font-bold text-[#171411] transition hover:border-[#b88a3b]">
        <i class="fa-regular fa-eye text-[#b88a3b]"></i>
        Voir le site
    </a>
</div>

@if(session('status'))
    <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-bold text-emerald-800">
        {{ session('status') }}
    </div>
@endif

@if ($errors->any())
    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-800">
        <div class="font-bold">Corrections necessaires</div>
        <ul class="mt-2 list-inside list-disc space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-6">
    @csrf

    <section class="{{ $section }}">
        <div class="mb-5">
            <h2 class="text-lg font-extrabold text-[#171411]">Identite</h2>
            <p class="text-sm text-[#6a5a4c]">Nom public et baseline du site.</p>
        </div>
        <div class="grid gap-5 md:grid-cols-2">
            <label class="{{ $label }}">
                Nom du site *
                <input required name="site_name" type="text" value="{{ old('site_name', $s['site_name']) }}" class="{{ $input }}">
            </label>
            <label class="{{ $label }}">
                Baseline
                <input name="site_tagline" type="text" value="{{ old('site_tagline', $s['site_tagline']) }}" class="{{ $input }}">
            </label>
        </div>
    </section>

    <section class="{{ $section }}">
        <div class="mb-5">
            <h2 class="text-lg font-extrabold text-[#171411]">Contact</h2>
            <p class="text-sm text-[#6a5a4c]">Informations affichees sur le site et emails de reception.</p>
        </div>
        <div class="grid gap-5 md:grid-cols-2">
            <label class="{{ $label }}">
                Telephone affiche
                <input name="phone_display" type="text" value="{{ old('phone_display', $s['phone_display']) }}" class="{{ $input }}" placeholder="96 813 203">
            </label>
            <label class="{{ $label }}">
                Telephone international
                <input name="phone_e164" type="text" value="{{ old('phone_e164', $s['phone_e164']) }}" class="{{ $input }}" placeholder="+21696813203">
                <span class="{{ $help }}">Utilise pour les liens telephone.</span>
            </label>
            <label class="{{ $label }}">
                WhatsApp
                <input name="whatsapp" type="text" value="{{ old('whatsapp', $s['whatsapp']) }}" class="{{ $input }}" placeholder="+21696813203">
            </label>
            <label class="{{ $label }}">
                Email public
                <input name="public_email" type="email" value="{{ old('public_email', $s['public_email']) }}" class="{{ $input }}" placeholder="contact@maison216.tn">
            </label>
            <label class="{{ $label }} md:col-span-2">
                Emails de reception
                <textarea name="admin_emails" rows="3" class="{{ $input }}" placeholder="admin@maison216.tn">{{ old('admin_emails', $s['admin_emails']) }}</textarea>
                <span class="{{ $help }}">Un email par ligne. Ces emails recevront les futures notifications de demandes.</span>
            </label>
        </div>
    </section>

    <section class="{{ $section }}">
        <div class="mb-5">
            <h2 class="text-lg font-extrabold text-[#171411]">Localisation</h2>
            <p class="text-sm text-[#6a5a4c]">Adresse atelier et zone de pose.</p>
        </div>
        <div class="grid gap-5 md:grid-cols-2">
            <label class="{{ $label }}">
                Adresse atelier
                <input name="address" type="text" value="{{ old('address', $s['address']) }}" class="{{ $input }}">
            </label>
            <label class="{{ $label }}">
                Ville
                <input name="city" type="text" value="{{ old('city', $s['city']) }}" class="{{ $input }}">
            </label>
            <label class="{{ $label }} md:col-span-2">
                Zone d'intervention
                <input name="service_area" type="text" value="{{ old('service_area', $s['service_area']) }}" class="{{ $input }}">
            </label>
        </div>
    </section>

    <section class="{{ $section }}">
        <div class="mb-5">
            <h2 class="text-lg font-extrabold text-[#171411]">Reseaux sociaux</h2>
            <p class="text-sm text-[#6a5a4c]">Liens publics affiches dans le footer.</p>
        </div>
        <div class="grid gap-5 md:grid-cols-2">
            <label class="{{ $label }}">Facebook<input name="facebook" type="url" value="{{ old('facebook', $s['facebook']) }}" class="{{ $input }}"></label>
            <label class="{{ $label }}">Instagram<input name="instagram" type="url" value="{{ old('instagram', $s['instagram']) }}" class="{{ $input }}"></label>
            <label class="{{ $label }}">TikTok<input name="tiktok" type="url" value="{{ old('tiktok', $s['tiktok']) }}" class="{{ $input }}"></label>
            <label class="{{ $label }}">LinkedIn<input name="linkedin" type="url" value="{{ old('linkedin', $s['linkedin']) }}" class="{{ $input }}"></label>
            <label class="{{ $label }}">YouTube<input name="youtube" type="url" value="{{ old('youtube', $s['youtube']) }}" class="{{ $input }}"></label>
            <label class="{{ $label }}">Messenger<input name="messenger" type="url" value="{{ old('messenger', $s['messenger']) }}" class="{{ $input }}"></label>
        </div>
    </section>

    <section class="{{ $section }}">
        <div class="mb-5">
            <h2 class="text-lg font-extrabold text-[#171411]">SEO & outils</h2>
            <p class="text-sm text-[#6a5a4c]">Tokens de verification uniquement. Aucun script libre.</p>
        </div>
        <div class="grid gap-5 md:grid-cols-2">
            <label class="{{ $label }}">
                Google Search Console
                <input name="google_site_verification" type="text" value="{{ old('google_site_verification', $s['google_site_verification']) }}" class="{{ $input }}">
                <span class="{{ $help }}">Coller uniquement la valeur du token.</span>
            </label>
            <label class="{{ $label }}">
                Bing Webmaster
                <input name="bing_site_verification" type="text" value="{{ old('bing_site_verification', $s['bing_site_verification']) }}" class="{{ $input }}">
                <span class="{{ $help }}">Coller uniquement la valeur `msvalidate.01`.</span>
            </label>
            <label class="{{ $label }}">
                Image OG globale par URL
                <input name="seo_og_image_url" type="text" value="{{ old('seo_og_image_url', $s['seo_og_image']) }}" class="{{ $input }}">
            </label>
            <label class="{{ $label }}">
                Image OG globale par fichier
                <input name="seo_og_image_file" type="file" accept="image/*" class="{{ $input }}">
            </label>
        </div>
    </section>

    <section class="{{ $section }}">
        <div class="mb-5">
            <h2 class="text-lg font-extrabold text-[#171411]">Assets</h2>
            <p class="text-sm text-[#6a5a4c]">Logo et favicon utilises par le front.</p>
        </div>
        <div class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-3xl border border-[#e8ddce] bg-[#fbf7f0] p-5">
                <div class="mb-4 text-sm font-extrabold text-[#171411]">Logo</div>
                @if($s['ui_logo'])
                    <img src="{{ \App\Support\SiteSettings::assetUrl($s['ui_logo']) }}" alt="Logo actuel" class="mb-4 h-12 w-auto object-contain">
                @endif
                <label class="{{ $label }}">URL logo<input name="ui_logo_url" type="text" value="{{ old('ui_logo_url', $s['ui_logo']) }}" class="{{ $input }}"></label>
                <label class="{{ $label }} mt-4">Fichier logo<input name="ui_logo_file" type="file" accept="image/*" class="{{ $input }}"></label>
            </div>
            <div class="rounded-3xl border border-[#e8ddce] bg-[#fbf7f0] p-5">
                <div class="mb-4 text-sm font-extrabold text-[#171411]">Favicon</div>
                @if($s['ui_favicon'])
                    <img src="{{ \App\Support\SiteSettings::assetUrl($s['ui_favicon']) }}" alt="Favicon actuel" class="mb-4 h-10 w-10 object-contain">
                @endif
                <label class="{{ $label }}">URL favicon<input name="ui_favicon_url" type="text" value="{{ old('ui_favicon_url', $s['ui_favicon']) }}" class="{{ $input }}"></label>
                <label class="{{ $label }} mt-4">Fichier favicon<input name="ui_favicon_file" type="file" accept=".ico,.png,.svg" class="{{ $input }}"></label>
            </div>
        </div>
    </section>

    <div class="sticky bottom-0 z-10 -mx-4 border-t border-[#e8ddce] bg-[#f7f4ee]/92 px-4 py-4 backdrop-blur">
        <div class="flex justify-end">
            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-full bg-[#171411] px-7 py-4 text-sm font-extrabold text-white transition hover:bg-[#b88a3b]">
                <i class="fa-regular fa-floppy-disk"></i>
                Enregistrer les parametres
            </button>
        </div>
    </div>
</form>
@endsection
