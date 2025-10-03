<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verify Email</title>
    @vite(['resources/css/theme.css','resources/css/auth/verify-email.css'])
</head>
<body>
    <nav>
        <div class="logo"><h1 id="logo">Auto<span>Payroll</span></h1></div>
    </nav>

    <div class="container">
        <div class="verify-message">
            <h2>Verify your email address</h2>
            <p>You entered <span id="email">example@email.com</span> as your account email address.</p>
            <p>Please check your account to complete verification.</p>
            <form action="{{route('verification.send')}}" method="post">
                @csrf
                <div class="button-group">
                    <button type="submit" class="button-filled">Resend email</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

