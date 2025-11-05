<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Employee extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasApiTokens;

    protected $primaryKey = 'employee_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'employee_id',
        'company_id',
        'employee_schedules_id',
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
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
        'phone_number',

        // Residential Address
        'country',
        'region_name',
        'province_name',
        'zip',
        'city_name',
        'barangay_name',
        'street',
        'house_number',

        // ID Address
        'id_country',
        'id_region',
        'id_province',
        'id_zip',
        'id_city',
        'id_barangay',
        'id_street',
        'id_house_number',

        // IDs and Accounts
        'bank_account_number',
        'sss_number',
        'phil_health_number',
        'pag_ibig_number',
        'tin_number',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'contract_start' => 'date',
        'contract_end' => 'date',
        'birthdate' => 'date',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }

    public function employeeSchedule()
    {
        return $this->hasMany(EmployeeSchedule::class, 'employee_id', 'employee_id');
    }

    public function attendanceLogs()
    {
        return $this->hasMany(AttendanceLogs::class, 'employee_id', 'employee_id');
    }
}

