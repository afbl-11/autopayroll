<?php

namespace App\Services\Payroll;

use App\Models\PayrollPeriod;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PayrollPeriodService
{
    public function createPeriod($adminId)
    {
        // Check if an open period already exists
        $periodExists = PayrollPeriod::where('is_closed', false)
            ->where('admin_id', $adminId)
            ->exists();

        if (!$periodExists) {

            $today = Carbon::now();

            if ($today->day <= 15) {
                // 1st to 15th period
                $start_date = $today->copy()->startOfMonth();   // 1st
                $end_date = $today->copy()->startOfMonth()->addDays(14); // 15th
            } else {
                // 16th to end-of-month period
                $start_date = $today->copy()->startOfMonth()->addDays(15); // 16th
                $end_date = $today->copy()->endOfMonth(); // Last day
            }

            PayrollPeriod::create([
                'payroll_period_id' => Str::uuid(),
                'admin_id' => $adminId,
                'is_closed' => false,
                'start_date' => $start_date,
                'end_date' => $end_date,
            ]);
        }
    }
}
