d<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>AutoPayroll Admin Module</title>
    @vite(['resources/css/admin_dashboard/admin_dashboard.css', 'resources/js/app.js'])

</head>
@include('partitions.sidebarAdmin')
<body>

<div class="container">

    <div class="header">
        <h2>Dashboard</h2>
        <div class="userInfo">
            <span>{{$variable}}</span> <!-- In the design, variable here is "Nichole Monzon" -->
            <img onclick="" src="{{ asset('images/afable.png') }}">
        </div>
    </div>

    <div class="content">
        <div class="head">
            <div class="header2">
                <h3>Payroll Summary</h3>
            </div>
            <div class="payrollCategories">
                <div class="payrollCategory1 payrollCategory">
                    <div>Paid Employees</div>
                    <p id="amount">{{$variable}}</p> <!-- In the design, variable here is "37" -->
                </div>
                <div class="payrollCategory2 payrollCategory">
                    <div>Total Payroll</div>
                    <p id="amount">{{$variable}}</p> <!-- In the design, variable here is "100,000.00" -->
                    <p id="pastAmount">{{$variable}}</p> <!-- In the design, variable here is "98,765.00 last month" -->
                </div>
                <div class="payrollCategory3 payrollCategory">
                    <div>Total Deductions</div>
                    <p id="amount">{{$variable}}</p> <!-- In the design, variable here is "33,876.00" -->
                    <p id="pastAmount">{{$variable}}</p> <!-- In the design, variable here is "36,564.00 last month" -->
                </div>
                <div class="payrollCategory4 payrollCategory">
                    <div>Upcoming Pay Date</div>
                    <p id="payDate">{{$variable}}</p> <!-- In the design, variable here is "June 30, 2025" -->
                </div>
            </div>
        </div>

        <div class="middleRow">
            <div class="attendanceOverview">
                <h2>Attendance Overview</h2>
                <div class="attendanceCategory1 attendanceCategory">
                    <p class="categoryTitle">Number of Absences</p>
                    <p id="num1">{{$variable}}</p> <!-- In the design, variable here is "10" -->
                </div>
                <div class="attendanceCategory2 attendanceCategory">
                    <p class="categoryTitle">Early Clock-ins</p>
                    <p id="num2">{{$variable}}</p> <!-- In the design, variable here is "27" -->
                </div>
                <div class="attendanceCategory3 attendanceCategory">
                    <p class="categoryTitle">Late Clock-ins</p>
                    <p id="num3">{{$variable}}</p> <!-- In the design, variable here is "20" -->
                </div>
                <div class="attendanceCategory4 attendanceCategory">
                    <p class="categoryTitle">Overtimes Logged</p>
                    <p id="num4">{{$variable}}</p> <!-- In the design, variable here is "15" -->
                </div>
            </div>

            <div class="manpower">
                <h2>Manpower Distribution</h2>

                <div class="manpowerRow">
                    <div class="companyName">
                        <div class="title">
                            <h4>Company</h4>
                        </div>
                        <div class="manpowerRow2">
                            <div class="logo">
                                <img class="companyLogo" src="{{ asset('images/building.png') }}">
                            </div>
                            <div class="details">
                                <strong>{{$variable}}</strong> <!-- In the design, variable here is "Mindchamps" -->
                            </div>
                        </div>
                    </div>
                    <div class="companyDetails">
                        <div class="addressTitle">
                            <h4>Address</h4>
                        </div>
                        <div class="manpowerRow2">
                            <div class="address">
                                <p>{{$variable}}</p>
                                <!-- In the design, variable here is "Unit 504, 5th Floor One Corporate Centre, Julia Vargas Ave, Ortigas Center, Pasig City, 1605" -->
                            </div>
                        </div>
                    </div>
                    <div class="manpowerCount">
                        <div class="manpowerTitle">
                            <h4>Manpower</h4>
                        </div>
                        <div class="manpowerRow2">
                            <div class="count">
                                <p id="manpowerCount">{{$variable}}</p> <!-- In the design, variable here is "10" -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="leaveRequests">
            <h2>Leave Requests</h2>
            <div class="leaveRequestsContainer">
                <div class="requesterName">
                    <p id="employeeName">{{$variable}}</p> <!-- In the design, variable here is "Marc Jurell Afable" -->
                </div>
                <div class="leaveRequest">
                    <p id="employeeReason">{{$variable}}</p>
                    <!-- In the design, variable here is "I would like to formally request vacation leave from July 15 to July 19, 2025 (5 working days)" -->
                </div>
                <div class="time">
                    <p id="employeeTime">{{$variable}}</p> <!-- In the design, variable here is "9 hours ago" -->
                </div>
            </div>


        </div>
    </div>
</div>

</body>
</html>

