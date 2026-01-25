<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\Employee;
use App\Models\LeaveCredits;
use App\Models\LeaveCreditType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LeaveCreditService
{
    public function createCreditRecord($employeeId) : void {

        $adminId = Auth::guard('admin')->id();

        $leaveTypes = LeaveCreditType::all();

        $employee = Employee::find($employeeId);

        foreach ($leaveTypes as $type) {
            if (($type->name === 'Maternity' && $employee->gender !== 'female') ||
                ($type->name === 'Paternity' && $employee->gender !== 'male')) {
                continue;
            }


        LeaveCredits::create([
            'leave_credit_id' => Str::uuid(),
            'employee_id' => $employeeId,
            'admin_id' => $adminId,
            'leave_credit_type_id' => $type->leave_credit_type_id,
            'credit_days' => match ($type->name) {
                'Vacation' => 15,
                'Sick' => 10,
                'Maternity' => 105,
                'Bereavement' => 3,
                'Paternity' => 7,
                default => 0,
            },
            'used_days' => 0,
            'approved_date' => Carbon::now(),
        ]);
        }
    }
}
