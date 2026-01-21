<?php

namespace App\Services\Payroll;

use App\Models\AttendanceLogs;
use App\Models\DailyPayrollLog;
use App\Models\Employee;
use App\Models\PayrollPeriod;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AttendancePayrollService
{
    /**
     * Sync attendance to payroll for a specific employee and date
     */
    public function syncAttendanceToPayroll($employeeId, $date, $companyId)
    {
        try {
            // Get attendance log
            $attendance = AttendanceLogs::withoutGlobalScope(\App\Models\Scopes\AdminScope::class)
                ->where('employee_id', $employeeId)
                ->where('log_date', $date)
                ->where('company_id', $companyId)
                ->first();

            if (!$attendance) {
                \Log::warning("No attendance found for employee {$employeeId} on {$date}");
                return null;
            }

            // Get employee with rate
            $employee = Employee::with('currentRate')->find($employeeId);
            if (!$employee) {
                throw new \Exception("Employee {$employeeId} not found");
            }

            // Get or create payroll period
            $period = $this->getActivePayrollPeriod();
            if (!$period) {
                throw new \Exception("No active payroll period found");
            }

            // Compute payroll based on attendance status
            $payrollData = $this->computePayrollFromAttendance($attendance, $employee);

            // Create or update daily payroll log
            return DailyPayrollLog::withoutGlobalScope(\App\Models\Scopes\AdminScope::class)
                ->updateOrCreate(
                    [
                        'employee_id' => $employeeId,
                        'payroll_date' => $date,
                        'payroll_period_id' => $period->payroll_period_id,
                    ],
                    array_merge($payrollData, [
                        'admin_id' => $employee->admin_id,
                        'is_adjusted' => 1,
                    ])
                );

        } catch (\Exception $e) {
            \Log::error('Payroll sync error: ' . $e->getMessage(), [
                'employee_id' => $employeeId,
                'date' => $date,
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Compute payroll based on attendance status
     */
    private function computePayrollFromAttendance($attendance, $employee)
    {
        $status = $attendance->status;
        $rate = $employee->currentRate?->rate ?? 0;
        
        // Log warning if employee has no rate
        if ($rate == 0) {
            \Log::warning("Employee has no rate configured", [
                'employee_id' => $employee->employee_id,
                'employee_name' => $employee->first_name . ' ' . $employee->last_name,
                'attendance_date' => $attendance->clock_in_time,
                'status' => $status
            ]);
        }
        
        // Base computation values
        $regularHours = 8;
        $dailyRate = $rate;
        $hourlyRate = $dailyRate / $regularHours;
        $perMinuteRate = $hourlyRate / 60;

        $clockInTime = $attendance->clock_in_time;
        $clockOutTime = $attendance->clock_out_time;

        // Initialize payroll data
        $payrollData = [
            'clock_in_time' => $clockInTime,
            'clock_out_time' => $clockOutTime,
            'gross_salary' => 0,
            'net_salary' => 0,
            'deduction' => 0,
            'overtime' => 0,
            'night_differential' => 0,
            'holiday_pay' => 0,
            'work_hours' => 0,
            'late_time' => 0,
        ];

        switch ($status) {
            case 'P': // Present
                return $this->computePresent($attendance, $employee, $hourlyRate, $dailyRate, $regularHours, $perMinuteRate);

            case 'O': // Overtime
            case 'OT': // Overtime (alternative)
                return $this->computeOvertime($attendance, $employee, $hourlyRate, $dailyRate, $regularHours, $perMinuteRate);

            case 'LT': // Late/Undertime
                return $this->computeLateUndertime($attendance, $employee, $hourlyRate, $dailyRate, $regularHours, $perMinuteRate);

            case 'A': // Absent
                return $this->computeAbsent();

            case 'DO': // Day Off
            case 'CD': // Change Day Off (same as day off - paid)
                return $this->computeDayOff($dailyRate);

            case 'RH': // Regular Holiday
            case 'R': // Regular Holiday (alternative)
            case 'L': // Legal Holiday
                return $this->computeHoliday($attendance, $employee, $dailyRate, $hourlyRate, $regularHours, true);

            case 'SH': // Special Holiday
            case 'S': // Special Holiday (alternative)
                return $this->computeHoliday($attendance, $employee, $dailyRate, $hourlyRate, $regularHours, false);

            case 'CO': // Change Day Off (old code)
                return $this->computeDayOff($dailyRate);

            case 'CDO': // Cancel Day Off
                return $this->computeCancelDayOff($attendance, $employee, $hourlyRate, $dailyRate, $regularHours, $perMinuteRate);

            default:
                return $payrollData;
        }
    }

    /**
     * Compute Present status
     */
    private function computePresent($attendance, $employee, $hourlyRate, $dailyRate, $regularHours, $perMinuteRate)
    {
        if (!$attendance->clock_in_time || !$attendance->clock_out_time) {
            return [
                'gross_salary' => $dailyRate,
                'net_salary' => $dailyRate,
                'deduction' => 0,
                'overtime' => 0,
                'night_differential' => 0,
                'holiday_pay' => 0,
                'work_hours' => $regularHours,
                'late_time' => 0,
                'clock_in_time' => $attendance->clock_in_time ?? '00:00:00',
                'clock_out_time' => $attendance->clock_out_time ?? '00:00:00',
            ];
        }

        $clockIn = Carbon::parse($attendance->clock_in_time);
        $clockOut = Carbon::parse($attendance->clock_out_time);
        
        // Handle night shifts that cross midnight
        if ($clockOut->lessThan($clockIn)) {
            $clockOut->addDay();
        }
        
        $workHours = $clockIn->diffInHours($clockOut, true);
        $workHours = min($workHours, $regularHours); // Cap at regular hours
        
        $grossSalary = $hourlyRate * $workHours;
        
        // Calculate night differential
        $nightDiff = $this->calculateNightDifferential($clockIn, $clockOut, $hourlyRate);
        
        return [
            'gross_salary' => $grossSalary,
            'net_salary' => $grossSalary + $nightDiff,
            'deduction' => 0,
            'overtime' => 0,
            'night_differential' => $nightDiff,
            'holiday_pay' => 0,
            'work_hours' => $workHours,
            'late_time' => 0,
            'clock_in_time' => $attendance->clock_in_time,
            'clock_out_time' => $attendance->clock_out_time,
        ];
    }

    /**
     * Compute Overtime status
     */
    private function computeOvertime($attendance, $employee, $hourlyRate, $dailyRate, $regularHours, $perMinuteRate)
    {
        if (!$attendance->clock_in_time || !$attendance->clock_out_time) {
            return $this->computePresent($attendance, $employee, $hourlyRate, $dailyRate, $regularHours, $perMinuteRate);
        }

        $clockIn = Carbon::parse($attendance->clock_in_time);
        $clockOut = Carbon::parse($attendance->clock_out_time);
        
        // Handle night shifts that cross midnight
        if ($clockOut->lessThan($clockIn)) {
            $clockOut->addDay();
        }
        
        $totalHours = $clockIn->diffInHours($clockOut, true);
        $workHours = min($totalHours, $regularHours);
        $overtimeHours = max($totalHours - $regularHours, 0);
        
        $grossSalary = $hourlyRate * $workHours;
        $overtimePay = $hourlyRate * $overtimeHours * 1.25; // 125% for overtime
        
        // Calculate night differential
        $nightDiff = $this->calculateNightDifferential($clockIn, $clockOut, $hourlyRate);
        
        $netSalary = $grossSalary + $overtimePay + $nightDiff;
        
        return [
            'gross_salary' => $grossSalary,
            'net_salary' => $netSalary,
            'deduction' => 0,
            'overtime' => $overtimePay,
            'night_differential' => $nightDiff,
            'holiday_pay' => 0,
            'work_hours' => $totalHours,
            'late_time' => 0,
            'clock_in_time' => $attendance->clock_in_time,
            'clock_out_time' => $attendance->clock_out_time,
        ];
    }

    /**
     * Compute Late/Undertime status
     */
    private function computeLateUndertime($attendance, $employee, $hourlyRate, $dailyRate, $regularHours, $perMinuteRate)
    {
        if (!$attendance->clock_in_time || !$attendance->clock_out_time) {
            // If no time recorded for late, treat as absent
            return $this->computeAbsent();
        }

        $clockIn = Carbon::parse($attendance->clock_in_time);
        $clockOut = Carbon::parse($attendance->clock_out_time);
        
        // Handle night shifts that cross midnight
        if ($clockOut->lessThan($clockIn)) {
            $clockOut->addDay();
        }
        
        $workHours = $clockIn->diffInHours($clockOut, true);
        $workMinutes = $clockIn->diffInMinutes($clockOut, true);
        
        // Calculate deduction based on how short of 8 hours they worked
        $expectedMinutes = $regularHours * 60;
        $shortMinutes = max($expectedMinutes - $workMinutes, 0);
        
        $deduction = $perMinuteRate * $shortMinutes;
        $grossSalary = $dailyRate;
        
        // Calculate night differential
        $nightDiff = $this->calculateNightDifferential($clockIn, $clockOut, $hourlyRate);
        
        $netSalary = $grossSalary - $deduction + $nightDiff;
        
        return [
            'gross_salary' => $grossSalary,
            'net_salary' => $netSalary,
            'deduction' => $deduction,
            'overtime' => 0,
            'night_differential' => $nightDiff,
            'holiday_pay' => 0,
            'work_hours' => $workHours,
            'late_time' => $shortMinutes,
            'clock_in_time' => $attendance->clock_in_time,
            'clock_out_time' => $attendance->clock_out_time,
        ];
    }

    /**
     * Compute Absent status
     */
    private function computeAbsent()
    {
        return [
            'gross_salary' => 0,
            'net_salary' => 0,
            'deduction' => 0,
            'overtime' => 0,
            'night_differential' => 0,
            'holiday_pay' => 0,
            'work_hours' => 0,
            'late_time' => 0,
            'clock_in_time' => null,
            'clock_out_time' => null,
        ];
    }

    /**
     * Compute Day Off status
     */
    private function computeDayOff($dailyRate)
    {
        return [
            'gross_salary' => $dailyRate,
            'net_salary' => $dailyRate,
            'deduction' => 0,
            'overtime' => 0,
            'night_differential' => 0,
            'holiday_pay' => 0,
            'work_hours' => 0,
            'late_time' => 0,
            'clock_in_time' => null,
            'clock_out_time' => null,
        ];
    }

    /**
     * Compute Holiday status (Regular/Legal or Special)
     */
    private function computeHoliday($attendance, $employee, $dailyRate, $hourlyRate, $regularHours, $isRegularHoliday)
    {
        // Regular/Legal Holiday = 200% (double pay)
        // Special Holiday = 130% (30% bonus)
        $holidayMultiplier = $isRegularHoliday ? 2.0 : 1.3;
        
        $holidayPay = $dailyRate * $holidayMultiplier;
        
        return [
            'gross_salary' => $dailyRate,
            'net_salary' => $holidayPay,
            'deduction' => 0,
            'overtime' => 0,
            'night_differential' => 0,
            'holiday_pay' => $holidayPay - $dailyRate,
            'work_hours' => $regularHours,
            'late_time' => 0,
            'clock_in_time' => $attendance->clock_in_time,
            'clock_out_time' => $attendance->clock_out_time,
        ];
    }

    /**
     * Compute Cancel Day Off status
     */
    private function computeCancelDayOff($attendance, $employee, $hourlyRate, $dailyRate, $regularHours, $perMinuteRate)
    {
        // If time-in/time-out exists → base salary applies
        if ($attendance->clock_in_time && $attendance->clock_out_time) {
            return $this->computePresent($attendance, $employee, $hourlyRate, $dailyRate, $regularHours, $perMinuteRate);
        }
        
        // If no time record → treated as Absent
        return $this->computeAbsent();
    }

    /**
     * Get active payroll period
     */
    private function getActivePayrollPeriod()
    {
        return PayrollPeriod::where('is_closed', false)
            ->latest()
            ->first();
    }

    /**
     * Calculate night differential for hours worked between 10 PM and 6 AM
     * Returns 10% premium pay for those hours
     */
    private function calculateNightDifferential($clockIn, $clockOut, $hourlyRate)
    {
        $nightDiffRate = 0.10; // 10% premium
        
        // Set up night differential period (10 PM to 6 AM)
        $nightDiffStart = $clockIn->copy()->setTimeFromTimeString('22:00:00');
        $nightDiffEnd = $clockIn->copy()->addDay()->setTimeFromTimeString('06:00:00');
        
        // Calculate overlap between work hours and night differential period
        $overlapStart = max($clockIn->timestamp, $nightDiffStart->timestamp);
        $overlapEnd = min($clockOut->timestamp, $nightDiffEnd->timestamp);
        
        // If there's an overlap, calculate hours
        $ndHours = 0;
        if ($overlapEnd > $overlapStart) {
            $ndHours = ($overlapEnd - $overlapStart) / 3600; // Convert seconds to hours
        }
        
        // Return night differential premium
        return round($hourlyRate * $ndHours * $nightDiffRate, 2);
    }

    /**
     * Bulk sync attendance to payroll for multiple employees
     */
    public function bulkSyncAttendanceToPayroll(array $records, $date, $companyId)
    {
        DB::beginTransaction();
        
        try {
            $results = [];
            
            foreach ($records as $employeeId => $data) {
                $result = $this->syncAttendanceToPayroll($employeeId, $date, $companyId);
                $results[$employeeId] = $result;
            }
            
            DB::commit();
            
            return $results;
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
