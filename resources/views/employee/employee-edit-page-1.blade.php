@vite(['resources/css/theme.css', 'resources/css/employee_registration/basicInformation.css'])

<x-app title="Edit Personal Information">
    <section class="main-content">
        <div class="form-wrapper">
            <form method="POST" action="{{ route('employee.update.personal', $employee) }}">
                @csrf
                @method('PUT')

                <h5>Personal Information</h5>

                <div class="field-row">
                    <x-form-input name="first_name" label="First Name" :value="$employee->first_name" />
                    <x-form-input name="middle_name" label="Middle Name" :value="$employee->middle_name" />
                </div>

                <div class="field-row">
                    <x-form-input name="last_name" label="Last Name" :value="$employee->last_name" />
                    <x-form-select
                            :options="['' => 'None', 'Sr.' => 'Sr.', 'Jr.' => 'Jr.', 'Other' => 'Other']"
                            label="Suffix"
                            name="suffix"
                            id="suffix"
                    >None</x-form-select>
                </div>

                <div class="field-row">
                    <x-form-input type="date" name="birthdate" label="Birthdate"
                        :value="$employee->birthdate?->format('Y-m-d')" />
                    <x-form-input label="Age" name="age" :value="$employee->age" readonly />
                </div>

                <div class="field-row">
                    <x-form-select name="gender" label="Gender"
                        :options="['male'=>'Male','female'=>'Female']"
                        :value="$employee->gender" />
                    <x-form-select name="blood_type" label="Blood Type"
                        :options="['A+' => 'A+','A-' => 'A-',
                                'B+' => 'B+','B-' => 'B-',
                                'AB+' => 'AB+','AB-' => 'AB-',
                                'O+' => 'O+','O-' => 'O-']"
                        :value="$employee->blood_type" />
                </div>

                <div class="field-row">
                    <x-form-select name="marital_status" label="Civil Status"
                    :options="['single'=>'Single','married'=>'Married','widowed'=>'Widowed']"
                    :value="$employee->marital_status" />
                </div>

                <x-button-submit>Save</x-button-submit>
            </form>
        </div>
    </section>
</x-app>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const birthdateInput = document.querySelector('input[name="birthdate"]');
    const ageInput = document.querySelector('input[name="age"]');

    if (!birthdateInput || !ageInput) return;

    const calculateAge = (birthdate) => {
        if (!birthdate) return '';
        const today = new Date();
        const birth = new Date(birthdate);
        let age = today.getFullYear() - birth.getFullYear();
        const monthDiff = today.getMonth() - birth.getMonth();
        const dayDiff = today.getDate() - birth.getDate();

        if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
            age--;
        }
        return age >= 0 ? age : 0;
    };

    ageInput.value = calculateAge(birthdateInput.value);

    birthdateInput.addEventListener('input', () => {
        ageInput.value = calculateAge(birthdateInput.value);
    });
});
</script>