<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\TestCase;

class EmployeeDashboard extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
      $service = app(\App\Services\employee_web\EmployeeDashboard::class);

      $result = $service->getSchedule();

      dd($result);
    }
}
