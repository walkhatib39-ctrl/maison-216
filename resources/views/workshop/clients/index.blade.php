@extends('layouts.workshop')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-[#171411]">Clients atelier</h1>
            <p class="mt-1 text-sm text-[#6a5a4c]">Carnet interne. Aucun lien avec les formulaires publics.</p>
        </div>
        <div class="flex flex-col gap-2 sm:flex-row">
            <a href="{{ route('workshop.orders.create') }}" class="inline-flex items-center justify-center rounded-xl border border-[#d8c7af] bg-white px-4 py-2.5 text-sm font-bold text-[#171411] transition hover:bg-[#fbf7f0]">
                + Ajouter commande
            </a>
            <a href="{{ route('workshop.clients.create') }}" class="inline-flex items-center justify-center rounded-xl bg-[#171411] px-4 py-2.5 text-sm font-bold text-white transition hover:bg-[#a47834]">
                + Ajouter client
            </a>
        </div>
    </div>

    @if(session('status'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">{{ session('status') }}</div>
    @endif

    <form method="GET" class="rounded-2xl border border-[#eadfce] bg-white p-4 shadow-sm">
        <div class="grid gap-3 md:grid-cols-[1fr_220px_auto]">
            <label>
                <span class="mb-1 block text-xs font-bold uppercase tracking-wide text-[#6a5a4c]">Recherche</span>
                <input name="q" value="{{ $filters['q'] }}" class="w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4" placeholder="Nom, téléphone, ville">
            </label>
            <label>
                <span class="mb-1 block text-xs font-bold uppercase tracking-wide text-[#6a5a4c]">Type client</span>
                <select name="client_type" class="w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4">
                    <option value="">Tous</option>
                    @foreach($clientTypes as $value => $label)
                        <option value="{{ $value }}" @selected($filters['client_type'] === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </label>
            <div class="flex items-end">
                <button class="w-full rounded-xl border border-[#d8c7af] bg-[#fbf7f0] px-4 py-2.5 text-sm font-bold text-[#171411] transition hover:bg-white md:w-auto">Filtrer</button>
            </div>
        </div>
    </form>

    <section class="overflow-hidden rounded-2xl border border-[#eadfce] bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-[#eadfce] text-sm">
                <thead class="bg-[#f7f4ee] text-left text-xs font-bold uppercase tracking-wide text-[#6a5a4c]">
                    <tr>
                        <th class="px-5 py-3">Client</th>
                        <th class="px-5 py-3">Contact</th>
                        <th class="px-5 py-3">Ville</th>
                        <th class="px-5 py-3">Type</th>
                        <th class="px-5 py-3">Commandes</th>
                        <th class="px-5 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f0e7da]">
                    @forelse($clients as $client)
                        <tr class="transition hover:bg-[#fbf7f0]">
                            <td class="px-5 py-4">
                                <div class="font-bold text-[#171411]">{{ $client->name }}</div>
                                @if($client->internal_notes)
                                    <div class="mt-1 max-w-xs truncate text-xs text-[#6a5a4c]">{{ $client->internal_notes }}</div>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-[#6a5a4c]">
                                <div>{{ $client->phone ?: '-' }}</div>
                                <div class="text-xs">{{ $client->whatsapp ?: '' }}</div>
                            </td>
                            <td class="px-5 py-4 text-[#6a5a4c]">{{ $client->city ?: '-' }}</td>
                            <td class="px-5 py-4">
                                <span class="rounded-full bg-[#f4ead8] px-2.5 py-1 text-xs font-bold text-[#8e6322]">{{ $client->clientTypeLabel() }}</span>
                            </td>
                            <td class="px-5 py-4 font-bold text-[#171411]">{{ $client->orders_count }}</td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('workshop.clients.show', $client) }}" class="rounded-xl border border-[#d8c7af] bg-white px-3 py-2 text-xs font-bold text-[#171411] hover:bg-[#fbf7f0]">Voir</a>
                                    <a href="{{ route('workshop.clients.edit', $client) }}" class="rounded-xl border border-[#d8c7af] bg-white px-3 py-2 text-xs font-bold text-[#171411] hover:bg-[#fbf7f0]">Modifier</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-10 text-center text-sm font-semibold text-[#6a5a4c]">Aucun client pour ce filtre.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    {{ $clients->links() }}
</div>
@endsection
