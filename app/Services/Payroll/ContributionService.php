<?php

namespace App\Services\Payroll;

use App\Models\PagIbigVersion;
use App\Models\PhilhealthRate;
use App\Models\SssVersionsTable;

class ContributionService
{
    public function computeAll(float $regularSalary): array
    {
        try {
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
        } catch (\Throwable $e) {
            // This will intercept the 500 error and show you the culprit
            dd([
                'error' => $e->getMessage(),
                'file'  => $e->getFile(),
                'line'  => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
    /**
     * Compute Pag-IBIG
     */
    public function computePagIbig(float $salary): array
    {
        $policy = PagIbigVersion::where('status', 'active')->first();

        // Use Null-safe operator ?-> to prevent 500 error if $policy is null
        $cap = (float) ($policy?->salary_cap ?? 10000.00);
        $eeRate = (float) ($policy?->employee_rate_above_threshold ?? 0.02);
        $erRate = (float) ($policy?->employer_rate ?? 0.02);

        $basis = min($salary, $cap);

        // Ensure rate is treated as decimal (e.g., 2% = 0.02)
        $actualEeRate = $eeRate > 1 ? $eeRate / 100 : $eeRate;
        $actualErRate = $erRate > 1 ? $erRate / 100 : $erRate;

        $ee = $basis * $actualEeRate;
        $er = $basis * $actualErRate;

        return [
            'employee' => round($ee, 2),
            'employer' => round($er, 2),
            'total'    => round($ee + $er, 2)
        ];
    }

    /**
     * Compute PhilHealth
     */
    public function computePhilHealth(float $salary): array
    {
        $policy = PhilhealthRate::where('status', 'active')->first();

        // Null-safe defaults
        $rawRate = (float) ($policy?->premium_rate ?? 0.05);
        $minSalary = (float) ($policy?->salary_floor ?? 10000.00);
        $maxSalary = (float) ($policy?->salary_ceiling ?? 100000.00);

        // Handle if DB has "5.00" instead of "0.05"
        $rate = $rawRate > 1 ? $rawRate / 100 : $rawRate;

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
     * Compute SSS
     */
    public function computeSSS(float $salary): array
    {
        $activeVersion = SssVersionsTable::where('status', 'active')
            ->with(['brackets' => fn($q) => $q->orderBy('min_salary', 'asc')])
            ->first();

        if (!$activeVersion) {
            return ['employee' => 0, 'employer' => 0, 'total' => 0];
        }

        $matchedBracket = $activeVersion->brackets->first(function ($bracket) use ($salary) {
            $max = $bracket->max_salary ?? INF;
            return $salary >= $bracket->min_salary && $salary <= $max;
        });

        if (!$matchedBracket) {
            return ['employee' => 0, 'employer' => 0, 'total' => 0];
        }

        $msc = (float) $matchedBracket->msc_amount;

        // Ensure rates are decimals
        $eeRate = (float) $activeVersion->ee_rate;
        $erRate = (float) $activeVersion->er_rate;
        $eeRate = $eeRate > 1 ? $eeRate / 100 : $eeRate;
        $erRate = $erRate > 1 ? $erRate / 100 : $erRate;

        $eeShare = $msc * $eeRate;
        $erShare = ($msc * $erRate) + (float)($matchedBracket->ec_er_share ?? 0);

        return [
            'employee' => round($eeShare, 2),
            'employer' => round($erShare, 2),
            'total'    => round($eeShare + $erShare, 2)
        ];
    }
}
