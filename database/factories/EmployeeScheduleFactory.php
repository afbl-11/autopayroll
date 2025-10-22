<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Employee;
use App\Models\EmployeeSchedule;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmployeeSchedule>
 */
class EmployeeScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    $usedEmployeeIds = EmployeeSchedule::pluck('employee_id')->toArray();

    // Pick a random employee not already scheduled
    $employee = Employee::whereNotIn('employee_id', $usedEmployeeIds)
        ->inRandomOrder()
        ->first();

    $company = Company::inRandomOrder()->first();

    // Pick a random shift
    $shift = Shift::inRandomOrder()->first();

    // Generate random working days (5 or 6)
    $possibleDays = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    $workingDays = collect($this->faker->randomElements($possibleDays, rand(5, 6)))->values();

    // Generate random start and end dates
    $startDate = $this->faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d');
    $endDate = $this->faker->boolean(70) // 70% chance to have an end date
        ? $this->faker->dateTimeBetween($startDate, '+2 months')->format('Y-m-d')
        : null;

    return [
        'employee_schedules_id'  => Carbon::now()->year . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
        'employee_id' => $employee?->employee_id,
        'company_id' => $company?->company_id,
        'shift_id' => $shift?->shift_id,
        'working_days' => json_encode($workingDays),

        // Optional custom schedule overrides
        'custom_start' => null,
        'custom_end' => null,
        'custom_break_start' => null,
        'custom_break_end' => null,
        'custom_lunch_start' => null,
        'custom_lunch_end' => null,

        // Historical schedule support
        'start_date' => $startDate,
        'end_date' => $endDate,
    ];
}
}
