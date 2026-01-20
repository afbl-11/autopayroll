<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AttendanceLogs;
use App\Models\Employee;
use App\Services\Payroll\AttendancePayrollService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SeedAttendanceData extends Command
{
    protected $signature = 'attendance:seed {employee_id} {start_date} {end_date}';
    protected $description = 'Seed attendance data with mixed statuses (Present, Late, Overtime)';

    public function handle()
    {
        $employeeId = $this->argument('employee_id');
        $startDate = Carbon::parse($this->argument('start_date'));
        $endDate = Carbon::parse($this->argument('end_date'));

        $employee = Employee::find($employeeId);
        if (!$employee) {
            $this->error("Employee {$employeeId} not found");
            return 1;
        }

        $this->info("Seeding attendance for {$employee->first_name} {$employee->last_name}");
        $this->info("From {$startDate->format('Y-m-d')} to {$endDate->format('Y-m-d')}");

        $payrollService = new AttendancePayrollService();
        $currentDate = $startDate->copy();
        $count = 0;

        DB::beginTransaction();

        try {
            while ($currentDate <= $endDate) {
                // Skip Sundays (assuming Sunday is rest day)
                if ($currentDate->dayOfWeek === 0) {
                    $currentDate->addDay();
                    continue;
                }

                // Generate random status: 60% Present, 25% Late, 15% Overtime
                $rand = rand(1, 100);
                if ($rand <= 60) {
                    $status = 'P'; // Present
                    $timeIn = '08:00:00';
                    $timeOut = '17:00:00';
                } elseif ($rand <= 85) {
                    $status = 'LT'; // Late
                    $lateMinutes = rand(10, 45);
                    $timeIn = Carbon::parse('08:00:00')->addMinutes($lateMinutes)->format('H:i:s');
                    $timeOut = '17:00:00';
                } else {
                    $status = 'O'; // Overtime
                    $timeIn = '08:00:00';
                    $overtimeHours = rand(1, 3);
                    $timeOut = Carbon::parse('17:00:00')->addHours($overtimeHours)->format('H:i:s');
                }

                $clockInTime = $currentDate->format('Y-m-d') . ' ' . $timeIn;
                $clockOutTime = $currentDate->format('Y-m-d') . ' ' . $timeOut;

                // Delete existing record if any
                AttendanceLogs::withoutGlobalScope(\App\Models\Scopes\AdminScope::class)
                    ->where('employee_id', $employeeId)
                    ->where('log_date', $currentDate->format('Y-m-d'))
                    ->delete();

                // Create attendance record
                AttendanceLogs::withoutGlobalScope(\App\Models\Scopes\AdminScope::class)
                    ->create([
                        'admin_id' => $employee->admin_id,
                        'company_id' => $employee->company_id,
                        'employee_id' => $employeeId,
                        'log_date' => $currentDate->format('Y-m-d'),
                        'time_in' => $timeIn,
                        'time_out' => $timeOut,
                        'clock_in_time' => $clockInTime,
                        'clock_out_time' => $clockOutTime,
                        'status' => $status,
                        'is_manual' => 1,
                        'is_adjusted' => 1,
                    ]);

                // Sync to payroll
                $payrollService->syncAttendanceToPayroll(
                    $employeeId,
                    $currentDate->format('Y-m-d'),
                    $employee->company_id
                );

                $count++;
                $this->info("✓ {$currentDate->format('Y-m-d')} - Status: {$status} - In: {$timeIn} Out: {$timeOut}");

                $currentDate->addDay();
            }

            DB::commit();

            $this->info("\n✅ Successfully seeded {$count} attendance records with payroll!");
            return 0;

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("Error: " . $e->getMessage());
            return 1;
        }
    }
}
