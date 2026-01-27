<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ResetProducts extends Command
{
    protected $signature = 'reset:products';
    protected $description = 'Truncate products and product_images tables';

    public function handle()
    {
        if (!$this->confirm('DO YOU REALLY WANT TO ERASE ALL PRODUCTS?', true)) {
            return;
        }

        $this->info('Resetting products...');
        
        Schema::disableForeignKeyConstraints();
        DB::table('product_images')->truncate();
        DB::table('products')->truncate();
        Schema::enableForeignKeyConstraints();

        $this->info('✅ All products and images deleted.');
    }
}
