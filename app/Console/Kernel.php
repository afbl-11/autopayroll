<?php

namespace App\Console;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
class Kernel extends ConsoleKernel
{
    public function schedule(Schedule $schedule) {

        $schedule->command('payslips:generate')->everyMinute();
    }

    protected function commands() {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }


}
