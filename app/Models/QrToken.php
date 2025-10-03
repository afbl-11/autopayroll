<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrToken extends Model
{
    use HasFactory;
    protected $primaryKey = 'token_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'token_id',
        'company_id',
        'is-active'
    ];

    public function companies() {
        return $this->beforeQuery(Company::class, 'company_id', 'company_id');
    }
}
