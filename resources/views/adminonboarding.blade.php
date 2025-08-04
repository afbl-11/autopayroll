<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AutoPayroll Admin Onboarding</title>
         @vite(['resources/css/aostyle.css', 'resources/js/app.js'])
</head>
<body>
    <div class = "logo">
        <span class="auto">Auto</span><span class="payroll">Payroll</span>
    </div>
  <div class ="container">
    <form class="form">
        <div class="head">
            <div class="a1">
                <label for= "fn">First Name <span class="required">*</span></label><br>
                <input type="text" id="fname" name="fname" required />
            </div>
            <div class="a2">
                <label for= "ln">Last Name <span class="required">*</span></label><br>
                <input type="text" id="lname" name="lname" required />
            </div>    
        </div>
        <div class = "row">
            <label for="role">Role <span class="required">*</span></label><br><br>
            <select name="role" id="role" required />
                <option value="admin">Admin</option>
                <option value="hr">HR</option>
            </select>
        </div>
        
        <div class="g1">
            <label for= "cn">Company Name <span class="required">*</span></label> <br>
            <input type="text" id="cname" name="cname" required />
            </div>
        <div class="g2">
            <label for= "fn">Company Address <span class="required">*</span></label> <br>
            <input type="text" id="address" name="address" required />
        </div>
        <div class="g3">
            <label for="email">Email <span class="required">*</span></label> <br>
             <input type="email" id="email" required />
            </div>
        <div class="g4">
            <label for="password">Password <span class="required">*</span></label> <br>
            <input type="password" id="password" required />
            <span class="toggleEye" onclick="togglePassword()">👁</span> 
        </div>


        <button type ="submit" class="start">Start</button>
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
