<?php

namespace App\Services\EmployeeWeb;

use App\Models\LeaveCredits;
use App\Models\LeaveRequest;
use Carbon\Carbon;

class LeaveDashboardService
{
    public function getLeaveBalances($employeeId): array
    {
        $logs = LeaveCredits::with('leaveCreditType')
            ->where('employee_id', $employeeId)
            ->get();

        $balances = [
            'vacation' => 0,
            'sick' => 0,
            'maternity' => 0,
            'paternity' => 0,
            'bereavement' => 0,
        ];

        foreach ($logs as $log) {
            $typeName = strtolower($log->leaveCreditType->name ?? '');
            if ($typeName && array_key_exists($typeName, $balances)) {
                $balances[$typeName] = $log->credit_days - $log->used_days;
            }
        }

        return $balances;
    }

    public function getLeaveRequests($employeeId)
    {
        $requests = LeaveRequest::where('employee_id', $employeeId)
            ->latest()
            ->get();

        $mapDates = function ($leave) {
            return [
                'start_date' => Carbon::parse($leave->start_date)->toDateString(), // YYYY-MM-DD
                'end_date'   => Carbon::parse($leave->end_date)->toDateString(),
            ];
        };

        return [
            'requests' => $requests,
            'approved' => $requests->where('status', 'approved')->map($mapDates)->values(),
            'pending'  => $requests->where('status', 'pending')->map($mapDates)->values(),
        ];
    }

    public function getFilteredLeaveRequests(string $employeeId, array $filters = [])
    {
        $query = LeaveRequest::where('employee_id', $employeeId);

        if (!empty($filters['from'])) {
            $query->whereDate('start_date', '>=', $filters['from']);
        }

        if (!empty($filters['to'])) {
            $query->whereDate('end_date', '<=', $filters['to']);
        }

        if (!empty($filters['leave_type'])) {
            $query->where('leave_type', $filters['leave_type']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        $requests = $query->latest()->get();

        $approved = $requests->where('status', 'approved')
            ->map(fn ($leave) => [
                'start_date' => Carbon::parse($leave->start_date),
                'end_date'   => Carbon::parse($leave->end_date),
            ])
            ->values();

        $pending = $requests->where('status', 'pending')
            ->map(fn ($leave) => [
                'start_date' => Carbon::parse($leave->start_date),
                'end_date'   => Carbon::parse($leave->end_date),
            ])
            ->values();

        return compact('requests', 'approved', 'pending');
    }


}
