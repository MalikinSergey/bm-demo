<?php

namespace App\Console\Commands;

use App\Models\Asset;
use Illuminate\Console\Command;

class CreateAssetsPngs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bm:create-assets-pngs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $this->info(date('Y-m-d H:i:s')).' start';

        foreach(Asset::orderBy('family_id', 'desc')->orderBy('name','asc')->get() as $asset){

            $this->info($asset->name);

            $asset->makePng();

        }

        $this->info(date('Y-m-d H:i:s')).' done';

        return 0;
    }
}
