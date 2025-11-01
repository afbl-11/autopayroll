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
            ->whereNull('end_date')
            ->first();

        if($openPeriod){
            $openPeriod->update([
                'is_closed' => true,
                'end_date' => $today,
            ]);

            $this->info("Closed period: {$openPeriod->payroll_period_id}");
        }


        $newPeriod = PayrollPeriod::create([
            'payroll_period_id' => $this->generate->generateId(PayrollPeriod::class, 'payroll_period_id'),
            'start_date' => $today->copy()->addDay(),
        ]);

        $this->info("New period created: {$newPeriod->payroll_period_id}");
    }
}
//todo: make end_date column in migration not nullable,
//todo: end date in this logic should have a default value: every 15th day of the month & endOfMonth() method.
