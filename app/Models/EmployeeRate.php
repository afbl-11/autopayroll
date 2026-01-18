<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EmployeeRate extends Model
{
    protected $primaryKey = 'employee_rate_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'employee_id',
        'admin_id',
        'rate',
        'effective_from',
        'effective_to'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }


    public function employee() {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }

}

