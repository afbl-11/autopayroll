@vite('resources/css/employee_registration/accountSetup.css')

<x-app title="Edit Contact Information">
    <section class="main-content">
        <div class="form-wrapper">
            <form method="POST" action="{{ route('employee.update.account', $employee) }}">
                @csrf
                @method('PUT')
                <div class="field-row">
                    <x-form-input type="email" name="email" label="Email"
                        :value="$employee->email" />
                </div>

                <div class="field-row">
                    <x-form-input type="tel" name="phone_number" id="phone_number" label="Phone Number" placeholder="e.g. 09276544387" :value="$employee->phone_number"></x-form-input>
                </div>
                <x-button-submit>Save</x-button-submit>
            </form>
        </div>
    </section>
</x-app>