<?php

namespace App\Providers;

use App\Models\Asset;
use App\Models\Family;
use App\Models\Pack;
use App\Services\TwoCheckout;
use Illuminate\Session\Store as Session;
use Illuminate\Support\ServiceProvider;
use Spatie\LittleGateKeeper\Authenticator;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {


        $this->app->singleton(
            TwoCheckout::class,
            function ($app) {
                return new TwoCheckout(config('services.2checkout'));
            }
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(!app()->runningInConsole()  && !in_array(\Request::getClientIp(),  [ '178.57.116.66', '62.118.139.0'])){
            // die('services on the maintenance');
        }

        Paginator::useBootstrapFive();

        Relation::morphMap(
            [
                'asset' => Asset::class,
                'family' => Family::class,
                'pack' => Pack::class,
            ]
        );
    }
}
