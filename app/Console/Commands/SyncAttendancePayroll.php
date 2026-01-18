<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AttendanceLogs;
use App\Services\Payroll\AttendancePayrollService;

class SyncAttendancePayroll extends Command
{
    protected $signature = 'attendance:sync-payroll {employee_id} {date} {company_id}';
    protected $description = 'Sync attendance to payroll for a specific employee and date';

    public function handle()
    {
        $employeeId = $this->argument('employee_id');
        $date = $this->argument('date');
        $companyId = $this->argument('company_id');

        // Update attendance record
        $att = AttendanceLogs::withoutGlobalScope(\App\Models\Scopes\AdminScope::class)
            ->where('employee_id', $employeeId)
            ->where('log_date', $date)
            ->first();

        if (!$att) {
            $this->error("Attendance not found for employee {$employeeId} on {$date}");
            return 1;
        }

        // Ensure clock times are set
        if (!$att->clock_in_time && $att->time_in) {
            $att->clock_in_time = $date . ' ' . $att->time_in;
        }
        if (!$att->clock_out_time && $att->time_out) {
            $att->clock_out_time = $date . ' ' . $att->time_out;
        }
        $att->is_adjusted = 1;
        $att->save();

        // Sync to payroll
        $service = new AttendancePayrollService();
        $result = $service->syncAttendanceToPayroll($employeeId, $date, $companyId);

        if ($result) {
            $this->info("Payroll synced successfully for employee {$employeeId} on {$date}");
            return 0;
        } else {
            $this->error("Failed to sync payroll");
            return 1;
        }
    }
}
