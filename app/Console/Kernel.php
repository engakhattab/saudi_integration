<?php

namespace App\Console;

use App\Console\Commands\ExitChildren;
use Illuminate\Console\Scheduling\Schedule;
use App\Models\GeneralSetting;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel{

    protected $commands = [ExitChildren::class];


    protected function schedule(Schedule $schedule){
        $settings = GeneralSetting::first();
        //  $schedule->command('exit:children')->dailyAt('11:59');
        $schedule->command('exit:children')->dailyAt('03:00');
//         $schedule->command('exit:children')->dailyAt(\Carbon\Carbon::parse($settings->exit_time)->format('H:i'));
    }


    protected function commands(){

        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
