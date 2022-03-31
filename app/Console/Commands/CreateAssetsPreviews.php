<?php

namespace App\Console\Commands;

use App\Models\Asset;
use Illuminate\Console\Command;

class CreateAssetsPreviews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bm:create-assets-previews';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
            $this->createAssets();

            $this->comment('sleep 10 min');

            sleep(60 * 10);
        }

        return 0;
    }

    protected function createAssets(){
        $this->info(date('Y-m-d H:i:s')) . ' start';

        foreach (Asset::orderBy('family_id', 'asc')->get() as $asset) {
            if (!$asset->Family) {
                $asset->preview_status = 'error';
                $asset->save();
                continue;
            }

            $this->info($asset->Family->name . ": " . $asset->name);


            if($asset->Family->type === 'icon'){
                $asset->makePngPreviews([320, 128, 86]);

            }
            else{
                $asset->makePngPreviews([512, 320, 128, 86]);

            }
        }

        $this->info(date('Y-m-d H:i:s')) . ' done';
    }
}
