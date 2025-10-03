<?php

namespace App\Repositories;

use App\Models\CreditAdjustment;

class CreditAdjustmentRepository
{
    public function create(array $data)
    {
        return CreditAdjustment::create($data);
    }

    public function update(array $data, $id)
    {
        $adjustment = CreditAdjustment::find($id);
        if ($adjustment) {
            $adjustment->update($data);
            return $adjustment;
        }
        return null;
    }

    public function delete($id)
    {
        return CreditAdjustment::destroy($id);
    }

    public function getById($id)
    {
        return CreditAdjustment::find($id);
    }

    public function getAll()
    {
        return CreditAdjustment::all();
    }

    public function getByEmployee($employeeId)
    {
        return CreditAdjustment::where('employee_id', $employeeId)->get();
    }

    public function getByApprover($approverId)
    {
        return CreditAdjustment::where('approver_id', $approverId)->get();
    }

    public function getByStatus($status)
    {
        return CreditAdjustment::where('status', $status)->get();
    }

    public function getByDate($date)
    {
        return CreditAdjustment::whereDate('affected_date', $date)->get();
    }

    public function getByType($type)
    {
        return CreditAdjustment::where('adjustment_type', $type)->get();
    }
}
