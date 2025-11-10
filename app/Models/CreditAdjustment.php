<?php

namespace App\Models;

use App\Models\Scopes\AdminScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditAdjustment extends Model
{
    use HasFactory;
    protected $primaryKey = 'adjustment_id';
    public $incrementing = true;
    protected $keyType = 'string';

    protected $fillable = [
        'adjustment_id',
        'admin_id',
        'employee_id',
        'approver_id',
        'adjustment_type',
        'subtype',
        'start_date',
        'end_date',
        'attachment_path',
        'reason',
        'status',
        'affected_date'
    ];

    protected $casts = [
        'affected_date' => 'date'

    ];

    public function employee() {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }

    public function approver() {
        return $this->belongsTo(Admin::class, 'approver_id', 'admin_id');
    }

    protected static function booted() {
        static::addGlobalScope(new AdminScope);

        static::creating(function ($model) {
            if($admin = auth('admin')->user()){
                $model->admin_id = $admin->admin_id;
            }
        });
    }
}
