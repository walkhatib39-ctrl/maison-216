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
