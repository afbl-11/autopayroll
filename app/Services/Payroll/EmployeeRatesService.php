<?php

namespace App\Services\Payroll;

use App\Models\Employee;
use App\Models\EmployeeRate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EmployeeRatesService
{
    public function createRate(array $data) : EmployeeRate {

        $admin = Auth::guard('admin')->id();
        $employee = Employee::find($data['employee_id']);

        return EmployeeRate::create([
           'employee_rate_id' => Str::uuid(),
            'employee_id' => $data['employee_id'],
            'admin_id' => $admin,
            'rate' => $data['rate'],
            'effective_from' => Carbon::now()->format('Y-m-d'),
        ]);
    }

    public function updateRate(array $data) : EmployeeRate {

        $oldRate = EmployeeRate::where('employee_id', $data['employeeId'])
                ->whereNull('effective_to')
                ->first();

        $oldRate->update([
            'effective_to' => Carbon::now()->sub(1,'day')->format('Y-m-d'),
        ]);

        return $this->createRate($data['employeeId']);
    }
}
