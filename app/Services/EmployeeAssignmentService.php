<?php

namespace App\Services;

use App\Models\Employee;
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
    public function unassign(Request $request,  $companyId)
    {
        $request->validate([
            'employees' => 'required|array',
        ]);

        return Employee::whereIn('employee_id', $request->employees)
            ->update(['company_id' => null]);
    }
}
