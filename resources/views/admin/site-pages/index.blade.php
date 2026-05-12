@extends('layouts.admin')

@section('content')
@php
    $statusOptions = [
        '' => 'Pages actives',
        'missing_meta' => 'Meta manquante',
        'noindex' => 'Noindex',
        'obsolete' => 'Obsoletes',
    ];
@endphp

<div class="space-y-6">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-[#171411]">Pages & SEO</h1>
            <p class="mt-1 text-sm text-[#6a5a4c]">Pages publiques groupees par silo.</p>
        </div>
        <form method="POST" action="{{ route('admin.site-pages.sync') }}">
            @csrf
            <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-[#171411] px-4 py-2.5 text-sm font-bold text-white transition hover:bg-[#a47834]">
                Synchroniser les pages
            </button>
        </form>
    </div>

    @if(session('status'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
            {{ session('status') }}
        </div>
    @endif

    <div class="grid gap-4 md:grid-cols-4">
        <div class="rounded-2xl border border-[#eadfce] bg-white p-5 shadow-sm">
            <div class="text-sm font-semibold text-[#6a5a4c]">Pages actives</div>
            <div class="mt-2 text-3xl font-extrabold text-[#171411]">{{ $stats['total'] }}</div>
        </div>
        <div class="rounded-2xl border border-[#eadfce] bg-white p-5 shadow-sm">
            <div class="text-sm font-semibold text-[#6a5a4c]">Meta manquante</div>
            <div class="mt-2 text-3xl font-extrabold text-[#171411]">{{ $stats['missing_meta'] }}</div>
        </div>
        <div class="rounded-2xl border border-[#eadfce] bg-white p-5 shadow-sm">
            <div class="text-sm font-semibold text-[#6a5a4c]">Noindex</div>
            <div class="mt-2 text-3xl font-extrabold text-[#171411]">{{ $stats['noindex'] }}</div>
        </div>
        <div class="rounded-2xl border border-[#eadfce] bg-white p-5 shadow-sm">
            <div class="text-sm font-semibold text-[#6a5a4c]">Obsoletes</div>
            <div class="mt-2 text-3xl font-extrabold text-[#171411]">{{ $stats['obsolete'] }}</div>
        </div>
    </div>

    <form method="GET" class="rounded-2xl border border-[#eadfce] bg-white p-4 shadow-sm">
        <div class="grid gap-3 lg:grid-cols-[1fr_220px_220px_auto]">
            <div>
                <label for="q" class="mb-1 block text-xs font-bold uppercase tracking-wide text-[#6a5a4c]">Recherche</label>
                <input id="q" name="q" value="{{ $filters['q'] }}" class="w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm text-[#171411] outline-none ring-[#b88a3b]/20 focus:ring-4" placeholder="Titre ou URL">
            </div>
            <div>
                <label for="silo" class="mb-1 block text-xs font-bold uppercase tracking-wide text-[#6a5a4c]">Silo</label>
                <select id="silo" name="silo" class="w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm text-[#171411] outline-none ring-[#b88a3b]/20 focus:ring-4">
                    <option value="">Tous les silos</option>
                    @foreach($silos as $silo)
                        <option value="{{ $silo }}" @selected($filters['silo'] === $silo)>{{ $silo }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="status" class="mb-1 block text-xs font-bold uppercase tracking-wide text-[#6a5a4c]">Statut</label>
                <select id="status" name="status" class="w-full rounded-xl border border-[#d8c7af] bg-white px-3 py-2.5 text-sm text-[#171411] outline-none ring-[#b88a3b]/20 focus:ring-4">
                    @foreach($statusOptions as $value => $label)
                        <option value="{{ $value }}" @selected($filters['status'] === $value)>{{ $label }}</option>
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

    @forelse($pagesBySilo as $silo => $pages)
        <section class="overflow-hidden rounded-2xl border border-[#eadfce] bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-[#eadfce] bg-[#fbf7f0] px-5 py-4">
                <div>
                    <h2 class="text-base font-extrabold text-[#171411]">{{ $silo }}</h2>
                    <p class="text-sm text-[#6a5a4c]">{{ $pages->count() }} page{{ $pages->count() > 1 ? 's' : '' }}</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-[#eadfce] text-sm">
                    <thead class="bg-[#f7f4ee] text-left text-xs font-bold uppercase tracking-wide text-[#6a5a4c]">
                        <tr>
                            <th class="px-5 py-3">Page</th>
                            <th class="px-5 py-3">URL</th>
                            <th class="px-5 py-3">Meta title</th>
                            <th class="px-5 py-3">Meta description</th>
                            <th class="px-5 py-3">Indexation</th>
                            <th class="px-5 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f0e7da]">
                        @foreach($pages as $page)
                            <tr class="transition hover:bg-[#fbf7f0]">
                                <td class="px-5 py-4">
                                    <div class="font-bold text-[#171411]">{{ $page->admin_title }}</div>
                                    <div class="mt-1 text-xs text-[#6a5a4c]">{{ $page->public_title }}</div>
                                </td>
                                <td class="px-5 py-4">
                                    <a href="{{ $page->publicUrl() }}" target="_blank" class="font-semibold text-[#8e6322] hover:text-[#171411]">
                                        /{{ $page->path }}
                                    </a>
                                </td>
                                <td class="px-5 py-4">
                                    @if(filled($page->meta_title))
                                        <span class="inline-flex whitespace-nowrap rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-800">Remplie</span>
                                    @else
                                        <span class="inline-flex whitespace-nowrap rounded-full bg-amber-50 px-2.5 py-1 text-xs font-bold text-amber-800">Manquante</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4">
                                    @if(filled($page->meta_description))
                                        <span class="inline-flex whitespace-nowrap rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-800">Remplie</span>
                                    @else
                                        <span class="inline-flex whitespace-nowrap rounded-full bg-amber-50 px-2.5 py-1 text-xs font-bold text-amber-800">Manquante</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4">
                                    @if($page->is_obsolete)
                                        <span class="inline-flex whitespace-nowrap rounded-full bg-slate-100 px-2.5 py-1 text-xs font-bold text-slate-700">Obsolete</span>
                                    @elseif($page->is_indexable)
                                        <span class="inline-flex whitespace-nowrap rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-800">Indexable</span>
                                    @else
                                        <span class="inline-flex whitespace-nowrap rounded-full bg-rose-50 px-2.5 py-1 text-xs font-bold text-rose-800">Noindex</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-right">
                                    <a href="{{ route('admin.site-pages.edit', $page) }}" class="inline-flex items-center justify-center rounded-xl border border-[#d8c7af] bg-white px-3 py-2 text-xs font-bold text-[#171411] transition hover:bg-[#fbf7f0]">
                                        Modifier
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    @empty
        <div class="rounded-2xl border border-[#eadfce] bg-white p-8 text-center shadow-sm">
            <h2 class="text-lg font-extrabold text-[#171411]">Aucune page pour ce filtre.</h2>
            <p class="mt-2 text-sm text-[#6a5a4c]">Changez les filtres ou synchronisez les pages.</p>
        </div>
    @endforelse
</div>
@endsection
