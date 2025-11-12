<?php

namespace App\Models;

use App\Models\Scopes\AdminScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceLogs extends Model
{
    use HasFactory;
    protected $primaryKey = 'log_id';
    public $incrementing = true;
    protected $keyType = 'string';


    protected $fillable = [
        'log_id',
        'admin_id',
        'employee_id',
        'company_id',
        'log_date',
        'is_adjusted',
        'clock_in_time',
        'clock_out_time',
        'clock_in_latitude',
        'clock_in_longitude',
        'clock_out_latitude',
        'clock_out_longitude',
    ];

    protected $casts = [
        'log_date' => 'date:Y-m-d',
        'clock_in_time' => 'date:H:i',
        'clock_out_time' => 'date:H:i',
        'clock_in_latitude' => 'decimal:8',
        'clock_in_longitude' => 'decimal:8',
        'clock_out_latitude' => 'decimal:8',
        'clock_out_longitude' => 'decimal:8',
    ];

    public function employee() {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }

    public function company() {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
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
