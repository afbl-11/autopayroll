<?php

namespace App\Models;

use App\Models\Scopes\AdminScope;
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
        'admin_id',
        'company_name',
        'first_name',
        'last_name',
        'company_logo',
        'industry',
        'tin_number',
        'address',
        'latitude',
        'longitude',
        'radius',
        'qr_token'
    ];
    public function employees()
    {
        return $this->hasMany(Employee::class, 'company_id', 'company_id');
    }
    public function employeeSchedule()
    {
        return $this->hasMany(EmployeeSchedule::class, 'company_id', 'company_id');
    }

    public function attendanceLogs() {
        $this->hasMany(AttendanceLogs::class, 'company_id', 'company_id');
    }
    protected static function booted() {
        static::addGlobalScope(new AdminScope);

        static::creating(function ($model) {
            if($admin = auth('admin')->user()){
                $model->admin_id = $admin->admin_id;
            }
        });
    }
}
