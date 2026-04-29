<?php

namespace App\Http\Controllers;

use App\Support\SiteStructure;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SitePageController extends Controller
{
    public function show(Request $request, SiteStructure $structure): View
    {
        $section = trim((string) $request->route('section'), '/');
        $path = trim((string) ($request->route('path') ?? ''), '/');
        $fullPath = $path !== '' ? "{$section}/{$path}" : $section;

        $page = $structure->find($fullPath);

        abort_if(!$page, 404);

        if ($fullPath === 'menuiserie-bois') {
            return view('site-structure.menuiserie-bois', [
                'title' => 'Menuiserie bois en Tunisie | Atelier sur mesure',
                'metaDescription' => 'Atelier de menuiserie bois en Tunisie. Cuisines, dressings, mobilier sur mesure. Fabrication 100% interne, plans 3D, pose incluse. Devis sous 48h.',
                'canonical' => url('/menuiserie-bois'),
                'ogType' => 'website',
                'ogImage' => asset('assets/home/menuiserie-bois.webp'),
            ]);
        }

        if ($fullPath === 'aluminium') {
            return view('site-structure.aluminium', [
                'title' => 'Menuiserie aluminium en Tunisie | Atelier alu sur mesure',
                'metaDescription' => 'Atelier de menuiserie aluminium en Tunisie. Fenêtres, portes, garde-corps, volets roulants, moustiquaires et brise-soleil. Devis alu sous 48h.',
                'canonical' => url('/aluminium'),
                'ogType' => 'website',
                'ogImage' => asset('assets/home/menuiserie-aluminium.jpg'),
            ]);
        }

        if (in_array($fullPath, ['aluminium/fenetre-aluminium', 'aluminium/porte-aluminium'], true)) {
            $isWindow = $fullPath === 'aluminium/fenetre-aluminium';

            return view('site-structure.aluminium-detail', [
                'pageKey' => $isWindow ? 'window' : 'door',
                'title' => $isWindow
                    ? 'Fenêtre aluminium sur mesure en Tunisie | Fabrication & pose'
                    : 'Porte aluminium sur mesure en Tunisie | Entrée, baie, coulissant',
                'metaDescription' => $isWindow
                    ? 'Fenêtres aluminium sur mesure fabriquées en atelier en Tunisie. Rupture de pont thermique, double vitrage, toutes teintes RAL. Métré gratuit, devis sous 48h, pose incluse.'
                    : 'Portes aluminium sur mesure fabriquées en atelier en Tunisie. Porte d’entrée, porte-fenêtre, baie coulissante. Toutes teintes RAL, serrurerie multipoints, pose incluse. Devis sous 48h.',
                'canonical' => url('/' . $fullPath),
                'ogType' => 'website',
                'ogImage' => asset('assets/home/menuiserie-aluminium.jpg'),
            ]);
        }

        if (in_array($fullPath, ['aluminium/garde-corps', 'aluminium/moustiquaire', 'aluminium/volet-roulant', 'aluminium/brise-soleil'], true)) {
            $pageMeta = [
                'aluminium/garde-corps' => [
                    'key' => 'guardrail',
                    'title' => 'Garde-corps aluminium sur mesure en Tunisie | Balcon, terrasse, escalier',
                    'description' => 'Garde-corps aluminium sur mesure en Tunisie. Balcon, terrasse, escalier, mezzanine. Barreaux, verre ou lames. Devis sous 48h.',
                ],
                'aluminium/moustiquaire' => [
                    'key' => 'mosquito',
                    'title' => 'Moustiquaire aluminium sur mesure en Tunisie | Enroulable, coulissante',
                    'description' => 'Moustiquaires aluminium sur mesure en Tunisie. Enroulable, coulissante ou fixe. Fabriquée aux dimensions de vos fenêtres, posée par notre équipe.',
                ],
                'aluminium/volet-roulant' => [
                    'key' => 'shutter',
                    'title' => 'Volet roulant aluminium sur mesure en Tunisie | Manuel & motorisé',
                    'description' => 'Volets roulants aluminium sur mesure en Tunisie. Manuel ou motorisé, pose en applique ou intégrée. Fabrication atelier, devis sous 48h.',
                ],
                'aluminium/brise-soleil' => [
                    'key' => 'sunshade',
                    'title' => 'Brise-soleil aluminium sur mesure en Tunisie | Lames fixes & orientables',
                    'description' => 'Brise-soleil aluminium sur mesure en Tunisie. Lames fixes, orientables ou motorisées. Protège du soleil sans bloquer la vue. Devis gratuit.',
                ],
            ][$fullPath];

            return view('site-structure.aluminium-product', [
                'pageKey' => $pageMeta['key'],
                'title' => $pageMeta['title'],
                'metaDescription' => $pageMeta['description'],
                'canonical' => url('/' . $fullPath),
                'ogType' => 'website',
                'ogImage' => asset('assets/home/menuiserie-aluminium.jpg'),
            ]);
        }

        if ($fullPath === 'fer-metal') {
            return view('site-structure.fer-metal', [
                'title' => 'Fabrication métallique en Tunisie | Portails et pergolas sur mesure',
                'metaDescription' => 'Atelier de ferronnerie et fabrication métallique en Tunisie. Portails fer forgé, pergolas, escaliers et garde-corps sur mesure. Devis sous 48h.',
                'canonical' => url('/fer-metal'),
                'ogType' => 'website',
                'ogImage' => asset('assets/home/fabrication-metallique.jpg'),
            ]);
        }

        if ($fullPath === 'sur-mesure') {
            return view('site-structure.sur-mesure', [
                'title' => 'Meuble sur mesure en Tunisie | Cuisine, dressing, placard',
                'metaDescription' => 'Fabrication sur mesure en Tunisie : cuisine, dressing, placard, meuble TV, bureau. Plans 3D, fabrication atelier, pose incluse. Devis gratuit sous 48h.',
                'canonical' => url('/sur-mesure'),
                'ogType' => 'website',
                'ogImage' => asset('assets/home/amenagement-sur-mesure.jpg'),
            ]);
        }

        $children = $structure->childrenOf($fullPath);
        $ancestors = $structure->ancestorsOf($fullPath);
        $siblings = $ancestors->last()
            ? collect($ancestors->last()['children'] ?? [])->where('path', '!=', $page['path'])->values()
            : $structure->mainNavigation()->where('path', '!=', $page['path'])->values();

        return view('site-structure.show', [
            'page' => $page,
            'children' => $children,
            'ancestors' => $ancestors,
            'siblings' => $siblings,
            'mainNavigation' => $structure->mainNavigation(),
            'title' => $page['title'],
            'metaDescription' => $page['description'],
            'ogType' => 'website',
        ]);
    }
}
