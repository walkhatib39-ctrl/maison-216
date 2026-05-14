<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Setting;
use App\Support\SiteSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlacedClient;
use App\Mail\OrderPlacedAdmin;

class ProductController extends Controller
{
    public function show(string $slug): View
    {
        $product = Product::with('images', 'category')->where('slug', $slug)->where('is_active', true)->firstOrFail();

        $messenger = (string) (Setting::get('contact.messenger') ?? '');
        $normalizedWhats = SiteSettings::whatsappDigits();

        // Pre-filled message
        $message = rawurlencode("Bonjour, je souhaite commander: {$product->title} - Lien: " . url()->current());

        $whatsLink = $normalizedWhats ? "https://wa.me/{$normalizedWhats}?text={$message}" : null;
        $messengerLink = $messenger ?: null;

        return view('product.show', [
            'product' => $product,
            'whatsLink' => $whatsLink,
            'messengerLink' => $messengerLink,
            'title' => $product->title,
            'metaDescription' => $product->short_description ? strip_tags($product->short_description) : (\App\Models\Setting::get('site.tagline', 'Atelier Maison216 en Tunisie')),
            'ogType' => 'product',
            'ogImage' => $product->main_image ?? ($product->images->first()->url ?? (\App\Models\Setting::get('seo.og_image') ?? \App\Models\Setting::get('ui.logo'))),
        ]);
    }

    public function quickOrder(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'product_id'   => ['required', 'integer', 'exists:products,id'],
            'full_name'    => ['required', 'string', 'max:120'],
            'phone'        => ['required', 'string', 'max:30'],
            'phone_alt'    => ['nullable', 'string', 'max:30'],
            'email'        => ['nullable', 'email', 'max:150'],
            'city'         => ['required', 'string', 'max:100'],
            'address'      => ['required', 'string', 'max:500'],
            'postal_code'  => ['nullable', 'string', 'max:10'],
            'customer_note'=> ['nullable', 'string', 'max:2000'],
            'quantity'     => ['nullable', 'integer', 'min:1', 'max:20'],
        ]);

        $product = Product::whereKey($data['product_id'])->where('is_active', true)->firstOrFail();

        if ($product->isQuoteOnly()) {
            return redirect()
                ->to('/devis?produit=' . urlencode($product->slug))
                ->with('status', 'Ce produit est disponible sur devis.');
        }

        $qty = (int) ($data['quantity'] ?? 1);
        $qty = max(1, min(20, $qty));

        $shipping = (int) (Setting::get('shipping.fee_millimes', 20000) ?? 20000); // 20 DT par défaut
        $unit = (int) ($product->price_millimes ?? 0);
        $subtotal = $unit * $qty;
        $total = $subtotal + $shipping;

        // Compute governorate from city
        $govMap = config('governorates', []);
        $gk = mb_strtolower(trim((string) $data['city']), 'UTF-8');
        $governorate = $govMap[$gk] ?? null;

        $order = Order::create([
            'full_name'              => $data['full_name'],
            'phone'                  => $data['phone'],
            'phone_alt'              => $data['phone_alt'] ?? null,
            'email'                  => $data['email'] ?? null,
            'city'                   => $data['city'],
            'governorate'            => $governorate,
            'address'                => $data['address'],
            'postal_code'            => $data['postal_code'] ?? null,
            'payment_method'         => 'COD',
            'status'                 => Order::STATUS_NEW,
            'shipping_fee_millimes'  => $shipping,
            'subtotal_millimes'      => $subtotal,
            'total_millimes'         => $total,
            'customer_note'          => $data['customer_note'] ?? null,
            'admin_note'             => null,
            'placed_at'              => now(),
        ]);

        OrderItem::create([
            'order_id'             => $order->id,
            'product_id'           => $product->id,
            'product_title'        => $product->title,
            'product_sku'          => $product->sku,
            'product_main_image'   => $product->main_image,
            'unit_price_millimes'  => $unit,
            'quantity'             => $qty,
            'line_total_millimes'  => $unit * $qty,
            'attributes'           => null,
        ]);

        // Optionnel: décrémenter le stock si > 0
        if (($product->stock ?? 0) > 0) {
            $product->decrement('stock', $qty);
        }

        // Email notifications (client + admin)
        try {
            $adminEmails = SiteSettings::adminEmails();

            if (!empty($data['email'])) {
                Mail::to($data['email'])
                    ->send(new OrderPlacedClient($order->load('items')));
            }
            if ($adminEmails !== []) {
                Mail::to($adminEmails)
                    ->send(new OrderPlacedAdmin($order));
            }
        } catch (\Throwable $e) {
            logger()->warning('Order email send failed: ' . $e->getMessage());
        }

        return redirect()
            ->route('home')
            ->with('success', 'Commande reçue. Nous vous contacterons pour confirmation. Merci !');
    }
}
