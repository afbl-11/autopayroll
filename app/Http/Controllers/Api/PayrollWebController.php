<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Carbon\Carbon;

class PayrollWebController extends Controller
{
    public function getPayroll($employeeId) {

        $employees = Employee::where('employee_id', $employeeId)
            ->with(['dailyPayrolls', 'currentRate'])->get();

        if($employees->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No data found',
            ]);
        }
        $data = [];

        foreach ($employees as $employee) {
            $rate = $employee->currentRate ? $employee->currentRate->rate : 0;
            foreach ($employee->dailyPayrolls as $log) {
                $data[] = [
                    'employee_id' => $employee->employee_id,
                    'employee_name' => $employee->first_name . ' ' . $employee->last_name,
                    'payroll_id' => $log->daily_payroll_id,
                    'rate' => $rate,
                    'gross_salary' => $log->gross_salary,
                    'net_salary' => $log->net_salary,
                    'deductions' => $log->deduction,
                    'overtime' => $log->overtime,
                    'night_differential' => $log->night_differential,
                    'holiday_pay' => $log->holiday_pay,
                    'payroll_date' => $log->payroll_date,
                    'late_time' => $log->late_time,
                    'work_hours' => $log->work_hours,
                    'clock_in_date' => Carbon::parse($log->clock_in_time)->format('Y-m-d'),
                    'clock_in_time' => Carbon::parse($log->clock_in_time)->format('H:i'),
                    'clock_out_date' => Carbon::parse($log->clock_out_time)->format('Y-m-d'),
                    'clock_out_time' => Carbon::parse($log->clock_out_time)->format('H:i'),
                ];
            }
        }

        return response()->json($data);

    }
}
