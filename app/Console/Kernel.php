<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
     
    protected $commands = [
            Commands\sendNotification::class,
    ];
    
    protected function schedule(Schedule $schedule)
    {
     // $schedule->command('users:sendemail')->cron('* * * * *');
    //$schedule->command('users:sendemail')->cron('0 0 * * *');
        
      //$schedule->command('users:sendemail')->dailyAt('00:00');
//09-10-25
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
