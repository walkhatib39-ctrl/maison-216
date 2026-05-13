<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Realization;
use App\Models\RealizationImage;
use App\Models\SitePage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RealizationController extends Controller
{
    public function index(Request $request): View
    {
        $filters = [
            'q' => trim((string) $request->query('q', '')),
            'silo' => (string) $request->query('silo', ''),
            'status' => (string) $request->query('status', ''),
            'page' => (string) $request->query('page', ''),
            'featured' => (string) $request->query('featured', ''),
        ];

        $query = Realization::query()
            ->withCount('pages')
            ->ordered();

        if ($filters['q'] !== '') {
            $q = $filters['q'];
            $query->where(function ($builder) use ($q) {
                $builder->where('title', 'like', "%{$q}%")
                    ->orWhere('project_type', 'like', "%{$q}%")
                    ->orWhere('short_description', 'like', "%{$q}%");
            });
        }

        if ($filters['silo'] !== '') {
            $query->where('silo', $filters['silo']);
        }

        if ($filters['status'] !== '') {
            $query->where('status', $filters['status']);
        }

        if ($filters['featured'] === '1') {
            $query->where('is_featured', true);
        }

        if ($filters['page'] !== '') {
            $query->whereHas('pages', fn ($pageQuery) => $pageQuery->whereKey($filters['page']));
        }

        return view('admin.realizations.index', [
            'realizations' => $query->paginate(18)->withQueryString(),
            'filters' => $filters,
            'statuses' => Realization::statuses(),
            'silos' => Realization::siloLabels(),
            'pages' => $this->pages(),
            'stats' => [
                'published' => Realization::query()->where('status', Realization::STATUS_PUBLISHED)->count(),
                'draft' => Realization::query()->where('status', Realization::STATUS_DRAFT)->count(),
                'featured' => Realization::query()->where('is_featured', true)->count(),
                'total' => Realization::query()->count(),
            ],
        ]);
    }

    public function create(): View
    {
        return view('admin.realizations.form', [
            'realization' => new Realization([
                'status' => Realization::STATUS_DRAFT,
                'silo' => 'menuiserie-bois',
                'sort_order' => 0,
            ]),
            'pages' => $this->pages(),
            'selectedPages' => collect(),
            'statuses' => Realization::statuses(),
            'silos' => Realization::siloLabels(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        $data['cover_image'] = $this->storeImage($request->file('cover_image'));
        $data['is_featured'] = (bool) ($data['is_featured'] ?? false);

        $realization = Realization::query()->create($data);
        $this->syncPages($realization, $request);
        $this->storeGalleryImages($realization, $request);

        return redirect()
            ->route('admin.realizations.edit', $realization)
            ->with('status', 'Realisation creee.');
    }

    public function edit(Realization $realization): View
    {
        $realization->load(['images', 'pages']);

        return view('admin.realizations.form', [
            'realization' => $realization,
            'pages' => $this->pages(),
            'selectedPages' => $realization->pages->pluck('id'),
            'statuses' => Realization::statuses(),
            'silos' => Realization::siloLabels(),
        ]);
    }

    public function update(Request $request, Realization $realization): RedirectResponse
    {
        $data = $this->validatedData($request, $realization);

        if ($request->hasFile('cover_image')) {
            $this->deleteStoredImage($realization->cover_image);
            $data['cover_image'] = $this->storeImage($request->file('cover_image'));
        }

        $data['is_featured'] = (bool) ($data['is_featured'] ?? false);

        $realization->fill($data)->save();
        $this->deleteGalleryImages($realization, $request);
        $this->syncPages($realization, $request);
        $this->storeGalleryImages($realization, $request);

        return back()->with('status', 'Realisation enregistree.');
    }

    public function destroy(Realization $realization): RedirectResponse
    {
        $realization->load('images');

        $this->deleteStoredImage($realization->cover_image);
        foreach ($realization->images as $image) {
            $this->deleteStoredImage($image->image_path);
        }

        $realization->delete();

        return redirect()
            ->route('admin.realizations.index')
            ->with('status', 'Realisation supprimee.');
    }

    private function validatedData(Request $request, ?Realization $realization = null): array
    {
        $slugRule = Rule::unique('realizations', 'slug');

        if ($realization?->exists) {
            $slugRule->ignore($realization);
        }

        return $request->validate([
            'title' => ['required', 'string', 'max:190'],
            'slug' => ['nullable', 'string', 'max:190', $slugRule],
            'project_type' => ['nullable', 'string', 'max:120'],
            'silo' => ['required', Rule::in(array_keys(Realization::siloLabels()))],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string', 'max:5000'],
            'cover_alt' => ['nullable', 'string', 'max:190'],
            'status' => ['required', Rule::in(array_keys(Realization::statuses()))],
            'is_featured' => ['nullable', 'boolean'],
            'completed_at' => ['nullable', 'date'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:100000'],
            'cover_image' => [$realization ? 'nullable' : 'required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:6144'],
            'gallery_images.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:6144'],
            'page_ids' => ['nullable', 'array'],
            'page_ids.*' => ['integer', 'exists:site_pages,id'],
            'delete_image_ids' => ['nullable', 'array'],
            'delete_image_ids.*' => ['integer', 'exists:realization_images,id'],
        ]);
    }

    private function pages()
    {
        return SitePage::query()
            ->active()
            ->orderBy('sort_order')
            ->get()
            ->groupBy('silo');
    }

    private function syncPages(Realization $realization, Request $request): void
    {
        $pageIds = collect($request->input('page_ids', []))
            ->filter()
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values();

        $sync = $pageIds->mapWithKeys(fn (int $id, int $index) => [
            $id => ['sort_order' => $index + 1, 'is_featured_on_page' => false],
        ])->all();

        $realization->pages()->sync($sync);
    }

    private function storeGalleryImages(Realization $realization, Request $request): void
    {
        $files = $request->file('gallery_images', []);

        foreach ($files as $index => $file) {
            if (!$file instanceof UploadedFile) {
                continue;
            }

            $realization->images()->create([
                'image_path' => $this->storeImage($file),
                'alt_text' => $realization->cover_alt ?: $realization->title,
                'sort_order' => $realization->images()->count() + $index + 1,
            ]);
        }
    }

    private function deleteGalleryImages(Realization $realization, Request $request): void
    {
        $ids = collect($request->input('delete_image_ids', []))
            ->map(fn ($id) => (int) $id)
            ->all();

        if ($ids === []) {
            return;
        }

        $images = $realization->images()->whereIn('id', $ids)->get();

        foreach ($images as $image) {
            $this->deleteStoredImage($image->image_path);
            $image->delete();
        }
    }

    private function storeImage(UploadedFile $file): string
    {
        $directory = public_path('uploads/realizations');

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'jpg');
        $filename = Str::random(40) . '.' . $extension;

        $file->move($directory, $filename);

        return 'uploads/realizations/' . $filename;
    }

    private function deleteStoredImage(?string $path): void
    {
        $path = trim((string) $path);

        if ($path === '' || str_starts_with($path, 'assets/') || str_starts_with($path, 'http')) {
            return;
        }

        if (str_starts_with($path, 'uploads/')) {
            $fullPath = public_path($path);

            if (is_file($fullPath)) {
                @unlink($fullPath);
            }

            return;
        }

        Storage::disk('public')->delete($path);
    }
}
