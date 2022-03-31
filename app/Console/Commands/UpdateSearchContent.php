<?php

namespace App\Console\Commands;

use App\Models\Asset;
use App\Models\Pack;
use Illuminate\Console\Command;

class UpdateSearchContent extends Command
{
    protected $signature = 'bm:update-search-content';

    protected $description = '';

    public function handle()
    {
        Asset::all()->map(fn($asset) => $asset->updateSearchContent());
        Pack::all()->map(fn($pack) => $pack->updateSearchContent());

        $this->info('done');
    }
}
