<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_images', function (Blueprint $table) {
            $table->text('url')->change();
        });
        
        // Also update products.main_image to text
        Schema::table('products', function (Blueprint $table) {
            $table->text('main_image')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('product_images', function (Blueprint $table) {
            $table->string('url')->change();
        });
        
        Schema::table('products', function (Blueprint $table) {
            $table->string('main_image')->nullable()->change();
        });
    }
};
