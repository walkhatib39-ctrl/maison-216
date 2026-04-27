<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->ensureTableEngineSupportsForeignKeys('products');
        $this->ensureTableEngineSupportsForeignKeys('categories');
        $this->ensureTableEngineSupportsForeignKeys('collections');

        // If a previous deployment failed mid-migration, recreate the pivot cleanly.
        Schema::dropIfExists('collection_product');

        Schema::create('collection_product', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->foreignId('collection_id')->constrained('collections')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();

            $table->unique(['collection_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('collection_product');
    }

    private function ensureTableEngineSupportsForeignKeys(string $table): void
    {
        if (DB::getDriverName() !== 'mysql' || !Schema::hasTable($table)) {
            return;
        }

        $row = DB::selectOne(
            'SELECT ENGINE FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ?',
            [$table]
        );

        if (($row->ENGINE ?? null) && strtoupper((string) $row->ENGINE) !== 'INNODB') {
            DB::statement("ALTER TABLE `{$table}` ENGINE=InnoDB");
        }
    }
};
