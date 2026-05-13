<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('realizations', function (Blueprint $table) {
            $table->id();
            $table->string('title', 190);
            $table->string('slug', 190)->unique();
            $table->string('project_type', 120)->nullable()->index();
            $table->string('silo', 80)->index();
            $table->string('location', 120)->nullable();
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->string('cover_image', 500);
            $table->string('cover_alt', 190)->nullable();
            $table->string('status', 40)->default('draft')->index();
            $table->boolean('is_featured')->default(false)->index();
            $table->date('completed_at')->nullable()->index();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->timestamps();

            $table->index(['silo', 'status']);
            $table->index(['status', 'is_featured']);
        });

        Schema::create('realization_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('realization_id')->constrained()->cascadeOnDelete();
            $table->string('image_path', 500);
            $table->string('alt_text', 190)->nullable();
            $table->string('caption', 190)->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['realization_id', 'sort_order']);
        });

        Schema::create('realization_site_page', function (Blueprint $table) {
            $table->id();
            $table->foreignId('realization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('site_page_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_featured_on_page')->default(false);
            $table->timestamps();

            $table->unique(['realization_id', 'site_page_id'], 'realization_page_unique');
            $table->index(['site_page_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('realization_site_page');
        Schema::dropIfExists('realization_images');
        Schema::dropIfExists('realizations');
    }
};
