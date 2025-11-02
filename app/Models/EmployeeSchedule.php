<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSchedule extends Model
{
    use HasFactory;

    protected $table = 'employee_schedules';
    protected $primaryKey = 'employee_schedules_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'employee_schedules_id',
        'employee_id',
        'shift_id',
        'working_days',
        'start_time',
        'end_time',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'working_days' => 'array',
        'start' => 'datetime:H:i',
        'end' => 'datetime:H:i',
    ];

    /**
     * Relationships
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }

}
