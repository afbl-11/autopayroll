<?php

namespace App\Models;

use App\Models\Scopes\AdminScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;
    protected $table = 'leave_request';
    protected $primaryKey = 'leave_request_id';
    public $incrementing = true;
    protected $keyType = 'string';


    protected $fillable = [
        'leave_request_id',
        'admin_id',
        'employee_id',
        'approver_id',
        'leave_type',
        'start_date',
        'end_date',
        'reason',
        'status',
        'supporting_doc',
        'submission_date'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'submission_date' => 'date'
    ];

    public function employee() {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }

    public function approver() {
        return $this->belongsTo(Admin::class, "approver_id", 'admin_id');
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
