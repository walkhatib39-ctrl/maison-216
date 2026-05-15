<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaAsset;
use App\Support\MediaLibrary;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MediaController extends Controller
{
    public function index(Request $request, MediaLibrary $library): View
    {
        if (!$request->boolean('skip_sync') && MediaAsset::query()->count() === 0) {
            $library->syncFilesystem(false);
        }

        [$assets, $filters] = $this->query($request, 36);

        return view('admin.media.index', [
            'assets' => $assets,
            'filters' => $filters,
            'stats' => [
                'total' => MediaAsset::query()->count(),
                'uploads' => MediaAsset::query()->where('source', 'upload')->count(),
                'assets' => MediaAsset::query()->where('source', 'assets')->count(),
                'images' => MediaAsset::query()->where('source', 'images')->count(),
                'storage' => MediaAsset::query()->where('source', 'storage')->count(),
            ],
        ]);
    }

    public function upload(Request $request, MediaLibrary $library): JsonResponse|RedirectResponse
    {
        $data = $request->validate([
            'media_files' => ['required', 'array', 'min:1'],
            'media_files.*' => ['file', 'mimes:jpg,jpeg,png,webp,gif,svg,ico', 'max:8192'],
        ]);

        $assets = [];
        foreach ($request->file('media_files', []) as $file) {
            $assets[] = $library->storeUpload($file, $request->user()?->id);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'assets' => collect($assets)->map(fn (MediaAsset $asset) => $this->resource($asset))->values(),
            ]);
        }

        return back()->with('status', count($assets) . ' fichier(s) ajoute(s) a la mediatheque.');
    }

    public function sync(Request $request, MediaLibrary $library): RedirectResponse
    {
        $stats = $library->syncFilesystem($request->boolean('include_catalog_images'));

        return back()->with('status', "Mediatheque synchronisee: {$stats['created']} ajoutes, {$stats['updated']} mis a jour, {$stats['deleted']} supprimes, {$stats['scanned']} fichiers scannes.");
    }

    public function picker(Request $request, MediaLibrary $library): JsonResponse
    {
        if (MediaAsset::query()->count() === 0) {
            $library->syncFilesystem(false);
        }

        [$assets] = $this->query($request, 48);

        return response()->json([
            'assets' => $assets->getCollection()
                ->map(fn (MediaAsset $asset) => $this->resource($asset))
                ->values(),
            'has_more' => $assets->hasMorePages(),
        ]);
    }

    /**
     * @return array{0:\Illuminate\Contracts\Pagination\LengthAwarePaginator,1:array<string,string>}
     */
    private function query(Request $request, int $perPage): array
    {
        $filters = [
            'q' => trim((string) $request->query('q', '')),
            'source' => trim((string) $request->query('source', '')),
        ];

        $query = MediaAsset::query()->latest();

        if ($filters['q'] !== '') {
            $q = $filters['q'];
            $query->where(function ($builder) use ($q) {
                $builder->where('filename', 'like', "%{$q}%")
                    ->orWhere('path', 'like', "%{$q}%")
                    ->orWhere('alt_text', 'like', "%{$q}%");
            });
        }

        if ($filters['source'] !== '') {
            $query->where('source', $filters['source']);
        }

        return [$query->paginate($perPage)->withQueryString(), $filters];
    }

    private function resource(MediaAsset $asset): array
    {
        return [
            'id' => $asset->id,
            'filename' => $asset->filename,
            'path' => $asset->path,
            'url' => $asset->public_url,
            'size' => $asset->human_size,
            'dimensions' => $asset->dimensions_label,
            'source' => $asset->source,
            'mime_type' => $asset->mime_type,
        ];
    }
}
