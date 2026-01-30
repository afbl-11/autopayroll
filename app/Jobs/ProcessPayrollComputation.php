<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Employee;
use App\Services\Payroll\PayrollHistory;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessPayrollComputation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $employee;

    public function __construct(Employee $employee)
    {
        $this->employee = $employee;
    }

    public function handle(PayrollHistory $payrollHistory)
    {
        Log::info('Payslip generation started for employee '.$this->employee->employee_id.' at '.now());

        $payrollHistory->generateAllPayslipsForEmployee($this->employee);

        Log::info('Payslip generation completed for employee '.$this->employee->employee_id.' at '.now());
    }
}
