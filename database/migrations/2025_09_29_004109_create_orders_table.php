<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Infos client (guest checkout)
            $table->string('full_name');
            $table->string('phone');
            $table->string('phone_alt')->nullable();
            $table->string('email')->nullable();

            // Adresse de livraison (Tunisie)
            $table->string('city'); // la ville suffit (on déduit le gouvernorat en interne si nécessaire)
            $table->string('address', 500);
            $table->string('postal_code', 10)->nullable();

            // Paiement & statut
            $table->string('payment_method')->default('COD'); // Paiement à la livraison
            $table->string('status')->default('Nouveau')->index(); // Nouveau, Confirmé, En préparation, En livraison, Livré, Annulé

            // Montants en millimes (1 DT = 1000 millimes)
            $table->unsignedInteger('shipping_fee_millimes')->default(20000); // 20 DT fixe
            $table->unsignedInteger('subtotal_millimes'); // somme des items (prix * qté)
            $table->unsignedInteger('total_millimes');    // subtotal + shipping

            // Notes
            $table->text('customer_note')->nullable();
            $table->text('admin_note')->nullable();

            // Suivi
            $table->timestamp('placed_at')->nullable()->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
