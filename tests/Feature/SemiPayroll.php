<?php

namespace Tests\Feature;

use App\Services\Payroll\PayrollHistory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\TestCase;

class SemiPayroll extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_generates_the_first_reference_for_a_year(): void
    {
        $service = app(PayrollHistory::class);

        $reference = $service->generatePayslipReference(2025);

        $this->assertEquals('PAY-2025-001', $reference);
    }

    /** @test */
    public function it_increments_reference_for_the_same_year(): void
    {
        // Seed existing payslip
        DB::table('payslips')->insert([
            'payslips_id'  => Str::uuid(),
            'employee_id'  => 'EMP-001',
            'year'         => 2025,
            'month'        => 1,
            'period'       => '1-15',
            'reference'    => 'PAY-2025-001',
            'period_start' => now(),
            'period_end'   => now(),
            'net_pay'      => 1000,
            'status'       => 'pending',
            'breakdown'    => json_encode([]),
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        $service = app(PayrollHistory::class);
        $reference = $service->generatePayslipReference(2025);

        $this->assertEquals('PAY-2025-002', $reference);
    }

    /** @test */
    public function it_resets_reference_for_a_new_year(): void
    {
        DB::table('payslips')->insert([
            'payslips_id'  => Str::uuid(),
            'employee_id'  => 'EMP-001',
            'year'         => 2025,
            'month'        => 12,
            'period'       => '16-30',
            'reference'    => 'PAY-2025-015',
            'period_start' => now(),
            'period_end'   => now(),
            'net_pay'      => 1000,
            'status'       => 'pending',
            'breakdown'    => json_encode([]),
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        $service = app(PayrollHistory::class);
        $reference = $service->generatePayslipReference(2026);

        $this->assertEquals('PAY-2026-001', $reference);
    }
}
