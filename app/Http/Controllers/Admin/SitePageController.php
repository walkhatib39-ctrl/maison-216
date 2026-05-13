<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SitePage;
use App\Support\SitePageSyncer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SitePageController extends Controller
{
    public function index(Request $request, SitePageSyncer $syncer): View
    {
        if (SitePage::query()->count() === 0) {
            $syncer->sync();
        }

        $query = SitePage::query()
            ->withCount('realizations')
            ->orderBy('sort_order')
            ->orderBy('path');

        $silo = $request->string('silo')->toString();
        if ($silo !== '') {
            $query->where('silo', $silo);
        }

        $status = $request->string('status')->toString();
        match ($status) {
            'missing_meta' => $query->where(function ($q) {
                $q->whereNull('meta_title')
                    ->orWhere('meta_title', '')
                    ->orWhereNull('meta_description')
                    ->orWhere('meta_description', '');
            })->where('is_obsolete', false),
            'noindex' => $query->where('is_indexable', false)->where('is_obsolete', false),
            'obsolete' => $query->where('is_obsolete', true),
            default => $query->where('is_obsolete', false),
        };

        $search = trim($request->string('q')->toString());
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('admin_title', 'like', "%{$search}%")
                    ->orWhere('public_title', 'like', "%{$search}%")
                    ->orWhere('path', 'like', "%{$search}%");
            });
        }

        $pages = $query->get()->groupBy('silo');
        $silos = SitePage::query()
            ->select('silo')
            ->distinct()
            ->orderBy('silo')
            ->pluck('silo');

        $stats = [
            'total' => SitePage::query()->active()->count(),
            'missing_meta' => SitePage::query()
                ->active()
                ->where(function ($q) {
                    $q->whereNull('meta_title')
                        ->orWhere('meta_title', '')
                        ->orWhereNull('meta_description')
                        ->orWhere('meta_description', '');
                })
                ->count(),
            'noindex' => SitePage::query()->active()->where('is_indexable', false)->count(),
            'obsolete' => SitePage::query()->where('is_obsolete', true)->count(),
        ];

        return view('admin.site-pages.index', [
            'pagesBySilo' => $pages,
            'silos' => $silos,
            'stats' => $stats,
            'filters' => [
                'silo' => $silo,
                'status' => $status,
                'q' => $search,
            ],
        ]);
    }

    public function edit(SitePage $sitePage): View
    {
        return view('admin.site-pages.edit', [
            'page' => $sitePage,
        ]);
    }

    public function update(Request $request, SitePage $sitePage): RedirectResponse
    {
        $data = $request->validate([
            'admin_title' => ['required', 'string', 'max:160'],
            'meta_title' => ['nullable', 'string', 'max:160'],
            'meta_description' => ['nullable', 'string', 'max:320'],
            'og_image' => ['nullable', 'url', 'max:500'],
            'is_indexable' => ['nullable', 'boolean'],
            'priority' => ['nullable', 'numeric', 'min:0.1', 'max:1.0'],
        ]);

        $sitePage->fill([
            'admin_title' => $data['admin_title'],
            'meta_title' => $data['meta_title'] ?? null,
            'meta_description' => $data['meta_description'] ?? null,
            'og_image' => $data['og_image'] ?? null,
            'is_indexable' => (bool) ($data['is_indexable'] ?? false),
            'priority' => $data['priority'] ?? null,
            'last_seo_reviewed_at' => now(),
        ])->save();

        return redirect()
            ->route('admin.site-pages.index', ['silo' => $sitePage->silo])
            ->with('status', 'Page enregistree.');
    }

    public function sync(SitePageSyncer $syncer): RedirectResponse
    {
        $result = $syncer->sync();

        return back()->with(
            'status',
            "Synchronisation terminee: {$result['created']} creees, {$result['updated']} mises a jour, {$result['obsolete']} obsoletes."
        );
    }
}
