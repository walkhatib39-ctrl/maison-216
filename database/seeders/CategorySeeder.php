<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('seeders/data/categories.md');
        if (!is_file($path)) {
            $this->command?->warn("Categories file not found at {$path}");
            return;
        }

        $content = file_get_contents($path);
        $lines = preg_split('/\r\n|\n|\r/', (string) $content);

        $parent = null;
        $parentPos = 0;
        $childPos = 0;

        // Emojis used to denote section headers (parents) in the provided markdown
        $parentMarkers = [
            '🛋️', // Salon & Séjour
            '🛏️', // Chambre
            '🍽️', // Salle à manger
            '🍳',  // Cuisine
            '🚿',  // Salle de bain
            '🏡',  // Entrée & Rangement
            '🖥️', // Bureau
            '🌿',  // Extérieur & Jardin
        ];

        foreach ($lines as $rawLine) {
            $line = trim($rawLine);

            // Skip empty lines
            if ($line === '') {
                continue;
            }

            // Normalize trailing comma (e.g. "Bureaux enfants, ")
            $line = rtrim($line, ", \t");

            // Detect parent section by emoji at start
            $isParent = false;
            foreach ($parentMarkers as $marker) {
                if (Str::startsWith($line, $marker)) {
                    $isParent = true;
                    // Remove marker from name
                    $name = trim(Str::after($line, $marker));
                    break;
                }
            }

            if ($isParent) {
                $parentPos++;
                $childPos = 0;

                // Create/update parent category
                $parent = Category::updateOrCreate(
                    ['slug' => Str::slug($name)],
                    ['name' => $name, 'parent_id' => null, 'position' => $parentPos]
                );

                $this->command?->info("Parent: {$parent->name}");
                continue;
            }

            // Otherwise treat as child of current parent
            if ($parent) {
                $childPos++;
                $childName = $line;
                $child = Category::updateOrCreate(
                    ['slug' => Str::slug($childName)],
                    ['name' => $childName, 'parent_id' => $parent->id, 'position' => $childPos]
                );

                $this->command?->line("  - Child: {$child->name}");
            } else {
                // In case a line appears before any parent marker, treat it as a parent.
                $parentPos++;
                $parent = Category::updateOrCreate(
                    ['slug' => Str::slug($line)],
                    ['name' => $line, 'parent_id' => null, 'position' => $parentPos]
                );
                $this->command?->info("Parent (fallback): {$parent->name}");
            }
        }
    }
}
