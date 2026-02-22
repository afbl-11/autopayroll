<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PagIbigVersion extends Model
{

    protected $table = 'pagibig_versions';
    protected $fillable = [
        'name', 'effective_date', 'salary_cap',
        'employee_rate_below_threshold', 'employee_rate_above_threshold',
        'employer_rate', 'threshold_amount', 'status'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
