<?php

namespace Tests\Feature;

use App\Models\AttendanceLogs;
use App\Models\Employee;
use App\Models\PayrollPeriod;
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
    public function it_computes_the_payroll_for_an_employee()
    {

        $employee = Employee::find('20253105');

//        dd($employee);

        $service = app(PayrollComputation::class);
        $result = $service->computePayroll($employee->employee_id);

        dd($result);

        $this->assertNotNull($result);
        $this->assertTrue($result['net_salary'] >= 0);
        $this->assertDatabaseHas('daily_payroll_logs', [
            'employee_id' => $employee->employee_id,
        ]);

    }
}
