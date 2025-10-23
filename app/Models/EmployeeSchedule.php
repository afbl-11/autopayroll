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
        'employee_id',
        'shift_id',
        'working_days',
        'custom_start',
        'custom_end',
        'custom_break_start',
        'custom_break_end',
        'custom_lunch_start',
        'custom_lunch_end',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'working_days' => 'array',
        'custom_start' => 'datetime:H:i',
        'custom_end' => 'datetime:H:i',
        'custom_break_start' => 'datetime:H:i',
        'custom_break_end' => 'datetime:H:i',
        'custom_lunch_start' => 'datetime:H:i',
        'custom_lunch_end' => 'datetime:H:i',
    ];

    /**
     * Relationships
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id', 'shift_id');
    }
}
