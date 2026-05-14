@extends('layouts.admin')

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-dark-900">Showroom produits</h1>
            <p class="text-dark-600 mt-1">{{ $products->total() }} produit{{ $products->total() > 1 ? 's' : '' }} publiable{{ $products->total() > 1 ? 's' : '' }} dans le Showroom</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.products.import') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white font-medium rounded-xl transition-colors duration-200 shadow-lg">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                </svg>
                Import JSON
            </a>
            <a href="{{ route('admin.products.create') }}"
               class="btn-premium inline-flex items-center gap-2 px-6 py-2 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-bold rounded-xl transition-all duration-200 shadow-premium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Nouveau produit
            </a>
        </div>
    </div>
</div>

@if(session('status'))
    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <p class="text-green-800 font-medium">{{ session('status') }}</p>
        </div>
    </div>
@endif

<!-- Advanced Filters -->
<div class="bg-white rounded-2xl border border-dark-100 shadow-premium mb-8">
    <div class="p-6 border-b border-dark-100">
        <h3 class="text-lg font-bold text-dark-900 flex items-center gap-2">
            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"/>
            </svg>
            Filtres avancés
        </h3>
    </div>
    <form method="GET" class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
            <div>
                <label class="block text-sm font-semibold text-dark-700 mb-2">Recherche</label>
                <div class="relative">
                    <input type="text" name="q" value="{{ $filters['q'] ?? '' }}"
                           class="w-full pl-10 pr-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200"
                           placeholder="Titre ou description...">
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-dark-700 mb-2">Activité Showroom</label>
                <select name="showroom_activity_id"
                        class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200">
                    <option value="">Toutes les activités</option>
                    @foreach($showroomActivities as $activity)
                        <option value="{{ $activity->id }}" @selected(($filters['showroom_activity_id'] ?? '') == $activity->id)>
                            {{ $activity->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-dark-700 mb-2">Type de vente</label>
                <select name="sale_type"
                        class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200">
                    <option value="">Tous</option>
                    <option value="commandable" @selected(($filters['sale_type'] ?? '') === 'commandable')>Produit commandable</option>
                    <option value="sur-devis" @selected(($filters['sale_type'] ?? '') === 'sur-devis')>Produit sur devis</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-dark-700 mb-2">Statut</label>
                <select name="active"
                        class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200">
                    <option value="">Tous les statuts</option>
                    <option value="1" @selected(($filters['active'] ?? '')==='1')>✅ Actif</option>
                    <option value="0" @selected(($filters['active'] ?? '')==='0')>❌ Inactif</option>
                </select>
            </div>
        </div>
        <div class="mt-6 flex flex-wrap items-center gap-3">
            <button type="submit"
                    class="btn-premium inline-flex items-center gap-2 px-6 py-3 bg-dark-800 hover:bg-dark-900 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"/>
                </svg>
                Appliquer les filtres
            </button>
            <a href="{{ route('admin.products.index') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-dark-100 hover:bg-dark-200 text-dark-700 font-semibold rounded-xl transition-colors duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Réinitialiser
            </a>
            
            @if($filters['q'] || $filters['showroom_activity_id'] || $filters['sale_type'] || $filters['active'] !== '')
                <div class="ml-auto flex items-center gap-2 text-sm text-dark-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                    Filtres actifs
                </div>
            @endif
        </div>
    </form>
</div>

<!-- Products Table -->
<div class="bg-white rounded-2xl border border-dark-100 shadow-premium overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gradient-to-r from-dark-50 to-dark-100 border-b border-dark-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-dark-700 uppercase tracking-wider">#</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-dark-700 uppercase tracking-wider">Produit</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-dark-700 uppercase tracking-wider">Activités</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-dark-700 uppercase tracking-wider">Prix</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-dark-700 uppercase tracking-wider">Stock</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-dark-700 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-dark-700 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-dark-100">
                @forelse($products as $p)
                    <tr class="hover:bg-dark-50 transition-colors duration-200 group">
                        <td class="px-6 py-6">
                            <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold text-sm">#{{ $p->id }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    @if($p->main_image_url)
                                        <img src="{{ $p->main_image_url }}" alt="{{ $p->title }}"
                                             class="h-16 w-16 object-cover rounded-xl border-2 border-dark-200 group-hover:border-primary-300 transition-colors duration-200">
                                    @else
                                        <div class="h-16 w-16 bg-gradient-to-br from-dark-100 to-dark-200 rounded-xl border-2 border-dark-200 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    @if($p->images_count > 1)
                                        <div class="absolute -top-2 -right-2 w-6 h-6 bg-primary-600 text-white text-xs font-bold rounded-full flex items-center justify-center">
                                            {{ $p->images_count }}
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="font-bold text-dark-900 text-lg truncate">{{ $p->title }}</div>
                                    <div class="mt-2 flex flex-wrap gap-2 text-xs">
                                        <span class="rounded-full bg-dark-100 px-2 py-1 font-medium text-dark-700">{{ $p->isDirectlyOrderable() ? 'commandable' : 'sur devis' }}</span>
                                        @if($p->isQuoteOnly())
                                            <span class="rounded-full bg-red-100 px-2 py-1 font-medium text-red-700">devis</span>
                                        @endif
                                        @foreach($p->showroomActivities->take(2) as $activity)
                                            <span class="rounded-full bg-emerald-100 px-2 py-1 font-medium text-emerald-700">{{ $activity->name }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            @if($p->showroomActivities->isNotEmpty())
                                <div class="flex flex-wrap gap-2">
                                    @foreach($p->showroomActivities as $activity)
                                        <span class="inline-flex rounded-full bg-emerald-100 px-3 py-2 text-xs font-bold text-emerald-800">{{ $activity->name }}</span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-dark-400 text-sm">Non assigné</span>
                            @endif
                        </td>
                        <td class="px-6 py-6">
                            <div class="text-2xl font-bold text-primary-600">
                                {{ $p->showroom_price_label }}
                            </div>
                            @if(!$p->isQuoteOnly() && $p->price_millimes && $p->compare_at_millimes && $p->compare_at_millimes > $p->price_millimes)
                                <div class="text-sm text-dark-400 line-through">
                                    {{ (int) floor($p->compare_at_millimes/1000) }} DT
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-6">
                            <div class="flex items-center gap-2">
                                @if($p->isQuoteOnly())
                                    <div class="w-3 h-3 bg-amber-500 rounded-full"></div>
                                    <span class="font-semibold text-amber-700">Sur devis</span>
                                @elseif($p->stock > 0)
                                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                    <span class="font-semibold text-dark-900">{{ $p->stock }}</span>
                                    <span class="text-sm text-dark-600">en stock</span>
                                @else
                                    <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                    <span class="font-semibold text-red-600">Rupture</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            @if($p->is_active)
                                <div class="inline-flex items-center gap-2 bg-green-100 text-green-800 px-3 py-2 rounded-lg font-semibold">
                                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                    Actif
                                </div>
                            @else
                                <div class="inline-flex items-center gap-2 bg-red-100 text-red-800 px-3 py-2 rounded-lg font-semibold">
                                    <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                                    Inactif
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-6">
                            <div class="flex items-center justify-end gap-2">
                                <!-- Toggle Status -->
                                <form action="{{ route('admin.products.toggle', $p) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" title="{{ $p->is_active ? 'Désactiver' : 'Activer' }}"
                                            class="interactive p-2 {{ $p->is_active ? 'bg-gray-100 hover:bg-gray-200 text-gray-600' : 'bg-green-100 hover:bg-green-200 text-green-600' }} rounded-lg transition-colors duration-200">
                                        @if($p->is_active)
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18 12M6 6l12 12"/>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        @endif
                                    </button>
                                </form>

                                <!-- View Product -->
                                <a href="{{ route('showroom.product.show', $p->slug) }}" target="_blank" title="Voir sur le site"
                                   class="interactive p-2 bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                </a>

                                <!-- Edit Product -->
                                <a href="{{ route('admin.products.edit', $p) }}" title="Modifier"
                                   class="interactive p-2 bg-primary-100 hover:bg-primary-200 text-primary-600 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>

                                <!-- Delete Product -->
                                <form action="{{ route('admin.products.destroy', $p) }}" method="POST" class="inline-block"
                                      onsubmit="return confirm('⚠️ Êtes-vous sûr de vouloir supprimer ce produit ?\n\n📦 Produit: {{ $p->title }}\n🗑️ Cette action est irréversible.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Supprimer"
                                            class="interactive p-2 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12">
                            <div class="text-center">
                                <div class="w-20 h-20 bg-dark-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-10 h-10 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-dark-700 mb-2">Aucun produit trouvé</h3>
                                <p class="text-dark-500 mb-6">
                                    @if($filters['q'] || $filters['showroom_activity_id'] || $filters['sale_type'] || $filters['active'] !== '')
                                        Aucun produit ne correspond à vos critères de recherche.
                                    @else
                                        Commencez par ajouter votre premier produit.
                                    @endif
                                </p>
                                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                                    @if($filters['q'] || $filters['showroom_activity_id'] || $filters['sale_type'] || $filters['active'] !== '')
                                        <a href="{{ route('admin.products.index') }}" 
                                           class="inline-flex items-center gap-2 px-6 py-3 bg-dark-100 hover:bg-dark-200 text-dark-700 font-semibold rounded-xl transition-colors duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                            </svg>
                                            Réinitialiser les filtres
                                        </a>
                                    @endif
                                    <a href="{{ route('admin.products.create') }}" 
                                       class="btn-premium inline-flex items-center gap-2 px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition-colors duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        Ajouter un produit
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
        <div class="px-6 py-4 border-t border-dark-100 bg-dark-50">
            <div class="flex items-center justify-between">
                <div class="text-sm text-dark-600">
                    Affichage de {{ $products->firstItem() }} à {{ $products->lastItem() }} sur {{ $products->total() }} produits
                </div>
                <div class="flex items-center gap-2">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Quick Actions Summary -->
<div class="mt-8 bg-white rounded-2xl border border-dark-100 shadow-premium p-6">
    <h3 class="text-lg font-bold text-dark-900 mb-4">Actions rapides</h3>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-4 text-center">
            <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-2">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
            </div>
            <h4 class="font-semibold text-dark-900 mb-1">Nouveau produit</h4>
            <p class="text-sm text-dark-600 mb-3">Ajouter un produit manuellement</p>
            <a href="{{ route('admin.products.create') }}" 
               class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium text-sm">
                Créer →
            </a>
        </div>
        
        <div class="bg-gradient-to-br from-amber-50 to-amber-100 border border-amber-200 rounded-xl p-4 text-center">
            <div class="w-10 h-10 bg-amber-600 rounded-full flex items-center justify-center mx-auto mb-2">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                </svg>
            </div>
            <h4 class="font-semibold text-dark-900 mb-1">Import JSON</h4>
            <p class="text-sm text-dark-600 mb-3">Importer plusieurs produits</p>
            <a href="{{ route('admin.products.import') }}" 
               class="inline-flex items-center text-amber-600 hover:text-amber-700 font-medium text-sm">
                Importer →
            </a>
        </div>
        
        <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-xl p-4 text-center">
            <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-2">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2-2V7a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 002 2h2a2 2 0 012-2V7a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 00-2 2h-2a2 2 0 00-2 2v6"/>
                </svg>
            </div>
            <h4 class="font-semibold text-dark-900 mb-1">Voir le Showroom</h4>
            <p class="text-sm text-dark-600 mb-3">Controler le rendu public</p>
            <a href="{{ route('showroom.index') }}" target="_blank"
               class="inline-flex items-center text-green-600 hover:text-green-700 font-medium text-sm">
                Ouvrir →
            </a>
        </div>
    </div>
</div>
@endsection
