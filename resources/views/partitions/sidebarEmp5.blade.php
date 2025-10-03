<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AutoPayroll Employee Onboarding</title>
         @vite(['resources/css/includes/sidebarEmp5.css', 'resources/js/app.js'])
</head>
<body>
    <div class = "sidebar">
        <div class="logo"><span class="a">A</span><span class="p">P</span></div>
        <nav>
            <ul>
                <li><a href="#"><img src="{{ asset('images/home.png') }}" id="img1"><span><p>Home</p></span></a></li>
                <li><a href="#"><img src="{{ asset('images/emp.png') }}"><span><p>Employee</p></span></a></li>
                <li><a href="#"><img src="{{ asset('images/compliance.png') }}"><span><p>Compliance</p></span></a></li>
                <li><a href="#"><img src="{{ asset('images/notif.png') }}"><span><p>Notifications</p></span></a></li>
                <li><a href="#"><img src="{{ asset('images/admin_dashboard.png') }}"><span><p>Admin</p></span></a></li>
            </ul>
        </nav>
    </div>
</body>
</html>
