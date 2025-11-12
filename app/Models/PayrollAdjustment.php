<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayrollAdjustment extends Model
{
    protected $table = 'payroll_adjustments';
    protected $primaryKey = 'payroll_adjustment_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'payroll_adjustment_id',
        'admin_id',
        'daily_payroll_id',
        'employee_id',
        'gross_salary',
        'net_salary',
        'deduction',//late deduct
        'overtime', //pay
        'night_differential',
        'holiday_pay',
        'payroll_date',

    ];

    protected $casts = [
        'gross_salary' => 'float',
        'net_salary' => 'float',
        'deduction' => 'float',//late deduct
        'overtime' => 'float', //pay
        'night_differential' => 'float',
        'holiday_pay' => 'float',
        'payroll_date' => 'date_format:Y-m-d',
    ];


}
