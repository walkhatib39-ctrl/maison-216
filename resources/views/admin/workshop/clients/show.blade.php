@extends('layouts.admin')

@section('content')
@php
    $statusColor = [
        'Nouvelle commande' => 'bg-blue-50 text-blue-800',
        'Mesure à faire' => 'bg-amber-50 text-amber-800',
        'Prix à valider' => 'bg-orange-50 text-orange-800',
        'Acompte reçu' => 'bg-emerald-50 text-emerald-800',
        'En production' => 'bg-indigo-50 text-indigo-800',
        'Prêt à livrer' => 'bg-purple-50 text-purple-800',
        'Livré' => 'bg-sky-50 text-sky-800',
        'Installé' => 'bg-teal-50 text-teal-800',
        'Clôturé' => 'bg-slate-100 text-slate-700',
        'Annulé' => 'bg-rose-50 text-rose-800',
    ];
@endphp

<div class="space-y-6">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
        <div>
            <a href="{{ route('admin.workshop.clients.index') }}" class="text-sm font-bold text-[#8e6322] hover:text-[#171411]">Retour aux clients</a>
            <h1 class="mt-2 text-2xl font-extrabold tracking-tight text-[#171411]">{{ $client->name }}</h1>
            <p class="mt-1 text-sm text-[#6a5a4c]">{{ $client->clientTypeLabel() }}{{ $client->city ? ' · ' . $client->city : '' }}</p>
        </div>
        <div class="flex flex-col gap-2 sm:flex-row">
            <a href="{{ route('admin.workshop.clients.edit', $client) }}" class="inline-flex items-center justify-center rounded-xl border border-[#d8c7af] bg-white px-4 py-2.5 text-sm font-bold text-[#171411] hover:bg-[#fbf7f0]">Modifier</a>
            <a href="{{ route('admin.workshop.orders.create', ['client_id' => $client->id]) }}" class="inline-flex items-center justify-center rounded-xl bg-[#171411] px-4 py-2.5 text-sm font-bold text-white hover:bg-[#a47834]">+ Ajouter commande</a>
        </div>
    </div>

    @if(session('status'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">{{ session('status') }}</div>
    @endif

    <div class="grid gap-6 lg:grid-cols-[0.72fr_1.28fr]">
        <section class="rounded-2xl border border-[#eadfce] bg-white p-6 shadow-sm">
            <h2 class="text-base font-extrabold text-[#171411]">Fiche client</h2>
            <dl class="mt-5 space-y-4 text-sm">
                <div><dt class="font-bold text-[#6a5a4c]">Téléphone</dt><dd class="mt-1 text-[#171411]">{{ $client->phone ?: '-' }}</dd></div>
                <div><dt class="font-bold text-[#6a5a4c]">WhatsApp</dt><dd class="mt-1 text-[#171411]">{{ $client->whatsapp ?: '-' }}</dd></div>
                <div><dt class="font-bold text-[#6a5a4c]">Adresse</dt><dd class="mt-1 whitespace-pre-line text-[#171411]">{{ $client->address ?: '-' }}</dd></div>
                <div><dt class="font-bold text-[#6a5a4c]">Notes internes</dt><dd class="mt-1 whitespace-pre-line text-[#171411]">{{ $client->internal_notes ?: '-' }}</dd></div>
            </dl>
        </section>

        <section class="overflow-hidden rounded-2xl border border-[#eadfce] bg-white shadow-sm">
            <div class="flex items-center justify-between gap-3 border-b border-[#eadfce] bg-[#fbf7f0] px-5 py-4">
                <h2 class="text-base font-extrabold text-[#171411]">Commandes du client</h2>
                <span class="text-sm font-bold text-[#6a5a4c]">{{ $client->orders->count() }}</span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-[#eadfce] text-sm">
                    <thead class="bg-[#f7f4ee] text-left text-xs font-bold uppercase tracking-wide text-[#6a5a4c]">
                        <tr>
                            <th class="px-5 py-3">Commande</th>
                            <th class="px-5 py-3">Montant</th>
                            <th class="px-5 py-3">Reste</th>
                            <th class="px-5 py-3">Statut</th>
                            <th class="px-5 py-3">Livraison</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f0e7da]">
                        @forelse($client->orders as $order)
                            <tr class="hover:bg-[#fbf7f0]">
                                <td class="px-5 py-4">
                                    <a href="{{ route('admin.workshop.orders.show', $order) }}" class="font-bold text-[#171411] hover:text-[#8e6322]">{{ $order->title }}</a>
                                    <div class="mt-1 text-xs text-[#6a5a4c]">{{ $order->categoryLabel() }}</div>
                                </td>
                                <td class="whitespace-nowrap px-5 py-4 font-bold text-[#171411]">{{ $order->totalAmountDisplay() }}</td>
                                <td class="whitespace-nowrap px-5 py-4 font-bold {{ $order->remaining_amount > 0 ? 'text-rose-700' : 'text-emerald-700' }}">{{ $order->remainingAmountDisplay() }}</td>
                                <td class="px-5 py-4"><span class="whitespace-nowrap rounded-full px-2.5 py-1 text-xs font-bold {{ $statusColor[$order->status] ?? 'bg-slate-100 text-slate-700' }}">{{ $order->status }}</span></td>
                                <td class="whitespace-nowrap px-5 py-4 text-[#6a5a4c]">{{ optional($order->delivery_due_at)->format('d/m/Y') ?: '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-5 py-10 text-center text-sm font-semibold text-[#6a5a4c]">Aucune commande.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>
@endsection
