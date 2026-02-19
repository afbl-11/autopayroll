<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SssVersionsTable extends Model
{
    // Make sure this matches your migration!
    // If your migration said Schema::create('sss_versions', ...), change this to 'sss_versions'
    protected $table = 'sss_versions_tables';

    protected $fillable = [
        'version_name',
        'effective_date',
        'ee_rate',
        'er_rate',
        'status'
    ];

    protected $casts = [
        'effective_date' => 'date',
        'ee_rate' => 'decimal:4',
        'er_rate' => 'decimal:4',
    ];

    public function brackets(): HasMany
    {
        return $this->hasMany(SssBrackets::class, 'version_id');
    }

    public function scopeActiveAt($query, $date)
    {
        return $query->where('status', 'active')
            ->where('effective_date', '<=', $date)
            ->orderBy('effective_date', 'desc');
    }
}
