@vite(['resources/css/employee_registration/designation.css', 'resources/js/empOnboarding/addEmp.js'])

<x-app title="Edit Employment Information">
    <section class="main-content">
        <div class="form-wrapper">
            <form method="POST" action="{{ route('employee.update.job', $employee) }}">
                @csrf
                @method('PUT')
                <div class="radio-group">
                    <label>Employment Type</label><br>
                    <x-form-radio
                        name="employment_type"
                        value="full-time"
                        label="Full-Time"
                        :selected="old('employment_type')"
                        required
                    />

                    <x-form-radio
                        name="employment_type"
                        value="part-time"
                        label="Part-Time"
                        :selected="old('employment_type')"
                        required
                    />

                    <x-form-radio
                        name="employment_type"
                        value="contractual"
                        label="Contractual"
                        :selected="old('employment_type')"
                        required
                    />
                </div>
                            
                <div class="field-row">
                    <x-form-input type="date" name="contract_start" id="contract_start" label="Starting Date"></x-form-input>
                    <x-form-input type="date" name="contract_end" id="contract_end" label="Termination Date"></x-form-input>
                </div>
    
                <div class="field-row">
                    <x-form-input name="job_position" id="job_position" :value="$employee->job_position" label="Position"></x-form-input>
                    <x-form-input type="file" name="uploaded_document" id="uploaded_document" label="Upload Documents" accept=".pdf,.jpg,.jpeg,.png"></x-form-input>
                    <small style="color: #666; margin-top: 5px; display: block;">Allowed formats: PDF, JPG, PNG (Max 5MB)</small>
                </div>

                <x-button-submit>Save</x-button-submit>
            </form>
        </div>
    </section>
</x-app>