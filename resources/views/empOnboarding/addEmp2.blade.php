<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AutoPayroll Employee Onboarding</title>
         @vite(['resources/css/empOnboarding/addEmp2.css', 'resources/js/empOnboarding/addEmp.js'])
</head>
<body>
  @include('layout.sidebar')
  <div class ="container">
    <div class = "header"><img onclick="" src="{{ asset('images/left-arrow.png') }}"><h2>Add Employee</h2></div>
    @include('layout.steps', ['step' => 2])
    <form class="form" action="" method="POST">
    <div class = "content">
        <div class="residentialAddress formGroup">
                <label for= "fn">Residential Address <span class="required">*</span></label><br>
                <input type="text" id="residentialAddress" name="residentialAddress" placeholder="Residential Address" required />
            </div>

        <div class="addressId formGroup">
                <label for= "fn">Address on ID <span class="required">*</span></label><br>
                <input type="text" id="addressId" name="addressId" placeholder="Address on ID" required />
            </div>

        <div class = "row">
            <div class="personalContactNum formGroup">
                <label for= "personalContactNum">Personal Contact Number <span class="required">*</span></label><br>
                <input type="number" id="personalContactNum" name="personalContactNum" placeholder="Personal Contact Number" required />
            </div>
            <div class="email formGroup">
                <label for="email">Email <span class="required">*</span></label> <br>
                <input type="email" id="email" name="email" placeholder="Email" required />
            </div>    
        </div>
        <div class="otherContactNum formGroup">
                <label for= "otherContactNum">Other Contact </label><br>
                <input type="number" id="otherContactNum" name="otherContactNum" placeholder="Other Contact Number (Optional)" />
            </div>
    </div>
        <button type ="submit" class="next">Next</button>
    </form> 
  </div>
</body>
</html>