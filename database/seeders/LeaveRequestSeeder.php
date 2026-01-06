<?php

namespace Database\Seeders;

use App\Models\LeaveRequest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LeaveRequestSeeder extends Seeder
{
    public function run(): void
    {
        $mockLeaveRequests = [
            [
                'leave_request_id' => Str::uuid(),
                'admin_id'         => '20267149',
                'employee_id'      => '20260653',
                'approver_id'      => '20267149',
                'leave_type'       => 'sick',
                'is_adjusted'      => false,
                'start_date'       => '2025-01-05',
                'end_date'         => '2025-01-06',
                'reason'           => 'Fever and flu',
                'status'           => 'approved',
                'supporting_doc'   => null,
                'submission_date'  => '2025-01-04',
            ],
            [
                'leave_request_id' => Str::uuid(),
                'admin_id'         => '20267149',
                'employee_id'      => '20260653',
                'approver_id'      => '20267149',
                'leave_type'       => 'vacation',
                'is_adjusted'      => false,
                'start_date'       => '2025-01-15',
                'end_date'         => '2025-01-18',
                'reason'           => 'Family vacation',
                'status'           => 'pending',
                'supporting_doc'   => null,
                'submission_date'  => '2025-01-10',
            ],
            [
                'leave_request_id' => Str::uuid(),
                'admin_id'         => '20267149',
                'employee_id'      => '20260653',
                'approver_id'      => '20267149',
                'leave_type'       => 'emergency',
                'is_adjusted'      => true,
                'start_date'       => '2025-01-20',
                'end_date'         => '2025-01-20',
                'reason'           => 'Family emergency',
                'status'           => 'approved',
                'supporting_doc'   => 'docs/emergency-proof.jpg',
                'submission_date'  => '2025-01-20',
            ],
            [
                'leave_request_id' => Str::uuid(),
                'admin_id'         => '20267149',
                'employee_id'      => '20260815',
                'approver_id'      => '20267149',
                'leave_type'       => 'bereavement',
                'is_adjusted'      => false,
                'start_date'       => '2025-02-01',
                'end_date'         => '2025-02-03',
                'reason'           => 'Death of a relative',
                'status'           => 'approved',
                'supporting_doc'   => 'docs/death-certificate.pdf',
                'submission_date'  => '2025-01-31',
            ],
            [
                'leave_request_id' => Str::uuid(),
                'admin_id'         => '20267149',
                'employee_id'      => '20260815',
                'approver_id'      => '20267149',
                'leave_type'       => 'sick',
                'is_adjusted'      => false,
                'start_date'       => '2025-02-10',
                'end_date'         => '2025-02-11',
                'reason'           => 'Migraine',
                'status'           => 'rejected',
                'supporting_doc'   => null,
                'submission_date'  => '2025-02-09',
            ],
        ];

        foreach ($mockLeaveRequests as $data) {
            LeaveRequest::create($data);
        }
        //LeaveRequest::factory()->count(10)->create();
    }
}
