@vite(['resources/css/welcome.css', 'resources/css/theme.css'])

    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AutoPayroll</title>
</head>
<body>
    <div class="container">
        <nav>
            <div class="logo-wrapper">
                <h1 class="logo">Auto<span>Payroll</span></h1>
            </div>
            <div class="buttons">
                <form action="{{route('auth.register.step1')}}" method="get">
                    <x-button-submit id="nav-button">Get Started</x-button-submit>
                </form>

                <form action="{{route('login')}}" method="get">
                    <x-button-submit>Sign In</x-button-submit>
                </form>
            </div>
        </nav>
{{--        introductions cards--}}
        <div class="introduction-wrapper">
            <div class="left-content-wrapper">
                <div class="message-wrapper">
                    <h3>We Make Payroll One Less Thing to  Worry About.</h3>
                    <p>From scanned attendance logs to automated payroll and compliance, AutoPayroll handles the details so you can focus on running your business.</p>
                <form action="{{route('auth.register.step1')}}" method="get">
                    <x-button-submit>Get Started</x-button-submit>
                </form>
                </div>
            </div>
            <div class="right-content-wrapper">
                <img src="{{asset('assets/landing/image1.png')}}" alt="">
            </div>
        </div>
        <div class="separator"></div>

{{--        info cards--}}
        <section class="info-cards-wrapper">
            <div class="info-cards-header"><h3>Less Work. More Control</h3></div>

            <div class="cards-wrapper">
                <div class="info-cards">
                    <img src="{{asset('assets/landing/salary.png')}}" alt="">
                    <p class="info-card-header">Payroll</p>
                    <p>Calculates payroll automatically using attendance data, daily rates, and benefit deductions, no
                        manual input needed.</p>
                </div>

                <div class="info-cards">
                    <img src="{{asset('assets/landing/calendar-with-check.png')}}" alt="">
                    <p class="info-card-header">Attendance Monitoring</p>
                    <p>Scans printed biometric logs to track attendance accurately, eliminating manual encoding and
                        reducing errors.</p>
                </div>
                <div class="info-cards">
                    <img src="{{asset('assets/landing/time-management 1.png')}}" alt="">
                    <p class="info-card-header">Credit Adjustment</p>
                    <p>Flexible credit adjustment module allowing admins to modify employee credits with proper tracking and transparency.</p>
                </div>
                <div class="info-cards">
                    <img src="{{asset('assets/landing/time-management 1.png')}}" alt="">
                    <p class="info-card-header">Leave Management</p>
                    <p>Streamlined leave request system fully integrated with attendance, making approvals and
                        record-keeping efficient.</p>
                </div>
                <div class="info-cards">
                    <img src="{{asset('assets/landing/time-management 1.png')}}" alt="">
                    <p class="info-card-header">Real-Time Notifications</p>
                    <p>Instant updates for approvals, requests, and announcements to keep everyone informed without delays.</p>
                </div>
                <div class="info-cards">
                    <img src="{{asset('assets/landing/time-management 1.png')}}" alt="">
                    <p class="info-card-header">Announcements</p>
                    <p>Easily broadcast company-wide updates and messages, ensuring everyone stays informed in real time.</p>
                </div>
            </div>
        </section>
{{--        2nd content--}}

        <section class="content-wrapper">
            <img src="{{asset('assets/landing/employee-list.png')}}" alt="">
            <div class="info-message">
                <h3 >Your Workforce at a Glance</h3>
                <p class="sub-text" >Browse, filter, and manage all employees across multiple client companies. View assignment details, track work status, and keep everything organized in one place.</p>
            </div>
        </section>
{{--        3rd content--}}
        <section class="content-wrapper" id="content-wrapper" >
            <div class="info-message">
                <h3 id="h3-content">Employee Attendance Overview</h3>
                <p id="p-content">Track employee attendance every cutoff period using submitted logs from client companies. Review absences, leaves, late-ins, and overtime in one place.</p>
            </div>
                <img src="{{asset('assets/landing/attendance.png')}}" alt="">
        </section>
{{--        4th content--}}
        <section class="content-wrapper">
            <img src="{{asset('assets/landing/leaveRequest.png')}}" alt="">
            <div class="info-message">
                <h3>Manage Leave Requests Efficiently</h3>
                <p>Review, approve, or revise employee leave requests with full visibility. Integrated with the mobile app for direct submissions from the field</p>
            </div>
        </section>

{{--           5th content--}}
{{--        <section class="content-wrapper">--}}
{{--            <div class="content-header">Built to Handle What Happens Behind the Scenes</div>--}}
{{--            <div class="last-info-wrapper">--}}
{{--                <div class="info-cards-wrapper">--}}
{{--                    <img src="{{asset('assets/landing/General-OCR.png')}}" alt="">--}}
{{--                    <h6>OCR Capture</h6>--}}
{{--                    <p>Scan printed attendance logs from client sites using the admin mobile app. Automatically digitizes data through OCR for accurate and efficient tracking.</p>--}}
{{--                </div>--}}
{{--                <div class="info-cards-wrapper">--}}
{{--                    <img src="{{asset('assets/landing/mobilePhone.png')}}" alt="">--}}
{{--                    <h6>Mobile App</h6>--}}
{{--                    <p>Allows employees to submit leave requests, view attendance records, and receive real-time announcements directly from their phones.</p>--}}
{{--                </div>--}}
{{--                <div class="info-cards-wrapper">--}}
{{--                    <img src="{{asset('assets/landing/Speaker.png')}}" alt="">--}}
{{--                    <h6>Announcement Center</h6>--}}
{{--                    <p>Manage announcements, alerts, and system notifications in one place. Ensure timely updates reach all employees across platforms.</p>--}}
{{--                </div>--}}
{{--                <div class="info-cards-wrapper">--}}
{{--                    <img src="{{asset('assets/landing/Ledger.png')}}" alt="">--}}
{{--                    <h6>Payroll Transactions</h6>--}}
{{--                    <p>View detailed salary records per employee, including pay dates, work days, gross income, overtime, deductions, and net pay with full breakdowns.</p>--}}
{{--                </div>--}}
{{--                <div class="info-cards-wrapper">--}}
{{--                    <img src="{{asset('assets/landing/Control-Panel.png')}}" alt="">--}}
{{--                    <h6>Dashboard</h6>--}}
{{--                    <p>Get a quick overview of key metrics—attendance summaries, leave requests, and payroll statuses. Designed for fast, informed decision-making.</p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </section>--}}

        <section class="banner">
            <div class="banner-header">
                <h3 >Ready to simplify HR and payroll for your team?</h3>
            </div>
            <div class="sub-message">
                <p>AutoPayroll brings everything together. It handles employee management, attendance tracking, leave requests, and payroll processing without the hassle of spreadsheets or manual work.</p>
            </div>
            <form action="{{route('auth.register.step1')}}" method="get">
                <x-button-submit>Get Started</x-button-submit>
            </form>

        </section>
        <footer>
            <div class="logo">Auto<span>Payroll</span></div>
        </footer>
    </div>
</body>
</html>
