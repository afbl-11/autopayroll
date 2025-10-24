@vite('resources/css/employee_dashboard/employee-information.css')

<x-app :navigation="true" navigationType="employee" :employee="$employee" :noHeader="true">
        <div class="content-wrapper">
            <section class="main-content">
                <div class="card-wrapper">
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
                    <div class="field-row">
                        <x-form-input
                            label="Place of Birth"
                            name="address"
                            id="address"
                            :value="$res_address"
                        />
                    </div>
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
            </section>

            <section class="side-content">
                <div class="card-wrapper">
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
