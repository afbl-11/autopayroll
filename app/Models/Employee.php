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
        'api_token',

        // Residential Address
        'country',
        'region',
        'province',
        'zip',
        'city',
        'barangay',
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

    protected $casts = [
        'contract_start' => 'date',
        'contract_end' => 'date',
        'birthdate' => 'date',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }

    public function shift()
    {
        return $this->hasMany(Shift::class, 'schedule_id', 'schedule_id');
    }

    public function attendanceLogs()
    {
        return $this->hasMany(AttendanceLogs::class, 'employee_id', 'employee_id');
    }
}
