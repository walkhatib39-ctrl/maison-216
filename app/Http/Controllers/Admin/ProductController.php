<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource with basic filters.
     */
    public function index(Request $request)
    {
        $query = Product::query()->with('category');

        $filters = [
            'q' => trim((string) $request->get('q', '')),
            'category_id' => $request->get('category_id'),
            'active' => $request->get('active'),
            'brand' => trim((string) $request->get('brand', '')),
        ];

        if ($filters['q'] !== '') {
            $q = $filters['q'];
            $query->where(function ($qq) use ($q) {
                $qq->where('title', 'like', "%{$q}%")
                    ->orWhere('sku', 'like', "%{$q}%");
            });
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', (int) $filters['category_id']);
        }

        if ($filters['active'] !== null && $filters['active'] !== '') {
            $query->where('is_active', (int) $filters['active'] === 1);
        }

        if ($filters['brand'] !== '') {
            $query->where('brand', 'like', '%' . $filters['brand'] . '%');
        }

        $products = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'filters', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.create', [
            'categories' => $categories,
            'product' => new Product(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'price' => ['required', 'string', 'max:50'], // e.g. "259" or "259 DT"
            'compare_at' => ['nullable', 'string', 'max:50'],
            'stock' => ['required', 'integer', 'min:0'],
            'sku' => ['nullable', 'string', 'max:100'],
            'brand' => ['nullable', 'string', 'max:150'],
            'main_image_url' => ['nullable', 'url'],
            'main_image_file' => ['nullable', 'image', 'max:4096'],
            'short_description' => ['nullable', 'string'],
            'long_description' => ['nullable', 'string'],
            'attributes_json' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],

            // gallery as newline-separated URLs
            'gallery_urls' => ['nullable', 'string'],
            // gallery uploaded files
            'gallery_files.*' => ['nullable', 'image', 'max:4096'],
        ]);

        $product = new Product();
        $product->title = $data['title'];
        $product->category_id = $data['category_id'] ?? null;
        $product->price_millimes = $this->parsePriceToMillimes((string) $data['price']);
        $product->compare_at_millimes = isset($data['compare_at']) && $data['compare_at'] !== '' ? $this->parsePriceToMillimes((string) $data['compare_at']) : null;
        $product->stock = (int) $data['stock'];
        $product->sku = $data['sku'] ?? null;
        $product->brand = $data['brand'] ?? null;
        $product->short_description = $data['short_description'] ?? null;
        $product->long_description = $data['long_description'] ?? null;
        $product->is_active = (bool) ($data['is_active'] ?? false);

        // attributes JSON input (raw JSON string)
        if (!empty($data['attributes_json'])) {
            $decoded = json_decode($data['attributes_json'], true);
            $product->attributes = is_array($decoded) ? $decoded : null;
        }

        // Main image from uploaded file or URL
        if ($request->hasFile('main_image_file')) {
            $product->main_image = $this->storeUploadedImage($request->file('main_image_file'));
        } elseif (!empty($data['main_image_url'])) {
            $product->main_image = $data['main_image_url'];
        }

        $product->save();

        // Build gallery list: main first then others
        $gallery = [];

        if ($product->main_image) {
            $gallery[] = $product->main_image;
        }

        // Add gallery URLs from textarea
        $gallery = array_merge($gallery, $this->parseGalleryUrls((string) ($data['gallery_urls'] ?? '')));

        // Add uploaded gallery files
        if ($request->hasFile('gallery_files')) {
            foreach ((array) $request->file('gallery_files') as $file) {
                if ($file) {
                    $gallery[] = $this->storeUploadedImage($file);
                }
            }
        }

        // Filter duplicates and empty
        $gallery = array_values(array_unique(array_filter($gallery)));

        // Save ProductImage records
        $position = 0;
        foreach ($gallery as $url) {
            $position++;
            ProductImage::create([
                'product_id' => $product->id,
                'url' => $url,
                'alt' => $product->title,
                'position' => $position,
            ]);
        }

        return redirect()->route('admin.products.index')->with('status', 'Produit créé.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();

        $existingGallery = $product->images()->pluck('url')->toArray();
        $existingGalleryText = implode("\n", array_filter($existingGallery, fn ($u) => $u !== $product->main_image));

        return view('admin.products.edit', [
            'categories' => $categories,
            'product' => $product->load('images'),
            'existingGalleryText' => $existingGalleryText,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'price' => ['required', 'string', 'max:50'],
            'compare_at' => ['nullable', 'string', 'max:50'],
            'stock' => ['required', 'integer', 'min:0'],
            'sku' => ['nullable', 'string', 'max:100'],
            'brand' => ['nullable', 'string', 'max:150'],
            'main_image_url' => ['nullable', 'url'],
            'main_image_file' => ['nullable', 'image', 'max:4096'],
            'short_description' => ['nullable', 'string'],
            'long_description' => ['nullable', 'string'],
            'attributes_json' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],

            'gallery_urls' => ['nullable', 'string'],
            'gallery_files.*' => ['nullable', 'image', 'max:4096'],
            'replace_gallery' => ['nullable', 'boolean'],
        ]);

        $product->title = $data['title'];
        $product->category_id = $data['category_id'] ?? null;
        $product->price_millimes = $this->parsePriceToMillimes((string) $data['price']);
        $product->compare_at_millimes = isset($data['compare_at']) && $data['compare_at'] !== '' ? $this->parsePriceToMillimes((string) $data['compare_at']) : null;
        $product->stock = (int) $data['stock'];
        $product->sku = $data['sku'] ?? null;
        $product->brand = $data['brand'] ?? null;
        $product->short_description = $data['short_description'] ?? null;
        $product->long_description = $data['long_description'] ?? null;
        $product->is_active = (bool) ($data['is_active'] ?? false);

        if (!empty($data['attributes_json'])) {
            $decoded = json_decode($data['attributes_json'], true);
            $product->attributes = is_array($decoded) ? $decoded : null;
        } else {
            $product->attributes = null;
        }

        // Main image
        if ($request->hasFile('main_image_file')) {
            $product->main_image = $this->storeUploadedImage($request->file('main_image_file'));
        } elseif (!empty($data['main_image_url'])) {
            $product->main_image = $data['main_image_url'];
        }

        $product->save();

        // Gallery management
        $newGallery = [];

        if (($data['replace_gallery'] ?? false)) {
            // Replace entire gallery
            $product->images()->delete();

            if ($product->main_image) {
                $newGallery[] = $product->main_image;
            }
        } else {
            // Keep existing gallery (including main image if present)
            $newGallery = $product->images()->orderBy('position')->pluck('url')->toArray();

            // Ensure main image first
            if ($product->main_image && (empty($newGallery) || $newGallery[0] !== $product->main_image)) {
                $newGallery = array_values(array_unique(array_merge([$product->main_image], $newGallery)));
            }
            $product->images()->delete();
        }

        // Add new URL entries
        $newGallery = array_merge($newGallery, $this->parseGalleryUrls((string) ($data['gallery_urls'] ?? '')));

        // Add uploaded files
        if ($request->hasFile('gallery_files')) {
            foreach ((array) $request->file('gallery_files') as $file) {
                if ($file) {
                    $newGallery[] = $this->storeUploadedImage($file);
                }
            }
        }

        // Persist
        $newGallery = array_values(array_unique(array_filter($newGallery)));
        $pos = 0;
        foreach ($newGallery as $url) {
            $pos++;
            ProductImage::create([
                'product_id' => $product->id,
                'url' => $url,
                'alt' => $product->title,
                'position' => $pos,
            ]);
        }

        return redirect()->route('admin.products.index')->with('status', 'Produit mis à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return back()->with('status', 'Produit supprimé.');
    }

    /**
     * UI form for JSON import.
     */
    public function importForm()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.import', [
            'categories' => $categories,
        ]);
    }

    /**
     * Handle JSON import from uploaded file using simplified logic from CLI command.
     */
    public function import(Request $request)
    {
        $data = $request->validate([
            'file' => ['required', 'file', 'mimes:json,txt'],
            'category_slug' => ['nullable', 'string', 'max:255'],
            'brand' => ['nullable', 'string', 'max:150'],
            'active' => ['nullable', 'boolean'],
            'limit' => ['nullable', 'integer', 'min:1', 'max:1000'],
            'dry_run' => ['nullable', 'boolean'],
        ]);

        $path = $request->file('file')->getRealPath();
        $json = File::get($path);
        $json = preg_replace('/^\xEF\xBB\xBF/', '', $json ?? '');
        $decoded = json_decode($json, true);

        if ($decoded === null) {
            return back()->withErrors(['file' => 'JSON invalide.'])->withInput();
        }

        $items = [];
        if (isset($decoded['products']) && is_array($decoded['products'])) {
            $items = $decoded['products'];
        } elseif (is_array($decoded)) {
            $items = $decoded;
        }

        $categoryId = null;
        if (!empty($data['category_slug'])) {
            $cat = Category::where('slug', $data['category_slug'])->first();
            $categoryId = $cat?->id;
        }

        $brand = $data['brand'] ?? null;
        $active = (bool) ($data['active'] ?? true);
        $dry = (bool) ($data['dry_run'] ?? false);
        $limit = $data['limit'] ?? null;

        $imported = 0;
        $errors = 0;

        foreach ($items as $idx => $item) {
            if ($limit !== null && $imported >= $limit) {
                break;
            }
            if (!is_array($item)) {
                continue;
            }
            try {
                $ok = $this->importItem($item, $categoryId, $brand, $active, $dry);
                if ($ok) {
                    $imported++;
                }
            } catch (\Throwable $e) {
                $errors++;
            }
        }

        $msg = $dry
            ? "DRY-RUN: {$imported} éléments traités."
            : "{$imported} produits importés" . ($errors ? " ({$errors} erreurs)" : '');

        return redirect()->route('admin.products.index')->with('status', $msg);
    }

    // ---------- Helpers ----------

    protected function importItem(array $item, ?int $categoryId, ?string $brand, bool $active, bool $dry): bool
    {
        $title = trim((string) ($item['title'] ?? ''));
        if ($title === '') {
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

        $attrs = [];
        if (isset($item['productInfo']) && is_array($item['productInfo'])) {
            foreach ($item['productInfo'] as $k => $v) {
                $kNorm = trim((string) $k);
                $vStr = is_string($v) ? $v : (is_numeric($v) ? (string) $v : json_encode($v));
                $vNorm = preg_replace('/\s+/u', ' ', trim((string) $vStr));
                $attrs[$kNorm] = $vNorm;
            }
        }
        if (!empty($item['url'])) {
            $attrs['source_url'] = (string) $item['url'];
        }

        $product = Product::where('title', $title)->first();
        $isNew = false;
        if (!$product) {
            $product = new Product();
            $isNew = true;
        }

        $product->title = $title;
        if ($isNew) {
            $product->slug = null;
        }
        $product->category_id = $categoryId;
        $product->price_millimes = $priceMillimes;
        $product->compare_at_millimes = null;
        $product->stock = $product->stock ?? 0;
        $product->sku = $product->sku ?? null;
        $product->brand = $brand ?? ($product->brand ?? null);
        $product->main_image = $mainImage ?: $product->main_image;
        $product->short_description = $shortHtml ?: null;
        $product->long_description = $longHtml ?: null;
        $product->attributes = $attrs ?: null;
        $product->is_active = $active;

        if ($dry) {
            return true;
        }

        $product->save();

        // Reset and insert gallery images
        $product->images()->delete();
        $position = 0;

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

        return true;
    }

    protected function parsePriceToMillimes(string $price): int
    {
        $price = trim($price);
        if ($price === '') {
            return 0;
        }
        // Remove non-numeric except separators
        $clean = preg_replace('/[^0-9,\.]/u', '', $price);
        if ($clean === null || $clean === '') {
            return 0;
        }
        // Handle space & non-breaking space
        $clean = str_replace([' ', "\u{00A0}"], '', $clean);
        if (str_contains($clean, ',') && str_contains($clean, '.')) {
            // assume dot thousands and comma decimals
            $clean = str_replace('.', '', $clean);
        }
        $clean = str_replace(',', '.', $clean);

        $value = (float) $clean;
        return (int) round($value * 1000);
    }

    protected function parseGalleryUrls(string $text): array
    {
        $lines = preg_split('/\r\n|\r|\n/', $text);
        $urls = [];
        foreach ($lines as $l) {
            $u = trim($l);
            if ($u !== '') {
                $urls[] = $u;
            }
        }
        return $urls;
    }

    protected function storeUploadedImage(\Illuminate\Http\UploadedFile $file): string
    {
        $path = $file->store('public/products');
        // Convert to public URL
        return Storage::url($path);
    }

    /**
     * Toggle active/inactive flag for a product (AJAX-safe, but simple POST back).
     */
    public function toggle(Product $product)
    {
        $product->is_active = !$product->is_active;
        $product->save();

        return back()->with('status', 'Statut produit mis à jour.');
    }
}
