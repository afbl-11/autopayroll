<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AutoPayroll Employee Onboarding</title>
         @vite(['resources/css/empOnboarding/addEmp3.css', 'resources/js/empOnboarding/addEmp.js'])
</head>
<body>
  @include('layout.sidebar')
  <div class ="container">
    <div class = "header"><img onclick="" src="{{ asset('images/left-arrow.png') }}"><h2>Add Employee</h2></div>
    @include('layout.steps', ['step' => 3])
    <form class="form" action="" method="GET">
    <div class = "content">
        <div class="head">
            <div class="companyDesignation formGroup">
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
            <button class="addCompany formGroup" onclick ="">Add Company</button> 
            </div>
        </div>
        
        <div class="emp-type formGroup">
            <label for= "emp-type">Employment Type <span class="required">*</span></label><br>
            <div class="emp-buttons">
            <button type="button" class="type">Fulltime</button>
            <button type="button" class="type">Part-Time</button>
            <button type="button" class="type">Contractual</button>
            </div>
        </div>
        
        <div class = "row">
            <div class="startingDate formGroup">
                <label for= "startingDate">Starting Date <span class="required">*</span></label><br>
                <input type="date" id="startingDate" name="startingDate" required />
            </div>

            <div class="jobPosition formGroup">
                <label for="jobPosition">Job Position <span class="required">*</span></label><br>
                <input type="text" id="jobPosition" name="jobPosition" placeholder="Job Position" required />
            </div>    
        </div>
        <div class="row2">
            <div class = "uploadDocuments formGroup">
                <label for="uploadDocuments">Upload Documents <span class="required">*</span></label><br>
                <div class="file-wrapper">
                    <input type="text" id="uploadDocuments" name="uploadDocuments" readonly />
                    <span id="seenIndicator" class="indicator unseen" hidden>Unseen</span>
                    <span id="removeFile" class="remove-btn" hidden>&times;</span>
                </div>
            </div>
            <div class = "wrapper2">
            <button type="button" class="browse formGroup">Browse</button>
            </div>
        </div>
        <div id="filePreview" class="file-preview" hidden>
            <div id="previewContent"></div>
        </div>
        </div>
        <div class="next-con">
        <button type ="submit" class="next">Next</button>
        </div>
    </form> 
  </div>
</body>
</html>