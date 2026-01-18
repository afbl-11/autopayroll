    public function hirePartTimeEmployee(Request $request, $companyId)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,employee_id',
            'selected_days' => 'required|array|min:1',
        ]);

        $employeeId = $request->employee_id;
        $selectedDays = $request->selected_days;

        // Get current week start (Monday) and end (Sunday)
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();

        // Check if employee is already assigned for this week
        $existingAssignment = PartTimeAssignment::where('employee_id', $employeeId)
            ->where('week_start', $weekStart)
            ->first();

        if ($existingAssignment) {
            // Get already assigned days
            $assignedDays = $existingAssignment->assigned_days;
            
            // Check if any selected day is already assigned
            $conflictingDays = array_intersect($selectedDays, $assignedDays);
            
            if (!empty($conflictingDays)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Employee is already assigned for: ' . implode(', ', $conflictingDays)
                ], 400);
            }

            // Add new days to existing assignment
            $allAssignedDays = array_unique(array_merge($assignedDays, $selectedDays));
            $existingAssignment->update([
                'assigned_days' => $allAssignedDays
            ]);
        } else {
            // Create new assignment
            PartTimeAssignment::create([
                'employee_id' => $employeeId,
                'company_id' => $companyId,
                'assigned_days' => $selectedDays,
                'week_start' => $weekStart,
                'week_end' => $weekEnd,
            ]);
        }

        // Get employee's available days
        $employee = Employee::find($employeeId);
        $availableDays = is_string($employee->days_available) 
            ? json_decode($employee->days_available, true) 
            : $employee->days_available;

        // Check if all available days are now assigned
        $allAssignedDays = $existingAssignment 
            ? $existingAssignment->assigned_days 
            : $selectedDays;

        $remainingDays = array_diff($availableDays, $allAssignedDays);

        return response()->json([
            'success' => true,
            'message' => 'Part-time employee hired successfully for ' . implode(', ', $selectedDays),
            'remaining_days' => $remainingDays
        ]);
    }
