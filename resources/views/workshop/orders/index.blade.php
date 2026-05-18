@extends('layouts.workshop')

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
            <h1 class="text-2xl font-extrabold tracking-tight text-[#171411]">Commandes atelier</h1>
            <p class="mt-1 text-sm text-[#6a5a4c]">Commandes internes ajoutées manuellement.</p>
        </div>
        <div class="flex flex-col gap-2 sm:flex-row">
            <a href="{{ route('workshop.orders.export', request()->query()) }}" class="inline-flex items-center justify-center rounded-xl border border-[#d8c7af] bg-white px-4 py-2.5 text-sm font-bold text-[#171411] transition hover:bg-[#fbf7f0]">Export Excel</a>
            <a href="{{ route('workshop.clients.index') }}" class="inline-flex items-center justify-center rounded-xl border border-[#d8c7af] bg-white px-4 py-2.5 text-sm font-bold text-[#171411] transition hover:bg-[#fbf7f0]">Clients</a>
            <a href="{{ route('workshop.orders.create') }}" class="inline-flex items-center justify-center rounded-xl bg-[#171411] px-4 py-2.5 text-sm font-bold text-white transition hover:bg-[#a47834]">+ Ajouter commande</a>
        </div>
    </div>

    @if(session('status'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">{{ session('status') }}</div>
    @endif

    <form method="GET" class="rounded-2xl border border-[#eadfce] bg-white p-4 shadow-sm">
        <div class="grid gap-3 xl:grid-cols-[1fr_210px_180px_170px_170px_auto]">
            <label>
                <span class="mb-1 block text-xs font-bold uppercase tracking-wide text-[#6a5a4c]">Recherche</span>
                <input name="q" value="{{ $filters['q'] }}" class="w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4" placeholder="Client, téléphone, commande">
            </label>
            <label>
                <span class="mb-1 block text-xs font-bold uppercase tracking-wide text-[#6a5a4c]">Client</span>
                <select name="client_id" class="w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4">
                    <option value="">Tous</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" @selected((string) $client->id === $filters['client_id'])>{{ $client->name }}</option>
                    @endforeach
                </select>
            </label>
            <label>
                <span class="mb-1 block text-xs font-bold uppercase tracking-wide text-[#6a5a4c]">Statut</span>
                <select name="status" class="w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4">
                    <option value="">Tous</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status }}" @selected($filters['status'] === $status)>{{ $status }}</option>
                    @endforeach
                </select>
            </label>
            <label>
                <span class="mb-1 block text-xs font-bold uppercase tracking-wide text-[#6a5a4c]">Catégorie</span>
                <select name="category" class="w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4">
                    <option value="">Toutes</option>
                    @foreach($categories as $value => $label)
                        <option value="{{ $value }}" @selected($filters['category'] === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </label>
            <label>
                <span class="mb-1 block text-xs font-bold uppercase tracking-wide text-[#6a5a4c]">Livraison</span>
                <input type="date" name="delivery_due_at" value="{{ $filters['delivery_due_at'] }}" class="w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4">
            </label>
            <div class="flex items-end">
                <button class="w-full rounded-xl border border-[#d8c7af] bg-[#fbf7f0] px-4 py-2.5 text-sm font-bold text-[#171411] transition hover:bg-white xl:w-auto">Filtrer</button>
            </div>
        </div>
        <div class="mt-4 flex flex-wrap gap-3">
            <label class="inline-flex items-center gap-2 rounded-xl border border-[#eadfce] bg-[#fbf7f0] px-3 py-2 text-sm font-bold text-[#171411]">
                <input type="checkbox" name="balance_due" value="1" @checked($filters['balance_due']) class="rounded border-[#d8c7af] text-[#b88a3b] focus:ring-[#b88a3b]">
                Reste à payer
            </label>
            <label class="inline-flex items-center gap-2 rounded-xl border border-[#eadfce] bg-[#fbf7f0] px-3 py-2 text-sm font-bold text-[#171411]">
                <input type="checkbox" name="overdue" value="1" @checked($filters['overdue']) class="rounded border-[#d8c7af] text-[#b88a3b] focus:ring-[#b88a3b]">
                En retard
            </label>
            <a href="{{ route('workshop.orders.index') }}" class="inline-flex items-center rounded-xl px-3 py-2 text-sm font-bold text-[#8e6322] hover:text-[#171411]">Réinitialiser</a>
        </div>
    </form>

    <section class="overflow-hidden rounded-2xl border border-[#eadfce] bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-[#eadfce] text-sm">
                <thead class="bg-[#f7f4ee] text-left text-xs font-bold uppercase tracking-wide text-[#6a5a4c]">
                    <tr>
                        <th class="px-5 py-3">Image</th>
                        <th class="px-5 py-3">Client</th>
                        <th class="px-5 py-3">Commande</th>
                        <th class="px-5 py-3">Catégorie</th>
                        <th class="px-5 py-3">Total</th>
                        <th class="px-5 py-3">Acompte</th>
                        <th class="px-5 py-3">Reste</th>
                        <th class="px-5 py-3">Statut</th>
                        <th class="px-5 py-3">Livraison</th>
                        <th class="px-5 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f0e7da]">
                    @forelse($orders as $order)
                        <tr class="transition hover:bg-[#fbf7f0]">
                            <td class="px-5 py-4">
                                @if($order->coverFile)
                                    <a href="{{ $order->coverFile->fileUrl() }}" target="_blank" class="block h-16 w-20 overflow-hidden rounded-2xl border border-[#eadfce] bg-[#f4ead8] shadow-sm">
                                        <img src="{{ $order->coverFile->fileUrl() }}" alt="{{ $order->coverFile->original_name }}" class="h-full w-full object-cover">
                                    </a>
                                @else
                                    <div class="flex h-16 w-20 items-center justify-center rounded-2xl border border-dashed border-[#d8c7af] bg-[#fbf7f0] text-[10px] font-bold uppercase tracking-wide text-[#9a8a78]">
                                        Sans image
                                    </div>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <div class="font-bold text-[#171411]">{{ $order->client?->name ?: 'Client supprimé' }}</div>
                                <div class="mt-1 text-xs text-[#6a5a4c]">{{ $order->client?->phone ?: $order->client?->whatsapp ?: '-' }}</div>
                            </td>
                            <td class="px-5 py-4">
                                <a href="{{ route('workshop.orders.show', $order) }}" class="font-bold text-[#171411] hover:text-[#8e6322]">{{ $order->title }}</a>
                                @if($order->files_count ?? false)
                                    <div class="mt-1 text-xs text-[#6a5a4c]">{{ $order->files_count }} fichier(s)</div>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-[#6a5a4c]">{{ $order->categoryLabel() }}</td>
                            <td class="whitespace-nowrap px-5 py-4 font-bold text-[#171411]">{{ $order->totalAmountDisplay() }}</td>
                            <td class="whitespace-nowrap px-5 py-4 text-[#6a5a4c]">{{ $order->depositAmountDisplay() }}</td>
                            <td class="whitespace-nowrap px-5 py-4 font-bold {{ $order->remaining_amount > 0 ? 'text-rose-700' : 'text-emerald-700' }}">{{ $order->remainingAmountDisplay() }}</td>
                            <td class="px-5 py-4"><span class="whitespace-nowrap rounded-full px-2.5 py-1 text-xs font-bold {{ $statusColor[$order->status] ?? 'bg-slate-100 text-slate-700' }}">{{ $order->status }}</span></td>
                            <td class="whitespace-nowrap px-5 py-4 {{ $order->isLate() ? 'font-bold text-rose-700' : 'text-[#6a5a4c]' }}">{{ optional($order->delivery_due_at)->format('d/m/Y') ?: '-' }}</td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('workshop.orders.show', $order) }}" class="rounded-xl border border-[#d8c7af] bg-white px-3 py-2 text-xs font-bold text-[#171411] hover:bg-[#fbf7f0]">Voir</a>
                                    <a href="{{ route('workshop.orders.edit', $order) }}" class="rounded-xl border border-[#d8c7af] bg-white px-3 py-2 text-xs font-bold text-[#171411] hover:bg-[#fbf7f0]">Modifier</a>
                                    <form method="POST" action="{{ route('workshop.orders.destroy', $order) }}" onsubmit="return confirm('Supprimer cette commande ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-xl border border-rose-200 bg-rose-50 px-3 py-2 text-xs font-bold text-rose-700 hover:bg-rose-100">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-5 py-10 text-center text-sm font-semibold text-[#6a5a4c]">Aucune commande pour ce filtre.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    {{ $orders->links() }}
</div>
@endsection
