@vite('resources/css/company/registerReview.css')

<x-app :noDefault="true" :title="$title">
    <div class="main-content">
        <form action="{{route('register.client')}}" method="post">
            @csrf
            <h6>Company Information</h6>

            <div class="field-row">
                <x-form-input
                    name="company_name"
                    id="company_name"
                    :readOnly="true"
                    :value="$data['company_name']"
                    label="Company Name"
                />
            </div>

            <div class="field-row">
                <x-form-input
                    name="first_name"
                    id="first_name"
                    label="Owner Full Name"
                    :value="$ownerName"
                />

                <x-form-input
                    id="tin"
                    name="tin"
                    label="TIN"
                    :value="$data['tin_number']"
                />
            </div>

            <div class="field-row">
                <x-form-input
                    id="industry"
                    name="industry"
                    label="Industry"
                    :value="$data['industry']"
                />
            </div>

            <h6>Address</h6>

                <div class="field-row">
                    <x-form-input
                        id="address"
                        name="address"
                        label="Full Address"
                        :value="$data['address']"
                    />
                </div>

            <div class="field-row">
                <x-form-input
                    id="latitude"
                    name="latitude"
                    label="Latitude"
                    :value="$data['latitude']"
                />
                <x-form-input
                    id="longitude"
                    name="longitude"
                    label="longitude"
                    :value="$data['longitude']"
                />

                <x-form-input
                    id="radius"
                    name="radius"
                    label="Radius"
                    :value="$data['radius']"
                />
            </div>

            <x-button-submit>Create Client</x-button-submit>
        </form>
    </div>
</x-app>
