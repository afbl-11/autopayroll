<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome to Autopayroll</title>
    @vite(['resources/css/theme.css','resources/css/auth/registrationSuccess.css'])
</head>
<body>
    <nav>
        <h1 class="logo" id="logo">Auto<span>Payroll</span></h1>
    </nav>
    <div class="container">
{{--        should have an image beside welcome--}}
        <h3>We’re thrilled to have you at AutoPayroll!</h3>
        <div class="welcome-message">
            <h6>Your account has been created successfully. We’re excited to help you save time and streamline your payroll process.</h6>
        </div>
        <div class="wrapper">
            <small>Didn't receive the email? Click to resend</small>
            <form action="{{route('verification.send')}}" method="post">
                @csrf
                <button type="submit" class="button-filled">Resend Email</button>
            </form>
        </div>

    </div>

{{--TODO: make this appear after new admin login--}}
</body>
</html>
