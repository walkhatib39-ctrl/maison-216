<?php

namespace App\Support;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class SiteStructure
{
    public function tree(): Collection
    {
        return collect(config('site_structure', []))
            ->map(fn (array $item) => $this->normalizeNode($item));
    }

    public function flat(): Collection
    {
        return $this->flatten($this->tree());
    }

    public function find(string $path): ?array
    {
        $path = $this->cleanPath($path);

        return $this->flat()->firstWhere('path', $path);
    }

    public function childrenOf(string $path): Collection
    {
        $page = $this->find($path);

        return collect($page['children'] ?? []);
    }

    public function ancestorsOf(string $path): Collection
    {
        $path = $this->cleanPath($path);
        $parts = explode('/', $path);
        $ancestors = collect();

        while (count($parts) > 1) {
            array_pop($parts);
            $ancestor = $this->find(implode('/', $parts));

            if ($ancestor) {
                $ancestors->prepend($ancestor);
            }
        }

        return $ancestors;
    }

    public function mainNavigation(): Collection
    {
        return $this->tree()->map(fn (array $item) => $this->withHref($item));
    }

    public function allUrls(): Collection
    {
        return $this->flat()->pluck('url')->values();
    }

    private function normalizeNode(array $item): array
    {
        $item['path'] = $this->cleanPath($item['path']);
        $item['slug'] = Str::afterLast($item['path'], '/');
        $item['url'] = url('/' . $item['path']);
        $item['href'] = url('/' . $item['path']);
        $item['children'] = collect($item['children'] ?? [])
            ->map(fn (array $child) => $this->normalizeNode($child))
            ->values()
            ->all();

        return $item;
    }

    private function flatten(Collection $nodes): Collection
    {
        return $nodes->flatMap(function (array $node) {
            $children = $this->flatten(collect($node['children'] ?? []));

            return collect([$node])->merge($children);
        })->values();
    }

    private function withHref(array $item): array
    {
        $item['href'] = $item['url'];

        return $item;
    }

    private function cleanPath(string $path): string
    {
        return trim($path, '/');
    }
}
