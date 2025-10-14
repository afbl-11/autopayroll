
@vite(['resources/css/employee_registration/address.css', 'resources/js/api/address-picker.js'])
<x-app :title="$title">

    <section class="main-content">

        <div class="form-wrapper">
            <form action="{{route('register.client')}}" method="post">
                @csrf
                <h5>Company Owner Information</h5>
                <div class="field-row">
                   <x-form-input name="first_name" id="first_name" label="First Name"></x-form-input>
                   <x-form-input name="last_name" id="last_name" label="Last Name"></x-form-input>
                </div>
                {{--                tin and industry--}}
                <div class="field-row">
                    <x-form-input name="tin_number" id="tin_number" label="TIN" placeholder="9-12 digits"></x-form-input>
                    <x-form-input name="industry" id="industry" label="Industry" placeholder="e.g. Finance"></x-form-input>
                </div>

                {{--                company Information--}}
                <h5>Company Information</h5>

                <div class="field-row">
                  <x-form-input name="company_name" id="company_name" label="Company Name"></x-form-input>
                </div>
                <h5>Residential Address</h5>
                {{-- country & region --}}
                <div class="field-row">
                    <x-form-select name="country" id="country" label="Country" required :options="['philippines' => 'Philippines']" value="philippines"></x-form-select>
                    <x-form-select name="region" id="region" label="Region" required>Select Region</x-form-select>
                </div>

                {{-- province & zip --}}
                <div class="field-row">
                    <x-form-select name="province" id="province" label="Province" required>Select Province</x-form-select>
                    <x-form-input name="zip" id="zip" label="Postal code"  placeholder="e.g. 6800" required></x-form-input>
                </div>

                {{-- city & barangay --}}
                <div class="field-row">
                    <x-form-select name="city" id="city" label="City" required>Select City / Municipality</x-form-select>
                    <x-form-select name="barangay" id="barangay" label="Barangay" required>Select Barangay</x-form-select>
                </div>

                {{-- street & building number --}}
                <div class="field-row">
                    <x-form-input name="street" id="street" label="Street" placeholder="e.g. Dalia" required ></x-form-input>
                    <x-form-input name="house_number" id="house_number" label="House/Unit Number" placeholder="1AB" required></x-form-input>
                </div>

               <x-button-submit>Add Client</x-button-submit>
            </form>
        </div>
    </section>
</x-app>
