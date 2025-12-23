@vite(['resources/css/admin_registration/change-location.css', 'resources/js/api/address-picker.js', 'resources/js/address-retrieve.js'])

<x-app :title="$title">
    <div class="container">
        <div class="form-container">
            <form action="{{route('change.location')}}" method="post">
                @csrf
                {{--        country & region--}}
                <div class="field-row">
                    <div class="field-input">
                        <label for="country">Country</label>
                        <select name="country" id="country">
                            <option value="philippines">Philippines</option>

                        </select>
                    </div>
                    <div class="field-input">
                        <label for="region">Region</label>
                        <select name="region" id="region">
                            <option value="">Select Region</option>
                        </select>
                        <input type="hidden" name="region_name" id="region_name">
                    </div>
                </div>
                {{--        province & zip--}}
                <div class="field-row">
                    <div class="field-input">
                        <label for="province">Province</label>
                        <select name="province" id="province">
                            <option value="">Select Province</option>
                        </select>
                        <input type="hidden" name="province_name" id="province_name">
                    </div>
                    <div class="field-input">
                        <label for="region">Postal Code</label>
                        <input type="text" name="zip" id="zip">
                    </div>
                </div>
                {{--        city & barangay--}}
                <div class="field-row">
                    <div class="field-input">
                        <label for="city">City / Municipality</label>
                        <select name="city" id="city">
                            <option value="">Select City / Municipality</option>
                        </select>
                        <input type="hidden" name="city_name" id="city_name">
                    </div>
                    <div class="field-input">
                        <label for="barangay">Barangay</label>
                        <select name="barangay" id="barangay">
                            <option value="">Select Barangay</option>
                        </select>
                        <input type="hidden" name="barangay_name" id="barangay_name">
                    </div>
                </div>
                {{--        street & building number--}}
                <div class="field-row">
                    <div class="field-input">
                        <label for="street">Street</label>
                        <input type="text" name="street" id="street">
                    </div>
                    <div class="field-input">
                        <label for="house_number">Unit / Building no.</label>
                        <input type="text" name="house_number" id="house-number">
                    </div>
                </div>
                <button type="submit" class="button-filled">Change Location</button>

            </form>
        </div>
    </div>
</x-app>
