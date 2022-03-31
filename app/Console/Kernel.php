<?php

namespace App\Console;

use App\Console\Commands\DefaultPrices;
use App\Console\Commands\EnsurePrices;
use App\Console\Commands\UpdateSearchContent;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        UpdateSearchContent::class,
        DefaultPrices::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//        $schedule->command('bm:create-assets-pngs')->cron('*/20 * * * *')->withoutOverlapping();
//        $schedule->command('bm:create-assets-previews')->cron('*/30 * * * *')->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
