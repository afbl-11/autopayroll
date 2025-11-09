<?php

namespace App\Services\Payroll;

class ContributionService
{
    /**
     * Compute SSS contribution based on regular salary
     */
    public function computeSSS(float $regularSalary): array
    {
        $base = min(max($regularSalary, 4000), 30000);

        $employeeShare = $base * 0.045;
        $employerShare = $base * 0.095;

        return [
            'base' => $base,
            'employee' => round($employeeShare, 2),
            'employer' => round($employerShare, 2),
            'total' => round($employeeShare + $employerShare, 2),
        ];
    }

    /**
     * Compute PhilHealth contribution based on regular salary
     */
    public function computePhilHealth(float $regularSalary): array
    {
        $base = min(max($regularSalary, 10000), 100000);

        $total = $base * 0.05;
        $employeeShare = $total / 2;
        $employerShare = $total / 2;

        return [
            'base' => $base,
            'employee' => round($employeeShare, 2),
            'employer' => round($employerShare, 2),
            'total' => round($total, 2),
        ];
    }

    /**
     * Compute Pag-IBIG contribution
     */
    public function computePagIbig(float $regularSalary): array
    {
        $employeeRate = $regularSalary <= 1500 ? 0.01 : 0.02;

        $base = min($regularSalary, 5000);

        $employeeShare = $base * $employeeRate;
        $employerShare = $base * 0.02;

        return [
            'base' => $base,
            'employee' => round($employeeShare, 2),
            'employer' => round($employerShare, 2),
            'total' => round($employeeShare + $employerShare, 2),
        ];
    }

    /**
     * Compute all government contributions
     */
    public function computeAll(float $regularSalary): array
    {
        $sss = $this->computeSSS($regularSalary);
        $philhealth = $this->computePhilHealth($regularSalary);
        $pagibig = $this->computePagIbig($regularSalary);

        return [
            'sss' => $sss,
            'philhealth' => $philhealth,
            'pagibig' => $pagibig,
            'total_employee' => round($sss['employee'] + $philhealth['employee'] + $pagibig['employee'], 2),
            'total_employer' => round($sss['employer'] + $philhealth['employer'] + $pagibig['employer'], 2),
            'total_contribution' => round(
                $sss['total'] + $philhealth['total'] + $pagibig['total'], 2
            ),
        ];
    }
}
