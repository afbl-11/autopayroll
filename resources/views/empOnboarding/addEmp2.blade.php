<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AutoPayroll Employee Onboarding</title>
         @vite(['resources/css/empOnboarding/addEmp2.css', 'resources/js/app.js'])
</head>
<body>
  @include('layout.sidebar', ['step' => 2])
  <div class ="container">
    <div class = "header"><img onclick="" src="{{ asset('images/left-arrow.png') }}"><h2>Add Employee</h2></div>
    @include('layout.steps')
    <form class="form" action="" method="GET">
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
<script>
    const currentStep = 2;
    const steps= document.querySelectorAll('.steps');
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