<?php

namespace App\Http\Controllers;

use App\Models\Realization;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RealizationController extends Controller
{
    public function index(Request $request): View
    {
        $silo = trim($request->string('silo')->toString());
        $allowedSilos = array_keys(Realization::siloLabels());

        $query = Realization::query()
            ->published()
            ->ordered();

        if ($silo !== '' && in_array($silo, $allowedSilos, true)) {
            $query->where('silo', $silo);
        }

        $realizations = $query->paginate(12)->withQueryString();
        $counts = Realization::query()
            ->published()
            ->selectRaw('silo, count(*) as total')
            ->groupBy('silo')
            ->pluck('total', 'silo');

        return view('realizations.index', [
            'realizations' => $realizations,
            'counts' => $counts,
            'activeSilo' => $silo,
            'siloLabels' => Realization::siloLabels(),
            'title' => 'Réalisations Maison216 | Cuisines, aluminium, métal et projets',
            'metaDescription' => 'Découvrez les réalisations Maison216 en Tunisie : cuisines, dressings, menuiserie aluminium, portails, pergolas et projets d’agencement.',
            'canonical' => route('realizations.index'),
            'ogImage' => asset('assets/home/realizations/cuisine-sur-mesure.jpg'),
        ]);
    }

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
