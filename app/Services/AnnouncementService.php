<?php

namespace App\Services;

use App\Models\Announcement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AnnouncementService
{
    public function postAnnouncement(array $data): Announcement {

        $admin = auth::guard('admin')->user();

        $fullName = $admin->first_name . ' ' . $admin->last_name;
        return Announcement::create([
            'announcement_id' => Str::uuid(),
            'admin_id' => auth::guard('admin')->id(),
            'title' => $data['title'],
            'message' => $data['message'],
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addDay(10),
            'is_active' => 0,
            'created_by' => $fullName,
      ]);
    }
}
