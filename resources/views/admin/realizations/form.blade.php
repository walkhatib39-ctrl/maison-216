@extends('layouts.admin')

@section('content')
@php
    $isEdit = $realization->exists;
@endphp

<div class="mx-auto max-w-6xl space-y-6">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
        <div>
            <a href="{{ route('admin.realizations.index') }}" class="text-sm font-bold text-[#8e6322] hover:text-[#171411]">Retour aux realisations</a>
            <h1 class="mt-2 text-2xl font-extrabold tracking-tight text-[#171411]">{{ $isEdit ? $realization->title : 'Ajouter une realisation' }}</h1>
            <p class="mt-1 text-sm text-[#6a5a4c]">{{ $isEdit ? 'Modifier le portfolio public.' : 'Creer une carte portfolio assignable aux pages.' }}</p>
        </div>
        @if($isEdit && $realization->status === \App\Models\Realization::STATUS_PUBLISHED)
            <a href="{{ route('realizations.show', $realization) }}" target="_blank" class="inline-flex items-center justify-center rounded-xl border border-[#d8c7af] bg-white px-4 py-2.5 text-sm font-bold text-[#171411] transition hover:bg-[#fbf7f0]">
                Voir sur le site
            </a>
        @endif
    </div>

    @if(session('status'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
            {{ session('status') }}
        </div>
    @endif

    @if($errors->any())
        <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-800">
            Corrigez les champs signales.
        </div>
    @endif

    <form method="POST" action="{{ $isEdit ? route('admin.realizations.update', $realization) : route('admin.realizations.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div class="grid gap-6 lg:grid-cols-[1fr_0.82fr]">
            <div class="space-y-6">
                <section class="rounded-2xl border border-[#eadfce] bg-white p-6 shadow-sm">
                    <h2 class="text-base font-extrabold text-[#171411]">Contenu</h2>
                    <div class="mt-5 grid gap-4 md:grid-cols-2">
                        <label class="block md:col-span-2">
                            <span class="text-sm font-bold text-[#171411]">Titre *</span>
                            <input name="title" value="{{ old('title', $realization->title) }}" required class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4">
                            @error('title')<span class="mt-1 block text-sm text-rose-700">{{ $message }}</span>@enderror
                        </label>

                        <label class="block">
                            <span class="text-sm font-bold text-[#171411]">Slug</span>
                            <input name="slug" value="{{ old('slug', $realization->slug) }}" class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4" placeholder="Auto si vide">
                            @error('slug')<span class="mt-1 block text-sm text-rose-700">{{ $message }}</span>@enderror
                        </label>

                        <label class="block">
                            <span class="text-sm font-bold text-[#171411]">Type de projet</span>
                            <input name="project_type" value="{{ old('project_type', $realization->project_type) }}" class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4" placeholder="Cuisine, pergola, vitrine...">
                            @error('project_type')<span class="mt-1 block text-sm text-rose-700">{{ $message }}</span>@enderror
                        </label>

                        <label class="block md:col-span-2">
                            <span class="text-sm font-bold text-[#171411]">Silo *</span>
                            <select name="silo" required class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4">
                                @foreach($silos as $value => $label)
                                    <option value="{{ $value }}" @selected(old('silo', $realization->silo) === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('silo')<span class="mt-1 block text-sm text-rose-700">{{ $message }}</span>@enderror
                        </label>

                        <label class="block md:col-span-2">
                            <span class="text-sm font-bold text-[#171411]">Description courte</span>
                            <textarea name="short_description" rows="3" class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4">{{ old('short_description', $realization->short_description) }}</textarea>
                            @error('short_description')<span class="mt-1 block text-sm text-rose-700">{{ $message }}</span>@enderror
                        </label>

                        <label class="block md:col-span-2">
                            <span class="text-sm font-bold text-[#171411]">Description longue</span>
                            <textarea name="description" rows="6" class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4">{{ old('description', $realization->description) }}</textarea>
                            @error('description')<span class="mt-1 block text-sm text-rose-700">{{ $message }}</span>@enderror
                        </label>
                    </div>
                </section>

                <section class="rounded-2xl border border-[#eadfce] bg-white p-6 shadow-sm">
                    <h2 class="text-base font-extrabold text-[#171411]">Images</h2>
                    <div class="mt-5 space-y-5">
                        @if($isEdit && $realization->cover_image)
                            <div class="overflow-hidden rounded-2xl border border-[#eadfce] bg-[#fbf7f0]">
                                <img src="{{ $realization->coverImageUrl() }}" alt="{{ $realization->cover_alt ?: $realization->title }}" class="h-72 w-full object-cover">
                            </div>
                        @endif

                        <label class="block">
                            <span class="text-sm font-bold text-[#171411]">Image principale {{ $isEdit ? '' : '*' }}</span>
                            <input type="file" name="cover_image" accept="image/jpeg,image/png,image/webp" @required(!$isEdit) class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4">
                            @error('cover_image')<span class="mt-1 block text-sm text-rose-700">{{ $message }}</span>@enderror
                        </label>

                        <label class="block">
                            <span class="text-sm font-bold text-[#171411]">Alt text image principale</span>
                            <input name="cover_alt" value="{{ old('cover_alt', $realization->cover_alt) }}" class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4">
                            @error('cover_alt')<span class="mt-1 block text-sm text-rose-700">{{ $message }}</span>@enderror
                        </label>

                        <label class="block">
                            <span class="text-sm font-bold text-[#171411]">Ajouter des images galerie</span>
                            <input type="file" name="gallery_images[]" accept="image/jpeg,image/png,image/webp" multiple class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4">
                            @error('gallery_images.*')<span class="mt-1 block text-sm text-rose-700">{{ $message }}</span>@enderror
                        </label>

                        @if($isEdit && $realization->images->isNotEmpty())
                            <div>
                                <div class="text-sm font-bold text-[#171411]">Galerie actuelle</div>
                                <div class="mt-3 grid gap-3 sm:grid-cols-2">
                                    @foreach($realization->images as $image)
                                        <label class="overflow-hidden rounded-2xl border border-[#eadfce] bg-[#fbf7f0]">
                                            <img src="{{ $image->imageUrl() }}" alt="{{ $image->alt_text ?: $realization->title }}" class="h-36 w-full object-cover">
                                            <span class="flex items-center gap-2 px-3 py-2 text-xs font-bold text-rose-700">
                                                <input type="checkbox" name="delete_image_ids[]" value="{{ $image->id }}" class="rounded border-[#d8c7af] text-rose-700 focus:ring-rose-700">
                                                Supprimer
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </section>
            </div>

            <aside class="space-y-6">
                <section class="rounded-2xl border border-[#eadfce] bg-white p-6 shadow-sm">
                    <h2 class="text-base font-extrabold text-[#171411]">Publication</h2>
                    <div class="mt-5 space-y-4">
                        <label class="block">
                            <span class="text-sm font-bold text-[#171411]">Statut *</span>
                            <select name="status" required class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4">
                                @foreach($statuses as $value => $label)
                                    <option value="{{ $value }}" @selected(old('status', $realization->status) === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </label>

                        <label class="flex items-center justify-between gap-4 rounded-2xl border border-[#eadfce] bg-[#fbf7f0] px-4 py-3">
                            <span>
                                <span class="block text-sm font-bold text-[#171411]">Afficher sur l'accueil</span>
                                <span class="block text-xs text-[#6a5a4c]">Prioritaire dans la section home.</span>
                            </span>
                            <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $realization->is_featured)) class="h-5 w-5 rounded border-[#d8c7af] text-[#b88a3b] focus:ring-[#b88a3b]">
                        </label>

                        <label class="block">
                            <span class="text-sm font-bold text-[#171411]">Date de realisation</span>
                            <input type="date" name="completed_at" value="{{ old('completed_at', optional($realization->completed_at)->format('Y-m-d')) }}" class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4">
                        </label>

                        <label class="block">
                            <span class="text-sm font-bold text-[#171411]">Ordre</span>
                            <input type="number" min="0" name="sort_order" value="{{ old('sort_order', $realization->sort_order ?? 0) }}" class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4">
                        </label>
                    </div>
                </section>

                <section class="rounded-2xl border border-[#eadfce] bg-white p-6 shadow-sm">
                    <h2 class="text-base font-extrabold text-[#171411]">Afficher sur les pages</h2>
                    <div class="mt-5 max-h-[640px] space-y-5 overflow-y-auto pr-1">
                        @foreach($pages as $silo => $group)
                            <div>
                                <div class="mb-2 text-xs font-bold uppercase tracking-[0.18em] text-[#a47834]">{{ $silo }}</div>
                                <div class="space-y-2">
                                    @foreach($group as $page)
                                        <label class="flex items-start gap-3 rounded-2xl border border-[#eadfce] bg-[#fbf7f0] px-3 py-3 text-sm">
                                            <input type="checkbox" name="page_ids[]" value="{{ $page->id }}" @checked(collect(old('page_ids', $selectedPages->all()))->contains($page->id)) class="mt-0.5 h-4 w-4 rounded border-[#d8c7af] text-[#b88a3b] focus:ring-[#b88a3b]">
                                            <span>
                                                <span class="block font-bold text-[#171411]">{{ $page->admin_title }}</span>
                                                <span class="block text-xs text-[#6a5a4c]">/{{ $page->path }}</span>
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            </aside>
        </div>

        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <a href="{{ route('admin.realizations.index') }}" class="inline-flex items-center justify-center rounded-xl border border-[#d8c7af] bg-white px-5 py-3 text-sm font-bold text-[#171411] transition hover:bg-[#fbf7f0]">
                Annuler
            </a>
            <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-[#171411] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#a47834]">
                {{ $isEdit ? 'Enregistrer' : 'Creer la realisation' }}
            </button>
        </div>
    </form>
</div>
@endsection
