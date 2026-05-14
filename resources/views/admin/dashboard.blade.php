@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-[#171411]">Tableau de bord</h1>
            <p class="mt-1 text-sm text-[#6a5a4c]">Demandes, SEO et contenu à traiter.</p>
        </div>
        <div class="flex flex-col gap-2 sm:flex-row">
            <a href="{{ route('admin.leads.index') }}" class="inline-flex items-center justify-center rounded-xl bg-[#171411] px-4 py-2.5 text-sm font-bold text-white transition hover:bg-[#a47834]">
                Voir les demandes
            </a>
            <a href="{{ route('admin.realizations.create') }}" class="inline-flex items-center justify-center rounded-xl border border-[#d8c7af] bg-white px-4 py-2.5 text-sm font-bold text-[#171411] transition hover:bg-[#fbf7f0]">
                Ajouter une réalisation
            </a>
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-4">
        <a href="{{ route('admin.leads.index', ['status' => \App\Models\Lead::STATUS_NEW]) }}" class="rounded-2xl border border-[#eadfce] bg-white p-5 shadow-sm transition hover:border-[#d5b170] hover:shadow-md">
            <div class="text-sm font-semibold text-[#6a5a4c]">Nouvelles demandes</div>
            <div class="mt-2 text-3xl font-extrabold text-[#171411]">{{ $stats['new_leads'] }}</div>
        </a>
        <a href="{{ route('admin.leads.index') }}" class="rounded-2xl border border-[#eadfce] bg-white p-5 shadow-sm transition hover:border-[#d5b170] hover:shadow-md">
            <div class="text-sm font-semibold text-[#6a5a4c]">Demandes ouvertes</div>
            <div class="mt-2 text-3xl font-extrabold text-[#171411]">{{ $stats['open_leads'] }}</div>
        </a>
        <a href="{{ route('admin.site-pages.index', ['status' => 'missing_meta']) }}" class="rounded-2xl border border-[#eadfce] bg-white p-5 shadow-sm transition hover:border-[#d5b170] hover:shadow-md">
            <div class="text-sm font-semibold text-[#6a5a4c]">Pages SEO à revoir</div>
            <div class="mt-2 text-3xl font-extrabold text-[#171411]">{{ $stats['seo_issues'] }}</div>
        </a>
        <a href="{{ route('admin.realizations.index', ['status' => \App\Models\Realization::STATUS_PUBLISHED]) }}" class="rounded-2xl border border-[#eadfce] bg-white p-5 shadow-sm transition hover:border-[#d5b170] hover:shadow-md">
            <div class="text-sm font-semibold text-[#6a5a4c]">Réalisations publiées</div>
            <div class="mt-2 text-3xl font-extrabold text-[#171411]">{{ $stats['published_realizations'] }}</div>
        </a>
    </div>

    <section class="grid gap-4 lg:grid-cols-4">
        <form method="POST" action="{{ route('admin.site-pages.sync') }}" class="rounded-2xl border border-[#eadfce] bg-white p-5 shadow-sm">
            @csrf
            <div class="text-sm font-bold text-[#171411]">Pages synchronisées</div>
            <div class="mt-1 text-xs font-semibold text-[#6a5a4c]">{{ $stats['pages'] }} pages actives</div>
            <button type="submit" class="mt-4 inline-flex w-full items-center justify-center rounded-xl border border-[#d8c7af] bg-[#fbf7f0] px-4 py-2.5 text-sm font-bold text-[#171411] transition hover:bg-white">
                Synchroniser
            </button>
        </form>
        <a href="{{ route('admin.site-pages.index', ['status' => 'missing_meta']) }}" class="rounded-2xl border border-[#eadfce] bg-white p-5 shadow-sm transition hover:border-[#d5b170] hover:shadow-md">
            <div class="text-sm font-bold text-[#171411]">Metas manquantes</div>
            <div class="mt-1 text-xs font-semibold text-[#6a5a4c]">{{ $stats['missing_meta'] }} page{{ $stats['missing_meta'] > 1 ? 's' : '' }}</div>
            <div class="mt-4 text-sm font-extrabold text-[#8e6322]">Corriger</div>
        </a>
        <a href="{{ route('admin.realizations.create') }}" class="rounded-2xl border border-[#eadfce] bg-white p-5 shadow-sm transition hover:border-[#d5b170] hover:shadow-md">
            <div class="text-sm font-bold text-[#171411]">Pages sans réalisation</div>
            <div class="mt-1 text-xs font-semibold text-[#6a5a4c]">{{ $stats['pages_without_realizations'] }} page{{ $stats['pages_without_realizations'] > 1 ? 's' : '' }} à enrichir</div>
            <div class="mt-4 text-sm font-extrabold text-[#8e6322]">Créer / assigner</div>
        </a>
        <a href="{{ route('admin.settings.index') }}" class="rounded-2xl border border-[#eadfce] bg-white p-5 shadow-sm transition hover:border-[#d5b170] hover:shadow-md">
            <div class="text-sm font-bold text-[#171411]">Paramètres publics</div>
            <div class="mt-1 text-xs font-semibold text-[#6a5a4c]">Téléphone, email, réseaux, SEO</div>
            <div class="mt-4 text-sm font-extrabold text-[#8e6322]">Ouvrir</div>
        </a>
    </section>

    <div class="grid gap-6 xl:grid-cols-[1.05fr_0.95fr]">
        <section class="overflow-hidden rounded-2xl border border-[#eadfce] bg-white shadow-sm">
            <div class="flex items-center justify-between gap-3 border-b border-[#eadfce] bg-[#fbf7f0] px-5 py-4">
                <h2 class="text-base font-extrabold text-[#171411]">Demandes récentes</h2>
                <a href="{{ route('admin.leads.index') }}" class="text-sm font-bold text-[#8e6322] hover:text-[#171411]">Tout voir</a>
            </div>
            <div class="divide-y divide-[#f0e7da]">
                @forelse($recentLeads as $lead)
                    <a href="{{ route('admin.leads.show', $lead) }}" class="block px-5 py-4 transition hover:bg-[#fbf7f0]">
                        <div class="flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <div class="truncate font-bold text-[#171411]">{{ $lead->name ?: 'Contact sans nom' }}</div>
                                <div class="mt-1 truncate text-sm text-[#6a5a4c]">{{ $lead->subject ?: $lead->typeLabel() }}</div>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    <span class="rounded-full bg-[#f4ead8] px-2.5 py-1 text-xs font-bold text-[#8e6322]">{{ $lead->typeLabel() }}</span>
                                    <span class="rounded-full bg-[#f7f4ee] px-2.5 py-1 text-xs font-bold text-[#5f5146]">{{ $lead->statusLabel() }}</span>
                                </div>
                            </div>
                            <div class="whitespace-nowrap text-xs font-semibold text-[#6a5a4c]">{{ $lead->created_at->format('d/m H:i') }}</div>
                        </div>
                    </a>
                @empty
                    <div class="px-5 py-10 text-center text-sm font-semibold text-[#6a5a4c]">Aucune demande pour le moment.</div>
                @endforelse
            </div>
        </section>

        <section class="overflow-hidden rounded-2xl border border-[#eadfce] bg-white shadow-sm">
            <div class="flex items-center justify-between gap-3 border-b border-[#eadfce] bg-[#fbf7f0] px-5 py-4">
                <h2 class="text-base font-extrabold text-[#171411]">Pages SEO à compléter</h2>
                <a href="{{ route('admin.site-pages.index', ['status' => 'missing_meta']) }}" class="text-sm font-bold text-[#8e6322] hover:text-[#171411]">Ouvrir</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-[#eadfce] text-sm">
                    <thead class="bg-[#f7f4ee] text-left text-xs font-bold uppercase tracking-wide text-[#6a5a4c]">
                        <tr>
                            <th class="px-5 py-3">Page</th>
                            <th class="px-5 py-3">Silo</th>
                            <th class="px-5 py-3">Manque</th>
                            <th class="px-5 py-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f0e7da]">
                        @forelse($missingMetaPages as $page)
                            <tr class="transition hover:bg-[#fbf7f0]">
                                <td class="px-5 py-4">
                                    <div class="font-bold text-[#171411]">{{ $page->admin_title }}</div>
                                    <div class="mt-1 text-xs text-[#6a5a4c]">/{{ $page->path }}</div>
                                </td>
                                <td class="px-5 py-4 text-[#6a5a4c]">{{ $page->silo }}</td>
                                <td class="px-5 py-4">
                                    <div class="flex flex-wrap gap-1.5">
                                        @unless(filled($page->meta_title))
                                            <span class="rounded-full bg-amber-50 px-2 py-1 text-xs font-bold text-amber-800">Title</span>
                                        @endunless
                                        @unless(filled($page->meta_description))
                                            <span class="rounded-full bg-amber-50 px-2 py-1 text-xs font-bold text-amber-800">Description</span>
                                        @endunless
                                    </div>
                                </td>
                                <td class="px-5 py-4 text-right">
                                    <a href="{{ route('admin.site-pages.edit', $page) }}" class="inline-flex rounded-xl border border-[#d8c7af] bg-white px-3 py-2 text-xs font-bold text-[#171411] transition hover:bg-[#fbf7f0]">Modifier</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-10 text-center text-sm font-semibold text-[#6a5a4c]">Aucune meta manquante.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="overflow-hidden rounded-2xl border border-[#eadfce] bg-white shadow-sm">
            <div class="flex items-center justify-between gap-3 border-b border-[#eadfce] bg-[#fbf7f0] px-5 py-4">
                <h2 class="text-base font-extrabold text-[#171411]">Pages sans réalisation</h2>
                <a href="{{ route('admin.realizations.create') }}" class="text-sm font-bold text-[#8e6322] hover:text-[#171411]">Ajouter</a>
            </div>
            <div class="divide-y divide-[#f0e7da]">
                @forelse($pagesWithoutRealizations as $page)
                    <div class="flex items-center justify-between gap-4 px-5 py-4">
                        <div class="min-w-0">
                            <div class="truncate font-bold text-[#171411]">{{ $page->admin_title }}</div>
                            <div class="mt-1 truncate text-xs text-[#6a5a4c]">/{{ $page->path }}</div>
                        </div>
                        <span class="shrink-0 rounded-full bg-[#f4ead8] px-2.5 py-1 text-xs font-bold text-[#8e6322]">{{ $page->silo }}</span>
                    </div>
                @empty
                    <div class="px-5 py-10 text-center text-sm font-semibold text-[#6a5a4c]">Toutes les pages clés ont au moins une réalisation assignée.</div>
                @endforelse
            </div>
        </section>

        <section class="overflow-hidden rounded-2xl border border-[#eadfce] bg-white shadow-sm">
            <div class="flex items-center justify-between gap-3 border-b border-[#eadfce] bg-[#fbf7f0] px-5 py-4">
                <h2 class="text-base font-extrabold text-[#171411]">Dernières réalisations</h2>
                <a href="{{ route('admin.realizations.index') }}" class="text-sm font-bold text-[#8e6322] hover:text-[#171411]">Tout voir</a>
            </div>
            <div class="grid gap-3 p-5 sm:grid-cols-2">
                @forelse($recentRealizations as $realization)
                    <a href="{{ route('admin.realizations.edit', $realization) }}" class="overflow-hidden rounded-2xl border border-[#eadfce] bg-[#fbf7f0] transition hover:bg-white">
                        <img src="{{ $realization->coverImageUrl() }}" alt="{{ $realization->cover_alt ?: $realization->title }}" class="h-28 w-full object-cover">
                        <div class="p-3">
                            <div class="line-clamp-1 font-bold text-[#171411]">{{ $realization->title }}</div>
                            <div class="mt-1 text-xs text-[#6a5a4c]">{{ $realization->statusLabel() }}</div>
                        </div>
                    </a>
                @empty
                    <div class="rounded-2xl border border-[#eadfce] bg-[#fbf7f0] p-4 text-sm font-semibold text-[#6a5a4c] sm:col-span-2">Aucune réalisation.</div>
                @endforelse
            </div>
        </section>
    </div>
</div>
@endsection
