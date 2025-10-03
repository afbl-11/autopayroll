<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $primaryKey = 'schedule_id';
    public $incrementing = false;
    protected $keyType = 'string';

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
