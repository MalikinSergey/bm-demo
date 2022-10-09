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


        while(true){
            $this->createPngs();

            $this->comment('sleep 10 min');

            sleep(60 * 10);
        }

        return 0;
    }

    protected function createPngs(){

        $this->info(date('Y-m-d H:i:s')).' start';

        foreach(Asset::orderBy('family_id', 'desc')->orderBy('name','asc')->get() as $asset){

            $this->info($asset->name);

            $asset->makePng();

        }

        $this->info(date('Y-m-d H:i:s')).' done';

    }
}
