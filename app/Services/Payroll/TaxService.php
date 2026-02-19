<?php

namespace App\Services\Payroll;

use App\Models\TaxVersion;

class TaxService
{
    /**
     * Calculate Withholding Tax based on the active law version in the DB.
     */
    public function compute(float $monthlyTaxableIncome): float
    {
        $activeVersion = TaxVersion::where('status', 'active')
            ->with(['brackets' => function($query) {
                $query->orderBy('min_income', 'asc');
            }])
            ->first();

        if (!$activeVersion || $monthlyTaxableIncome <= 0) {
            return 0.00;
        }

        foreach ($activeVersion->brackets as $bracket) {
            $min = (float) $bracket->min_income;
            $max = $bracket->max_income ? (float) $bracket->max_income : INF;

            if ($monthlyTaxableIncome >= $min && $monthlyTaxableIncome <= $max) {
                $baseTax = (float) $bracket->base_tax;
                $excessOver = (float) $bracket->excess_over;
                $percentage = (float) $bracket->percentage;

                $taxableExcess = max(0, $monthlyTaxableIncome - $excessOver);
                $taxOnExcess = $taxableExcess * $percentage;

                return round($baseTax + $taxOnExcess, 2);
            }
        }

        return 0.00;
    }
}
