<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRegisterAddress;
use App\Models\Admin;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee;
use App\Models\Company;

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

    public function updateProfile(Request $request)
    {
        $admin = auth('admin')->user();

        $request->validate([
            'first_name'    => 'sometimes|required|string|max:255',
            'middle_name'   => 'nullable|string|max:255',
            'last_name'     => 'sometimes|required|string|max:255',
            'suffix'        => 'nullable|string|max:50',
            'company_name'  => 'sometimes|required|string|max:255',
            'profile_photo' => 'nullable|image|max:2048',
        ]);

        $firstName  = ucwords(strtolower($request->first_name));
        $middleName = $request->middle_name ? ucwords(strtolower($request->middle_name)) : null;
        $lastName   = ucwords(strtolower($request->last_name));
        $suffix     = $request->suffix ? ucwords(strtolower($request->suffix)) : null;

        $employeeQuery = Employee::where('first_name', $firstName)
            ->where('last_name', $lastName)
            ->where('middle_name', $middleName)
            ->where('suffix', $suffix);

        if ($employeeQuery->exists()) {
            return back()
                ->withInput()
                ->withErrors([
                    'first_name' => 'This name is already registered as an employee.'
                ]);
        }

        if ($request->company_name) {
            $companyName = ucwords(strtolower($request->company_name));

            if (
                Company::where('company_name', $companyName)
                    ->where('company_id', '!=', $admin->company_id)
                    ->exists()
            ) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'company_name' => 'This company name already exists.'
                    ]);
            }
        }

        $data = [
            'first_name'   => $firstName,
            'middle_name'  => $middleName,
            'last_name'    => $lastName,
            'suffix'       => $suffix,
            'company_name' => $request->company_name
                ? ucwords(strtolower($request->company_name))
                : null,
        ];

        if ($request->hasFile('profile_photo')) {
            $data['profile_photo'] = $request->file('profile_photo')
                ->store('profile-photos', 'public');
        }

        $admin->update($data);

        if ($admin->wasChanged()) {
            return back()->with('success', 'Profile updated.');
        }

        return back()->with('info', 'No changes were made.');
    }

    public function showForgotPassword(Request $request)
    {
        $email = $request->query('email');
        return view('auth.auth-forgot-password', compact('email'));

    }

    public function resetForgotPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
            'email' => 'required|email',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin) {
            return back()->withErrors(['email' => 'No account found with this email.']);
        }

        if (Hash::check($request->password, $admin->password)) {
            return back()
                ->withErrors(['password' => 'New password must be different from the old password.'])
                ->withInput();
        }

        $admin->password = Hash::make($request->password);
        $admin->save();

        return redirect()
            ->route('login')
            ->with('success', 'Password updated.');
    }
}
