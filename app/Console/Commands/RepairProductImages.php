<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class RepairProductImages extends Command
{
    protected $signature = 'products:repair-images
                            {--only-missing=1 : Only process products where the local image file is missing}
                            {--limit=0 : Limit the number of products to process (0 = all)}
                            {--id=* : Only process specific product IDs}
                            {--dry-run : Show what would be done without making changes}';

    protected $description = 'Repair broken product main images (fix extension/path or re-download from source_url)';

    public function handle(): int
    {
        $onlyMissing = $this->toBoolish($this->option('only-missing'));
        $limit = max(0, (int) $this->option('limit'));
        $ids = array_values(array_filter((array) $this->option('id')));
        $dryRun = (bool) $this->option('dry-run');

        $query = Product::query()->whereNotNull('main_image')->orderBy('id');

        if ($ids) {
            $query->whereIn('id', $ids);
        }

        $total = $query->count();
        if ($total === 0) {
            $this->info('No products found.');
            return self::SUCCESS;
        }

        if ($dryRun) {
            $this->warn('DRY RUN - No changes will be made.');
        }

        $processed = 0;
        $skipped = 0;
        $fixed = 0;
        $downloaded = 0;
        $failed = 0;

        $bar = $this->output->createProgressBar($limit > 0 ? min($limit, $total) : $total);
        $bar->start();

        $query->chunkById(200, function ($products) use (
            $onlyMissing,
            $limit,
            $dryRun,
            &$processed,
            &$skipped,
            &$fixed,
            &$downloaded,
            &$failed,
            $bar
        ) {
            foreach ($products as $product) {
                if ($limit > 0 && $processed >= $limit) {
                    return false;
                }

                $processed++;
                $bar->advance();

                $current = (string) $product->main_image;
                $current = $this->normalizeRelativePath($current);

                if ($onlyMissing && $this->publicFileExists($current)) {
                    $skipped++;
                    continue;
                }

                $resolved = $this->resolveExistingLocalMainImage($product, $current);

                if ($resolved !== null) {
                    $fixed++;
                    if (!$dryRun && $resolved !== $current) {
                        $this->persistMainImageFix($product, $current, $resolved);
                    }
                    continue;
                }

                $downloadedPath = $this->downloadMainImageFromSourceUrl($product, $current);
                if ($downloadedPath !== null) {
                    $downloaded++;
                    if (!$dryRun) {
                        $this->persistMainImageFix($product, $current, $downloadedPath);
                    }
                    continue;
                }

                $failed++;
                $this->newLine();
                $this->warn("Failed: #{$product->id} {$product->slug}");
            }
        });

        $bar->finish();
        $this->newLine(2);

        $this->info('=== SUMMARY ===');
        $this->info("Processed: {$processed}");
        $this->info("Skipped (already OK): {$skipped}");
        $this->info("Fixed (path/extension): {$fixed}");
        $this->info("Downloaded: {$downloaded}");
        $this->warn("Failed: {$failed}");

        return self::SUCCESS;
    }

    private function persistMainImageFix(Product $product, string $oldPath, string $newPath): void
    {
        $newPath = $this->normalizeRelativePath($newPath);
        $oldPath = $this->normalizeRelativePath($oldPath);

        if ($product->main_image !== $newPath) {
            $product->main_image = $newPath;
            $product->saveQuietly();
        }

        // Keep product_images table consistent
        ProductImage::query()
            ->where('product_id', $product->id)
            ->where('url', $oldPath)
            ->update(['url' => $newPath]);
    }

    private function resolveExistingLocalMainImage(Product $product, string $currentPath): ?string
    {
        if ($this->publicFileExists($currentPath)) {
            return $currentPath;
        }

        $dir = $this->normalizeRelativePath((string) dirname($currentPath));
        $base = pathinfo($currentPath, PATHINFO_FILENAME) ?: 'main';

        $extensions = ['jpg', 'jpeg', 'png', 'webp', 'JPG', 'JPEG', 'PNG', 'WEBP'];

        foreach ($extensions as $ext) {
            $candidate = "{$dir}/{$base}.{$ext}";
            if ($this->publicFileExists($candidate)) {
                return $candidate;
            }
        }

        // Try using the product slug as directory name (common mismatch after slug normalization)
        if (!empty($product->slug) && Str::startsWith($dir, 'images/')) {
            foreach ($extensions as $ext) {
                $candidate = "images/{$product->slug}/{$base}.{$ext}";
                if ($this->publicFileExists($candidate)) {
                    return $candidate;
                }
            }
        }

        return null;
    }

    private function downloadMainImageFromSourceUrl(Product $product, string $currentPath): ?string
    {
        $sourceUrl = $product->attributes['source_url'] ?? null;
        if (!is_string($sourceUrl) || trim($sourceUrl) === '') {
            return null;
        }

        try {
            $htmlResponse = Http::timeout(30)
                ->retry(2, 750)
                ->withOptions(['verify' => false])
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                    'Accept-Language' => 'fr-FR,fr;q=0.9,en-US;q=0.7,en;q=0.6',
                    'Referer' => 'https://www.google.com/',
                ])
                ->get($sourceUrl);

            if (!$htmlResponse->successful()) {
                return null;
            }

            $imageUrl = $this->extractOgImageUrl((string) $htmlResponse->body());
            if (!$imageUrl || !Str::startsWith($imageUrl, ['http://', 'https://'])) {
                return null;
            }

            $imageResponse = Http::timeout(60)
                ->retry(2, 750)
                ->withOptions(['verify' => false])
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                    'Accept' => 'image/webp,image/apng,image/*,*/*;q=0.8',
                    'Referer' => $sourceUrl,
                ])
                ->get($imageUrl);

            if (!$imageResponse->successful()) {
                return null;
            }

            $contentType = (string) ($imageResponse->header('Content-Type') ?? '');
            if (!Str::contains(strtolower($contentType), 'image/')) {
                return null;
            }

            $dir = $this->normalizeRelativePath((string) dirname($currentPath));
            $base = pathinfo($currentPath, PATHINFO_FILENAME) ?: 'main';

            // Fall back to a predictable folder when current path is weird
            if ($dir === '.' || $dir === '') {
                $dir = 'images/' . ($product->slug ?: (string) $product->id);
            }

            $ext = $this->guessImageExtension($imageUrl, $contentType);
            $relative = "{$dir}/{$base}.{$ext}";

            $absDir = public_path($dir);
            if (!File::exists($absDir)) {
                File::makeDirectory($absDir, 0755, true);
            }

            File::put(public_path($relative), $imageResponse->body());

            return $relative;
        } catch (\Throwable $e) {
            return null;
        }
    }

    private function extractOgImageUrl(string $html): ?string
    {
        // Prefer og:image
        $url = $this->extractMetaContent($html, 'property', 'og:image');
        if ($url) {
            return $url;
        }

        // Fallback: twitter:image
        $url = $this->extractMetaContent($html, 'name', 'twitter:image');
        if ($url) {
            return $url;
        }

        return null;
    }

    private function extractMetaContent(string $html, string $attr, string $value): ?string
    {
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $loaded = $dom->loadHTML($html);
        libxml_clear_errors();

        if (!$loaded) {
            return null;
        }

        $xpath = new \DOMXPath($dom);
        $nodes = $xpath->query("//meta[@{$attr}='{$value}']/@content");

        if (!$nodes || $nodes->length === 0) {
            return null;
        }

        $content = trim((string) $nodes->item(0)?->nodeValue);
        return $content !== '' ? $content : null;
    }

    private function guessImageExtension(string $url, string $contentType): string
    {
        $path = (string) (parse_url($url, PHP_URL_PATH) ?? '');
        $ext = strtolower((string) pathinfo($path, PATHINFO_EXTENSION));

        if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true)) {
            return $ext === 'jpeg' ? 'jpg' : $ext;
        }

        $ct = strtolower($contentType);
        if (str_contains($ct, 'image/png')) {
            return 'png';
        }
        if (str_contains($ct, 'image/webp')) {
            return 'webp';
        }
        if (str_contains($ct, 'image/jpeg') || str_contains($ct, 'image/jpg')) {
            return 'jpg';
        }

        return 'jpg';
    }

    private function publicFileExists(string $relativePath): bool
    {
        $relativePath = $this->normalizeRelativePath($relativePath);
        if ($relativePath === '' || $relativePath === '.') {
            return false;
        }

        return File::exists(public_path($relativePath));
    }

    private function normalizeRelativePath(string $path): string
    {
        $path = str_replace('\\', '/', $path);
        $path = preg_replace('#/+#', '/', $path) ?? $path;
        return ltrim($path, '/');
    }

    private function toBoolish(mixed $value): bool
    {
        $v = strtolower(trim((string) $value));
        return !in_array($v, ['', '0', 'false', 'no', 'off'], true);
    }
}

