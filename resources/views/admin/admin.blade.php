<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>AutoPayroll Admin Module</title>
    @vite(['resources/css/admin_dashboard/dashboard.css', 'resources/js/app.js', 'resources/css/theme.css'])
</head>
<body>

<div class="sidebar">

</div>
<div class="container">
    <nav>
        <h4>Dashboard</h4>
        <div class="user-menu">
            <a href="#">
                <p>{{$admin}}</p>
                <img src="#">
            </a>
        </div>
    </nav>
    <div class="main-content">

        <div class="summary-wrapper">
            <div class="header">
                <h5>Payroll Summary</h5>
            </div>

            <div class="table-data">
                <div class="data-wrapper">
                    <div class="table-item">
                        <h6>Paid Employees</h6>
                        <div class="data">
                            <h3>{{$employee_count}}</h3>
                        </div>
                    </div>
                    <div class="table-item">
                        <h6>Total Payroll</h6>
                        <div class="data">
                    <h3>778879</h3>
                        </div>
                    </div>
                    <div class="table-item">
                        <h6>Total Deductions</h6>
                    </div>
                    <div class="table-item">
                        <h6>Upcoming Pay Date</h6>
                    </div>
                </div>
            </div>

        </div>

        <div class="section">
            <div class="attendance-overview">

            </div>
            <div class="manpower-distribution">

            </div>
        </div>
        <div class="leave-requests">

        </div>
    </div>
</div>

</body>
</html>

