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
        'phone_number',

        // Residential Address
        'res_country',
        'res_country_code',
        'res_region',
        'res_region_code',
        'res_province',
        'res_province_code',
        'res_zip',
        'res_zip_code',
        'res_city',
        'res_city_code',
        'res_barangay',
        'res_barangay_code',
        'res_street',
        'res_street_code',
        'res_house_number',
        'res_house_number_code',

        // ID Address
        'id_country',
        'id_country_code',
        'id_region',
        'id_region_code',
        'id_province',
        'id_province_code',
        'id_zip',
        'id_zip_code',
        'id_city',
        'id_city_code',
        'id_barangay',
        'id_barangay_code',
        'id_street',
        'id_street_code',
        'id_house_number',
        'id_house_number_code',

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

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id', 'schedule_id');
    }

    public function attendanceLogs()
    {
        return $this->hasMany(AttendanceLogs::class, 'employee_id', 'employee_id');
    }
}
