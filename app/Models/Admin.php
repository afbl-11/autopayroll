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
        'middle_name',
        'last_name',
        'suffix',
        'email',
        'password',
        'company_name',
        'country',
        'region_name',
        'province_name',
        'zip',
        'city_name',
        'barangay_name',
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

    public function announcement() {
        return $this->hasMany(Announcement::class, 'admin_id', 'admin_id');
    }

    public function employee() {
        return $this->hasMany(Employee::class, 'admin_id', 'admin_id');
    }
}
