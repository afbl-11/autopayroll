<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AutoPayroll Authentication</title>
         @vite(['resources/css/auth/authVerify.css', 'resources/js/app.js'])
</head>
<body>
    <div class = "logo">
        <span class="auto">Auto</span><span class="payroll">Payroll</span>
    </div>
  <div class ="container">
    <h2>Enter Verification Code</h2>
    <p>We've sent a code to <strong>blank@gmail.com</strong></p>
    <div class="otp">
        <input type="text" maxlength="1" inputmode="numeric" />
        <input type="text" maxlength="1" inputmode="numeric" />
        <input type="text" maxlength="1" inputmode="numeric" />
        <input type="text" maxlength="1" inputmode="numeric" />
        <input type="text" maxlength="1" inputmode="numeric" />
        <input type="text" maxlength="1" inputmode="numeric" />
    </div>
    <div class="resend">Didn't receive a code? <strong><a onclick="resendCode()">Click to resend.</a></strong></div>
    <div class="actions">
        <button class="cancel" onclick="cancel()">Cancel</button>
        <button class="continue" onclick="submitCode()">Continue</button>
    </div>
  </div>
  <script>
    const inputs = document.querySelectorAll('.otp input');
    inputs.forEach((input,index) => {
        input.addEventListener('input', () => {
            if (input.value.length > 0 && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !input.value && index > 0) {
                inputs[index - 1].focus();
            }
        });
    });
 </script>
</body>
</html>
