<?php

namespace App\Console\Commands;

use App\Support\CatalogArchitectureSynchronizer;
use Illuminate\Console\Command;
use RuntimeException;

class SyncCatalogArchitecture extends Command
{
    protected $signature = 'maison216:sync-catalog-architecture
        {--force : Remplace aussi les mappings room/type déjà présents}
    ';

    protected $description = 'Crée la nouvelle architecture catalogue et mappe les catégories/produits existants.';

    public function handle(): int
    {
        try {
            $results = (new CatalogArchitectureSynchronizer(
                force: (bool) $this->option('force'),
            ))->run();
        } catch (RuntimeException $exception) {
            $this->error($exception->getMessage());

            return self::FAILURE;
        }

        $this->info('Synchronisation de l’architecture catalogue terminée.');
        $this->newLine();

        $this->line('Rooms: ' . ($results['rooms']['count'] ?? 0));
        $this->line('Product types: ' . ($results['product_types']['count'] ?? 0));
        $this->newLine();

        $this->table(
            ['Bloc', 'Processed', 'Room updates', 'Type updates', 'Extra', 'Unchanged'],
            [
                [
                    'Categories',
                    $results['categories']['processed'] ?? 0,
                    $results['categories']['room_updates'] ?? 0,
                    $results['categories']['type_updates'] ?? 0,
                    'kind=' . ($results['categories']['kind_updates'] ?? 0) . ' / indexable=' . ($results['categories']['indexable_updates'] ?? 0),
                    $results['categories']['unchanged'] ?? 0,
                ],
                [
                    'Products',
                    $results['products']['processed'] ?? 0,
                    $results['products']['room_updates'] ?? 0,
                    $results['products']['type_updates'] ?? 0,
                    'sale_mode=' . ($results['products']['sale_mode_updates'] ?? 0),
                    $results['products']['unchanged'] ?? 0,
                ],
            ]
        );

        return self::SUCCESS;
    }
}
