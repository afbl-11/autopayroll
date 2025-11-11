<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnnouncementRequest;
use App\Models\Announcement;
use App\Services\AnnouncementService;
use http\Env\Request;

class AnnouncementsController extends Controller
{

    public function getAnnouncements() {

        $announcement = Announcement::get();

        return view('announcement.announcement', compact('announcement'))->with('title', 'Announcements');
    }
    public function getAnnouncementDetail($id) {

        $announce = Announcement::find($id);

        return view('announcement.announcementDetail', compact('announce'))->with('title', 'Announcement');
    }

    public function deleteAnnouncement($id) {
        $announcement = Announcement::find($id);

        if ($announcement) {
            $announcement->delete();
            return redirect()->route('announcements')->with('message', 'Announcement deleted successfully.');
        }

        return redirect()->route('announcements')->with('error', 'Announcement not found.');
    }

    public function createAnnouncement() {

        return view('announcement.create')->with('title', 'Create Announcement');
    }

    public function postAnnouncement(AnnouncementRequest $request)
    {
        $service = new AnnouncementService();
        $service->postAnnouncement($request->validated());

        return redirect()->route('announcements')->with('message', 'Announcement created successfully.');
    }
}
