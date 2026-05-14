<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('showroom_activities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('headline')->nullable();
            $table->text('description')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('product_showroom_activity', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('showroom_activity_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['product_id', 'showroom_activity_id'], 'product_showroom_activity_unique');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->unsignedInteger('price_millimes')->nullable()->change();
            $table->boolean('is_starting_price')->default(false)->after('quote_only');
            $table->string('showroom_badge')->nullable()->after('is_customizable');
            $table->string('availability_label')->nullable()->after('dimension_summary');
            $table->string('delivery_note')->nullable()->after('availability_label');
            $table->string('finish_summary')->nullable()->after('delivery_note');
            $table->json('custom_options')->nullable()->after('attributes');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'is_starting_price',
                'showroom_badge',
                'availability_label',
                'delivery_note',
                'finish_summary',
                'custom_options',
            ]);
            $table->unsignedInteger('price_millimes')->nullable(false)->default(0)->change();
        });

        Schema::dropIfExists('product_showroom_activity');
        Schema::dropIfExists('showroom_activities');
    }
};
