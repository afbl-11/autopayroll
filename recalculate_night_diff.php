<?php

/**
 * Temporary script to recalculate night differential for existing payroll records
 * Run this once to fix the existing records, then delete this file
 * 
 * Usage: php recalculate_night_diff.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\AttendanceLogs;
use App\Services\Payroll\AttendancePayrollService;

echo "Starting night differential recalculation...\n\n";

// Employee ID from the screenshot
$employeeId = '20260115';

// Dates that need recalculation
$dates = [
    '2026-01-04',
    '2026-01-06',
    '2026-01-17',
    '2026-02-12'
];

$payrollService = new AttendancePayrollService();

foreach ($dates as $date) {
    echo "Processing $employeeId on $date...\n";
    
    // Get attendance record
    $attendance = AttendanceLogs::withoutGlobalScope(\App\Models\Scopes\AdminScope::class)
        ->where('employee_id', $employeeId)
        ->where('log_date', $date)
        ->first();
    
    if (!$attendance) {
        echo "  ❌ No attendance found for $date\n";
        continue;
    }
    
    echo "  Found attendance: {$attendance->clock_in_time} to {$attendance->clock_out_time}\n";
    
    try {
        // Recalculate payroll
        $result = $payrollService->syncAttendanceToPayroll(
            $employeeId,
            $date,
            $attendance->company_id
        );
        
        if ($result) {
            echo "  ✅ Payroll recalculated - Night Diff: ₱" . number_format($result->night_differential, 2) . "\n";
        } else {
            echo "  ❌ Failed to recalculate\n";
        }
    } catch (\Exception $e) {
        echo "  ❌ Error: " . $e->getMessage() . "\n";
    }
    
    echo "\n";
}

echo "Recalculation complete!\n";
echo "You can now delete this file (recalculate_night_diff.php)\n";
