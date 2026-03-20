<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductType;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductTypeController extends Controller
{
    public function index()
    {
        $productTypes = ProductType::query()
            ->with('room')
            ->withCount(['products', 'categories'])
            ->orderBy('position')
            ->orderBy('name')
            ->get();

        $rooms = Room::query()
            ->where('is_active', true)
            ->orderBy('position')
            ->orderBy('name')
            ->get();

        return view('admin.catalog.product-types.index', compact('productTypes', 'rooms'));
    }

    public function store(Request $request)
    {
        ProductType::create($this->validatedData($request));

        return back()->with('success', 'Type de produit créé avec succès.');
    }

    public function update(Request $request, ProductType $productType)
    {
        $productType->update($this->validatedData($request, $productType));

        return back()->with('success', 'Type de produit mis à jour.');
    }

    public function destroy(ProductType $productType)
    {
        if ($productType->products()->exists() || $productType->categories()->exists()) {
            return back()->with('error', "Impossible de supprimer ce type tant qu'il est utilisé.");
        }

        $productType->delete();

        return back()->with('success', 'Type de produit supprimé.');
    }

    protected function validatedData(Request $request, ?ProductType $productType = null): array
    {
        return $request->validate([
            'room_id' => ['nullable', 'exists:rooms,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('product_types', 'slug')->ignore($productType?->id)],
            'code' => ['nullable', 'string', 'max:50', Rule::unique('product_types', 'code')->ignore($productType?->id)],
            'short_label' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'position' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]) + [
            'is_active' => $request->boolean('is_active'),
            'position' => (int) $request->input('position', 0),
        ];
    }
}
