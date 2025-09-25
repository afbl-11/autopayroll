<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AutoPayroll Authentication</title>
         @vite(['resources/css/auth/auth.css', 'resources/js/app.js', "resources/css/theme.css"])
</head>
<body>
    <div class = "logo">
        <span class="auto">Auto</span><span class="payroll">Payroll</span>
    </div>
  <div class ="container">
    <h1 class ="header">Welcome Back!</h1>

    <form class="form" action="{{route('login.admin')}}" method="post" >
        @csrf
        <div class="l1">
            <label for= "email">Email or Username </label> <br>
            <input type="text" name="email" id="email" required />
            @error('email')
            <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="l2">
            <label for="password">Password </label> <br>
                <div class = "wrapper">
                    <input type="password" name="password" id="password" required />
                    <span class="toggleEye" onclick="togglePassword()">👁</span> <br>
                </div>
            <a class = "forgot" href="./authverify.blade.php">Forgot Password?</a>
        </div>

        <button type ="submit" class="signIn" >Sign In</button>
    </form>

  </div>
  <script>
    function togglePassword() {
    const passwordInput = document.getElementById("password");
    const icon = document.querySelector(".toggleEye");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        icon.textContent = "⌣";
    } else {
        passwordInput.type = "password";
        icon.textContent = "👁";
    }
}
 </script>
</body>
</html>
