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
      'resources/js/empOnboarding/addEmp.js'
    ])
</head>
<body>
<nav>
    <a href="{{route('employee.register')}}"><img src="{{asset('assets/employeeProfile/BackArrow.png')}}" alt=""></a>
    <h4>Add Employee</h4>
</nav>

<div class="container">
    <div class="content">
        @include('partitions.steps', ['step' => 2])
        <form action="{{route('employee.register.3')}}" method="get">
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
                        <label for="country2">Country</label>
                        <select name="country2" id="country2">
                            <option value="philippines">Philippines</option>
                        </select>
                    </div>
                    <div class="field-input">
                        <label for="region2">Region</label>
                        <select name="region2" id="region2">
                            <option value="">Select Region</option>
                        </select>
                    </div>
                </div>

                {{-- province & zip --}}
                <div class="field-row">
                    <div class="field-input">
                        <label for="province2">Province</label>
                        <select name="province2" id="province2">
                            <option value="">Select Province</option>
                        </select>
                    </div>
                    <div class="field-input">
                        <label for="zip2">Postal Code</label>
                        <input type="text" name="zip2" id="zip2">
                    </div>
                </div>

                {{-- city & barangay --}}
                <div class="field-row">
                    <div class="field-input">
                        <label for="city2">City / Municipality</label>
                        <select name="city2" id="city2">
                            <option value="">Select City / Municipality</option>
                        </select>
                    </div>
                    <div class="field-input">
                        <label for="barangay2">Barangay</label>
                        <select name="barangay2" id="barangay2">
                            <option value="">Select Barangay</option>
                        </select>
                    </div>
                </div>

                {{-- street & building number --}}
                <div class="field-row">
                    <div class="field-input">
                        <label for="street2">Street</label>
                        <input type="text" name="street2" id="street2">
                    </div>
                    <div class="field-input">
                        <label for="house-number2">Unit / Building no.</label>
                        <input type="text" name="house_number2" id="house-number2">
                    </div>
                </div>

            <button type="submit" class="button-filled">Continue</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
