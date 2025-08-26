<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AutoPayroll Employee Onboarding</title>
         @vite(['resources/css/includes/steps.css', 'resources/js/app.js'])
</head>
<body>
     <div class="steps-div">
        <div class="steps" data-step="1"><div class="icon"><img src="{{ asset('images/notVerified.png') }}"></div><div class="step-no">Step 1</div><div class="desc">Basic Information</div></div>
        <div class="line" data-step="1"></div>
        <div class="steps" data-step="2"><div class="icon"><img src="{{ asset('images/notVerified.png') }}"></div><div class="step-no">Step 2</div><div class="desc">Contact & Address</div></div>
        <div class="line" data-step="2"></div>
        <div class="steps" data-step="3"><div class="icon"><img src="{{ asset('images/notVerified.png') }}"></div><div class="step-no">Step 3</div><div class="desc">Employment Overview</div></div>
        <div class="line" data-step="3"></div>
        <div class="steps" data-step="4"><div class="icon"><img src="{{ asset('images/notVerified.png') }}"></div><div class="step-no">Step 4</div><div class="desc">Account Setup</div></div>
        <div class="line" data-step="4"></div>
        <div class="steps" data-step="5"><div class="icon"><img src="{{ asset('images/notVerified.png') }}"></div><div class="step-no">Step 5</div><div class="desc">Review Details</div></div>
    </div>
</body>
</html>