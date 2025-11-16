<?php

namespace App\Models;

use App\Models\Scopes\AdminScope;
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
        'admin_id',
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
        'android_id',

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
    public function rates()
    {
        return $this->hasMany(EmployeeRate::class, 'employee_id', 'employee_id');
    }
    public function currentRate()
    {
        return $this->hasOne(EmployeeRate::class, 'employee_id', 'employee_id')
            ->where('effective_from', '<=', now())
            ->where(function($query) {
                $query->where('effective_to', '>=', now())
                    ->orWhereNull('effective_to');
            })
            ->latest('effective_from');
    }
    public function creditAdjustments()
    {
        return $this->hasMany(CreditAdjustment::class, 'employee_id', 'employee_id');
    }
    protected static function booted() {
        static::addGlobalScope(new AdminScope);

        static::creating(function ($model) {
            if($admin = auth('admin')->user()){
                $model->admin_id = $admin->admin_id;
            }
        });
    }

    public function leaves() {
        return $this->hasMany(LeaveRequest::class, 'employee_id', 'employee_id');
    }

    public function dailyPayrolls() {
        return $this->hasMany(DailyPayrollLog::class, 'employee_id', 'employee_id');
    }
}

