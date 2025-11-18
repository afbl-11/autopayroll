<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\LeaveCredits;
use App\Services\AttendanceService;
use App\Services\Auth\EmployeeRegistrationService;
use App\Services\LeaveCreditService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Foundation\Testing\WithFaker;


class CreateEmp extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {

        $empId = '20250778';
        $adminId = '20253519';
        $service = app(AttendanceService::class);
        $result = $service->getWorkingHours($empId);

      dd($result);
    }
}
