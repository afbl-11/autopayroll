<?php

namespace Tests\Feature;

use App\Models\AttendanceLogs;
use App\Models\Employee;
use App\Services\CreditAdjustmentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
//use Tests\TestCase;
use Illuminate\Foundation\Testing\TestCase;

class AdjustClock extends TestCase
{
    public function testAdjustClock() {

        $service = app(CreditAdjustmentService::class);

        $employee = Employee::find('20250222');
        $log = AttendanceLogs::where('employee_id', $employee->employee_id)->first();

//        dd($log->log_id);
        $data = [
            'employee_id' => $employee->employee_id,
//            'new_clock_out' => '16:56:52',
            'log_date' => '2025-11-09',
//            'log_id' => $log->log_id,
        ];

        $result = $service->markPresent($data);

        dd($result);
    }
}
