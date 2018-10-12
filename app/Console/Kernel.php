<?php

namespace App\Console;

use App\Console\Commands\BackupCommand;
use App\Console\Commands\Inspire;
use App\Console\Commands\IP;
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
        BackupCommand::class,
        IP::class

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
