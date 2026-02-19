<?php
namespace App\Services\Payroll;

use App\Models\PagIbigVersion;
use App\Models\PhilhealthRate;
use App\Models\SssVersionsTable;

// Add your SSS and PhilHealth models here
// use App\Models\SssVersion;
// use App\Models\PhilHealthVersion;

class ContributionService
{
    public function computeAll(float $regularSalary): array
    {
        // We pass the regular salary to all, but each method
        // will apply its own specific versioning logic.
        $sss = $this->computeSSS($regularSalary);
        $philhealth = $this->computePhilHealth($regularSalary);
        $pagibig = $this->computePagIbig($regularSalary);

        return [
            'sss' => $sss,
            'philhealth' => $philhealth,
            'pagibig' => $pagibig,
            'total_employee' => round($sss['employee'] + $philhealth['employee'] + $pagibig['employee'], 2),
            'total_employer' => round($sss['employer'] + $philhealth['employer'] + $pagibig['employer'], 2),
            'total_contribution' => round($sss['total'] + $philhealth['total'] + $pagibig['total'], 2),
        ];
    }

    /**
     * Compute Pag-IBIG based on the Active Version in DB
     */
    public function computePagIbig(float $salary): array
    {
        $policy = PagIbigVersion::where('status', 'active')->first();

        // Fallback to 2026 standard if DB is empty
        $cap = $policy->salary_cap ?? 10000.00;
        $eeRateAbove = $policy->employee_rate_above_threshold ?? 0.02;
        $erRate = $policy->employer_rate ?? 0.02;

        // Logic: Basis is salary capped at the MFS Cap
        $basis = min($salary, $cap);

        $ee = $basis * $eeRateAbove;
        $er = $basis * $erRate;

        return [
            'employee' => round($ee, 2),
            'employer' => round($er, 2),
            'total'    => round($ee + $er, 2)
        ];
    }

    /**
     * Compute PhilHealth (2026 standard: 5% shared equally)
     */
    public function computePhilHealth(float $salary): array
    {
        $policy = PhilhealthRate::where('status', 'active')->first();

        // 2026 Standard Fallbacks
        $rate = $policy->premium_rate ?? 0.05;
        $minSalary = $policy->salary_floor ?? 10000.00;
        $maxSalary = $policy->salary_ceiling ?? 100000.00;

        // Apply PhilHealth Floor and Ceiling
        $basis = $salary;
        if ($basis < $minSalary) $basis = $minSalary;
        if ($basis > $maxSalary) $basis = $maxSalary;

        $totalContribution = $basis * $rate;
        $share = $totalContribution / 2;

        return [
            'employee' => round($share, 2),
            'employer' => round($share, 2),
            'total'    => round($totalContribution, 2)
        ];
    }

    /**
     * Compute SSS based on Salary Brackets
     */
    public function computeSSS(float $salary): array
    {
        // 1. Get the active version
        $activeVersion = \App\Models\SssVersionsTable::where('status', 'active')
            ->with(['brackets' => function($query) {
                $query->orderBy('min_salary', 'asc');
            }])
            ->first();

        if (!$activeVersion) return ['employee' => 0, 'employer' => 0, 'total' => 0];

        // 2. Find the correct bracket
        $matchedBracket = null;
        foreach ($activeVersion->brackets as $bracket) {
            $max = $bracket->max_salary ?? INF;
            if ($salary >= $bracket->min_salary && $salary <= $max) {
                $matchedBracket = $bracket;
                break;
            }
        }

        if (!$matchedBracket) return ['employee' => 0, 'employer' => 0, 'total' => 0];

        // 3. Calculate based on MSC (Monthly Salary Credit)
        // MSC is the basis for the percentage
        $msc = (float) $matchedBracket->msc_amount;

        // Standard 2026 Rates: EE (4.5%) and ER (9.5%)
        $eeShare = $msc * $activeVersion->ee_rate;
        $erShare = ($msc * $activeVersion->er_rate) + (float)$matchedBracket->ec_er_share; // Add the EC contribution to ER

        return [
            'employee' => round($eeShare, 2),
            'employer' => round($erShare, 2),
            'total'    => round($eeShare + $erShare, 2)
        ];
    }
}
