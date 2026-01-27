<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImportProducts extends Command
{
    protected $signature = 'app:import-products
        {path : JSON file or a directory containing JSON files}
        {--category= : Category slug to assign (e.g. meubles-tv-supports-tv)}
        {--brand= : Default brand for all items}
        {--active=1 : 1/0 to mark products active}
        {--dry-run : Parse and show summary without writing to DB}
        {--limit= : Max items to import per file}';

    protected $description = 'Import products from JSON into the database (Maison 216 format)';

    public function handle(): int
    {
        $pathArg = (string) $this->argument('path');
        $real = $this->resolvePath($pathArg);

        if (!$real) {
            $this->error("Path not found: {$pathArg}");
            return self::FAILURE;
        }

        $categorySlug = (string) ($this->option('category') ?? '');
        $categoryId = $this->resolveCategoryId($categorySlug);
        if ($categorySlug !== '' && !$categoryId) {
            $this->warn("Category slug '{$categorySlug}' not found. Products will have no category.");
        }

        $brand = $this->option('brand') ? (string) $this->option('brand') : null;
        $active = $this->toBool($this->option('active'));
        $dryRun = (bool) $this->option('dry-run');
        $limit = $this->option('limit') ? (int) $this->option('limit') : null;

        $files = [];
        if (is_dir($real)) {
            foreach (File::files($real) as $f) {
                if (strtolower($f->getExtension()) === 'json') {
                    $files[] = $f->getPathname();
                }
            }
            if (!$files) {
                $this->warn("No JSON files found in directory: {$real}");
                return self::SUCCESS;
            }
        } else {
            $files[] = $real;
        }

        $totalImported = 0;
        foreach ($files as $file) {
            $this->info("Processing file: {$file}");
            $json = File::get($file);

            // Remove BOM if present
            $json = preg_replace('/^\xEF\xBB\xBF/', '', $json ?? '');

            $data = json_decode($json, true);
            if ($data === null) {
                $this->error("Invalid JSON in {$file}");
                continue;
            }

            $items = [];
            if (isset($data['products']) && is_array($data['products'])) {
                $items = $data['products'];
            } elseif (is_array($data)) {
                $items = $data;
            }

            if (!is_array($items) || empty($items)) {
                $this->warn("No items found in {$file}");
                continue;
            }

            $count = 0;
            foreach ($items as $idx => $item) {
                if ($limit !== null && $count >= $limit) {
                    $this->line("Limit {$limit} reached for file.");
                    break;
                }
                if (!is_array($item)) {
                    continue;
                }

                try {
                    $saved = $this->importItem($item, $categoryId, $brand, $active, $dryRun);
                    if ($saved) {
                        $count++;
                    }
                } catch (\Throwable $e) {
                    $title = $item['title'] ?? 'N/A';
                    $this->error("Failed to import item '{$title}': " . $e->getMessage());
                }
            }

            $this->info("Imported {$count} items from {$file}");
            $totalImported += $count;
        }

        $this->info("Total imported: {$totalImported}");
        return self::SUCCESS;
    }

    protected $categoryCache = [];

    protected function importItem(array $item, ?int $defaultCategoryId, ?string $brand, bool $active, bool $dryRun): bool
    {
        $title = trim((string) ($item['title'] ?? ''));
        if ($title === '') {
            $this->warn('Skipping item with empty title.');
            return false;
        }

        $priceStr = (string) ($item['price'] ?? '');
        $priceMillimes = $this->parsePriceToMillimes($priceStr);

        $shortHtml = (string) ($item['shortDescriptionHtml'] ?? ($item['description'] ?? ''));
        $longHtml = (string) ($item['longDescriptionHtml'] ?? '');

        $mainImage = (string) ($item['mainImage'] ?? '');
        $gallery = [];
        if (isset($item['galleryImages']) && is_array($item['galleryImages'])) {
            $gallery = array_values(array_filter(array_map('strval', $item['galleryImages'])));
        }

        // Normalize attributes
        $attrs = [];
        if (isset($item['productInfo']) && is_array($item['productInfo'])) {
            foreach ($item['productInfo'] as $k => $v) {
                $kNorm = trim((string) $k);
                $vStr = is_string($v) ? $v : (is_numeric($v) ? (string) $v : json_encode($v));
                // Collapse whitespace and newlines
                $vNorm = preg_replace('/\s+/u', ' ', trim((string) $vStr));
                $attrs[$kNorm] = $vNorm;
            }
        }
        if (!empty($item['url'])) {
            $attrs['source_url'] = (string) $item['url'];
        }

        // === CATEGORY RESOLUTION ===
        // Priority: 1. categorySlug from item, 2. defaultCategoryId from CLI
        $categoryId = $defaultCategoryId;
        
        if (!empty($item['categorySlug'])) {
            $slug = (string) $item['categorySlug'];
            
            // Use cache to avoid repeated DB queries
            if (!isset($this->categoryCache[$slug])) {
                $cat = Category::where('slug', $slug)->first();
                $this->categoryCache[$slug] = $cat?->id;
            }
            
            if ($this->categoryCache[$slug]) {
                $categoryId = $this->categoryCache[$slug];
            }
        }

        // Find existing product by exact title; else create new
        $product = Product::where('title', $title)->first();
        $isNew = false;
        if (!$product) {
            $product = new Product();
            $isNew = true;
        }

        // Fill fields
        $product->title = $title;
        // Let boot() generate unique slug if needed
        if ($isNew) {
            $product->slug = null;
        }
        $product->category_id = $categoryId;
        $product->price_millimes = $priceMillimes;
        $product->compare_at_millimes = null;
        $product->stock = $product->stock ?? 0; // admin ajustera ensuite
        $product->sku = $product->sku ?? null;
        $product->brand = $brand ?? ($product->brand ?? null);
        $product->main_image = $mainImage ?: $product->main_image;
        $product->short_description = $shortHtml ?: null;
        $product->long_description = $longHtml ?: null;
        $product->attributes = $attrs ?: null;
        $product->is_active = $active;

        if ($dryRun) {
            $this->line("[DRY] {$title} | price: {$priceMillimes} millimes | images: " . count($gallery));
            return true;
        }

        $product->save();

        // Reset and insert gallery images
        $product->images()->delete();
        $position = 0;

        // Ensure main image first if not already in gallery
        if ($product->main_image) {
            $position++;
            ProductImage::create([
                'product_id' => $product->id,
                'url' => $product->main_image,
                'alt' => $product->title,
                'position' => $position,
            ]);
        }

        foreach ($gallery as $url) {
            // Avoid duplicate of main image
            if ($product->main_image && $url === $product->main_image) {
                continue;
            }
            $position++;
            ProductImage::create([
                'product_id' => $product->id,
                'url' => $url,
                'alt' => $product->title,
                'position' => $position,
            ]);
        }

        $this->line(($isNew ? 'CREATED' : 'UPDATED') . ": {$product->title}");
        return true;
    }

    protected function parsePriceToMillimes(string $price): int
    {
        if ($price === '') {
            return 0;
        }
        // Remove currency and non-numeric except separators
        $clean = preg_replace('/[^0-9,\.]/u', '', $price);
        if ($clean === null || $clean === '') {
            return 0;
        }
        // Remove thousand separators (.)
        // Then convert decimal comma to dot
        $clean = str_replace([' ', "\u{00A0}"], '', $clean);
        // If both comma and dot present, assume dot thousands and comma decimals
        if (str_contains($clean, ',') && str_contains($clean, '.')) {
            $clean = str_replace('.', '', $clean);
        }
        $clean = str_replace(',', '.', $clean);

        $value = (float) $clean; // e.g. 259.00
        $millimes = (int) round($value * 1000); // 259000
        return max(0, $millimes);
    }

    protected function resolveCategoryId(?string $slug): ?int
    {
        if (!$slug) {
            return null;
        }
        $cat = Category::where('slug', $slug)->first();
        return $cat?->id;
    }

    protected function resolvePath(string $path): ?string
    {
        // Try raw path
        if (file_exists($path)) {
            return realpath($path) ?: $path;
        }
        // Try relative to base_path
        $candidate = base_path($path);
        if (file_exists($candidate)) {
            return realpath($candidate) ?: $candidate;
        }
        return null;
    }

    protected function toBool(mixed $val): bool
    {
        if (is_bool($val)) return $val;
        $str = strtolower(trim((string) $val));
        return in_array($str, ['1', 'true', 'yes', 'y', 'on'], true);
    }
}
