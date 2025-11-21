<?php

namespace Tests\Feature;

use App\Services\DashboardService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Foundation\Testing\WithFaker;


class CompanyPayroll extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
            $service = app(DashboardService::class);

            $result = $service->getDeductions();

           dd($result);
    }
}
