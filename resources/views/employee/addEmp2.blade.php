 @vite([
        'resources/css/employee_registration/address.css',
        'resources/js/empOnboarding/addEmp.js',
        'resources/js/api/employee-address.js',


    ])
<x-app :title="$title" :showProgression="false">
    <section class="main-content">
            <div class="form-wrapper">
                <form action="{{route('store.employee.register.2')}}" method="post">
                    @csrf
                    <div class="form-container">

                        <h5>Residential Address</h5>
                        {{-- country & region --}}
                        <div class="field-row">
                            <x-form-select name="country" id="country" label="Country" required :options="['Philippines' => 'Philippines']" selected="{{ old('country', 'Philippines') }}"></x-form-select>
                            <x-form-select name="region" id="region" label="Region" required :selected="old('region')">Select Region</x-form-select>
                            <input type="hidden" name="region_name" id="region_name" value="{{ old('region_name') }}">
                        </div>

                        {{-- province & zip --}}
                        <div class="field-row">
                            <x-form-select name="province" id="province" label="Province" required :selected="old('province')">Select Province</x-form-select>
                            <x-form-input name="zip" id="zip" label="Postal code" placeholder="e.g. 6800" required :value="old('zip')"></x-form-input>
                            <input type="hidden" name="province_name" id="province_name" value="{{ old('province_name') }}">
                        </div>

                        {{-- city & barangay --}}
                        <div class="field-row">
                            <x-form-select name="city" id="city" label="City" required :selected="old('city')">Select City / Municipality</x-form-select>
                            <input type="hidden" name="city_name" id="city_name" value="{{ old('city_name') }}">
                            <x-form-select name="barangay" id="barangay" label="Barangay" required :selected="old('barangay')">Select Barangay</x-form-select>
                            <input type="hidden" name="barangay_name" id="barangay_name" value="{{ old('barangay_name') }}">
                        </div>

                        {{-- street & building number --}}
                        <div class="field-row">
                            <x-form-input name="street" id="street" label="Street" placeholder="e.g. Dalia" required :value="old('street')"></x-form-input>
                            <x-form-input name="house_number" id="house_number" label="House/Unit Number" placeholder="1AB" required :value="old('house_number')"></x-form-input>
                        </div>

                        <h5>Contact Information</h5>
{{--                        phone number and email--}}
                        <div class="field-row">
                          <x-form-input type="tel" name="phone_number" id="phone_number" label="Phone Number" placeholder="e.g. 09276544387" required :value="old('phone_number')"></x-form-input>
                          <x-form-input type="email" name="email" id="email" label="Email" :value="old('email')"></x-form-input>
                        </div>

                        <h5>Address on ID</h5>
        {{--                check box--}}
                        <div class="check-box">
                            <input type="checkbox" name="same_address" id="same_address">
                            <label for="same_address">Same on Residential Address</label>
                        </div>
                        {{-- country & region --}}
                        <div class="field-row">
                            <x-form-select name="id_country" id="id_country" label="Country" :options="['Philippines' => 'Philippines']" required :selected="old('id_country', 'Philippines')"></x-form-select>
                            <x-form-select name="id_region" id="id_region" label="Region" :selected="old('id_region')"></x-form-select>
                            <input type="hidden" name="id_region_name" id="id_region_name" value="{{ old('id_region_name') }}">
                        </div>

                        {{-- province & zip --}}
                        <div class="field-row">
                           <x-form-select name="id_province" id="id_province" label="Province" required :selected="old('id_province')">Select Province</x-form-select>
                            <x-form-input name="id_zip" id="id_zip" label="Postal Code" required placeholder="e.g. 6800" :value="old('id_zip')"></x-form-input>
                            <input type="hidden" name="id_province_name" id="id_province_name" value="{{ old('id_province_name') }}">
                        </div>

                        {{-- city & barangay --}}
                        <div class="field-row">
                            <x-form-select name="id_city" id="id_city" label="City" required :selected="old('id_city')">Select City/Municipality</x-form-select>
                            <input type="hidden" name="id_city_name" id="id_city_name" value="{{ old('id_city_name') }}">
                            <x-form-select name="id_barangay" id="id_barangay" label="Barangay" required :selected="old('id_barangay')">Select Barangay</x-form-select>
                            <input type="hidden" name="id_barangay_name" id="id_barangay_name" value="{{ old('id_barangay_name') }}">


                        </div>

                        {{-- street & building number --}}
                        <div class="field-row">
                            <x-form-input name="id_street" id="id_street" label="Street" placeholder="e.g. Dalia" required :value="old('id_street')"></x-form-input>
                            <x-form-input name="id_house_number" id="id_house_number" label="House/Unit Number" placeholder="1AB" required :value="old('id_house_number')"></x-form-input>
                        </div>

                    <x-button-submit>Continue</x-button-submit>
                    </div>
                </form>
            </div>
    </section>
</x-app>

