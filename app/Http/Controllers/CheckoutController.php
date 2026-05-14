<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests\CheckoutRequest;

class CheckoutController extends Controller
{
    public function __construct(private readonly OrderService $orders)
    {
    }

    /**
     * Display checkout page for a given product (by id or slug), with optional qty preset.
     */
    public function create(Request $request, string $product): View|RedirectResponse
    {
        $prod = Product::where('slug', $product)
            ->orWhere('id', $product)
            ->where('is_active', true)
            ->with('images', 'category')
            ->firstOrFail();

        if ($prod->isQuoteOnly()) {
            return redirect()
                ->to('/devis?produit=' . urlencode($prod->slug))
                ->with('status', 'Ce produit est disponible sur devis.');
        }

        $qty = (int) $request->integer('qty', 1);
        $qty = max(1, min(20, $qty));

        return view('checkout.create', [
            'product' => $prod,
            'qty' => $qty,
            'title' => 'Commander — ' . $prod->title,
            'metaDescription' => 'Commande rapide pour ' . $prod->title . ' — Livraison 3–7 jours, paiement à la livraison.',
            'robots' => 'noindex,nofollow',
        ]);
    }

    /**
     * Handle checkout form submission and create order.
     */
    public function store(CheckoutRequest $request, string $product): RedirectResponse
    {
        $prod = Product::where('slug', $product)
            ->orWhere('id', $product)
            ->where('is_active', true)
            ->firstOrFail();

        if ($prod->isQuoteOnly()) {
            return redirect()
                ->to('/devis?produit=' . urlencode($prod->slug))
                ->with('status', 'Ce produit est disponible sur devis.');
        }

        $data = $request->validated();

        $order = $this->orders->createFromProduct($prod, $data);

        return redirect()
            ->route('checkout.success', ['order' => $order->id])
            ->with('success', 'Commande reçue. Nous vous contacterons pour confirmation. Merci !');
    }

    /**
     * Success page after order creation.
     */
    public function success(Request $request): View
    {
        $orderId = (int) $request->integer('order');
        return view('checkout.success', [
            'orderId' => $orderId,
            'title' => 'Commande confirmée',
            'metaDescription' => 'Votre commande a bien été reçue. Nous vous contacterons pour confirmation.',
            'robots' => 'noindex,nofollow',
        ]);
    }
}
