<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('home', [
            'title' => 'Accueil',
            'metaDescription' => 'Maison 216 est un atelier intégré bois, aluminium et métal en Tunisie pour cuisines, dressings, fenêtres, portails et projets d aménagement sur mesure.',
            'ogType' => 'website',
            'ogImage' => \App\Models\Setting::get('seo.og_image') ?? \App\Models\Setting::get('ui.logo'),
        ]);
    }
}
