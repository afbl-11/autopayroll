<?php

namespace App\Repositories;

use App\Models\LeaveRequest;

class LeaveRequestRepository
{
    public function create(array $data)
    {
        return LeaveRequest::create($data);
    }

    public function update(array $data, $id)
    {
        $leave = LeaveRequest::find($id);
        if ($leave) {
            $leave->update($data);
            return $leave;
        }
        return null;
    }

    public function delete($id)
    {
        return LeaveRequest::destroy($id);
    }

    public function getById($id)
    {
        return LeaveRequest::find($id);
    }

    public function getAll()
    {
        return LeaveRequest::all();
    }

    public function getByEmployee($employeeId)
    {
        return LeaveRequest::where('employee_id', $employeeId)->get();
    }

    public function getByApprover($approverId)
    {
        return LeaveRequest::where('approver_id', $approverId)->get();
    }

    public function getByStatus($status)
    {
        return LeaveRequest::where('status', $status)->get();
    }

    public function getByLeaveType($type)
    {
        return LeaveRequest::where('leave_type', $type)->get();
    }

    public function getByDateRange($start, $end)
    {
        return LeaveRequest::whereBetween('start_date', [$start, $end])->get();
    }

    public function getPendingRequests()
    {
        return LeaveRequest::where('status', 'Pending')->get();
    }
}
