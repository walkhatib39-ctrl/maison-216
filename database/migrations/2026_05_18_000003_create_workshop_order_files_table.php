<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workshop_order_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workshop_order_id')->constrained('workshop_orders')->cascadeOnDelete();
            $table->string('file_type', 60)->default('photo_client');
            $table->string('file_path');
            $table->string('original_name');
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('size')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['workshop_order_id', 'file_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workshop_order_files');
    }
};
