<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        // On récupère uniquement les catégories racines, et on charge leurs enfants et le nombre de produits
        $rootCategories = Category::whereNull('parent_id')
            ->with(['children' => function ($query) {
                $query->withCount('products')->orderBy('position')->with(['children' => function ($q) {
                    $q->withCount('products')->orderBy('position');
                }]);
            }])
            ->withCount('products')
            ->orderBy('position', 'asc')
            ->get();

        // Pour l'ajout/édition, on a besoin de la liste plate pour le select "Parent"
        $allCategories = Category::orderBy('name')->get();

        return view('admin.categories.index', compact('rootCategories', 'allCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'icon' => 'nullable|string|max:255',
            'featured_image' => 'nullable|image|max:4096',
        ]);

        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id,
            'icon' => $request->icon,
        ]);

        if ($request->hasFile('featured_image')) {
            $this->saveFeaturedImage($category, $request->file('featured_image'));
        }

        return redirect()->back()->with('success', 'Catégorie créée avec succès.');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id|not_in:' . $category->id, // Ne peut pas être son propre parent
            'icon' => 'nullable|string|max:255',
            'featured_image' => 'nullable|image|max:4096',
            'remove_featured_image' => 'nullable|boolean',
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id,
            'icon' => $request->icon,
        ]);

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
}
