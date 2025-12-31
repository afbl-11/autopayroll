<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class EmployeeEditController extends Controller
{
    public function show(Employee $employee)
    {
        $fullName = trim(
            $employee->first_name . ' ' .
            ($employee->middle_name ? $employee->middle_name . ' ' : '') .
            $employee->last_name
        );

        if ($employee->suffix) {
            $fullName .= ' ' . $employee->suffix;
        }

        $age = $employee->birthdate
            ? $employee->birthdate->age
            : null;

        $res_address =
            $employee->house_number . ', '
            .$employee->street . ', '
            . $employee->barangay_name .', '
            . $employee->city_name . ', '
            . $employee->province_name . ', '
            . $employee->zip . ', '
            . $employee->region_name. ', '
            .$employee->country ;
        $id_address =
             $employee->id_country . ', '
             . $employee->id_region_name . ', '
             . $employee->id_zip . ', '
             . $employee->id_city_name . ', '
             . $employee->id_barangay_name .', '
             .$employee->id_street . ', '
             .$employee->id_house_number;

        return view('employee.employee-information', compact(
            'employee',
            'fullName',
            'age',
            'res_address',
            'id_address'
        ));
    }

    public function editPersonal(Employee $employee)
    {
        return view('employee.employee-edit-page-1', compact('employee'));
    }

    public function updatePersonal(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'first_name'     => 'nullable|string',
            'middle_name'    => 'nullable|string',
            'last_name'      => 'nullable|string',
            'suffix'         => 'nullable|string',
            'birthdate'      => 'nullable|date',
            'gender'         => 'nullable|string',
            'blood_type'     => 'nullable|string',
            'marital_status' => 'nullable|string',
        ]);

        $firstName = ucwords(strtolower($request->first_name));
        $middleName = $request->middle_name ? ucwords(strtolower($request->middle_name)) : null;
        $lastName = ucwords(strtolower($request->last_name));
        $suffix = $request->suffix ? ucwords(strtolower($request->suffix)) : null;

        $duplicateQuery = Employee::where('first_name', $firstName)
            ->where('last_name', $lastName)
            ->where('employee_id', '!=', $employee->employee_id);

        if ($middleName) {
            $duplicateQuery->where('middle_name', $middleName);
        }

        if ($suffix) {
            $duplicateQuery->where('suffix', $suffix);
        }

        if ($duplicateQuery->exists()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['first_name' => 'An employee with the same full name already exists.']);
        }

        $adminQuery = Admin::where('first_name', $firstName)
            ->where('last_name', $lastName);

        if ($middleName) {
            $adminQuery->where('middle_name', $middleName);
        } else {
            $adminQuery->whereNull('middle_name');
        }

        if ($suffix) {
            $adminQuery->where('suffix', $suffix);
        } else {
            $adminQuery->whereNull('suffix');
        }

        if ($adminQuery->exists()) {
            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'first_name' => 'This is your name.'
                ]);
        }

         $employee->update(
            collect($validated)
                ->except('suffix')
                ->filter(fn ($v) => !is_null($v))
                ->toArray()
        );

        if ($request->has('suffix')) {
            if ($request->suffix === 'None' || $request->suffix === '') {
                $employee->suffix = null;
            } else {
                $employee->suffix = $request->suffix;
            }
            $employee->save();
        }

            if ($employee->wasChanged()) {
                $employee->save();

                return redirect()
                    ->route('employee.info', $employee)
                    ->with('success', 'Personal information updated.');
            }

        return redirect()->route('employee.info', $employee);
    }

    public function editAddress(Employee $employee)
    {
        return view('employee.employee-edit-page-2', compact('employee'));
    }

    public function updateAddress(Request $request, Employee $employee)
    {
        $resData = collect($request->only([
            'country',
            'region',
            'region_name',
            'province',
            'province_name',
            'city',
            'city_name',
            'barangay',
            'barangay_name',
            'street',
            'house_number',
            'zip',
        ]))
        ->filter(fn ($v) => !is_null($v))
        ->toArray();

        if (!empty($resData)) {
            $employee->update($resData);
        }

        if ($request->has('same_address')) {
            $idData = [
                'id_country'       => $resData['country']        ?? $employee->country,
                'id_region'        => $resData['region']         ?? $employee->region,
                'id_region_name'   => $resData['region_name']    ?? $employee->region_name,
                'id_province'      => $resData['province']       ?? $employee->province,
                'id_province_name' => $resData['province_name']  ?? $employee->province_name,
                'id_city'          => $resData['city']           ?? $employee->city,
                'id_city_name'     => $resData['city_name']      ?? $employee->city_name,
                'id_barangay'      => $resData['barangay']       ?? $employee->barangay,
                'id_barangay_name' => $resData['barangay_name']  ?? $employee->barangay_name,
                'id_street'        => $resData['street']         ?? $employee->street,
                'id_house_number'  => $resData['house_number']  ?? $employee->house_number,
                'id_zip'           => $resData['zip']            ?? $employee->zip,
            ];
        } else {
            $idData = collect($request->only([
                'id_country',
                'id_region',
                'id_region_name',
                'id_province',
                'id_province_name',
                'id_city',
                'id_city_name',
                'id_barangay',
                'id_barangay_name',
                'id_street',
                'id_house_number',
                'id_zip',
            ]))
            ->filter(fn ($v) => !is_null($v))
            ->toArray();
        }

        if (!empty($idData)) {
            $employee->update($idData);
        }

        if ($employee->wasChanged()) {
            return redirect()
                ->route('employee.info', $employee)
                ->with('success', 'Address information updated.');
        }

        return redirect()->route('employee.info', $employee);
    }

    public function editJob(Employee $employee)
    {
        return view('employee.employee-edit-page-3', compact('employee'));
    }

    public function updateJob(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'job_position'      => 'nullable|string|max:255',
            'employment_type'   => 'nullable|string|in:full-time,part-time,contractual',
            'rate'              => 'nullable|numeric',
            'contract_start'    => 'nullable|date',
            'contract_end'      => 'nullable|date|after_or_equal:contract_start',
            'uploaded_document' => 'nullable|file|mimes:pdf,jpg,png,docx|max:2048',
        ]);

        if ($request->hasFile('uploaded_document')) {
            $file = $request->file('uploaded_document');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/documents', $filename); 
            $validated['uploaded_document'] = $filename;
        }

        $employee->update(array_filter($validated, fn ($v) => !is_null($v)));

            if ($employee->wasChanged()) {
                $employee->save();

                return redirect()
                    ->route('employee.info', $employee)
                    ->with('success', 'Employment details updated.');
            }

        return redirect()->route('employee.info', $employee);
    }

    public function editAccount(Employee $employee)
    {
        return view('employee.employee-edit-page-4', compact('employee'));
    }

    public function updateAccount(Request $request, Employee $employee)
    {
        $request->validate([
            'email' => 'nullable|email|unique:employees,email,' 
                        . $employee->employee_id . ',employee_id',

            'phone_number' => 'nullable|string|max:15|unique:employees,phone_number,' 
                        . $employee->employee_id . ',employee_id',
        ]);

        $employee->update([
            'email'        => $request->email,
            'phone_number' => $request->phone_number,
        ]);

            if ($employee->wasChanged()) {
                $employee->save();

                return redirect()
                    ->route('employee.info', $employee)
                    ->with('success', 'Contact information updated.');
            }

        return redirect()->route('employee.info', $employee);
    }

    public function editGovernment(Employee $employee)
    {
        return view('employee.employee-edit-page-5', compact('employee'));
    }

    public function updateGovernment(Request $request, Employee $employee)
    {
        $request->validate([
            'bank_account_number' => 'required|string|max:20',
            'sss_number'          => 'required|string|max:20|unique:employees,sss_number,' . $employee->employee_id . ',employee_id',
            'phil_health_number'  => 'required|string|max:20|unique:employees,phil_health_number,' . $employee->employee_id . ',employee_id',
            'pag_ibig_number'     => 'required|string|max:20|unique:employees,pag_ibig_number,' . $employee->employee_id . ',employee_id',
            'tin_number'          => 'required|string|max:20|unique:employees,tin_number,' . $employee->employee_id . ',employee_id',
        ]);

        $employee->update([
            'bank_account_number' => $request->bank_account_number,
            'sss_number'          => $request->sss_number,
            'phil_health_number'  => $request->phil_health_number,
            'pag_ibig_number'     => $request->pag_ibig_number,
            'tin_number'          => $request->tin_number,
        ]);

            if ($employee->wasChanged()) {
                $employee->save();

                return redirect()
                    ->route('employee.info', $employee)
                    ->with('success', 'Government and Bank information updated.');
            }

        return redirect()->route('employee.info', $employee);
    }
}