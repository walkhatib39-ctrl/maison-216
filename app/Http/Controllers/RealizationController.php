<?php

namespace App\Http\Controllers;

use App\Models\Realization;
use Illuminate\View\View;

class RealizationController extends Controller
{
    public function show(Realization $realization): View
    {
        abort_unless($realization->status === Realization::STATUS_PUBLISHED, 404);

        $realization->load(['images', 'pages']);

        return view('realizations.show', [
            'realization' => $realization,
            'title' => $realization->title,
            'metaDescription' => $realization->short_description ?: str($realization->description)->limit(155)->toString(),
            'canonical' => route('realizations.show', $realization),
            'ogImage' => $realization->coverImageUrl(),
        ]);
    }
}
