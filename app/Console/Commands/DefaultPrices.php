<?php

namespace App\Console\Commands;

use App\Models\Asset;
use App\Models\Family;
use App\Models\Pack;
use Illuminate\Console\Command;

class DefaultPrices extends Command
{
    protected $signature = 'bm:default-prices';

    protected $description = '';

    /**
     * Старое ценообразование
     *
     * @deprecated
     */
    public function handle()
    {
        foreach (Asset::all() as $item) {
            if (!$item->price_personal) {
                $item->price_personal = config('boykomarket.default_prices.asset.personal');
            }

            if (!$item->price_commercial) {
                $item->price_commercial = config('boykomarket.default_prices.asset.commercial');
            }

            if (!$item->price_commercial_ext) {
                $item->price_commercial_ext = config('boykomarket.default_prices.asset.commercial_ext');
            }

            $item->save();
        }
        foreach (Pack::all() as $item) {
            if (!$item->price_personal) {
                $item->price_personal = config('boykomarket.default_prices.pack.personal');
            }

            if (!$item->price_commercial) {
                $item->price_commercial = config('boykomarket.default_prices.pack.commercial');
            }

            if (!$item->price_commercial_ext) {
                $item->price_commercial_ext = config('boykomarket.default_prices.pack.commercial_ext');
            }

            $item->save();
        }
        foreach (Family::all() as $item) {
            if (!$item->price_personal) {
                $item->price_personal = config('boykomarket.default_prices.family.personal');
            }

            if (!$item->price_commercial) {
                $item->price_commercial = config('boykomarket.default_prices.family.commercial');
            }

            if (!$item->price_commercial_ext) {
                $item->price_commercial_ext = config('boykomarket.default_prices.family.commercial_ext');
            }

            $item->save();
        }

        $this->info('done');
    }
}
