<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhilhealthRate extends Model
{
    protected $fillable = [
        'effectivity_year',
        'premium_rate',
        'salary_floor',
        'salary_ceiling',
        'status',
    ];

    /**
     * Calculate PhilHealth contribution based on salary and year.
     * Usage: PhilHealthRate::calculate(35000, 2026);
     */
    public static function calculate(float $salary, int $year)
    {
        // 1. Fetch the rules for the specific year
        $rule = self::where('effectivity_year', $year)->first();

        if (!$rule) {
            throw new \Exception("PhilHealth rates for year {$year} not found.");
        }

        // 2. Clamp the salary between the floor and ceiling
        // If salary is ₱5,000, it becomes ₱10,000 (floor)
        // If salary is ₱150,000, it becomes ₱100,000 (ceiling)
        $clampedSalary = max($rule->salary_floor, min($salary, $rule->salary_ceiling));

        // 3. Compute Total Premium (5% of clamped salary)
        $totalPremium = $clampedSalary * ($rule->premium_rate / 100);

        // 4. Split 50/50
        $share = $totalPremium / 2;

        return [
            'total_premium'  => round($totalPremium, 2),
            'employee_share' => round($share, 2),
            'employer_share' => round($share, 2),
            'applied_rate'   => $rule->premium_rate,
        ];
    }
}
