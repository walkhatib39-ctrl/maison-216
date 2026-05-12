@extends('layouts.admin')

@section('content')
<div class="mx-auto max-w-4xl space-y-6">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
        <div>
            <a href="{{ route('admin.site-pages.index', ['silo' => $page->silo]) }}" class="text-sm font-bold text-[#8e6322] hover:text-[#171411]">Retour aux pages</a>
            <h1 class="mt-2 text-2xl font-extrabold tracking-tight text-[#171411]">{{ $page->admin_title }}</h1>
            <p class="mt-1 text-sm text-[#6a5a4c]">/{{ $page->path }}</p>
        </div>
        <a href="{{ $page->publicUrl() }}" target="_blank" class="inline-flex items-center justify-center rounded-xl border border-[#d8c7af] bg-white px-4 py-2.5 text-sm font-bold text-[#171411] transition hover:bg-[#fbf7f0]">
            Voir la page
        </a>
    </div>

    @if($errors->any())
        <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-800">
            Corrigez les champs signales.
        </div>
    @endif

    <form method="POST" action="{{ route('admin.site-pages.update', $page) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <section class="rounded-2xl border border-[#eadfce] bg-white p-6 shadow-sm">
            <h2 class="text-base font-extrabold text-[#171411]">Informations page</h2>
            <div class="mt-5 grid gap-4 md:grid-cols-2">
                <div>
                    <label for="admin_title" class="mb-1 block text-sm font-bold text-[#171411]">Titre admin</label>
                    <input id="admin_title" name="admin_title" value="{{ old('admin_title', $page->admin_title) }}" required class="w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4">
                    @error('admin_title')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="mb-1 block text-sm font-bold text-[#171411]">Canonical</label>
                    <input value="{{ $page->canonicalUrl() }}" readonly class="w-full rounded-xl border border-[#eadfce] bg-[#fbf7f0] px-3 py-2.5 text-sm text-[#6a5a4c]">
                    <p class="mt-1 text-xs text-[#6a5a4c]">Genere automatiquement. Non modifiable.</p>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-bold text-[#171411]">Silo</label>
                    <input value="{{ $page->silo }}" readonly class="w-full rounded-xl border border-[#eadfce] bg-[#fbf7f0] px-3 py-2.5 text-sm text-[#6a5a4c]">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-bold text-[#171411]">Titre public</label>
                    <input value="{{ $page->public_title }}" readonly class="w-full rounded-xl border border-[#eadfce] bg-[#fbf7f0] px-3 py-2.5 text-sm text-[#6a5a4c]">
                </div>
            </div>
        </section>

        <section class="rounded-2xl border border-[#eadfce] bg-white p-6 shadow-sm">
            <h2 class="text-base font-extrabold text-[#171411]">SEO</h2>
            <div class="mt-5 space-y-5">
                <div>
                    <div class="mb-1 flex items-center justify-between gap-3">
                        <label for="meta_title" class="block text-sm font-bold text-[#171411]">Meta title</label>
                        <span class="text-xs font-semibold text-[#6a5a4c]">{{ mb_strlen((string) old('meta_title', $page->meta_title)) }}/160</span>
                    </div>
                    <input id="meta_title" name="meta_title" value="{{ old('meta_title', $page->meta_title) }}" class="w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4">
                    @error('meta_title')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
                </div>

                <div>
                    <div class="mb-1 flex items-center justify-between gap-3">
                        <label for="meta_description" class="block text-sm font-bold text-[#171411]">Meta description</label>
                        <span class="text-xs font-semibold text-[#6a5a4c]">{{ mb_strlen((string) old('meta_description', $page->meta_description)) }}/320</span>
                    </div>
                    <textarea id="meta_description" name="meta_description" rows="4" class="w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4">{{ old('meta_description', $page->meta_description) }}</textarea>
                    @error('meta_description')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="og_image" class="mb-1 block text-sm font-bold text-[#171411]">Image OG</label>
                    <input id="og_image" name="og_image" value="{{ old('og_image', $page->og_image) }}" class="w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4" placeholder="https://...">
                    @error('og_image')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <label class="flex items-center justify-between gap-4 rounded-2xl border border-[#eadfce] bg-[#fbf7f0] px-4 py-3">
                        <span>
                            <span class="block text-sm font-bold text-[#171411]">Indexable</span>
                            <span class="block text-xs text-[#6a5a4c]">Autoriser l'indexation moteurs.</span>
                        </span>
                        <input type="checkbox" name="is_indexable" value="1" @checked(old('is_indexable', $page->is_indexable)) class="h-5 w-5 rounded border-[#d8c7af] text-[#b88a3b] focus:ring-[#b88a3b]">
                    </label>
                    <div>
                        <label for="priority" class="mb-1 block text-sm font-bold text-[#171411]">Priorite sitemap</label>
                        <input id="priority" name="priority" value="{{ old('priority', $page->priority) }}" class="w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4" placeholder="0.8">
                        @error('priority')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>
        </section>

        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <a href="{{ route('admin.site-pages.index', ['silo' => $page->silo]) }}" class="inline-flex items-center justify-center rounded-xl border border-[#d8c7af] bg-white px-5 py-3 text-sm font-bold text-[#171411] transition hover:bg-[#fbf7f0]">
                Annuler
            </a>
            <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-[#171411] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#a47834]">
                Enregistrer les metas
            </button>
        </div>
    </form>
</div>
@endsection
