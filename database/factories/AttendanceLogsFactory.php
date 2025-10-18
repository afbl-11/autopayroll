<?php

namespace Database\Factories;

use App\Models\AttendanceLogs;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AttendanceLogsFactory extends Factory
{
    protected $model = AttendanceLogs::class;

    public function definition()
    {
        $clockIn = $this->faker->dateTimeBetween('08:00', '10:00');

        $clockOut = (clone $clockIn)->modify('+'.rand(8,10).' hours');

        $employee = Employee::inRandomOrder()->first();

        $lat = $this->faker->latitude(14.5, 14.7);
        $long = $this->faker->longitude(120.9, 121.1);

        return [
            'log_id' => Carbon::now()->year . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
            'employee_id' => $employee ? $employee->employee_id : $this->faker->uuid(),
            'clock_in_time' => $clockIn,
            'clock_out_time' => $clockOut,
            'clock_in_latitude' => $lat,
            'clock_in_longitude' => $long + 0.001,
        ];
    }
}
