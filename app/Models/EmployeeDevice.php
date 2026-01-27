<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeDevice extends Model
{

    protected $table = 'employee_devices';
    public $incrementing = false;
    protected $keyType = 'string';
//    use HasFactory;

    protected $fillable = [
        'employee_id',
        'fcm_token',
        'platform',
    ];

    /**
     * Each device belongs to an employee
     */
    public function employee()
    {
        // employee_id (string PK in employees table)
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }
}
