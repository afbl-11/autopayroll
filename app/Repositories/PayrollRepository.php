<?php

namespace App\Repositories;

use App\Models\Payroll;

class PayrollRepository
{
    public function create(array $data)
    {
        return Payroll::create($data);
    }

    public function update(array $data, $id)
    {
        $payroll = Payroll::find($id);
        if ($payroll) {
            $payroll->update($data);
            return $payroll;
        }
        return null;
    }

    public function delete($id)
    {
        return Payroll::destroy($id);
    }

    public function getById($id)
    {
        return Payroll::find($id);
    }

    public function getAll()
    {
        return Payroll::all();
    }

    public function getByEmployee($employeeId)
    {
        return Payroll::where('employee_id', $employeeId)->get();
    }

    public function getByDateRange($start, $end)
    {
        return Payroll::whereBetween('pay_date', [$start, $end])->get();
    }

    public function getByStatus($status)
    {
        return Payroll::where('status', $status)->get();
    }

    public function getLatestPayroll($employeeId)
    {
        return Payroll::where('employee_id', $employeeId)
            ->orderBy('pay_date', 'desc')
            ->first();
    }

    public function getTotalNetPayByEmployee($employeeId)
    {
        return Payroll::where('employee_id', $employeeId)->sum('net_pay');
    }

    public function getTotalDeductionsByEmployee($employeeId)
    {
        return Payroll::where('employee_id', $employeeId)
                ->sum('pag_ibig_deductions')
            + Payroll::where('employee_id', $employeeId)->sum('sss_deductions')
            + Payroll::where('employee_id', $employeeId)->sum('late_deductions')
            + Payroll::where('employee_id', $employeeId)->sum('cash_bond');
    }
}
