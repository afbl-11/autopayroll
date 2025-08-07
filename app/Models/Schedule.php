<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $primaryKey = 'schedule_id';
    public $incrementing = false;
    protected $keyType = 'integer';

    protected $fillable = [
        'schedule_id',
        'company_id',
        'shift_name',
        'start_time',
        'end_time'
    ];

    public function company() {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }
}
