<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function getAnnouncements(Request $request) {

        $employee = $request->user();

        if(!$employee){
            return response()->json([
                'success' => false,
                'message' => 'Employee not found'
            ]);
        }

        $announcements = Announcement::where('is_active', true)->get();

        if($announcements->isEmpty()){
            return response()->json([
                'success' => false,
                'message' => 'Announcements not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'announcements' => $announcements
        ]);
    }
}
