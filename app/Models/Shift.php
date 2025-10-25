<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $primaryKey = 'shift_id';
    public $incrementing = true;
    protected $keyType = 'string';

    protected $fillable = [
        'shift_id',
        'start_time',
        'end_time',
        'break_start',
        'break_end',
        'lunch_start',
        'lunch_end',
    ];

    public function employeeSchedules()
    {
        return $this->hasMany(EmployeeSchedule::class, 'shift_id', 'shift_id');
    }
}
