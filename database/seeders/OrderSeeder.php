<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        // Use active products if present, otherwise any product
        $products = Product::query()
            ->when(Product::where('is_active', true)->exists(), fn($q) => $q->where('is_active', true))
            ->inRandomOrder()
            ->get();

        if ($products->isEmpty()) {
            $this->command?->warn('OrderSeeder: aucun produit trouvé, seeding annulé.');
            return;
        }

        $shippingFeeMillimesDefault = (int) (Setting::get('shipping.fee_millimes', 20000) ?? 20000);

        $cities = [
            'Tunis', 'Ariana', 'Ben Arous', 'Manouba', 'Bizerte', 'Nabeul', 'Zaghouan', 'Beja', 'Jendouba',
            'Kef', 'Siliana', 'Sousse', 'Monastir', 'Mahdia', 'Sfax', 'Kairouan', 'Kasserine', 'Sidi Bouzid',
            'Gabès', 'Medenine', 'Tataouine', 'Tozeur', 'Gafsa', 'Kebili'
        ];

        $statuses = [
            Order::STATUS_NEW,
            Order::STATUS_CONFIRMED,
            Order::STATUS_PREPARING,
            Order::STATUS_DELIVERING,
            Order::STATUS_DELIVERED,
            Order::STATUS_CANCELED,
        ];

        $govMap = config('governorates', []);

        $count = 40; // number of fake orders
        for ($i = 0; $i < $count; $i++) {
            $fullName = fake('fr_FR')->name();
            $phone = '+216 ' . fake()->randomElement(['20', '21', '22', '23', '24', '25', '26', '27', '28', '29']) . ' ' . fake()->randomNumber(7, true);
            $phoneAlt = fake()->boolean(30) ? ('+216 ' . fake()->randomElement(['50', '51', '52', '53', '54', '55', '56', '57', '58', '59']) . ' ' . fake()->randomNumber(7, true)) : null;
            $email = fake()->boolean(60) ? fake('fr_FR')->safeEmail() : null;
            $city = fake()->randomElement($cities);
            $address = fake('fr_FR')->streetAddress();
            $postal = fake()->boolean(70) ? (string) fake()->numberBetween(1000, 9999) : null;

            $itemsQty = fake()->numberBetween(1, 4);
            $picked = $products->random(min($itemsQty, $products->count()));
            $picked = Collection::wrap($picked);

            $subtotal = 0;
            $orderItems = [];

            foreach ($picked as $p) {
                $quantity = fake()->numberBetween(1, 2);
                $unit = (int) ($p->price_millimes ?? 0);
                $line = $unit * $quantity;
                $subtotal += $line;

                $orderItems[] = [
                    'product_id' => $p->id,
                    'product_title' => $p->title,
                    'product_sku' => $p->sku,
                    'product_main_image' => $p->main_image,
                    'unit_price_millimes' => $unit,
                    'quantity' => $quantity,
                    'line_total_millimes' => $line,
                    'attributes' => $p->attributes,
                ];
            }

            $shipping = $shippingFeeMillimesDefault;
            $total = $subtotal + $shipping;

            // Weight statuses: more "Nouveau/Confirmé/Préparation/Livraison", fewer Delivered/Canceled
            $status = fake()->randomElement([
                Order::STATUS_NEW, Order::STATUS_NEW,
                Order::STATUS_CONFIRMED, Order::STATUS_CONFIRMED,
                Order::STATUS_PREPARING,
                Order::STATUS_DELIVERING,
                Order::STATUS_DELIVERED,
                Order::STATUS_CANCELED,
            ]);

            $createdAt = now()->subDays(fake()->numberBetween(0, 30))->subMinutes(fake()->numberBetween(0, 1440));

            $order = Order::create([
                'full_name' => $fullName,
                'phone' => $phone,
                'phone_alt' => $phoneAlt,
                'email' => $email,
                'city' => $city,
                'governorate' => ($govMap[mb_strtolower(trim((string) $city), 'UTF-8')] ?? null),
                'address' => $address,
                'postal_code' => $postal,
                'payment_method' => 'COD',
                'status' => $status,
                'shipping_fee_millimes' => $shipping,
                'subtotal_millimes' => $subtotal,
                'total_millimes' => $total,
                'customer_note' => fake()->boolean(20) ? fake('fr_FR')->sentence() : null,
                'admin_note' => fake()->boolean(15) ? fake('fr_FR')->sentence() : null,
                'placed_at' => $createdAt,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            foreach ($orderItems as $oi) {
                $oi['order_id'] = $order->id;
                OrderItem::create($oi);
            }
        }

        $this->command?->info("OrderSeeder: {$count} commandes factices créées.");
    }
}
