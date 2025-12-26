@vite('resources/css/employee_dashboard/employee-information.css')

<x-app :navigation="true" navigationType="employee" :employee="$employee" :noHeader="true">
        <div class="content-wrapper">
            <section class="main-content">
                @if (session('success'))
                    <div class="custom-alert">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="card-wrapper">
                    <a href="{{ route('employee.edit.personal', $employee) }}" class="btn-edit">Edit</a>
                    <h6>Personal Information</h6>
{{--                    name and gender--}}
                    <div class="field-row">
                        <x-form-input
                            label="Full Name"
                            id="full-name"
                            name="full-name"
                            :value="$fullName"
                        />
                        <x-form-input
                            label="Gender"
                            id="gender"
                            name="gender"
                            :value="$employee->gender"
                        />
                    </div>
                    <div class="field-row">
{{--                        civil status and blood type--}}
                        <x-form-input
                            label="Civil Status"
                            id="status"
                            name="status"
                            :value="$employee->marital_status"
                        />
                        <x-form-input
                            label="Blood Type"
                            id="blood-type"
                            name="blood-type"
                            :value="$employee->blood_type"
                        />
                    </div>
{{--                    place of birth--}}
{{--                    <div class="field-row">--}}
{{--                        <x-form-input--}}
{{--                            label="Place of Birth"--}}
{{--                            name="address"--}}
{{--                            id="address"--}}
{{--                            :value="$res_address"--}}
{{--                        />--}}
{{--                    </div>--}}
{{--                    birthdate and age--}}
                    <div class="field-row">
                        <x-form-input
                            label="Date of Birth"
                            id="birthdate"
                            name="birthdate"
                            :value="$employee->birthdate->format('F j, Y')"
                        />
                        <x-form-input
                            label="Age"
                            id="age"
                            name="age"
                            :value="$age"
                        />
                    </div>
                </div>
                <div class="card-wrapper">
                    <a href="{{ route('employee.edit.address', $employee) }}" class="btn-edit">Edit</a>
                    <h6>Address Information</h6>
{{--                    nav and button--}}
                    <div class="field-row">
                        <x-form-input
                            label="Residential Address"
                            name="res_address"
                            id="res_address"
                            :value="$res_address"
                        />
                    </div>
                    <div class="field-row">
                        <x-form-input
                            label="Address on Id"
                            name="id_address"
                            id="id_address"
                            :value="$id_address"
                        />
                    </div>
                </div>
                <div class="card-wrapper">
                    <a href="{{ route('employee.edit.government', $employee) }}" class="btn-edit">Edit</a>
                    <h6>Government & Bank Information</h6>

                    <div class="field-row">
                        <x-form-input
                            label="Bank Account Number"
                            id="bank_account_number"
                            name="bank_account_number"
                            :value="$employee->bank_account_number"
                        />
                        <x-form-input
                            label="SSS Number"
                            id="sss_number"
                            name="sss_number"
                            :value="$employee->sss_number"
                        />
                    </div>

                    <div class="field-row">
                        <x-form-input
                            label="PhilHealth Number"
                            id="philhealth_number"
                            name="philhealth_number"
                            :value="$employee->phil_health_number"
                        />
                        <x-form-input
                            label="Pag-IBIG Number"
                            id="pag_ibig_number"
                            name="pag_ibig_number"
                            :value="$employee->pag_ibig_number"
                        />
                    </div>

                    <div class="field-row">
                        <x-form-input
                            label="TIN Number"
                            id="tin_number"
                            name="tin_number"
                            :value="$employee->tin_number"
                        />
                    </div>
                </div>
            </section>

            <section class="side-content">
                <div class="card-wrapper">
                    <a href="{{ route('employee.edit.account', $employee) }}" class="btn-edit">Edit</a>
                    <h6>Contact Information</h6>
                    <div class="field-row"> 
                        <x-form-input
                            label="Phone Number"
                            id="phone_num"
                            name="phone_num"
                            :value="$employee->phone_number"
                        />
                        <x-form-input
                            label="Email"
                            id="email"
                            name="email"
                            :value="$employee->email"
                        />
                    </div>
                </div>
                <div class="card-wrapper">
                    <a href="{{ route('employee.edit.job', $employee) }}" class="btn-edit">Edit</a>
                    <h6>Employment Overview</h6>
                    <div class="field-row">
                        <x-form-input
                            label="Date Started"
                            id="start_date"
                            name="start_date"
                            :value="$employee->contract_start->format('F j, Y')"
                        />

                        <x-form-input
                            label="Job Role"
                            id="job_position"
                            name="job_position"
                            :value="$employee->job_position"
                        />
                    </div>
                    <div class="field-row">
                        <x-form-input
                            label="Employment Status"
                            id="employment_status"
                            name="employment_status"
                            :value="$employee->employment_type"
                        />
                    </div>
                </div>
                <div class="notes">
{{--                    optional--}}
                </div>
            </section>   
        </div>
</x-app>
<script>
    setTimeout(() => {
        const alert = document.querySelector('.custom-alert');
        if (alert) alert.remove();
    }, 3500);
</script>