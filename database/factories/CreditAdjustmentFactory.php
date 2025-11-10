<?php

namespace Database\Factories;

use App\Models\CreditAdjustment;
use App\Models\Employee;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CreditAdjustmentFactory extends Factory
{
    protected $model = CreditAdjustment::class;

    public function definition()
    {
        $employee = Employee::inRandomOrder()->first();
        $approver = Admin::inRandomOrder()->first();
        $admin = Admin::inRandomOrder()->first();

        $types = ['attendance','leave','payroll','official_business'];
        $subtypes = [
            'TIME_CORR','LATE_CORR','ABSENCE_CORR','LOG_MISSING','OB_MARKING','DTR_CORR',
            'LEAVE_CREDIT_ADJ','LEAVE_STATUS_CORR','LEAVE_TYPE_CHANGE','LEAVE_CANCEL','LEAVE_POST_APPROVAL',
            'OT_CORR','HOLIDAY_PAY_CORR','PAYROLL_DIFF','DEDUCTION_CORR','BONUS_CORR','LEAVE_PAY_CORR',
            'OB_FILE','OB_CORR'
        ];
        $statuses = ['pending','approved','rejected'];

        $adjustmentType = $this->faker->randomElement($types);

        // optionally add start/end date for leave or OB
        $startDate = null;
        $endDate = null;
        if (in_array($adjustmentType, ['leave','official_business'])) {
            $startDate = $this->faker->dateTimeBetween('-1 years', 'now')->format('Y-m-d');
            $endDate = $this->faker->dateTimeBetween($startDate, 'now')->format('Y-m-d');
        }

        return [
            'adjustment_id' => Str::uuid(),
            'admin_id' => $admin ? $admin->admin_id : $this->faker->uuid(),
            'employee_id' => $employee ? $employee->employee_id : $this->faker->uuid(),
            'approver_id' => $approver ? $approver->admin_id : $this->faker->uuid(),
            'adjustment_type' => $adjustmentType,
            'subtype' => $this->faker->randomElement($subtypes),
            'reason' => $this->faker->sentence(6),
            'status' => $this->faker->randomElement($statuses),
            'affected_date' => $this->faker->dateTimeBetween('-1 years', 'now')->format('Y-m-d'),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'attachment_path' => null,
        ];
    }
}
