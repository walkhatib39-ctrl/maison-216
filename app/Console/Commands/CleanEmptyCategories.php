<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use App\Models\Product;

class CleanEmptyCategories extends Command
{
    protected $signature = 'app:clean-empty-categories {--dry-run : Show what would be deleted without actually deleting}';
    protected $description = 'Delete categories with 0 products (including children products)';

    public function handle(): int
    {
        $dryRun = $this->option('dry-run');
        
        $this->info("Analyzing categories...\n");
        
        // Get all categories with their product counts
        $categories = Category::withCount('products')->get();
        
        // Build a map of category ID -> total products (including children)
        $totalProducts = [];
        
        // First pass: count direct products
        foreach ($categories as $cat) {
            $totalProducts[$cat->id] = $cat->products_count;
        }
        
        // Second pass: add children's products to parents (bottom-up)
        // We need to process from deepest to shallowest
        $categoriesByDepth = [];
        foreach ($categories as $cat) {
            $depth = $this->getCategoryDepth($cat);
            $categoriesByDepth[$depth][] = $cat;
        }
        
        krsort($categoriesByDepth); // Sort by depth descending
        
        foreach ($categoriesByDepth as $depth => $cats) {
            foreach ($cats as $cat) {
                if ($cat->parent_id && isset($totalProducts[$cat->parent_id])) {
                    $totalProducts[$cat->parent_id] += $totalProducts[$cat->id];
                }
            }
        }
        
        // Identify empty categories (0 total products including children)
        $emptyCategories = [];
        $nonEmptyCategories = [];
        
        foreach ($categories as $cat) {
            $total = $totalProducts[$cat->id];
            if ($total === 0) {
                $emptyCategories[] = $cat;
            } else {
                $nonEmptyCategories[] = ['category' => $cat, 'total' => $total];
            }
        }
        
        // Show statistics
        $this->info("📊 CATEGORY ANALYSIS:");
        $this->info("   Total categories: " . count($categories));
        $this->info("   Categories with products: " . count($nonEmptyCategories));
        $this->info("   Empty categories (to delete): " . count($emptyCategories));
        
        // Show top categories with most products
        usort($nonEmptyCategories, fn($a, $b) => $b['total'] - $a['total']);
        
        $this->newLine();
        $this->info("🏆 TOP 20 CATEGORIES BY PRODUCT COUNT:");
        $this->table(
            ['Category', 'Slug', 'Direct', 'Total (incl. children)'],
            array_map(fn($item) => [
                $item['category']->name,
                $item['category']->slug,
                $item['category']->products_count,
                $item['total']
            ], array_slice($nonEmptyCategories, 0, 20))
        );
        
        // Show empty categories
        $this->newLine();
        $this->info("🗑️ EMPTY CATEGORIES TO DELETE:");
        foreach (array_slice($emptyCategories, 0, 30) as $cat) {
            $this->line("  - {$cat->name} ({$cat->slug})");
        }
        if (count($emptyCategories) > 30) {
            $this->line("  ... and " . (count($emptyCategories) - 30) . " more");
        }
        
        if ($dryRun) {
            $this->newLine();
            $this->warn("🔍 DRY RUN - No changes made. Remove --dry-run to actually delete.");
            return 0;
        }
        
        // Delete empty categories (children first to avoid FK issues)
        $this->newLine();
        $this->info("Deleting empty categories...");
        
        $deleted = 0;
        
        // Sort by depth descending to delete children first
        usort($emptyCategories, fn($a, $b) => $this->getCategoryDepth($b) - $this->getCategoryDepth($a));
        
        foreach ($emptyCategories as $cat) {
            // Double-check it's still empty (in case a child was reassigned)
            $directCount = Product::where('category_id', $cat->id)->count();
            $childrenCount = Category::where('parent_id', $cat->id)->count();
            
            if ($directCount === 0 && $childrenCount === 0) {
                $cat->delete();
                $deleted++;
            }
        }
        
        $this->info("✅ Deleted {$deleted} empty categories!");
        $this->info("   Remaining categories: " . Category::count());
        
        return 0;
    }
    
    private function getCategoryDepth(Category $category): int
    {
        $depth = 0;
        $current = $category;
        while ($current->parent_id) {
            $depth++;
            $current = Category::find($current->parent_id);
            if (!$current) break;
        }
        return $depth;
    }
}
