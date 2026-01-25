<?php

namespace App\Http\Controllers\EmployeeWeb;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Services\EmployeeWeb\EmployeeAnnouncementService;
use Auth;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function __construct(
        protected EmployeeAnnouncementService $announcementService
    ){}
    public function index(Request $request)
    {
        $employee = Auth::guard('employee_web')->user();

        $validated = $request->validate([
            'type' => 'nullable|in:Payroll,Admin,Memo',
        ]);

        $announcements = $this->announcementService
            ->announcements($validated['type'] ?? null, $employee->admin_id);

        return view(
            'employee_web.announcementModule.announcementScreen',
            compact('announcements')
        );
    }

    public function show($id)
    {
        $announcement = Announcement::find($id);

        if (!$announcement) {
            return redirect()->back()->with('error', 'Announcement not found.');
        }

        $attachments = $announcement->attachments
            ? json_decode($announcement->attachments, true)
            : [];

        return view('employee_web.announcementModule.announcementView', [
            'announcement' => $announcement,
            'attachments' => $attachments,
        ]);
    }


    public function deleteAnnouncement($id) {
        $announcement = Announcement::find($id);

        if ($announcement) {
            $announcement->delete();
            return redirect()->route('employee_web.announcement')->with('message', 'Announcement deleted successfully.');
        }

        return redirect()->route('employee_web.announcement')->with('error', 'Announcement not found.');
    }

}
