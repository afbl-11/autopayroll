<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payslip extends Model
{
    protected $table = 'payslips';
    protected $primaryKey = 'payslips_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'payslips_id',
        'employee_id',
        'year',
        'month',
        'period',
        'period_start',
        'period_end',
        'pay_date',
        'net_pay',
        'status',
        'breakdown',
        'reference',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }

    public function getFormattedNetPayAttribute(): string
    {
        return '₱ ' . number_format($this->net_pay, 2);
    }

    // Scope: filter by date range
    public function scopePeriodBetween($query, $from, $to)
    {
        if ($from) {
            $query->whereDate('period_start', '>=', $from);
        }
        if ($to) {
            $query->whereDate('period_end', '<=', $to);
        }
        return $query;
    }
}
