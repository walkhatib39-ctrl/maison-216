@extends('layouts.admin')

@section('content')
@php
    $statusClass = [
        'new' => 'bg-amber-50 text-amber-800',
        'contacted' => 'bg-sky-50 text-sky-800',
        'qualified' => 'bg-indigo-50 text-indigo-800',
        'won' => 'bg-emerald-50 text-emerald-800',
        'lost' => 'bg-rose-50 text-rose-800',
        'archived' => 'bg-slate-100 text-slate-700',
    ];
    $priorityClass = [
        'low' => 'bg-slate-100 text-slate-700',
        'normal' => 'bg-[#fbf7f0] text-[#6a5a4c]',
        'high' => 'bg-rose-50 text-rose-800',
    ];
@endphp

<div class="space-y-6">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-[#171411]">Demandes</h1>
            <p class="mt-1 text-sm text-[#6a5a4c]">Devis, professionnels et messages contact.</p>
        </div>
        <a href="{{ url('/devis') }}" target="_blank" class="inline-flex items-center justify-center rounded-xl bg-[#171411] px-4 py-2.5 text-sm font-bold text-white transition hover:bg-[#a47834]">
            Ouvrir le formulaire devis
        </a>
    </div>

    @if(session('status'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
            {{ session('status') }}
        </div>
    @endif

    <div class="grid gap-4 md:grid-cols-4">
        <div class="rounded-2xl border border-[#eadfce] bg-white p-5 shadow-sm">
            <div class="text-sm font-semibold text-[#6a5a4c]">Nouvelles</div>
            <div class="mt-2 text-3xl font-extrabold text-[#171411]">{{ $stats['new'] }}</div>
        </div>
        <div class="rounded-2xl border border-[#eadfce] bg-white p-5 shadow-sm">
            <div class="text-sm font-semibold text-[#6a5a4c]">A traiter</div>
            <div class="mt-2 text-3xl font-extrabold text-[#171411]">{{ $stats['open'] }}</div>
        </div>
        <div class="rounded-2xl border border-[#eadfce] bg-white p-5 shadow-sm">
            <div class="text-sm font-semibold text-[#6a5a4c]">Professionnels</div>
            <div class="mt-2 text-3xl font-extrabold text-[#171411]">{{ $stats['professional'] }}</div>
        </div>
        <div class="rounded-2xl border border-[#eadfce] bg-white p-5 shadow-sm">
            <div class="text-sm font-semibold text-[#6a5a4c]">Devis</div>
            <div class="mt-2 text-3xl font-extrabold text-[#171411]">{{ $stats['quote'] }}</div>
        </div>
    </div>

    <form method="GET" class="rounded-2xl border border-[#eadfce] bg-white p-4 shadow-sm">
        <div class="grid gap-3 lg:grid-cols-[1fr_170px_170px_170px_auto]">
            <div>
                <label for="q" class="mb-1 block text-xs font-bold uppercase tracking-wide text-[#6a5a4c]">Recherche</label>
                <input id="q" name="q" value="{{ $filters['q'] }}" class="w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm text-[#171411] outline-none ring-[#b88a3b]/20 focus:ring-4" placeholder="Nom, telephone, email, source">
            </div>
            <div>
                <label for="type" class="mb-1 block text-xs font-bold uppercase tracking-wide text-[#6a5a4c]">Type</label>
                <select id="type" name="type" class="w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm text-[#171411] outline-none ring-[#b88a3b]/20 focus:ring-4">
                    <option value="">Tous</option>
                    @foreach($types as $value => $label)
                        <option value="{{ $value }}" @selected($filters['type'] === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="status" class="mb-1 block text-xs font-bold uppercase tracking-wide text-[#6a5a4c]">Statut</label>
                <select id="status" name="status" class="w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm text-[#171411] outline-none ring-[#b88a3b]/20 focus:ring-4">
                    <option value="">Tous</option>
                    @foreach($statuses as $value => $label)
                        <option value="{{ $value }}" @selected($filters['status'] === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="priority" class="mb-1 block text-xs font-bold uppercase tracking-wide text-[#6a5a4c]">Priorite</label>
                <select id="priority" name="priority" class="w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm text-[#171411] outline-none ring-[#b88a3b]/20 focus:ring-4">
                    <option value="">Toutes</option>
                    @foreach($priorities as $value => $label)
                        <option value="{{ $value }}" @selected($filters['priority'] === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full rounded-xl border border-[#d8c7af] bg-[#fbf7f0] px-4 py-2.5 text-sm font-bold text-[#171411] transition hover:bg-white lg:w-auto">
                    Filtrer
                </button>
            </div>
        </div>
    </form>

    <section class="overflow-hidden rounded-2xl border border-[#eadfce] bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-[#eadfce] text-sm">
                <thead class="bg-[#f7f4ee] text-left text-xs font-bold uppercase tracking-wide text-[#6a5a4c]">
                    <tr>
                        <th class="px-5 py-3">Date</th>
                        <th class="px-5 py-3">Demande</th>
                        <th class="px-5 py-3">Contact</th>
                        <th class="px-5 py-3">Source</th>
                        <th class="px-5 py-3">Statut</th>
                        <th class="px-5 py-3">Priorite</th>
                        <th class="px-5 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f0e7da]">
                    @forelse($leads as $lead)
                        <tr class="transition hover:bg-[#fbf7f0]">
                            <td class="whitespace-nowrap px-5 py-4 text-[#6a5a4c]">
                                {{ $lead->created_at->format('d/m/Y') }}
                                <div class="text-xs">{{ $lead->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-5 py-4">
                                <div class="font-bold text-[#171411]">{{ $lead->subject ?: $lead->typeLabel() }}</div>
                                <div class="mt-1 text-xs text-[#6a5a4c]">{{ $lead->typeLabel() }}</div>
                            </td>
                            <td class="px-5 py-4">
                                <div class="font-bold text-[#171411]">{{ $lead->name }}</div>
                                <div class="mt-1 text-xs text-[#6a5a4c]">{{ $lead->phone ?: $lead->email ?: 'Contact incomplet' }}</div>
                            </td>
                            <td class="px-5 py-4 text-xs font-semibold text-[#6a5a4c]">
                                {{ $lead->source_page_path ? '/' . ltrim($lead->source_page_path, '/') : '-' }}
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex whitespace-nowrap rounded-full px-2.5 py-1 text-xs font-bold {{ $statusClass[$lead->status] ?? 'bg-slate-100 text-slate-700' }}">{{ $lead->statusLabel() }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex whitespace-nowrap rounded-full px-2.5 py-1 text-xs font-bold {{ $priorityClass[$lead->priority] ?? 'bg-slate-100 text-slate-700' }}">{{ $lead->priorityLabel() }}</span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <a href="{{ route('admin.leads.show', $lead) }}" class="inline-flex items-center justify-center rounded-xl border border-[#d8c7af] bg-white px-3 py-2 text-xs font-bold text-[#171411] transition hover:bg-[#fbf7f0]">
                                    Ouvrir
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-10 text-center text-sm font-semibold text-[#6a5a4c]">
                                Aucune demande pour ce filtre.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    {{ $leads->links() }}
</div>
@endsection
