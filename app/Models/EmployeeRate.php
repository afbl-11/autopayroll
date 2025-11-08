<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeRate extends Model
{
    protected $primaryKey = 'employee_rate_id';
    public $incrementing = true;

    protected $fillable = [
        'employee_rate_id',
        'employee_id',
        'rate',
        'effective_from',
        'effective_to'
    ];


    public function employee() {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }

}

