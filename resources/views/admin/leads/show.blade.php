@extends('layouts.admin')

@section('content')
@php
    $payload = $lead->payload ?? [];
@endphp

<div class="mx-auto max-w-5xl space-y-6">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
        <div>
            <a href="{{ route('admin.leads.index') }}" class="text-sm font-bold text-[#8e6322] hover:text-[#171411]">Retour aux demandes</a>
            <h1 class="mt-2 text-2xl font-extrabold tracking-tight text-[#171411]">{{ $lead->subject ?: $lead->typeLabel() }}</h1>
            <p class="mt-1 text-sm text-[#6a5a4c]">Reçue le {{ $lead->created_at->format('d/m/Y à H:i') }}</p>
        </div>
        <div class="flex flex-wrap gap-2">
            @if($lead->whatsappUrl())
                <a href="{{ $lead->whatsappUrl() }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#171411] px-4 py-2.5 text-sm font-bold text-white transition hover:bg-[#a47834]">
                    <i class="fa-brands fa-whatsapp"></i>
                    WhatsApp
                </a>
            @endif
            @if($lead->email)
                <a href="mailto:{{ $lead->email }}" class="inline-flex items-center justify-center gap-2 rounded-xl border border-[#d8c7af] bg-white px-4 py-2.5 text-sm font-bold text-[#171411] transition hover:bg-[#fbf7f0]">
                    <i class="fa-regular fa-envelope"></i>
                    Email
                </a>
            @endif
        </div>
    </div>

    @if(session('status'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
            {{ session('status') }}
        </div>
    @endif

    <div class="grid gap-6 lg:grid-cols-[1fr_0.75fr]">
        <section class="rounded-2xl border border-[#eadfce] bg-white p-6 shadow-sm">
            <h2 class="text-base font-extrabold text-[#171411]">Message</h2>
            <div class="mt-5 whitespace-pre-line rounded-2xl border border-[#eadfce] bg-[#fbf7f0] p-5 text-sm leading-7 text-[#3f352d]">{{ $lead->message ?: 'Aucun message.' }}</div>

            <div class="mt-6 grid gap-4 md:grid-cols-2">
                <div class="rounded-2xl border border-[#eadfce] bg-white p-4">
                    <div class="text-xs font-bold uppercase tracking-wide text-[#6a5a4c]">Type</div>
                    <div class="mt-2 font-bold text-[#171411]">{{ $lead->typeLabel() }}</div>
                </div>
                <div class="rounded-2xl border border-[#eadfce] bg-white p-4">
                    <div class="text-xs font-bold uppercase tracking-wide text-[#6a5a4c]">Source</div>
                    <div class="mt-2 font-bold text-[#171411]">{{ $lead->source_page_path ? '/' . ltrim($lead->source_page_path, '/') : '-' }}</div>
                </div>
                <div class="rounded-2xl border border-[#eadfce] bg-white p-4">
                    <div class="text-xs font-bold uppercase tracking-wide text-[#6a5a4c]">Projet</div>
                    <div class="mt-2 font-bold text-[#171411]">{{ $payload['project_type'] ?? '-' }}</div>
                </div>
                <div class="rounded-2xl border border-[#eadfce] bg-white p-4">
                    <div class="text-xs font-bold uppercase tracking-wide text-[#6a5a4c]">Localisation</div>
                    <div class="mt-2 font-bold text-[#171411]">{{ $payload['location'] ?? '-' }}</div>
                </div>
            </div>
        </section>

        <aside class="space-y-6">
            <section class="rounded-2xl border border-[#eadfce] bg-white p-6 shadow-sm">
                <h2 class="text-base font-extrabold text-[#171411]">Contact</h2>
                <dl class="mt-5 space-y-4 text-sm">
                    <div>
                        <dt class="font-bold text-[#6a5a4c]">Nom</dt>
                        <dd class="mt-1 text-[#171411]">{{ $lead->name }}</dd>
                    </div>
                    <div>
                        <dt class="font-bold text-[#6a5a4c]">Telephone</dt>
                        <dd class="mt-1 text-[#171411]">{{ $lead->phone ?: '-' }}</dd>
                    </div>
                    <div>
                        <dt class="font-bold text-[#6a5a4c]">Email</dt>
                        <dd class="mt-1 text-[#171411]">{{ $lead->email ?: '-' }}</dd>
                    </div>
                    <div>
                        <dt class="font-bold text-[#6a5a4c]">Entreprise</dt>
                        <dd class="mt-1 text-[#171411]">{{ $lead->company ?: '-' }}</dd>
                    </div>
                    <div>
                        <dt class="font-bold text-[#6a5a4c]">Profession</dt>
                        <dd class="mt-1 text-[#171411]">{{ $lead->profession ?: '-' }}</dd>
                    </div>
                </dl>
            </section>

            <form method="POST" action="{{ route('admin.leads.update', $lead) }}" class="rounded-2xl border border-[#eadfce] bg-white p-6 shadow-sm">
                @csrf
                @method('PUT')

                <h2 class="text-base font-extrabold text-[#171411]">Traitement</h2>

                <div class="mt-5 space-y-4">
                    <label class="block">
                        <span class="text-sm font-bold text-[#171411]">Statut</span>
                        <select name="status" class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4">
                            @foreach($statuses as $value => $label)
                                <option value="{{ $value }}" @selected(old('status', $lead->status) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="block">
                        <span class="text-sm font-bold text-[#171411]">Priorite</span>
                        <select name="priority" class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4">
                            @foreach($priorities as $value => $label)
                                <option value="{{ $value }}" @selected(old('priority', $lead->priority) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="block">
                        <span class="text-sm font-bold text-[#171411]">Notes internes</span>
                        <textarea name="admin_notes" rows="6" class="mt-2 w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm outline-none ring-[#b88a3b]/20 focus:ring-4">{{ old('admin_notes', $lead->admin_notes) }}</textarea>
                    </label>
                </div>

                <button type="submit" class="mt-5 inline-flex w-full items-center justify-center rounded-xl bg-[#171411] px-4 py-3 text-sm font-bold text-white transition hover:bg-[#a47834]">
                    Enregistrer
                </button>
            </form>
        </aside>
    </div>
</div>
@endsection
