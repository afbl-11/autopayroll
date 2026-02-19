<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SssBrackets extends Model
{
    protected $table = 'sss_brackets';

    protected $fillable = [
        'version_id',
        'min_salary',
        'max_salary',
        'msc_amount',
        'ec_er_share'
    ];

    protected $casts = [
        'min_salary' => 'decimal:2',
        'max_salary' => 'decimal:2',
        'msc_amount' => 'decimal:2',
        'ec_er_share' => 'decimal:2',
    ];

    /**
     * Relationship: Bracket belongs back to a Version
     */
    public function version(): BelongsTo
    {
        return $this->belongsTo(SssVersionsTable::class);
    }
}
