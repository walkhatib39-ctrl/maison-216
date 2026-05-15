<?php

namespace App\Support;

use App\Models\MediaAsset;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MediaLibrary
{
    /** @var array<int, string> */
    private array $extensions = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg', 'ico'];

    /**
     * @return array{created:int, updated:int, deleted:int, scanned:int}
     */
    public function syncFilesystem(bool $includeCatalogImages = true): array
    {
        $stats = ['created' => 0, 'updated' => 0, 'deleted' => 0, 'scanned' => 0];
        $startedAt = now();
        $syncedSources = [];

        foreach ($this->roots($includeCatalogImages) as $root) {
            $syncedSources[] = $root['source'];

            if (!is_dir($root['base'])) {
                continue;
            }

            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($root['base'], \FilesystemIterator::SKIP_DOTS)
            );

            foreach ($iterator as $file) {
                if (!$file instanceof \SplFileInfo || !$file->isFile()) {
                    continue;
                }

                $extension = strtolower($file->getExtension());
                if (!in_array($extension, $this->extensions, true)) {
                    continue;
                }

                $absolute = $file->getPathname();
                $relativeToRoot = trim(str_replace('\\', '/', Str::after($absolute, rtrim($root['base'], DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR)), '/');
                if ($relativeToRoot === '') {
                    continue;
                }

                $path = trim($root['prefix'] . '/' . $relativeToRoot, '/');
                $stats['scanned']++;

                $result = $this->upsertFromFile($absolute, $path, $root['source'], $root['read_meta']);
                $stats[$result]++;
            }
        }

        if ($syncedSources !== []) {
            $stats['deleted'] = MediaAsset::query()
                ->whereIn('source', array_values(array_unique($syncedSources)))
                ->where(function ($query) use ($startedAt) {
                    $query->whereNull('last_seen_at')
                        ->orWhere('last_seen_at', '<', $startedAt);
                })
                ->delete();
        }

        return $stats;
    }

    public function storeUpload(UploadedFile $file, ?int $userId = null): MediaAsset
    {
        $extension = strtolower($file->getClientOriginalExtension() ?: $file->guessExtension() ?: 'jpg');
        $safeName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) ?: 'image';
        $filename = $safeName . '-' . Str::random(10) . '.' . $extension;
        $relativeDirectory = 'uploads/media-library/' . now()->format('Y/m');
        $directory = public_path($relativeDirectory);

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $file->move($directory, $filename);
        $path = $relativeDirectory . '/' . $filename;
        $this->upsertFromFile(public_path($path), $path, 'upload', true);

        $media = MediaAsset::where('path', $path)->firstOrFail();
        if ($userId) {
            $media->uploaded_by = $userId;
            $media->save();
        }

        return $media;
    }

    /**
     * @return array<int, array{base:string,prefix:string,source:string,read_meta:bool}>
     */
    private function roots(bool $includeCatalogImages): array
    {
        $roots = [
            ['base' => public_path('uploads'), 'prefix' => 'uploads', 'source' => 'uploads', 'read_meta' => true],
            ['base' => public_path('assets'), 'prefix' => 'assets', 'source' => 'assets', 'read_meta' => true],
            ['base' => storage_path('app/public'), 'prefix' => 'storage', 'source' => 'storage', 'read_meta' => true],
        ];

        if ($includeCatalogImages) {
            $roots[] = ['base' => public_path('images'), 'prefix' => 'images', 'source' => 'images', 'read_meta' => false];
        }

        return $roots;
    }

    private function upsertFromFile(string $absolutePath, string $path, string $source, bool $readMetadata): string
    {
        $existing = MediaAsset::where('path', $path)->first();
        $dimensions = $readMetadata ? $this->dimensions($absolutePath) : ['width' => null, 'height' => null];
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        $payload = [
            'filename' => basename($path),
            'extension' => $extension,
            'mime_type' => $readMetadata ? (File::mimeType($absolutePath) ?: null) : $this->mimeTypeForExtension($extension),
            'size' => filesize($absolutePath) ?: null,
            'source' => $source,
            'last_seen_at' => now(),
        ];

        if ($readMetadata || !$existing) {
            $payload['width'] = $dimensions['width'];
            $payload['height'] = $dimensions['height'];
        }

        if ($existing) {
            if ($existing->source === 'upload') {
                $payload['source'] = 'upload';
            }

            $existing->fill($payload)->save();

            return 'updated';
        }

        MediaAsset::create([
            'path' => $path,
            ...$payload,
        ]);

        return 'created';
    }

    /**
     * @return array{width:?int,height:?int}
     */
    private function dimensions(string $absolutePath): array
    {
        $extension = strtolower(pathinfo($absolutePath, PATHINFO_EXTENSION));
        if (in_array($extension, ['svg', 'ico'], true)) {
            return ['width' => null, 'height' => null];
        }

        $size = @getimagesize($absolutePath);

        return [
            'width' => is_array($size) ? ($size[0] ?? null) : null,
            'height' => is_array($size) ? ($size[1] ?? null) : null,
        ];
    }

    private function mimeTypeForExtension(string $extension): ?string
    {
        return match ($extension) {
            'jpg', 'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'webp' => 'image/webp',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml',
            'ico' => 'image/x-icon',
            default => null,
        };
    }
}
