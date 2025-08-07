<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AutoPayroll Employee Onboarding</title>
         @vite(['resources/css/addEmp4.css', 'resources/js/app.js'])
</head>
<body>
    <div class = "sidebar">
        <div class="logo"><span class="a">A</span><span class="p">P</span></div>
        <nav>
            <ul>
                <li><a href="#"><img src="{{ asset('images/home.png') }}" id="img1"><span><p>Home</p></span></a></li>
                <li><a href="#"><img src="{{ asset('images/emp.png') }}"><span><p>Employee</p></span></a></li>
                <li><a href="#"><img src="{{ asset('images/compliance.png') }}"><span><p>Compliance</p></span></a></li>
                <li><a href="#"><img src="{{ asset('images/notif.png') }}"><span><p>Notifications</p></span></a></li>
                <li><a href="#"><img src="{{ asset('images/admin.png') }}"><span><p>Admin</p></span></a></li>
            </ul>
        </nav>
    </div>
    
  <div class ="container">
    <div class = "header"><a href="{{ route('addEmp3') }}"><img src="{{ asset('images/left-arrow.png') }}"></a><h2>Add Employee</h2></div>
    <div class="steps-div">
        <div class="steps"><div class="icon"><img src="{{ asset('images/verified.png') }}"></div><div class="step-no">Step 1</div><div class="desc">Basic Information</div></div>
        <div class="lines"><h1>____</h1></div>
        <div class="steps"><div class="icon"><img src="{{ asset('images/verified.png') }}"></div><div class="step-no">Step 2</div><div class="desc">Contact & Address</div></div>
        <div class="lines"><h1>____</h1></div>
        <div class="steps"><div class="icon"><img src="{{ asset('images/verified.png') }}"></div><div class="step-no">Step 3</div><div class="desc">Employment Overview</div></div>
        <div class="lines"><h1>____</h1></div>
        <div class="steps"><div class="icon"><img src="{{ asset('images/verified.png') }}"></div><div class="step-no">Step 4</div><div class="desc">Account Setup</div></div>
        <div class="lines"><h1>____</h1></div>
        <div class="steps"><div class="icon"><img src="{{ asset('images/notVerified.png') }}"></div><div class="step-no">Step 5</div><div class="desc">Review Details</div></div>
        
    </div>
    <form class="form" action="{{ route('addEmp5') }}" method="GET">
    <div class = "content">
        <div class="email">
                <label for="email">Email <span class="required">*</span></label> <br>
                <input type="email" id="email" required />
        </div>

        <div class="empId">
                <label for= "fn">Employee Identification Number </label><br>
                <input type="number" id="empId" name="empId" required />
        </div>

        <div class="password">
            <label for="password">Password </label> <br>
            <div class = "wrapper">
            <input type="password" id="password" required />
            <span class="toggleEye" onclick="togglePassword()">👁</span> <br> 
            </div>
        </div>

    </div>
        <button type ="submit" class="next">Next</button>
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
