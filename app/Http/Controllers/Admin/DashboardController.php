<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

        return view('admin.dashboard', [
            'stats' => [
                'pages' => SitePage::query()->active()->count(),
                'missing_meta' => (clone $missingMetaQuery)->count(),
                'noindex' => SitePage::query()->active()->where('is_indexable', false)->count(),
                'obsolete' => SitePage::query()->where('is_obsolete', true)->count(),
            ],
            'missingMetaPages' => $missingMetaQuery
                ->orderBy('sort_order')
                ->limit(8)
                ->get(),
            'recentPages' => SitePage::query()
                ->active()
                ->latest('updated_at')
                ->limit(6)
                ->get(),
        ]);
    }
}
