<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Company;

class EmployeeEditController extends Controller
{
    public function show(Employee $employee)
    {
        // Load current rate and salary history
        $employee->load(['currentRate', 'salaryHistory']);
        
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

        $salaryHistory = $employee->salaryHistory;

        return view('employee.employee-information', compact(
            'employee',
            'fullName',
            'age',
            'res_address',
            'id_address',
            'salaryHistory'
        ));
    }

    public function editPersonal(Employee $employee)
    {
        return view('employee.employee-edit-page-1', compact('employee'));
    }

    public function updatePersonal(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'first_name'     => 'sometimes|required|string',
            'middle_name'    => 'nullable|string',
            'last_name'      => 'sometimes|required|string',
            'suffix'         => 'nullable|string',
            'birthdate'      => 'sometimes|required|date',
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

        $updateData = [
            'first_name' => $firstName,
            'middle_name' => $middleName,
            'last_name' => $lastName,
            'birthdate' => $request->birthdate,
            'gender' => $request->gender ?? $employee->gender,
            'blood_type' => $request->blood_type ?? $employee->blood_type,
            'marital_status' => $request->marital_status ?? $employee->marital_status,
        ];

        $employee->update($updateData);

        if ($request->has('suffix')) {
            if ($request->suffix === 'None' || $request->suffix === '') {
                $employee->suffix = null;
            } else {
                $employee->suffix = $suffix;
            }
            $employee->save();
        }

        return redirect()
            ->route('employee.info', $employee)
            ->with('success', 'Personal information updated successfully.');
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
        $companies = Company::orderBy('company_name')->pluck('company_name', 'company_id');

        return view('employee.employee-edit-page-3', compact('employee', 'companies'));
    }

    public function updateJob(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'job_position'      => 'sometimes|required|string|max:255',
            'employment_type'   => 'required|string|in:full-time,part-time,contractual',
            'company_id'        => 'nullable|exists:companies,company_id',
            'days_available'    => 'nullable|string',
            'contract_start'    => 'required|date',
            'contract_end'      => 'nullable|date|after_or_equal:contract_start',
            'uploaded_documents.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if ($request->hasFile('uploaded_documents')) {
            $uploadedFiles = [];

            foreach ($request->file('uploaded_documents') as $file) {
                $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('employee_documents', $filename, 'public');
                $uploadedFiles[] = $path;
            }

            $validated['uploaded_documents'] = json_encode($uploadedFiles);
        }

        //if (isset($validated['job_position'])) {
            //$newJob = ucwords(strtolower(trim($validated['job_position'])));
            //$currentJob = ucwords(strtolower(trim($employee->job_position)));

            //if ($newJob === $currentJob) {
                //return redirect()->back()
                    //->withInput()
                    //->withErrors(['job_position' => 'The job position is the same as the current one.']);
            //}

            //$validated['job_position'] = $newJob;
        //}

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
            'email' => 'sometimes|required|email|unique:employees,email,' 
                        . $employee->employee_id . ',employee_id',

            'phone_number' => 'sometimes|required|string|max:15|unique:employees,phone_number,' 
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

        if (Company::where('tin_number', $request->tin_number)->exists()) {
            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'tin_number' => 'This TIN number is already assigned to a company.'
                ]);
        }

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

    public function updateRate(Request $request, $id)
    {
        $request->validate([
            'rate' => 'required|numeric|min:0',
            'effective_from' => 'required|date',
        ]);

        $employee = Employee::findOrFail($id);

        // End the current rate if it exists
        if ($employee->currentRate) {
            $currentRate = $employee->currentRate;
            $effectiveFrom = \Carbon\Carbon::parse($request->effective_from);
            
            // Only end the current rate if the new effective date is after the current effective_from
            if ($effectiveFrom->greaterThan($currentRate->effective_from)) {
                $currentRate->update([
                    'effective_to' => $effectiveFrom->subDay()->format('Y-m-d')
                ]);
            }
        }

        // Create new rate entry
        \App\Models\EmployeeRate::create([
            'employee_id' => $employee->employee_id,
            'admin_id' => auth('admin')->id(),
            'rate' => $request->rate,
            'effective_from' => $request->effective_from,
            'effective_to' => null,
        ]);

        return redirect()
            ->route('employee.info', $employee->employee_id)
            ->with('success', 'Daily salary rate updated successfully.');
    }

    public function editRate(Request $request, $employeeId, $rateId)
    {
        $request->validate([
            'rate' => 'required|numeric|min:0',
            'effective_from' => 'required|date',
            'effective_to' => 'nullable|date|after_or_equal:effective_from',
        ]);

        $rate = \App\Models\EmployeeRate::findOrFail($rateId);
        
        // Update the rate
        $rate->update([
            'rate' => $request->rate,
            'effective_from' => $request->effective_from,
            'effective_to' => $request->effective_to,
        ]);

        return redirect()
            ->route('employee.info', $employeeId)
            ->with('success', 'Salary rate updated successfully.');
    }
}