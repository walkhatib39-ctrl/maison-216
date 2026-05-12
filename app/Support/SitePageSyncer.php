<?php

namespace App\Support;

use App\Models\SitePage;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class SitePageSyncer
{
    public function __construct(private readonly SiteStructure $structure)
    {
    }

    public function sync(): array
    {
        $pages = $this->structure->flat()->values();
        $seenPaths = $pages->pluck('path')->all();
        $created = 0;
        $updated = 0;

        $pages->each(function (array $page, int $index) use (&$created, &$updated): void {
            $path = trim((string) $page['path'], '/');
            $existing = SitePage::query()->where('path', $path)->first();

            $attributes = [
                'silo' => Str::before($path, '/'),
                'parent_path' => $this->parentPath($path),
                'page_type' => (string) ($page['type'] ?? 'quote'),
                'public_title' => (string) ($page['title'] ?? $path),
                'description_snapshot' => (string) ($page['description'] ?? ''),
                'sort_order' => $index + 1,
                'is_obsolete' => false,
            ];

            if (!$existing) {
                SitePage::query()->create(array_merge($attributes, [
                    'path' => $path,
                    'admin_title' => (string) ($page['title'] ?? $path),
                    'meta_title' => null,
                    'meta_description' => null,
                    'is_indexable' => true,
                ]));
                $created++;

                return;
            }

            if (!filled($existing->admin_title)) {
                $attributes['admin_title'] = (string) ($page['title'] ?? $path);
            }

            $existing->fill($attributes);
            if ($existing->isDirty()) {
                $existing->save();
                $updated++;
            }
        });

        $obsolete = SitePage::query()
            ->whereNotIn('path', $seenPaths)
            ->where('is_obsolete', false)
            ->update(['is_obsolete' => true]);

        return [
            'created' => $created,
            'updated' => $updated,
            'obsolete' => $obsolete,
            'total' => SitePage::query()->count(),
        ];
    }

    public function silos(): Collection
    {
        return $this->structure
            ->tree()
            ->pluck('path')
            ->map(fn (string $path) => Str::before($path, '/'))
            ->unique()
            ->values();
    }

    private function parentPath(string $path): ?string
    {
        return str_contains($path, '/') ? Str::beforeLast($path, '/') : null;
    }
}
