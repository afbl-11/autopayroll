<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>AutoPayroll Employee Onboarding</title>
    @vite(['resources/css/employee_registration/addEmp1.css', 'resources/js/app.js','resources/css/includes/sidebar.css'])
</head>
<body>
@include('partitions.sidebar')
<div class="container">
    <div class="header"><a href="#"><img src="{{ asset('images/left-arrow.png') }}"></a>
        <h2>Add Employee</h2></div>
{{--    @include('partitions.steps', ['step' => 1])--}}
    <form class="form" action="{{route('employee.register.2')}}" method="get">
        <div class="content">
            <div class="head">
                <div class="firstName formGroup">
                    <label for="firstName">First Name <span class="required">*</span></label><br>
                    <input type="text" id="firstName" name="firstName" placeholder="First Name" required/>
                </div>
                <div class="middleName formGroup">
                    <label for="middleName">Middle Name</label><br>
                    <input type="text" id="middleName" name="middleName" placeholder="Middle Name (Optional)"/>
                </div>
            </div>
            <div class="row">
                <div class="lastName formGroup">
                    <label for="lastName">Last Name <span class="required">*</span></label><br>
                    <input type="text" id="lastName" name="lastName" placeholder="Last Name" required/>
                </div>
                <div class="suffix formGroup">
                    <label for="suffix">Suffix</label><br>
                    <select name="suffix" id="suffix" required/>
                    <option value="sr">Sr.</option>
                    <option value="jr">Jr.</option>
                    <option value="third">III</option>
                    </select>
                </div>
            </div>

            <div class="place-Of-birth formGroup">
                <label for="placeOfbirth">Place of Birth <span class="required">*</span></label> <br>
                <input type="text" id="placeOfbirth" name="placeOfbirth" placeholder="Place of Birth" required/>
            </div>

            <div class="row">
                <div class="date-Of-birth formGroup">
                    <label for="dateOfbirth">Date of Birth</label><br>
                    <input type="date" id="date-Of-birth" name="date-Of-birth" placeholder="Date of Birth" required/>
                </div>

                <div class="age formGroup">
                    <label for="age">Age</label><br>
                    <input type="number" id="age" name="age" placeholder="Age" required/>
                </div>
            </div>
            <div class="row">
                <div class="gender formGroup">
                    <label for="gender">Gender</label><br>
                    <select name="gender" id="gender" required/>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    </select>
                </div>
                <div class="marital-status formGroup">
                    <label for="marital-status">Marital Status</label><br>
                    <select name="marital-status" id="marital-status" required/>
                    <option value="single">Single</option>
                    <option value="married">Married</option>
                    </select>
                </div>
            </div>
            <div class="blood-type formGroup">
                <label for="blood-type">Blood Type</label><br>
                <select name="blood-type" id="blood-type" required/>
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
        <button type="submit" class="next">Next</button>
    </form>
</div>
<script>
    document.getElementById('date-Of-birth').addEventListener('blur', function () {
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
            alert("The hired employee admin_dashboard does not meet the required minimum age standards for employment.");
            return;
        }

        if (age > 65) {
            document.getElementById('date-Of-birth').value = '';
            document.getElementById('age').value = '';
            alert("The hired employee admin_dashboard is beyond the suitable age range for employment."); //inassume ko lang ito sa age range.
            return;
        }
    });

    document.getElementById('age').addEventListener('change', function () {
        const dateOfbirthInput = document.getElementById('date-Of-birth');

        if (!dateOfbirthInput.value.trim()) {
            alert("Please enter the employee admin_dashboard's date of birth first.");
            this.value = '';
            dateOfbirthInput.focus();
            return;
        }

    });

    const currentStep = 1;
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

