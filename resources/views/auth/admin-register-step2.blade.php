<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Account Creation | Address</title>
    @vite(['resources/css/theme.css', 'resources/css/admin_registration/admin_dashboard-step2.css', 'resources/js/api/address-picker.js'])
</head>
<body>
<div class="logo">
    <h1 id="logo">Auto<span>Payroll</span></h1>
</div>
<div class="container">
<div class="form-container">
    <form action="{{route('admin_dashboard.register')}}" method="post">
        @csrf
        <h6>Company Information</h6>
        <div class="field-row">
            <div class="field-input">
                <label for="company_name">Company Name</label>
                <input type="text" name="company_name" id="company-name">
            </div>
        </div>
{{--        country & region--}}
        <div class="field-row">
            <div class="field-input">
                <label for="country">Country</label>
                <select name="country" id="country">
                    <option value="">Select Country</option>
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
{{--        province & zip--}}
        <div class="field-row">
            <div class="field-input">
                <label for="province">Province</label>
                <select name="province" id="province">
                    <option value="">Select Province</option>
                </select>
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
            </div>
            <div class="field-input">
                <label for="barangay">Barangay</label>
                <select name="barangay" id="barangay">
                    <option value="">Select Barangay</option>
                </select>
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
        <button type="submit" class="button-filled">Create Account</button>

    </form>
</div>
</div>
</body>
</html>
