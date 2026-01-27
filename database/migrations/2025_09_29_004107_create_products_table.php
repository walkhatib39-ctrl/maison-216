<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // Catégorisation
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();

            // Données principales
            $table->string('title');
            $table->string('slug')->unique();

            // Prix en millimes (1 DT = 1000 millimes) pour précision et simplicité d'affichage (ex: "280 DT")
            $table->unsignedInteger('price_millimes');
            $table->unsignedInteger('compare_at_millimes')->nullable();

            // Inventaire
            $table->unsignedInteger('stock')->default(0); // Admin ajustera ensuite

            // Références & marque
            $table->string('sku')->nullable()->index();
            $table->string('brand')->nullable();

            // Médias
            $table->string('main_image')->nullable();

            // Descriptions
            $table->text('short_description')->nullable();   // HTML court
            $table->longText('long_description')->nullable(); // HTML long

            // Attributs/infos techniques (JSON)
            $table->json('attributes')->nullable();

            // Statut d'activité
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // Recherche simple (titre) — on pourra l'étendre plus tard
            // (fulltext selon version MySQL ; sinon on laissera via LIKE)
            // $table->fullText('title');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
