<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workshop_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workshop_client_id')->nullable()->constrained('workshop_clients')->nullOnDelete();
            $table->string('title');
            $table->string('category', 40)->default('bois');
            $table->text('description')->nullable();
            $table->text('dimensions')->nullable();
            $table->string('finish')->nullable();
            $table->decimal('total_amount', 12, 3)->default(0);
            $table->decimal('deposit_amount', 12, 3)->default(0);
            $table->date('ordered_at')->nullable();
            $table->date('delivery_due_at')->nullable();
            $table->string('status', 60)->default('Nouvelle commande');
            $table->text('internal_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'delivery_due_at']);
            $table->index(['category', 'delivery_due_at']);
            $table->index('ordered_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workshop_orders');
    }
};
