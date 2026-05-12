<?php

namespace App\Services;

use App\Mail\OrderPlacedAdmin;
use App\Mail\OrderPlacedClient;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Setting;
use App\Support\SiteSettings;
use Illuminate\Support\Facades\Mail;

class OrderService
{
    /**
     * Create an order from a product and payload, send emails, and optionally decrement stock.
     *
     * Expected $payload keys (validated before call):
     * - full_name (string)
     * - phone (string)
     * - phone_alt (nullable string)
     * - email (nullable string)
     * - city (string)
     * - address (string)
     * - postal_code (nullable string)
     * - customer_note (nullable string)
     * - quantity (int 1..20)
     *
     * Returns the created Order (with items relation).
     */
    public function createFromProduct(Product $product, array $payload): Order
    {
        $qty = (int) ($payload['quantity'] ?? 1);
        $qty = max(1, min(20, $qty));

        $shipping = (int) (Setting::get('shipping.fee_millimes', 20000) ?? 20000); // 20 DT par défaut
        $unit = (int) ($product->price_millimes ?? 0);
        $subtotal = $unit * $qty;
        $total = $subtotal + $shipping;

        // Governorate mapping from city
        $govMap = config('governorates', []);
        $gk = mb_strtolower(trim((string) $payload['city']), 'UTF-8');
        $governorate = $govMap[$gk] ?? null;

        $order = Order::create([
            'full_name'              => (string) $payload['full_name'],
            'phone'                  => (string) $payload['phone'],
            'phone_alt'              => $payload['phone_alt'] ?? null,
            'email'                  => $payload['email'] ?? null,
            'city'                   => (string) $payload['city'],
            'governorate'            => $governorate,
            'address'                => (string) $payload['address'],
            'postal_code'            => $payload['postal_code'] ?? null,
            'payment_method'         => 'COD',
            'status'                 => Order::STATUS_NEW,
            'shipping_fee_millimes'  => $shipping,
            'subtotal_millimes'      => $subtotal,
            'total_millimes'         => $total,
            'customer_note'          => $payload['customer_note'] ?? null,
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

        // Decrement stock when positive
        if (($product->stock ?? 0) > 0) {
            $product->decrement('stock', $qty);
        }

        // Email notifications (client + admin)
        try {
            $adminEmails = SiteSettings::adminEmails();

            if (!empty($payload['email'])) {
                Mail::to($payload['email'])
                    ->send(new OrderPlacedClient($order->load('items')));
            }
            if ($adminEmails !== []) {
                Mail::to($adminEmails)
                    ->send(new OrderPlacedAdmin($order));
            }
        } catch (\Throwable $e) {
            logger()->warning('Order email send failed: ' . $e->getMessage());
        }

        return $order;
    }
}
