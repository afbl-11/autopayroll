<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Checking attendance logs...\n";
$logs = \App\Models\AttendanceLogs::withoutGlobalScope(\App\Models\Scopes\AdminScope::class)
    ->where('employee_id', '20269098')
    ->orderBy('log_date', 'desc')
    ->limit(5)
    ->get();

echo "Found " . $logs->count() . " attendance records\n";
foreach($logs as $log) {
    echo "  Date: {$log->log_date}, Status: {$log->status}, Manual: {$log->is_manual}, Time In: {$log->time_in}, Clock In: {$log->clock_in_time}\n";
}

echo "\nChecking daily payroll logs...\n";
$payroll = \App\Models\DailyPayrollLog::withoutGlobalScope(\App\Models\Scopes\AdminScope::class)
    ->where('employee_id', '20269098')
    ->orderBy('payroll_date', 'desc')
    ->limit(5)
    ->get();

echo "Found " . $payroll->count() . " payroll records\n";
foreach($payroll as $p) {
    echo "  Date: {$p->payroll_date}, Gross: {$p->gross_salary}, Net: {$p->net_salary}, Hours: {$p->work_hours}\n";
}

echo "\nChecking payroll period...\n";
$period = \App\Models\PayrollPeriod::orderBy('created_at', 'desc')->first();
if($period) {
    echo "  Latest period: {$period->start_date} to {$period->end_date} (ID: {$period->payroll_period_id})\n";
    echo "  Is closed: " . ($period->is_closed ?? 'NULL') . "\n";
    
    // Check for active (not closed) period
    $activePeriod = \App\Models\PayrollPeriod::where('is_closed', false)->latest()->first();
    if($activePeriod) {
        echo "  Active period: {$activePeriod->start_date} to {$activePeriod->end_date}\n";
    } else {
        echo "  No active (not closed) period found!\n";
    }
    
    // Check if there's any payroll for this period
    $periodPayroll = \App\Models\DailyPayrollLog::withoutGlobalScope(\App\Models\Scopes\AdminScope::class)
        ->where('payroll_period_id', $period->payroll_period_id)
        ->count();
    echo "  Payroll records in this period: {$periodPayroll}\n";
} else {
    echo "  No payroll period found!\n";
}
