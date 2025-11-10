<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdjustmentType extends Model
{
    protected $table = 'adjustment_types';
    protected $primaryKey = 'adjustment_type_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'adjustment_type_id',
        'main_type',
        'code',
        'label',
        'description',
        'is_active',
    ];
}
