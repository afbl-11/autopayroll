@vite('resources/css/company/company-info.css')

<x-app :noHeader="true" :companyHeader="true" :company="$company">
    <section class="main-content">
        <div class="information-card">
            <h6>Company Information</h6>
            <div class="input-wrapper">
                <x-form-input
                    class="form-input"
                    label="Company Owner"
                    id="owner"
                    :value="$company->company_name"
                />
                <x-form-input
                    class="form-input"
                    label="TIN"
                    id="tin"
                    :value="$company->tin_number"
                />
            </div>

            <div class="input-wrapper">
                <x-form-input
                    class="form-input"
                    label="Type of Industry"
                    id="industry"
                    :value="$company->industry"
                />
                <x-form-input
                    class="form-input"
                    label="Assigned employees"
                    id="employee-count"
                    :value="$company->employees->count()"
                />
            </div>

            <h6>Address</h6>
            <div class="input-wrapper">
                <x-form-input
                    class="form-input"
                    label="Full address"
                    id="address"
                    :value="$company->country"
                />
                <x-form-input
                    class="form-input"
                    label="Latitude"
                    id="latitude"
                    value="123.4567"
                />
            </div>
            <div class="input-wrapper">
                <x-form-input
                    class="form-input"
                    label="Longitude"
                    id="longitude"
                    value="43.1233"
                />
            </div>
        </div>
    </section>
</x-app>
