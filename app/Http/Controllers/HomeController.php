<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Support\StorefrontCatalog;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(StorefrontCatalog $catalog): View
    {
        $latest = Product::where('is_active', true)
            ->latest()
            ->take(8)
            ->with('category')
            ->get();

        $featuredProducts = Product::where('is_active', true)
            ->latest('updated_at')
            ->take(6)
            ->with('category')
            ->get();

        return view('home', [
            'homeRooms' => $catalog->showcaseRooms(),
            'composerEntries' => $catalog->composerTypes(),
            'featuredCollections' => $catalog->featuredCollections(),
            'latest' => $latest,
            'featuredProducts' => $featuredProducts,
            'atelierCapabilities' => collect([
                [
                    'title' => 'Menuiserie bois',
                    'copy' => 'Chambres, dressings, meubles TV, rangements, bureaux et compositions pensées pour le quotidien.',
                ],
                [
                    'title' => 'Menuiserie aluminium',
                    'copy' => 'Portes, fenêtres, vitrines et verrières pour la maison comme pour le commerce.',
                ],
                [
                    'title' => 'Travail de fer',
                    'copy' => 'Portails, pergolas, garde-corps et finitions métal sur mesure.',
                ],
            ]),
            'trustHighlights' => collect([
                'Livraison à domicile',
                'Paiement à la livraison',
                'Made in Tunisia',
            ]),
            'title' => 'Accueil',
            'metaDescription' => 'Maison 216 vous aide à trouver les bons meubles pour chaque pièce et vous accompagne aussi sur les projets sur mesure en Tunisie.',
            'ogType' => 'website',
            'ogImage' => \App\Models\Setting::get('seo.og_image') ?? \App\Models\Setting::get('ui.logo'),
        ]);
    }
}
