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
                    'copy' => 'Dressing, chambre, meuble TV, cuisine, rangements et compositions complètes.',
                ],
                [
                    'title' => 'Menuiserie aluminium',
                    'copy' => 'Portes, fenêtres, vitrines, verrières et solutions techniques pour habitat ou commerce.',
                ],
                [
                    'title' => 'Travail de fer',
                    'copy' => 'Structures, garde-corps, pergolas, portails et finitions métalliques sur mesure.',
                ],
            ]),
            'trustHighlights' => collect([
                'Atelier réel en Tunisie',
                'Livraison sur tout le territoire',
                'Paiement à la livraison selon le produit',
                'Accompagnement WhatsApp et devis rapide',
            ]),
            'title' => 'Accueil',
            'metaDescription' => 'Maison 216 conçoit et vend des meubles en Tunisie. Achetez par élément, composez votre pièce ou lancez un projet sur mesure en bois, aluminium ou fer.',
            'ogType' => 'website',
            'ogImage' => \App\Models\Setting::get('seo.og_image') ?? \App\Models\Setting::get('ui.logo'),
        ]);
    }
}
