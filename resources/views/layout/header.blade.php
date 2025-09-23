<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Employee Header</title>
  @vite(['resources/css/includes/header.css', 'resources/js/app.js'])
</head>
<body>
    <div class="employee-header">
        <img class="leftArrow" onclick="" src="{{ asset('images/left-arrow.png') }}">
            <div class="employee-info">
                    <img src="{{ asset('images/afable.png') }}">
                    <div class="details">
                        <h2>Marc Jurell Afable</h2>
                        <span class="status active">Active</span>
                    </div>
                </div>
                <div class="employee-info-right">
                    <p class ="empID">Employee ID<strong>EMP1001</strong></p>
                    <p>Job Position<strong>Janitor</strong></p>
                </div>
                <button class="send-email-btn">Send Email</button>
    </div>
 
    <div class="employee-options">
        <a href="#" class="employee-option">
            <span class="icon"><img src="{{ asset('images/Personal Info.png') }}"></span>
            <span class="label">Personal Information</span>
        </a>

        <a href="#" class="employee-option">
            <span class="icon"><img src="{{ asset('images/Contract.png') }}"></span>
            <span class="label">Contract</span>
        </a>

        <a href="#" class="employee-option">
            <span class="icon"><img src="{{ asset('images/Payroll.png') }}"></span>
            <span class="label">Payroll</span>
        </a>

        <a href="#" class="employee-option">
            <span class="icon"><img src="{{ asset('images/Document.png') }}"></span>
            <span class="label">Documents</span>
        </a>
        
        <a href="#" class="employee-option">
            <span class="icon"><img src="{{ asset('images/Time Management.png') }}"></span>
            <span class="label">Time Management</span>
        </a>
    </div>
</body>
</html>