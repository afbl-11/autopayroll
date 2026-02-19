<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaxVersion extends Model
{
    protected $fillable = ['name', 'effective_date', 'status'];

    // Define relationship: One Version has Many Brackets
    public function brackets(): HasMany
    {
        return $this->hasMany(TaxBracket::class)->orderBy('min_income', 'asc');
    }

    // Helper to find the current active tax law
    public function scopeActive($query)
    {
        return $query->where('status', 'active')->latest('effective_date');
    }
}
