<?php

namespace Tests\Feature;

use App\Services\Payroll\ComputeSemi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\TestCase;

class SemiPayroll extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
       $service = app(ComputeSemi::class);
       $result = $service->calculateSemiPayroll();

        dd($result);

        $response->assertStatus(200);
    }
}
