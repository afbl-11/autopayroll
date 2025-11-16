 @vite([
      'resources/css/employee_registration/address.css',
      'resources/js/api/address-picker.js',
      'resources/js/api/address-sync.js',
      'resources/js/empOnboarding/addEmp.js',
      'resources/js/address-retrieve.js',
    ])
<x-app :title="$title" :showProgression="true">
    <section class="main-content">
            <div class="form-wrapper">
                <form action="{{route('store.employee.register.2')}}" method="post">
                    @csrf
                    <div class="form-container">

                        <h5>Residential Address</h5>
                        {{-- country & region --}}
                        <div class="field-row">
                            <x-form-select name="country" id="country" label="Country" required :options="['Philippines' => 'Philippines']" value="philippines"></x-form-select>
                            <x-form-select name="region" id="region" label="Region" required>Select Region</x-form-select>
                            <input type="hidden" name="region_name" id="region_name">
                        </div>

                        {{-- province & zip --}}
                        <div class="field-row">
                            <x-form-select name="province" id="province" label="Province" required>Select Province</x-form-select>
                            <x-form-input name="zip" id="zip" label="Postal code"  placeholder="e.g. 6800" required></x-form-input>
                            <input type="hidden" name="province_name" id="province_name">
                        </div>

                        {{-- city & barangay --}}
                        <div class="field-row">
                            <x-form-select name="city" id="city" label="City" required>Select City / Municipality</x-form-select>
                            <input type="hidden" name="city_name" id="city_name">
                            <x-form-select name="barangay" id="barangay" label="Barangay" required>Select Barangay</x-form-select>
                            <input type="hidden" name="barangay_name" id="barangay_name">
                        </div>

                        {{-- street & building number --}}
                        <div class="field-row">
                            <x-form-input name="street" id="street" label="Street" placeholder="e.g. Dalia" required ></x-form-input>
                            <x-form-input name="house_number" id="house_number" label="House/Unit Number" placeholder="1AB" required></x-form-input>
                        </div>

                        <h5>Contact Information</h5>
{{--                        phone number and email--}}
                        <div class="field-row">
                          <x-form-input type="tel" name="phone_number" id="phone_number" label="Phone Number" placeholder="e.g. 09276544387" required></x-form-input>
                          <x-form-input type="email" name="email" id="email" label="Email" ></x-form-input>
                        </div>

                        <h5>Address on ID</h5>
        {{--                check box--}}
                        <div class="check-box">
                            <input type="checkbox" name="same_address" id="same_address">
                            <label for="same_address">Same on Residential Address</label>
                        </div>
                        {{-- country & region --}}
                        <div class="field-row">
                            <x-form-select name="id_country" id="id_country" label="Country" :options="['Philippines' => 'Philippines']" value="philippines" required></x-form-select>
                            <x-form-select name="id_region" id="id_region" label="Region"></x-form-select>
                        </div>

                        {{-- province & zip --}}
                        <div class="field-row">
                           <x-form-select name="id_province" id="id_province" label="Province" required>Select Province</x-form-select>
                            <x-form-input name="id_zip" id="id_zip" label="Postal Code" required placeholder="e.g. 6800"></x-form-input>
                            <input type="hidden" name="id_province_name" id="id_province_name">
                        </div>

                        {{-- city & barangay --}}
                        <div class="field-row">
                            <x-form-select name="id_city" id="id_city" label="City" required>Select City/Municipality</x-form-select>
                            <input type="hidden" name="id_city_name" id="id_city_name">
                            <x-form-select name="id_barangay" id="id_barangay" label="Barangay" required>Select Barangay</x-form-select>
                            <input type="hidden" name="id_barangay_name" id="id_barangay_name">


                        </div>

                        {{-- street & building number --}}
                        <div class="field-row">
                            <x-form-input name="id_street" id="id_street" label="Street" placeholder="e.g. Dalia" required ></x-form-input>
                            <x-form-input name="id_house_number" id="id_house_number" label="House/Unit Number" placeholder="1AB" required></x-form-input>
                        </div>

                    <x-button-submit>Continue</x-button-submit>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-app>
