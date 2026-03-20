<?php

namespace App\Support;

use App\Models\CatalogCollection;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Room;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\Schema;

class StorefrontCatalog
{
    protected ?SupportCollection $rootCategoriesCache = null;

    public function architectureReady(): bool
    {
        return Schema::hasTable('rooms')
            && Schema::hasTable('product_types')
            && Schema::hasTable('collections')
            && Schema::hasColumn('products', 'room_id')
            && Schema::hasColumn('products', 'product_type_id')
            && Schema::hasColumn('products', 'primary_collection_id')
            && Schema::hasColumn('categories', 'room_id')
            && Schema::hasColumn('categories', 'product_type_id');
    }

    public function showcaseRooms(int $limit = 6): SupportCollection
    {
        if ($this->architectureReady()) {
            $rooms = Room::query()
                ->where('is_active', true)
                ->with([
                    'productTypes' => fn ($query) => $query->where('is_active', true)->orderBy('position')->orderBy('name'),
                    'categories' => fn ($query) => $query->whereNull('parent_id')->orderBy('position')->orderBy('name'),
                ])
                ->withCount(['products', 'categories', 'collections'])
                ->orderBy('position')
                ->orderBy('name')
                ->take($limit)
                ->get();

            if ($rooms->isNotEmpty()) {
                return $rooms->map(function (Room $room) {
                    return [
                        'name' => $room->name,
                        'slug' => $room->slug,
                        'tagline' => $room->tagline ?: 'Explorez les modules, collections et compositions de cet univers.',
                        'href' => $this->roomUrl($room),
                        'image' => $this->resolveRoomImage($room),
                        'count' => (int) ($room->products_count ?? 0),
                        'subitems' => $room->productTypes->take(4)->pluck('name')->values(),
                        'collections_count' => (int) ($room->collections_count ?? 0),
                    ];
                });
            }
        }

        return $this->rootCategories()->take($limit)->map(function (Category $category) {
            return [
                'name' => $category->name,
                'slug' => $category->slug,
                'tagline' => $category->children->take(4)->pluck('name')->join(' • ') ?: 'Découvrez nos meilleures sélections pour cet univers.',
                'href' => route('category.show', $category->slug),
                'image' => $this->resolveCategoryImage($category),
                'count' => (int) $category->total_products_count,
                'subitems' => $category->children->take(4)->pluck('name')->values(),
                'collections_count' => 0,
            ];
        })->values();
    }

    public function composerTypes(int $limit = 6): SupportCollection
    {
        if ($this->architectureReady()) {
            $types = ProductType::query()
                ->where('is_active', true)
                ->with([
                    'room',
                    'categories' => fn ($query) => $query->orderBy('position')->orderBy('name'),
                ])
                ->withCount('products')
                ->orderByDesc('products_count')
                ->orderBy('position')
                ->take($limit)
                ->get();

            if ($types->isNotEmpty()) {
                return $types->map(function (ProductType $type) {
                    return [
                        'name' => $type->short_label ?: $type->name,
                        'eyebrow' => $type->room?->name ?: 'Composer',
                        'description' => $type->description ?: "Entrez par le module {$type->name} et construisez une offre plus précise.",
                        'href' => $this->productTypeUrl($type),
                        'badge' => (int) ($type->products_count ?? 0) . ' produits',
                    ];
                });
            }
        }

        $types = $this->rootCategories()
            ->flatMap(fn (Category $category) => $category->children->map(fn (Category $child) => [$category, $child]))
            ->take($limit);

        return $types->map(function (array $pair) {
            [$parent, $child] = $pair;

            return [
                'name' => $child->name,
                'eyebrow' => $parent->name,
                'description' => "Commencez par {$child->name} puis affinez votre pièce selon vos besoins.",
                'href' => route('category.show', $child->slug),
                'badge' => (int) $child->products_count . ' produits',
            ];
        })->values();
    }

    public function featuredCollections(int $limit = 3): SupportCollection
    {
        if (!$this->architectureReady()) {
            return collect();
        }

        $collections = CatalogCollection::query()
            ->where('is_active', true)
            ->with('room')
            ->withCount(['products', 'primaryProducts'])
            ->orderBy('position')
            ->orderBy('name')
            ->take($limit)
            ->get();

        return $collections->map(function (CatalogCollection $collection) {
            return [
                'name' => $collection->name,
                'eyebrow' => $collection->badge_label ?: ($collection->room?->name ?: 'Collection signature'),
                'family' => $collection->aesthetic_family,
                'description' => $collection->description ?: 'Une ligne cohérente à décliner par modules ou par composition prête.',
                'href' => $this->collectionUrl($collection),
                'count' => (int) (($collection->products_count ?? 0) + ($collection->primary_products_count ?? 0)),
            ];
        })->filter(fn (array $collection) => !empty($collection['name']))->values();
    }

    public function footerCategories(int $limit = 6): SupportCollection
    {
        return $this->showcaseRooms($limit)->map(fn (array $room) => [
            'name' => $room['name'],
            'href' => $room['href'],
            'count' => $room['count'],
        ]);
    }

    public function rootCategories(): SupportCollection
    {
        if ($this->rootCategoriesCache) {
            return $this->rootCategoriesCache;
        }

        $this->rootCategoriesCache = Category::query()
            ->whereNull('parent_id')
            ->orderBy('position')
            ->with([
                'children' => fn ($query) => $query->orderBy('position')->withCount('products'),
            ])
            ->withCount('products')
            ->get();

        return $this->rootCategoriesCache;
    }

    protected function roomUrl(Room $room): string
    {
        $linkedCategory = $room->categories->first();

        if ($linkedCategory) {
            return route('category.show', $linkedCategory->slug);
        }

        $matchingCategory = Category::where('slug', $room->slug)->first();

        return $matchingCategory
            ? route('category.show', $matchingCategory->slug)
            : route('categories.index');
    }

    protected function productTypeUrl(ProductType $type): string
    {
        $linkedCategory = $type->categories->first();

        if ($linkedCategory) {
            return route('category.show', $linkedCategory->slug);
        }

        $matchingCategory = Category::where('slug', $type->slug)->first();

        return $matchingCategory
            ? route('category.show', $matchingCategory->slug)
            : route('categories.index');
    }

    protected function collectionUrl(CatalogCollection $collection): string
    {
        $primaryProduct = Product::query()
            ->where('primary_collection_id', $collection->id)
            ->where('is_active', true)
            ->with('category')
            ->latest()
            ->first();

        if ($primaryProduct?->category?->slug) {
            return route('category.show', $primaryProduct->category->slug);
        }

        return route('categories.index');
    }

    protected function resolveRoomImage(Room $room): ?string
    {
        $categoryImage = $room->categories->first()?->featured_image;
        if (!empty($categoryImage)) {
            return $categoryImage;
        }

        return Product::query()
            ->where('room_id', $room->id)
            ->where('is_active', true)
            ->whereNotNull('main_image')
            ->where('main_image', '!=', '')
            ->value('main_image');
    }

    protected function resolveCategoryImage(Category $category): ?string
    {
        if (!empty($category->featured_image)) {
            return $category->featured_image;
        }

        $directImage = Product::query()
            ->where('category_id', $category->id)
            ->where('is_active', true)
            ->whereNotNull('main_image')
            ->where('main_image', '!=', '')
            ->value('main_image');

        if ($directImage) {
            return $directImage;
        }

        $childrenIds = $category->children->pluck('id');

        if ($childrenIds->isEmpty()) {
            return null;
        }

        return Product::query()
            ->whereIn('category_id', $childrenIds)
            ->where('is_active', true)
            ->whereNotNull('main_image')
            ->where('main_image', '!=', '')
            ->value('main_image');
    }
}
