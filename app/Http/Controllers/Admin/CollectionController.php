<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CatalogCollection;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CollectionController extends Controller
{
    public function index()
    {
        $collections = CatalogCollection::query()
            ->with('room')
            ->withCount(['products', 'primaryProducts'])
            ->orderBy('position')
            ->orderBy('name')
            ->get();

        $rooms = Room::query()
            ->where('is_active', true)
            ->orderBy('position')
            ->orderBy('name')
            ->get();

        return view('admin.catalog.collections.index', compact('collections', 'rooms'));
    }

    public function store(Request $request)
    {
        CatalogCollection::create($this->validatedData($request));

        return back()->with('success', 'Collection créée avec succès.');
    }

    public function update(Request $request, CatalogCollection $collection)
    {
        $collection->update($this->validatedData($request, $collection));

        return back()->with('success', 'Collection mise à jour.');
    }

    public function destroy(CatalogCollection $collection)
    {
        if ($collection->products()->exists() || $collection->primaryProducts()->exists()) {
            return back()->with('error', "Impossible de supprimer cette collection tant qu'elle est liée à des produits.");
        }

        $collection->delete();

        return back()->with('success', 'Collection supprimée.');
    }

    protected function validatedData(Request $request, ?CatalogCollection $collection = null): array
    {
        return $request->validate([
            'room_id' => ['nullable', 'exists:rooms,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('collections', 'slug')->ignore($collection?->id)],
            'code' => ['nullable', 'string', 'max:50', Rule::unique('collections', 'code')->ignore($collection?->id)],
            'aesthetic_family' => ['nullable', 'string', 'max:255'],
            'badge_label' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'position' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]) + [
            'is_active' => $request->boolean('is_active'),
            'position' => (int) $request->input('position', 0),
        ];
    }
}
