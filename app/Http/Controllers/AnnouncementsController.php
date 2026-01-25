<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnnouncementRequest;
use App\Models\Announcement;
use App\Models\AnnouncementType;
use App\Services\AnnouncementService;
use App\Services\EmployeeWeb\EmployeeAnnouncementService;
use Auth;
use Illuminate\Http\Request;


class AnnouncementsController extends Controller
{
    public function __construct(
        protected EmployeeAnnouncementService $announcementService
    ){}

    public function getAnnouncements(Request $request) {

        $admin = Auth::guard('admin')->user();

        $validated = $request->validate([
            'type' => 'nullable|in:Payroll,Admin,Memo',
        ]);

        $announcement = $this->announcementService
            ->announcements($validated['type'] ?? null, $admin->admin_id);

        return view('announcement.announcement', compact('announcement'))->with('title', 'Announcements');
    }
    public function getAnnouncementDetail($id) {

        $announcement = Announcement::find($id);

        return view('announcement.announcementDetail', compact('announcement'))->with('title', 'Announcement');
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
        $types = AnnouncementType::pluck('name', 'name');

        return view('announcement.create', compact ('types'))->with('title', 'Create Announcement');
    }

    public function postAnnouncement(AnnouncementRequest $request)
    {
        $service = new AnnouncementService();

        // Get validated input
        $data = $request->validated();

        // Attach the uploaded file to the data array if it exists
        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment');
        }

        $service->postAnnouncement($data);

        return redirect()->route('announcements')
            ->with('message', 'Announcement created successfully.');
    }
}
