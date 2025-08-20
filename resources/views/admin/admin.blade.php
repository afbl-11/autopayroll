<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AutoPayroll Admin Module</title>
         @vite(['resources/css/admin/admin.css', 'resources/js/app.js'])
</head>
<body>
  @include('layout.sidebarAdmin')
  <div class ="container">
    <div class = "header">
        <h2>Dashboard</h2>
        <div class="userInfo">
            <span>Nichole Monzon</span>
            <img onclick="" src="{{ asset('images/afable.png') }}">
        </div>
    </div>
    
    <div class = "content">
        <div class="head">
            <div class="header2">
           <h3>Payroll Summary</h3>
           </div>
            <div class="payrollCategories">
                <div class="payrollCategory1">
                    <div>Paid Employees</div>
                    <p id="amount">37</p>
                </div>
                <div class="payrollCategory2">
                    <div>Total Payroll</div>
                    <p id="amount">100,000.00</p>
                    <p id="pastAmount">98,765.00 last month</p>
                </div>
                <div class="payrollCategory3">
                    <div>Total Deductions</div>
                     <p id="amount">33,876.00</p>
                     <p id="pastAmount">36,564.00 last month</p>
                </div>
                <div class="payrollCategory4">
                    <div>Upcoming Pay Date</div>
                    <p id="payDate">June 30, 2025</p>
                </div>
            </div>    
        </div>
        
        <div class = "middleRow">
            <div class="attendanceOverview">
                <h2>Attendance Overview</h2>
                <div class = "attendanceCategory1">
                    <p class = "categoryTitle">Number of Absences</p>
                    <p id="num1">10</p>
                </div>
                <div class = "attendanceCategory2">
                    <p class = "categoryTitle">Early Clock-ins</p>
                    <p id="num2">27</p>
                </div>
                <div class = "attendanceCategory3">
                    <p class = "categoryTitle">Late Clock-ins</p>
                    <p id="num3">20</p>
                </div>
                <div class = "attendanceCategory4">
                    <p class = "categoryTitle">Overtimes Logged</p>
                    <p id="num4">15</p>
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
                                <strong>Mindchamps</strong>
                            </div>
                          </div>
                        </div>
                        <div class="companyDetails">
                            <div class="addressTitle">
                                <h4>Address</h4>
                            </div>
                            <div class="manpowerRow2">
                            <div class="address">
                                <p>Unit 504, 5th Floor One Corporate Centre, Julia Vargas Ave, Ortigas Center, Pasig City, 1605</p>
                            </div>
                            </div>
                        </div>
                        <div class="manpowerCount">
                            <div class="manpowerTitle">
                                <h4>Manpower</h4>
                            </div>
                            <div class="manpowerRow2">
                            <div class="count">
                                <p id="manpowerCount">10</p>
                            </div>
                            </div>
                        </div>
                    </div>

                    <div class="manpowerRow">  
                        <div class="companyName">
                            
                        <div class="manpowerRow2">
                            <div class="logo">
                                <img class="companyLogo" src="{{ asset('images/building.png') }}">
                            </div>
                            <div class="details">
                                <strong>Mindchamps</strong>
                            </div>
                          </div>
                        </div>
                        <div class="companyDetails">
                            
                            <div class="manpowerRow2">
                            <div class="address">
                                <p>Unit 504, 5th Floor One Corporate Centre, Julia Vargas Ave, Ortigas Center, Pasig City, 1605</p>
                            </div>
                            </div>
                        </div>
                        <div class="manpowerCount">
                            
                            <div class="manpowerRow2">
                            <div class="count">
                                <p id="manpowerCount">10</p>
                            </div>
                            </div>
                        </div>
                    </div>

                     <div class="manpowerRow">  
                        <div class="companyName">
                            
                        <div class="manpowerRow2">
                            <div class="logo">
                                <img class="companyLogo" src="{{ asset('images/building.png') }}">
                            </div>
                            <div class="details">
                                <strong>Mindchamps</strong>
                            </div>
                          </div>
                        </div>
                        <div class="companyDetails">
                            
                            <div class="manpowerRow2">
                            <div class="address">
                                <p>Unit 504, 5th Floor One Corporate Centre, Julia Vargas Ave, Ortigas Center, Pasig City, 1605</p>
                            </div>
                            </div>
                        </div>
                        <div class="manpowerCount">
                            
                            <div class="manpowerRow2">
                            <div class="count">
                                <p id="manpowerCount">10</p>
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
                    <p id="employeeName">Marc Jurell Afable</p>
                </div>
                <div class = "leaveRequest">
                    <p id="employeeReason">I would like to formally request vacation leave from July 15 to July 19, 2025 (5 working days)</p>
                </div>
                <div class = "time">
                    <p id="employeeTime">9 hours ago</p>
                </div>
                </div>
        </div>
  </div>
</div>
</body>
</html>

