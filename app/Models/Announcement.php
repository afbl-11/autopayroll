<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $table = 'announcements';
    public $incrementing = false;
    protected $primaryKey = 'announcement_id';

    protected $fillable = [
        'announcement_id',
        'admin_id',
        'title',
        'message',
        'start_date',
        'end_date',
        'created_by',
        'is_active',
        'attachments',
    ];

    public function admin(){
        return $this->belongsTo(Admin::class, 'admin_id', 'admin_id');
    }
}
