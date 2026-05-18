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
            <a href="{{ route('admin.workshop.orders.index') }}" class="text-sm font-bold text-[#8e6322] hover:text-[#171411]">Retour aux commandes</a>
            <h1 class="mt-2 text-2xl font-extrabold tracking-tight text-[#171411]">{{ $order->title }}</h1>
            <p class="mt-1 text-sm text-[#6a5a4c]">{{ $order->client?->name ?: 'Client supprimé' }} · {{ $order->categoryLabel() }}</p>
        </div>
        <div class="flex flex-col gap-2 sm:flex-row">
            <a href="{{ route('admin.workshop.orders.edit', $order) }}" class="inline-flex items-center justify-center rounded-xl bg-[#171411] px-4 py-2.5 text-sm font-bold text-white hover:bg-[#a47834]">Modifier</a>
        </div>
    </div>

    @if(session('status'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">{{ session('status') }}</div>
    @endif

    <div class="grid gap-4 md:grid-cols-4">
        <div class="rounded-2xl border border-[#eadfce] bg-white p-5 shadow-sm">
            <div class="text-sm font-semibold text-[#6a5a4c]">Montant total</div>
            <div class="mt-2 text-3xl font-extrabold text-[#171411]">{{ $order->totalAmountDisplay() }}</div>
        </div>
        <div class="rounded-2xl border border-[#eadfce] bg-white p-5 shadow-sm">
            <div class="text-sm font-semibold text-[#6a5a4c]">Acompte reçu</div>
            <div class="mt-2 text-3xl font-extrabold text-[#171411]">{{ $order->depositAmountDisplay() }}</div>
        </div>
        <div class="rounded-2xl border border-[#eadfce] bg-white p-5 shadow-sm">
            <div class="text-sm font-semibold text-[#6a5a4c]">Reste à payer</div>
            <div class="mt-2 text-3xl font-extrabold {{ $order->remaining_amount > 0 ? 'text-rose-700' : 'text-emerald-700' }}">{{ $order->remainingAmountDisplay() }}</div>
        </div>
        <div class="rounded-2xl border border-[#eadfce] bg-white p-5 shadow-sm">
            <div class="text-sm font-semibold text-[#6a5a4c]">Statut</div>
            <div class="mt-3"><span class="inline-flex rounded-full px-3 py-1.5 text-sm font-bold {{ $statusColor[$order->status] ?? 'bg-slate-100 text-slate-700' }}">{{ $order->status }}</span></div>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-[0.72fr_1.28fr]">
        <aside class="space-y-6">
            <section class="rounded-2xl border border-[#eadfce] bg-white p-6 shadow-sm">
                <h2 class="text-base font-extrabold text-[#171411]">Client</h2>
                @if($order->client)
                    <div class="mt-5 space-y-3 text-sm">
                        <div class="font-bold text-[#171411]">{{ $order->client->name }}</div>
                        <div class="text-[#6a5a4c]">{{ $order->client->phone ?: '-' }}</div>
                        <div class="text-[#6a5a4c]">{{ $order->client->whatsapp ?: '-' }}</div>
                        <div class="text-[#6a5a4c]">{{ $order->client->city ?: '-' }}</div>
                        <a href="{{ route('admin.workshop.clients.show', $order->client) }}" class="inline-flex rounded-xl border border-[#d8c7af] bg-[#fbf7f0] px-3 py-2 text-xs font-bold text-[#171411] hover:bg-white">Voir fiche client</a>
                    </div>
                @else
                    <div class="mt-5 text-sm font-semibold text-[#6a5a4c]">Client supprimé.</div>
                @endif
            </section>

            <section class="rounded-2xl border border-[#eadfce] bg-white p-6 shadow-sm">
                <h2 class="text-base font-extrabold text-[#171411]">Dates</h2>
                <dl class="mt-5 space-y-4 text-sm">
                    <div><dt class="font-bold text-[#6a5a4c]">Date de commande</dt><dd class="mt-1 text-[#171411]">{{ optional($order->ordered_at)->format('d/m/Y') ?: '-' }}</dd></div>
                    <div><dt class="font-bold text-[#6a5a4c]">Livraison prévue</dt><dd class="mt-1 {{ $order->isLate() ? 'font-bold text-rose-700' : 'text-[#171411]' }}">{{ optional($order->delivery_due_at)->format('d/m/Y') ?: '-' }}</dd></div>
                </dl>
            </section>
        </aside>

        <div class="space-y-6">
            <section class="rounded-2xl border border-[#eadfce] bg-white p-6 shadow-sm">
                <h2 class="text-base font-extrabold text-[#171411]">Détails commande</h2>
                <dl class="mt-5 grid gap-5 md:grid-cols-2 text-sm">
                    <div class="md:col-span-2"><dt class="font-bold text-[#6a5a4c]">Description</dt><dd class="mt-1 whitespace-pre-line text-[#171411]">{{ $order->description ?: '-' }}</dd></div>
                    <div><dt class="font-bold text-[#6a5a4c]">Dimensions</dt><dd class="mt-1 whitespace-pre-line text-[#171411]">{{ $order->dimensions ?: '-' }}</dd></div>
                    <div><dt class="font-bold text-[#6a5a4c]">Couleur / finition</dt><dd class="mt-1 whitespace-pre-line text-[#171411]">{{ $order->finish ?: '-' }}</dd></div>
                    <div class="md:col-span-2"><dt class="font-bold text-[#6a5a4c]">Notes internes</dt><dd class="mt-1 whitespace-pre-line text-[#171411]">{{ $order->internal_notes ?: '-' }}</dd></div>
                </dl>
            </section>

            <section class="overflow-hidden rounded-2xl border border-[#eadfce] bg-white shadow-sm">
                <div class="flex items-center justify-between gap-3 border-b border-[#eadfce] bg-[#fbf7f0] px-5 py-4">
                    <h2 class="text-base font-extrabold text-[#171411]">Fichiers joints</h2>
                    <a href="{{ route('admin.workshop.orders.edit', $order) }}" class="text-sm font-bold text-[#8e6322] hover:text-[#171411]">Ajouter</a>
                </div>
                <div class="grid gap-3 p-5 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse($order->files as $file)
                        <div class="overflow-hidden rounded-2xl border border-[#eadfce] bg-[#fbf7f0]">
                            @if($file->isImage())
                                <a href="{{ $file->fileUrl() }}" target="_blank"><img src="{{ $file->fileUrl() }}" alt="{{ $file->original_name }}" class="h-40 w-full object-cover"></a>
                            @else
                                <a href="{{ $file->fileUrl() }}" target="_blank" class="flex h-40 items-center justify-center bg-white px-4 text-center text-sm font-bold text-[#171411]">{{ $file->original_name }}</a>
                            @endif
                            <div class="p-3">
                                <div class="truncate text-xs font-bold text-[#171411]">{{ $file->fileTypeLabel() }}</div>
                                <div class="mt-1 truncate text-xs text-[#6a5a4c]">{{ $file->original_name }}</div>
                                <form method="POST" action="{{ route('admin.workshop.orders.files.destroy', [$order, $file]) }}" class="mt-3" onsubmit="return confirm('Supprimer ce fichier ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-xs font-bold text-rose-700">Supprimer</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-[#eadfce] bg-[#fbf7f0] p-5 text-sm font-semibold text-[#6a5a4c] sm:col-span-2 lg:col-span-3">Aucun fichier joint.</div>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
