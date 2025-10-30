@vite('resources/css/company/company-employee.css')

<x-app :noHeader="true" :navigation="true" :company="$company">
    <section  class="main-content">
        <form action="{{route('company.employee.assign.save', $company->company_id)}}" method="post">
        @csrf
                    <x-button-submit id="button">Save Selection</x-button-submit>
            <div id="employee-cards-container">
                @foreach($employees as $employee)
                    <label class="employee-card-wrapper">
                        <input
                            type="checkbox"
                            name="employees[]"
                            value="{{ $employee->employee_id }}"
                            class="hidden peer"
                        >
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
                            :clickable="false"
                        />
                    </label>
                @endforeach
            </div>
        </form>
    </section>
</x-app>
{{--todo: make a counter to how many employees have been selected--}}
