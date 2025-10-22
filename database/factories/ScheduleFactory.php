<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Shift;

class ScheduleFactory extends Factory
{
    protected $model = Shift::class;

    public function definition()
    {
        // pick a random company
        $company = Company::inRandomOrder()->first();

        // define common shifts
        $shifts = [
            ['shift_name' => 'Morning', 'start_time' => '08:00:00', 'end_time' => '16:00:00'],
            ['shift_name' => 'Afternoon', 'start_time' => '16:00:00', 'end_time' => '00:00:00'],
            ['shift_name' => 'Night', 'start_time' => '00:00:00', 'end_time' => '08:00:00'],
        ];

        $shift = $this->faker->randomElement($shifts);

        return [
            'schedule_id' => $this->faker->unique()->numberBetween(1, 10000),
            'company_id' => $company ? $company->company_id : $this->faker->uuid(),
            'shift_name' => $shift['shift_name'],
            'start_time' => $shift['start_time'],
            'end_time' => $shift['end_time'],
        ];
    }
}
