@extends('layouts.admin')

@section('content')
@php
    $selectedShowroomActivityIds = collect(old('showroom_activity_ids', $selectedShowroomActivityIds ?? $product->showroomActivities->pluck('id')->all()));
@endphp

<div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
    <div>
        <a href="{{ route('admin.products.index') }}" class="text-sm font-extrabold text-[#8e6322]">Retour aux produits</a>
        <h1 class="mt-2 text-3xl font-extrabold text-[#171411]">{{ $product->title }}</h1>
        <p class="mt-1 text-sm font-medium text-[#6a5a4c]">/{{ $product->slug }}</p>
    </div>
    <a href="{{ route('showroom.product.show', $product->slug) }}" target="_blank" class="inline-flex w-fit items-center justify-center rounded-xl border border-[#d8c7af] bg-white px-4 py-2.5 text-sm font-bold text-[#171411]">
        Voir la fiche
    </a>
</div>

@if (session('status'))
    <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-semibold text-emerald-800">{{ session('status') }}</div>
@endif

@if ($errors->any())
    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm font-semibold text-red-800">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="grid gap-6 xl:grid-cols-[1fr_360px]">
    @csrf
    @method('PUT')

    <div class="space-y-6">
        <section class="rounded-[22px] border border-[#e6dac8] bg-white p-6 shadow-sm">
            <h2 class="text-lg font-extrabold text-[#171411]">Informations produit</h2>
            <div class="mt-6 grid gap-5 md:grid-cols-2">
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-[#171411]">Nom du produit *</label>
                    <input required name="title" value="{{ old('title', $product->title) }}" class="mt-2 w-full rounded-xl border-[#d8c7af] px-4 py-3 text-sm focus:border-[#b88a3b] focus:ring-0">
                </div>

                <div>
                    <label class="block text-sm font-bold text-[#171411]">Slug</label>
                    <input name="slug" value="{{ old('slug', $product->slug) }}" class="mt-2 w-full rounded-xl border-[#d8c7af] px-4 py-3 text-sm focus:border-[#b88a3b] focus:ring-0">
                </div>

                <div>
                    <label class="block text-sm font-bold text-[#171411]">Type de vente *</label>
                    <select name="sale_mode" required class="mt-2 w-full rounded-xl border-[#d8c7af] px-4 py-3 text-sm focus:border-[#b88a3b] focus:ring-0">
                        <option value="catalog" @selected(old('sale_mode', $product->isQuoteOnly() ? 'sur_mesure' : 'catalog') === 'catalog')>Produit commandable</option>
                        <option value="sur_mesure" @selected(old('sale_mode', $product->isQuoteOnly() ? 'sur_mesure' : 'catalog') === 'sur_mesure')>Produit sur devis</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-[#171411]">Badge</label>
                    <input name="showroom_badge" value="{{ old('showroom_badge', $product->showroom_badge) }}" class="mt-2 w-full rounded-xl border-[#d8c7af] px-4 py-3 text-sm focus:border-[#b88a3b] focus:ring-0" placeholder="Standard, Sur mesure, Premium, Pro">
                </div>

                <div>
                    <label class="block text-sm font-bold text-[#171411]">Disponibilite / stock *</label>
                    <input required name="stock" type="number" min="0" step="1" value="{{ old('stock', $product->stock) }}" class="mt-2 w-full rounded-xl border-[#d8c7af] px-4 py-3 text-sm focus:border-[#b88a3b] focus:ring-0">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-[#171411]">Activites concernees</label>
                    <select name="showroom_activity_ids[]" multiple size="8" class="mt-2 w-full rounded-xl border-[#d8c7af] px-4 py-3 text-sm focus:border-[#b88a3b] focus:ring-0">
                        @foreach($showroomActivities as $activity)
                            <option value="{{ $activity->id }}" @selected($selectedShowroomActivityIds->contains($activity->id))>{{ $activity->name }}</option>
                        @endforeach
                    </select>
                    <p class="mt-2 text-xs font-semibold text-[#7a6b5a]">Ctrl/Cmd pour selectionner plusieurs activites.</p>
                </div>
            </div>
        </section>

        <section class="rounded-[22px] border border-[#e6dac8] bg-white p-6 shadow-sm">
            <h2 class="text-lg font-extrabold text-[#171411]">Prix et conditions</h2>
            <div class="mt-6 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
                <div>
                    <label class="block text-sm font-bold text-[#171411]">Prix de vente</label>
                    <input name="price" value="{{ old('price', $product->price_millimes !== null ? (int) floor($product->price_millimes / 1000) : '') }}" class="mt-2 w-full rounded-xl border-[#d8c7af] px-4 py-3 text-sm focus:border-[#b88a3b] focus:ring-0">
                    <p class="mt-2 text-xs font-semibold text-[#7a6b5a]">Obligatoire si commandable. Vide = sur devis.</p>
                </div>
                <div>
                    <label class="block text-sm font-bold text-[#171411]">Prix promotionnel</label>
                    <input name="compare_at" value="{{ old('compare_at', $product->compare_at_millimes !== null ? (int) floor($product->compare_at_millimes / 1000) : '') }}" class="mt-2 w-full rounded-xl border-[#d8c7af] px-4 py-3 text-sm focus:border-[#b88a3b] focus:ring-0">
                </div>
                <label class="flex items-center gap-3 rounded-xl border border-[#e6dac8] bg-[#fbf7f0] px-4 py-3">
                    <input type="checkbox" name="is_starting_price" value="1" @checked(old('is_starting_price', $product->is_starting_price)) class="rounded border-[#c8b694] text-[#b88a3b] focus:ring-[#b88a3b]">
                    <span class="text-sm font-bold text-[#171411]">Afficher “A partir de”</span>
                </label>
                <div>
                    <label class="block text-sm font-bold text-[#171411]">Disponibilite</label>
                    <input name="availability_label" value="{{ old('availability_label', $product->availability_label) }}" class="mt-2 w-full rounded-xl border-[#d8c7af] px-4 py-3 text-sm focus:border-[#b88a3b] focus:ring-0">
                </div>
                <div>
                    <label class="block text-sm font-bold text-[#171411]">Livraison</label>
                    <input name="delivery_note" value="{{ old('delivery_note', $product->delivery_note) }}" class="mt-2 w-full rounded-xl border-[#d8c7af] px-4 py-3 text-sm focus:border-[#b88a3b] focus:ring-0">
                </div>
            </div>
        </section>

        <section class="rounded-[22px] border border-[#e6dac8] bg-white p-6 shadow-sm">
            <h2 class="text-lg font-extrabold text-[#171411]">Contenu et specifications</h2>
            <div class="mt-6 grid gap-5 md:grid-cols-2">
                <div>
                    <label class="block text-sm font-bold text-[#171411]">Materiaux</label>
                    <input name="material_summary" value="{{ old('material_summary', $product->material_summary) }}" class="mt-2 w-full rounded-xl border-[#d8c7af] px-4 py-3 text-sm focus:border-[#b88a3b] focus:ring-0">
                </div>
                <div>
                    <label class="block text-sm font-bold text-[#171411]">Dimensions</label>
                    <input name="dimension_summary" value="{{ old('dimension_summary', $product->dimension_summary) }}" class="mt-2 w-full rounded-xl border-[#d8c7af] px-4 py-3 text-sm focus:border-[#b88a3b] focus:ring-0">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-[#171411]">Finitions</label>
                    <input name="finish_summary" value="{{ old('finish_summary', $product->finish_summary) }}" class="mt-2 w-full rounded-xl border-[#d8c7af] px-4 py-3 text-sm focus:border-[#b88a3b] focus:ring-0">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-[#171411]">Description courte</label>
                    <textarea name="short_description" rows="3" class="mt-2 w-full rounded-xl border-[#d8c7af] px-4 py-3 text-sm focus:border-[#b88a3b] focus:ring-0">{{ old('short_description', $product->short_description) }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-[#171411]">Description longue</label>
                    <textarea name="long_description" rows="8" class="mt-2 w-full rounded-xl border-[#d8c7af] px-4 py-3 text-sm focus:border-[#b88a3b] focus:ring-0">{{ old('long_description', $product->long_description) }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-[#171411]">Options personnalisables JSON</label>
                    <textarea name="custom_options_json" rows="5" class="mt-2 w-full rounded-xl border-[#d8c7af] px-4 py-3 font-mono text-sm focus:border-[#b88a3b] focus:ring-0">{{ old('custom_options_json', $product->custom_options ? json_encode($product->custom_options, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) : '') }}</textarea>
                </div>
            </div>
        </section>
    </div>

    <aside class="space-y-6">
        <section class="rounded-[22px] border border-[#e6dac8] bg-white p-6 shadow-sm">
            <h2 class="text-lg font-extrabold text-[#171411]">Publication</h2>
            <label class="mt-5 flex items-center gap-3 rounded-xl border border-[#e6dac8] bg-[#fbf7f0] px-4 py-3">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active)) class="rounded border-[#c8b694] text-[#b88a3b] focus:ring-[#b88a3b]">
                <span class="text-sm font-bold text-[#171411]">Publier sur le site</span>
            </label>
        </section>

        <section class="rounded-[22px] border border-[#e6dac8] bg-white p-6 shadow-sm">
            <h2 class="text-lg font-extrabold text-[#171411]">Images</h2>
            @if($product->main_image_url)
                <img src="{{ $product->main_image_url }}" alt="{{ $product->title }}" class="mt-5 aspect-[4/3] w-full rounded-2xl object-cover">
            @endif
            <div class="mt-5 space-y-5">
                <div>
                    <label class="block text-sm font-bold text-[#171411]">Remplacer image principale</label>
                    <input name="main_image_file" type="file" accept="image/*" class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-4 py-3 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-bold text-[#171411]">Ou URL image</label>
                    <input name="main_image_url" type="url" value="{{ old('main_image_url', $product->main_image) }}" class="mt-2 w-full rounded-xl border-[#d8c7af] px-4 py-3 text-sm focus:border-[#b88a3b] focus:ring-0">
                </div>
                <div>
                    <label class="flex items-center gap-2 text-sm font-bold text-[#171411]">
                        <input type="checkbox" name="replace_gallery" value="1" class="rounded border-[#c8b694] text-[#b88a3b] focus:ring-[#b88a3b]">
                        Remplacer la galerie
                    </label>
                </div>
                <div>
                    <label class="block text-sm font-bold text-[#171411]">Ajouter des images galerie</label>
                    <input name="gallery_files[]" type="file" accept="image/*" multiple class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-4 py-3 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-bold text-[#171411]">URLs galerie</label>
                    <textarea name="gallery_urls" rows="4" class="mt-2 w-full rounded-xl border-[#d8c7af] px-4 py-3 text-sm focus:border-[#b88a3b] focus:ring-0">{{ old('gallery_urls', $existingGalleryText) }}</textarea>
                </div>
            </div>
        </section>

        <button type="submit" class="w-full rounded-xl bg-[#171411] px-5 py-4 text-sm font-extrabold text-white transition hover:bg-[#b88a3b]">
            Enregistrer
        </button>
    </aside>
</form>
@endsection
