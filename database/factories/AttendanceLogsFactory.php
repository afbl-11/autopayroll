<?php

namespace Database\Factories;

use App\Models\AttendanceLogs;
use App\Models\Company;
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
        $company = Company::inRandomOrder()->first();

        // simulate GPS coordinates within some company range
        $clockInLat = $this->faker->latitude(14.5, 14.7);
        $clockInLong = $this->faker->longitude(120.9, 121.1);

        // add small variation for clock out
        $clockOutLat = $clockInLat + $this->faker->randomFloat(6, -0.001, 0.001);
        $clockOutLong = $clockInLong + $this->faker->randomFloat(6, -0.001, 0.001);

        return [
            'log_id' => Str::uuid(),
            'employee_id' => $employee ? $employee->employee_id : $this->faker->uuid(),
            'company_id' => $company ? $company->company_id : $this->faker->uuid(),
            'clock_in_time' => $clockIn,
            'clock_out_time' => $clockOut,
            'clock_in_latitude' => $clockInLat,
            'clock_in_longitude' => $clockInLong,
            'clock_out_latitude' => $clockOutLat,
            'clock_out_longitude' => $clockOutLong,
//            'android_id' => $employee ? 'device-' . $this->faker->uuid() : null,
        ];
    }
}
