<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class SmartCategorize extends Command
{
    protected $signature = 'app:smart-categorize';
    protected $description = 'Intelligently categorize products by matching category names in product titles (most specific first)';

    public function handle()
    {
        ini_set('memory_limit', '512M');
        
        $this->info("Loading categories...");
        
        // Load all categories with their depth (subcategories have parent_id)
        $allCategories = Category::with('parent.parent')->get();
        
        // Sort categories by depth (deepest first = most specific)
        // Level 2 (grandchild) > Level 1 (child) > Level 0 (root)
        $sortedCategories = $allCategories->sortByDesc(function ($cat) {
            $depth = 0;
            if ($cat->parent_id) {
                $depth = 1;
                if ($cat->parent && $cat->parent->parent_id) {
                    $depth = 2;
                }
            }
            return $depth;
        })->values();
        
        $this->info("Loaded {$sortedCategories->count()} categories (sorted by specificity)");
        
        // Build keyword patterns from category names
        // We'll search for these in product titles
        $patterns = [];
        foreach ($sortedCategories as $cat) {
            // Create variations of the category name to match
            $name = $cat->name;
            $patterns[] = [
                'category_id' => $cat->id,
                'name' => $name,
                'keywords' => $this->generateKeywords($name),
            ];
        }
        
        $this->info("Built " . count($patterns) . " category patterns");
        
        // Process products in chunks
        $updated = 0;
        $noMatch = 0;
        $already = 0;
        $total = Product::count();
        
        $bar = $this->output->createProgressBar($total);
        $bar->start();
        
        Product::chunk(500, function ($products) use ($patterns, &$updated, &$noMatch, &$already, $bar) {
            foreach ($products as $product) {
                $bar->advance();
                
                $title = mb_strtolower($product->title);
                $matchedCategoryId = null;
                
                // Try to match patterns (already sorted by specificity)
                foreach ($patterns as $pattern) {
                    foreach ($pattern['keywords'] as $keyword) {
                        if (mb_strpos($title, $keyword) !== false) {
                            $matchedCategoryId = $pattern['category_id'];
                            break 2; // Found most specific match, stop
                        }
                    }
                }
                
                if ($matchedCategoryId) {
                    if ($product->category_id !== $matchedCategoryId) {
                        $product->category_id = $matchedCategoryId;
                        $product->save();
                        $updated++;
                    } else {
                        $already++;
                    }
                } else {
                    $noMatch++;
                }
            }
        });
        
        $bar->finish();
        $this->newLine(2);
        
        $this->info("✅ Smart categorization complete!");
        $this->info("   Updated: {$updated}");
        $this->info("   Already correct: {$already}");
        $this->info("   No match found: {$noMatch}");
        
        return 0;
    }
    
    /**
     * Generate keyword variations from a category name
     */
    private function generateKeywords(string $name): array
    {
        $keywords = [];
        $lower = mb_strtolower($name);
        
        // Exact name
        $keywords[] = $lower;
        
        // Without accents
        $keywords[] = $this->removeAccents($lower);
        
        // Singular/Plural variations
        if (Str::endsWith($lower, 's')) {
            $keywords[] = mb_substr($lower, 0, -1); // Remove trailing s
        } else {
            $keywords[] = $lower . 's'; // Add s
        }
        
        // Handle common patterns
        // "Tables à manger" -> "table à manger", "table a manger"
        $keywords[] = str_replace(' à ', ' a ', $lower);
        $keywords[] = str_replace(' & ', ' ', $lower);
        $keywords[] = str_replace('é', 'e', $lower);
        $keywords[] = str_replace('è', 'e', $lower);
        
        return array_unique(array_filter($keywords));
    }
    
    private function removeAccents(string $str): string
    {
        $accents = ['é', 'è', 'ê', 'ë', 'à', 'â', 'ä', 'ù', 'û', 'ü', 'î', 'ï', 'ô', 'ö', 'ç'];
        $replace = ['e', 'e', 'e', 'e', 'a', 'a', 'a', 'u', 'u', 'u', 'i', 'i', 'o', 'o', 'c'];
        return str_replace($accents, $replace, $str);
    }
}
