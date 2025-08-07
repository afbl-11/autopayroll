<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceLogs extends Model
{
    protected $primaryKey = 'log_id';
    public $incrementing = false;
    protected $keyType = 'integer';

    protected $fillable = [
        'log_id',
        'employee_id',
        'clock_in_time',
        'clock_out_time',
        'status',
        'clock_in_latitude',
        'clock_out_latitude'
    ];

    protected $cast = [
        'clock_in_time' => 'datetime',
        'clock_out_time' => 'datetime',
        'clock_in_latitude' => 'decimal:8',
        'clock_out_longitude' => 'decimal:8'
    ];

    public function employee() {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }
}
