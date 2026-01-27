<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Illuminate\Support\Facades\File;

class FixAbsolutePaths extends Command
{
    protected $signature = 'images:fix-absolute';
    protected $description = 'Fix absolute paths in DB and move images to public';

    public function handle()
    {
        $products = Product::where('main_image', 'like', '%:%')
            ->orWhere('main_image', 'like', '/Users%')
            ->orWhere('main_image', 'like', '%exports-v2%')
            ->get();
            
        echo "Found " . $products->count() . " products with suspicious paths.\n";
        
        $fixed = 0;
        $failed = 0;
        $publicPath = public_path();
        
        foreach ($products as $product) {
            $sourcePath = $product->main_image;
            
            // Clean up path
            $sourcePath = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $sourcePath);
            
            if (File::exists($sourcePath)) {
                $filename = basename($sourcePath);
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                
                // Destination
                $destDir = $publicPath . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $product->slug;
                if (!File::exists($destDir)) {
                    File::makeDirectory($destDir, 0755, true);
                }
                
                $destFile = $destDir . DIRECTORY_SEPARATOR . 'main.' . $ext;
                
                // Copy if not exists or overwrite
                try {
                    File::copy($sourcePath, $destFile);
                    
                    $relativePath = 'images/' . $product->slug . '/main.' . $ext;
                    $product->main_image = $relativePath;
                    $product->saveQuietly();
                    
                    echo "Fixed: {$product->slug}\n";
                    $fixed++;
                } catch (\Exception $e) {
                    echo "Failed to copy {$sourcePath}: " . $e->getMessage() . "\n";
                    $failed++;
                }
            } else {
                echo "Source not found: {$sourcePath}\n";
                // Try to see if it exists in public already?
                // Logic from previous fix script might apply here too
                $failed++;
            }
        }
        
        echo "Fixed: $fixed, Failed/Missing Source: $failed\n";
    }
}

$cmd = new FixAbsolutePaths();
$cmd->handle();
