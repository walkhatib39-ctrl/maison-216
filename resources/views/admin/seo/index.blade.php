@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-extrabold tracking-tight text-[#171411]">SEO & outils</h1>
        <p class="mt-1 text-sm text-[#6a5a4c]">Sitemap, robots et verifications moteurs.</p>
    </div>

    <div class="grid gap-4 md:grid-cols-3">
        <a href="{{ route('sitemap') }}" target="_blank" class="rounded-2xl border border-[#eadfce] bg-white p-5 shadow-sm transition hover:bg-[#fbf7f0]">
            <div class="text-sm font-semibold text-[#6a5a4c]">Sitemap XML</div>
            <div class="mt-2 text-lg font-extrabold text-[#171411]">Voir le sitemap</div>
        </a>
        <a href="{{ route('robots') }}" target="_blank" class="rounded-2xl border border-[#eadfce] bg-white p-5 shadow-sm transition hover:bg-[#fbf7f0]">
            <div class="text-sm font-semibold text-[#6a5a4c]">Robots.txt</div>
            <div class="mt-2 text-lg font-extrabold text-[#171411]">Voir robots.txt</div>
        </a>
        <a href="{{ route('admin.site-pages.index') }}" class="rounded-2xl border border-[#eadfce] bg-white p-5 shadow-sm transition hover:bg-[#fbf7f0]">
            <div class="text-sm font-semibold text-[#6a5a4c]">Metas par page</div>
            <div class="mt-2 text-lg font-extrabold text-[#171411]">Ouvrir Pages & SEO</div>
        </a>
    </div>

    <section class="rounded-2xl border border-[#eadfce] bg-white p-6 shadow-sm">
        <h2 class="text-base font-extrabold text-[#171411]">Regles de securite</h2>
        <div class="mt-4 grid gap-3 md:grid-cols-2">
            <div class="rounded-2xl bg-[#fbf7f0] p-4 text-sm font-semibold text-[#6a5a4c]">
                Les canonical sont generes automatiquement par le code.
            </div>
            <div class="rounded-2xl bg-[#fbf7f0] p-4 text-sm font-semibold text-[#6a5a4c]">
                Aucun script libre n'est editable depuis l'admin.
            </div>
        </div>
    </section>
</div>
@endsection
