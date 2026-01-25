<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveCreditType extends Model
{
//    use HasFactory;

    protected $primaryKey = 'leave_credit_type_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['leave_credit_type_id', 'name'];


}
