@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-[#171411]">Tableau de bord</h1>
            <p class="mt-1 text-sm text-[#6a5a4c]">Etat du cockpit Maison216.</p>
        </div>
        <a href="{{ route('admin.site-pages.index') }}" class="inline-flex items-center justify-center rounded-xl bg-[#171411] px-4 py-2.5 text-sm font-bold text-white transition hover:bg-[#a47834]">
            Ouvrir Pages & SEO
        </a>
    </div>

    <div class="grid gap-4 md:grid-cols-4">
        <div class="rounded-2xl border border-[#eadfce] bg-white p-5 shadow-sm">
            <div class="text-sm font-semibold text-[#6a5a4c]">Pages actives</div>
            <div class="mt-2 text-3xl font-extrabold text-[#171411]">{{ $stats['pages'] }}</div>
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

    <div class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
        <section class="overflow-hidden rounded-2xl border border-[#eadfce] bg-white shadow-sm">
            <div class="border-b border-[#eadfce] bg-[#fbf7f0] px-5 py-4">
                <h2 class="text-base font-extrabold text-[#171411]">Pages a completer</h2>
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

        <section class="rounded-2xl border border-[#eadfce] bg-white p-5 shadow-sm">
            <h2 class="text-base font-extrabold text-[#171411]">Dernieres pages modifiees</h2>
            <div class="mt-4 space-y-3">
                @forelse($recentPages as $page)
                    <a href="{{ route('admin.site-pages.edit', $page) }}" class="block rounded-2xl border border-[#eadfce] bg-[#fbf7f0] p-4 transition hover:bg-white">
                        <div class="font-bold text-[#171411]">{{ $page->admin_title }}</div>
                        <div class="mt-1 text-xs text-[#6a5a4c]">{{ $page->updated_at->format('d/m/Y H:i') }}</div>
                    </a>
                @empty
                    <div class="rounded-2xl border border-[#eadfce] bg-[#fbf7f0] p-4 text-sm font-semibold text-[#6a5a4c]">Aucune page modifiee.</div>
                @endforelse
            </div>
        </section>
    </div>
</div>
@endsection
