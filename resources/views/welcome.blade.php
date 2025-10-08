<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoPayroll</title>
    @vite(['resources/css/welcome.css', 'resources/css/theme.css'])
</head>
<body>
<header>
    <nav>
        <div class="logo">
            <a href="#" class="logo-link">
                <span class="auto">Auto</span><span class="payroll">Payroll</span>
            </a>
        </div>
        <ul class="nav-links">
            <li><a href="#">Our Team</a></li>
            <li><a href="#">About</a></li>
            <li><a href="{{route('auth.register.step1')}}" class="border-button">Get Started</a></li>
            <li><a href="{{route('login')}}" class="sign-in-button">Sign In</a></li>
        </ul>
    </nav>
</header>

<section class="main-content">
    <div class="left-content">
        <h1>We Make Payroll One Less Thing to Worry About.</h1>
        <p class="p-color">From scanned attendance logs to automated payroll and compliance, AutoPayroll handles the details so you can focus on running your business.</p>
        <a href="#" class="get-started-button">Get Started</a>
    </div>
    <div class="right-content">
        <img src="empDetails2.png" alt="Payroll Dashboard Image" class="dashboard-image">
    </div>
</section>

<section class="new-section">
    <div class="top-box">
    </div>
    <h2 class="main-header">Less work.<br>More control.</h2>
    <div class="content-container">
        <div class="features">
            <div class="feature-item">
                <div class="feature-box">
                    <img src="salary.png" alt="Payroll Icon">
                    <h3>Payroll</h3>
                    <p>Calculates payroll automatically using attendance data, daily rates, and benefit deductions. No manual input needed.</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-box">
                    <img src="calendar-with-check.png" alt="Attendance Monitoring Icon">
                    <h3>Attendance Monitoring</h3>
                    <p>Scans printed biometric logs to track attendance accurately, eliminating manual encoding and reducing errors.</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-box">
                    <img src="time-management.png" alt="Leave Management Icon">
                    <h3>Leave Management</h3>
                    <p>Streamlined leave request system fully integrated with attendance, making approvals and record-keeping efficient.</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-box">
                    <img src="finance-report.png" alt="Compliance Report Icon">
                    <h3>Compliance Report</h3>
                    <p>Generates government-ready reports for SSS, Pag-IBIG, and PhilHealth in just a few clicks.</p>
                </div>
            </div>
        </div>
        <div class="workforce-glance">
            <div class="workforce-glance-content">
                <img src="employee list.png" alt="Workforce Image">
                <div class="workforce-text">
                    <h3>Your Workforce at a Glance</h3>
                    <p>Browse, filter, and manage all employees across multiple client companies. View assignment details, track work status, and keep everything organized in one place.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="attendance-overview">
    <div class="overview-container">
        <div class="left-content-sec3">
            <h3>Employee Attendance Overview</h3>
            <p>Track employee attendance every cutoff period using submitted logs from client companies. Review absences, leaves, late-ins, and overtime in one place.</p>
        </div>
        <div class="right-content-sec3">
            <img src="attendance.png" alt="Employee Attendance Image" class="overview-image">
        </div>
    </div>
</section>

<section class="leave-request-overview">
    <div class="leave-request-container">
        <div class="left-content-sec4">
            <img src="laptop and mobile.png" alt="Employee Attendance Image" class="overview-image laptop-image">
        </div>
        <div class="right-content-sec4">
            <h3>Manage Leave Request Efficiently</h3>
            <p>Review, approve, or revise employee leave requests with full visibility. Integrated with the mobile app for direct submissions from the field.</p>
        </div>
    </div>
</section>

<section class="behind-the-scene-section">
    <h1>Built to Handle What Happens Behind the Scenes</h1>
    <div class="behind-the-scene-container">
        <div class="ocr-capture-behind">
            <div class="feature-boxs">
                <img src="ocr.png" alt="OCR Capture Icon">
                <h3>OCR Capture</h3>
                <p>Scan printed attendance logs from client sites using the admin mobile app. Automatically digitizes data through OCR for accurate and efficient tracking.</p>
            </div>
        </div>
        <div class="mobile-app-behind">
            <div class="feature-boxs">
                <img src="mobile-app.png" alt="Mobile App Icon">
                <h3>Mobile App</h3>
                <p>Allows employees to submit leave requests, view attendance records, and receive real-time announcements directly from their phones.</p>
            </div>
        </div>
        <div class="announcement-center-behind">
            <div class="feature-boxs">
                <img src="announcement.png" alt="Announcement Center Icon">
                <h3>Announcement Center</h3>
                <p>Manage announcements, alerts, and system notifications in one place. Ensure timely updates reach all employees across platforms.</p>
            </div>
        </div>
        <div class="payroll-transactions-behind">
            <div class="feature-boxs">
                <img src="payroll-transactions.png" alt="Payroll Icon">
                <h3>Payroll Transactions</h3>
                <p>View detailed salary records per employee, including pay dates, work days, gross income, overtime, deductions, and net pay with full breakdowns.</p>
            </div>
        </div>
        <div class="dashboard-behind">
            <div class="feature-boxs">
                <img src="dashboard-icon.png" alt="Dashboard Icon">
                <h3>Dashboard</h3>
                <p>Get a quick overview of key metrics—attendance summaries, leave requests, and payroll statuses. Designed for fast, informed decision-making.</p>
            </div>
        </div>
    </div>
</section>

<section class="team-section">
    <h3>Our Team</h3>
    <div class="team-container">
        <div class="profile">
            <div class="profile-content">
                <h4>Jurell</h4>
                <p>UX & Full-stack Developer</p>
                <img src="https://scontent.fmnl4-7.fna.fbcdn.net/v/t39.30808-6/485175297_2907432539417464_5247260076594652740_n.jpg?_nc_cat=104&ccb=1-7&_nc_sid=a5f93a&_nc_eui2=AeE4Wu_2iiswUHuLu6R5K2NBVmiZZEmV_CJWaJlkSZX8IhzJ22QBtnp0T9jFd5RCtnsW-VFV1pCIltazAagoK1xD&_nc_ohc=J5zrFQh8S5AQ7kNvwHnj21D&_nc_oc=AdmTHTMWBx6vUEF7ruNMhOJCm5EwLGuvoUkYBnT7pLBM3any2TJ4i1_x9JMKm_BZHa8&_nc_pt=1&_nc_zt=23&_nc_ht=scontent.fmnl4-7.fna&_nc_gid=VTD5uAwO7LryqzVGi_93cw&oh=00_AfdmLcrMxnzW-LbN939pOkBwzf3A7yIqNmFHa1NyNvmxSQ&oe=68E5B49B" alt="Jurell" class="profile-img">
            </div>
        </div>
        <div class="profile">
            <div class="profile-content">
                <h4>Nichole</h4>
                <p>Front-end Developer</p>
                <img src="nicho.png" alt="Nichole" class="profile-img">
            </div>
        </div>
        <div class="profile">
            <div class="profile-content">
                <h4>Louise</h4>
                <p>Front-end Developer</p>
                <img src="https://scontent.fmnl4-4.fna.fbcdn.net/v/t39.30808-6/481946049_23928401933494841_385131459698779964_n.jpg?_nc_cat=100&ccb=1-7&_nc_sid=a5f93a&_nc_eui2=AeHMTsEDWbuBTbWB3Qii8zX36qJCIyRsTd_qokIjJGxN39-LC33LAWyjRMe_Dto6-h9dciCpND9qDff8u1f_zykF&_nc_ohc=2KgKx4HlWBQQ7kNvwFisopp&_nc_oc=AdnbPnSc1XOyMHptWIklMqCzUTgiE0cPRBHLaRxlFralDtDItpldJvsTOoeujDdshSo&_nc_pt=1&_nc_zt=23&_nc_ht=scontent.fmnl4-4.fna&_nc_gid=6F97B_pzVSnXM07XlLrrMw&oh=00_AfeRsf5150q3a5xFY0wkuvuA_-9J79ADHJCtuRLnbz2m0A&oe=68E5A355" alt="Louise" class="profile-img">
            </div>
        </div>
        <div class="profile">
            <div class="profile-content">
                <h4>Miguel</h4>
                <p>Mobile Developer</p>
                <img src="miguel.jpg" alt="Miguel" class="profile-img">
            </div>
        </div>
        <div class="profile">
            <div class="profile-content">
                <h4>Emilio</h4>
                <p>Front-End Developer</p>
                <img src="https://scontent.fmnl4-4.fna.fbcdn.net/v/t1.6435-9/37368031_1787096014716525_2793678833646043136_n.jpg?_nc_cat=102&ccb=1-7&_nc_sid=a5f93a&_nc_eui2=AeGDHdfE-qvrbA7QR_iywPgZiVlJo6fSGUWJWUmjp9IZRe7xA97z3aWejv5tvT42RoP34gsHqAyppspHsvNzzRIV&_nc_ohc=m2zTPLKSaNoQ7kNvwEVxS58&_nc_oc=Adk1Zrfj5wc2Lyo2IRQ9xYDYF7LjyMVaR9JxJmXuvMqI-Lg7oLJNxe2MrJQ7GDncCpA&_nc_pt=1&_nc_zt=23&_nc_ht=scontent.fmnl4-4.fna&_nc_gid=0qi2SjQ7JZnsGjmxvJ05jg&oh=00_Afc7Nyb2EhoMBCZe72WM1fksHFAtK4Wc7n_ARH5Euz9qqg&oe=690749E4" alt="emilio" class="profile-img">
            </div>
        </div>
        <div class="profile">
            <div class="profile-content">
                <h4>Carls</h4>
                <p>Front-End Developer</p>
                <img src="https://scontent.fmnl4-3.fna.fbcdn.net/v/t39.30808-6/476100505_8927596240621235_5940968550311596721_n.jpg?_nc_cat=109&ccb=1-7&_nc_sid=a5f93a&_nc_eui2=AeFvX7VPhTfn2i-b1SX5FV3_pK81AwAedb6krzUDAB51vnHj6kSG1378FHg95ec7xTn_PlVJxEcXKkVD7Ho4Xvdm&_nc_ohc=Ixi-OHvCf84Q7kNvwFYq82a&_nc_oc=AdkdHzju_pzRFmC_YDwQ90jSn9aeNcqp9jtmLIGwjXWeE2vOD7SYhtKgMjAlo401v9k&_nc_pt=1&_nc_zt=23&_nc_ht=scontent.fmnl4-3.fna&_nc_gid=Rhq6keYVCanvKPRb-1eiEA&oh=00_Afej9CeXkg7ITtUE8DWVGM5SZfVVicFTsS-AHNjudKFviQ&oe=68E58D93" alt="carls" class="profile-img">
            </div>
        </div>
    </div>
</section>

<section class="hr-section">
    <h3>Ready to simplify HR and payroll for your team?</h3>
    <p>AutoPayroll brings everything together. It handles employee management, attendance tracking, leave requests, and payroll processing without the hassle of spreadsheets or manual work.</p>
    <button class="get-started-btn">Get Started</button>
</section>

<section class="logo-section">
    <div class="logo-content-s8">
        <span class="logo-text">Auto</span><span class="logo-payroll">Payroll</span>
    </div>
</section>
</body>
</html>
