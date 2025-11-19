<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
       $schedule->command('attendance:check')
             ->everyMinute() // O ->everyFiveMinutes() para menos frecuencia
             ->when(function () {
                 $now = Carbon::now('America/Lima');
                 return $now->hour >= 7 && $now->hour < 9; // Solo entre 7-9 AM
             });

        $schedule->command('attendance:send-absence-notifications')
             ->dailyAt('08:05') // Ejecutar a las 8:05 AM
             ->timezone('America/Lima');
    }
    

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

