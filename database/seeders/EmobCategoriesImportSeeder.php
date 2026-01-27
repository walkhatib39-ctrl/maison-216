<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class EmobCategoriesImportSeeder extends Seeder
{
    public function run(): void
    {
        // Read the JSON file
        $jsonPath = 'C:\Users\WALID DEV\apps walid\meuble\emob-categories.json';
        
        if (!file_exists($jsonPath)) {
            $this->command->error("JSON file not found: {$jsonPath}");
            return;
        }
        
        $categories = json_decode(file_get_contents($jsonPath), true);
        
        if (empty($categories)) {
            $this->command->error("No categories found in JSON file");
            return;
        }
        
        $this->command->info("Importing " . count($categories) . " categories...");
        
        // First pass: create all categories without parent relationships
        $slugToId = [];
        
        foreach ($categories as $cat) {
            $category = Category::create([
                'name' => $cat['name'],
                'slug' => $cat['slug'],
                'parent_id' => null, // Will be set in second pass
            ]);
            $slugToId[$cat['slug']] = $category->id;
        }
        
        $this->command->info("Created " . count($slugToId) . " categories");
        
        // Second pass: set parent relationships
        $updated = 0;
        foreach ($categories as $cat) {
            if (!empty($cat['parentSlug']) && isset($slugToId[$cat['parentSlug']])) {
                Category::where('slug', $cat['slug'])->update([
                    'parent_id' => $slugToId[$cat['parentSlug']]
                ]);
                $updated++;
            }
        }
        
        $this->command->info("Set parent relationships for {$updated} categories");
        $this->command->info("✅ Import complete!");
    }
}
