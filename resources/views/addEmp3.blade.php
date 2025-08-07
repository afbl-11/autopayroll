<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AutoPayroll Employee Onboarding</title>
         @vite(['resources/css/addEmp3.css', 'resources/js/app.js'])
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
    <div class = "header"><a href="{{ route('addEmp2') }}"><img src="{{ asset('images/left-arrow.png') }}"></a><h2>Add Employee</h2></div>
    <div class="steps-div">
        <div class="steps"><div class="icon"><img src="{{ asset('images/verified.png') }}"></div><div class="step-no">Step 1</div><div class="desc">Basic Information</div></div>
        <div class="lines"><h1>____</h1></div>
        <div class="steps"><div class="icon"><img src="{{ asset('images/verified.png') }}"></div><div class="step-no">Step 2</div><div class="desc">Contact & Address</div></div>
        <div class="lines"><h1>____</h1></div>
        <div class="steps"><div class="icon"><img src="{{ asset('images/verified.png') }}"></div><div class="step-no">Step 3</div><div class="desc">Employment Overview</div></div>
        <div class="lines"><h1>____</h1></div>
        <div class="steps"><div class="icon"><img src="{{ asset('images/notVerified.png') }}"></div><div class="step-no">Step 4</div><div class="desc">Account Setup</div></div>
        <div class="line"><h1>____</h1></div>
        <div class="steps"><div class="icon"><img src="{{ asset('images/notVerified.png') }}"></div><div class="step-no">Step 5</div><div class="desc">Review Details</div></div>
        
    </div>
    <form class="form" action="{{ route('addEmp4') }}" method="GET">
    <div class = "content">
        <div class="head">
            <div class="companyDesignation">
                <label for= "companyDesignation">Company Designation <span class="required">*</span></label><br>
                <select name="companyDesignation" id="companyDesignation" required />
                    <option value="c1">Vships Services Oceania Inc.</option>
                    <option value="c2">Metrogate</option>
                    <option value="c3">Mindchamps</option>
                    <option value="c4">Synapse</option>
                    <option value="c5">Elevated Plus</option>
                    <option value="c6">Quaerito Qualitas Inc.</option>
                    <option value="c7">Proselect Management Inc.</option>
                    <option value="c8">Global Marine Travel</option>
                    <option value="c9">Brawn Fire Safety Equipment Co.</option>
                </select>
            </div>
            <div class="wrapper">
            <a href="#">
            <button class="addCompany">Add Company</button> </a>   
            </div>
        </div>
        
        <div class="emp-type">
            <label for= "emp-type">Employment Type <span class="required">*</span></label><br>
            <div class="emp-buttons">
            <button type="button" class="type">Fulltime</button>
            <button type="button" class="type">Part-Time</button>
            <button type="button" class="type">Contractual</button>
            </div>
        </div>
        
        <div class = "row">
            <div class="startingDate">
                <label for= "startingDate">Starting Date <span class="required">*</span></label><br>
                <input type="date" id="startingDate" name="startingDate" required />
            </div>

            <div class="jobPosition">
                <label for="jobPosition">Job Position <span class="required">*</span></label><br>
                <input type="text" id="jobPosition" name="jobPosition" required />
            </div>    
        </div>
        <div class="row2">
            <div class = "uploadDocuments">
                <label for="uploadDocuments">Upload Documents <span class="required">*</span></label><br>
                <input type="text" id="uploadDocuments" name="uploadDocuments" readonly />
            </div>
            <div class = "wrapper2">
            <button type="button" class="browse">Browse</button>
            </div>
        </div>
        </div>
        <div class="next-con">
        <button type ="submit" class="next">Next</button>
        </div>
    </form> 
  </div>
  <script>
    
 </script>
</body>
</html>
