<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('type', 40)->default('contact')->index();
            $table->string('source_page_path', 190)->nullable()->index();
            $table->text('source_url')->nullable();
            $table->string('name');
            $table->string('email', 190)->nullable();
            $table->string('phone', 40)->nullable();
            $table->string('company', 190)->nullable();
            $table->string('profession', 120)->nullable();
            $table->string('subject', 190)->nullable();
            $table->text('message')->nullable();
            $table->json('payload')->nullable();
            $table->string('status', 40)->default('new')->index();
            $table->string('priority', 20)->default('normal')->index();
            $table->text('admin_notes')->nullable();
            $table->timestamp('last_contacted_at')->nullable();
            $table->timestamps();

            $table->index(['type', 'status']);
            $table->index(['created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
