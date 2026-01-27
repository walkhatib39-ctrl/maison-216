@extends('layouts.admin')

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-dark-900">SEO & Référencement</h1>
            <p class="text-dark-600 mt-1">Optimiser le référencement naturel de votre boutique</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.settings.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition-colors duration-200 shadow-lg">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Paramètres généraux
            </a>
        </div>
    </div>
</div>

<!-- SEO Status Overview -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8 stagger-animation">
    <!-- Sitemap -->
    <div class="product-card bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-premium-lg">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                </svg>
            </div>
            <div class="text-green-100 text-sm font-medium">Actif</div>
        </div>
        <div class="text-2xl font-bold mb-2">Sitemap XML</div>
        <div class="text-green-100 text-sm">Disponible et à jour</div>
        <div class="mt-4">
            <a href="/sitemap.xml" target="_blank" class="text-green-100 hover:text-white text-sm font-medium">
                Voir le sitemap →
            </a>
        </div>
    </div>

    <!-- Robots.txt -->
    <div class="product-card bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-premium-lg">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                </svg>
            </div>
            <div class="text-blue-100 text-sm font-medium">Configuré</div>
        </div>
        <div class="text-2xl font-bold mb-2">Robots.txt</div>
        <div class="text-blue-100 text-sm">Directives pour crawlers</div>
        <div class="mt-4">
            <a href="/robots.txt" target="_blank" class="text-blue-100 hover:text-white text-sm font-medium">
                Voir robots.txt →
            </a>
        </div>
    </div>

    <!-- Meta Tags -->
    <div class="product-card bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-premium-lg">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
            </div>
            <div class="text-purple-100 text-sm font-medium">Dynamiques</div>
        </div>
        <div class="text-2xl font-bold mb-2">Meta Tags</div>
        <div class="text-purple-100 text-sm">Titre et descriptions SEO</div>
        <div class="mt-4">
            <span class="text-purple-100 text-sm">Générés automatiquement</span>
        </div>
    </div>

    <!-- Performance -->
    <div class="product-card bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl p-6 text-white shadow-premium-lg">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <div class="text-amber-100 text-sm font-medium">Optimisé</div>
        </div>
        <div class="text-2xl font-bold mb-2">Performance</div>
        <div class="text-amber-100 text-sm">Site optimisé SEO</div>
        <div class="mt-4">
            <span class="text-amber-100 text-sm">Temps de chargement rapide</span>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
    <!-- Configuration SEO actuelle -->
    <div class="xl:col-span-2 space-y-8">
        <!-- Statut actuel -->
        <div class="bg-white rounded-2xl border border-dark-100 shadow-premium">
            <div class="p-6 border-b border-dark-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-dark-900">Configuration actuelle</h3>
                        <p class="text-sm text-dark-600">État du référencement de votre site</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Métadonnées -->
                    <div class="space-y-4">
                        <h4 class="font-semibold text-dark-900 flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Métadonnées dynamiques
                        </h4>
                        <ul class="space-y-2 text-sm text-dark-600">
                            <li class="flex items-center gap-2">
                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                Titre de page automatique
                            </li>
                            <li class="flex items-center gap-2">
                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                Meta description par page
                            </li>
                            <li class="flex items-center gap-2">
                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                Open Graph (Facebook)
                            </li>
                            <li class="flex items-center gap-2">
                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                Twitter Cards
                            </li>
                        </ul>
                    </div>

                    <!-- Structure -->
                    <div class="space-y-4">
                        <h4 class="font-semibold text-dark-900 flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Structure & Navigation
                        </h4>
                        <ul class="space-y-2 text-sm text-dark-600">
                            <li class="flex items-center gap-2">
                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                URLs propres (SEO-friendly)
                            </li>
                            <li class="flex items-center gap-2">
                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                Fil d'Ariane (breadcrumbs)
                            </li>
                            <li class="flex items-center gap-2">
                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                Hiérarchie H1, H2, H3
                            </li>
                            <li class="flex items-center gap-2">
                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                Navigation logique
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fonctionnalités disponibles -->
        <div class="bg-white rounded-2xl border border-dark-100 shadow-premium">
            <div class="p-6 border-b border-dark-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-dark-900">Fonctionnalités SEO actives</h3>
                        <p class="text-sm text-dark-600">Optimisations déjà en place</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="p-4 bg-green-50 border border-green-200 rounded-xl">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7"/>
                                </svg>
                            </div>
                            <h4 class="font-semibold text-green-800">Sitemap XML</h4>
                        </div>
                        <p class="text-sm text-green-700">Indexation automatique des pages</p>
                    </div>

                    <div class="p-4 bg-blue-50 border border-blue-200 rounded-xl">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1"/>
                                </svg>
                            </div>
                            <h4 class="font-semibold text-blue-800">Robots.txt</h4>
                        </div>
                        <p class="text-sm text-blue-700">Directives pour les moteurs</p>
                    </div>

                    <div class="p-4 bg-purple-50 border border-purple-200 rounded-xl">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>
                            <h4 class="font-semibold text-purple-800">Meta Tags</h4>
                        </div>
                        <p class="text-sm text-purple-700">Optimisation automatique</p>
                    </div>

                    <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-8 h-8 bg-amber-500 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <h4 class="font-semibold text-amber-800">Performance</h4>
                        </div>
                        <p class="text-sm text-amber-700">Chargement optimisé</p>
                    </div>

                    <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-xl">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <h4 class="font-semibold text-emerald-800">Mobile-First</h4>
                        </div>
                        <p class="text-sm text-emerald-700">Responsive design</p>
                    </div>

                    <div class="p-4 bg-indigo-50 border border-indigo-200 rounded-xl">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-8 h-8 bg-indigo-500 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                            </div>
                            <h4 class="font-semibold text-indigo-800">Schema.org</h4>
                        </div>
                        <p class="text-sm text-indigo-700">Données structurées</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recommandations -->
        <div class="bg-white rounded-2xl border border-dark-100 shadow-premium">
            <div class="p-6 border-b border-dark-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-dark-900">Recommandations</h3>
                        <p class="text-sm text-dark-600">Optimisations suggérées pour améliorer le SEO</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex items-start gap-4 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-blue-800 mb-1">Optimiser les images</h4>
                            <p class="text-sm text-blue-700">Ajouter des attributs alt descriptifs à toutes les images produits</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-4 bg-green-50 border border-green-200 rounded-xl">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-green-800 mb-1">Contenu riche</h4>
                            <p class="text-sm text-green-700">Enrichir les descriptions produits avec plus de détails pour le SEO</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-4 bg-purple-50 border border-purple-200 rounded-xl">
                        <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-purple-800 mb-1">Pages de marques</h4>
                            <p class="text-sm text-purple-700">Créer des pages dédiées aux marques pour cibler plus de mots-clés</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar - Outils et actions -->
    <div class="space-y-8">
        <!-- Outils SEO -->
        <div class="bg-white rounded-2xl border border-dark-100 shadow-premium">
            <div class="p-6 border-b border-dark-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-dark-900">Outils SEO</h3>
                        <p class="text-sm text-dark-600">Liens rapides et vérifications</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    <a href="/sitemap.xml" target="_blank"
                       class="w-full inline-flex items-center justify-between gap-2 px-4 py-3 bg-green-100 hover:bg-green-200 text-green-700 font-medium rounded-xl transition-colors duration-200">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7"/>
                            </svg>
                            Sitemap XML
                        </div>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    </a>

                    <a href="/robots.txt" target="_blank"
                       class="w-full inline-flex items-center justify-between gap-2 px-4 py-3 bg-blue-100 hover:bg-blue-200 text-blue-700 font-medium rounded-xl transition-colors duration-200">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1"/>
                            </svg>
                            Robots.txt
                        </div>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    </a>

                    <a href="{{ route('home') }}" target="_blank"
                       class="w-full inline-flex items-center justify-between gap-2 px-4 py-3 bg-primary-100 hover:bg-primary-200 text-primary-700 font-medium rounded-xl transition-colors duration-200">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            Voir le site
                        </div>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Analyse et conseils -->
        <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 border border-emerald-200 rounded-2xl p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h4 class="font-semibold text-emerald-800">Statut SEO global</h4>
            </div>
            <div class="text-sm text-emerald-700 space-y-2 mb-4">
                <p>✅ Votre site Maison 216 est correctement optimisé pour le SEO</p>
                <p>✅ Sitemap XML disponible et robots.txt configuré</p>
                <p>✅ Meta tags dynamiques par page</p>
                <p>✅ URLs SEO-friendly avec slugs</p>
            </div>
            <div class="text-xs text-emerald-600">
                Continuez à enrichir vos contenus produits pour améliorer le référencement naturel
            </div>
        </div>

        <!-- Prochaines étapes -->
        <div class="bg-white rounded-2xl border border-dark-100 shadow-premium p-6">
            <h4 class="font-semibold text-dark-900 mb-4">Prochaines étapes suggérées</h4>
            <ol class="space-y-3">
                <li class="flex items-start gap-3">
                    <div class="w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0">1</div>
                    <div>
                        <div class="font-medium text-dark-900">Enrichir les meta descriptions</div>
                        <div class="text-sm text-dark-600">Personnaliser les descriptions de chaque catégorie</div>
                    </div>
                </li>
                <li class="flex items-start gap-3">
                    <div class="w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0">2</div>
                    <div>
                        <div class="font-medium text-dark-900">Images Alt text</div>
                        <div class="text-sm text-dark-600">Ajouter des descriptions ALT aux images</div>
                    </div>
                </li>
                <li class="flex items-start gap-3">
                    <div class="w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0">3</div>
                    <div>
                        <div class="font-medium text-dark-900">Blog/Actualités</div>
                        <div class="text-sm text-dark-600">Créer du contenu pour améliorer le référencement</div>
                    </div>
                </li>
                <li class="flex items-start gap-3">
                    <div class="w-6 h-6 bg-green-500 text-white rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0">✓</div>
                    <div>
                        <div class="font-medium text-dark-900">Schema.org</div>
                        <div class="text-sm text-dark-600">Données structurées pour les produits</div>
                    </div>
                </li>
            </ol>
        </div>
    </div>
</div>
@endsection
