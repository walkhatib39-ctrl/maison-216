<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::query()
            ->withCount(['products', 'categories', 'productTypes', 'collections'])
            ->orderBy('position')
            ->orderBy('name')
            ->get();

        return view('admin.catalog.rooms.index', compact('rooms'));
    }

    public function store(Request $request)
    {
        Room::create($this->validatedData($request));

        return back()->with('success', 'Univers créé avec succès.');
    }

    public function update(Request $request, Room $room)
    {
        $room->update($this->validatedData($request, $room));

        return back()->with('success', 'Univers mis à jour.');
    }

    public function destroy(Room $room)
    {
        if (
            $room->products()->exists() ||
            $room->categories()->exists() ||
            $room->productTypes()->exists() ||
            $room->collections()->exists()
        ) {
            return back()->with('error', "Impossible de supprimer cet univers tant qu'il est lié au catalogue.");
        }

        $room->delete();

        return back()->with('success', 'Univers supprimé.');
    }

    protected function validatedData(Request $request, ?Room $room = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('rooms', 'slug')->ignore($room?->id)],
            'code' => ['nullable', 'string', 'max:50', Rule::unique('rooms', 'code')->ignore($room?->id)],
            'tagline' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'position' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]) + [
            'is_active' => $request->boolean('is_active'),
            'position' => (int) $request->input('position', 0),
        ];
    }
}
