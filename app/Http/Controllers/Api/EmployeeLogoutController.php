<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeeLogoutController extends Controller
{
    public function logout(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $currentToken = $request->user()->currentAccessToken();

        if (!$currentToken) {
            return response()->json(['message' => "You haven't logged in yet"], 401);
        }

        // Revoke the current token
        $request->user()->currentAccessToken()->delete();
        $user['android_id'] = null;
        $user->save();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }
}
