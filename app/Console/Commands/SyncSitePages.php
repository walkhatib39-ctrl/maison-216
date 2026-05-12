<?php

namespace App\Console\Commands;

use App\Support\SitePageSyncer;
use Illuminate\Console\Command;

class SyncSitePages extends Command
{
    protected $signature = 'site-pages:sync';

    protected $description = 'Synchronise les pages publiques Maison216 depuis la structure du site.';

    public function handle(SitePageSyncer $syncer): int
    {
        $result = $syncer->sync();

        $this->components->info(sprintf(
            'Pages synchronisees: %d creees, %d mises a jour, %d obsoletes, %d total.',
            $result['created'],
            $result['updated'],
            $result['obsolete'],
            $result['total'],
        ));

        return self::SUCCESS;
    }
}
