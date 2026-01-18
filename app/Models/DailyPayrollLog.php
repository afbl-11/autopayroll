<?php

namespace App\Models;

use App\Models\Scopes\AdminScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DailyPayrollLog extends Model
{
    use HasFactory;

    protected $table = 'daily_payroll_logs';
    protected $primaryKey = 'daily_payroll_id';
    public $incrementing = false;
    protected $keyType = 'string';


    protected $fillable = [
        'daily_payroll_id',
        'admin_id',
        'employee_id',
        'payroll_period_id',
        'gross_salary',
        'net_salary',
        'deduction',
        'overtime',
        'night_differential',
        'holiday_pay',
        'payroll_date',
        'late_time',
        'work_hours',
        'clock_in_time',
        'clock_out_time',
        'is_adjusted',
    ];

    protected static function booted() {
        static::addGlobalScope(new AdminScope);

        static::creating(function ($model) {
            if (empty($model->daily_payroll_id)) {
                $model->daily_payroll_id = (string) Str::uuid();
            }
            if($admin = auth('admin')->user()){
                $model->admin_id = $admin->admin_id;
            }
        });
    }

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
        return $this->belongsTo(AttendanceLogs::class, 'log_id', 'log_id');
    }
}
