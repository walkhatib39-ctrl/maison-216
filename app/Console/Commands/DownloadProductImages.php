<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DownloadProductImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:download-images 
                            {--limit=0 : Limit the number of products to process (0 = all)}
                            {--force : Force re-download even if local file exists}
                            {--dry-run : Show what would be done without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download external product images and store them locally';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $limit = (int) $this->option('limit');
        $force = $this->option('force');
        $dryRun = $this->option('dry-run');

        // Get products with external URLs
        $query = Product::whereNotNull('main_image')
            ->where('main_image', 'like', 'http%')
            ->where('main_image', 'not like', '%/storage/%');

        if ($limit > 0) {
            $query->limit($limit);
        }

        $products = $query->get();
        $total = $products->count();

        if ($total === 0) {
            $this->info('No products with external images found.');
            return Command::SUCCESS;
        }

        $this->info("Found {$total} products with external images.");

        if ($dryRun) {
            $this->warn('DRY RUN - No changes will be made.');
        }

        // Ensure storage directory exists
        $storagePath = 'public/products';
        if (!Storage::exists($storagePath)) {
            Storage::makeDirectory($storagePath);
            $this->info("Created storage directory: {$storagePath}");
        }

        // Create progress bar
        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $downloaded = 0;
        $failed = 0;
        $skipped = 0;

        foreach ($products as $product) {
            try {
                $result = $this->processProduct($product, $storagePath, $force, $dryRun);
                
                if ($result === 'downloaded') {
                    $downloaded++;
                } elseif ($result === 'skipped') {
                    $skipped++;
                } else {
                    $failed++;
                }
            } catch (\Exception $e) {
                $failed++;
                $this->newLine();
                $this->error("Error processing product #{$product->id}: " . $e->getMessage());
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        // Summary
        $this->info("=== SUMMARY ===");
        $this->info("Downloaded: {$downloaded}");
        $this->info("Skipped (already local): {$skipped}");
        $this->warn("Failed: {$failed}");

        return Command::SUCCESS;
    }

    /**
     * Process a single product's image
     */
    private function processProduct(Product $product, string $storagePath, bool $force, bool $dryRun): string
    {
        $originalUrl = $product->main_image;

        // Skip if already local
        if (Str::startsWith($originalUrl, '/storage/') || !Str::startsWith($originalUrl, 'http')) {
            return 'skipped';
        }

        // Generate local filename
        $extension = $this->getExtension($originalUrl);
        $filename = Str::slug($product->slug ?? $product->id) . '-' . $product->id . '.' . $extension;
        $localPath = "{$storagePath}/{$filename}";

        // Check if already exists
        if (!$force && Storage::exists($localPath)) {
            // Update DB to point to local if not already
            $publicPath = '/storage/products/' . $filename;
            if ($product->main_image !== $publicPath) {
                if (!$dryRun) {
                    $product->update(['main_image' => $publicPath]);
                }
            }
            return 'skipped';
        }

        if ($dryRun) {
            $this->newLine();
            $this->line("Would download: {$originalUrl} -> {$localPath}");
            return 'downloaded';
        }

        // Download image
        try {
            $response = Http::timeout(30)
                ->withOptions([
                    'verify' => false, // Bypass SSL verification for external sites
                ])
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                    'Accept' => 'image/webp,image/apng,image/*,*/*;q=0.8',
                    'Accept-Language' => 'en-US,en;q=0.9',
                    'Referer' => 'https://www.google.com/',
                ])
                ->get($originalUrl);

            if (!$response->successful()) {
                $this->newLine();
                $this->warn("HTTP {$response->status()} for product #{$product->id}: {$originalUrl}");
                return 'failed';
            }

            // Verify it's an image
            $contentType = $response->header('Content-Type');
            if (!Str::startsWith($contentType, 'image/')) {
                $this->newLine();
                $this->warn("Not an image (Content-Type: {$contentType}) for product #{$product->id}");
                return 'failed';
            }

            // Save to storage
            Storage::put($localPath, $response->body());

            // Update product with local path
            $publicPath = '/storage/products/' . $filename;
            $product->update(['main_image' => $publicPath]);

            return 'downloaded';

        } catch (\Exception $e) {
            $this->newLine();
            $this->warn("Download failed for product #{$product->id}: " . $e->getMessage());
            return 'failed';
        }
    }

    /**
     * Get file extension from URL
     */
    private function getExtension(string $url): string
    {
        // Parse URL to get path
        $path = parse_url($url, PHP_URL_PATH);
        
        // Get extension
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        
        // Clean up (remove query strings)
        $extension = Str::before($extension, '?');
        
        // Default to jpg if no extension
        if (empty($extension) || !in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            return 'jpg';
        }

        return strtolower($extension);
    }
}
