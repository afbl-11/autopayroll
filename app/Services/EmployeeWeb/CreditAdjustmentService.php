<?php

namespace App\Services\EmployeeWeb;

use App\Models\CreditAdjustment;

class CreditAdjustmentService
{
    public function getPendingRequests($employeeId) : int {

        $log = CreditAdjustment::where('employee_id', $employeeId)
            ->where('status', 'pending')
            ->count();

        if (!$log) {
            return 0;
        }

        return $log;
    }

    public function getApprovedRequests($employeeId) : int {
        $log = CreditAdjustment::where('employee_id', $employeeId)
            ->where('status', 'approved')
            ->count();

        if (!$log) {
            return 0;
        }

        return $log;
    }

    public function getLatestAdjustment($employeeId) {
        $log = CreditAdjustment::where('employee_id', $employeeId)
            ->latest()
            ->first();

        if (!$log) {
            return 0;
        }
        return $log->adjustment_type;
    }

    public function getAdjustmentHistory($employeeId)
    {
        $logs = CreditAdjustment::where('employee_id', $employeeId)
            ->latest()
            ->get();

        return $logs;
    }
}
