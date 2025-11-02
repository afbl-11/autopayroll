<?php

namespace App\Console;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
class Kernel extends ConsoleKernel
{
    public function schedule(Schedule $schedule) {

        $schedule->command('app:payroll-rollover')
            ->monthlyOn(15, '00:00')
            ->withoutOverlapping();

        $schedule->command('app:payroll-rollover')
            ->monthlyOn(Carbon::now()->endOfMonth()->day, '00:00')
            ->withoutOverlapping();
    }

    protected function commands() {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }


}
