<?php

namespace App\Console\Commands;

use App\Models\Employee;
use App\Services\AttendanceService;
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
        $this->info('Starting absence check...');

        $employees = Employee::all();
        $absentCount = 0;

        foreach ($employees as $employee) {
            // We capture the "result" of the function in $isAbsent
            $isAbsent = $attendanceService->markAbsent($employee->employee_id);

            if ($isAbsent) {
                $absentCount++;
                $this->info("Employee {$employee->employee_id} was marked absent.");
            }
        }

        $this->comment("Process finished. Total new absences: $absentCount");
    }
}
