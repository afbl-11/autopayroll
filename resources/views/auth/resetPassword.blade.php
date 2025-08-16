<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AutoPayroll Authentication</title>
         @vite(['resources/css/auth/resetPassword.css', 'resources/js/app.js'])
</head>
<body>
    <div class = "logo">
        <span class="auto">Auto</span><span class="payroll">Payroll</span>
    </div>
  <div class ="container">
    <h2>Reset Your Password</h2>
    <p>Please enter a new password</p>
    <form id = "resetForm" class="form">
        <div class="p1">
            <label for="password">New Password </label> <br>
            <div class="wrapper">
            <input type="password" id="password" required />
            <span class="toggleEye" onclick="togglePassword()">👁</span> <br> 
            </div>
            <small id="passwordError" class="error"></small>
            </div>
        <div class="p2">
            <label for="password2">Confirm Password </label> <br>
            <div class = "wrapper2">
            <input type="password" id="password2" required />
            <span class="toggleEye2" onclick="togglePassword2()">👁</span> <br>
            </div>
            <small id="confirmError" class="error"></small> 
        </div>
        <div class="actions">
        <button class="cancel" onclick="cancel()">Cancel</button>
        <button class="continue" onclick="submitCode()">Continue</button>
        </div>
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
    function togglePassword2() {
    const passwordInput = document.getElementById("password2");
    const icon = document.querySelector(".toggleEye2");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        icon.textContent = "⌣"; 
    } else {
        passwordInput.type = "password";
        icon.textContent = "👁";
    }
    }
    document.getElementById('resetForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const password = document.getElementById('password').value;
        const confirm = document.getElementById('password2').value;

        let valid = true;

        const passwordError = document.getElementById('passwordError');
        const passwordInput = document.getElementById('password');
        const specialCharRegex = /[^A-Za-z0-9]/;

        if (password.length < 8 || !specialCharRegex.test(password)) {
            passwordError.textContent = "Password must be 8+ characters and include a special character.";
            passwordInput.classList.add('error-input');
            valid = false;
        } else {
            passwordError.textContent = "";
            passwordInput.classList.remove('error-input');
        }

        const confirmError = document.getElementById('confirmError');
        const confirmInput = document.getElementById('password2');
        if (password !== confirm) {
            confirmError.textContent = "Password doesn't match.";
            confirmInput.classList.add('error-input');
            valid = false;
        } else {
            confirmError.textContent = "";
            confirmInput.classList.remove('error-input');
        }

        if (valid) {
            alert("Password reset successful!");
        }
    });
 </script>
</body>
</html>
