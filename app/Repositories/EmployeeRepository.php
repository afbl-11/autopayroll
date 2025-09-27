<?php

namespace App\Repositories;

use App\Models\Employee;

class EmployeeRepository
{
    public function create(array $data) {
        return Employee::create($data);
    }

    public function update(array $data, $id) {
        $employee = Employee::find($id);
        if ($employee) {
            $employee->update($data);
            return $employee;
        }
        return null;
    }

    public function delete($id) {
        return Employee::destroy($id);
    }

    public function searchEmployees($query)
    {
        return Employee::where('first_name', 'like', "%{$query}%")
            ->orWhere('last_name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->get();
    }

    public function getEmployees() {
        return Employee::all();
    }

    public function getEmployeeById($id) {
        return Employee::find($id);
    }

    public function getEmployeeByEmail($email) {
        return Employee::where('email', $email)->first();
    }

    public function getEmployeeByLastName($last_name) {
        return Employee::where('last_name', $last_name)->get();
    }

    public function getEmployeeBySchedule($schedule) {
        return Employee::where('schedule', $schedule)->get();
    }

    public function getEmployeeByCompany($company_id) {
        return Employee::where('company_id', $company_id)->get();
    }

    public function getEmployeeByPosition($job_position) {
            return Employee::where('job_position', $job_position)->get();
    }

    public function getEmployeeByEmploymentType($employment_type) {
        return Employee::where('employment_type', $employment_type)->get();
    }
    public function getEmployeeByGender($gender) {
        return Employee::where('gender', $gender)->get();
    }

}
