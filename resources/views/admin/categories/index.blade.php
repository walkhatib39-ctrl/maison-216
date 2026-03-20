@extends('layouts.admin')

@php
    $kindOptions = [
        'catalog' => 'Catalogue',
        'room' => 'Landing univers',
        'product_family' => 'Famille produit',
        'bundle' => 'Composition / bundle',
        'collection_landing' => 'Landing collection',
        'service' => 'Service',
    ];

    $emptyCategory = [
        'id' => null,
        'name' => '',
        'parent_id' => '',
        'icon' => '',
        'featured_image' => '',
        'room_id' => '',
        'product_type_id' => '',
        'category_kind' => 'catalog',
        'landing_intro' => '',
        'landing_outro' => '',
        'is_indexable' => true,
    ];

    $serializeCategory = function ($category) {
        return [
            'id' => $category->id,
            'name' => $category->name,
            'parent_id' => $category->parent_id ? (string) $category->parent_id : '',
            'icon' => $category->icon ?? '',
            'featured_image' => $category->featured_image ? asset($category->featured_image) : '',
            'room_id' => $category->room_id ? (string) $category->room_id : '',
            'product_type_id' => $category->product_type_id ? (string) $category->product_type_id : '',
            'category_kind' => $category->category_kind ?? 'catalog',
            'landing_intro' => $category->landing_intro ?? '',
            'landing_outro' => $category->landing_outro ?? '',
            'is_indexable' => (bool) ($category->is_indexable ?? true),
        ];
    };
@endphp

@section('content')
<div x-data="{ 
    isModalOpen: false, 
    mode: 'create', 
    category: @js($emptyCategory),
    deleteUrl: '',
    isDeleteModalOpen: false, 
    selectedItems: [],
    isBulk: false,
    removeFeaturedImage: false,

    resetCategory() {
        this.category = { ...@js($emptyCategory) };
    },
    
    toggleSelection(id) {
        if (this.selectedItems.includes(id)) {
            this.selectedItems = this.selectedItems.filter(item => item !== id);
        } else {
            this.selectedItems.push(id);
        }
    },
    toggleAll() {
        const allCheckboxes = document.querySelectorAll('.category-checkbox');
        const allIds = Array.from(allCheckboxes).map(cb => parseInt(cb.value));
        
        if (this.selectedItems.length === allIds.length) {
            this.selectedItems = [];
        } else {
            this.selectedItems = allIds;
        }
    },
    openCreate() {
        this.mode = 'create';
        this.resetCategory();
        this.removeFeaturedImage = false;
        this.isModalOpen = true;
    },
    openEdit(cat) {
        this.mode = 'edit';
        this.category = { ...@js($emptyCategory), ...cat };
        this.removeFeaturedImage = false;
        this.isModalOpen = true;
    },
    openDelete(url) {
        this.isBulk = false;
        this.deleteUrl = url;
        this.isDeleteModalOpen = true;
    },
    openBulkDelete() {
        this.isBulk = true;
        this.deleteUrl = '{{ route("admin.categories.bulk-destroy") }}';
        this.isDeleteModalOpen = true;
    }
}">

    <!-- Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-dark-900">Catégories</h1>
            <p class="text-dark-600 mt-1">Gérez l'arborescence de votre catalogue</p>
        </div>
        <button @click="openCreate()" class="btn-premium bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-xl flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Ajouter une catégorie
        </button>
    </div>

    <!-- Feedback Messages -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 text-green-700 p-4 rounded-xl border border-green-200 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 bg-red-50 text-red-700 p-4 rounded-xl border border-red-200 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('error') }}
        </div>
    @endif

    @if(!$architectureEnabled)
        <div class="mb-6 rounded-2xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800">
            Les tables de la nouvelle architecture catalogue ne sont pas encore migrées. Lancez `php artisan migrate` puis `php artisan maison216:sync-catalog-architecture`.
        </div>
    @endif

    <!-- Bulk Actions -->
    <div x-show="selectedItems.length > 0" x-transition class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4 flex justify-between items-center">
        <span class="text-blue-700 font-medium">
            <span x-text="selectedItems.length"></span> éléments sélectionnés
        </span>
        <button @click="openBulkDelete()" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 text-sm font-medium transition-colors">
            Supprimer la sélection
        </button>
    </div>

    <!-- Category Tree Table -->
    <div class="bg-white rounded-2xl shadow-premium border border-dark-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-dark-50 text-dark-600 font-semibold text-sm border-b border-dark-100">
                <tr>
                    <th class="py-4 px-6 w-12">
                        <input type="checkbox" @click="toggleAll()" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500 w-4 h-4">
                    </th>
                    <th class="py-4 px-6">Nom de la catégorie</th>
                    <th class="py-4 px-6">Image</th>
                    <th class="py-4 px-6">Architecture</th>
                    <th class="py-4 px-6">Slug</th>
                    <th class="py-4 px-6 text-center">Produits</th>
                    <th class="py-4 px-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-dark-100">
                @foreach($rootCategories as $root)
                    <!-- Level 0 -->
                    <tr class="hover:bg-gray-50 group transition-colors">
                        <td class="py-3 px-6">
                            <input type="checkbox" value="{{ $root->id }}" @click="toggleSelection({{ $root->id }})" :checked="selectedItems.includes({{ $root->id }})" class="category-checkbox rounded border-gray-300 text-primary-600 focus:ring-primary-500 w-4 h-4">
                        </td>
                        <td class="py-3 px-6">
                            <div class="flex items-center gap-2">
                                <span class="p-1 bg-dark-100 rounded text-dark-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                                </span>
                                <div>
                                    <div class="font-bold text-dark-900">{{ $root->name }}</div>
                                    <div class="mt-1 flex flex-wrap gap-2 text-xs">
                                        <span class="rounded-full bg-slate-100 px-2 py-1 font-medium text-slate-700">{{ $kindOptions[$root->category_kind ?? 'catalog'] ?? ($root->category_kind ?? 'catalog') }}</span>
                                        @if($root->room)
                                            <span class="rounded-full bg-blue-100 px-2 py-1 font-medium text-blue-800">{{ $root->room->name }}</span>
                                        @endif
                                        @if($root->productType)
                                            <span class="rounded-full bg-violet-100 px-2 py-1 font-medium text-violet-800">{{ $root->productType->name }}</span>
                                        @endif
                                        @unless($root->is_indexable)
                                            <span class="rounded-full bg-amber-100 px-2 py-1 font-medium text-amber-800">Noindex</span>
                                        @endunless
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-6">
                            @if($root->featured_image)
                                <img src="{{ asset($root->featured_image) }}" alt="" class="h-10 w-10 rounded-xl object-cover border border-dark-100">
                            @else
                                <div class="h-10 w-10 rounded-xl bg-dark-50 border border-dark-100 flex items-center justify-center text-xs text-dark-400">—</div>
                            @endif
                        </td>
                        <td class="py-3 px-6 text-sm text-dark-500">
                            <div>{{ $root->room?->slug ?? '—' }}</div>
                            <div class="text-xs text-dark-400">{{ $root->productType?->slug ?? '—' }}</div>
                        </td>
                        <td class="py-3 px-6 text-sm text-dark-500 font-mono">{{ $root->slug }}</td>
                        <td class="py-3 px-6 text-center">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $root->total_products_count }}
                            </span>
                        </td>
                        <td class="py-3 px-6 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('category.show', $root->slug) }}" target="_blank" class="text-dark-400 hover:text-primary-600" title="Voir sur le site">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <button @click='openEdit(@json($serializeCategory($root)))' class="text-blue-600 hover:text-blue-800 font-medium text-sm">Modifier</button>
                                <button @click="openDelete('{{ route('admin.categories.destroy', $root) }}')" class="text-red-500 hover:text-red-700 text-sm">Supprimer</button>
                            </div>
                        </td>
                    </tr>

                    <!-- Level 1 -->
                    @foreach($root->children as $child)
                        <tr class="hover:bg-gray-50 group transition-colors">
                            <td class="py-3 px-6 pl-12">
                                <input type="checkbox" value="{{ $child->id }}" @click="toggleSelection({{ $child->id }})" :checked="selectedItems.includes({{ $child->id }})" class="category-checkbox rounded border-gray-300 text-primary-600 focus:ring-primary-500 w-4 h-4 mr-2">
                            </td>
                            <td class="py-3 px-6 pl-0">
                                <div class="flex items-center gap-2 relative">
                                    <!-- Connector line visual (optional, simplified here) -->
                                    <span class="text-dark-300">↳</span>
                                    <div>
                                        <div class="font-medium text-dark-800">{{ $child->name }}</div>
                                        <div class="mt-1 flex flex-wrap gap-2 text-xs">
                                            <span class="rounded-full bg-slate-100 px-2 py-1 font-medium text-slate-700">{{ $kindOptions[$child->category_kind ?? 'catalog'] ?? ($child->category_kind ?? 'catalog') }}</span>
                                            @if($child->room)
                                                <span class="rounded-full bg-blue-100 px-2 py-1 font-medium text-blue-800">{{ $child->room->name }}</span>
                                            @endif
                                            @if($child->productType)
                                                <span class="rounded-full bg-violet-100 px-2 py-1 font-medium text-violet-800">{{ $child->productType->name }}</span>
                                            @endif
                                            @unless($child->is_indexable)
                                                <span class="rounded-full bg-amber-100 px-2 py-1 font-medium text-amber-800">Noindex</span>
                                            @endunless
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-6">
                                @if($child->featured_image)
                                    <img src="{{ asset($child->featured_image) }}" alt="" class="h-9 w-9 rounded-lg object-cover border border-dark-100">
                                @else
                                    <div class="h-9 w-9 rounded-lg bg-dark-50 border border-dark-100 flex items-center justify-center text-xs text-dark-400">—</div>
                                @endif
                            </td>
                            <td class="py-3 px-6 text-sm text-dark-500">
                                <div>{{ $child->room?->slug ?? '—' }}</div>
                                <div class="text-xs text-dark-400">{{ $child->productType?->slug ?? '—' }}</div>
                            </td>
                            <td class="py-3 px-6 text-sm text-dark-500 font-mono">{{ $child->slug }}</td>
                            <td class="py-3 px-6 text-center">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                    {{ $child->total_products_count }}
                                </span>
                            </td>
                            <td class="py-3 px-6 text-right">
                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('category.show', $child->slug) }}" target="_blank" class="text-dark-400 hover:text-primary-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <button @click='openEdit(@json($serializeCategory($child)))' class="text-blue-600 hover:text-blue-800 text-sm">Modifier</button>
                                    <button @click="openDelete('{{ route('admin.categories.destroy', $child) }}')" class="text-red-500 hover:text-red-700 text-sm">Supprimer</button>
                                </div>
                            </td>
                        </tr>

                        <!-- Level 2 -->
                        @foreach($child->children as $subChild)
                            <tr class="hover:bg-gray-50 group transition-colors text-sm">
                                <td class="py-2 px-6 pl-20 border-l border-dashed border-gray-200 ml-6">
                                    <input type="checkbox" value="{{ $subChild->id }}" @click="toggleSelection({{ $subChild->id }})" :checked="selectedItems.includes({{ $subChild->id }})" class="category-checkbox rounded border-gray-300 text-primary-600 focus:ring-primary-500 w-4 h-4 mr-2">
                                </td>
                                <td class="py-2 px-6 pl-0">
                                    <div class="flex items-center gap-2">
                                        <span class="text-dark-300">•</span>
                                        <div>
                                            <div class="text-dark-600">{{ $subChild->name }}</div>
                                            <div class="mt-1 flex flex-wrap gap-2 text-[11px]">
                                                <span class="rounded-full bg-slate-100 px-2 py-1 font-medium text-slate-700">{{ $kindOptions[$subChild->category_kind ?? 'catalog'] ?? ($subChild->category_kind ?? 'catalog') }}</span>
                                                @if($subChild->room)
                                                    <span class="rounded-full bg-blue-100 px-2 py-1 font-medium text-blue-800">{{ $subChild->room->name }}</span>
                                                @endif
                                                @if($subChild->productType)
                                                    <span class="rounded-full bg-violet-100 px-2 py-1 font-medium text-violet-800">{{ $subChild->productType->name }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-2 px-6">
                                    @if($subChild->featured_image)
                                        <img src="{{ asset($subChild->featured_image) }}" alt="" class="h-8 w-8 rounded-lg object-cover border border-dark-100">
                                    @else
                                        <div class="h-8 w-8 rounded-lg bg-dark-50 border border-dark-100 flex items-center justify-center text-[10px] text-dark-400">—</div>
                                    @endif
                                </td>
                                <td class="py-2 px-6 text-xs text-dark-400">
                                    <div>{{ $subChild->room?->slug ?? '—' }}</div>
                                    <div>{{ $subChild->productType?->slug ?? '—' }}</div>
                                </td>
                                <td class="py-2 px-6 text-xs text-dark-400 font-mono">{{ $subChild->slug }}</td>
                                <td class="py-2 px-6 text-center">
                                    <span class="text-xs text-gray-500">{{ $subChild->total_products_count }}</span>
                                </td>
                                <td class="py-2 px-6 text-right">
                                    <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('category.show', $subChild->slug) }}" target="_blank" class="text-dark-400 hover:text-primary-600">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                        <button @click='openEdit(@json($serializeCategory($subChild)))' class="text-blue-600 hover:text-blue-800 text-xs">Modif.</button>
                                        <button @click="openDelete('{{ route('admin.categories.destroy', $subChild) }}')" class="text-red-500 hover:text-red-700 text-xs">Suppr.</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal Form (AlpineJS) -->
    <div x-show="isModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Overlay -->
            <div x-show="isModalOpen" @click="isModalOpen = false" x-transition.opacity class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal Content -->
            <div x-show="isModalOpen" x-transition.scale class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl w-full">
                <form :action="mode === 'create' ? '{{ route('admin.categories.store') }}' : '/admin/categories/' + category.id" method="POST" enctype="multipart/form-data">
                    @csrf
                    <template x-if="mode === 'edit'">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="mb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" x-text="mode === 'create' ? 'Nouvelle catégorie' : 'Modifier catégorie'"></h3>
                            <p class="mt-1 text-sm text-gray-500">Arborescence, SEO et rattachement à la nouvelle architecture catalogue.</p>
                        </div>

                        <div class="grid gap-6 lg:grid-cols-2">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nom</label>
                                    <input type="text" name="name" x-model="category.name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Catégorie Parente</label>
                                    <select name="parent_id" x-model="category.parent_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                                        <option value="">-- Aucune (Racine) --</option>
                                        @foreach($allCategories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Icône (SVG ou Classe)</label>
                                    <input type="text" name="icon" x-model="category.icon" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50" placeholder="ex: fas fa-home">
                                </div>

                                @if($architectureEnabled)
                                    <div class="grid gap-4 sm:grid-cols-2">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Univers</label>
                                            <select name="room_id" x-model="category.room_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                                                <option value="">-- Aucun --</option>
                                                @foreach($rooms as $room)
                                                    <option value="{{ $room->id }}">{{ $room->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Type de meuble</label>
                                            <select name="product_type_id" x-model="category.product_type_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                                                <option value="">-- Aucun --</option>
                                                @foreach($productTypes as $productType)
                                                    <option value="{{ $productType->id }}">{{ $productType->name }}{{ $productType->room ? ' • ' . $productType->room->name : '' }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Nature de page</label>
                                        <select name="category_kind" x-model="category.category_kind" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                                            @foreach($kindOptions as $value => $label)
                                                <option value="{{ $value }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Image à la une</label>
                                    <div class="mt-1 space-y-2">
                                        <div class="flex items-center gap-3">
                                            <template x-if="category.featured_image && !removeFeaturedImage">
                                                <img :src="category.featured_image" alt="" class="h-12 w-12 rounded-xl object-cover border border-gray-200">
                                            </template>
                                            <template x-if="category.featured_image && removeFeaturedImage">
                                                <div class="text-sm text-red-600 font-medium">Image sera supprimée</div>
                                            </template>
                                            <input type="file"
                                                   name="featured_image"
                                                   accept="image/*"
                                                   @change="removeFeaturedImage = false"
                                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                                        </div>

                                        <template x-if="category.featured_image">
                                            <label class="inline-flex items-center gap-2 text-sm text-red-600">
                                                <input type="checkbox"
                                                       name="remove_featured_image"
                                                       value="1"
                                                       x-model="removeFeaturedImage"
                                                       class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                                Supprimer l'image actuelle
                                            </label>
                                        </template>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">PNG/JPG, max 4Mo.</p>
                                </div>

                                @if($architectureEnabled)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Intro SEO / landing</label>
                                        <textarea name="landing_intro" x-model="category.landing_intro" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50" placeholder="Texte d'introduction pour la future landing catégorie."></textarea>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Outro SEO / conseils</label>
                                        <textarea name="landing_outro" x-model="category.landing_outro" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50" placeholder="Bloc éditorial bas de page, FAQ, conseils, maillage interne."></textarea>
                                    </div>

                                    <div class="rounded-xl border border-dark-100 bg-dark-50 p-4">
                                        <input type="hidden" name="is_indexable" :value="category.is_indexable ? 1 : 0">
                                        <label class="inline-flex items-center gap-3 text-sm font-medium text-dark-800">
                                            <input type="checkbox" x-model="category.is_indexable" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                            Indexable par les moteurs
                                        </label>
                                        <p class="mt-2 text-xs text-dark-500">Désactive l’indexation pour les catégories parasites ou les imports trop faibles pour le SEO.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                            Enregistrer
                        </button>
                        <button type="button" @click="isModalOpen = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Annuler
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div x-show="isDeleteModalOpen" class="fixed inset-0 z-[60] overflow-y-auto" style="display: none;">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="isDeleteModalOpen" @click="isDeleteModalOpen = false" x-transition.opacity class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="isDeleteModalOpen" x-transition.scale class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" x-text="isBulk ? 'Supprimer ' + selectedItems.length + ' éléments ?' : 'Supprimer la catégorie ?'"></h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    <span x-text="isBulk ? 'Êtes-vous sûr de vouloir supprimer ces ' + selectedItems.length + ' catégories ?' : 'Êtes-vous sûr de vouloir supprimer cette catégorie ?'"></span>
                                    <br>
                                    <span class="font-bold text-red-600">Attention : Tous les produits et sous-catégories associés seront également supprimés.</span>
                                    Cette action est irréversible.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-3">
                    <form :action="deleteUrl" method="POST">
                        @csrf @method('DELETE')
                        <template x-if="isBulk">
                            <template x-for="id in selectedItems" :key="id">
                                <input type="hidden" name="ids[]" :value="id">
                            </template>
                        </template>
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:w-auto sm:text-sm">
                            Confirmer la suppression
                        </button>
                    </form>
                    <button type="button" @click="isDeleteModalOpen = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm">
                        Annuler
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
