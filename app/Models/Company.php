<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $primaryKey ='company_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'company_id',
        'company_name',
        'company_logo',
        'country',
        'region',
        'province',
        'city',
        'barangay',
        'street',
        'house_number',
        'zip',
        'industry',
        'tin_number'
    ];
}
