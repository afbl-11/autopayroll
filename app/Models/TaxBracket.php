<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaxBracket extends Model
{
    protected $fillable = [
        'tax_version_id', 'min_income', 'max_income',
        'base_tax', 'excess_over', 'percentage'
    ];

    protected $casts = [
        'min_income' => 'decimal:2',
        'max_income' => 'decimal:2',
        'base_tax'   => 'decimal:2',
        'excess_over' => 'decimal:2',
        'percentage' => 'decimal:4',
    ];

    public function version(): BelongsTo
    {
        return $this->belongsTo(TaxVersion::class);
    }
}
