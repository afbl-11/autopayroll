<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $primaryKey = 'employee_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'employee_id',
        'company_id',
        'schedule_id',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'username',
        'password',
        'job_position',
        'employment_type',
        'contract_start',
        'contract_end',
        'birthdate',
        'gender',
        'marital_status',
        'blood_type',
        'religion',
        'country',
        'region',
        'province',
        'zip',
        'city',
        'barangay',
        'street',
        'house_number',
        'bank_account_number',
        'sss_number',
        'phil_health_number',
        'pag_ibig_number',
        'tin_number',
        'phone_number',
    ];
    protected $casts = [
        'contract_start' => 'date',
        'contract_end' => 'date',
        'birthdate' => 'date',
    ];

    public function company() {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }

    public function schedule() {
        return $this->belongsTo(Schedule::class, 'schedule_id', 'schedule_id');
    }

    public function attendanceLogs()
    {
        return $this->hasMany(AttendanceLogs::class, 'employee_id', 'employee_id');
    }


}
