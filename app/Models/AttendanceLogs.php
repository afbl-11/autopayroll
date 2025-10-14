<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceLogs extends Model
{
    use HasFactory;
    protected $primaryKey = 'log_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'log_id',
        'employee_id',
        'clock_in_date',
        'clock_in_time',
        'clock_out_time',
        'clock_in_latitude',
        'clock_out_latitude'
    ];

    protected $casts = [
        'clock_in_date' => 'date',
        'clock_in_time' => 'time',
        'clock_out_time' => 'time',
        'clock_in_latitude' => 'decimal:8',
        'clock_out_longitude' => 'decimal:8'
    ];

    public function employee() {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }

}
