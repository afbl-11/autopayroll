<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AutoPayroll Employee Onboarding</title>
    @vite([
      'resources/css/theme.css',
      'resources/css/employee_registration/addEmp2.css',
      'resources/js/api/address-picker.js',
      'resources/js/api/address-sync.js',
      'resources/js/empOnboarding/addEmp.js',
      'resources/js/address-retrieve.js',
    ])
</head>
<body>
<nav>
    <a href="{{route('store.employee.register.1')}}"><img src="{{asset('assets/employeeProfile/BackArrow.png')}}" alt=""></a>
    <h4>Add Employee</h4>
</nav>

<div class="container">
    <div class="content">
        @include('partitions.steps', ['step' => 2])
        <form action="{{route('store.employee.register.2')}}" method="post">
            @csrf
            <div class="form-container">

                <h5>Residential Address</h5>
                {{-- country & region --}}
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
                    </div>
                </div>

                {{-- province & zip --}}
                <div class="field-row">
                    <div class="field-input">
                        <label for="province">Province</label>
                        <select name="province" id="province">
                            <option value="">Select Province</option>
                        </select>
                    </div>
                    <div class="field-input">
                        <label for="zip">Postal Code</label>
                        <input type="text" name="zip" id="zip">
                    </div>
                </div>

                {{-- city & barangay --}}
                <div class="field-row">
                    <div class="field-input">
                        <label for="city">City / Municipality</label>
                        <select name="city" id="city">
                            <option value="">Select City / Municipality</option>
                        </select>
                    </div>
                    <div class="field-input">
                        <label for="barangay">Barangay</label>
                        <select name="barangay" id="barangay">
                            <option value="">Select Barangay</option>
                        </select>
                    </div>
                </div>

                {{-- street & building number --}}
                <div class="field-row">
                    <div class="field-input">
                        <label for="street">Street</label>
                        <input type="text" name="street" id="street">
                    </div>
                    <div class="field-input">
                        <label for="house-number">Unit / Building no.</label>
                        <input type="text" name="house_number" id="house-number">
                    </div>
                </div>

                <h5>Contact Information</h5>
                <div class="field-row">
                    <div class="field-input">
                        <label for="phone_number">Personal Contact Number</label>
                        <input type="tel" name="phone_number" id="phone_number" required>
                    </div>
                    <div class="field-input">
                        <label for="email">Email Address (optional)</label>
                        <input type="email" name="email" id="email">
                    </div>
                </div>

                <h5>Address on ID</h5>
{{--                check box--}}
                <div class="check-box">
                    <input type="checkbox" name="same_address" id="same_address">
                    <label for="same_address">Same on Residential Address</label>
                </div>
                {{-- country & region --}}
                <div class="field-row">
                    <div class="field-input">
                        <label for="id_country">Country</label>
                        <select name="id_country" id="id_country">
                            <option value="philippines">Philippines</option>
                        </select>
                    </div>
                    <div class="field-input">
                        <label for="id_region">Region</label>
                        <select name="id_region" id="id_region">
                            <option value="">Select Region</option>
                        </select>
                    </div>
                </div>

                {{-- province & zip --}}
                <div class="field-row">
                    <div class="field-input">
                        <label for="id_province">Province</label>
                        <select name="id_province" id="id_province">
                            <option value="">Select Province</option>
                        </select>
                    </div>
                    <div class="field-input">
                        <label for="id_zip">Postal Code</label>
                        <input type="text" name="id_zip" id="id_zip">
                    </div>
                </div>

                {{-- city & barangay --}}
                <div class="field-row">
                    <div class="field-input">
                        <label for="id_city">City / Municipality</label>
                        <select name="id_city" id="id_city">
                            <option value="">Select City / Municipality</option>
                        </select>
                    </div>
                    <div class="field-input">
                        <label for="id_barangay">Barangay</label>
                        <select name="id_barangay" id="id_barangay">
                            <option value="">Select Barangay</option>
                        </select>
                    </div>
                </div>

                {{-- street & building number --}}
                <div class="field-row">
                    <div class="field-input">
                        <label for="id_street">Street</label>
                        <input type="text" name="id_street" id="id_street">
                    </div>
                    <div class="field-input">
                        <label for="id_house-number">Unit / Building no.</label>
                        <input type="text" name="id_house_number" id="id_house-number">
                    </div>
                </div>

            <button type="submit" class="button-filled">Continue</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
