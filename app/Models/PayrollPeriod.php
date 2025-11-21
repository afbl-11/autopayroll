<?php

namespace App\Models;

use App\Models\Scopes\AdminScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollPeriod extends Model
{
    use HasFactory;

    protected $primaryKey = 'payroll_period_id';

    public $incrementing = true;

    protected $keyType = 'string';



    protected $fillable = [
        'payroll_period_id',
        'admin_id',
        'start_date',
        'end_date',
        'is_closed',
    ];

}
