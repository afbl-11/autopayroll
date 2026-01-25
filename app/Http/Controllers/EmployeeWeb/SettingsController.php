<?php

namespace App\Http\Controllers\EmployeeWeb;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Employee;
use Auth;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function updateEmployeeProfile(Request $request) {
        $employee = Auth::guard('employee_web')->user();

        $request->validate([
            'first_name'    => 'sometimes|required|string|max:255',
            'middle_name'   => 'nullable|string|max:255',
            'last_name'     => 'sometimes|required|string|max:255',
            'suffix'        => 'nullable|string|max:50',
            'profile_photo' => 'nullable|image|max:2048',
        ]);

        $firstName  = ucwords(strtolower($request->first_name));
        $middleName = $request->middle_name ? ucwords(strtolower($request->middle_name)) : null;
        $lastName   = ucwords(strtolower($request->last_name));
        $suffix     = $request->suffix ? ucwords(strtolower($request->suffix)) : null;

        // Prevent duplicate names
        $employeeQuery = Employee::where('first_name', $firstName)
            ->where('last_name', $lastName)
            ->where('middle_name', $middleName)
            ->where('suffix', $suffix)
            ->where('employee_id', '!=', $employee->employee_id); // exclude self

        if ($employeeQuery->exists()) {
            return back()
                ->withInput()
                ->withErrors([
                    'first_name' => 'This name is already registered as an employee.'
                ]);
        }

        $data = [
            'first_name'  => $firstName,
            'middle_name' => $middleName,
            'last_name'   => $lastName,
            'suffix'      => $suffix,
        ];

        if ($request->hasFile('profile_photo')) {
            if ($employee->profile_photo) {
                \Storage::disk('public')->delete($employee->profile_photo);
            }
            $data['profile_photo'] = $request->file('profile_photo')
                ->store('profile-photos', 'public');
        }

        $employee->update($data);

        if ($employee->wasChanged()) {
            return back()->with('success', 'Profile updated.');
        }

        return back()->with('info', 'No changes were made.');
    }


    public function index() {

        return view('employee_web.employeeSettings');
    }
}
