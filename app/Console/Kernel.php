<?php

namespace App\Console;

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
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('gmail:api --email=gmail --all --limit=10 --silent')
            ->everyFiveMinutes();
        $schedule->command('gmail:api --email=gmail --imbox --limit=10 --silent')
            ->everyMinute();
//        $schedule->command('gmail:api --email=commercehero --all --limit=10 --silent')
//            ->everyFiveMinutes();
//        $schedule->command('gmail:api --email=commercehero --imbox --limit=10 --silent')
//            ->everyMinute();
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
