<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>AutoPayroll Employee Onboarding</title>
    @vite(['resources/css/employee admin_dashboard registration/addEmp5.css', 'resources/js/app.js'])
</head>
<body>
@include('partitions.sidebarEmp5')
<div class="container">
    <div class="header"><a href="#"><img src="{{ asset('images/left-arrow.png') }}"></a>
        <h2>Add Employee</h2></div>
    @include('partitions.steps')
    <form class="form" action="" method="POST">
        <div class="content">
            <h3>BASIC INFORMATION</h3>
            <div class="head">
                <div class="firstName formGroup">
                    <label for="firstName">First Name </label><br>
                    <input type="text" id="firstName" name="firstName" readonly/>
                </div>
                <div class="lastName formGroup">
                    <label for="lastName">Last Name </label><br>
                    <input type="text" id="lastName" name="lastName" readonly/>
                </div>
            </div>

            <div class="place-Of-birth formGroup">
                <label for="placeOfbirth">Place of Birth </label> <br>
                <input type="text" id="placeOfbirth" name="placeOfbirth" readonly/>
            </div>

            <div class="row">
                <div class="date-Of-birth formGroup">
                    <label for="dateOfbirth">Date of Birth</label><br>
                    <input type="number" id="date-Of-birth" name="date-Of-birth" readonly/>
                </div>

                <div class="age formGroup">
                    <label for="age">Age</label><br>
                    <input type="number" id="age" name="age" readonly/>
                </div>
            </div>
            <div class="row">
                <div class="gender formGroup">
                    <label for="gender">Gender</label><br>
                    <input type="text" id="gender" name="gender" readonly/>
                </div>
                <div class="marital-status formGroup">
                    <label for="marital-status">Marital Status</label><br>
                    <input type="text" id="marital-status" name="marital-status" readonly/>
                </div>
            </div>
            <div class="blood-type formGroupLow">
                <label for="blood-type">Blood Type</label><br>
                <input type="text" id="blood-type" name="blood-type" readonly/>
            </div>
        </div>

        <div class="content">
            <h3>CONTACT & ADDRESS</h3>
            <div class="residentialAddress formGroup">
                <label for="fn">Residential Address </label><br>
                <input type="text" id="residentialAddress" name="residentialAddress" readonly/>
            </div>

            <div class="addressId formGroup">
                <label for="fn">Address on ID </label><br>
                <input type="text" id="addressId" name="addressId" readonly/>
            </div>

            <div class="row">
                <div class="personalContactNum formGroup">
                    <label for="personalContactNum">Personal Contact Number </label><br>
                    <input type="number" id="personalContactNum" name="personalContactNum" readonly/>
                </div>
                <div class="email formGroup">
                    <label for="email">Email </label> <br>
                    <input type="email" id="email" name="email" readonly/>
                </div>
            </div>
            <div class="otherContactNum formGroupLow">
                <label for="otherContactNum">Other Contact </label><br>
                <input type="number" id="otherContactNum" name="otherContactNum" readonly/>
            </div>
        </div>

        <div class="content">
            <h3>EMPLOYMENT OVERVIEW</h3>
            <div class="head">
                <div class="companyDesignation formGroup">
                    <label for="companyDesignation">Company Designation </label><br>
                    <input type="text" id="companyDesignation" name="companyDesignation" readonly/>
                </div>
            </div>

            <div class="emp-type formGroupLow">
                <label for="emp-type">Employment Type </label><br>
                <input type="text" id="emp-type" name="emp-type" readonly/>
            </div>

            <div class="row">
                <div class="startingDate formGroup">
                    <label for="startingDate">Starting Date </label><br>
                    <input type="number" id="startingDate" name="startingDate" readonly/>
                </div>

                <div class="jobPosition formGroup">
                    <label for="jobPosition">Job Position </label><br>
                    <input type="text" id="jobPosition" name="jobPosition" readonly/>
                </div>
            </div>
            <div class="row2">
                <div class="uploadDocuments formGroupLow">
                    <label for="uploadDocuments">Upload Documents </label><br>
                    <input type="text" id="uploadDocuments" name="uploadDocuments" readonly/>
                </div>
            </div>
        </div>

        <div class="content">
            <h3>ACCOUNT SETUP</h3>
            <div class="email formGroup">
                <label for="email">Email <span class="required">*</span></label> <br>
                <input type="email" id="email" readonly/>
            </div>

            <div class="empId formGroup">
                <label for="fn">Employee Identification Number </label><br>
                <input type="number" id="empId" name="empId" readonly/>
            </div>

            <div class="password formGroupLow">
                <label for="password">Password </label> <br>
                <input type="password" id="password" readonly/>
            </div>
        </div>


        <button type="submit" class="confirm">Confirm</button>
    </form>
</div>

<script>
    const currentStep = 5;
    const steps = document.querySelectorAll('.steps');
    const lines = document.querySelectorAll('.line');
    steps.forEach(step => {
        const stepNum = parseInt(step.dataset.step);
        if (stepNum <= currentStep) {
            step.querySelector('img').src = "{{ asset('images/verified.png') }}";
        }
    });
    lines.forEach(line => {
        const lineNum = parseInt(line.dataset.step);
        if (lineNum <= currentStep) {
            line.classList.add('active-line');
        }
    });
</script>
</body>
</html>

