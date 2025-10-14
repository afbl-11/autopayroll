@vite(['resources/css/employee_dashboard/employeeDashboard.css'])
<x-app :title="$title">
    <nav>
        <div class="nav-group">
            <x-form-input
                type="search"
                name="search_bar"
                id="search_bar"
                placeholder="Search Employee"
                class="nav-items"
                :noDefault="true"
                :value="request('search_bar')"
            ></x-form-input>

            <div class="filters">
                <x-form-select
                    name="company_id"
                    id="company_id"
                    :options="$companies"
                    class="nav-items"
                    :noDefault="true"
                    :value="request('company_id')"
                >Company</x-form-select>

                <x-form-select
                    name="status"
                    id="status"
                    :options="['active'=> 'Active', 'inactive' => 'Inactive']"
                    :noDefault="true"
                    :value="request('status')"
                >Status</x-form-select>
            </div>
        </div>

        <div class="btn-link">
            <x-button-link source="employee.register.1" :noDefault="true">Add Employee</x-button-link>
        </div>
    </nav>

    <section class="main-content">
        <div id="employee-cards-container">
            @foreach($employees as $employee)
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
            @if($employees->isEmpty())
                <p class="no-results">No employees found.</p>
            @endif
    </section>
</x-app>


