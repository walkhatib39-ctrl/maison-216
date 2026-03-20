@extends('layouts.admin')

@section('content')
<!-- Dashboard Header -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-dark-900">Tableau de bord</h1>
            <p class="text-dark-600 mt-1">Aperçu de votre activité e-commerce</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="bg-white px-4 py-2 rounded-xl border border-dark-100 shadow-sm">
                <div class="text-sm text-dark-600">Dernière mise à jour</div>
                <div class="text-dark-900 font-medium">{{ now()->format('d/m/Y H:i') }}</div>
            </div>
            <button onclick="location.reload()" class="btn-premium inline-flex items-center gap-2 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-xl transition-colors duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Actualiser
            </button>
        </div>
    </div>
</div>

<!-- KPI Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8 stagger-animation">
    <!-- Commandes du jour -->
    <div class="product-card bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-premium-lg">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
            </div>
            <div class="text-white/80 text-sm font-medium">Aujourd'hui</div>
        </div>
        <div class="text-3xl font-bold mb-2">{{ $ordersToday }}</div>
        <div class="text-blue-100 text-sm">Commandes du jour</div>
        <div class="mt-4 flex items-center text-sm">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
            </svg>
            <span class="text-blue-100">Tendance positive</span>
        </div>
    </div>

    <!-- Total commandes -->
    <div class="product-card bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl p-6 text-white shadow-premium-lg">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2-2V7a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 002 2h2a2 2 0 012-2V7a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 00-2 2h-2a2 2 0 00-2 2v6"/>
                </svg>
            </div>
            <div class="text-white/80 text-sm font-medium">Total</div>
        </div>
        <div class="text-3xl font-bold mb-2">{{ number_format($ordersTotal) }}</div>
        <div class="text-emerald-100 text-sm">Commandes totales</div>
        <div class="mt-4 flex items-center text-sm">
            <div class="w-full bg-white/20 rounded-full h-2">
                <div class="bg-white h-2 rounded-full" style="width: 85%"></div>
            </div>
        </div>
    </div>

    <!-- Chiffre d'affaires -->
    <div class="product-card bg-gradient-to-br from-primary-500 to-primary-600 rounded-2xl p-6 text-white shadow-premium-lg">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                </svg>
            </div>
            <div class="text-white/80 text-sm font-medium">CA Total</div>
        </div>
        <div class="text-3xl font-bold mb-2">{{ number_format($revenueTotalDT, 0, ',', ' ') }} DT</div>
        <div class="text-primary-100 text-sm">Chiffre d'affaires estimé</div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-primary-100">🚀 Performance excellente</span>
        </div>
    </div>

    <!-- Produits -->
    <div class="product-card bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-premium-lg">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <div class="text-white/80 text-sm font-medium">Catalogue</div>
        </div>
        <div class="text-3xl font-bold mb-2">{{ number_format($productsCount) }}</div>
        <div class="text-purple-100 text-sm">Produits en ligne</div>
        <div class="mt-4 flex items-center justify-between text-sm">
            <span class="text-purple-100">{{ $categoriesCount }} catégories</span>
            <a href="{{ route('admin.products.create') }}" class="text-white hover:text-purple-200 font-medium">
                + Ajouter
            </a>
        </div>
        <div class="mt-2 text-xs text-purple-100/90">
            {{ $roomsCount }} univers • {{ $productTypesCount }} types • {{ $collectionsCount }} collections
        </div>
    </div>
</div>

<!-- Charts & Analytics Section -->
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-8">
    <!-- Recent Orders -->
    <div class="xl:col-span-2 bg-white rounded-2xl shadow-premium border border-dark-100">
        <div class="p-6 border-b border-dark-100">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-dark-900">Commandes récentes</h3>
                <a href="{{ route('admin.orders.index') }}" class="text-primary-600 hover:text-primary-700 font-medium text-sm">
                    Voir tout →
                </a>
            </div>
        </div>
        <div class="p-6">
            @if($recentOrders->count() > 0)
                <div class="space-y-4">
                    @foreach($recentOrders as $order)
                        <div class="flex items-center justify-between p-4 bg-dark-50 rounded-xl hover:bg-dark-100 transition-colors duration-200">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full flex items-center justify-center">
                                    <span class="text-white font-semibold text-sm">#{{ $order->id }}</span>
                                </div>
                                <div>
                                    <div class="font-semibold text-dark-900">{{ $order->full_name }}</div>
                                    <div class="text-sm text-dark-600">{{ $order->created_at->format('d/m/Y H:i') }}</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-bold text-dark-900">{{ $order->total_display ?? 'N/A' }}</div>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($order->status === 'processing' ? 'bg-blue-100 text-blue-800' : 
                                       ($order->status === 'shipped' ? 'bg-purple-100 text-purple-800' : 
                                       'bg-green-100 text-green-800')) }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-dark-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-dark-700 mb-2">Aucune commande récente</h4>
                    <p class="text-dark-500">Les nouvelles commandes apparaîtront ici</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="bg-white rounded-2xl shadow-premium border border-dark-100">
        <div class="p-6 border-b border-dark-100">
            <h3 class="text-xl font-bold text-dark-900">Statistiques rapides</h3>
        </div>
        <div class="p-6 space-y-6">
            <!-- Status Distribution -->
            <div>
                <h4 class="font-semibold text-dark-700 mb-3">État des commandes</h4>
                <div class="space-y-3">
                    @php
                        $statusStats = [
                            'pending' => ['count' => \App\Models\Order::where('status', 'pending')->count(), 'color' => 'yellow', 'label' => 'En attente'],
                            'processing' => ['count' => \App\Models\Order::where('status', 'processing')->count(), 'color' => 'blue', 'label' => 'En cours'],
                            'shipped' => ['count' => \App\Models\Order::where('status', 'shipped')->count(), 'color' => 'purple', 'label' => 'Expédiées'],
                            'delivered' => ['count' => \App\Models\Order::where('status', 'delivered')->count(), 'color' => 'green', 'label' => 'Livrées']
                        ];
                        $totalOrders = max(array_sum(array_column($statusStats, 'count')), 1);
                    @endphp
                    
                    @foreach($statusStats as $status => $data)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 rounded-full bg-{{ $data['color'] }}-500"></div>
                                <span class="text-sm text-dark-600">{{ $data['label'] }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-20 bg-dark-100 rounded-full h-2">
                                    <div class="bg-{{ $data['color'] }}-500 h-2 rounded-full" style="width: {{ ($data['count'] / $totalOrders) * 100 }}%"></div>
                                </div>
                                <span class="text-sm font-semibold text-dark-900 w-8">{{ $data['count'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Top Categories -->
            <div>
                <h4 class="font-semibold text-dark-700 mb-3">Top catégories</h4>
                <div class="space-y-2">
                    @foreach(\App\Models\Category::withCount('products')->orderBy('products_count', 'desc')->take(3)->get() as $category)
                        <div class="flex items-center justify-between p-3 bg-dark-50 rounded-lg">
                            <span class="text-sm font-medium text-dark-700">{{ $category->name }}</span>
                            <span class="text-sm text-dark-500">{{ $category->products_count }} produits</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-2xl shadow-premium border border-dark-100 mb-8">
    <div class="p-6 border-b border-dark-100">
        <h3 class="text-xl font-bold text-dark-900">Actions rapides</h3>
        <p class="text-dark-600 text-sm mt-1">Accès direct aux fonctionnalités principales</p>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('admin.products.create') }}" 
               class="interactive group flex flex-col items-center p-6 bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-xl hover:from-blue-100 hover:to-blue-200 transition-all duration-200">
                <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-200">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                </div>
                <h4 class="font-semibold text-dark-900 text-center">Nouveau produit</h4>
                <p class="text-sm text-dark-600 text-center mt-1">Ajouter un produit</p>
            </a>

            <a href="{{ route('admin.orders.index') }}" 
               class="interactive group flex flex-col items-center p-6 bg-gradient-to-br from-emerald-50 to-emerald-100 border border-emerald-200 rounded-xl hover:from-emerald-100 hover:to-emerald-200 transition-all duration-200">
                <div class="w-12 h-12 bg-emerald-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-200">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <h4 class="font-semibold text-dark-900 text-center">Gérer commandes</h4>
                <p class="text-sm text-dark-600 text-center mt-1">Traiter les commandes</p>
            </a>

            <a href="{{ route('admin.settings.index') }}" 
               class="interactive group flex flex-col items-center p-6 bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-xl hover:from-purple-100 hover:to-purple-200 transition-all duration-200">
                <div class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-200">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h4 class="font-semibold text-dark-900 text-center">Paramètres</h4>
                <p class="text-sm text-dark-600 text-center mt-1">Configuration</p>
            </a>

            <a href="{{ route('admin.rooms.index') }}" 
               class="interactive group flex flex-col items-center p-6 bg-gradient-to-br from-amber-50 to-amber-100 border border-amber-200 rounded-xl hover:from-amber-100 hover:to-amber-200 transition-all duration-200">
                <div class="w-12 h-12 bg-amber-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-200">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18M5 21V7l7-4 7 4v14"/>
                    </svg>
                </div>
                <h4 class="font-semibold text-dark-900 text-center">Architecture catalogue</h4>
                <p class="text-sm text-dark-600 text-center mt-1">Univers, types, collections</p>
            </a>

            <a href="{{ route('home') }}" target="_blank" 
               class="interactive group flex flex-col items-center p-6 bg-gradient-to-br from-primary-50 to-primary-100 border border-primary-200 rounded-xl hover:from-primary-100 hover:to-primary-200 transition-all duration-200">
                <div class="w-12 h-12 bg-primary-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-200">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </div>
                <h4 class="font-semibold text-dark-900 text-center">Voir le site</h4>
                <p class="text-sm text-dark-600 text-center mt-1">Interface client</p>
            </a>
        </div>
    </div>
</div>

<!-- System Info -->
<div class="bg-gradient-to-r from-dark-50 to-dark-100 rounded-2xl border border-dark-200 p-6">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="font-semibold text-dark-900">Système</h3>
            <p class="text-sm text-dark-600 mt-1">
                Laravel {{ app()->version() }} • PHP {{ PHP_VERSION }} • 
                Base de données connectée • Cache actif
            </p>
        </div>
        <div class="flex items-center gap-2">
            <div class="w-3 h-3 bg-green-500 rounded-full pulse-glow"></div>
            <span class="text-sm font-medium text-green-700">Système opérationnel</span>
        </div>
    </div>
</div>
@endsection
