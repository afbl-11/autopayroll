<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AutoPayroll Admin Onboarding</title>
    @vite(['resources/css/onboarding/admin-onboarding.css', 'resources/js/api/address-picker.js', 'resources/css/theme.css'])


</head>
<body>
    <div class="container" >
        <div class="logo">
            <h1 id="logo">Auto<span>Payroll</span></h1>
        </div>
        <div class="form-container">
            <form action="{{route('admin.register')}}" method="post">
                @csrf
                 <h6>Personal Information</h6>

                <div class="field-row">
                    <div class="field-input">
                        <label for="first_name">First name</label>
                        <input type="text" name="first_name" id="first_name" required>
                    </div>
                    <div class="field-input">
                        <label for="last_name">Last name</label>
                        <input type="text" name="last_name" id="last_name" required>
                    </div>
                </div>
{{--                email and role--}}
                <div class="field-row">
                    <div class="field-input">
                        <label for="tin">Tax Identification Number</label>
                        <input type="text" name="tin" id="tin" required>
                    </div>
                    <div class="field-input">
                        <label for="role">Role</label>
                        <select name="role" id="role" required>
                            <option value="">Select a Role</option>
                            <option value="admin">Admin</option>
                            <option value="hr">HR</option>
                        </select>
                    </div>
                </div>
{{--                password--}}
                <div class="field-row">
                    <div class="field-input">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" required>
                    </div>
                    <div class="field-input auto">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" required>
                    </div>
                </div>
{{--                company Information--}}
                <h6>Company Information</h6>

                <div class="field-row">
                    <div class="field-input">
                        <label for="company_name">Company Name</label>
                        <input type="text" name="company_name" id="company-name" required>
                    </div>
                </div>
{{--country and region--}}
                <div class="field-row">
                    <div class="field-input">
                        <label for="country">Country</label>
                        <select name="country" id="country" required>
                            <option value="">Select Country</option>
                            <option value="philippines">Philippines</option>
                        </select>
                    </div>
                    <div class="field-input">
                        <label for="region">Region</label>
                        <select name="region" id="region" required>
                            <option value="">Select Region</option>
                        </select>
                    </div>
                </div>
{{--                    province and zip code--}}
                <div class="field-row">
                    <div class="field-input">
                        <label for="province">Province</label>
                        <select name="province" id="province" required>
                            <option value="">Select Province</option>
                        </select>
                    </div>
                    <div class="field-input">
                        <label for="zip">Zip Code</label>
                        <input type="text" name="zip" id="zip-code" required>
                    </div>
                </div>
{{--                city and barangay--}}
                <div class="field-row">
                    <div class="field-input">
                        <label for="city">City / Municipality</label>
                        <select name="city" id="city" required>
                            <option value="">Select City / Municipality</option>
                        </select>
                    </div>
                    <div class="field-input">
                        <label for="barangay">Barangay</label>
                        <select name="barangay" id="barangay" required>
                            <option value="">Select Barangay</option>
                        </select>
                    </div>
                </div>
{{--                street and unit number--}}
                <div class="field-row">
                    <div class="field-input">
                        <label for="street">Street</label>
                        <input type="text" name="street" id="street" required>
                    </div>
                    <div class="field-input">
                        <label for="house_number">Unit / Building no.</label>
                        <input type="text" name="house_number" id="house-number" required>
                    </div>
                </div>

                <button type="submit" class="button-filled">Start</button>
            </form>
        </div>
    </div>

{{--TODO: set Tin number max num: 12
    TODO: password reveal
    TODO: password validation - front-end
     --}}


</body>
</html>
