<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\LeaveCredits;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LeaveCreditService
{
    public function createCreditRecord($employeeId) :? LeaveCredits {

        $adminId = Auth::guard('admin')->id();

        $credit = 15.0;
        $used_days = 0;

        return LeaveCredits::create([
            'leave_credit_id' => Str::uuid(),
            'employee_id' => $employeeId,
            'admin_id' => $adminId,
            'credit_days' => $credit,
            'used_days' => $used_days,
            'approved_date' => Carbon::now(),
        ]);
    }
}
