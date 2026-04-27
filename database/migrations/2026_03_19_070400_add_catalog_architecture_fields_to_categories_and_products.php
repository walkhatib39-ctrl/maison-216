<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->ensureTableEngineSupportsForeignKeys('categories');
        $this->ensureTableEngineSupportsForeignKeys('products');
        $this->ensureTableEngineSupportsForeignKeys('rooms');
        $this->ensureTableEngineSupportsForeignKeys('product_types');
        $this->ensureTableEngineSupportsForeignKeys('collections');

        Schema::table('categories', function (Blueprint $table) {
            $table->foreignId('room_id')->nullable()->after('parent_id')->constrained('rooms')->nullOnDelete();
            $table->foreignId('product_type_id')->nullable()->after('room_id')->constrained('product_types')->nullOnDelete();
            $table->string('category_kind')->default('catalog')->after('featured_image');
            $table->text('landing_intro')->nullable()->after('category_kind');
            $table->text('landing_outro')->nullable()->after('landing_intro');
            $table->boolean('is_indexable')->default(true)->after('landing_outro');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('room_id')->nullable()->after('category_id')->constrained('rooms')->nullOnDelete();
            $table->foreignId('product_type_id')->nullable()->after('room_id')->constrained('product_types')->nullOnDelete();
            $table->foreignId('primary_collection_id')->nullable()->after('product_type_id')->constrained('collections')->nullOnDelete();
            $table->string('sale_mode')->default('catalog')->after('brand');
            $table->boolean('quote_only')->default(false)->after('sale_mode');
            $table->boolean('is_customizable')->default(false)->after('quote_only');
            $table->string('material_summary')->nullable()->after('main_image');
            $table->string('dimension_summary')->nullable()->after('material_summary');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropConstrainedForeignId('primary_collection_id');
            $table->dropConstrainedForeignId('product_type_id');
            $table->dropConstrainedForeignId('room_id');
            $table->dropColumn([
                'sale_mode',
                'quote_only',
                'is_customizable',
                'material_summary',
                'dimension_summary',
            ]);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropConstrainedForeignId('product_type_id');
            $table->dropConstrainedForeignId('room_id');
            $table->dropColumn([
                'category_kind',
                'landing_intro',
                'landing_outro',
                'is_indexable',
            ]);
        });
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
