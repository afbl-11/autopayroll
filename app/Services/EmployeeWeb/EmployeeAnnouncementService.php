<?php

namespace App\Services\EmployeeWeb;

use App\Models\Announcement;
use Illuminate\Http\Request;

class EmployeeAnnouncementService
{
    public function getAllAnnouncements($admin_id) {
        $post = Announcement::where('admin_id', $admin_id)
            ->where('is_active', true)
            ->get();

        if($post->isEmpty()) {
            return [
                'success' => false,
                'message' => 'No announcements found'
            ];
        }
        return $post;
    }

    public function announcements(?string $type, string $admin_id)
    {
        return Announcement::where('admin_id', $admin_id)
            ->where('is_active', true)
            ->when($type, fn ($query) => $query->where('type', $type))
            ->latest()
            ->get();
    }
}
