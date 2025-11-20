<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpCodes extends Model
{
    protected $table = 'otp_codes';
    protected $primaryKey = 'otp_code_id';
    protected $keyType = 'string';

    protected $fillable = [
        'otp_code_id',
        'employee_id',
        'otp_code',
        'expires_at',
        'verified',
    ];

    public function employee() {
        return $this->belongsTo('App\Models\Employee', 'employee_id', 'employee_id');
    }
}
