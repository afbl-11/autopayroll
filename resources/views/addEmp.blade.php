<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AutoPayroll Employee Onboarding</title>
         @vite(['resources/css/addEmp.css', 'resources/js/app.js'])
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
    <form class="form" action="{{ route('addEmp2') }}" method="GET">
    <div class = "content">
        <div class="head">
            <div class="fn">
                <label for= "fn">First Name <span class="required">*</span></label><br>
                <input type="text" id="fname" name="fname" required />
            </div>
            <div class="mn">
                <label for= "mn">Middle Name</label><br>
                <input type="text" id="mname" name="mname" placeholder="Optional" />
            </div>    
        </div>
        <div class = "row">
            <div class="ln">
                <label for= "ln">Last Name <span class="required">*</span></label><br>
                <input type="text" id="lname" name="lname" />
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
    document.getElementById('date-Of-birth').addEventListener('change', function() {
        const dateOfbirth = new Date(this.value);
        const d = Date.now() - dateOfbirth.getTime();
        const aged = new Date(d);
        const age = Math.abs(aged.getUTCFullYear() - 1970);
        document.getElementById('age').value = age;
    });
 </script>
</body>
</html>

