<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\LeaveCredits;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LeaveCreditService
{
    public function createCreditRecord($employeeId, $adminId) :? LeaveCredits {

        if(!Auth::guard('admin')->check()){
            throw new \Exception('Unauthorized: Only admins can create leave credits.');
        }

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
