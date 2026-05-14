<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Realization;
use App\Models\SitePage;
use App\Support\SitePageSyncer;

class DashboardController extends Controller
{
    public function index(SitePageSyncer $syncer)
    {
        if (SitePage::query()->count() === 0) {
            $syncer->sync();
        }

        $missingMetaQuery = SitePage::query()
            ->active()
            ->where(function ($q) {
                $q->whereNull('meta_title')
                    ->orWhere('meta_title', '')
                    ->orWhereNull('meta_description')
                    ->orWhere('meta_description', '');
            });

        $seoIssuesQuery = SitePage::query()
            ->active()
            ->where(function ($q) {
                $q->where(function ($meta) {
                    $meta->whereNull('meta_title')
                        ->orWhere('meta_title', '')
                        ->orWhereNull('meta_description')
                        ->orWhere('meta_description', '');
                })->orWhere('is_indexable', false);
            });

        $pagesWithoutRealizationsQuery = SitePage::query()
            ->active()
            ->where('page_type', 'quote')
            ->whereIn('silo', ['menuiserie-bois', 'aluminium', 'fer-metal', 'sur-mesure', 'projets'])
            ->doesntHave('realizations');

        return view('admin.dashboard', [
            'stats' => [
                'new_leads' => Lead::query()->where('status', Lead::STATUS_NEW)->count(),
                'open_leads' => Lead::query()->open()->count(),
                'pages' => SitePage::query()->active()->count(),
                'missing_meta' => (clone $missingMetaQuery)->count(),
                'seo_issues' => (clone $seoIssuesQuery)->count(),
                'published_realizations' => Realization::query()->where('status', Realization::STATUS_PUBLISHED)->count(),
                'pages_without_realizations' => (clone $pagesWithoutRealizationsQuery)->count(),
                'noindex' => SitePage::query()->active()->where('is_indexable', false)->count(),
                'obsolete' => SitePage::query()->where('is_obsolete', true)->count(),
            ],
            'recentLeads' => Lead::query()
                ->latest()
                ->limit(6)
                ->get(),
            'missingMetaPages' => $missingMetaQuery
                ->orderBy('sort_order')
                ->limit(8)
                ->get(),
            'pagesWithoutRealizations' => $pagesWithoutRealizationsQuery
                ->orderBy('sort_order')
                ->limit(8)
                ->get(),
            'recentPages' => SitePage::query()
                ->active()
                ->latest('updated_at')
                ->limit(6)
                ->get(),
            'recentRealizations' => Realization::query()
                ->latest()
                ->limit(4)
                ->get(),
        ]);
    }
}
