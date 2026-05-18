@extends('layouts.admin')

@section('content')
@php
    $groups = [
        ['title' => 'Livraison prévue aujourd’hui', 'orders' => $todayDeliveries, 'tone' => 'border-blue-200 bg-blue-50 text-blue-800'],
        ['title' => 'Commandes en retard', 'orders' => $lateOrders, 'tone' => 'border-rose-200 bg-rose-50 text-rose-800'],
        ['title' => 'Commandes sans acompte', 'orders' => $noDepositOrders, 'tone' => 'border-amber-200 bg-amber-50 text-amber-800'],
        ['title' => 'Prêtes à livrer', 'orders' => $readyOrders, 'tone' => 'border-purple-200 bg-purple-50 text-purple-800'],
        ['title' => 'Livrées avec reste à payer', 'orders' => $deliveredWithBalance, 'tone' => 'border-orange-200 bg-orange-50 text-orange-800'],
    ];
@endphp

<div class="space-y-6">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-[#171411]">À faire aujourd’hui</h1>
            <p class="mt-1 text-sm text-[#6a5a4c]">Livraisons, retards, acomptes et paiements à suivre.</p>
        </div>
        <div class="flex flex-col gap-2 sm:flex-row">
            <a href="{{ route('admin.workshop.clients.index') }}" class="inline-flex items-center justify-center rounded-xl border border-[#d8c7af] bg-white px-4 py-2.5 text-sm font-bold text-[#171411] hover:bg-[#fbf7f0]">Clients</a>
            <a href="{{ route('admin.workshop.orders.index') }}" class="inline-flex items-center justify-center rounded-xl border border-[#d8c7af] bg-white px-4 py-2.5 text-sm font-bold text-[#171411] hover:bg-[#fbf7f0]">Commandes</a>
            <a href="{{ route('admin.workshop.orders.create') }}" class="inline-flex items-center justify-center rounded-xl bg-[#171411] px-4 py-2.5 text-sm font-bold text-white hover:bg-[#a47834]">+ Ajouter commande</a>
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-5">
        @foreach($groups as $group)
            <a href="#group-{{ $loop->index }}" class="rounded-2xl border border-[#eadfce] bg-white p-5 shadow-sm transition hover:border-[#d5b170] hover:shadow-md">
                <div class="text-sm font-semibold text-[#6a5a4c]">{{ $group['title'] }}</div>
                <div class="mt-2 text-3xl font-extrabold text-[#171411]">{{ $group['orders']->count() }}</div>
            </a>
        @endforeach
    </div>

    <div class="grid gap-6 xl:grid-cols-2">
        @foreach($groups as $group)
            <section id="group-{{ $loop->index }}" class="overflow-hidden rounded-2xl border border-[#eadfce] bg-white shadow-sm">
                <div class="flex items-center justify-between gap-3 border-b border-[#eadfce] bg-[#fbf7f0] px-5 py-4">
                    <h2 class="text-base font-extrabold text-[#171411]">{{ $group['title'] }}</h2>
                    <span class="rounded-full border px-2.5 py-1 text-xs font-bold {{ $group['tone'] }}">{{ $group['orders']->count() }}</span>
                </div>
                <div class="divide-y divide-[#f0e7da]">
                    @forelse($group['orders'] as $order)
                        <a href="{{ route('admin.workshop.orders.show', $order) }}" class="block px-5 py-4 transition hover:bg-[#fbf7f0]">
                            <div class="flex items-start justify-between gap-4">
                                <div class="min-w-0">
                                    <div class="truncate font-bold text-[#171411]">{{ $order->title }}</div>
                                    <div class="mt-1 truncate text-sm text-[#6a5a4c]">{{ $order->client?->name ?: 'Client supprimé' }}{{ $order->client?->phone ? ' · ' . $order->client->phone : '' }}</div>
                                    <div class="mt-2 flex flex-wrap gap-2">
                                        <span class="rounded-full bg-[#f4ead8] px-2.5 py-1 text-xs font-bold text-[#8e6322]">{{ $order->categoryLabel() }}</span>
                                        <span class="rounded-full bg-[#f7f4ee] px-2.5 py-1 text-xs font-bold text-[#5f5146]">{{ $order->status }}</span>
                                        @if($order->remaining_amount > 0)
                                            <span class="rounded-full bg-rose-50 px-2.5 py-1 text-xs font-bold text-rose-700">Reste {{ $order->remainingAmountDisplay() }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="whitespace-nowrap text-xs font-semibold {{ $order->isLate() ? 'text-rose-700' : 'text-[#6a5a4c]' }}">{{ optional($order->delivery_due_at)->format('d/m/Y') ?: '-' }}</div>
                            </div>
                        </a>
                    @empty
                        <div class="px-5 py-10 text-center text-sm font-semibold text-[#6a5a4c]">Rien à traiter ici.</div>
                    @endforelse
                </div>
            </section>
        @endforeach
    </div>
</div>
@endsection
