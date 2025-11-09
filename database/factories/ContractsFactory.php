<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Contracts;
use App\Models\Employee;
use App\Services\GenerateId;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ContractsFactory extends Factory
{
    protected $model = Contracts::class;

    public function definition()
    {
        $employee = Employee::inRandomOrder()->first();
        $signedDate = $this->faker->dateTimeBetween('-1 years', 'now');
        $endDate = (clone $signedDate)->modify('+'.rand(1,3).' years');
        $admin = Admin::inRandomOrder()->first();

        return [
            'contract_id' => Carbon::now()->year . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
            'admin_id' => $admin->admin_id,
            'employee_id' => $employee ? $employee->employee_id : $this->faker->uuid(),
            'signed_date' => $signedDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'rate' => 500,
        ];
    }
}
