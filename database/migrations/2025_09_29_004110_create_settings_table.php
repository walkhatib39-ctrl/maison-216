<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            // Key/Value générique pour permettre une configuration flexible depuis l'admin
            // Exemples de clés: site.name, contact.whatsapp, contact.messenger, shipping.fee_millimes, ui.logo, ui.favicon
            $table->string('key')->unique();
            $table->json('value')->nullable();
            $table->string('group')->nullable()->index(); // ex: 'site', 'contact', 'shipping', 'ui'
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
