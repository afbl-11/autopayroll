<?php

namespace App\Services;

use App\Models\EmployeeSchedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ScheduleService
{

    public function __construct(
       protected GenerateId $generateId
    ){}
    public function createSchedule(array $data): EmployeeSchedule {
/*
 * checks where the employee has a current or existing schedule. then after that, we will  update
 * it and add an end_date so we can close that schedule before opening a new one
 * */
        DB::transaction(function () use ($data) {
            $oldSched = EmployeeSchedule::where('employee_id', $data['employee_id'])
                ->whereNull('end_date')
                ->latest('start_date')
                ->first();


            if ($oldSched) {
                $oldSched->update([
                    'end_date' => Carbon::parse($oldSched['start_date'])->subDay()->toDateString(),
                ]);
            }
        });
        /*
         * after closing the schedule, we will create a new one
         * */

        $data['employee_schedules_id'] = $this->generateId->generateId(EmployeeSchedule::class,'employee_schedules_id');
        $data['start_date'] = Carbon::now()->toDateString();

        return EmployeeSchedule::create($data);
    }
}
