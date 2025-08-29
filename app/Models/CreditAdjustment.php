<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditAdjustment extends Model
{
    protected $primaryKey = 'adjustment_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'adjustment_id',
        'employee_id',
        'approver_id',
        'adjustment_type',
        'reason',
        'status',
        'affected_date'
    ];

    protected $casts = [
        'affected_date' => 'date'
    ];

    public function employee() {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }

    public function approver() {
        return $this->belongsTo(Admin::class, 'approver_id', 'admin_id');
    }
}
