<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Syncing all attendance records for employee 20269098...\n\n";

// Get the payroll service
$service = app(\App\Services\Payroll\AttendancePayrollService::class);

$employeeId = '20269098';

// Get all attendance records
$attendances = \App\Models\AttendanceLogs::withoutGlobalScope(\App\Models\Scopes\AdminScope::class)
    ->where('employee_id', $employeeId)
    ->orderBy('log_date', 'asc')
    ->get();

echo "Found {$attendances->count()} attendance records\n\n";

foreach($attendances as $attendance) {
    echo "Processing {$attendance->log_date} - Status: {$attendance->status}\n";
    
    try {
        $result = $service->syncAttendanceToPayroll(
            $employeeId,
            $attendance->log_date,
            $attendance->company_id
        );
        
        if ($result) {
            echo "  ✓ Synced - Gross: {$result->gross_salary}, Net: {$result->net_salary}\n";
        } else {
            echo "  ✗ Sync returned null\n";
        }
    } catch (\Exception $e) {
        echo "  ✗ ERROR: " . $e->getMessage() . "\n";
    }
}

echo "\nDone!\n";
