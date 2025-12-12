@vite(['resources/css/theme.css', 'resources/css/employee_registration/basicInformation.css'])

<x-app title="{{ $title }}" :showProgression="false">
    <section class="main-content">
        <div class="form-wrapper">
            <form action="{{ route('store.employee.register.1') }}" method="post">
                @csrf

                {{-- =========================
                  PERSONAL INFORMATION
                ========================== --}}
                <section id="personal-information">
                    <h5>Personal Information</h5>

                    {{-- First, Middle, Last Name --}}
                    <div class="field-row">
                        <x-form-input name="first_name" id="first_name" label="First Name" required />
                        <x-form-input name="middle_name" id="middle_name" label="Middle Name"  required />
                    </div>

                    <div class="field-row">
                        <x-form-input name="last_name" id="last_name" label="Last Name"  required />

                        <x-form-select
                            :options="['Sr.' => 'Sr.', 'Jr.' => 'Jr.', 'Other' => 'Other']"
                            label="Suffix"
                            name="suffix"
                            id="suffix"
                        >None</x-form-select>
                    </div>

                    {{-- Birthdate and Age --}}
                    <div class="field-row">
                        <x-form-input type="date" name="birthdate" id="birthdate"
                                      label="Birth Date" :value="old('birthdate')" required />
                        <x-form-input name="age" id="age" label="Age"
                                       required :readonly="true" />
                    </div>

                    <div class="field-row">
                        <x-form-select
                            :options="['male' => 'Male', 'female' => 'Female']"
                            label="Gender"
                            name="gender"
                            id="gender"
                            required
                        >------</x-form-select>

                        <x-form-select
                            :options="[
                                'A+' => 'A+','A-' => 'A-',
                                'B+' => 'B+','B-' => 'B-',
                                'AB+' => 'AB+','AB-' => 'AB-',
                                'O+' => 'O+','O-' => 'O-'
                            ]"
                            label="Blood Type"
                            name="blood_type"
                            id="blood_type"
                            required
                        >------</x-form-select>
                    </div>

                    <div class="field-row">
                        <x-form-select
                            :options="[
                                'single' => 'Single',
                                'married' => 'Married',
                                'widowed' => 'Widow'
                            ]"
                            label="Civil Status"
                            name="marital_status"
                            id="marital_status"
                            required
                        >------</x-form-select>
                    </div>
                </section>

                {{-- =========================
                     GOVERNMENT REQUIREMENTS
                ========================== --}}
                <section id="government-requirement">
                    <h5>Government Requirements</h5>

                    {{-- Bank and SSS --}}
                    <div class="field-row">
                        <x-form-input label="Bank Account Number"
                                      name="bank_account_number"
                                      id="bank_account_number"
                                      required
                                      placeholder="10-16 digits"
                        />

                        <x-form-input label="Social Security Number"
                                      name="sss_number"
                                      id="sss_number"
                                      placeholder="10 digits"
                                      required />
                    </div>

                    {{-- PhilHealth and Pag-IBIG --}}
                    <div class="field-row">
                        <x-form-input label="PhilHealth Number"
                                      name="phil_health_number"
                                      id="phil_health_number"
                                      placeholder="12 digits"
                                       required />

                        <x-form-input label="Pag-IBIG Number"
                                      name="pag_ibig_number"
                                      id="pag_ibig_number"
                                      placeholder="12 digits"
                                       required />
                    </div>

                    {{-- TIN --}}
                    <div class="field-row">
                        <x-form-input label="TIN"
                                      name="tin_number"
                                      id="tin_number"
                                      placeholder="9-12 digits"
                                      required />
                    </div>
                </section>

                <x-button-submit>Continue</x-button-submit>
            </form>
        </div>
    </section>
</x-app>

<script>

    document.addEventListener('DOMContentLoaded', () => {
        const dateInput = document.getElementById('birthdate');
        const ageInput = document.getElementById('age');

        dateInput.addEventListener('change', () => {
            const birthdateValue = dateInput.value;
            if(!birthdateValue) return;

            const today = new Date();
            const birthDate = new Date(birthdateValue);


            let age = today.getFullYear() - birthDate.getFullYear();

            const monthDiff = today.getMonth() - birthDate.getMonth();
            const dayDiff = today.getDate() - birthDate.getDate();

            if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
                age--;
            }

            ageInput.value = age >= 0 ? age : 0;
        });
    });
</script>

