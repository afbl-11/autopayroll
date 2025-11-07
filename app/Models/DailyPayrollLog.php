<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyPayrollLog extends Model
{
    use HasFactory;

    protected $table = 'daily_payroll_logs';
    protected $primaryKey = 'daily_payroll_id';
    public $incrementing = false;
    protected $keyType = 'string';


    protected $fillable = [
        'daily_payroll_id',
        'employee_id',
        'payroll_period_id',
        'log_id',
        'gross_salary',
        'net_salary',
        'deduction',
        'overtime',
        'night_differential',
        'holiday_pay',
        'cash_bond',
        'payroll_date',
        'status'
    ];

    // Relationships

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }

    public function payrollPeriod()
    {
        return $this->belongsTo(PayrollPeriod::class, 'payroll_period_id', 'payroll_period_id');
    }

    public function attendanceLog()
    {
        return $this->belongsTo(AttendanceLog::class, 'log_id', 'log_id');
    }
}
