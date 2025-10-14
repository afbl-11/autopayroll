@vite(['resources/css/employees/employee_card.css'])
<div class="card-wrapper">
    @foreach($employees as $employee)
        @php $attendance = $employee->attendanceLogs->first(); @endphp
        <x-employee-cards
            :name="$employee->first_name . ' ' . $employee->last_name"
            :id="$employee->employee_id"
            :username="$employee->username"
            :image="'assets/profile-pic.png'"
            :date="$employee->contract_start"
            :phone="$employee->phone_number"
            :type="$employee->employment_type"
            :position="$employee->job_position"
            :email="$employee->email"
            :status="$attendance?->status"
        />
    @endforeach
</div>
