<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CatalogCollection;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductType;
use App\Models\Room;
use App\Models\ShowroomActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource with basic filters.
     */
    public function index(Request $request)
    {
        $query = Product::query()
            ->with(['category', 'room', 'productType', 'primaryCollection', 'showroomActivities'])
            ->withCount('images');

        $filters = [
            'q' => trim((string) $request->get('q', '')),
            'category_id' => $request->get('category_id'),
            'room_id' => $request->get('room_id'),
            'product_type_id' => $request->get('product_type_id'),
            'showroom_activity_id' => $request->get('showroom_activity_id'),
            'sale_type' => $request->get('sale_type'),
            'active' => $request->get('active'),
            'brand' => trim((string) $request->get('brand', '')),
        ];

        if ($filters['q'] !== '') {
            $q = $filters['q'];
            $query->where(function ($qq) use ($q) {
                $qq->where('title', 'like', "%{$q}%")
                    ->orWhere('short_description', 'like', "%{$q}%");
            });
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', (int) $filters['category_id']);
        }

        if (!empty($filters['room_id'])) {
            $query->where('room_id', (int) $filters['room_id']);
        }

        if (!empty($filters['product_type_id'])) {
            $query->where('product_type_id', (int) $filters['product_type_id']);
        }

        if (!empty($filters['showroom_activity_id'])) {
            $query->whereHas('showroomActivities', function ($activityQuery) use ($filters) {
                $activityQuery->where('showroom_activities.id', (int) $filters['showroom_activity_id']);
            });
        }

        if ($filters['sale_type'] === 'commandable') {
            $query->where('quote_only', false)->where('sale_mode', '!=', 'sur_mesure');
        }

        if ($filters['sale_type'] === 'sur-devis') {
            $query->where(function ($saleQuery) {
                $saleQuery->where('quote_only', true)->orWhere('sale_mode', 'sur_mesure');
            });
        }

        if ($filters['active'] !== null && $filters['active'] !== '') {
            $query->where('is_active', (int) $filters['active'] === 1);
        }

        if ($filters['brand'] !== '') {
            $query->where('brand', 'like', '%' . $filters['brand'] . '%');
        }

        $products = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::orderBy('name')->get();
        $rooms = Room::orderBy('position')->orderBy('name')->get();
        $productTypes = ProductType::with('room')->orderBy('position')->orderBy('name')->get();
        $showroomActivities = ShowroomActivity::where('is_active', true)->orderBy('sort_order')->orderBy('name')->get();

        return view('admin.products.index', compact('products', 'filters', 'categories', 'rooms', 'productTypes', 'showroomActivities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $rooms = Room::where('is_active', true)->orderBy('position')->orderBy('name')->get();
        $productTypes = ProductType::with('room')->where('is_active', true)->orderBy('position')->orderBy('name')->get();
        $collections = CatalogCollection::with('room')->where('is_active', true)->orderBy('position')->orderBy('name')->get();
        $showroomActivities = ShowroomActivity::where('is_active', true)->orderBy('sort_order')->orderBy('name')->get();

        return view('admin.products.create', [
            'categories' => $categories,
            'rooms' => $rooms,
            'productTypes' => $productTypes,
            'collections' => $collections,
            'showroomActivities' => $showroomActivities,
            'product' => new Product(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $quoteOnly = $request->boolean('quote_only') || $request->input('sale_mode') === 'sur_mesure';

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'room_id' => ['nullable', 'integer', 'exists:rooms,id'],
            'product_type_id' => ['nullable', 'integer', 'exists:product_types,id'],
            'primary_collection_id' => ['nullable', 'integer', 'exists:collections,id'],
            'collection_ids' => ['nullable', 'array'],
            'collection_ids.*' => ['integer', 'exists:collections,id'],
            'sale_mode' => ['required', 'string', 'in:catalog,sur_mesure'],
            'quote_only' => ['nullable', 'boolean'],
            'is_starting_price' => ['nullable', 'boolean'],
            'is_customizable' => ['nullable', 'boolean'],
            'price' => [$quoteOnly ? 'nullable' : 'required', 'string', 'max:50'], // e.g. "259" or "259 DT"
            'compare_at' => ['nullable', 'string', 'max:50'],
            'stock' => ['required', 'integer', 'min:0'],
            'sku' => ['nullable', 'string', 'max:100'],
            'brand' => ['nullable', 'string', 'max:150'],
            'showroom_badge' => ['nullable', 'string', 'max:80'],
            'material_summary' => ['nullable', 'string', 'max:255'],
            'dimension_summary' => ['nullable', 'string', 'max:255'],
            'availability_label' => ['nullable', 'string', 'max:255'],
            'delivery_note' => ['nullable', 'string', 'max:255'],
            'finish_summary' => ['nullable', 'string', 'max:255'],
            'main_image_url' => ['nullable', 'string', 'max:500'],
            'main_image_file' => ['nullable', 'image', 'max:4096'],
            'short_description' => ['nullable', 'string'],
            'long_description' => ['nullable', 'string'],
            'attributes_json' => ['nullable', 'string'],
            'custom_options_json' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'showroom_activity_ids' => ['nullable', 'array'],
            'showroom_activity_ids.*' => ['integer', 'exists:showroom_activities,id'],

            // gallery as newline-separated URLs
            'gallery_urls' => ['nullable', 'string'],
            // gallery uploaded files
            'gallery_files.*' => ['nullable', 'image', 'max:4096'],
        ]);

        $product = new Product();
        $product->title = $data['title'];
        $product->slug = filled($data['slug'] ?? null) ? Str::slug((string) $data['slug']) : null;
        $product->category_id = $data['category_id'] ?? null;
        $product->room_id = $data['room_id'] ?? null;
        $product->product_type_id = $data['product_type_id'] ?? null;
        $product->primary_collection_id = $data['primary_collection_id'] ?? null;
        $product->sale_mode = $data['sale_mode'];
        $product->quote_only = $quoteOnly;
        $product->is_starting_price = (bool) ($data['is_starting_price'] ?? false);
        $product->is_customizable = $quoteOnly || (bool) ($data['is_customizable'] ?? false);
        $product->price_millimes = filled($data['price'] ?? null) ? $this->parsePriceToMillimes((string) $data['price']) : null;
        $product->compare_at_millimes = isset($data['compare_at']) && $data['compare_at'] !== '' ? $this->parsePriceToMillimes((string) $data['compare_at']) : null;
        $product->stock = (int) $data['stock'];
        $product->sku = $data['sku'] ?? null;
        $product->brand = $data['brand'] ?? null;
        $product->showroom_badge = $data['showroom_badge'] ?? null;
        $product->material_summary = $data['material_summary'] ?? null;
        $product->dimension_summary = $data['dimension_summary'] ?? null;
        $product->availability_label = $data['availability_label'] ?? null;
        $product->delivery_note = $data['delivery_note'] ?? null;
        $product->finish_summary = $data['finish_summary'] ?? null;
        $product->short_description = $data['short_description'] ?? null;
        $product->long_description = $data['long_description'] ?? null;
        $product->is_active = (bool) ($data['is_active'] ?? false);

        // attributes JSON input (raw JSON string)
        if (!empty($data['attributes_json'])) {
            $decoded = json_decode($data['attributes_json'], true);
            $product->attributes = is_array($decoded) ? $decoded : null;
        }
        if (!empty($data['custom_options_json'])) {
            $decoded = json_decode($data['custom_options_json'], true);
            $product->custom_options = is_array($decoded) ? $decoded : null;
        }

        // Main image from uploaded file or URL
        if ($request->hasFile('main_image_file')) {
            $product->main_image = $this->storeUploadedImage($request->file('main_image_file'));
        } elseif (!empty($data['main_image_url'])) {
            $product->main_image = $data['main_image_url'];
        }

        $product->save();
        $this->syncCollections($product, $data['collection_ids'] ?? [], $product->primary_collection_id);
        $this->syncShowroomActivities($product, $data['showroom_activity_ids'] ?? []);

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
        $rooms = Room::where('is_active', true)->orderBy('position')->orderBy('name')->get();
        $productTypes = ProductType::with('room')->where('is_active', true)->orderBy('position')->orderBy('name')->get();
        $collections = CatalogCollection::with('room')->where('is_active', true)->orderBy('position')->orderBy('name')->get();
        $showroomActivities = ShowroomActivity::where('is_active', true)->orderBy('sort_order')->orderBy('name')->get();

        $existingGallery = $product->images()->pluck('url')->toArray();
        $existingGalleryText = implode("\n", array_filter($existingGallery, fn ($u) => $u !== $product->main_image));
        $selectedShowroomActivityIds = $product->showroomActivities()->pluck('showroom_activities.id')->all();

        return view('admin.products.edit', [
            'categories' => $categories,
            'rooms' => $rooms,
            'productTypes' => $productTypes,
            'collections' => $collections,
            'showroomActivities' => $showroomActivities,
            'product' => $product->load(['images', 'collections', 'showroomActivities']),
            'existingGalleryText' => $existingGalleryText,
            'selectedShowroomActivityIds' => $selectedShowroomActivityIds,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $quoteOnly = $request->boolean('quote_only') || $request->input('sale_mode') === 'sur_mesure';

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('products', 'slug')->ignore($product->id)],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'room_id' => ['nullable', 'integer', 'exists:rooms,id'],
            'product_type_id' => ['nullable', 'integer', 'exists:product_types,id'],
            'primary_collection_id' => ['nullable', 'integer', 'exists:collections,id'],
            'collection_ids' => ['nullable', 'array'],
            'collection_ids.*' => ['integer', 'exists:collections,id'],
            'sale_mode' => ['required', 'string', 'in:catalog,sur_mesure'],
            'quote_only' => ['nullable', 'boolean'],
            'is_starting_price' => ['nullable', 'boolean'],
            'is_customizable' => ['nullable', 'boolean'],
            'price' => [$quoteOnly ? 'nullable' : 'required', 'string', 'max:50'],
            'compare_at' => ['nullable', 'string', 'max:50'],
            'stock' => ['required', 'integer', 'min:0'],
            'sku' => ['nullable', 'string', 'max:100'],
            'brand' => ['nullable', 'string', 'max:150'],
            'showroom_badge' => ['nullable', 'string', 'max:80'],
            'material_summary' => ['nullable', 'string', 'max:255'],
            'dimension_summary' => ['nullable', 'string', 'max:255'],
            'availability_label' => ['nullable', 'string', 'max:255'],
            'delivery_note' => ['nullable', 'string', 'max:255'],
            'finish_summary' => ['nullable', 'string', 'max:255'],
            'main_image_url' => ['nullable', 'string', 'max:500'],
            'main_image_file' => ['nullable', 'image', 'max:4096'],
            'short_description' => ['nullable', 'string'],
            'long_description' => ['nullable', 'string'],
            'attributes_json' => ['nullable', 'string'],
            'custom_options_json' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'showroom_activity_ids' => ['nullable', 'array'],
            'showroom_activity_ids.*' => ['integer', 'exists:showroom_activities,id'],

            'gallery_urls' => ['nullable', 'string'],
            'gallery_files.*' => ['nullable', 'image', 'max:4096'],
            'replace_gallery' => ['nullable', 'boolean'],
        ]);

        $product->title = $data['title'];
        $product->slug = filled($data['slug'] ?? null) ? Str::slug((string) $data['slug']) : null;
        $product->category_id = $data['category_id'] ?? null;
        $product->room_id = $data['room_id'] ?? null;
        $product->product_type_id = $data['product_type_id'] ?? null;
        $product->primary_collection_id = $data['primary_collection_id'] ?? null;
        $product->sale_mode = $data['sale_mode'];
        $product->quote_only = $quoteOnly;
        $product->is_starting_price = (bool) ($data['is_starting_price'] ?? false);
        $product->is_customizable = $quoteOnly || (bool) ($data['is_customizable'] ?? false);
        $product->price_millimes = filled($data['price'] ?? null) ? $this->parsePriceToMillimes((string) $data['price']) : null;
        $product->compare_at_millimes = isset($data['compare_at']) && $data['compare_at'] !== '' ? $this->parsePriceToMillimes((string) $data['compare_at']) : null;
        $product->stock = (int) $data['stock'];
        $product->sku = $data['sku'] ?? null;
        $product->brand = $data['brand'] ?? null;
        $product->showroom_badge = $data['showroom_badge'] ?? null;
        $product->material_summary = $data['material_summary'] ?? null;
        $product->dimension_summary = $data['dimension_summary'] ?? null;
        $product->availability_label = $data['availability_label'] ?? null;
        $product->delivery_note = $data['delivery_note'] ?? null;
        $product->finish_summary = $data['finish_summary'] ?? null;
        $product->short_description = $data['short_description'] ?? null;
        $product->long_description = $data['long_description'] ?? null;
        $product->is_active = (bool) ($data['is_active'] ?? false);

        if (!empty($data['attributes_json'])) {
            $decoded = json_decode($data['attributes_json'], true);
            $product->attributes = is_array($decoded) ? $decoded : null;
        } else {
            $product->attributes = null;
        }
        if (!empty($data['custom_options_json'])) {
            $decoded = json_decode($data['custom_options_json'], true);
            $product->custom_options = is_array($decoded) ? $decoded : null;
        } else {
            $product->custom_options = null;
        }

        // Main image
        if ($request->hasFile('main_image_file')) {
            $product->main_image = $this->storeUploadedImage($request->file('main_image_file'));
        } elseif (!empty($data['main_image_url'])) {
            $product->main_image = $data['main_image_url'];
        }

        $product->save();
        $this->syncCollections($product, $data['collection_ids'] ?? [], $product->primary_collection_id);
        $this->syncShowroomActivities($product, $data['showroom_activity_ids'] ?? []);

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

    protected function syncCollections(Product $product, array $collectionIds, ?int $primaryCollectionId): void
    {
        $ids = collect($collectionIds)
            ->map(fn ($id) => (int) $id)
            ->filter()
            ->unique()
            ->values();

        if ($primaryCollectionId) {
            $ids = $ids->prepend($primaryCollectionId)->unique()->values();
        }

        $payload = $ids->mapWithKeys(function (int $id, int $index) use ($primaryCollectionId) {
            return [
                $id => [
                    'position' => $index,
                    'is_featured' => $primaryCollectionId ? $id === $primaryCollectionId : $index === 0,
                ],
            ];
        })->all();

        $product->collections()->sync($payload);
    }

    protected function syncShowroomActivities(Product $product, array $activityIds): void
    {
        $payload = collect($activityIds)
            ->map(fn ($id) => (int) $id)
            ->filter()
            ->unique()
            ->values()
            ->mapWithKeys(fn (int $id, int $index) => [$id => ['sort_order' => $index]])
            ->all();

        $product->showroomActivities()->sync($payload);
    }
}
