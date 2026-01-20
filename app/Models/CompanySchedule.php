<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySchedule extends Model
{
    protected $fillable = [
        'company_id',
        'working_days',
        'start_time',
        'end_time',
        'last_updated_at',
    ];

    protected $casts = [
        'working_days' => 'array',
        'last_updated_at' => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }
}
