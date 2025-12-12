@vite(['resources/css/employee_registration/designation.css', 'resources/js/empOnboarding/addEmp.js'])

<x-app :title="$title" :showProgression="false">
<section class="main-content">
    <div class="form-wrapper">
        <form  action="{{route('store.employee.register.3')}}" method="post" enctype="multipart/form-data">
            @csrf
{{--                company and add company button--}}
            <div class="field-row">
                <x-form-select  name="company_id" id="company_id" label="Company" :options="$companies" required></x-form-select>
                <x-button-link source="show.register.client" class="button-link" :noDefault="true">Add Client</x-button-link>
            </div>
{{--            employment type--}}
            <div class="field-row">
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
                <x-form-input
                    label="Daily Rate"
                    name="rate"
                    id="rate"
                    type="text"
                />
            </div>

{{--            start and end date--}}
            <div class="field-row">
                <x-form-input type="date" name="contract_start" id="contract_start" label="Starting Date" required></x-form-input>
                <x-form-input type="date" name="contract_end" id="contract_end" label="Termination Date" required></x-form-input>
            </div>
{{--           upload documents --}}
            <div class="field-row">
                <x-form-input name="job_position" id="job_position" label="Position" required ></x-form-input>
                <x-form-input type="file" name="uploaded_document" id="uploaded_document" label="Upload Documents" accept=".pdf,.jpg,.png,.docx" required></x-form-input>
            </div>
            <x-button-submit>Continue</x-button-submit>
        </form>
    </div>
</section>
</x-app>
