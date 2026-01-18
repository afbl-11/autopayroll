<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartTimeAssignment extends Model
{
    protected $fillable = [
        'employee_id',
        'company_id',
        'assigned_days',
        'week_start',
        'week_end',
    ];

    protected $casts = [
        'assigned_days' => 'array',
        'week_start' => 'date',
        'week_end' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }
}
