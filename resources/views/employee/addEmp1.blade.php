@vite(['resources/css/theme.css', 'resources/css/employee_registration/basicInformation.css'])
@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <strong>There were some problems with your input.</strong>
        <ul class="mt-2 list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<x-app title="{{$title}}" :showProgression="true">

    <section class="main-content">
        <div class="form-wrapper">
            <form action="{{route('store.employee.register.1')}}" method="post">
                @csrf
                <section id="personal-information">
                    <h5>Personal Information</h5>
            {{--        first and last name--}}
                    <div class="field-row">
                        <x-form-input  name="first_name" id="first_name"  label="First Name" required></x-form-input>
                        <x-form-input name="middle_name" id="middle_name"  label="Middle Name" required></x-form-input>
                    </div>
                    <div class="field-row">
                        <x-form-input name="last_name" id="last_name"  label="Last Name" required></x-form-input>
                        <x-form-select :options="['Sr.' => 'Sr.','Jr.' => 'Jr.', 'Other' => 'Other' ]" label="Suffix"  name="suffix" id="suffix">None</x-form-select>
                    </div>

    {{--                birthdate and age--}}
                    <div class="field-row">
                        <x-form-input type="date" name="birthdate" id="birthdate"  label="Birth Date" required></x-form-input>
                        <x-form-input name="age" id="age"  label="Age" required ></x-form-input>
                    </div>

                    <div class="field-row">
                        <x-form-select :options="['male' => 'Male', 'female' => 'Female' ]" label="Blood Type" required name="gender" id="gender">------</x-form-select>
                        <x-form-select
                            :options="[
                                'A+' => 'A+',
                                'A-' => 'A-',
                                'B+' => 'B+',
                                'B-' => 'B-',
                                'AB+' => 'AB+',
                                'AB-' => 'AB-',
                                'O+' => 'O+',
                                'O-' => 'O-']"
                            label="Blood Type" required name="blood_type" id="blood_type">------</x-form-select>
                    </div>
                    <div class="field-row">
                        <x-form-select :options="[
                                'single' => 'Single',
                                'married' => 'Married',
                                'widow' => 'Widow'
                            ]" required label="Civil Status" name="marital_status" id="marital_status">------</x-form-select>
                    </div>
                </section>

                <section id=government-requirement">
{{--                    bank and sss--}}
                    <h5>Government Requirements</h5>
                    <div class="field-row">
                        <x-form-input label="Bank Account Number" name="bank_account_number" id="bank_account_number" required></x-form-input>
                        <x-form-input label="Social Security Number" name="sss_number" id="sss_number" required placeholder="e.g 123456789102"></x-form-input>
                    </div>

{{--                    philhealth and pagibig--}}
                    <div class="field-row">
                        <x-form-input label="Phil-Health Number" name="phil_health_number" id="phil_health_number" required placeholder="e.g 1234567891023456"></x-form-input>
                        <x-form-input label="Pag-Ibig Number" name="pag_ibig_number" id="pag_ibig_number" required placeholder="e.g 1234567891023456"></x-form-input>
                    </div>

{{--                    Tin--}}
                    <div class="field-row">
                        <x-form-input label="TIN" name="tin_number" id="pag_ibig_number" required placeholder="e.g 1234567891"></x-form-input>
                    </div>
                </section>


                <x-button-submit>Continue</x-button-submit>
            </form>
        </div>
    </section>

</x-app>
