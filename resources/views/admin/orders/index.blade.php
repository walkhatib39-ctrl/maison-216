@extends('layouts.admin')

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-dark-900">Gestion des commandes</h1>
            <p class="text-dark-600 mt-1">{{ $orders->total() }} commande{{ $orders->total() > 1 ? 's' : '' }} au total</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.orders.export', request()->query()) }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-xl transition-colors duration-200 shadow-lg">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export CSV
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

<!-- Status Overview Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8 stagger-animation">
    @php
        $statusStats = [
            'pending' => ['count' => \App\Models\Order::where('status', 'pending')->count(), 'color' => 'yellow', 'label' => 'En attente', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
            'processing' => ['count' => \App\Models\Order::where('status', 'processing')->count(), 'color' => 'blue', 'label' => 'En cours', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z'],
            'shipped' => ['count' => \App\Models\Order::where('status', 'shipped')->count(), 'color' => 'purple', 'label' => 'Expédiées', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
            'delivered' => ['count' => \App\Models\Order::where('status', 'delivered')->count(), 'color' => 'green', 'label' => 'Livrées', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z']
        ];
    @endphp

    @foreach($statusStats as $status => $data)
        <div class="product-card bg-gradient-to-br from-{{ $data['color'] }}-500 to-{{ $data['color'] }}-600 rounded-2xl p-6 text-white shadow-premium-lg cursor-pointer" 
             onclick="filterByStatus('{{ $status }}')">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $data['icon'] }}"/>
                    </svg>
                </div>
                <div class="text-{{ $data['color'] }}-100 text-sm font-medium">{{ ucfirst($status) }}</div>
            </div>
            <div class="text-3xl font-bold mb-2">{{ number_format($data['count']) }}</div>
            <div class="text-{{ $data['color'] }}-100 text-sm">{{ $data['label'] }}</div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-{{ $data['color'] }}-100">Cliquer pour filtrer</span>
            </div>
        </div>
    @endforeach
</div>

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
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-6">
            <div>
                <label class="block text-sm font-semibold text-dark-700 mb-2">Recherche</label>
                <div class="relative">
                    <input type="text" name="q" value="{{ $filters['q'] ?? '' }}"
                           class="w-full pl-10 pr-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200"
                           placeholder="Nom, téléphone, email...">
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-dark-700 mb-2">Statut</label>
                <select name="status" id="statusFilter"
                        class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200">
                    <option value="">Tous les statuts</option>
                    @foreach($statusOptions as $st)
                        <option value="{{ $st }}" @selected(($filters['status'] ?? '')===$st)>
                            {{ ucfirst($st) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-dark-700 mb-2">Ville</label>
                <input type="text" name="city" value="{{ $filters['city'] ?? '' }}"
                       class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200"
                       placeholder="Filtrer par ville...">
            </div>
            <div>
                <label class="block text-sm font-semibold text-dark-700 mb-2">Date début</label>
                <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}"
                       class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200">
            </div>
            <div>
                <label class="block text-sm font-semibold text-dark-700 mb-2">Date fin</label>
                <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}"
                       class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200">
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
            <a href="{{ route('admin.orders.index') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-dark-100 hover:bg-dark-200 text-dark-700 font-semibold rounded-xl transition-colors duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Réinitialiser
            </a>
        </div>
    </form>
</div>

<!-- Bulk Actions -->
<form method="POST" action="{{ route('admin.orders.bulk') }}" id="bulkForm">
    @csrf
    
    <!-- Bulk Actions Bar -->
    <div class="bg-white rounded-2xl border border-dark-100 shadow-premium overflow-hidden mb-8" id="bulkActions" style="display: none;">
        <div class="p-4 bg-gradient-to-r from-primary-50 to-primary-100 border-b border-primary-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <span class="text-primary-800 font-semibold" id="selectedCount">0 commande(s) sélectionnée(s)</span>
                    <select name="status" required
                            class="px-4 py-2 border-2 border-primary-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200 text-sm">
                        <option value="" disabled selected>Changer le statut</option>
                        @foreach($statusOptions as $st)
                            <option value="{{ $st }}">{{ ucfirst($st) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <button type="submit"
                            class="btn-premium inline-flex items-center gap-2 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-xl transition-colors duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Appliquer
                    </button>
                    <button type="button" onclick="deselectAll()"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-dark-100 hover:bg-dark-200 text-dark-700 font-semibold rounded-xl transition-colors duration-200">
                        Désélectionner tout
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-2xl border border-dark-100 shadow-premium overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-dark-50 to-dark-100 border-b border-dark-200">
                    <tr>
                        <th class="px-6 py-4 text-left">
                            <input type="checkbox" id="selectAll" 
                                   class="rounded border-dark-300 text-primary-600 focus:ring-primary-500 transition-colors duration-200">
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-dark-700 uppercase tracking-wider">#</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-dark-700 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-dark-700 uppercase tracking-wider">Client</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-dark-700 uppercase tracking-wider">Localisation</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-dark-700 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-dark-700 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-dark-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-dark-100">
                    @forelse($orders as $o)
                        <tr class="hover:bg-dark-50 transition-colors duration-200 group">
                            <td class="px-6 py-6">
                                <input type="checkbox" name="ids[]" value="{{ $o->id }}" class="order-checkbox rounded border-dark-300 text-primary-600 focus:ring-primary-500 transition-colors duration-200">
                            </td>
                            <td class="px-6 py-6">
                                <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full flex items-center justify-center">
                                    <span class="text-white font-bold text-sm">#{{ $o->id }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <div class="flex flex-col">
                                    <span class="font-semibold text-dark-900">{{ $o->created_at->format('d/m/Y') }}</span>
                                    <span class="text-sm text-dark-600">{{ $o->created_at->format('H:i') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                                        <span class="text-white font-semibold text-sm">{{ substr($o->full_name, 0, 2) }}</span>
                                    </div>
                                    <div>
                                        <div class="font-bold text-dark-900">{{ $o->full_name }}</div>
                                        <div class="text-sm text-dark-600 flex items-center gap-2">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                            </svg>
                                            {{ $o->phone }}
                                        </div>
                                        @if($o->email)
                                            <div class="text-sm text-dark-600 flex items-center gap-2">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                </svg>
                                                {{ $o->email }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <div class="flex flex-col">
                                    <div class="inline-flex items-center gap-2 bg-dark-100 text-dark-700 px-3 py-1 rounded-lg text-sm font-medium">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        {{ $o->city }}
                                    </div>
                                    @if($o->governorate)
                                        <span class="text-xs text-dark-500 mt-1">{{ $o->governorate }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                @php
                                    $statusConfig = [
                                        'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'dot' => 'bg-yellow-500'],
                                        'processing' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'dot' => 'bg-blue-500'],
                                        'shipped' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-800', 'dot' => 'bg-purple-500'],
                                        'delivered' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'dot' => 'bg-green-500']
                                    ];
                                    $config = $statusConfig[$o->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'dot' => 'bg-gray-500'];
                                @endphp
                                <div class="inline-flex items-center gap-2 {{ $config['bg'] }} {{ $config['text'] }} px-3 py-2 rounded-lg font-semibold">
                                    <div class="w-2 h-2 {{ $config['dot'] }} rounded-full"></div>
                                    {{ ucfirst($o->status) }}
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <div class="text-2xl font-bold text-primary-600">
                                    {{ (int) floor(($o->total_millimes ?? 0)/1000) }} DT
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <div class="flex items-center justify-end gap-2">
                                    <!-- View Order -->
                                    <a href="{{ route('admin.orders.show', $o) }}" title="Voir détails"
                                       class="interactive p-2 bg-primary-100 hover:bg-primary-200 text-primary-600 rounded-lg transition-colors duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>

                                    <!-- Print Order -->
                                    <a href="{{ route('admin.orders.print', $o) }}" target="_blank" title="Imprimer"
                                       class="interactive p-2 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-lg transition-colors duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                        </svg>
                                    </a>

                                    <!-- Quick Status Change -->
                                    <div class="relative inline-block">
                                        <button type="button" onclick="toggleStatusMenu({{ $o->id }})" title="Changer statut"
                                                class="interactive p-2 bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-lg transition-colors duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </button>
                                        <div id="statusMenu{{ $o->id }}" class="hidden absolute right-0 top-full mt-2 w-48 bg-white border border-dark-200 rounded-xl shadow-premium-lg z-10">
                                            @foreach($statusOptions as $status)
                                                <button type="button" 
                                                        onclick="changeOrderStatus({{ $o->id }}, '{{ $status }}')"
                                                        class="w-full text-left px-4 py-2 text-sm hover:bg-dark-50 transition-colors duration-200 {{ $status === $o->status ? 'bg-primary-50 text-primary-700 font-semibold' : 'text-dark-700' }} {{ $loop->first ? 'rounded-t-xl' : '' }} {{ $loop->last ? 'rounded-b-xl' : '' }}">
                                                    {{ ucfirst($status) }}
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12">
                                <div class="text-center">
                                    <div class="w-20 h-20 bg-dark-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-10 h-10 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-dark-700 mb-2">Aucune commande trouvée</h3>
                                    <p class="text-dark-500 mb-6">
                                        @if($filters['q'] || $filters['status'] || $filters['city'] || $filters['date_from'] || $filters['date_to'])
                                            Aucune commande ne correspond à vos critères de recherche.
                                        @else
                                            Les nouvelles commandes apparaîtront ici.
                                        @endif
                                    </p>
                                    @if($filters['q'] || $filters['status'] || $filters['city'] || $filters['date_from'] || $filters['date_to'])
                                        <a href="{{ route('admin.orders.index') }}" 
                                           class="inline-flex items-center gap-2 px-6 py-3 bg-dark-100 hover:bg-dark-200 text-dark-700 font-semibold rounded-xl transition-colors duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                            </svg>
                                            Réinitialiser les filtres
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
            <div class="px-6 py-4 border-t border-dark-100 bg-dark-50">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-dark-600">
                        Affichage de {{ $orders->firstItem() }} à {{ $orders->lastItem() }} sur {{ $orders->total() }} commandes
                    </div>
                    <div class="flex items-center gap-2">
                        {{ $orders->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</form>

<!-- JavaScript for interactions -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select All checkbox functionality
    const selectAllCheckbox = document.getElementById('selectAll');
    const orderCheckboxes = document.querySelectorAll('.order-checkbox');
    const bulkActionsDiv = document.getElementById('bulkActions');
    const selectedCountSpan = document.getElementById('selectedCount');

    function updateBulkActions() {
        const checkedBoxes = document.querySelectorAll('.order-checkbox:checked');
        const count = checkedBoxes.length;
        
        if (count > 0) {
            bulkActionsDiv.style.display = 'block';
            selectedCountSpan.textContent = `${count} commande${count > 1 ? 's' : ''} sélectionnée${count > 1 ? 's' : ''}`;
        } else {
            bulkActionsDiv.style.display = 'none';
        }
    }

    selectAllCheckbox.addEventListener('change', function() {
        orderCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkActions();
    });

    orderCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateBulkActions();
            
            // Update select all checkbox state
            const allChecked = Array.from(orderCheckboxes).every(cb => cb.checked);
            const someChecked = Array.from(orderCheckboxes).some(cb => cb.checked);
            
            selectAllCheckbox.checked = allChecked;
            selectAllCheckbox.indeterminate = someChecked && !allChecked;
        });
    });

    // Close status menus when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.relative')) {
            document.querySelectorAll('[id^="statusMenu"]').forEach(menu => {
                menu.classList.add('hidden');
            });
        }
    });
});

// Filter by status from cards
function filterByStatus(status) {
    const statusFilter = document.getElementById('statusFilter');
    if (statusFilter) {
        statusFilter.value = status;
        statusFilter.form.submit();
    }
}

// Deselect all checkboxes
function deselectAll() {
    document.querySelectorAll('.order-checkbox').forEach(checkbox => {
        checkbox.checked = false;
    });
    document.getElementById('selectAll').checked = false;
    document.getElementById('selectAll').indeterminate = false;
    document.getElementById('bulkActions').style.display = 'none';
}

// Toggle status menu
function toggleStatusMenu(orderId) {
    const menu = document.getElementById(`statusMenu${orderId}`);
    
    // Close all other menus
    document.querySelectorAll('[id^="statusMenu"]').forEach(otherMenu => {
        if (otherMenu.id !== `statusMenu${orderId}`) {
            otherMenu.classList.add('hidden');
        }
    });
    
    // Toggle current menu
    menu.classList.toggle('hidden');
}

// Change order status
function changeOrderStatus(orderId, status) {
    if (confirm(`Confirmer le changement de statut vers "${status}" ?`)) {
        // Create form and submit
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/orders/${orderId}/status`;
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        form.innerHTML = `
            <input type="hidden" name="_token" value="${csrfToken}">
            <input type="hidden" name="_method" value="PATCH">
            <input type="hidden" name="status" value="${status}">
        `;
        
        document.body.appendChild(form);
        form.submit();
    }
    
    // Close menu
    document.getElementById(`statusMenu${orderId}`).classList.add('hidden');
}
</script>
@endsection
