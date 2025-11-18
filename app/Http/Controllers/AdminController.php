<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRegisterAddress;
use App\Models\Admin;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function showSettings() {
        $admin = Auth::guard('admin')->id();

        return view('admin.settings', compact('admin'))->with(['title' => 'Settings']);
    }

    public function showChangePassword() {

        return view('admin.changePassword')->with(['title' => 'Change Password']);
    }

    public function showChangeLocation() {

        return view('admin.changeLocation')->with(['title' => 'Change Location']);
    }

    public function changePassword(Request $request) {

        $request->validate([
            'admin_id' => 'required|exists:admins,admin_id',
            'password' => 'required|string|min:8',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $adminId = $request->admin_id;

        $admin = Admin::find($adminId);

        if (!\Hash::check($request->password, $admin->password)) {
            return back()->withErrors(['password' => 'Current password is incorrect.'])->withInput();
        }

        $admin->password = Hash::make($request->new_password);
        $admin->save();

        return redirect()->route('admin.settings')->with(['success' => 'Password reset successfully.']);
    }

    public function deleteAccount(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8',
        ]);

        $admin = Auth::guard('admin')->user();

        if (!\Hash::check($request->password, $admin->password)) {
            return back()->withErrors(['password' => 'Current password is incorrect.'])->withInput();
        }

        $admin->delete();

        Auth::guard('admin')->logout();

        return redirect()->route('login')->with('success', 'Account deleted successfully.');
    }

    public function changeLocation(Request $request) {

        $admin = Auth::guard('admin')->user();
        $request->validate([
            'country' => 'required|string|max:255',
            'region_name' => 'required|string|max:255',
            'province_name' => 'required|string|max:255',
            'city_name' => 'required|string|max:255',
            'barangay_name' => 'required|string|max:255',
            'zip' => 'required|digits:4',
            'street' => 'required|string|max:255',
            'house_number' => 'required|string|max:20',
        ]);

        $admin->region_name = $request->region_name;
        $admin->province_name = $request->province_name;
        $admin->city_name = $request->city_name;
        $admin->barangay_name = $request->barangay_name;
        $admin->street = $request->street;
        $admin->house_number = $request->house_number;
        $admin->save();

        return redirect()->route('admin.settings')->with(['success' => 'Location changed successfully.']);
    }

}
