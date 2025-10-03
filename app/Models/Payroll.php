<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;
    protected $primaryKey = 'payroll_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'employee_id',
        'payroll_period_id',
        'rate',
        'gross_salary',
        'net_pay',
        'pag_ibig_deductions',
        'sss_deductions',
        'late_deductions',
        'cash_bond',
        'holiday',
        'night_differential',
        'overtime',
        'pay_date',
        'status'
    ];

    protected $casts = [
        'rate' => 'decimal:8',
        'gross_salary' => 'decimal:8',
        'net_pay' => 'decimal:8',
        'pag_ibig_deductions' => 'decimal:8',
        'phil_health_deductions' => 'decimal:8',
        'late_deductions' => 'decimal:8',
        'cash_bond' => 'decimal:8',
        'holiday' => 'decimal:8',
        'night_differential' => 'decimal:8',
        'overtime' => 'decimal:8',
        'pay_date' => 'date'
    ];

    public function employee() {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }
    public function payrollPeriod() {
        return $this->belongsTo(PayrollPeriod::class, 'payroll_period_id', 'payroll_period_id');
    }
}
