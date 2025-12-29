@vite(['resources/css/company/company-info.css', 'resources/js/company/company-info.js'])

<x-app :noHeader="true" :navigation="true" :company="$company">
    <section class="main-content">
        <nav>
            <a href="{{ route('company.edit', $company->company_id) }}"
            class="btn-edit">
                Edit Profile
            </a>
        </nav>
        <div class="information-card">

            {{-- HEADER --}}
            <div class="card-header">
                <h6>Company Information</h6>
            </div>

                <div class="input-wrapper">
                    <x-form-input
                        class="form-input"
                        label="Company Owner"
                        id="owner"
                        name="owner"
                        :value="old('owner', trim($company->first_name . ' ' . $company->last_name))"
                        readonly
                    />

                    <x-form-input
                        class="form-input"
                        label="TIN"
                        id="tin"
                        name="tin_number"
                        :value="old('tin_number', $company->tin_number)"
                        readonly
                    />
                </div>

                <div class="input-wrapper">
                    <x-form-input
                        class="form-input"
                        label="Type of Industry"
                        id="industry"
                        name="industry"
                        :value="old('industry', $company->industry)"
                        readonly
                    />

                    <x-form-input
                        class="form-input"
                        label="Assigned employees"
                        id="employee-count"
                        :value="$company->employees->count()"
                        readonly
                        data-no-edit
                    />
                </div>

            <h6 class="title-address">Address</h6>
            <div class="input-wrapper">
                <x-form-input
                    class="form-input"
                    label="Full address"
                    id="address"
                    :value="$company->address"
                    readonly
                    data-no-edit
                />
            </div>

            <div class="field-row">
                <x-form-input
                    class="form-input"
                    label="Longitude"
                    id="longitude"
                    value="43.1233"
                    readonly
                    data-no-edit
                />
                <x-form-input
                    class="form-input"
                    label="Latitude"
                    id="latitude"
                    value="123.4567"
                    readonly
                    data-no-edit
                />
            </div>
        </div>
    </section>
</x-app>
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function showCustomAlert(message) {
            const alert = document.createElement("div");
            alert.className = "custom-alert";
            alert.textContent = message;
            document.body.appendChild(alert);
            setTimeout(() => alert.remove(), 3500);
        }
        showCustomAlert(@json(session('success')));
    });
</script>
@endif