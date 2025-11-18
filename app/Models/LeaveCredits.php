<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveCredits extends Model
{
    protected $table = 'leave_credits';
    protected $primaryKey = 'leave_credit_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'leave_credit_id',
        'employee_id',
        'admin_id',
        'used_days',
        'credit_days',
        'is_used',
        'approved_date',
    ];

    protected $casts =[
        'used_days' => 'float',
        'credit_days' => 'float',
    ];

    public function employee() {
        return $this->belongsTo('App\Models\Employee', 'employee_id', 'employee_id');
    }
}
