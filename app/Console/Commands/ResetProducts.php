<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ResetProducts extends Command
{
    protected $signature = 'catalog:purge
        {--dry-run : Show what will be deleted without changing data or files}
        {--force : Run without interactive confirmation}
        {--backup : Export affected catalog rows before deleting them}
        {--delete-files : Delete product and category image files}';

    protected $description = 'Purge catalog products, categories, product images, and optional image files while keeping the ecommerce module.';

    public function handle(): int
    {
        $dryRun = (bool) $this->option('dry-run');
        $deleteFiles = (bool) $this->option('delete-files');
        $backup = (bool) $this->option('backup');

        $stats = $this->catalogStats();
        $filePlan = $this->buildFileDeletionPlan();

        $this->table(
            ['Element', 'Count'],
            [
                ['products', $stats['products']],
                ['product_images', $stats['product_images']],
                ['categories', $stats['categories']],
                ['collection_product links', $stats['collection_product']],
                ['order_items to detach from products', $stats['order_items_with_product']],
                ['order item images to clear', $stats['order_items_with_image']],
                ['local image files found', count($filePlan['files'])],
                ['catalog image directories found', count($filePlan['directories'])],
            ]
        );

        if ($dryRun) {
            $this->warn('Dry run only. No data or files were changed.');
            $this->line('Run with --force --backup --delete-files to purge the current catalog.');

            return Command::SUCCESS;
        }

        if (! $this->option('force') && ! $this->confirm('Delete all catalog products, categories, and selected images?', false)) {
            $this->warn('Catalog purge cancelled.');

            return Command::SUCCESS;
        }

        if ($backup) {
            $backupPath = $this->writeBackup();
            $this->info("Backup written: {$backupPath}");
        }

        $deletedFiles = 0;
        $deletedDirectories = 0;

        if ($deleteFiles) {
            [$deletedFiles, $deletedDirectories] = $this->deleteCatalogFiles($filePlan);
        }

        DB::transaction(function () use ($deleteFiles) {
            DB::table('order_items')
                ->whereNotNull('product_id')
                ->update(['product_id' => null]);

            if ($deleteFiles) {
                DB::table('order_items')
                    ->whereNotNull('product_main_image')
                    ->update(['product_main_image' => null]);
            }

            if ($this->tableExists('collection_product')) {
                DB::table('collection_product')->delete();
            }

            DB::table('product_images')->delete();
            DB::table('products')->delete();

            DB::table('categories')->update(['parent_id' => null]);
            DB::table('categories')->delete();
        });

        $this->resetAutoIncrement(['collection_product', 'product_images', 'products', 'categories']);

        $this->info('Catalog data purged.');

        if ($deleteFiles) {
            $this->line("Deleted image files: {$deletedFiles}");
            $this->line("Deleted product image directories: {$deletedDirectories}");
        } else {
            $this->warn('Image files were not deleted because --delete-files was not used.');
        }

        return Command::SUCCESS;
    }

    private function catalogStats(): array
    {
        return [
            'products' => DB::table('products')->count(),
            'product_images' => DB::table('product_images')->count(),
            'categories' => DB::table('categories')->count(),
            'collection_product' => $this->tableExists('collection_product') ? DB::table('collection_product')->count() : 0,
            'order_items_with_product' => $this->tableExists('order_items') ? DB::table('order_items')->whereNotNull('product_id')->count() : 0,
            'order_items_with_image' => $this->tableExists('order_items') ? DB::table('order_items')->whereNotNull('product_main_image')->count() : 0,
        ];
    }

    private function writeBackup(): string
    {
        $directory = storage_path('app/private/catalog-purge-backups');
        File::ensureDirectoryExists($directory);

        $path = $directory . '/catalog-purge-' . now()->format('Ymd-His') . '.json';

        $payload = [
            'created_at' => now()->toIso8601String(),
            'tables' => [
                'categories' => DB::table('categories')->get(),
                'products' => DB::table('products')->get(),
                'product_images' => DB::table('product_images')->get(),
                'collection_product' => $this->tableExists('collection_product') ? DB::table('collection_product')->get() : collect(),
                'order_items_touched' => $this->tableExists('order_items')
                    ? DB::table('order_items')
                        ->whereNotNull('product_id')
                        ->orWhereNotNull('product_main_image')
                        ->get(['id', 'product_id', 'product_main_image'])
                    : collect(),
            ],
        ];

        File::put($path, json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

        return $path;
    }

    private function buildFileDeletionPlan(): array
    {
        $paths = collect()
            ->merge(DB::table('products')->whereNotNull('main_image')->pluck('main_image'))
            ->merge(DB::table('product_images')->whereNotNull('url')->pluck('url'))
            ->merge(DB::table('categories')->whereNotNull('featured_image')->pluck('featured_image'));

        $files = $paths
            ->map(fn ($path) => $this->resolveLocalPublicFile((string) $path))
            ->filter()
            ->unique()
            ->values()
            ->all();

        $directories = DB::table('products')
            ->whereNotNull('slug')
            ->pluck('slug')
            ->map(fn ($slug) => public_path('images/' . $slug))
            ->filter(fn ($path) => is_dir($path) && $this->isInside($path, public_path('images')))
            ->merge($this->directCatalogImageDirectories())
            ->map(fn ($path) => realpath($path) ?: $path)
            ->unique()
            ->values()
            ->all();

        return [
            'files' => $files,
            'directories' => $directories,
        ];
    }

    private function deleteCatalogFiles(array $filePlan): array
    {
        $deletedFiles = 0;
        $deletedDirectories = 0;

        foreach ($filePlan['files'] as $file) {
            if (is_file($file) && File::delete($file)) {
                $deletedFiles++;
            }
        }

        foreach ($filePlan['directories'] as $directory) {
            if (is_dir($directory) && File::deleteDirectory($directory)) {
                $deletedDirectories++;
            }
        }

        $categoriesDirectory = public_path('images/categories');
        if (is_dir($categoriesDirectory) && count(File::files($categoriesDirectory)) === 0) {
            File::deleteDirectory($categoriesDirectory);
            $deletedDirectories++;
        }

        return [$deletedFiles, $deletedDirectories];
    }

    private function directCatalogImageDirectories(): array
    {
        $directory = public_path('images');

        if (! is_dir($directory)) {
            return [];
        }

        return collect(File::directories($directory))
            ->filter(fn ($path) => $this->isInside($path, $directory))
            ->map(fn ($path) => realpath($path) ?: $path)
            ->values()
            ->all();
    }

    private function resolveLocalPublicFile(string $path): ?string
    {
        $path = trim($path);

        if ($path === '' || str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return null;
        }

        $path = ltrim($path, '/');

        $candidates = [];

        if (str_starts_with($path, 'images/')) {
            $candidates[] = public_path($path);
        }

        if (str_starts_with($path, 'storage/')) {
            $relative = substr($path, strlen('storage/'));
            $candidates[] = public_path($path);
            $candidates[] = storage_path('app/public/' . $relative);
        }

        foreach ($candidates as $candidate) {
            if (is_file($candidate) && (
                $this->isInside($candidate, public_path('images')) ||
                $this->isInside($candidate, public_path('storage')) ||
                $this->isInside($candidate, storage_path('app/public'))
            )) {
                return $candidate;
            }
        }

        return null;
    }

    private function resetAutoIncrement(array $tables): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        foreach ($tables as $table) {
            if ($this->tableExists($table)) {
                DB::statement("ALTER TABLE `{$table}` AUTO_INCREMENT = 1");
            }
        }
    }

    private function tableExists(string $table): bool
    {
        return DB::getSchemaBuilder()->hasTable($table);
    }

    private function isInside(string $path, string $base): bool
    {
        $realPath = realpath($path);
        $realBase = realpath($base);

        if (! $realPath || ! $realBase) {
            return false;
        }

        return str_starts_with($realPath, $realBase . DIRECTORY_SEPARATOR) || $realPath === $realBase;
    }
}
