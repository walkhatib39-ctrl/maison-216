@extends('layouts.admin')

@section('content')
<div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
    <div>
        <h1 class="text-3xl font-extrabold text-[#171411]">Nouveau produit Showroom</h1>
        <p class="mt-1 text-sm font-medium text-[#6a5a4c]">Produit commandable ou solution sur devis, assigne a une activite professionnelle.</p>
    </div>
    <a href="{{ route('admin.products.index') }}" class="inline-flex w-fit items-center justify-center rounded-xl border border-[#d8c7af] bg-white px-4 py-2.5 text-sm font-bold text-[#171411]">
        Retour
    </a>
</div>

@if ($errors->any())
    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm font-semibold text-red-800">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="grid gap-6 xl:grid-cols-[1fr_360px]">
    @csrf

    <div class="space-y-6">
        <section class="rounded-[22px] border border-[#e6dac8] bg-white p-6 shadow-sm">
            <h2 class="text-lg font-extrabold text-[#171411]">Informations produit</h2>
            <div class="mt-6 grid gap-5 md:grid-cols-2">
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-[#171411]">Nom du produit *</label>
                    <input required name="title" value="{{ old('title') }}" class="mt-2 w-full rounded-xl border-[#d8c7af] px-4 py-3 text-sm focus:border-[#b88a3b] focus:ring-0" placeholder="Comptoir parapharmacie compact">
                </div>

                <div>
                    <label class="block text-sm font-bold text-[#171411]">Slug</label>
                    <input name="slug" value="{{ old('slug') }}" class="mt-2 w-full rounded-xl border-[#d8c7af] px-4 py-3 text-sm focus:border-[#b88a3b] focus:ring-0" placeholder="comptoir-parapharmacie-compact">
                </div>

                <div>
                    <label class="block text-sm font-bold text-[#171411]">Type de vente *</label>
                    <select name="sale_mode" required class="mt-2 w-full rounded-xl border-[#d8c7af] px-4 py-3 text-sm focus:border-[#b88a3b] focus:ring-0">
                        <option value="catalog" @selected(old('sale_mode', 'catalog') === 'catalog')>Produit commandable</option>
                        <option value="sur_mesure" @selected(old('sale_mode') === 'sur_mesure')>Produit sur devis</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-[#171411]">Badge</label>
                    <input name="showroom_badge" value="{{ old('showroom_badge') }}" class="mt-2 w-full rounded-xl border-[#d8c7af] px-4 py-3 text-sm focus:border-[#b88a3b] focus:ring-0" placeholder="Standard, Sur mesure, Premium, Pro">
                </div>

                <div>
                    <label class="block text-sm font-bold text-[#171411]">Disponibilite / stock *</label>
                    <input required name="stock" type="number" min="0" step="1" value="{{ old('stock', 0) }}" class="mt-2 w-full rounded-xl border-[#d8c7af] px-4 py-3 text-sm focus:border-[#b88a3b] focus:ring-0">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-[#171411]">Activites concernees</label>
                    <select name="showroom_activity_ids[]" multiple size="8" class="mt-2 w-full rounded-xl border-[#d8c7af] px-4 py-3 text-sm focus:border-[#b88a3b] focus:ring-0">
                        @foreach($showroomActivities as $activity)
                            <option value="{{ $activity->id }}" @selected(collect(old('showroom_activity_ids', []))->contains($activity->id))>{{ $activity->name }}</option>
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
                    <input name="price" value="{{ old('price') }}" class="mt-2 w-full rounded-xl border-[#d8c7af] px-4 py-3 text-sm focus:border-[#b88a3b] focus:ring-0" placeholder="1250">
                    <p class="mt-2 text-xs font-semibold text-[#7a6b5a]">Obligatoire si commandable. Vide = sur devis.</p>
                </div>
                <div>
                    <label class="block text-sm font-bold text-[#171411]">Prix promotionnel</label>
                    <input name="compare_at" value="{{ old('compare_at') }}" class="mt-2 w-full rounded-xl border-[#d8c7af] px-4 py-3 text-sm focus:border-[#b88a3b] focus:ring-0" placeholder="1490">
                </div>
                <label class="flex items-center gap-3 rounded-xl border border-[#e6dac8] bg-[#fbf7f0] px-4 py-3">
                    <input type="checkbox" name="is_starting_price" value="1" @checked(old('is_starting_price')) class="rounded border-[#c8b694] text-[#b88a3b] focus:ring-[#b88a3b]">
                    <span class="text-sm font-bold text-[#171411]">Afficher “A partir de”</span>
                </label>
                <div>
                    <label class="block text-sm font-bold text-[#171411]">Disponibilite</label>
                    <input name="availability_label" value="{{ old('availability_label') }}" class="mt-2 w-full rounded-xl border-[#d8c7af] px-4 py-3 text-sm focus:border-[#b88a3b] focus:ring-0" placeholder="En stock, sur commande">
                </div>
                <div>
                    <label class="block text-sm font-bold text-[#171411]">Livraison</label>
                    <input name="delivery_note" value="{{ old('delivery_note') }}" class="mt-2 w-full rounded-xl border-[#d8c7af] px-4 py-3 text-sm focus:border-[#b88a3b] focus:ring-0" placeholder="Grand Tunis, pose sur devis">
                </div>
            </div>
        </section>

        <section class="rounded-[22px] border border-[#e6dac8] bg-white p-6 shadow-sm">
            <h2 class="text-lg font-extrabold text-[#171411]">Contenu et specifications</h2>
            <div class="mt-6 grid gap-5 md:grid-cols-2">
                <div>
                    <label class="block text-sm font-bold text-[#171411]">Materiaux</label>
                    <input name="material_summary" value="{{ old('material_summary') }}" class="mt-2 w-full rounded-xl border-[#d8c7af] px-4 py-3 text-sm focus:border-[#b88a3b] focus:ring-0" placeholder="MDF, metal, aluminium">
                </div>
                <div>
                    <label class="block text-sm font-bold text-[#171411]">Dimensions</label>
                    <input name="dimension_summary" value="{{ old('dimension_summary') }}" class="mt-2 w-full rounded-xl border-[#d8c7af] px-4 py-3 text-sm focus:border-[#b88a3b] focus:ring-0" placeholder="120 x 60 x 110 cm">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-[#171411]">Finitions</label>
                    <input name="finish_summary" value="{{ old('finish_summary') }}" class="mt-2 w-full rounded-xl border-[#d8c7af] px-4 py-3 text-sm focus:border-[#b88a3b] focus:ring-0" placeholder="RAL au choix, chene clair, noir mat">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-[#171411]">Description courte</label>
                    <textarea name="short_description" rows="3" class="mt-2 w-full rounded-xl border-[#d8c7af] px-4 py-3 text-sm focus:border-[#b88a3b] focus:ring-0">{{ old('short_description') }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-[#171411]">Description longue</label>
                    <textarea name="long_description" rows="8" class="mt-2 w-full rounded-xl border-[#d8c7af] px-4 py-3 text-sm focus:border-[#b88a3b] focus:ring-0">{{ old('long_description') }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-[#171411]">Options personnalisables JSON</label>
                    <textarea name="custom_options_json" rows="5" class="mt-2 w-full rounded-xl border-[#d8c7af] px-4 py-3 font-mono text-sm focus:border-[#b88a3b] focus:ring-0" placeholder='{"Dimensions":["120 cm","160 cm"],"Finition":["Noir mat","Chene clair"]}'>{{ old('custom_options_json') }}</textarea>
                </div>
            </div>
        </section>
    </div>

    <aside class="space-y-6">
        <section class="rounded-[22px] border border-[#e6dac8] bg-white p-6 shadow-sm">
            <h2 class="text-lg font-extrabold text-[#171411]">Publication</h2>
            <label class="mt-5 flex items-center gap-3 rounded-xl border border-[#e6dac8] bg-[#fbf7f0] px-4 py-3">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', true)) class="rounded border-[#c8b694] text-[#b88a3b] focus:ring-[#b88a3b]">
                <span class="text-sm font-bold text-[#171411]">Publier sur le site</span>
            </label>
        </section>

        <section class="rounded-[22px] border border-[#e6dac8] bg-white p-6 shadow-sm">
            <h2 class="text-lg font-extrabold text-[#171411]">Images</h2>
            <div class="mt-5 space-y-5">
                <div id="product-main-image-preview" class="hidden overflow-hidden rounded-2xl border border-[#eadfce] bg-[#fbf7f0]"></div>
                <div>
                    <label class="block text-sm font-bold text-[#171411]">Image principale</label>
                    <input name="main_image_file" type="file" accept="image/*" class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-4 py-3 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-bold text-[#171411]">Image depuis la mediatheque ou URL</label>
                    <input id="product-main-image" name="main_image_url" type="text" value="{{ old('main_image_url') }}" class="mt-2 w-full rounded-xl border-[#d8c7af] px-4 py-3 text-sm focus:border-[#b88a3b] focus:ring-0" placeholder="uploads/... ou https://...">
                    <button type="button" data-media-picker data-media-target="#product-main-image" data-media-preview="#product-main-image-preview" class="mt-3 inline-flex w-full items-center justify-center rounded-xl border border-[#d8c7af] bg-[#fbf7f0] px-4 py-2.5 text-sm font-extrabold text-[#171411] transition hover:bg-white">
                        Choisir depuis la mediatheque
                    </button>
                </div>
                <div>
                    <label class="block text-sm font-bold text-[#171411]">Galerie</label>
                    <input name="gallery_files[]" type="file" accept="image/*" multiple class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-4 py-3 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-bold text-[#171411]">Images galerie depuis la mediatheque ou URLs</label>
                    <textarea id="product-gallery-images" name="gallery_urls" rows="4" class="mt-2 w-full rounded-xl border-[#d8c7af] px-4 py-3 text-sm focus:border-[#b88a3b] focus:ring-0" placeholder="Un chemin ou une URL par ligne">{{ old('gallery_urls') }}</textarea>
                    <button type="button" data-media-picker data-media-target="#product-gallery-images" data-media-mode="append" class="mt-3 inline-flex w-full items-center justify-center rounded-xl border border-[#d8c7af] bg-[#fbf7f0] px-4 py-2.5 text-sm font-extrabold text-[#171411] transition hover:bg-white">
                        Ajouter depuis la mediatheque
                    </button>
                </div>
            </div>
        </section>

        <button type="submit" class="w-full rounded-xl bg-[#171411] px-5 py-4 text-sm font-extrabold text-white transition hover:bg-[#b88a3b]">
            Creer le produit
        </button>
    </aside>
</form>
@endsection
