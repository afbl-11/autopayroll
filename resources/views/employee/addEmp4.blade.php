<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>AutoPayroll Employee Onboarding</title>
    @vite(['resources/css/employee admin_dashboard registration/addEmp4.css', 'resources/js/app.js'])
</head>
<body>
@include('partitions.sidebar')
<div class="container">
    <div class="header"><a href=""><img src="{{ asset('images/left-arrow.png') }}"></a>
        <h2>Add Employee</h2></div>
    @include('partitions.steps')
    <form class="form" action="{{route('employee.register.5')}}" method="get">
        <div class="content">
            <div class="email formGroup">
                <label for="email">Email <span class="required">*</span></label> <br>
                <input type="email" id="email" placeholder="Email" required/>
            </div>

            <div class="empId formGroup">
                <label for="fn">Employee Identification Number </label><br>
                <input type="number" id="empId" name="empId" placeholder="Employee ID Number" required/>
            </div>

            <div class="password formGroup">
                <label for="password">Password </label> <br>
                <div class="wrapper">
                    <input type="password" id="password" placeholder="Password" required/>
                    <span class="toggleEye" onclick="togglePassword()">👁</span> <br>
                </div>
            </div>

        </div>
        <button type="submit" class="next">Next</button>
    </form>
</div>
<script>
    function togglePassword() {
        const passwordInput = document.getElementById("password");
        const icon = document.querySelector(".toggleEye");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            icon.textContent = "⌣";
        } else {
            passwordInput.type = "password";
            icon.textContent = "👁";
        }
    }

    const currentStep = 4;
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
