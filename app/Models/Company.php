<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $primaryKey ='company_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'company_id',
        'company_name',
        'first_name',
        'last_name',
        'company_logo',
        'industry',
        'tin_number',
        'latitude',
        'longitude',
        'radius'
    ];
    public function employees()
    {
        return $this->hasMany(Employee::class, 'company_id', 'company_id');
    }
    public function employeeSchedule()
    {
        return $this->hasMany(EmployeeSchedule::class, 'company_id', 'company_id');
    }
}
