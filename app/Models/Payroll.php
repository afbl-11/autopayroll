<?php

namespace App\Models;

use App\Models\Scopes\AdminScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;
    protected $primaryKey = 'payroll_id';
    public $incrementing = true;
    protected $keyType = 'string';


    protected $fillable = [
        'payroll_id',
        'admin_id',
        'employee_id',
        'payroll_period_id',
        'rate',
        'gross_salary',
        'net_pay',
        'pag_ibig_deductions',
        'phil_health_deductions',
        'sss_deductions',
        'late_deductions',
        'cash_bond',
        'holiday',
        'night_differential',
        'overtime',
        'pay_date',
        'status' // auto filled
    ];

    protected $casts = [
        'rate' => 'decimal:2',
        'gross_salary' => 'decimal:2',
        'net_pay' => 'decimal:2',
        'pag_ibig_deductions' => 'decimal:2',
        'phil_health_deductions' => 'decimal:2',
        'late_deductions' => 'decimal:2',
        'cash_bond' => 'decimal:2',
        'holiday' => 'decimal:2',
        'night_differential' => 'decimal:2',
        'overtime' => 'decimal:2',
        'pay_date' => 'date'
    ];

    public function employee() {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }
    public function payrollPeriod() {
        return $this->belongsTo(PayrollPeriod::class, 'payroll_period_id', 'payroll_period_id');
    }

    protected static function booted() {
        static::addGlobalScope(new AdminScope);

        static::creating(function ($model) {
            if($admin = auth('admin')->user()){
                $model->admin_id = $admin->admin_id;
            }
        });
    }
}
