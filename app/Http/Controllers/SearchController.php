<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));

        $query = Product::query()
            ->where('is_active', true)
            ->with([
                'category',
                'images' => function ($q) {
                    $q->select(['id', 'product_id', 'url'])->orderBy('position');
                },
            ]);

        if ($q !== '' && mb_strlen($q) >= 2) {
            $query->where(function ($qq) use ($q) {
                $qq->where('title', 'like', '%' . $q . '%')
                    ->orWhere('brand', 'like', '%' . $q . '%');
            });
        }

        $products = $query->latest()->paginate(24)->withQueryString();

        return view('search.index', [
            'q' => $q,
            'products' => $products,
            'title' => $q !== '' ? ('Recherche: ' . $q) : 'Tous les produits',
            'metaDescription' => $q !== '' ? ('Recherche de produits: ' . $q) : 'Decouvrez tous nos produits Maison 216.',
            'ogType' => 'website',
            'ogImage' => \App\Models\Setting::get('seo.og_image') ?? \App\Models\Setting::get('ui.logo'),
        ]);
    }

    /**
     * GET /search/suggest?q=... 
     * Returns lightweight JSON suggestions for autosuggest dropdown.
     * Each item: { title, slug, image }
     */
    public function suggest(Request $request): JsonResponse
    {
        $q = trim((string) $request->query('q', ''));
        if ($q === '' || mb_strlen($q) < 2) {
            return response()->json([]);
        }

        $products = Product::query()
            ->where('is_active', true)
            ->where(function ($qq) use ($q) {
                $qq->where('title', 'like', '%' . $q . '%')
                   ->orWhere('brand', 'like', '%' . $q . '%');
            })
            ->select(['id', 'slug', 'title', 'main_image', 'brand'])
            ->with(['images' => function ($q) {
                $q->select(['id', 'product_id', 'url'])->orderBy('position');
            }])
            ->take(8)
            ->get();

        $data = $products->map(function (Product $p) {
            $img = $p->main_image_url ?: ($p->images->first()->url ?? null);

            return [
                'title' => $p->title,
                'slug'  => $p->slug,
                'image' => $img,
                'brand' => $p->brand,
                'url'   => route('showroom.product.show', $p->slug, false),
            ];
        });

        return response()->json($data);
    }
}
