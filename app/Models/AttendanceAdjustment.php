<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceAdjustment extends Model
{
    protected $table = 'attendance_adjustments';
    protected $primaryKey = 'attendance_adjustment_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'attendance_adjustment_id',
        'log_id',
        'employee_id',
        'admin_id',
        'clock_in_time',
        'clock_out_time',
        'status',
    ];
}
