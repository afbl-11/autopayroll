<?php

namespace App\Repositories;

use App\Models\AttendanceLogs;

class AttendanceRepository
{
    public function create(array $data)
    {
        return AttendanceLogs::create($data);
    }

    public function update(array $data, $id)
    {
        $log = AttendanceLogs::find($id);
        if ($log) {
            $log->update($data);
            return $log;
        }
        return null;
    }

    public function delete($id)
    {
        return AttendanceLogs::destroy($id);
    }

    public function getById($id)
    {
        return AttendanceLogs::find($id);
    }

    public function getByEmployee($employeeId)
    {
        return AttendanceLogs::where('employee_id', $employeeId)->get();
    }

    public function getByDate($date)
    {
        return AttendanceLogs::whereDate('clock_in_time', $date)
            ->orWhereDate('clock_out_time', $date)
            ->get();
    }

    public function getClockIn($date) {
        return AttendanceLogs::WhereDate('clock_in_time', $date)->get();
    }
    public function getClockOut($date) {
        return AttendanceLogs::where('clock_out_time', $date)->get();
    }

    public function getAll()
    {
        return AttendanceLogs::all();
    }

    public function getByStatus($status)
    {
        return AttendanceLogs::where('status', $status)->get();
    }


}
