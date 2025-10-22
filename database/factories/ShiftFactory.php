<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shift>
 */
class ShiftFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $shiftPatterns = [
            ['start' => '08:00:00', 'end' => '17:00:00', 'break_start' => '10:00:00', 'break_end' => '10:15:00', 'lunch_start' => '12:00:00', 'lunch_end' => '13:00:00'], // Regular day
            ['start' => '06:00:00', 'end' => '15:00:00', 'break_start' => '09:00:00', 'break_end' => '09:15:00', 'lunch_start' => '12:00:00', 'lunch_end' => '13:00:00'], // Morning shift
            ['start' => '14:00:00', 'end' => '23:00:00', 'break_start' => '17:00:00', 'break_end' => '17:15:00', 'lunch_start' => '19:00:00', 'lunch_end' => '20:00:00'], // Swing shift
            ['start' => '22:00:00', 'end' => '07:00:00', 'break_start' => '01:00:00', 'break_end' => '01:15:00', 'lunch_start' => '03:00:00', 'lunch_end' => '04:00:00'], // Night shift
        ];

        $pattern = $this->faker->randomElement($shiftPatterns);
        return [
            'start_time' => $pattern['start'],
            'end_time' => $pattern['end'],
            'break_start' => $pattern['break_start'],
            'break_end' => $pattern['break_end'],
            'lunch_start' => $pattern['lunch_start'],
            'lunch_end' => $pattern['lunch_end'],
        ];
    }
}
