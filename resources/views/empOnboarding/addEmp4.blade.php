<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AutoPayroll Employee Onboarding</title>
         @vite(['resources/css/empOnboarding/addEmp4.css', 'resources/js/empOnboarding/addEmp.js'])
</head>
<body>
  @include('layout.sidebar')
  <div class ="container">
    <div class = "header"><img onclick="" src="{{ asset('images/left-arrow.png') }}"><h2>Add Employee</h2></div>
    @include('layout.steps', ['step' => 4])
    <form class="form" action="" method="POST">
    <div class = "content">
        <div class="email formGroup">
                <label for="email">Email <span class="required">*</span></label><br>
                <input type="email" id="email" placeholder="Email" required />
        </div>

        <div class="empId formGroup">
                <label for= "fn">Employee Identification Number <span class="required">*</span></label><br>
                <input type="number" id="empId" name="empId" placeholder="Employee ID Number" required />
        </div>

        <div class="password formGroup">
            <label for="password">Password <span class="required">*</span></label><br>
            <div class = "wrapper">
            <input type="password" id="password" placeholder="Password" required />
            <span class="toggleEye" onclick="togglePassword()">👁</span> <br> 
            </div>
        </div>
    </div>
        <button type ="submit" class="next">Next</button>
    </form> 
  </div>
</body> 
</html>