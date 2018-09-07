<?php

namespace App\Console;

use App\Console\Commands\CanteenMeal;
use App\Console\Commands\CanteenTakeout;
use App\Console\Commands\BackupCommand;
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
        CanteenMeal::class,
        BackupCommand::class
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
        $schedule->command('canteen:takeout')->weekly()->sundays()->at('23:00'); //每周星期日 23点运行任务
        $schedule->command('canteen:meal')->dailyAt('1:00')->withoutOverlapping(); //每天凌晨1点运行任务
        //开启每天凌晨一点备份
        if(config('admin.data_backup_mysql_dump')) {
            $schedule->command('backup:run')->dailyAt('1:00')->withoutOverlapping(); //每天凌晨1点运行任务
        }

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
