<?php

namespace Database\Factories;

use App\Models\CreditAdjustment;
use App\Models\Employee;
use App\Models\Admin;
use App\Services\GenerateId;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CreditAdjustmentFactory extends Factory
{

    protected $model = CreditAdjustment::class;

    public function definition()
    {

        $employee = Employee::inRandomOrder()->first();

        $approver = Admin::inRandomOrder()->first();

        $types = ['attendance','leave','official business'];
        $statuses = ['approved','rejected'];

        return [
            'adjustment_id' => Carbon::now()->year . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
            'employee_id' => $employee ? $employee->employee_id : $this->faker->uuid(),
            'approver_id' => $approver ? $approver->admin_id : $this->faker->uuid(),
            'adjustment_type' => $this->faker->randomElement($types),
            'reason' => $this->faker->sentence(6),
            'status' => $this->faker->randomElement($statuses),
            'affected_date' => $this->faker->dateTimeBetween('-1 years', 'now')->format('Y-m-d'),
        ];
    }
}
