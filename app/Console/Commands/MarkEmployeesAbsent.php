<?php

namespace App\Console\Commands;

use App\Models\AttendanceLogs;
use App\Models\Employee;
use App\Models\EmployeeSchedule;
use App\Services\AttendanceService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MarkEmployeesAbsent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:mark-absent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks for missing logs and marks employees as absent';

    /**
     * Execute the console command.
     */
    public function handle(AttendanceService $attendanceService)
    {
        $now = now();
        $today = $now->toDateString();
        $currentTime = $now->toTimeString();

        $schedules = EmployeeSchedule::where('end_time', '<=', $currentTime)
            ->whereNull('end_date')
            ->get();
        $absentCount = 0;
        foreach ($schedules as $schedule) {
            $alreadyProcessed = AttendanceLogs::where('employee_id', $schedule->employee_id)
                ->where('log_date', $today)
                ->exists();

            if (!$alreadyProcessed) {
                $attendanceService->markAbsent($schedule->employee_id, includeToday: true);

                $absentCount++;
                $this->info("Employee {$schedule->employee_id} was marked absent." . $absentCount);

                $this->info("Employee ID: {$schedule->employee_id} processed.");
            }
        }
        $this->info("No Employee Processed...");
    }
}
