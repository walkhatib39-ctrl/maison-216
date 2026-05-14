@extends('layouts.admin')

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-dark-900">Nouveau produit</h1>
            <p class="text-dark-600 mt-1">Ajouter un produit à votre catalogue</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.products.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-dark-100 hover:bg-dark-200 text-dark-700 font-medium rounded-xl transition-colors duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Retour aux produits
            </a>
        </div>
    </div>
</div>

@if ($errors->any())
    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
            </div>
            <div class="font-semibold text-red-800">Veuillez corriger les erreurs suivantes :</div>
        </div>
        <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
    @csrf
    
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        <!-- Formulaire principal -->
        <div class="xl:col-span-2 space-y-8">
            <!-- Informations de base -->
            <div class="bg-white rounded-2xl border border-dark-100 shadow-premium">
                <div class="p-6 border-b border-dark-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-dark-900">Informations de base</h3>
                            <p class="text-sm text-dark-600">Titre, catégorie et détails essentiels</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-dark-700 mb-2">Titre du produit *</label>
                            <input required name="title" type="text" value="{{ old('title') }}"
                                   class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200"
                                   placeholder="Ex: Canapé 3 places moderne en tissu">
                            <p class="text-xs text-dark-500 mt-1">Le nom affiché sur votre site</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-dark-700 mb-2">Catégorie</label>
                            <select name="category_id"
                                    class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200">
                                <option value="">— Aucune catégorie —</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" @selected(old('category_id')==$cat->id)>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-dark-500 mt-1">Classer dans une catégorie</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-dark-700 mb-2">Univers</label>
                            <select name="room_id"
                                    class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200">
                                <option value="">— Aucun univers —</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" @selected(old('room_id') == $room->id)>{{ $room->name }}</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-dark-500 mt-1">Couche stratégique principale</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-dark-700 mb-2">Type de produit</label>
                            <select name="product_type_id"
                                    class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200">
                                <option value="">— Aucun type —</option>
                                @foreach($productTypes as $type)
                                    <option value="{{ $type->id }}" @selected(old('product_type_id') == $type->id)>
                                        {{ $type->name }}@if($type->room) · {{ $type->room->name }} @endif
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-dark-500 mt-1">Ex: lit, commode, dressing</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-dark-700 mb-2">Collection principale</label>
                            <select name="primary_collection_id"
                                    class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200">
                                <option value="">— Aucune collection —</option>
                                @foreach($collections as $collection)
                                    <option value="{{ $collection->id }}" @selected(old('primary_collection_id') == $collection->id)>
                                        {{ $collection->name }}@if($collection->room) · {{ $collection->room->name }} @endif
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-dark-500 mt-1">Collection d’appartenance principale</p>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-dark-700 mb-2">Collections associées</label>
                            <select name="collection_ids[]" multiple size="6"
                                    class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200">
                                @foreach($collections as $collection)
                                    <option value="{{ $collection->id }}" @selected(collect(old('collection_ids', []))->contains($collection->id))>
                                        {{ $collection->name }}@if($collection->room) · {{ $collection->room->name }} @endif
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-dark-500 mt-1">Maintenez Ctrl/Cmd pour sélectionner plusieurs collections.</p>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-dark-700 mb-2">Activités Showroom</label>
                            <select name="showroom_activity_ids[]" multiple size="8"
                                    class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200">
                                @foreach($showroomActivities as $activity)
                                    <option value="{{ $activity->id }}" @selected(collect(old('showroom_activity_ids', []))->contains($activity->id))>
                                        {{ $activity->name }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-dark-500 mt-1">Les pages activité du Showroom affichent uniquement les produits assignés ici.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-dark-700 mb-2">SKU</label>
                            <input name="sku" type="text" value="{{ old('sku') }}"
                                   class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200"
                                   placeholder="Ex: CANAPÉ-3P-001">
                            <p class="text-xs text-dark-500 mt-1">Code produit unique (optionnel)</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-dark-700 mb-2">Marque</label>
                            <input name="brand" type="text" value="{{ old('brand') }}"
                                   class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200"
                                   placeholder="Ex: Design Moderne">
                            <p class="text-xs text-dark-500 mt-1">Fabricant du produit (optionnel)</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-dark-700 mb-2">Mode de vente</label>
                            <select name="sale_mode"
                                    class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200">
                                <option value="catalog" @selected(old('sale_mode', 'catalog') === 'catalog')>Catalogue simple</option>
                                <option value="bundle" @selected(old('sale_mode') === 'bundle')>Composition / bundle</option>
                                <option value="configurable" @selected(old('sale_mode') === 'configurable')>Configurable</option>
                                <option value="sur_mesure" @selected(old('sale_mode') === 'sur_mesure')>Sur mesure</option>
                            </select>
                            <p class="text-xs text-dark-500 mt-1">Prépare le futur tunnel produit</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-dark-700 mb-2">Badge Showroom</label>
                            <input name="showroom_badge" type="text" value="{{ old('showroom_badge') }}"
                                   class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200"
                                   placeholder="Standard, Sur mesure, Premium, Pro">
                            <p class="text-xs text-dark-500 mt-1">Affiché sur les cartes produit</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-dark-700 mb-2">Résumé matières</label>
                            <input name="material_summary" type="text" value="{{ old('material_summary') }}"
                                   class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200"
                                   placeholder="Ex: MDF, chêne clair, métal noir">
                            <p class="text-xs text-dark-500 mt-1">Résumé court pour cartes et filtres</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-dark-700 mb-2">Résumé dimensions</label>
                            <input name="dimension_summary" type="text" value="{{ old('dimension_summary') }}"
                                   class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200"
                                   placeholder="Ex: 160x200 cm">
                            <p class="text-xs text-dark-500 mt-1">Résumé rapide affichable partout</p>
                        </div>

                        <div class="md:col-span-2 grid grid-cols-1 gap-4 lg:grid-cols-4">
                            <div class="flex items-center gap-4 rounded-xl border border-green-200 bg-green-50 p-4">
                                <input id="is_active" name="is_active" type="checkbox" value="1" @checked(old('is_active', true))
                                       class="w-5 h-5 rounded border-green-300 text-green-600 focus:ring-green-500 transition-colors duration-200">
                                <div class="flex-1">
                                    <label for="is_active" class="font-semibold text-green-800">Produit actif</label>
                                    <p class="text-sm text-green-600">Visible sur le site</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-4 rounded-xl border border-amber-200 bg-amber-50 p-4">
                                <input id="quote_only" name="quote_only" type="checkbox" value="1" @checked(old('quote_only'))
                                       class="w-5 h-5 rounded border-amber-300 text-amber-600 focus:ring-amber-500 transition-colors duration-200">
                                <div class="flex-1">
                                    <label for="quote_only" class="font-semibold text-amber-800">Devis uniquement</label>
                                    <p class="text-sm text-amber-600">Pas d’achat direct</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-4 rounded-xl border border-orange-200 bg-orange-50 p-4">
                                <input id="is_starting_price" name="is_starting_price" type="checkbox" value="1" @checked(old('is_starting_price'))
                                       class="w-5 h-5 rounded border-orange-300 text-orange-600 focus:ring-orange-500 transition-colors duration-200">
                                <div class="flex-1">
                                    <label for="is_starting_price" class="font-semibold text-orange-800">À partir de</label>
                                    <p class="text-sm text-orange-600">Préfixe le prix</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-4 rounded-xl border border-blue-200 bg-blue-50 p-4">
                                <input id="is_customizable" name="is_customizable" type="checkbox" value="1" @checked(old('is_customizable'))
                                       class="w-5 h-5 rounded border-blue-300 text-blue-600 focus:ring-blue-500 transition-colors duration-200">
                                <div class="flex-1">
                                    <label for="is_customizable" class="font-semibold text-blue-800">Personnalisable</label>
                                    <p class="text-sm text-blue-600">Entrée future pour builder</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Prix et inventaire -->
            <div class="bg-white rounded-2xl border border-dark-100 shadow-premium">
                <div class="p-6 border-b border-dark-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-dark-900">Prix et inventaire</h3>
                            <p class="text-sm text-dark-600">Tarification et gestion du stock</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-dark-700 mb-2">Prix de vente</label>
                            <div class="relative">
                                <input name="price" type="text" value="{{ old('price') }}"
                                       class="w-full pl-4 pr-12 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200"
                                       placeholder="259">
                                <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-dark-600 font-semibold">
                                    DT
                                </div>
                            </div>
                            <p class="text-xs text-dark-500 mt-1">Obligatoire uniquement pour les produits commandables. Vide = Sur devis.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-dark-700 mb-2">Prix barré</label>
                            <div class="relative">
                                <input name="compare_at" type="text" value="{{ old('compare_at') }}"
                                       class="w-full pl-4 pr-12 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200"
                                       placeholder="399">
                                <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-dark-600 font-semibold">
                                    DT
                                </div>
                            </div>
                            <p class="text-xs text-dark-500 mt-1">Prix de comparaison (promotion)</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-dark-700 mb-2">Stock *</label>
                            <input required name="stock" type="number" min="0" step="1" value="{{ old('stock', 0) }}"
                                   class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200"
                                   placeholder="10">
                            <p class="text-xs text-dark-500 mt-1">Quantité disponible</p>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-dark-700 mb-2">Disponibilité</label>
                            <input name="availability_label" type="text" value="{{ old('availability_label') }}"
                                   class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0"
                                   placeholder="En stock, Sur commande, 2-3 semaines">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-dark-700 mb-2">Livraison</label>
                            <input name="delivery_note" type="text" value="{{ old('delivery_note') }}"
                                   class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0"
                                   placeholder="Livraison Grand Tunis, pose sur devis">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-dark-700 mb-2">Finitions</label>
                            <input name="finish_summary" type="text" value="{{ old('finish_summary') }}"
                                   class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0"
                                   placeholder="RAL au choix, mélaminé, MDF laqué">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Descriptions -->
            <div class="bg-white rounded-2xl border border-dark-100 shadow-premium">
                <div class="p-6 border-b border-dark-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-dark-900">Descriptions</h3>
                            <p class="text-sm text-dark-600">Contenu affiché sur la page produit</p>
                        </div>
                    </div>
                </div>
                <div class="p-6 space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-dark-700 mb-2">Description courte</label>
                        <textarea name="short_description" rows="4"
                                  class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200"
                                  placeholder="Canapé moderne 3 places en tissu beige, parfait pour votre salon...">{{ old('short_description') }}</textarea>
                        <p class="text-xs text-dark-500 mt-1">Résumé affiché sur les listes de produits</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-dark-700 mb-2">Description détaillée</label>
                        <textarea name="long_description" rows="8"
                                  class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200"
                                  placeholder="<h3>Caractéristiques</h3>&#10;<ul>&#10;<li>Tissu haute qualité</li>&#10;<li>Structure en bois massif</li>&#10;</ul>">{{ old('long_description') }}</textarea>
                        <p class="text-xs text-dark-500 mt-1">Description complète avec HTML autorisé</p>
                    </div>
                </div>
            </div>

            <!-- Attributs -->
            <div class="bg-white rounded-2xl border border-dark-100 shadow-premium">
                <div class="p-6 border-b border-dark-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-dark-900">Attributs techniques</h3>
                            <p class="text-sm text-dark-600">Spécifications et caractéristiques</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div>
                        <label class="block text-sm font-semibold text-dark-700 mb-2">Attributs JSON</label>
                        <textarea name="attributes_json" rows="6"
                                  class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200 font-mono text-sm"
                                  placeholder='{"Couleur":"Beige","Dimensions":"190x85x90 cm","Matière":"Tissu polyester","Places":"3","Poids":"45 kg"}'>{{ old('attributes_json') }}</textarea>
                        <div class="mt-2 p-3 bg-amber-50 border border-amber-200 rounded-lg">
                            <div class="text-sm text-amber-800">
                                <strong>Format JSON :</strong> Utilisez des guillemets doubles pour les clés et valeurs.
                                <br><strong>Exemple :</strong> {"Couleur":"Beige","Dimensions":"190x85x90 cm"}
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-semibold text-dark-700 mb-2">Options personnalisables JSON</label>
                        <textarea name="custom_options_json" rows="5"
                                  class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200 font-mono text-sm"
                                  placeholder='{"Dimensions":["120 cm","160 cm"],"Finition":["Noir mat","Chêne clair"]}'>{{ old('custom_options_json') }}</textarea>
                        <p class="text-xs text-dark-500 mt-2">Utilisé pour les produits sur devis ou configurables.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar - Images -->
        <div class="space-y-8">
            <!-- Images -->
            <div class="bg-white rounded-2xl border border-dark-100 shadow-premium">
                <div class="p-6 border-b border-dark-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-dark-900">Images produit</h3>
                            <p class="text-sm text-dark-600">Photo principale et galerie</p>
                        </div>
                    </div>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Image principale -->
                    <div>
                        <h4 class="font-semibold text-dark-900 mb-3">Image principale</h4>
                        
                        <div>
                            <label class="block text-sm font-semibold text-dark-700 mb-2">URL de l'image</label>
                            <input name="main_image_url" type="url" value="{{ old('main_image_url') }}"
                                   class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200"
                                   placeholder="https://exemple.com/image.jpg">
                            <p class="text-xs text-dark-500 mt-1">Ou utilisez le téléversement ci-dessous</p>
                        </div>
                        
                        <div class="mt-4">
                            <label class="block text-sm font-semibold text-dark-700 mb-2">Téléverser une image</label>
                            <div class="border-2 border-dashed border-dark-300 rounded-xl p-6 text-center hover:border-primary-400 transition-colors duration-200">
                                <input name="main_image_file" type="file" accept="image/*" class="hidden" id="mainImageFile">
                                <label for="mainImageFile" class="cursor-pointer">
                                    <svg class="w-8 h-8 text-dark-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                    <div class="text-sm text-dark-600 font-medium">Cliquer pour sélectionner</div>
                                    <div class="text-xs text-dark-500 mt-1">JPG, PNG, WEBP (Max 5MB)</div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Galerie -->
                    <div>
                        <h4 class="font-semibold text-dark-900 mb-3">Galerie d'images</h4>
                        
                        <div>
                            <label class="block text-sm font-semibold text-dark-700 mb-2">URLs (une par ligne)</label>
                            <textarea name="gallery_urls" rows="4"
                                      class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200"
                                      placeholder="https://exemple.com/image1.jpg&#10;https://exemple.com/image2.jpg&#10;https://exemple.com/image3.jpg">{{ old('gallery_urls') }}</textarea>
                            <p class="text-xs text-dark-500 mt-1">Ou utilisez le téléversement ci-dessous</p>
                        </div>
                        
                        <div class="mt-4">
                            <label class="block text-sm font-semibold text-dark-700 mb-2">Téléverser plusieurs images</label>
                            <div class="border-2 border-dashed border-dark-300 rounded-xl p-6 text-center hover:border-primary-400 transition-colors duration-200">
                                <input name="gallery_files[]" type="file" accept="image/*" multiple class="hidden" id="galleryFiles">
                                <label for="galleryFiles" class="cursor-pointer">
                                    <svg class="w-8 h-8 text-dark-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                    <div class="text-sm text-dark-600 font-medium">Sélectionner plusieurs images</div>
                                    <div class="text-xs text-dark-500 mt-1">JPG, PNG, WEBP (Max 5MB chacune)</div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-2xl border border-dark-100 shadow-premium p-6">
                <div class="space-y-4">
                    <button type="submit"
                            class="w-full btn-premium inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-bold rounded-xl transition-all duration-200 shadow-premium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Créer le produit
                    </button>
                    
                    <a href="{{ route('admin.products.index') }}"
                       class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-dark-100 hover:bg-dark-200 text-dark-700 font-semibold rounded-xl transition-colors duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Annuler
                    </a>
                </div>
            </div>

            <!-- Aide -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-2xl p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h4 class="font-semibold text-blue-800">Conseils</h4>
                </div>
                <ul class="text-sm text-blue-700 space-y-2">
                    <li>• Utilisez des photos de qualité pour attirer vos clients</li>
                    <li>• Rédigez des descriptions détaillées et attractives</li>
                    <li>• Définissez des prix cohérents avec votre marché</li>
                    <li>• Les attributs JSON amélioreront la fiche produit</li>
                </ul>
            </div>
        </div>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // File input preview functionality
    function setupFilePreview(inputId, previewContainer) {
        const input = document.getElementById(inputId);
        if (input) {
            input.addEventListener('change', function(e) {
                const files = e.target.files;
                if (files.length > 0) {
                    // Create or update preview
                    let preview = previewContainer.querySelector('.file-preview');
                    if (!preview) {
                        preview = document.createElement('div');
                        preview.className = 'file-preview mt-4 space-y-2';
                        previewContainer.appendChild(preview);
                    }
                    
                    preview.innerHTML = '';
                    
                    Array.from(files).forEach(file => {
                        if (file.type.startsWith('image/')) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const div = document.createElement('div');
                                div.className = 'p-3 bg-primary-50 border border-primary-200 rounded-xl';
                                div.innerHTML = `
                                    <div class="flex items-center gap-3">
                                        <img src="${e.target.result}" alt="Aperçu" class="h-12 w-12 object-cover rounded-lg border border-primary-300">
                                        <div>
                                            <div class="text-sm font-medium text-primary-800">${file.name}</div>
                                            <div class="text-xs text-primary-600">${(file.size / 1024 / 1024).toFixed(2)} MB</div>
                                        </div>
                                    </div>
                                `;
                                preview.appendChild(div);
                            };
                            reader.readAsDataURL(file);
                        }
                    });
                }
            });
        }
    }

    // Setup file previews
    setupFilePreview('mainImageFile', document.querySelector('#mainImageFile').closest('div'));
    setupFilePreview('galleryFiles', document.querySelector('#galleryFiles').closest('div'));
    
    // JSON validation for attributes
    const attributesTextarea = document.querySelector('textarea[name="attributes_json"]');
    if (attributesTextarea) {
        attributesTextarea.addEventListener('blur', function() {
            const value = this.value.trim();
            if (value) {
                try {
                    JSON.parse(value);
                    this.classList.remove('border-red-300');
                    this.classList.add('border-green-300');
                } catch (e) {
                    this.classList.remove('border-green-300');
                    this.classList.add('border-red-300');
                }
            } else {
                this.classList.remove('border-red-300', 'border-green-300');
            }
        });
    }
});
</script>
@endsection
