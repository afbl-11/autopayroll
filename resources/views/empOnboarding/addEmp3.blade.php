<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AutoPayroll Employee Onboarding</title>
         @vite(['resources/css/empOnboarding/addEmp3.css', 'resources/js/app.js'])
</head>
<body>
  @include('layout.sidebar')
  <div class ="container">
    <div class = "header"><a href=""><img src="{{ asset('images/left-arrow.png') }}"></a><h2>Add Employee</h2></div>
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
    <form class="form" action="" method="GET">
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
            <button class="addCompany" onclick ="">Add Company</button> 
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
    const empButtons = document.querySelectorAll('.emp-buttons .type');
    let selectedType = null;

    empButtons.forEach(button => {
        button.addEventListener('click', () => {

            if (button.classList.contains('type-selected')) {
                button.classList.remove('type-selected');
                selectedType = null;
                console.log('Deselected Employment Type');
            } else {
                empButtons.forEach(btn => btn.classList.remove('type-selected'));
                button.classList.add('type-selected');
                selectedType = button.textContent.trim();
                console.log('Selected Employment Type:', selectedType);
            }
        });
    });

    const browseButton = document.querySelector('.browse');
    const uploadInput = document.getElementById('uploadDocuments');

    const hiddenFileInput = document.createElement('input');
    hiddenFileInput.type = 'file';
    hiddenFileInput.style.display = 'none';
    document.body.appendChild(hiddenFileInput);

    browseButton.addEventListener('click', () => {
        hiddenFileInput.click();
    });

    hiddenFileInput.addEventListener('change', () => {
        if (hiddenFileInput.files.length > 0) {
            const fileName = hiddenFileInput.files[0].name;
            uploadInput.value = fileName;
        }
    });
 </script>
</body>
</html>
