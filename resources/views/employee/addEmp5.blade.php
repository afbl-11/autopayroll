@vite(['resources/css/employee_registration/reviewDetails.css', 'resources/js/empOnboarding/addEmp.js'])

<x-app :title="$title" :showProgression="false">
    <section class="main-content">
        <div class="form-wrapper">
            <form class="form" action="{{route('employee.create')}}" method="post">
                @csrf

                <section class="basic_information">
                    <h5>Basic Information</h5>
    {{--                first and middle name--}}
                    <div class="field-row">
                        <x-form-input id="first_name" label="First Name" :value="$data['first_name'] ?? null"></x-form-input>
                        <x-form-input id="middle_name" label="Middle Name" :value="$data['middle_name'] ?? null"></x-form-input>
                    </div>
    {{--                last and suffix--}}
                    <div class="field-row">
                        <x-form-input id="last_name" label="Last Name" :value="$data['last_name'] ?? null"></x-form-input>
                        <x-form-input id="suffix" label="Suffix" :value="$data['suffix'] ?? 'N/A'"></x-form-input>
                    </div>
    {{--                place of birth--}}
                    <div class="field-row">
                        <x-form-input id="birthplace" label="Place of Birth" :value="$address"></x-form-input>
                    </div>
    {{--                bday and civil status--}}
                    <div class="field-row">
                        <x-form-input id="birthdate" label="Date of Birth" :value="$data['birthdate']"></x-form-input>
                        <x-form-input id="age" label="Age" :value="$data['age']"></x-form-input>
                    </div>
    {{--                gender and status--}}
                    <div class="field-row">
                        <x-form-input id="gender" label="Gender" :value="$data['gender']"></x-form-input>
                        <x-form-input id="civil_status" label="Civil Status" :value="$data['marital_status']"></x-form-input>
                    </div>

                    <div class="field-row">
                        <x-form-input id="blood_type" label="Blood Type" :value="$data['blood_type']"></x-form-input>
                    </div>
                </section>

                <section class="contact_address">
                    <h5>Contact & Address</h5>
{{--                    res address--}}
                    <div class="field-row">
                        <x-form-input id="res_address" label="Residential Address" :value="$address"></x-form-input>
                    </div>
{{--                    id address--}}
                    <div class="field-row">
                        <x-form-input id="id_address" label="Address on Id" :value="$idAddress"></x-form-input>
                    </div>
{{--                    phone and email--}}
                    <div class="field-row">
                        <x-form-input id="phone_num" label="Personal Contact Number" :value="$data['phone_number']"></x-form-input>
                        <x-form-input id="email" label="Email Address" :value="$data['email']"></x-form-input>
                    </div>

                    <div class="field-row">
                        <x-form-input id="other_contact" label="Other Contacts" value="N/A"></x-form-input>
                    </div>
                </section>

{{--                employment overview--}}
                <section class="employment_overview">
                    <h5>Employment Overview</h5>

{{--                    Company--}}
                    <div class="field-row">
                        <x-form-input id="company_id" label="Company Designation" :value="$data['company_id']"></x-form-input>
                    </div>
{{--                    employment type and position--}}
                    <div class="field-row">
                        <x-form-input id="employment_type" label="Employment Type" :value="$data['employment_type']"></x-form-input>
                        <x-form-input id="position" label="Position" :value="$data['job_position']"></x-form-input>
                    </div>
{{--                    starting and end date--}}
                    <div class="field-row">
                        <x-form-input id="contract_start" label="Starting Date" :value="$data['contract_start']"></x-form-input>
                        <x-form-input id="contract_end" label="Termination Date" :value="$data['contract_end']"></x-form-input>
                    </div>
{{--                    uploaded docs--}}
                    <div class="field-row">
                        <x-form-input id="documents" label="Uploaded Documents" :value="$data['uploaded_documents'] ?? 'N/A' "></x-form-input>
                    </div>

                    <section class="account_setup">
                        <h5>Account Information</h5>

                        <div class="field-row">
                            <x-form-input id="username" label="User Name" :value="$data['username']"></x-form-input>
                            <x-form-input id="setup_email" label="Email Address" :value="$data['email']"></x-form-input>
                        </div>

                        <div class="field-row">
                            <x-form-input id="password" label="password" value="DefaultPassword123!"></x-form-input>
                        </div>
                    </section>
                </section>
                <x-button-submit>Create Employee</x-button-submit>
            </form>
        </div>

    </section>
</x-app>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const inputs = document.querySelectorAll('input, textarea, select');

        inputs.forEach(input => {
            input.classList.add('read-mode-only');
        });
    });
</script>

