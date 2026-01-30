<?php

namespace App\Console\Commands;

use AllowDynamicProperties;
use App\Models\Employee;
use App\Services\Payroll\PayrollHistory;
use Illuminate\Console\Command;
use App\Jobs\ProcessPayrollComputation;

#[AllowDynamicProperties]
class GeneratePayslips extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
//    protected $signature = 'app:generate-payslips';
    protected $signature = 'payslips:generate';
    protected $description = 'Generate all payslips for employees';
    /**
     * The console command description.
     *
     * @var string
     */
//    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function __construct(PayrollHistory $payrollService)
    {
        parent::__construct();
        $this->payrollService = $payrollService;
    }

    public function handle()
    {
        $employees = Employee::all();

        foreach ($employees as $employee) {
            ProcessPayrollComputation::dispatch($employee);
        }

        $this->info('Payslip jobs dispatched for all employees.');
    }
}
