<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        // Top-level categories for navigation/sections (with children)
        $rootCategories = Category::whereNull('parent_id')
            ->orderBy('position')
            ->with(['children' => function ($q) {
                $q->orderBy('position')->withCount('products');
            }])
            ->withCount('products')
            ->get();

        // Latest products (active) for nouveautés
        $latest = Product::where('is_active', true)
            ->latest()
            ->take(12)
            ->with('category')
            ->get();

        // Best sellers (placeholder: most recent for now, could be based on order count later)
        $bestsellers = Product::where('is_active', true)
            ->orderByDesc('created_at')
            ->take(8)
            ->with('category')
            ->get();

        // Salon & Séjour products
        $salonProducts = $this->getProductsByCategory('salons-complets', 6);

        // Chambre products
        $chambreProducts = $this->getProductsByCategory('chambres-enfant-completes', 4);

        // Salle à manger products
        $salleMangerProducts = $this->getProductsByCategory('salles-a-manger-completes', 3);

        // Specific categories for the homepage grid
        $gridSlugs = [
            'lits', 
            'armoires', 
            'bureaux', 
            'tables', 
            'meubles-d-assises', 
            'meubles-tv'
        ];
        
        $gridCategories = Category::whereIn('slug', $gridSlugs)->get()
            ->sortBy(function($cat) use ($gridSlugs) {
                return array_search($cat->slug, $gridSlugs);
            });

        return view('home', [
            'rootCategories' => $rootCategories,
            'latest' => $latest,
            'bestsellers' => $bestsellers,
            'salonProducts' => $salonProducts,
            'chambreProducts' => $chambreProducts,
            'salleMangerProducts' => $salleMangerProducts,
            'gridCategories' => $gridCategories,
            'title' => 'Accueil',
            'metaDescription' => 'Maison 216 - Vente de meubles en Tunisie. Découvrez notre collection de canapés, lits, tables et décoration. Livraison partout en Tunisie, paiement à la livraison.',
            'ogType' => 'website',
            'ogImage' => \App\Models\Setting::get('seo.og_image') ?? \App\Models\Setting::get('ui.logo'),
        ]);
    }

    /**
     * Get products by category slug (including subcategories)
     */
    private function getProductsByCategory(string $slug, int $limit = 6)
    {
        // First, try to find products directly in the category or its children
        $category = Category::where('slug', $slug)->first();
        
        if (!$category) {
            // If exact category not found, try partial match
            $category = Category::where('slug', 'like', "%{$slug}%")->first();
        }

        if (!$category) {
            // Fallback to latest products if category not found
            return Product::where('is_active', true)
                ->latest()
                ->take($limit)
                ->with('category')
                ->get();
        }

        // Get all category IDs (parent + children)
        $categoryIds = collect([$category->id]);
        
        // Add children IDs
        $childrenIds = Category::where('parent_id', $category->id)->pluck('id');
        $categoryIds = $categoryIds->merge($childrenIds);
        
        // Add grandchildren IDs
        if ($childrenIds->isNotEmpty()) {
            $grandchildrenIds = Category::whereIn('parent_id', $childrenIds)->pluck('id');
            $categoryIds = $categoryIds->merge($grandchildrenIds);
        }

        return Product::where('is_active', true)
            ->whereIn('category_id', $categoryIds)
            ->latest()
            ->take($limit)
            ->with('category')
            ->get();
    }
}
