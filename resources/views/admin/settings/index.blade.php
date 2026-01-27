@extends('layouts.admin')

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-dark-900">Paramètres du site</h1>
            <p class="text-dark-600 mt-1">Configuration générale de votre boutique en ligne</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}" target="_blank"
               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition-colors duration-200 shadow-lg">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                Prévisualiser le site
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

<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
    @csrf

    <!-- Site Identity Section -->
    <div class="bg-white rounded-2xl border border-dark-100 shadow-premium mb-8">
        <div class="p-6 border-b border-dark-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2-2v2m0-4.5V9a2 2 0 012-2h2a2 2 0 012 2v8.5M7 7h4"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-dark-900">Identité du site</h3>
                    <p class="text-sm text-dark-600">Nom de votre boutique et slogan</p>
                </div>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-dark-700 mb-2">Nom du site *</label>
                    <input required name="site_name" type="text" value="{{ old('site_name', $s['site_name']) }}"
                           class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200"
                           placeholder="Ex: Maison 216">
                    <p class="text-xs text-dark-500 mt-1">Affiché dans le header et le titre des pages</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-dark-700 mb-2">Tagline</label>
                    <input name="site_tagline" type="text" value="{{ old('site_tagline', $s['site_tagline']) }}"
                           class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200"
                           placeholder="Ex: Meubles & Décoration">
                    <p class="text-xs text-dark-500 mt-1">Slogan affiché sous le nom</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact & Checkout Section -->
    <div class="bg-white rounded-2xl border border-dark-100 shadow-premium mb-8">
        <div class="p-6 border-b border-dark-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-dark-900">Contact & Commandes</h3>
                    <p class="text-sm text-dark-600">Canaux de communication pour vos clients</p>
                </div>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-dark-700 mb-2">WhatsApp</label>
                    <div class="relative">
                        <input name="whatsapp" type="text" value="{{ old('whatsapp', $s['whatsapp']) }}"
                               class="w-full pl-12 pr-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200"
                               placeholder="+216 12 345 678">
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-dark-500 mt-1">Format international recommandé</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-dark-700 mb-2">Messenger</label>
                    <div class="relative">
                        <input name="messenger" type="url" value="{{ old('messenger', $s['messenger']) }}"
                               class="w-full pl-12 pr-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200"
                               placeholder="https://m.me/votrepage">
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2 w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-dark-500 mt-1">Lien direct vers votre page Facebook</p>
                </div>
            </div>
            
            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex items-center gap-4 p-4 bg-green-50 border border-green-200 rounded-xl">
                    <input id="checkout_whatsapp_enabled" name="checkout_whatsapp_enabled" type="checkbox" value="1"
                           @checked(old('checkout_whatsapp_enabled', $s['checkout_whatsapp_enabled']))
                           class="w-5 h-5 rounded border-green-300 text-green-600 focus:ring-green-500 transition-colors duration-200">
                    <div class="flex-1">
                        <label for="checkout_whatsapp_enabled" class="font-semibold text-green-800">Bouton WhatsApp</label>
                        <p class="text-sm text-green-600">Afficher sur les pages produit</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                    <input id="checkout_messenger_enabled" name="checkout_messenger_enabled" type="checkbox" value="1"
                           @checked(old('checkout_messenger_enabled', $s['checkout_messenger_enabled']))
                           class="w-5 h-5 rounded border-blue-300 text-blue-600 focus:ring-blue-500 transition-colors duration-200">
                    <div class="flex-1">
                        <label for="checkout_messenger_enabled" class="font-semibold text-blue-800">Bouton Messenger</label>
                        <p class="text-sm text-blue-600">Afficher sur les pages produit</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Shipping Section -->
    <div class="bg-white rounded-2xl border border-dark-100 shadow-premium mb-8">
        <div class="p-6 border-b border-dark-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-dark-900">Livraison</h3>
                    <p class="text-sm text-dark-600">Configuration des frais de livraison</p>
                </div>
            </div>
        </div>
        <div class="p-6">
            <div class="max-w-md">
                <label class="block text-sm font-semibold text-dark-700 mb-2">Frais de livraison *</label>
                <div class="relative">
                    <input required name="shipping_fee" type="number" min="0" step="1"
                           value="{{ old('shipping_fee', (int) floor(($s['shipping_fee_millimes'] ?? 20000)/1000)) }}"
                           class="w-full pl-4 pr-12 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200"
                           placeholder="20">
                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-dark-600 font-semibold">
                        DT
                    </div>
                </div>
                <p class="text-xs text-dark-500 mt-1">Frais appliqués à toutes les commandes</p>
                
                <div class="mt-4 p-4 bg-amber-50 border border-amber-200 rounded-xl">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm font-semibold text-amber-800">Information</span>
                    </div>
                    <p class="text-sm text-amber-700 mt-1">
                        Les frais de livraison sont ajoutés automatiquement au total de chaque commande.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- UI Assets Section -->
    <div class="bg-white rounded-2xl border border-dark-100 shadow-premium mb-8">
        <div class="p-6 border-b border-dark-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-dark-900">Logo & Favicon</h3>
                    <p class="text-sm text-dark-600">Images de votre marque</p>
                </div>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Logo Section -->
                <div class="space-y-4">
                    <h4 class="font-semibold text-dark-900 flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        Logo principal
                    </h4>
                    
                    @if($s['ui_logo'])
                        <div class="p-4 bg-dark-50 border border-dark-200 rounded-xl">
                            <div class="text-sm font-medium text-dark-700 mb-2">Logo actuel :</div>
                            <img src="{{ $s['ui_logo'] }}" alt="Logo actuel" class="h-12 max-w-full object-contain">
                        </div>
                    @endif
                    
                    <div>
                        <label class="block text-sm font-semibold text-dark-700 mb-2">URL du logo</label>
                        <input name="ui_logo_url" type="url" value="{{ old('ui_logo_url') }}"
                               class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200"
                               placeholder="https://exemple.com/logo.png">
                        <p class="text-xs text-dark-500 mt-1">Ou utilisez le téléversement ci-dessous</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-dark-700 mb-2">Téléverser un logo</label>
                        <div class="border-2 border-dashed border-dark-300 rounded-xl p-6 text-center hover:border-primary-400 transition-colors duration-200">
                            <input name="ui_logo_file" type="file" accept="image/*" class="hidden" id="logoFile">
                            <label for="logoFile" class="cursor-pointer">
                                <svg class="w-8 h-8 text-dark-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <div class="text-sm text-dark-600 font-medium">Cliquer pour sélectionner</div>
                                <div class="text-xs text-dark-500 mt-1">PNG, JPG, SVG (Max 2MB)</div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Favicon Section -->
                <div class="space-y-4">
                    <h4 class="font-semibold text-dark-900 flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                        Favicon
                    </h4>
                    
                    @if($s['ui_favicon'])
                        <div class="p-4 bg-dark-50 border border-dark-200 rounded-xl">
                            <div class="text-sm font-medium text-dark-700 mb-2">Favicon actuel :</div>
                            <img src="{{ $s['ui_favicon'] }}" alt="Favicon actuel" class="h-8 w-8 object-contain">
                        </div>
                    @endif
                    
                    <div>
                        <label class="block text-sm font-semibold text-dark-700 mb-2">URL du favicon</label>
                        <input name="ui_favicon_url" type="url" value="{{ old('ui_favicon_url') }}"
                               class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200"
                               placeholder="https://exemple.com/favicon.ico">
                        <p class="text-xs text-dark-500 mt-1">Ou utilisez le téléversement ci-dessous</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-dark-700 mb-2">Téléverser un favicon</label>
                        <div class="border-2 border-dashed border-dark-300 rounded-xl p-6 text-center hover:border-primary-400 transition-colors duration-200">
                            <input name="ui_favicon_file" type="file" accept=".png,.ico" class="hidden" id="faviconFile">
                            <label for="faviconFile" class="cursor-pointer">
                                <svg class="w-8 h-8 text-dark-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <div class="text-sm text-dark-600 font-medium">Cliquer pour sélectionner</div>
                                <div class="text-xs text-dark-500 mt-1">PNG, ICO (32x32 recommandé)</div>
                            </label>
                        </div>
                    </div>
                    
                    <div class="p-4 bg-blue-50 border border-blue-200 rounded-xl">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm font-semibold text-blue-800">À propos du favicon</span>
                        </div>
                        <p class="text-sm text-blue-700 mt-1">
                            Le favicon apparaît dans l'onglet du navigateur. Taille recommandée : 32x32 pixels.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Save Button -->
    <div class="bg-white rounded-2xl border border-dark-100 shadow-premium p-6">
        <div class="flex items-center justify-between">
            <div>
                <h4 class="font-semibold text-dark-900">Sauvegarder les modifications</h4>
                <p class="text-sm text-dark-600">Les changements seront appliqués immédiatement sur votre site</p>
            </div>
            <button type="submit"
                    class="btn-premium inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-bold rounded-xl transition-all duration-200 shadow-premium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Enregistrer les paramètres
            </button>
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
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Create preview if it doesn't exist
                        let preview = previewContainer.querySelector('.file-preview');
                        if (!preview) {
                            preview = document.createElement('div');
                            preview.className = 'file-preview mt-4 p-3 bg-primary-50 border border-primary-200 rounded-xl';
                            previewContainer.appendChild(preview);
                        }
                        
                        preview.innerHTML = `
                            <div class="flex items-center gap-3">
                                <img src="${e.target.result}" alt="Aperçu" class="h-12 w-12 object-contain rounded-lg border border-primary-300">
                                <div>
                                    <div class="text-sm font-medium text-primary-800">${file.name}</div>
                                    <div class="text-xs text-primary-600">${(file.size / 1024).toFixed(1)} KB</div>
                                </div>
                            </div>
                        `;
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    }

    // Setup file previews
    setupFilePreview('logoFile', document.querySelector('#logoFile').closest('.space-y-4'));
    setupFilePreview('faviconFile', document.querySelector('#faviconFile').closest('.space-y-4'));
});
</script>
@endsection
