<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Company;
use App\Models\Employee;
use App\Models\EmployeeSchedule;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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

    // Generate random working days (5 or 6)
    $possibleDays = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    $workingDays = collect($this->faker->randomElements($possibleDays, rand(5, 6)))->values();

    // Generate random start and end dates
    $startDate = $this->faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d');
    $endDate = $this->faker->boolean(70) // 70% chance to have an end date
        ? $this->faker->dateTimeBetween($startDate, '+2 months')->format('Y-m-d')
        : null;

    $startHour = $this->faker->numberBetween(7, 10);
    $endHour = $startHour + $this->faker->numberBetween(7, 9);
    $start_time = sprintf('%02d:00', $startHour);
    $end_time = sprintf('%02d:00', $endHour);
    $admin = Admin::inRandomOrder()->first();
    return [
        'employee_schedules_id'  => Str::uuid(),
        'admin_id' => $admin->admin_id,
        'employee_id' => $employee?->employee_id,
        'working_days' => json_encode($workingDays),
        'start_time' => $start_time,
        'end_time' => $end_time,
        'start_date' => $startDate,
        'end_date' => $endDate,
    ];
}
}
