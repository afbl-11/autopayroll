<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AutoPayroll Employee Onboarding</title>
         @vite(['resources/css/addEmp2.css', 'resources/js/app.js'])
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
    <div class = "header"><a href="{{ route('addEmp') }}"><img src="{{ asset('images/left-arrow.png') }}"></a><h2>Add Employee</h2></div>
    <div class="steps-div">
        <div class="steps"><div class="icon"><img src="{{ asset('images/verified.png') }}"></div><div class="step-no">Step 1</div><div class="desc">Basic Information</div></div>
        <div class="lines"><h1>____</h1></div>
        <div class="steps"><div class="icon"><img src="{{ asset('images/verified.png') }}"></div><div class="step-no">Step 2</div><div class="desc">Contact & Address</div></div>
        <div class="lines"><h1>____</h1></div>
        <div class="steps"><div class="icon"><img src="{{ asset('images/notVerified.png') }}"></div><div class="step-no">Step 3</div><div class="desc">Employment Overview</div></div>
        <div class="line"><h1>____</h1></div>
        <div class="steps"><div class="icon"><img src="{{ asset('images/notVerified.png') }}"></div><div class="step-no">Step 4</div><div class="desc">Account Setup</div></div>
        <div class="line"><h1>____</h1></div>
        <div class="steps"><div class="icon"><img src="{{ asset('images/notVerified.png') }}"></div><div class="step-no">Step 5</div><div class="desc">Review Details</div></div>
        
    </div>
    <form class="form" action="{{ route('addEmp3') }}" method="GET">
    <div class = "content">
        <div class="residentialAddress">
                <label for= "fn">Residential Address <span class="required">*</span></label><br>
                <input type="text" id="residentialAddress" name="residentialAddress" required />
            </div>

        <div class="addressId">
                <label for= "fn">Address on ID <span class="required">*</span></label><br>
                <input type="text" id="addressId" name="addressId" required />
            </div>

        <div class = "row">
            <div class="personalContactNum">
                <label for= "personalContactNum">Personal Contact Number <span class="required">*</span></label><br>
                <input type="number" id="personalContactNum" name="personalContactNum" required />
            </div>
            <div class="email">
                <label for="email">Email <span class="required">*</span></label> <br>
                <input type="email" id="email" required />
            </div>    
        </div>
        <div class="otherContactNum">
                <label for= "otherContactNum">Other Contact </label><br>
                <input type="number" id="otherContactNum" name="otherContactNum" placeholder="Optional" />
            </div>
    </div>
        <button type ="submit" class="next">Next</button>
    </form> 
  </div>
</body>
</html>
