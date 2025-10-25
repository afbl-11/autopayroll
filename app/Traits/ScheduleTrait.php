<?php

namespace App\Traits;

use App\Models\EmployeeSchedule;

trait ScheduleTrait
{
    private function isScheduledToday($id)
    {
        $todayDay = now()->format('D');

        $schedule = EmployeeSchedule::where('employee_id', $id)
            ->latest('start_date')
            ->with('shift')
            ->first();

        if (!$schedule || !$schedule->shift) {
            return false;
        }

        $workingDays = is_array($schedule->working_days)
            ? $schedule->working_days
            : json_decode($schedule->working_days, true);

        return [
            'isWorkingDay' => in_array($todayDay, $workingDays),
            'schedule' => $schedule,
        ];
    }
}
