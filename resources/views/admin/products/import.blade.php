@extends('layouts.admin')

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-dark-900">Import produits JSON</h1>
            <p class="text-dark-600 mt-1">Importer plusieurs produits en une seule fois</p>
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

<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
    <!-- Formulaire principal -->
    <div class="xl:col-span-2">
        <form method="POST" action="{{ route('admin.products.import.store') }}" enctype="multipart/form-data">
            @csrf
            
            <!-- Fichier JSON -->
            <div class="bg-white rounded-2xl border border-dark-100 shadow-premium mb-8">
                <div class="p-6 border-b border-dark-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-dark-900">Fichier de données</h3>
                            <p class="text-sm text-dark-600">Sélectionner le fichier JSON à importer</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div>
                        <label class="block text-sm font-semibold text-dark-700 mb-3">Fichier JSON *</label>
                        <div class="border-2 border-dashed border-dark-300 rounded-xl p-8 text-center hover:border-amber-400 transition-colors duration-200">
                            <input required name="file" type="file" accept=".json,.txt" class="hidden" id="jsonFile">
                            <label for="jsonFile" class="cursor-pointer">
                                <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                </div>
                                <div class="text-lg font-semibold text-dark-900 mb-2">Cliquer pour sélectionner</div>
                                <div class="text-sm text-dark-600 mb-2">Glisser-déposer votre fichier ici</div>
                                <div class="text-xs text-dark-500">JSON, TXT (Max 10MB)</div>
                            </label>
                        </div>
                        <div class="mt-3 p-3 bg-amber-50 border border-amber-200 rounded-lg">
                            <div class="text-sm text-amber-800">
                                <strong>Format accepté :</strong> Tableau de produits JSON ou objet avec clé "products".
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Configuration import -->
            <div class="bg-white rounded-2xl border border-dark-100 shadow-premium mb-8">
                <div class="p-6 border-b border-dark-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-dark-900">Configuration import</h3>
                            <p class="text-sm text-dark-600">Paramètres par défaut et options avancées</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-dark-700 mb-2">Catégorie (slug)</label>
                            <input name="category_slug" type="text" value="{{ old('category_slug') }}"
                                   class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200"
                                   placeholder="ex: meubles-tv-supports-tv">
                            <p class="text-xs text-dark-500 mt-1">Catégorie par défaut pour tous les produits</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-dark-700 mb-2">Marque par défaut</label>
                            <input name="brand" type="text" value="{{ old('brand') }}"
                                   class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200"
                                   placeholder="Ex: Design Moderne">
                            <p class="text-xs text-dark-500 mt-1">Marque appliquée si non spécifiée dans le JSON</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-dark-700 mb-2">Statut par défaut</label>
                            <select name="active"
                                    class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200">
                                <option value="1" @selected(old('active', '1')==='1')>✅ Actif (visible sur le site)</option>
                                <option value="0" @selected(old('active')==='0')>❌ Inactif (masqué)</option>
                            </select>
                            <p class="text-xs text-dark-500 mt-1">Visibilité des produits importés</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-dark-700 mb-2">Limite d'éléments</label>
                            <input name="limit" type="number" min="1" step="1" value="{{ old('limit') }}"
                                   class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200"
                                   placeholder="Tous (optionnel)">
                            <p class="text-xs text-dark-500 mt-1">Nombre max de produits à importer</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Options avancées -->
            <div class="bg-white rounded-2xl border border-dark-100 shadow-premium mb-8">
                <div class="p-6 border-b border-dark-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-dark-900">Options avancées</h3>
                            <p class="text-sm text-dark-600">Paramètres de sécurité et test</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-4 p-4 bg-orange-50 border border-orange-200 rounded-xl">
                        <input id="dry_run" name="dry_run" type="checkbox" value="1" @checked(old('dry_run'))
                               class="w-5 h-5 rounded border-orange-300 text-orange-600 focus:ring-orange-500 transition-colors duration-200">
                        <div class="flex-1">
                            <label for="dry_run" class="font-semibold text-orange-800">Mode test (Dry-run)</label>
                            <p class="text-sm text-orange-700">Analyser le fichier sans écrire en base de données</p>
                        </div>
                        <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="bg-white rounded-2xl border border-dark-100 shadow-premium p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-semibold text-dark-900">Lancer l'import</h4>
                        <p class="text-sm text-dark-600">Traiter le fichier et créer les produits</p>
                    </div>
                    <button type="submit"
                            class="btn-premium inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-amber-600 to-amber-700 hover:from-amber-700 hover:to-amber-800 text-white font-bold rounded-xl transition-all duration-200 shadow-premium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                        </svg>
                        Démarrer l'import
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Sidebar - Guide et exemples -->
    <div class="space-y-8">
        <!-- Guide rapide -->
        <div class="bg-white rounded-2xl border border-dark-100 shadow-premium">
            <div class="p-6 border-b border-dark-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-dark-900">Guide rapide</h3>
                        <p class="text-sm text-dark-600">Étapes pour réussir l'import</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <ol class="space-y-4">
                    <li class="flex items-start gap-3">
                        <div class="w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0">1</div>
                        <div>
                            <div class="font-medium text-dark-900">Préparer le fichier JSON</div>
                            <div class="text-sm text-dark-600">Format array ou objet avec clé "products"</div>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0">2</div>
                        <div>
                            <div class="font-medium text-dark-900">Configurer les paramètres</div>
                            <div class="text-sm text-dark-600">Catégorie, marque et statut par défaut</div>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0">3</div>
                        <div>
                            <div class="font-medium text-dark-900">Tester avec Dry-run</div>
                            <div class="text-sm text-dark-600">Vérifier avant l'import définitif</div>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="w-6 h-6 bg-green-500 text-white rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0">✓</div>
                        <div>
                            <div class="font-medium text-dark-900">Lancer l'import final</div>
                            <div class="text-sm text-dark-600">Désactiver Dry-run et importer</div>
                        </div>
                    </li>
                </ol>
            </div>
        </div>

        <!-- Format JSON -->
        <div class="bg-white rounded-2xl border border-dark-100 shadow-premium">
            <div class="p-6 border-b border-dark-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-dark-900">Format JSON</h3>
                        <p class="text-sm text-dark-600">Exemple de structure attendue</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="bg-dark-900 rounded-xl p-4 text-sm font-mono text-green-400 overflow-x-auto">
<pre class="whitespace-pre"><code>[
  {
    "title": "Canapé moderne",
    "price": "599",
    "stock": 5,
    "brand": "Design Pro",
    "images": [
      "https://url1.jpg",
      "https://url2.jpg"
    ],
    "attributes": {
      "Couleur": "Beige",
      "Places": "3"
    }
  }
]</code></pre>
                </div>
                <div class="mt-4 text-xs text-dark-500">
                    <strong>Astuce :</strong> Utilisez la logique de l'import CLI (app:import-products) pour plus d'options.
                </div>
            </div>
        </div>

        <!-- Sécurité -->
        <div class="bg-gradient-to-br from-red-50 to-red-100 border border-red-200 rounded-2xl p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
                <h4 class="font-semibold text-red-800">Important</h4>
            </div>
            <ul class="text-sm text-red-700 space-y-2">
                <li>• Toujours tester avec le mode Dry-run d'abord</li>
                <li>• Sauvegarder votre base avant import massif</li>
                <li>• Vérifier la taille du fichier (< 10MB)</li>
                <li>• Prévoir une limite pour éviter les timeouts</li>
            </ul>
        </div>

        <!-- Actions rapides -->
        <div class="bg-white rounded-2xl border border-dark-100 shadow-premium p-6">
            <h4 class="font-semibold text-dark-900 mb-4">Actions rapides</h4>
            <div class="space-y-3">
                <a href="{{ route('admin.products.create') }}"
                   class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-blue-100 hover:bg-blue-200 text-blue-700 font-medium rounded-xl transition-colors duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Créer un produit
                </a>
                <a href="{{ route('admin.products.index') }}"
                   class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-dark-100 hover:bg-dark-200 text-dark-700 font-medium rounded-xl transition-colors duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    Voir tous les produits
                </a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // File input preview and drag & drop
    const fileInput = document.getElementById('jsonFile');
    const dropZone = fileInput.closest('.border-dashed');
    
    // File preview
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const label = dropZone.querySelector('label');
            const originalContent = label.innerHTML;
            
            label.innerHTML = `
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="text-lg font-semibold text-green-700 mb-2">Fichier sélectionné</div>
                <div class="text-sm text-green-600 mb-2">${file.name}</div>
                <div class="text-xs text-green-500">${(file.size / 1024 / 1024).toFixed(2)} MB</div>
            `;
            
            dropZone.classList.remove('border-dark-300', 'hover:border-amber-400');
            dropZone.classList.add('border-green-300', 'bg-green-50');
        }
    });
    
    // Drag & Drop functionality
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });
    
    function highlight(e) {
        dropZone.classList.add('border-amber-500', 'bg-amber-50');
    }
    
    function unhighlight(e) {
        dropZone.classList.remove('border-amber-500', 'bg-amber-50');
    }
    
    dropZone.addEventListener('drop', handleDrop, false);
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        if (files.length > 0) {
            fileInput.files = files;
            fileInput.dispatchEvent(new Event('change', { bubbles: true }));
        }
    }
});
</script>
@endsection
