<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_pages', function (Blueprint $table) {
            $table->id();
            $table->string('path')->unique();
            $table->string('silo')->index();
            $table->string('parent_path')->nullable()->index();
            $table->string('page_type')->default('quote')->index();
            $table->string('admin_title');
            $table->string('public_title');
            $table->text('description_snapshot')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('og_image')->nullable();
            $table->boolean('is_indexable')->default(true)->index();
            $table->boolean('is_obsolete')->default(false)->index();
            $table->decimal('priority', 2, 1)->nullable();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->timestamp('last_seo_reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_pages');
    }
};
