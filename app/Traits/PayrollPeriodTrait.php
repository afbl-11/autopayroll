<?php

namespace App\Traits;

use App\Models\PayrollPeriod;

trait PayrollPeriodTrait
{
    private function hasPeriod() {
        $payroll_period = PayrollPeriod::where('is_closed', false)
            ->latest()
            ->first();

        if(!$payroll_period) {
            return null;
        }
        $payroll_start = $payroll_period->start_date;
        $payroll_end = $payroll_period->end_date;

        return [$payroll_start, $payroll_end];
    }
}
