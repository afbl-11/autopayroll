<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnnouncementType extends Model
{
    protected $table = 'announcement_types';
    public $timestamps = false;
    protected $primaryKey = 'announcement_type_id';

    protected $fillable = [
        'announcement_type_id',
        'name'
    ];

    public function announcements()
    {
        return $this->hasMany(Announcement::class, 'announcement_type_id');
    }
}
