<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollPeriod extends Model
{
    use HasFactory;

    protected $primaryKey = 'payroll_period_id';

    public $incrementing = false;

    protected $keyType = 'string';


    protected $fillable = [
        'start_date',
        'end_date',
        'is_closed',
    ];
}
