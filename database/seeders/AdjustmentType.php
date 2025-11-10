<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdjustmentType extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['main_type' => 'attendance', 'code' => 'TIME_CORR', 'label' => 'Time Correction', 'description' => 'Adjust incorrect time-in or time-out.', 'is_active' => true],
            ['main_type' => 'attendance', 'code' => 'LATE_CORR', 'label' => 'Late Correction', 'description' => 'Remove wrongly marked late.', 'is_active' => true],
            ['main_type' => 'attendance', 'code' => 'ABSENCE_CORR', 'label' => 'Absence Correction', 'description' => 'Change absent to present with valid proof.', 'is_active' => true],
            ['main_type' => 'attendance', 'code' => 'LOG_MISSING', 'label' => 'Missing Log Entry', 'description' => 'Add missing time-in or time-out.', 'is_active' => true],
            ['main_type' => 'attendance', 'code' => 'OB_MARKING', 'label' => 'Official Business Marking', 'description' => 'Convert a day to official business.', 'is_active' => true],
            ['main_type' => 'attendance', 'code' => 'DTR_CORR', 'label' => 'DTR Correction', 'description' => 'General daily time record correction.', 'is_active' => true],

            ['main_type' => 'leave', 'code' => 'LEAVE_CREDIT_ADJ', 'label' => 'Leave Credit Adjustment', 'description' => 'Add or deduct leave credits.', 'is_active' => true],
            ['main_type' => 'leave', 'code' => 'LEAVE_STATUS_CORR', 'label' => 'Leave Status Correction', 'description' => 'Change absent to leave.', 'is_active' => true],
            ['main_type' => 'leave', 'code' => 'LEAVE_TYPE_CHANGE', 'label' => 'Leave Type Change', 'description' => 'Convert leave type (e.g., VL → SL).', 'is_active' => true],
            ['main_type' => 'leave', 'code' => 'LEAVE_CANCEL', 'label' => 'Leave Cancellation', 'description' => 'Cancel previously approved leave.', 'is_active' => true],
            ['main_type' => 'leave', 'code' => 'LEAVE_POST_APPROVAL', 'label' => 'Post-Approval Filing', 'description' => 'Approve leave filed after the date.', 'is_active' => true],

            ['main_type' => 'payroll', 'code' => 'OT_CORR', 'label' => 'Overtime Correction', 'description' => 'Add or modify overtime hours.', 'is_active' => true],
            ['main_type' => 'payroll', 'code' => 'HOLIDAY_PAY_CORR', 'label' => 'Holiday Pay Correction', 'description' => 'Correct missing holiday pay.', 'is_active' => true],
            ['main_type' => 'payroll', 'code' => 'PAYROLL_DIFF', 'label' => 'Payroll Difference Adjustment', 'description' => 'Fix underpaid payroll.', 'is_active' => true],
            ['main_type' => 'payroll', 'code' => 'DEDUCTION_CORR', 'label' => 'Deduction Correction', 'description' => 'Remove or adjust incorrect deductions.', 'is_active' => true],
            ['main_type' => 'payroll', 'code' => 'BONUS_CORR', 'label' => 'Bonus or Allowance Correction', 'description' => 'Add missed bonus or allowance.', 'is_active' => true],
            ['main_type' => 'payroll', 'code' => 'LEAVE_PAY_CORR', 'label' => 'Leave Pay Correction', 'description' => 'Fix leave pay.', 'is_active' => true],

            ['main_type' => 'official_business', 'code' => 'OB_FILE', 'label' => 'Official Business Filing', 'description' => 'File an OB for past work-related travel.', 'is_active' => true],
            ['main_type' => 'official_business', 'code' => 'OB_CORR', 'label' => 'Official Business Correction', 'description' => 'Fix date or status of an OB entry.', 'is_active' => true],
        ];

        foreach ($types as &$type) {
            $type['adjustment_type_id'] = Str::uuid();
        }

        DB::table('adjustment_types')->insert($types);
    }
}
