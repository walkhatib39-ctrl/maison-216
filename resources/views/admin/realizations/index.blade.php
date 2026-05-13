@extends('layouts.admin')

@section('content')
@php
    $statusClass = [
        'draft' => 'bg-slate-100 text-slate-700',
        'published' => 'bg-emerald-50 text-emerald-800',
    ];
@endphp

<div class="space-y-6">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-[#171411]">Realisations</h1>
            <p class="mt-1 text-sm text-[#6a5a4c]">Portfolio public, images et assignations aux pages.</p>
        </div>
        <a href="{{ route('admin.realizations.create') }}" class="inline-flex items-center justify-center rounded-xl bg-[#171411] px-4 py-2.5 text-sm font-bold text-white transition hover:bg-[#a47834]">
            Ajouter une realisation
        </a>
    </div>

    @if(session('status'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
            {{ session('status') }}
        </div>
    @endif

    <div class="grid gap-4 md:grid-cols-4">
        <div class="rounded-2xl border border-[#eadfce] bg-white p-5 shadow-sm">
            <div class="text-sm font-semibold text-[#6a5a4c]">Publiees</div>
            <div class="mt-2 text-3xl font-extrabold text-[#171411]">{{ $stats['published'] }}</div>
        </div>
        <div class="rounded-2xl border border-[#eadfce] bg-white p-5 shadow-sm">
            <div class="text-sm font-semibold text-[#6a5a4c]">Brouillons</div>
            <div class="mt-2 text-3xl font-extrabold text-[#171411]">{{ $stats['draft'] }}</div>
        </div>
        <div class="rounded-2xl border border-[#eadfce] bg-white p-5 shadow-sm">
            <div class="text-sm font-semibold text-[#6a5a4c]">Accueil</div>
            <div class="mt-2 text-3xl font-extrabold text-[#171411]">{{ $stats['featured'] }}</div>
        </div>
        <div class="rounded-2xl border border-[#eadfce] bg-white p-5 shadow-sm">
            <div class="text-sm font-semibold text-[#6a5a4c]">Total</div>
            <div class="mt-2 text-3xl font-extrabold text-[#171411]">{{ $stats['total'] }}</div>
        </div>
    </div>

    <form method="GET" class="rounded-2xl border border-[#eadfce] bg-white p-4 shadow-sm">
        <div class="grid gap-3 xl:grid-cols-[1fr_180px_180px_220px_150px_auto]">
            <div>
                <label for="q" class="mb-1 block text-xs font-bold uppercase tracking-wide text-[#6a5a4c]">Recherche</label>
                <input id="q" name="q" value="{{ $filters['q'] }}" class="w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm text-[#171411] outline-none ring-[#b88a3b]/20 focus:ring-4" placeholder="Titre ou type de projet">
            </div>
            <div>
                <label for="silo" class="mb-1 block text-xs font-bold uppercase tracking-wide text-[#6a5a4c]">Silo</label>
                <select id="silo" name="silo" class="w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm text-[#171411] outline-none ring-[#b88a3b]/20 focus:ring-4">
                    <option value="">Tous</option>
                    @foreach($silos as $value => $label)
                        <option value="{{ $value }}" @selected($filters['silo'] === $value)>{{ $label }}</option>
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
                <label for="page" class="mb-1 block text-xs font-bold uppercase tracking-wide text-[#6a5a4c]">Page</label>
                <select id="page" name="page" class="w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm text-[#171411] outline-none ring-[#b88a3b]/20 focus:ring-4">
                    <option value="">Toutes</option>
                    @foreach($pages as $silo => $group)
                        <optgroup label="{{ $silo }}">
                            @foreach($group as $page)
                                <option value="{{ $page->id }}" @selected((string) $filters['page'] === (string) $page->id)>/{{ $page->path }}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>
            <label class="flex items-end gap-2 pb-2 text-sm font-bold text-[#171411]">
                <input type="checkbox" name="featured" value="1" @checked($filters['featured'] === '1') class="h-5 w-5 rounded border-[#d8c7af] text-[#b88a3b] focus:ring-[#b88a3b]">
                Accueil
            </label>
            <div class="flex items-end">
                <button type="submit" class="w-full rounded-xl border border-[#d8c7af] bg-[#fbf7f0] px-4 py-2.5 text-sm font-bold text-[#171411] transition hover:bg-white xl:w-auto">
                    Filtrer
                </button>
            </div>
        </div>
    </form>

    <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
        @forelse($realizations as $realization)
            <article class="overflow-hidden rounded-[28px] border border-[#eadfce] bg-white shadow-sm">
                <div class="relative h-52 bg-[#e8ddce]">
                    <img src="{{ $realization->coverImageUrl() }}" alt="{{ $realization->cover_alt ?: $realization->title }}" class="h-full w-full object-cover">
                    <div class="absolute left-4 top-4 flex flex-wrap gap-2">
                        <span class="rounded-full px-2.5 py-1 text-xs font-bold {{ $statusClass[$realization->status] ?? 'bg-slate-100 text-slate-700' }}">{{ $realization->statusLabel() }}</span>
                        @if($realization->is_featured)
                            <span class="rounded-full bg-[#171411] px-2.5 py-1 text-xs font-bold text-white">Accueil</span>
                        @endif
                    </div>
                </div>
                <div class="p-5">
                    <div class="text-xs font-bold uppercase tracking-[0.18em] text-[#a47834]">{{ $realization->siloLabel() }}</div>
                    <h2 class="font-display mt-2 text-xl font-extrabold text-[#171411]">{{ $realization->title }}</h2>
                    <p class="mt-2 line-clamp-2 text-sm leading-6 text-[#6a5a4c]">{{ $realization->short_description ?: $realization->project_type }}</p>

                    <div class="mt-4 flex flex-wrap gap-2 text-xs font-bold text-[#6a5a4c]">
                        <span class="rounded-full bg-[#fbf7f0] px-2.5 py-1">{{ $realization->pages_count }} page{{ $realization->pages_count > 1 ? 's' : '' }}</span>
                    </div>

                    <div class="mt-5 flex items-center justify-between gap-3">
                        <a href="{{ route('admin.realizations.edit', $realization) }}" class="inline-flex items-center justify-center rounded-xl border border-[#d8c7af] bg-white px-3 py-2 text-xs font-bold text-[#171411] transition hover:bg-[#fbf7f0]">
                            Modifier
                        </a>
                        @if($realization->status === \App\Models\Realization::STATUS_PUBLISHED)
                            <a href="{{ route('realizations.show', $realization) }}" target="_blank" class="inline-flex items-center justify-center rounded-xl border border-[#d8c7af] bg-white px-3 py-2 text-xs font-bold text-[#171411] transition hover:bg-[#fbf7f0]">
                                Voir
                            </a>
                        @endif
                        <form method="POST" action="{{ route('admin.realizations.destroy', $realization) }}" onsubmit="return confirm('Supprimer cette realisation ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs font-bold text-rose-700 hover:text-rose-900">Supprimer</button>
                        </form>
                    </div>
                </div>
            </article>
        @empty
            <div class="rounded-2xl border border-[#eadfce] bg-white p-8 text-center shadow-sm md:col-span-2 xl:col-span-3">
                <h2 class="text-lg font-extrabold text-[#171411]">Aucune realisation pour ce filtre.</h2>
                <p class="mt-2 text-sm text-[#6a5a4c]">Ajoutez une realisation ou changez les filtres.</p>
            </div>
        @endforelse
    </div>

    {{ $realizations->links() }}
</div>
@endsection
