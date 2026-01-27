<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::whereNull('parent_id')
            ->orderBy('position')
            ->with(['children' => function ($q) {
                $q->orderBy('position');
            }])
            ->get();

        return view('category.index', [
            'categories' => $categories,
            'title' => 'Catégories',
            'metaDescription' => 'Explorez toutes nos catégories de meubles et décoration en Tunisie.',
            'ogType' => 'website',
            'ogImage' => \App\Models\Setting::get('seo.og_image') ?? \App\Models\Setting::get('ui.logo'),
        ]);
    }

    public function show(Request $request, string $slug): View
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        // Include products from this category and its direct children
        $childIds = $category->children()->pluck('id')->toArray();
        $categoryIds = array_merge([$category->id], $childIds);

        $query = Product::query()
            ->where('is_active', true)
            ->whereIn('category_id', $categoryIds);

        // Basic filters (expandable)
        if ($request->filled('q')) {
            $q = trim((string) $request->string('q'));
            $query->where('title', 'like', '%' . $q . '%');
        }
        if ($request->filled('min')) {
            $min = max(0, (int) $request->integer('min'));
            $query->where('price_millimes', '>=', $min * 1000);
        }
        if ($request->filled('max')) {
            $max = max(0, (int) $request->integer('max'));
            if ($max > 0) {
                $query->where('price_millimes', '<=', $max * 1000);
            }
        }
        if ($request->filled('brand')) {
            $query->where('brand', $request->string('brand'));
        }

        $products = $query->latest()->paginate(24)->withQueryString();

        // For sidebar: siblings (other children of the same parent) and children
        $siblings = collect();
        if ($category->parent_id) {
            $siblings = Category::where('parent_id', $category->parent_id)->orderBy('position')->get();
        }
        $children = $category->children()->orderBy('position')->get();

        // Precompute max price (DT) in this category tree for price slider UI
        $maxPriceMillimes = Product::where('is_active', true)
            ->whereIn('category_id', $categoryIds)
            ->max('price_millimes');
        $maxPriceDt = (int) ceil((int) ($maxPriceMillimes ?? 0) / 1000);

        return view('category.show', [
            'category' => $category,
            'products' => $products,
            'siblings' => $siblings,
            'children' => $children,
            'title' => $category->name,
            'metaDescription' => 'Découvrez notre sélection ' . $category->name . ' — ' . (\App\Models\Setting::get('site.tagline', 'Meubles & Décoration en Tunisie')),
            'ogType' => 'website',
            'ogImage' => \App\Models\Setting::get('seo.og_image') ?? \App\Models\Setting::get('ui.logo'),
            'maxPriceDt' => max($maxPriceDt, 1000),
        ]);
    }
}
