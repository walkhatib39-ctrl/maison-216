@extends('layouts.admin')

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-dark-900">Commande #{{ $order->id }}</h1>
            <p class="text-dark-600 mt-1">Passée le {{ $order->created_at->format('d/m/Y à H:i') }}</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.orders.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-dark-100 hover:bg-dark-200 text-dark-700 font-medium rounded-xl transition-colors duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Retour aux commandes
            </a>
            <a href="{{ route('admin.orders.print', $order) }}" target="_blank"
               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition-colors duration-200 shadow-lg">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Imprimer
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

<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
    <!-- Informations principales -->
    <div class="xl:col-span-2 space-y-8">
        <!-- Informations client -->
        <div class="bg-white rounded-2xl border border-dark-100 shadow-premium">
            <div class="p-6 border-b border-dark-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-dark-900">Informations client</h3>
                        <p class="text-sm text-dark-600">Coordonnées et adresse de livraison</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-dark-700 mb-1">Nom complet</label>
                            <div class="flex items-center gap-2 p-3 bg-dark-50 rounded-lg">
                                <svg class="w-4 h-4 text-dark-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span class="font-medium text-dark-900">{{ $order->full_name }}</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-dark-700 mb-1">Téléphone principal</label>
                            <div class="flex items-center gap-2 p-3 bg-dark-50 rounded-lg">
                                <svg class="w-4 h-4 text-dark-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <span class="font-medium text-dark-900">{{ $order->phone }}</span>
                            </div>
                        </div>
                        @if($order->phone_alt)
                            <div>
                                <label class="block text-sm font-semibold text-dark-700 mb-1">Téléphone alternatif</label>
                                <div class="flex items-center gap-2 p-3 bg-dark-50 rounded-lg">
                                    <svg class="w-4 h-4 text-dark-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <span class="font-medium text-dark-900">{{ $order->phone_alt }}</span>
                                </div>
                            </div>
                        @endif
                        @if($order->email)
                            <div>
                                <label class="block text-sm font-semibold text-dark-700 mb-1">Email</label>
                                <div class="flex items-center gap-2 p-3 bg-dark-50 rounded-lg">
                                    <svg class="w-4 h-4 text-dark-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="font-medium text-dark-900">{{ $order->email }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-dark-700 mb-1">Ville</label>
                            <div class="flex items-center gap-2 p-3 bg-dark-50 rounded-lg">
                                <svg class="w-4 h-4 text-dark-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span class="font-medium text-dark-900">{{ $order->city }}</span>
                            </div>
                        </div>
                        @if($order->governorate)
                            <div>
                                <label class="block text-sm font-semibold text-dark-700 mb-1">Gouvernorat</label>
                                <div class="flex items-center gap-2 p-3 bg-dark-50 rounded-lg">
                                    <svg class="w-4 h-4 text-dark-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                    </svg>
                                    <span class="font-medium text-dark-900">{{ $order->governorate }}</span>
                                </div>
                            </div>
                        @endif
                        <div>
                            <label class="block text-sm font-semibold text-dark-700 mb-1">Adresse complète</label>
                            <div class="flex items-start gap-2 p-3 bg-dark-50 rounded-lg">
                                <svg class="w-4 h-4 text-dark-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                <span class="font-medium text-dark-900">{{ $order->address }}</span>
                            </div>
                        </div>
                        @if($order->postal_code)
                            <div>
                                <label class="block text-sm font-semibold text-dark-700 mb-1">Code postal</label>
                                <div class="flex items-center gap-2 p-3 bg-dark-50 rounded-lg">
                                    <svg class="w-4 h-4 text-dark-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                    <span class="font-medium text-dark-900">{{ $order->postal_code }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="mt-6 pt-6 border-t border-dark-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-dark-700 mb-1">Mode de paiement</label>
                            <div class="inline-flex items-center gap-2 bg-primary-100 text-primary-700 px-3 py-2 rounded-lg font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                {{ ucfirst($order->payment_method) }}
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-dark-700 mb-1">Date de commande</label>
                            <div class="inline-flex items-center gap-2 bg-dark-100 text-dark-700 px-3 py-2 rounded-lg font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $order->created_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Articles commandés -->
        <div class="bg-white rounded-2xl border border-dark-100 shadow-premium">
            <div class="p-6 border-b border-dark-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-dark-900">Articles commandés</h3>
                        <p class="text-sm text-dark-600">{{ $order->items->count() }} article{{ $order->items->count() > 1 ? 's' : '' }} dans cette commande</p>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-dark-50 to-dark-100 border-b border-dark-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-dark-700 uppercase tracking-wider">Produit</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-dark-700 uppercase tracking-wider">Prix unitaire</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-dark-700 uppercase tracking-wider">Quantité</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-dark-700 uppercase tracking-wider">Total ligne</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-dark-100">
                        @forelse($order->items as $item)
                            <tr class="hover:bg-dark-50 transition-colors duration-200">
                                <td class="px-6 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="relative">
                                            @if($item->product_main_image)
                                                <img src="{{ $item->product_main_image }}" alt="{{ $item->product_title }}"
                                                     class="h-16 w-16 object-cover rounded-xl border-2 border-dark-200">
                                            @else
                                                <div class="h-16 w-16 bg-gradient-to-br from-dark-100 to-dark-200 rounded-xl border-2 border-dark-200 flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="font-bold text-dark-900 text-lg">{{ $item->product_title }}</div>
                                            @if($item->product_sku)
                                                <div class="text-sm text-dark-600 mt-1 flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                                    </svg>
                                                    SKU: {{ $item->product_sku }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-6">
                                    <div class="text-xl font-bold text-primary-600">
                                        {{ (int) floor(($item->unit_price_millimes ?? 0)/1000) }} DT
                                    </div>
                                </td>
                                <td class="px-6 py-6">
                                    <div class="inline-flex items-center gap-2 bg-dark-100 text-dark-700 px-3 py-2 rounded-lg font-bold">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                        {{ $item->quantity }}
                                    </div>
                                </td>
                                <td class="px-6 py-6 text-right">
                                    <div class="text-2xl font-bold text-dark-900">
                                        {{ (int) floor(($item->line_total_millimes ?? 0)/1000) }} DT
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12">
                                    <div class="text-center">
                                        <div class="w-16 h-16 bg-dark-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <svg class="w-8 h-8 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                            </svg>
                                        </div>
                                        <h4 class="text-lg font-semibold text-dark-700 mb-2">Aucun article</h4>
                                        <p class="text-dark-500">Cette commande ne contient aucun article</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Note client -->
        @if($order->customer_note)
            <div class="bg-white rounded-2xl border border-dark-100 shadow-premium">
                <div class="p-6 border-b border-dark-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-dark-900">Note du client</h3>
                            <p class="text-sm text-dark-600">Message laissé lors de la commande</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                        <div class="text-dark-900 whitespace-pre-line">{{ $order->customer_note }}</div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Timeline historique des statuts -->
        <div class="bg-white rounded-2xl border border-dark-100 shadow-premium">
            <div class="p-6 border-b border-dark-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 110-16 8 8 0 010 16z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-dark-900">Historique des statuts</h3>
                        <p class="text-sm text-dark-600">Journal des changements avec notes et agent</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                @if($order->statusHistory->count())
                    <ol class="relative border-l-2 border-dark-100 ml-3">
                        @foreach($order->statusHistory as $log)
                            <li class="mb-6 ml-6">
                                <span class="absolute -left-[11px] flex items-center justify-center w-5 h-5 bg-emerald-500 rounded-full ring-4 ring-white"></span>
                                <div class="flex flex-wrap items-center gap-3">
                                    <span class="text-xs font-semibold text-dark-500 bg-dark-50 px-2 py-1 rounded">{{ $log->created_at->format('d/m/Y H:i') }}</span>
                                    <span class="text-sm font-bold text-emerald-700">{{ $log->status }}</span>
                                    @if($log->user)
                                        <span class="text-xs text-dark-500">par {{ $log->user->name }}</span>
                                    @endif
                                </div>
                                @if($log->note)
                                    <div class="mt-2 text-sm text-dark-800 bg-emerald-50 border border-emerald-100 rounded-xl p-3">
                                        {{ $log->note }}
                                    </div>
                                @endif
                            </li>
                        @endforeach
                    </ol>
                @else
                    <div class="text-sm text-dark-500">Aucun historique disponible pour l’instant.</div>
                @endif
            </div>
        </div>

    </div>

    <!-- Sidebar avec récap et actions -->
    <div class="space-y-8">
        <!-- Récapitulatif financier -->
        <div class="bg-white rounded-2xl border border-dark-100 shadow-premium">
            <div class="p-6 border-b border-dark-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-dark-900">Récapitulatif</h3>
                        <p class="text-sm text-dark-600">Total de la commande</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-dark-600">Sous-total produits</span>
                        <span class="font-semibold text-dark-900">{{ (int) floor(($order->subtotal_millimes ?? 0)/1000) }} DT</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-dark-600">Frais de livraison</span>
                        <span class="font-semibold text-dark-900">{{ (int) floor(($order->shipping_fee_millimes ?? 0)/1000) }} DT</span>
                    </div>
                    <div class="border-t border-dark-200 pt-4">
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-bold text-dark-900">Total</span>
                            <span class="text-2xl font-bold text-primary-600">{{ (int) floor(($order->total_millimes ?? 0)/1000) }} DT</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gestion statut et note admin -->
        <div class="bg-white rounded-2xl border border-dark-100 shadow-premium">
            <div class="p-6 border-b border-dark-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-dark-900">Gestion commande</h3>
                        <p class="text-sm text-dark-600">Statut et note admin</p>
                    </div>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="p-6">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <!-- Statut actuel -->
                    <div>
                        <label class="block text-sm font-semibold text-dark-700 mb-2">Statut actuel</label>
                        @php
                            $statusConfig = [
                                'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'dot' => 'bg-yellow-500'],
                                'processing' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'dot' => 'bg-blue-500'],
                                'shipped' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-800', 'dot' => 'bg-purple-500'],
                                'delivered' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'dot' => 'bg-green-500']
                            ];
                            $config = $statusConfig[$order->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'dot' => 'bg-gray-500'];
                        @endphp
                        <div class="inline-flex items-center gap-3 {{ $config['bg'] }} {{ $config['text'] }} px-4 py-3 rounded-xl font-semibold">
                            <div class="w-3 h-3 {{ $config['dot'] }} rounded-full"></div>
                            {{ ucfirst($order->status) }}
                        </div>
                    </div>

                    <!-- Changer statut -->
                    <div>
                        <label class="block text-sm font-semibold text-dark-700 mb-2">Nouveau statut</label>
                        <select name="status"
                                class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200">
                            @foreach($statusOptions as $status)
                                <option value="{{ $status }}" @selected($order->status === $status)>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-dark-500 mt-1">Choisir le nouveau statut de la commande</p>
                    </div>

                    <!-- Note admin -->
                    <div>
                        <label class="block text-sm font-semibold text-dark-700 mb-2">Note administrateur</label>
                        <textarea name="admin_note" rows="4"
                                  class="w-full px-4 py-3 border-2 border-dark-200 rounded-xl focus:border-primary-500 focus:ring-0 transition-colors duration-200"
                                  placeholder="Ajouter une note interne...">{{ old('admin_note', $order->admin_note) }}</textarea>
                        <p class="text-xs text-dark-500 mt-1">Note visible uniquement par les administrateurs</p>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between pt-4 border-t border-dark-100">
                        <button type="submit"
                                class="btn-premium inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-bold rounded-xl transition-all duration-200 shadow-premium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Mettre à jour
                        </button>

                        <!-- Supprimer commande -->
                        <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" class="inline-block"
                              onsubmit="return confirm('⚠️ Êtes-vous sûr de vouloir supprimer cette commande ?\n\n🗑️ Cette action est irréversible.\n📋 Commande #{{ $order->id }} - {{ $order->full_name }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="Supprimer la commande"
                                    class="inline-flex items-center gap-2 px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl transition-colors duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </form>
        </div>

        <!-- Statut visuel -->
        @php
            $statusConfig = [
                'pending' => ['color' => 'yellow', 'label' => 'En attente', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                'processing' => ['color' => 'blue', 'label' => 'En cours', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z'],
                'shipped' => ['color' => 'purple', 'label' => 'Expédiée', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
                'delivered' => ['color' => 'green', 'label' => 'Livrée', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z']
            ];
            $currentStatus = $statusConfig[$order->status] ?? ['color' => 'gray', 'label' => $order->status, 'icon' => 'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'];
        @endphp
        
        <div class="bg-gradient-to-br from-{{ $currentStatus['color'] }}-500 to-{{ $currentStatus['color'] }}-600 rounded-2xl p-6 text-white shadow-premium-lg">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $currentStatus['icon'] }}"/>
                    </svg>
                </div>
                <div>
                    <h4 class="text-xl font-bold">{{ $currentStatus['label'] }}</h4>
                    <p class="text-{{ $currentStatus['color'] }}-100 text-sm">Statut actuel de la commande</p>
                </div>
            </div>
            <div class="text-{{ $currentStatus['color'] }}-100 text-sm">
                Mis à jour le {{ $order->updated_at->format('d/m/Y à H:i') }}
            </div>
        </div>
    </div>
</div>
@endsection
