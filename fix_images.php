<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Illuminate\Support\Facades\File;

class FixImageExtensions extends Command
{
    protected $signature = 'images:fix-extensions';
    protected $description = 'Fix product image extensions in database to match file system';

    public function handle()
    {
        $products = Product::whereNotNull('main_image')->get();
        $fixedCount = 0;
        $missingCount = 0;

        $extensions = ['jpg', 'jpeg', 'png', 'webp', 'JPG', 'JPEG', 'PNG', 'WEBP'];
        $publicPath = public_path();

        foreach ($products as $product) {
            $currentPath = $product->main_image;
            $fullPath = $publicPath . '/' . $currentPath;
            
            // Normalize path separator
            $fullPath = str_replace('\\', '/', $fullPath);
            
            $needsSave = false;
            
            // ERROR: File does not exist as recorded
            if (!File::exists($fullPath)) {
                $baseDir = dirname($fullPath);
                $filename = pathinfo($fullPath, PATHINFO_FILENAME); // e.g., 'main'
                
                $found = false;
                
                // Check other extensions
                foreach ($extensions as $ext) {
                    $candidate = $baseDir . '/' . $filename . '.' . $ext;
                    if (File::exists($candidate)) {
                        $relativePath = 'images/' . $product->slug . '/' . $filename . '.' . $ext;
                        echo "Fixing {$product->id} ({$product->slug}): {$currentPath} -> {$relativePath}\n";
                        $product->main_image = $relativePath;
                        $needsSave = true;
                        $found = true;
                        $fixedCount++;
                        break;
                    }
                }
                
                if (!$found) {
                    echo "Missing image for {$product->slug}: {$currentPath}\n";
                    $missingCount++;
                }
            } else {
                // File exists, verify extension case sensitivity (approximate)
                // Windows is case insensitive, so File::exists returns true even if DB has .png and file is .PNG
                // Realpath might help resolve the actual casing
                $realPath = realpath($fullPath);
                if ($realPath) {
                    $realPathRelative = str_replace([str_replace('\\', '/', $publicPath) . '/', '\\'], ['', '/'], str_replace('\\', '/', $realPath));
                     if ($realPathRelative !== $currentPath) {
                         echo "Fixing case/path {$product->id}: {$currentPath} -> {$realPathRelative}\n";
                         $product->main_image = $realPathRelative;
                         $needsSave = true;
                         $fixedCount++;
                     }
                }
            }
            
            // Check small_image if it exists
             if ($product->small_image) {
                $currentSmallPath = $product->small_image;
                $fullSmallPath = $publicPath . '/' . $currentSmallPath;
                $fullSmallPath = str_replace('\\', '/', $fullSmallPath);

                 if (!File::exists($fullSmallPath)) {
                    $baseDir = dirname($fullSmallPath);
                    $filename = pathinfo($fullSmallPath, PATHINFO_FILENAME);
                    
                    foreach ($extensions as $ext) {
                        $candidate = $baseDir . '/' . $filename . '.' . $ext;
                        if (File::exists($candidate)) {
                            $relativePath = 'images/' . $product->slug . '/' . $filename . '.' . $ext;
                            $product->small_image = $relativePath;
                            $needsSave = true;
                            break;
                        }
                    }
                 }
             }

            if ($needsSave) {
                $product->saveQuietly();
            }
        }

        echo "Fixed {$fixedCount} images.\n";
        echo "Missing {$missingCount} images.\n";
    }
}

// Execute logic directly in tinker-friendly format since we can't register command easily
$cmd = new FixImageExtensions();
$cmd->handle();
