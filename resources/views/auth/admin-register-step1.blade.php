<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AutoPayroll Admin Onboarding</title>
    @vite(['resources/css/admin_registration/admin-step1.css', 'resources/js/api/address-picker.js', 'resources/css/theme.css'])


</head>
<body>
        <div class="logo">
            <h1 id="logo">Auto<span>Payroll</span></h1>
        </div>
    <div class="container" >
        <div class="create-intro">

        </div>
        <div class="form-container">
            <div class="form-intro">
                <h4>Create Your Account</h4>
                <p>Let's get started with a few information</p>
            </div>
            <form action="{{route('auth.store.step1')}}" method="post">
                @csrf
{{--                first name--}}
                <div class="field-row">
                    <div class="field-input">
                        <label for="first_name">First name</label>
                        <input type="text" name="first_name" id="first_name" required>
                    </div>
                    <div class="field-input">
                        <label for="middle_name">Middle name</label>
                        <input type="text" name="middle_name" id="middle_name" required>
                    </div>
                </div>
{{--                last name and suffix--}}
                <div class="field-row">
                    <div class="field-input">
                        <label for="last_name">Last name</label>
                        <input type="text" name="last_name" id="last_name" required>
                    </div>
                    <div class="field-input">
                        <label for="suffix">Suffix</label>
                        <select name="suffix" id="suffix">
                            <option value="">None</option>
                            <option value="Sr.">Sr.</option>
                            <option value="Jr.">Jr.</option>
                        </select>
                    </div>
                </div>

{{--                email--}}
                <div class="field-row">
                    <div class="field-input">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" required>
                    </div>
                </div>
{{--                password--}}
                <div class="field-row">
                    <div class="field-input ">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" required>
                    </div>
{{--                    <div class="field-input ">--}}
{{--                        <label for="confirm_password">Confirm Password</label>--}}
{{--                        <input type="password" name="confirm_password" id="confirm-password" required>--}}
{{--                    </div>--}}
                </div>

                <button type="submit" class="button-filled">Continue</button>
            </form>
        </div>
    </div>

{{--
    TODO: password reveal
    TODO: password validation - front-end
    TODO: email verification
     --}}


</body>
</html>
