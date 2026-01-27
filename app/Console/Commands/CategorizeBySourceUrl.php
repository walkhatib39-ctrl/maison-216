<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorizeBySourceUrl extends Command
{
    protected $signature = 'app:categorize-by-url {path? : Path to JSON files directory}';
    protected $description = 'Re-categorize products by extracting category slug from their original Emob URLs';

    public function handle()
    {
        ini_set('memory_limit', '512M');
        
        $path = $this->argument('path') ?? 'C:\Users\WALID DEV\apps walid\meuble\exports\processed';
        
        if (!is_dir($path)) {
            $this->error("Directory not found: {$path}");
            return 1;
        }

        $this->info("Reading JSON files from: {$path}");
        
        // Build a map of all categories by slug for fast lookup
        $categories = Category::pluck('id', 'slug')->toArray();
        $this->info("Found " . count($categories) . " categories");

        // Read all JSON files and build a map: productSlug => sourceUrl
        $urlMap = [];
        $files = glob($path . '/*.json');
        
        $this->info("Found " . count($files) . " JSON files");
        
        foreach ($files as $file) {
            $this->info("Reading: " . basename($file));
            $json = json_decode(file_get_contents($file), true);
            if (!is_array($json)) continue;
            
            foreach ($json as $item) {
                if (!isset($item['title']) || !isset($item['url'])) continue;
                
                $slug = Str::slug($item['title']);
                $urlMap[$slug] = $item['url'];
            }
            
            // Free memory
            unset($json);
        }
        
        $this->info("Built URL map with " . count($urlMap) . " entries");
        
        // Process products in chunks to avoid memory issues
        $updated = 0;
        $notFound = 0;
        $noMatch = 0;
        $total = Product::count();
        
        $bar = $this->output->createProgressBar($total);
        $bar->start();
        
        Product::chunk(500, function ($products) use ($urlMap, $categories, &$updated, &$notFound, &$noMatch, $bar) {
            foreach ($products as $product) {
                $bar->advance();
                
                $url = $urlMap[$product->slug] ?? null;
                
                if (!$url) {
                    $notFound++;
                    continue;
                }
                
                // Extract category slug from URL
                // Example: https://www.emob-meubles.fr/lampadaires/lampadaire-xyz
                $path = parse_url($url, PHP_URL_PATH);
                $segments = array_values(array_filter(explode('/', $path)));
                
                if (empty($segments)) {
                    $noMatch++;
                    continue;
                }
                
                // Try each segment as a potential category slug (skip the last one which is the product)
                $categoryId = null;
                $productSlugFromUrl = end($segments); // Last segment is usually the product
                
                foreach ($segments as $segment) {
                    // Skip if this segment is the product slug
                    if ($segment === $productSlugFromUrl) {
                        continue;
                    }
                    
                    // Try to find category with this slug
                    if (isset($categories[$segment])) {
                        $categoryId = $categories[$segment];
                        // Don't break - continue to find the MOST specific (last matching) category
                    }
                }
                
                if ($categoryId && $product->category_id !== $categoryId) {
                    $product->category_id = $categoryId;
                    $product->save();
                    $updated++;
                } elseif (!$categoryId) {
                    $noMatch++;
                }
            }
        });
        
        $bar->finish();
        $this->newLine(2);
        
        $this->info("✅ Categorization complete!");
        $this->info("   Updated: {$updated}");
        $this->info("   No URL found: {$notFound}");
        $this->info("   No category match: {$noMatch}");
        
        return 0;
    }
}
