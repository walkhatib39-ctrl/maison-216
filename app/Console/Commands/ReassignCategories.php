<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\File;

class ReassignCategories extends Command
{
    protected $signature = 'app:reassign-categories {path? : Path to JSON files directory}';
    protected $description = 'Reassign categories to products that have null category_id using categorySlug from JSON';

    public function handle(): int
    {
        $path = $this->argument('path') ?? 'C:\Users\WALID DEV\apps walid\meuble\exports\with-categories';
        
        if (!is_dir($path)) {
            $this->error("Directory not found: {$path}");
            return 1;
        }
        
        // Build map of product slug -> categorySlug from JSON files
        $this->info("Building product -> category map from JSON files...");
        
        $productCategoryMap = [];
        $files = glob($path . '/*.json');
        
        foreach ($files as $file) {
            $json = json_decode(file_get_contents($file), true);
            if (!is_array($json)) continue;
            
            foreach ($json as $item) {
                $title = $item['title'] ?? null;
                $categorySlug = $item['categorySlug'] ?? null;
                
                if ($title && $categorySlug) {
                    $productCategoryMap[$title] = $categorySlug;
                }
            }
        }
        
        $this->info("Built map with " . count($productCategoryMap) . " entries");
        
        // Build category slug -> id map
        $categoryMap = Category::pluck('id', 'slug')->toArray();
        $this->info("Found " . count($categoryMap) . " categories");
        
        // Update products that have null category_id
        $products = Product::whereNull('category_id')->get();
        $this->info("Found " . $products->count() . " products without category");
        
        $updated = 0;
        $notFound = 0;
        
        $bar = $this->output->createProgressBar($products->count());
        $bar->start();
        
        foreach ($products as $product) {
            $bar->advance();
            
            $categorySlug = $productCategoryMap[$product->title] ?? null;
            
            if (!$categorySlug) {
                $notFound++;
                continue;
            }
            
            $categoryId = $categoryMap[$categorySlug] ?? null;
            
            if ($categoryId) {
                $product->category_id = $categoryId;
                $product->save();
                $updated++;
            } else {
                $notFound++;
            }
        }
        
        $bar->finish();
        $this->newLine(2);
        
        $this->info("✅ Reassignment complete!");
        $this->info("   Updated: {$updated}");
        $this->info("   Not found: {$notFound}");
        
        // Final stats
        $this->info("\nFinal stats:");
        $this->info("   Products with category: " . Product::whereNotNull('category_id')->count());
        $this->info("   Products without category: " . Product::whereNull('category_id')->count());
        
        return 0;
    }
}
