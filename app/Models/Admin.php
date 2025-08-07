<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $primaryKey = 'admin_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'admin_id',
        'first_name',
        'last_name',
        'email',
        'password',
    ];
}
