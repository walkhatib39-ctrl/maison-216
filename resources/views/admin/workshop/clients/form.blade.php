@extends('layouts.admin')

@section('content')
@php($isEdit = $client->exists)

<div class="mx-auto max-w-4xl space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <a href="{{ route('admin.workshop.clients.index') }}" class="text-sm font-bold text-[#8e6322] hover:text-[#171411]">Retour aux clients</a>
            <h1 class="mt-2 text-2xl font-extrabold tracking-tight text-[#171411]">{{ $isEdit ? 'Modifier le client' : 'Ajouter client' }}</h1>
            <p class="mt-1 text-sm text-[#6a5a4c]">Fiche interne atelier.</p>
        </div>
        @if($isEdit)
            <a href="{{ route('admin.workshop.orders.create', ['client_id' => $client->id]) }}" class="inline-flex items-center justify-center rounded-xl bg-[#171411] px-4 py-2.5 text-sm font-bold text-white transition hover:bg-[#a47834]">+ Commande</a>
        @endif
    </div>

    @if($errors->any())
        <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-800">Corrigez les champs signalés.</div>
    @endif

    <form method="POST" action="{{ $isEdit ? route('admin.workshop.clients.update', $client) : route('admin.workshop.clients.store') }}" class="space-y-6">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <section class="rounded-2xl border border-[#eadfce] bg-white p-6 shadow-sm">
            <h2 class="text-base font-extrabold text-[#171411]">Informations client</h2>
            <div class="mt-5 grid gap-4 md:grid-cols-2">
                <label class="block md:col-span-2">
                    <span class="text-sm font-bold text-[#171411]">Nom *</span>
                    <input name="name" value="{{ old('name', $client->name) }}" required class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4">
                    @error('name')<span class="mt-1 block text-sm text-rose-700">{{ $message }}</span>@enderror
                </label>
                <label class="block">
                    <span class="text-sm font-bold text-[#171411]">Téléphone</span>
                    <input name="phone" value="{{ old('phone', $client->phone) }}" class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4">
                </label>
                <label class="block">
                    <span class="text-sm font-bold text-[#171411]">WhatsApp</span>
                    <input name="whatsapp" value="{{ old('whatsapp', $client->whatsapp) }}" class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4">
                </label>
                <label class="block">
                    <span class="text-sm font-bold text-[#171411]">Ville</span>
                    <input name="city" value="{{ old('city', $client->city) }}" class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4">
                </label>
                <label class="block">
                    <span class="text-sm font-bold text-[#171411]">Type client *</span>
                    <select name="client_type" required class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4">
                        @foreach($clientTypes as $value => $label)
                            <option value="{{ $value }}" @selected(old('client_type', $client->client_type) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </label>
                <label class="block md:col-span-2">
                    <span class="text-sm font-bold text-[#171411]">Adresse</span>
                    <textarea name="address" rows="3" class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4">{{ old('address', $client->address) }}</textarea>
                </label>
                <label class="block md:col-span-2">
                    <span class="text-sm font-bold text-[#171411]">Notes internes</span>
                    <textarea name="internal_notes" rows="5" class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4">{{ old('internal_notes', $client->internal_notes) }}</textarea>
                </label>
            </div>
        </section>

        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <a href="{{ $isEdit ? route('admin.workshop.clients.show', $client) : route('admin.workshop.clients.index') }}" class="inline-flex items-center justify-center rounded-xl border border-[#d8c7af] bg-white px-5 py-3 text-sm font-bold text-[#171411] hover:bg-[#fbf7f0]">Annuler</a>
            <button class="inline-flex items-center justify-center rounded-xl bg-[#171411] px-5 py-3 text-sm font-bold text-white hover:bg-[#a47834]">{{ $isEdit ? 'Enregistrer' : 'Créer le client' }}</button>
        </div>
    </form>
</div>
@endsection
