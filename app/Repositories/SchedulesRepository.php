<?php

namespace App\Repositories;

use App\Models\Schedule;

class SchedulesRepository
{
    public function create(array $data)
    {
        return Schedule::create($data);
    }

    public function update(array $data, $id)
    {
        $schedule = Schedule::find($id);
        if ($schedule) {
            $schedule->update($data);
            return $schedule;
        }
        return null;
    }

    public function delete($id)
    {
        return Schedule::destroy($id);
    }

    public function getById($id)
    {
        return Schedule::find($id);
    }

    public function getAll()
    {
        return Schedule::all();
    }

    public function getByCompany($companyId)
    {
        return Schedule::where('company_id', $companyId)->get();
    }

    public function getByShiftName($shiftName)
    {
        return Schedule::where('shift_name', 'like', "%{$shiftName}%")->get();
    }

    public function getByTimeRange($start, $end)
    {
        return Schedule::where('start_time', '>=', $start)
            ->where('end_time', '<=', $end)
            ->get();
    }
}
