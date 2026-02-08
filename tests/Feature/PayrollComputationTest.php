<?php

namespace Tests\Feature;

use App\Models\AttendanceLogs;
use App\Models\Employee;
use App\Models\PayrollPeriod;
use App\Services\AttendanceService;
use App\Services\Payroll\AttendancePayrollService;
use App\Services\Payroll\PayrollComputation;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
//use Tests\TestCase;

class PayrollComputationTest extends TestCase
{
//    use RefreshDatabase;

    /** @test */
    /** @test */
    public function it_computes_the_overtime_pay_correctly()
    {
        // 1. Setup - Fetch your data
        $attendance = AttendanceLogs::where('employee_id', '20269719')
            ->where('log_date', '2026-02-03')
            ->firstOrFail();

        $employee = Employee::with('currentRate')->findOrFail('20269719');

        $dailyRate = $employee->currentRate->rate; // 625
        $regularHours = 8;
        $hourlyRate = $dailyRate / $regularHours; // 78.125
        $perMinuteRate = $hourlyRate / 60;
        dd($dailyRate );

        // 2. Execute - Call the service
        $service = app(AttendancePayrollService::class);

        // Using Reflection because computeOvertime is a private method
        $reflection = new \ReflectionClass(AttendancePayrollService::class);
        $method = $reflection->getMethod('computeOvertime');
        $method->setAccessible(true);

        $result = $method->invokeArgs($service, [
            $attendance, $employee, $hourlyRate, $dailyRate, $regularHours, $perMinuteRate
        ]);
        // 3. Assert - Check the math
        // Assuming 1 hour of OT: 625 (Regular) + (78.125 * 1.25) = 722.66
        $expectedOvertimePay = round(($hourlyRate / 9) * 1.25 * 1, 2);
        $expectedNet = round($dailyRate + $expectedOvertimePay, 2);

        $this->assertEquals(5000, $result['gross_salary'], 'Gross salary should be capped at daily rate');
        $this->assertEquals($expectedOvertimePay, round($result['overtime'], 2), 'Overtime pay calculation mismatch');
        $this->assertEquals($expectedNet, round($result['net_salary'], 2), 'Net salary calculation mismatch');
    }
}
