<?php

namespace App\Services;

use App\Models\Announcement;
use App\Models\AnnouncementType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AnnouncementService
{
    /**
     * Post a new announcement.
     *
     * @param array $data
     * @return Announcement
     */
    public function postAnnouncement(array $data): Announcement
    {
        $admin = Auth::guard('admin')->user();
        $fullName = $admin->first_name . ' ' . $admin->last_name;
        $attachments = null;

        if (!empty($data['attachment']) && $data['attachment'] instanceof \Illuminate\Http\UploadedFile) {
            $path = $data['attachment']->store('announcement_attachments', 'public');

            $attachments = json_encode([$path]);
        }
        $type = AnnouncementType::where('announcement_type_id', $data['type'])->first();

        return Announcement::create([
            'announcement_id' => \Illuminate\Support\Str::uuid(),
            'announcement_type_id' => $data['type'],
            'admin_id' => \Illuminate\Support\Facades\Auth::guard('admin')->id(),
            'subject' => $data['subject'],
            'type' => $type->name,
            'title' => $data['title'],
            'message' => $data['message'],
            'attachments' => $attachments,
            'start_date' => $data['start_date'] ?? now(),
            'end_date' => $data['end_date'] ?? now()->addDays(10),
            'is_active' => 1,
            'created_by' => $data['created_by'] ?? (Auth::guard('admin')->user()->first_name . ' ' . Auth::guard('admin')->user()->last_name),
        ]);

    }
}
