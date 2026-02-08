<?php

namespace App\Observers;

use App\Jobs\ProcessPayrollComputation;
use App\Models\DailyPayrollLog;
use App\Models\Employee;
use App\Services\Payroll\PayrollHistory;

class EmployeeObserver
{

    public function __construct(
        protected PayrollHistory $payrollService
    )
    {
    }

    /**
     * Handle the Employee "created" event.
     */

    public function created(Employee $employee): void
    {
        // If you need a payroll log, create or fetch it
        $log = DailyPayrollLog::create([
            'employee_id' => $employee->employee_id,
            'payroll_date' => now(),
            // add other required fields...
        ]);

        ProcessPayrollComputation::dispatch($employee->employee_id);
    }

    /**
     * Handle the Employee "updated" event.
     */
    public function updated(Employee $employee): void
    {

    }

    /**
     * Handle the Employee "deleted" event.
     */
    public function deleted(Employee $employee): void
    {
        //
    }

    /**
     * Handle the Employee "restored" event.
     */
    public function restored(Employee $employee): void
    {
        //
    }

    /**
     * Handle the Employee "force deleted" event.
     */
    public function forceDeleted(Employee $employee): void
    {
        //
    }
}
