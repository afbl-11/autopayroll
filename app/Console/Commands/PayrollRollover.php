<?php

namespace App\Console\Commands;

use App\Models\PayrollPeriod;
use App\Services\GenerateId;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PayrollRollover extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:payroll-rollover';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $generate;

    public function __construct()
    {
        parent::__construct();
        $this->generate = new GenerateId();
    }

    public function handle(): void
    {
        $this->info("Starting payroll rollover...");

        $today = Carbon::today();
        /*
         * check if there is an existing period, if exists,
         *  close that period then, start a new period
         * */

        $openPeriod = PayrollPeriod::where('is_closed', false)
            ->whereNotNull('start_date')
            ->whereNotNull('end_date')
            ->first();

        if($openPeriod){
            $openPeriod->update([
                'is_closed' => true,
            ]);

            $this->info("Closed period: {$openPeriod->payroll_period_id}");
        }

        if ($today->day <= 15) {
            $start_date = $today->copy()->addDay();
            $end_date = $start_date->copy()->startOfMonth()->addDays(14); // 15th
        } else {
            $start_date = $today->copy()->addDay();
            $end_date = $start_date->copy()->endOfMonth();
        }

        $newPeriod = PayrollPeriod::create([
            'payroll_period_id' => $this->generate->generateId(PayrollPeriod::class, 'payroll_period_id'),
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);

        $this->info("New period created: {$newPeriod->payroll_period_id}");
    }
}

/*
 * method is for creating a new payroll period via a scheduler
 * */
