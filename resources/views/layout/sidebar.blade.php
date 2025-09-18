<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Navigation Bar</title>
    @vite(['resources/css/includes/sidebar.css', 'resources/js/app.js'])
</head>
<body>
    <div class="whole-container">
        <aside class="sidebar">
            <div class="brand">
                <span class="brand-letter">A</span><span class="brand-letter highlight">P</span>
                <span class="full-name">Auto</span><span class="highlight">Payroll</span>
            </div>
            <nav class="nav">
                <a href="#" class="nav-item">
                    <span class="icon fa fa-home"></span>
                    <span class="label">Home</span>
                </a>
                <a href="#" class="nav-item">
                    <span class="icon fa fa-users"></span>
                    <span class="label">Employee</span>
                </a>
                <a href="#" class="nav-item">
                    <span class="icon fa fa-newspaper"></span>
                    <span class="label">Compliance</span>
                </a>
                <a href="#" class="nav-item">
                    <span class="icon fa fa-bell"></span>
                    <span class="label">Notifications</span>
                </a>
                <a href="#" class="nav-item">
                    <span class="icon fa fa-user"></span>
                    <span class="label">Admin</span>
                </a>
            </nav>
        </aside>
    </div>
</body>
</html>