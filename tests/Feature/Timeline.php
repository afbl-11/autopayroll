<?php

namespace Tests\Feature;

use App\Models\AttendanceLogs;
use App\Models\Employee;
use App\Models\EmployeeSchedule;
use App\Services\AttendanceReport;
use App\Services\AttendanceService;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Foundation\Testing\WithFaker;


class Timeline extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $service = app(AttendanceReport::class);

        $sched = Employee::with('employeeSchedule')->find('20250778');

//        dd($sched);
        $start_time =  $sched->employeeSchedule->first()->start_time;
        $end_time =  $sched->employeeSchedule->first()->end_time;

        $log = AttendanceLogs::where('employee_id','20250778')->first();

        $result = $service->generateTimeline($start_time, $end_time,$log->clock_in_time,$log->clock_out_time);

        dd($result);

    }
}
