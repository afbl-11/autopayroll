<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\EmployeeSchedule;
use App\Models\PartTimeAssignment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EmployeeAssignmentService
{
    public function assignEmployees(Request $request, $companyId)
    {
        $request->validate([
            'employees' => 'array|required',
        ]);

        return Employee::whereIn('employee_id', $request->employees)
            ->update(['company_id' => $companyId]);
    }
    
    public function unassign(Request $request, $companyId)
    {
        $request->validate([
            'employees' => 'required|array',
        ]);

        $weekStart = Carbon::now()->startOfWeek();
        $employeeIds = $request->employees;

        foreach ($employeeIds as $employeeId) {
            $employee = Employee::find($employeeId);
            
            if (!$employee) {
                continue;
            }

            // Check if this is a part-time employee
            if ($employee->employment_type === 'part-time') {
                // For part-time employees:
                // 1. Delete ALL part-time assignments for this company
                PartTimeAssignment::where('employee_id', $employeeId)
                    ->where('company_id', $companyId)
                    ->delete();
                
                // 2. Delete ALL employee schedules for this company
                EmployeeSchedule::where('employee_id', $employeeId)
                    ->where('company_id', $companyId)
                    ->delete();
                
                // 3. Ensure company_id is null (part-time employees should not have permanent company assignment)
                $employee->update(['company_id' => null]);
            } else {
                // For permanent employees (full-time/contractual):
                // 1. Set company_id to null
                $employee->update(['company_id' => null]);
                
                // 2. End their schedule
                EmployeeSchedule::where('employee_id', $employeeId)
                    ->where('company_id', $companyId)
                    ->whereNull('end_date')
                    ->update(['end_date' => now()]);
            }
        }

        return true;
    }
}
