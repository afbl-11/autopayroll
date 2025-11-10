<?php

namespace Database\Factories;

use App\Models\LeaveRequest;
use App\Models\Employee;
use App\Models\Admin;
use App\Services\GenerateId;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class LeaveRequestFactory extends Factory
{
    protected $model = LeaveRequest::class;

    public function definition()
    {
        $employee = Employee::inRandomOrder()->first();

        $approver = Admin::inRandomOrder()->first();

        $leaveTypes = ['sick', 'vacation', 'maternity', 'bereavement', 'emergency'];
        $statuses = ['pending','approved','rejected','need revision'];


        $startDate = $this->faker->dateTimeBetween('-6 months', '+3 months');
        $endDate = (clone $startDate)->modify('+'.rand(1,5).' days');
        $admin = Admin::inRandomOrder()->first();
        return [
            'leave_request_id' => Str::uuid(),
            'admin_id' => $admin->admin_id,
            'employee_id' => $employee ? $employee->employee_id : $this->faker->uuid(),
            'approver_id' => $approver ? $approver->admin_id : $this->faker->uuid(),
            'leave_type' => $this->faker->randomElement($leaveTypes),
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'reason' => $this->faker->sentence(6),
            'status' => $this->faker->randomElement($statuses),
            'supporting_doc' => $this->faker->optional()->filePath(),
            'submission_date' => $this->faker->dateTimeBetween('-1 months', 'now')->format('Y-m-d'),
        ];
    }
}
