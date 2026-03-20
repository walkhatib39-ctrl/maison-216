<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ProductType;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $architectureEnabled = $this->architectureEnabled();

        // On récupère uniquement les catégories racines, et on charge leurs enfants et le nombre de produits
        $rootCategories = Category::whereNull('parent_id')
            ->with([
                'room',
                'productType',
                'children' => function ($query) {
                    $query->withCount('products')
                        ->with(['room', 'productType'])
                        ->orderBy('position')
                        ->with([
                            'children' => function ($q) {
                                $q->withCount('products')
                                    ->with(['room', 'productType'])
                                    ->orderBy('position');
                            },
                        ]);
                },
            ])
            ->withCount('products')
            ->orderBy('position', 'asc')
            ->get();

        // Pour l'ajout/édition, on a besoin de la liste plate pour le select "Parent"
        $allCategories = Category::orderBy('name')->get();
        $rooms = $architectureEnabled
            ? Room::where('is_active', true)->orderBy('position')->orderBy('name')->get()
            : collect();
        $productTypes = $architectureEnabled
            ? ProductType::with('room')->where('is_active', true)->orderBy('position')->orderBy('name')->get()
            : collect();

        return view('admin.categories.index', compact('rootCategories', 'allCategories', 'rooms', 'productTypes', 'architectureEnabled'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'icon' => 'nullable|string|max:255',
            'featured_image' => 'nullable|image|max:4096',
        ];

        if ($this->architectureEnabled()) {
            $rules = array_merge($rules, [
                'room_id' => 'nullable|exists:rooms,id',
                'product_type_id' => 'nullable|exists:product_types,id',
                'category_kind' => 'nullable|string|max:50',
                'landing_intro' => 'nullable|string|max:5000',
                'landing_outro' => 'nullable|string|max:5000',
                'is_indexable' => 'nullable|boolean',
            ]);
        }

        $data = $request->validate($rules);

        $payload = [
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'parent_id' => $data['parent_id'] ?? null,
            'icon' => $data['icon'] ?? null,
        ];

        if ($this->architectureEnabled()) {
            $payload = array_merge($payload, [
                'room_id' => $data['room_id'] ?? null,
                'product_type_id' => $data['product_type_id'] ?? null,
                'category_kind' => $data['category_kind'] ?? 'catalog',
                'landing_intro' => $data['landing_intro'] ?? null,
                'landing_outro' => $data['landing_outro'] ?? null,
                'is_indexable' => $request->boolean('is_indexable', true),
            ]);
        }

        $category = Category::create($payload);

        if ($request->hasFile('featured_image')) {
            $this->saveFeaturedImage($category, $request->file('featured_image'));
        }

        return redirect()->back()->with('success', 'Catégorie créée avec succès.');
    }

    public function update(Request $request, Category $category)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id|not_in:' . $category->id, // Ne peut pas être son propre parent
            'icon' => 'nullable|string|max:255',
            'featured_image' => 'nullable|image|max:4096',
            'remove_featured_image' => 'nullable|boolean',
        ];

        if ($this->architectureEnabled()) {
            $rules = array_merge($rules, [
                'room_id' => 'nullable|exists:rooms,id',
                'product_type_id' => 'nullable|exists:product_types,id',
                'category_kind' => 'nullable|string|max:50',
                'landing_intro' => 'nullable|string|max:5000',
                'landing_outro' => 'nullable|string|max:5000',
                'is_indexable' => 'nullable|boolean',
            ]);
        }

        $data = $request->validate($rules);

        $payload = [
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'parent_id' => $data['parent_id'] ?? null,
            'icon' => $data['icon'] ?? null,
        ];

        if ($this->architectureEnabled()) {
            $payload = array_merge($payload, [
                'room_id' => $data['room_id'] ?? null,
                'product_type_id' => $data['product_type_id'] ?? null,
                'category_kind' => $data['category_kind'] ?? 'catalog',
                'landing_intro' => $data['landing_intro'] ?? null,
                'landing_outro' => $data['landing_outro'] ?? null,
                'is_indexable' => $request->boolean('is_indexable', true),
            ]);
        }

        $category->update($payload);

        if ($request->hasFile('featured_image')) {
            $this->saveFeaturedImage($category, $request->file('featured_image'));
        } elseif ($request->boolean('remove_featured_image')) {
            $this->deleteFeaturedImage($category);
        }

        return redirect()->back()->with('success', 'Catégorie mise à jour.');
    }

    private function saveFeaturedImage(Category $category, \Illuminate\Http\UploadedFile $file): void
    {
        $dir = public_path('images/categories');
        if (!File::exists($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        $ext = strtolower($file->getClientOriginalExtension() ?: 'jpg');
        $filename = 'cat-' . $category->id . '-' . time() . '.' . $ext;
        $file->move($dir, $filename);

        if (!empty($category->featured_image)) {
            $oldPath = public_path($category->featured_image);
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
        }

        $category->featured_image = 'images/categories/' . $filename;
        $category->save();
    }

    private function deleteFeaturedImage(Category $category): void
    {
        if (!empty($category->featured_image)) {
            $oldPath = public_path($category->featured_image);
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
        }

        $category->featured_image = null;
        $category->save();
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->back()->with('success', 'Catégorie supprimée.');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:categories,id',
        ]);

        $ids = $request->ids;
        $count = 0;

        foreach ($ids as $id) {
            $category = Category::find($id);
            if ($category) {
                // Individual delete triggers model events (cascade delete)
                $category->delete();
                $count++;
            }
        }

        return redirect()->back()->with('success', "$count catégories supprimées avec succès.");
    }

    protected function architectureEnabled(): bool
    {
        return Schema::hasTable('rooms')
            && Schema::hasTable('product_types')
            && Schema::hasColumn('categories', 'room_id')
            && Schema::hasColumn('categories', 'product_type_id');
    }
}
