<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AutoPayroll Employee Onboarding</title>
         @vite(['resources/css/empOnboarding/addEmp1.css', 'resources/js/app.js'])
</head>
<body>
  @include('layout.sidebar')
  <div class ="container">
    <div class = "header"><a href="#"><img src="{{ asset('images/left-arrow.png') }}"></a><h2>Add Employee</h2></div>
    <div class="steps-div">
        <div class="steps"><div class="icon"><img src="{{ asset('images/verified.png') }}"></div><div class="step-no">Step 1</div><div class="desc">Basic Information</div></div>
        <div class="lines"><h1>____</h1></div>
        <div class="steps"><div class="icon"><img src="{{ asset('images/notVerified.png') }}"></div><div class="step-no">Step 2</div><div class="desc">Contact & Address</div></div>
        <div class="line"><h1>____</h1></div>
        <div class="steps"><div class="icon"><img src="{{ asset('images/notVerified.png') }}"></div><div class="step-no">Step 3</div><div class="desc">Employment Overview</div></div>
        <div class="line"><h1>____</h1></div>
        <div class="steps"><div class="icon"><img src="{{ asset('images/notVerified.png') }}"></div><div class="step-no">Step 4</div><div class="desc">Account Setup</div></div>
        <div class="line"><h1>____</h1></div>
        <div class="steps"><div class="icon"><img src="{{ asset('images/notVerified.png') }}"></div><div class="step-no">Step 5</div><div class="desc">Review Details</div></div>
    </div>
    <form class="form" action="" method="GET">
    <div class = "content">
        <div class="head">
            <div class="firstName">
                <label for= "firstName">First Name <span class="required">*</span></label><br>
                <input type="text" id="firstName" name="firstName" required />
            </div>
            <div class="middleName">
                <label for= "middleName">Middle Name</label><br>
                <input type="text" id="middleName" name="middleName" placeholder="Optional" />
            </div>    
        </div>
        <div class = "row">
            <div class="lastName">
                <label for= "lastName">Last Name <span class="required">*</span></label><br>
                <input type="text" id="lastName" name="lastName" required />
            </div>
            <div class = "suffix">
                <label for="suffix">Suffix</label><br>
                <select name="suffix" id="suffix" required />
                    <option value="sr">Sr.</option>
                    <option value="jr">Jr.</option>
                    <option value="third">III</option>
                </select>
            </div>
        </div>
        
        <div class="place-Of-birth">
            <label for= "placeOfbirth">Place of Birth <span class="required">*</span></label> <br>
            <input type="text" id="placeOfbirth" name="placeOfbirth" required />
            </div>
        
        <div class = "row">
            <div class="date-Of-birth">
                <label for= "dateOfbirth">Date of Birth</label><br>
                <input type="date" id="date-Of-birth" name="date-Of-birth" />
            </div>

            <div class="age">
                <label for="age">Age</label><br>
                <input type="number" id="age" name="age" />
            </div>    
        </div>
        <div class="row">
            <div class = "gender">
                <label for="gender">Gender</label><br>
                <select name="gender" id="gender" />
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
            <div class = "marital-status">
                <label for="marital-status">Marital Status</label><br>
                <select name="marital-status" id="marital-status" />
                    <option value="single">Single</option>
                    <option value="married">Married</option>
                </select>
            </div>
        </div>
            <div class = "blood-type">
                <label for="blood-type">Blood Type</label><br>
                <select name="blood-type" id="blood-type" />     <!-- tinanggal ko yung mga required sa iba kasi sinunod ko design sa figma. -->
                    <option value="blood-type-1">A+</option>
                    <option value="blood-type-2">A-</option>
                    <option value="blood-type-3">B+</option>
                    <option value="blood-type-4">B-</option>
                    <option value="blood-type-5">O+</option>
                    <option value="blood-type-6">O-</option>
                    <option value="blood-type-7">AB+</option>
                    <option value="blood-type-8">AB-</option>
                </select>
            </div>
        </div>
        <button type ="submit" class="next">Next</button>
    </form> 
  </div>
  <script>
    document.getElementById('date-Of-birth').addEventListener('blur', function() {
        const dateOfbirth = new Date(this.value);
        if (isNaN(dateOfbirth)) return;
        
        const today = new Date();

        if (dateOfbirth > today) {
            document.getElementById('age').value = '';
            alert("Date of birth cannot be in the future.");
            return;
        }

        const date = Date.now() - dateOfbirth.getTime();
        const ageDate = new Date(date);
        const age = Math.abs(ageDate.getUTCFullYear() - 1970);
        document.getElementById('age').value = age;

        if (age < 15) {
            document.getElementById('date-Of-birth').value = '';
            document.getElementById('age').value = '';
            alert("The hired employee does not meet the required minimum age standards for employment.");
            return;
        }
        
        if (age > 65) {
            document.getElementById('date-Of-birth').value = '';
            document.getElementById('age').value = '';
            alert("The hired employee is beyond the suitable age range for employment."); //inassume ko lang ito sa age range.
            return;
        }
    });

    document.getElementById('age').addEventListener('change', function() {
       const dateOfbirthInput = document.getElementById('date-Of-birth');

       if (!dateOfbirthInput.value.trim()) {
          alert("Please enter the employee's date of birth first.");
          this.value = '';
          dateOfbirthInput.focus();
          return;
       }

    });

 </script>
</body>
</html>

