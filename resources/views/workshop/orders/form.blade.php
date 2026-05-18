@extends('layouts.workshop')

@section('content')
@php
    $isEdit = $order->exists;
    $dateValue = function ($value) {
        return $value ? \Illuminate\Support\Carbon::parse($value)->format('Y-m-d') : '';
    };
@endphp

<div class="mx-auto max-w-6xl space-y-6">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
        <div>
            <a href="{{ route('workshop.orders.index') }}" class="text-sm font-bold text-[#8e6322] hover:text-[#171411]">Retour aux commandes</a>
            <h1 class="mt-2 text-2xl font-extrabold tracking-tight text-[#171411]">{{ $isEdit ? 'Modifier la commande' : 'Ajouter commande' }}</h1>
            <p class="mt-1 text-sm text-[#6a5a4c]">Commande interne atelier. Aucun lien avec le site public.</p>
        </div>
        <a href="{{ route('workshop.clients.create') }}" class="inline-flex items-center justify-center rounded-xl border border-[#d8c7af] bg-white px-4 py-2.5 text-sm font-bold text-[#171411] transition hover:bg-[#fbf7f0]">+ Ajouter client</a>
    </div>

    @if($errors->any())
        <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-800">
            Corrigez les champs signalés.
        </div>
    @endif

    <form method="POST" action="{{ $isEdit ? route('workshop.orders.update', $order) : route('workshop.orders.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div class="grid gap-6 lg:grid-cols-[1fr_0.78fr]">
            <div class="space-y-6">
                <section class="rounded-2xl border border-[#eadfce] bg-white p-6 shadow-sm">
                    <h2 class="text-base font-extrabold text-[#171411]">Commande</h2>
                    <div class="mt-5 grid gap-4 md:grid-cols-2">
                        <label class="block md:col-span-2">
                            <span class="text-sm font-bold text-[#171411]">Client lié *</span>
                            <select name="workshop_client_id" required class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4">
                                <option value="">Sélectionner un client</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" @selected((string) old('workshop_client_id', $order->workshop_client_id) === (string) $client->id)>
                                        {{ $client->name }}{{ $client->phone ? ' · ' . $client->phone : '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('workshop_client_id')<span class="mt-1 block text-sm text-rose-700">{{ $message }}</span>@enderror
                        </label>

                        <label class="block md:col-span-2">
                            <span class="text-sm font-bold text-[#171411]">Titre de la commande *</span>
                            <input name="title" value="{{ old('title', $order->title) }}" required class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4" placeholder="Dressing chambre, comptoir pharmacie, pergola...">
                            @error('title')<span class="mt-1 block text-sm text-rose-700">{{ $message }}</span>@enderror
                        </label>

                        <label class="block">
                            <span class="text-sm font-bold text-[#171411]">Catégorie *</span>
                            <select name="category" required class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4">
                                @foreach($categories as $value => $label)
                                    <option value="{{ $value }}" @selected(old('category', $order->category) === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </label>

                        <label class="block">
                            <span class="text-sm font-bold text-[#171411]">Statut *</span>
                            <select name="status" required class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4">
                                @foreach($statuses as $status)
                                    <option value="{{ $status }}" @selected(old('status', $order->status) === $status)>{{ $status }}</option>
                                @endforeach
                            </select>
                        </label>

                        <label class="block md:col-span-2">
                            <span class="text-sm font-bold text-[#171411]">Description</span>
                            <textarea name="description" rows="4" class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4" placeholder="Détails de la commande, besoins client, contraintes...">{{ old('description', $order->description) }}</textarea>
                        </label>

                        <label class="block">
                            <span class="text-sm font-bold text-[#171411]">Dimensions</span>
                            <textarea name="dimensions" rows="4" class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4" placeholder="Largeur, hauteur, profondeur, quantités...">{{ old('dimensions', $order->dimensions) }}</textarea>
                        </label>

                        <label class="block">
                            <span class="text-sm font-bold text-[#171411]">Couleur / finition</span>
                            <textarea name="finish" rows="4" class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4" placeholder="RAL, bois, MDF, thermolaquage...">{{ old('finish', $order->finish) }}</textarea>
                        </label>
                    </div>
                </section>

                <section class="rounded-2xl border border-[#eadfce] bg-white p-6 shadow-sm">
                    <h2 class="text-base font-extrabold text-[#171411]">Fichiers joints</h2>
                    <div class="mt-5 grid gap-4 md:grid-cols-[220px_1fr]">
                        <label class="block">
                            <span class="text-sm font-bold text-[#171411]">Type des fichiers</span>
                            <select name="attachment_type" class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4">
                                @foreach($fileTypes as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label class="block">
                            <span class="text-sm font-bold text-[#171411]">Ajouter photos, plans, croquis</span>
                            <input type="file" name="attachments[]" multiple class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4">
                            <span class="mt-1 block text-xs font-semibold text-[#6a5a4c]">Images, PDF, plans ou documents. Taille max 20 Mo par fichier.</span>
                            @error('attachments.*')<span class="mt-1 block text-sm text-rose-700">{{ $message }}</span>@enderror
                        </label>
                    </div>

                    @if($isEdit && $order->files->isNotEmpty())
                        <div class="mt-6 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach($order->files as $file)
                                <div class="overflow-hidden rounded-2xl border border-[#eadfce] bg-[#fbf7f0]">
                                    @if($file->isImage())
                                        <a href="{{ $file->fileUrl() }}" target="_blank"><img src="{{ $file->fileUrl() }}" alt="{{ $file->original_name }}" class="h-36 w-full object-cover"></a>
                                    @else
                                        <a href="{{ $file->fileUrl() }}" target="_blank" class="flex h-36 items-center justify-center bg-white px-4 text-center text-sm font-bold text-[#171411]">{{ $file->original_name }}</a>
                                    @endif
                                    <div class="p-3">
                                        <div class="truncate text-xs font-bold text-[#171411]">{{ $file->fileTypeLabel() }}</div>
                                        <div class="mt-1 truncate text-xs text-[#6a5a4c]">{{ $file->original_name }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </section>
            </div>

            <aside class="space-y-6">
                <section class="rounded-2xl border border-[#eadfce] bg-white p-6 shadow-sm">
                    <h2 class="text-base font-extrabold text-[#171411]">Paiement</h2>
                    <div class="mt-5 grid gap-4">
                        <label class="block">
                            <span class="text-sm font-bold text-[#171411]">Montant total</span>
                            <input name="total_amount" value="{{ old('total_amount', $order->total_amount) }}" inputmode="decimal" class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4" placeholder="0">
                            @error('total_amount')<span class="mt-1 block text-sm text-rose-700">{{ $message }}</span>@enderror
                        </label>
                        <label class="block">
                            <span class="text-sm font-bold text-[#171411]">Acompte reçu</span>
                            <input name="deposit_amount" value="{{ old('deposit_amount', $order->deposit_amount) }}" inputmode="decimal" class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4" placeholder="0">
                            @error('deposit_amount')<span class="mt-1 block text-sm text-rose-700">{{ $message }}</span>@enderror
                        </label>
                        @if($isEdit)
                            <div class="rounded-2xl border border-[#eadfce] bg-[#fbf7f0] p-4">
                                <div class="text-xs font-bold uppercase tracking-wide text-[#6a5a4c]">Reste à payer</div>
                                <div class="mt-1 text-2xl font-extrabold {{ $order->remaining_amount > 0 ? 'text-rose-700' : 'text-emerald-700' }}">{{ $order->remainingAmountDisplay() }}</div>
                            </div>
                        @endif
                    </div>
                </section>

                <section class="rounded-2xl border border-[#eadfce] bg-white p-6 shadow-sm">
                    <h2 class="text-base font-extrabold text-[#171411]">Dates</h2>
                    <div class="mt-5 grid gap-4">
                        <label class="block">
                            <span class="text-sm font-bold text-[#171411]">Date de commande</span>
                            <input type="date" name="ordered_at" value="{{ old('ordered_at', $dateValue($order->ordered_at)) }}" class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4">
                        </label>
                        <label class="block">
                            <span class="text-sm font-bold text-[#171411]">Date de livraison prévue</span>
                            <input type="date" name="delivery_due_at" value="{{ old('delivery_due_at', $dateValue($order->delivery_due_at)) }}" class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4">
                        </label>
                    </div>
                </section>

                <section class="rounded-2xl border border-[#eadfce] bg-white p-6 shadow-sm">
                    <h2 class="text-base font-extrabold text-[#171411]">Notes internes</h2>
                    <textarea name="internal_notes" rows="8" class="mt-5 w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4">{{ old('internal_notes', $order->internal_notes) }}</textarea>
                </section>
            </aside>
        </div>

        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <a href="{{ $isEdit ? route('workshop.orders.show', $order) : route('workshop.orders.index') }}" class="inline-flex items-center justify-center rounded-xl border border-[#d8c7af] bg-white px-5 py-3 text-sm font-bold text-[#171411] hover:bg-[#fbf7f0]">Annuler</a>
            <button class="inline-flex items-center justify-center rounded-xl bg-[#171411] px-5 py-3 text-sm font-bold text-white hover:bg-[#a47834]">{{ $isEdit ? 'Enregistrer' : 'Créer la commande' }}</button>
        </div>
    </form>
</div>
@endsection
