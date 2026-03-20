<x-app-layout>
    @php
        $selectedCollectionIds = collect(old('collection_ids', $product->collections->pluck('id')->all()));
    @endphp

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Éditer produit — #{{ $product->id }}
            </h2>
            <a href="{{ route('admin.products.index') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition">
                Retour
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 rounded bg-emerald-50 text-emerald-800 p-3">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 rounded bg-red-50 text-red-800 p-3">
                    <div class="font-medium">Veuillez corriger les erreurs suivantes:</div>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST"
                  action="{{ route('admin.products.update', $product) }}"
                  enctype="multipart/form-data"
                  class="bg-white rounded-lg shadow-sm p-6 space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Titre</label>
                        <input required name="title" type="text" value="{{ old('title', $product->title) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Catégorie</label>
                        <select name="category_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">— Aucune —</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" @selected(old('category_id', $product->category_id)==$cat->id)>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Univers</label>
                        <select name="room_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">— Aucun —</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}" @selected(old('room_id', $product->room_id) == $room->id)>{{ $room->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Type de produit</label>
                        <select name="product_type_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">— Aucun —</option>
                            @foreach($productTypes as $type)
                                <option value="{{ $type->id }}" @selected(old('product_type_id', $product->product_type_id) == $type->id)>
                                    {{ $type->name }}@if($type->room) · {{ $type->room->name }} @endif
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Collection principale</label>
                        <select name="primary_collection_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">— Aucune —</option>
                            @foreach($collections as $collection)
                                <option value="{{ $collection->id }}" @selected(old('primary_collection_id', $product->primary_collection_id) == $collection->id)>
                                    {{ $collection->name }}@if($collection->room) · {{ $collection->room->name }} @endif
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Collections associées</label>
                        <select name="collection_ids[]" multiple size="6"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @foreach($collections as $collection)
                                <option value="{{ $collection->id }}" @selected($selectedCollectionIds->contains($collection->id))>
                                    {{ $collection->name }}@if($collection->room) · {{ $collection->room->name }} @endif
                                </option>
                            @endforeach
                        </select>
                        <div class="mt-1 text-xs text-gray-500">Ctrl/Cmd pour sélectionner plusieurs collections.</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Prix (DT)</label>
                        <input required name="price" type="text" value="{{ old('price', (int) floor(($product->price_millimes ?? 0)/1000)) }}"
                               placeholder="Ex: 259 ou 259 DT"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Prix barré (DT)</label>
                        <input name="compare_at" type="text"
                               value="{{ old('compare_at', $product->compare_at_millimes !== null ? (int) floor($product->compare_at_millimes/1000) : '') }}"
                               placeholder="Optionnel"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Stock</label>
                        <input required name="stock" type="number" min="0" step="1" value="{{ old('stock', $product->stock) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">SKU</label>
                        <input name="sku" type="text" value="{{ old('sku', $product->sku) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Marque</label>
                        <input name="brand" type="text" value="{{ old('brand', $product->brand) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Mode de vente</label>
                        <select name="sale_mode"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="catalog" @selected(old('sale_mode', $product->sale_mode ?? 'catalog') === 'catalog')>Catalogue simple</option>
                            <option value="bundle" @selected(old('sale_mode', $product->sale_mode) === 'bundle')>Composition / bundle</option>
                            <option value="configurable" @selected(old('sale_mode', $product->sale_mode) === 'configurable')>Configurable</option>
                            <option value="sur_mesure" @selected(old('sale_mode', $product->sale_mode) === 'sur_mesure')>Sur mesure</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Résumé matières</label>
                        <input name="material_summary" type="text" value="{{ old('material_summary', $product->material_summary) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Résumé dimensions</label>
                        <input name="dimension_summary" type="text" value="{{ old('dimension_summary', $product->dimension_summary) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div class="flex items-center gap-3">
                        <input id="is_active" name="is_active" type="checkbox" value="1" @checked(old('is_active', $product->is_active)) class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <label for="is_active" class="text-sm text-gray-700">Actif</label>
                    </div>

                    <div class="flex items-center gap-3">
                        <input id="quote_only" name="quote_only" type="checkbox" value="1" @checked(old('quote_only', $product->quote_only)) class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <label for="quote_only" class="text-sm text-gray-700">Devis uniquement</label>
                    </div>

                    <div class="flex items-center gap-3">
                        <input id="is_customizable" name="is_customizable" type="checkbox" value="1" @checked(old('is_customizable', $product->is_customizable)) class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <label for="is_customizable" class="text-sm text-gray-700">Personnalisable</label>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Image principale (URL)</label>
                        <input name="main_image_url" type="url" value="{{ old('main_image_url', $product->main_image) }}"
                               placeholder="https://..."
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <div class="mt-2 text-xs text-gray-500">Ou téléversez un fichier ci-dessous</div>
                        <input name="main_image_file" type="file" accept="image/*"
                               class="mt-2 block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">

                        @if($product->main_image)
                            <div class="mt-3">
                                <img src="{{ asset($product->main_image) }}" alt="{{ $product->title }}" class="h-24 w-24 object-cover rounded">
                            </div>
                        @endif
                    </div>

                    <div>
                        <div class="flex items-center justify-between">
                            <label class="block text-sm font-medium text-gray-700">Galerie (URLs, une par ligne)</label>
                            <label class="inline-flex items-center text-sm text-gray-700">
                                <input type="checkbox" name="replace_gallery" value="1" class="mr-2 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                Remplacer entièrement
                            </label>
                        </div>
                        <textarea name="gallery_urls" rows="6"
                                  placeholder="https://...jpg&#10;https://...png"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('gallery_urls', $existingGalleryText) }}</textarea>
                        <div class="mt-2 text-xs text-gray-500">Ou téléversez plusieurs images ci-dessous</div>
                        <input name="gallery_files[]" type="file" accept="image/*" multiple
                               class="mt-2 block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Description courte (HTML)</label>
                    <textarea name="short_description" rows="4"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('short_description', $product->short_description) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Description longue (HTML)</label>
                    <textarea name="long_description" rows="8"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('long_description', $product->long_description) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Attributs (JSON)</label>
                    <textarea name="attributes_json" rows="6" placeholder='{"Couleur":"Chêne","Dimensions":"120x60x45"}'
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('attributes_json', $product->attributes ? json_encode($product->attributes, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT) : '') }}</textarea>
                    <div class="mt-1 text-xs text-gray-500">Collez un objet JSON valide.</div>
                </div>

                <div class="pt-4">
                    <button type="submit"
                            class="inline-flex items-center px-6 py-2.5 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
