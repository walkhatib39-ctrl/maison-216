<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use Illuminate\Support\Facades\File;

class AddMissingCategories extends Command
{
    protected $signature = 'app:add-missing-categories {path? : Path to JSON files directory}';
    protected $description = 'Find and add missing categories from JSON files';

    public function handle(): int
    {
        $path = $this->argument('path') ?? 'C:\Users\WALID DEV\apps walid\meuble\exports\with-categories';
        
        if (!is_dir($path)) {
            $this->error("Directory not found: {$path}");
            return 1;
        }
        
        $this->info("Reading JSON files from: {$path}");
        
        // Get all existing category slugs
        $existingSlugs = Category::pluck('slug')->toArray();
        $this->info("Found " . count($existingSlugs) . " existing categories");
        
        // Find all unique categorySlug values from JSON files
        $missingSlugs = [];
        $files = glob($path . '/*.json');
        
        foreach ($files as $file) {
            $json = json_decode(file_get_contents($file), true);
            if (!is_array($json)) continue;
            
            foreach ($json as $item) {
                $slug = $item['categorySlug'] ?? null;
                if ($slug && !in_array($slug, $existingSlugs) && !isset($missingSlugs[$slug])) {
                    $missingSlugs[$slug] = true;
                }
            }
        }
        
        $slugsToAdd = array_keys($missingSlugs);
        $this->info("Found " . count($slugsToAdd) . " missing category slugs");
        
        if (empty($slugsToAdd)) {
            $this->info("No missing categories to add!");
            return 0;
        }
        
        // Show them
        foreach (array_slice($slugsToAdd, 0, 20) as $slug) {
            $this->line("  - {$slug}");
        }
        if (count($slugsToAdd) > 20) {
            $this->line("  ... and " . (count($slugsToAdd) - 20) . " more");
        }
        
        // Create the missing categories
        $this->info("\nCreating missing categories...");
        $created = 0;
        
        foreach ($slugsToAdd as $slug) {
            // Generate a readable name from the slug
            $name = ucfirst(str_replace('-', ' ', $slug));
            
            Category::create([
                'name' => $name,
                'slug' => $slug,
                'parent_id' => null, // For now, without parent relationship
            ]);
            $created++;
        }
        
        $this->info("✅ Created {$created} new categories!");
        $this->info("Total categories now: " . Category::count());
        
        return 0;
    }
}
