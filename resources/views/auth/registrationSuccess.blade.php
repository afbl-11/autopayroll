<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome to Autopayroll</title>
    @vite(['resources/css/theme.css'])
</head>
<body>
    <nav>
        <h1 class="logo" id="logo">Auto<span>Payroll</span></h1>
    </nav>
    <div class="container">
{{--        should have an image beside welcome--}}
        <h3>Welcome to AutoPayroll!!</h3>
        <h6>Your account has been created successfully. We’re excited to help you save time and streamline your payroll process.</h6>
        <p>Please verify email now to sign-in to your account.</p>
        <form action="{{route('login')}}" method="get">
            @csrf
            <button type="submit" class="button-filled">Verify email</button>
        </form>

    </div>
</body>
</html>
