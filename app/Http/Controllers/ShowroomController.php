<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Setting;
use App\Models\ShowroomActivity;
use App\Support\SiteSettings;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShowroomController extends Controller
{
    public function index(): View
    {
        $activities = ShowroomActivity::query()
            ->where('is_active', true)
            ->withCount(['products' => fn ($query) => $query->where('is_active', true)])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $products = Product::query()
            ->where('is_active', true)
            ->with(['images', 'showroomActivities'])
            ->latest()
            ->limit(12)
            ->get();

        return view('showroom.index', [
            'activities' => $activities,
            'products' => $products,
            'title' => 'Le Showroom Maison216',
            'metaDescription' => 'Produits, modèles et solutions d aménagement en bois, aluminium et métal pour commerces et espaces professionnels en Tunisie.',
        ]);
    }

    public function activity(Request $request, ShowroomActivity $activity): View
    {
        abort_unless($activity->is_active, 404);

        $saleType = (string) $request->query('vente', 'all');
        $search = trim((string) $request->query('q', ''));

        $products = $activity->products()
            ->where('products.is_active', true)
            ->with(['images', 'showroomActivities'])
            ->when($saleType === 'commandable', fn ($query) => $query->where('quote_only', false)->where('sale_mode', '!=', 'sur_mesure'))
            ->when($saleType === 'sur-devis', fn ($query) => $query->where(function ($query) {
                $query->where('quote_only', true)->orWhere('sale_mode', 'sur_mesure');
            }))
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('short_description', 'like', "%{$search}%");
                });
            })
            ->paginate(18)
            ->withQueryString();

        return view('showroom.activity', [
            'activity' => $activity,
            'products' => $products,
            'saleType' => $saleType,
            'search' => $search,
            'title' => $activity->meta_title ?: $activity->name . ' | Showroom Maison216',
            'metaDescription' => $activity->meta_description ?: $activity->description,
        ]);
    }

    public function product(string $slug): View
    {
        $product = Product::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->with(['images', 'category', 'showroomActivities'])
            ->firstOrFail();

        $phone = SiteSettings::phoneDisplay();
        $whatsappDigits = SiteSettings::whatsappDigits();
        $message = rawurlencode('Bonjour, je suis intéressé par ce produit du Showroom Maison216 : ' . $product->title . ' - ' . url()->current());
        $whatsappUrl = $whatsappDigits ? "https://wa.me/{$whatsappDigits}?text={$message}" : null;

        return view('showroom.product', [
            'product' => $product,
            'phone' => $phone,
            'whatsappUrl' => $whatsappUrl,
            'title' => $product->title,
            'metaDescription' => $product->short_description ? strip_tags($product->short_description) : Setting::get('site.tagline', 'Showroom Maison216'),
            'ogType' => 'product',
            'ogImage' => $product->main_image ?? ($product->images->first()->url ?? Setting::get('seo.og_image')),
        ]);
    }
}
