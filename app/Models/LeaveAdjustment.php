<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveAdjustment extends Model
{
    protected $table = 'leave_adjustments';
    protected $primaryKey = 'leave_adjustment_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'leave_adjustment_id',
        'employee_id',
        'admin_id',
        'leave_request_id',
        'leave_type',
        'start_date',
        'end_date',
        'status',
        'supporting_doc',
    ];
}
