<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $primaryKey ='company_id';
    public $incrementing = false;
    protected $keyType = 'integer';

    protected $fillable = [
        'company_id',
        'company_name',
        'company_address',
        'industry',
        'tin_number'
    ];
}
