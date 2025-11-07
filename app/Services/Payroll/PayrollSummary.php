<?php

namespace App\Services\Payroll;

use App\Models\DailyPayrollLog;
use App\Models\Employee;
use App\Models\Payroll;

class PayrollSummary
{
    public function showDaily($id) {
        $employee = DailyPayrollLog::where('employee_id', $id)
        ->orderBy('created_at', 'asc')
        ->get();

        if(!$employee) {
            return 'Employee doesn\'t have a payroll log';
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
