<?php

namespace App\Console;

use App\Console\Commands\CanteenMeal;
use App\Console\Commands\CanteenTakeout;
use App\Console\Commands\Inspire;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     * php artisan schedule:run >> /dev/null 2>&1
     * @var array
     */
    protected $commands = [
        Inspire::class,
        CanteenTakeout::class,
        CanteenMeal::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')->hourly();

        //过期外卖
        $schedule->command('canteen:takeout')->everyMinute()->withoutOverlapping();
        $schedule->command('canteen:meal')->everyMinute()->withoutOverlapping();
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
