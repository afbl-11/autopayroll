<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AutoPayroll Employee Onboarding</title>
    @vite(['resources/css/employee_registration/addEmp1.css', 'resources/js/empOnboarding/addEmp.js'])
</head>
<body>
    @include('partitions.sidebar')

    <div class ="container">
        <div class = "header"><img onclick="" src="{{ asset('images/left-arrow.png') }}"><h2>Add Employee</h2></div>
        @include('partitions.steps', ['step' => 1])

        <form class="form" action="{{route('store.employee.register.1')}}" method="post">
            @csrf
            <div class = "content">

                <div class="head">
                    <div class="firstName formGroup">
                        <label for= "firstName">First Name <span class="required">*</span></label><br>
                        <input type="text" id="firstName" name="firstName" placeholder="First Name" required />
                    </div>
                    <div class="middleName formGroup">
                        <label for= "middleName">Middle Name</label><br>
                        <input type="text" id="middleName" name="middleName" placeholder="Middle Name (Optional)" />
                    </div>
                </div>

                <div class = "row">
                    <div class="lastName formGroup">
                        <label for= "lastName">Last Name <span class="required">*</span></label><br>
                        <input type="text" id="lastName" name="lastName" placeholder="Last Name" required />
                    </div>
                    <div class = "suffix formGroup">
                        <label for="suffix">Suffix</label><br>
                        <select name="suffix" id="suffix" required />
                            <option value=""></option>
                            <option value="sr">Sr.</option>
                            <option value="jr">Jr.</option>
                        </select>
                    </div>
                </div>


                <div class = "row">
                    <div class="date-Of-birth formGroup">
                        <label for= "dateOfbirth">Date of Birth <span class="required">*</span></label><br>
                        <input type="date" id="date-Of-birth" name="date-Of-birth" placeholder="Date of Birth" required />
                    </div>

                    <div class="age formGroup">
                        <label for="age">Age <span class="required">*</span></label><br>
                        <input type="number" id="age" name="age" placeholder="Age" required />
                    </div>
                </div>
                <div class="row">
                    <div class = "gender formGroup">
                        <label for="gender">Gender <span class="required">*</span></label><br>
                        <select name="gender" id="gender" required />
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class = "marital-status formGroup">
                        <label for="marital-status">Marital Status <span class="required">*</span></label><br>
                        <select name="marital-status" id="marital-status" required />
                            <option value="single">Single</option>
                            <option value="married">Married</option>
                        </select>
                    </div>
                </div>
                    <div class = "blood-type formGroup">
                        <label for="blood-type">Blood Type <span class="required">*</span></label><br>
                        <select name="blood-type" id="blood-type" required />
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
                <button type ="submit" class="next">Next</button>
        </form>
     </div>
</body>
</html>
