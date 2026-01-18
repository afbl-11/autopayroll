<?php

namespace App\Services\Payroll;

use App\Models\DailyPayrollLog;
use App\Models\Employee;
use App\Models\Payroll;

class PayrollSummary
{
    public function showDaily($id) {
        $employee = DailyPayrollLog::withoutGlobalScope(\App\Models\Scopes\AdminScope::class)
            ->where('employee_id', $id)
            ->orderBy('payroll_date', 'desc')
            ->get();

        if(!$employee || $employee->isEmpty()) {
            return collect(); // Return empty collection instead of string
        }
        return $employee;
    }

    public function showSemi($id) {
        $employee = Payroll::where('employee_id', $id)
            ->orderBy('created_at', 'asc')
            ->get();

        if(!$employee) {
            return 'Employee doesn\'t have a payroll log';
        }
        return $employee;
    }
}
