@extends('layouts.admin')

@section('content')
<div class="space-y-7">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
        <div>
            <h1 class="text-3xl font-extrabold tracking-[-0.03em] text-[#171411]">Mediatheque</h1>
            <p class="mt-1 max-w-2xl text-sm leading-6 text-[#6a5a4c]">Images disponibles sur le serveur Maison216. Utilisez-les dans les realisations, produits Showroom, SEO et parametres site.</p>
        </div>
        <div class="flex flex-col gap-2 sm:flex-row">
            <form method="POST" action="{{ route('admin.media.sync') }}">
                @csrf
                <button type="submit" class="inline-flex items-center justify-center rounded-xl border border-[#d8c7af] bg-white px-4 py-2.5 text-sm font-extrabold text-[#171411] transition hover:bg-[#fbf7f0]">
                    Synchroniser les images utiles
                </button>
            </form>
            <form method="POST" action="{{ route('admin.media.sync') }}">
                @csrf
                <input type="hidden" name="include_catalog_images" value="1">
                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-[#171411] px-4 py-2.5 text-sm font-extrabold text-white transition hover:bg-[#a47834]">
                    Synchroniser tout le serveur
                </button>
            </form>
        </div>
    </div>

    @if(session('status'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">{{ session('status') }}</div>
    @endif

    @if($errors->any())
        <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-800">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="grid gap-4 md:grid-cols-5">
        @foreach([
            ['label' => 'Total', 'value' => $stats['total']],
            ['label' => 'Uploads admin', 'value' => $stats['uploads']],
            ['label' => 'Assets publics', 'value' => $stats['assets']],
            ['label' => 'Images catalogue', 'value' => $stats['images']],
            ['label' => 'Storage', 'value' => $stats['storage']],
        ] as $card)
            <div class="rounded-2xl border border-[#eadfce] bg-white p-5 shadow-sm">
                <div class="text-xs font-bold uppercase tracking-[0.16em] text-[#a47834]">{{ $card['label'] }}</div>
                <div class="mt-2 text-3xl font-extrabold text-[#171411]">{{ $card['value'] }}</div>
            </div>
        @endforeach
    </div>

    <section class="rounded-[26px] border border-[#eadfce] bg-white p-5 shadow-sm">
        <form method="POST" action="{{ route('admin.media.upload') }}" enctype="multipart/form-data" class="grid gap-4 lg:grid-cols-[1fr_auto] lg:items-end">
            @csrf
            <label class="block">
                <span class="text-sm font-bold text-[#171411]">Ajouter des images</span>
                <input type="file" name="media_files[]" multiple accept="image/*,.ico,.svg" class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 file:mr-4 file:rounded-lg file:border-0 file:bg-[#171411] file:px-4 file:py-2 file:text-sm file:font-bold file:text-white focus:ring-4">
            </label>
            <button class="rounded-xl bg-[#171411] px-5 py-3 text-sm font-extrabold text-white transition hover:bg-[#a47834]">Uploader</button>
        </form>
    </section>

    <section class="rounded-[26px] border border-[#eadfce] bg-white p-5 shadow-sm">
        <form method="GET" class="grid gap-3 lg:grid-cols-[1fr_220px_auto]">
            <input name="q" value="{{ $filters['q'] }}" placeholder="Rechercher nom de fichier ou chemin..." class="rounded-xl border border-[#d8c7af] bg-white px-4 py-3 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4">
            <select name="source" class="rounded-xl border border-[#d8c7af] bg-white px-4 py-3 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4">
                <option value="">Toutes sources</option>
                @foreach(['upload' => 'Uploads admin', 'uploads' => 'Uploads existants', 'assets' => 'Assets publics', 'images' => 'Images catalogue', 'storage' => 'Storage'] as $value => $label)
                    <option value="{{ $value }}" @selected($filters['source'] === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <button class="rounded-xl border border-[#d8c7af] bg-[#fbf7f0] px-5 py-3 text-sm font-extrabold text-[#171411]">Filtrer</button>
        </form>
    </section>

    <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @forelse($assets as $asset)
            <article class="overflow-hidden rounded-[24px] border border-[#eadfce] bg-white shadow-sm">
                <a href="{{ $asset->public_url }}" target="_blank" class="block bg-[#f0e5d4]">
                    <img src="{{ $asset->public_url }}" alt="{{ $asset->alt_text ?: $asset->filename }}" loading="lazy" class="aspect-[4/3] w-full object-cover">
                </a>
                <div class="space-y-3 p-4">
                    <div>
                        <div class="truncate text-sm font-extrabold text-[#171411]" title="{{ $asset->filename }}">{{ $asset->filename }}</div>
                        <div class="mt-1 text-xs font-semibold text-[#6a5a4c]">{{ $asset->dimensions_label ?: 'Dimensions non lues' }} · {{ $asset->human_size }}</div>
                    </div>
                    <div class="rounded-xl bg-[#fbf7f0] px-3 py-2 text-xs font-semibold text-[#6a5a4c]">
                        <div class="truncate" title="{{ $asset->path }}">{{ $asset->path }}</div>
                    </div>
                    <div class="flex gap-2">
                        <button type="button" data-copy-media="{{ $asset->path }}" class="flex-1 rounded-xl border border-[#d8c7af] px-3 py-2 text-xs font-extrabold text-[#171411]">Copier chemin</button>
                        <a href="{{ $asset->public_url }}" target="_blank" class="rounded-xl bg-[#171411] px-3 py-2 text-xs font-extrabold text-white">Ouvrir</a>
                    </div>
                </div>
            </article>
        @empty
            <div class="col-span-full rounded-[24px] border border-dashed border-[#d8c7af] bg-white px-6 py-14 text-center">
                <div class="text-lg font-extrabold text-[#171411]">Aucune image trouvee</div>
                <p class="mt-2 text-sm text-[#6a5a4c]">Uploadez une image ou lancez une synchronisation du serveur.</p>
            </div>
        @endforelse
    </section>

    @if($assets->hasPages())
        <div class="rounded-2xl border border-[#eadfce] bg-white px-4 py-3">
            {{ $assets->links() }}
        </div>
    @endif
</div>
@endsection
