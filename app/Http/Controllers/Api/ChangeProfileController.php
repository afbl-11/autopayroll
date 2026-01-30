<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChangeProfileController extends Controller
{
    public function changeProfile(Request $request)
    {
        $employee = $request->user();

        if (!$employee) {
            return response()->json([
                'success' => false,
                'message' => 'Employee not found or not authenticated'
            ], 401);
        }

        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        if ($employee->profile_photo && Storage::disk('public')->exists($employee->profile_photo)) {
            Storage::disk('public')->delete($employee->profile_photo);
        }

        $path = $request->file('profile_photo')->store(
            'profile-photos',
            'public'
        );

        // Save to DB
        $employee->profile_photo = $path;
        $employee->save();

        return response()->json([
            'success' => true,
            'message' => 'Profile photo updated successfully.',
            'data' => [
                'profile_photo_url' => asset('storage/' . $path),
            ]
        ], 200);
    }

}
