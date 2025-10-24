@vite('resources/css/company/company-employee.css')

<x-app :noHeader="true" :navigation="true" :company="$company">
    <section class="main-content">
        <div id="employee-cards-container">
            @foreach($company->employees as $employee)
                @php
                    $attendance = $employee->attendanceLogs->first();
                @endphp

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
                ></x-employee-cards>
            @endforeach
        </div>
        @if($company->employees->isEmpty())
            <p class="no-results">No employees found.</p>
        @endif
    </section>
</x-app>
