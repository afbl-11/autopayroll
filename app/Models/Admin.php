<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasFactory;
    protected $primaryKey = 'admin_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'admin_id',
        'first_name',
        'last_name',
        'email',
        'role',
        'password',
        'tin',
        'company_name',
        'country',
        'region',
        'province',
        'zip',
        'city',
        'barangay',
        'street',
        'house_number',
        'email_verified_at'
    ];

    protected $hidden = [
        'password',
//        'remember_token',
        'tin'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
