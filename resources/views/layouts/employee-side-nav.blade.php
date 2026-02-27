@vite(['resources/css/theme.css', 'resources/css/includes/sidebar.css'])

<aside class="sidebar-container" id="sidebar">
    <div class="sidebar-header">
        <div class="logo-wrapper">
            <x-logo-minimized></x-logo-minimized>
        </div>
        <span class="brand-name">Auto<span style="color:#FFD858;">Payroll</span>
        </span>
    </div>

    <nav class="nav-menu">
        <ul class="nav-list">

            <li class="nav-item">
                <a href="{{ url('/employee/employee-dashboard') }}"
                   class="nav-link {{ request()->is('/employee/employee-dashboard*') ? 'active' : '' }}">
                    <i class="bi bi-grid-fill"></i>
                    <span class="link-text">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('/employee/payroll') }}"
                   class="nav-link {{ request()->is('employee/payroll*') ? 'active' : '' }}">
                    <i class="bi bi-receipt"></i>
                    <span class="link-text">Payslips</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('/employee/announcement') }}"
                   class="nav-link {{ request()->is('employee/announcement*') ? 'active' : '' }}">
                    <i class="bi bi-megaphone-fill"></i>
                    <span class="link-text">Announcements</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('/employee/credit-adjustment') }}"
                   class="nav-link {{ request()->is('employee/credit-adjustment*') ? 'active' : '' }}">
                    <i class="bi bi-sliders"></i>
                    <span class="link-text">Credit Adjustment</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('/employee/leave-module') }}"
                   class="nav-link {{ request()->is('employee/leave-module*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-text-fill"></i>
                    <span class="link-text">Leave Filing</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{route('employee_web.settings')}}" class="nav-link">
                    <i class="bi bi-gear-fill"></i>
                    <span class="link-text">Settings</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{route('employee.tutorial.settings')}}" class="nav-link">
                    <img src="{{ asset('assets/navigations/guide-3.png') }}" alt="Guide">
                    <span class="link-text">Guide</span>
                </a>
            </li>


        </ul>
    </nav>

    <div class="sidebar-footer">

        <form action="{{ route('logout') }}" method="post" class="logout-form">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </button>
        </form>

        <button id="sidebarToggle" class="toggle-btn">
            <i class="bi bi-chevron-double-right" id="toggleIcon"></i>
        </button>
    </div>
</aside>

{{-- SIDEBAR SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const sidebar = document.getElementById('sidebar');
    const mainContent = document.querySelector('.main-content');
    const toggleBtn = document.getElementById('sidebarToggle');
    const toggleIcon = document.getElementById('toggleIcon');

    function updateIcon() {
        const expanded = sidebar.classList.contains('expanded');
        toggleIcon.classList.toggle('bi-chevron-double-left', expanded);
        toggleIcon.classList.toggle('bi-chevron-double-right', !expanded);
    }
    if (window.innerWidth > 480) {
        const isExpanded = localStorage.getItem('sidebar-expanded') === 'true';

        if (isExpanded) {
            sidebar.classList.add('expanded');
            mainContent?.classList.add('main-content-expanded');
        }
    } else {
        sidebar.classList.remove('expanded');
        mainContent?.classList.remove('main-content-expanded');
    }
    updateIcon();
    
    toggleBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        sidebar.classList.toggle('expanded');
        updateIcon();

        if (window.innerWidth > 480) {
            localStorage.setItem(
                'sidebar-expanded',
                sidebar.classList.contains('expanded')
            );
        }
    });

    document.addEventListener('click', function (e) {
        const isClickInsideSidebar = sidebar.contains(e.target);
        const isClickOnToggle = toggleBtn.contains(e.target);

        if (!isClickInsideSidebar && !isClickOnToggle) {
            sidebar.classList.remove('expanded');
            mainContent?.classList.remove('main-content-expanded');
            updateIcon();

            if (window.innerWidth > 480) {
                localStorage.setItem('sidebar-expanded', false);
            }
        }
    });
});
</script>

<style>
    @media (max-width: 480px) {

    .sidebar-container {
        position: fixed;
        left: -260px;
        top: 0;
        height: 100vh;
        width: 260px;
        transition: 0.3s ease;
        z-index: 1050;
    }

    .sidebar-container.expanded {
        left: 0;
    }

    .main-content {
        margin-left: 0px !important;
    }
    .nav-menu {
        margin-top: 0px;
    }
    .sidebar-header {
        margin-top: 60px;
        border-top: 1px solid rgba(255,255,255,0.1);
        padding-top: 40px;
    }

     .toggle-btn {
        position: fixed;
        top: 20px;
        left: 15px;
        z-index: 1100;

        width: 45px;
        height: 45px;
        border-radius: 12px;
        border: none;

        display: flex;
        align-items: center;
        justify-content: center;

        transition: all 0.3s ease;
    }

    /* 🔹 When sidebar is CLOSED */
    .sidebar-container:not(.expanded) ~ .sidebar-footer .toggle-btn,
    .sidebar-container:not(.expanded) .toggle-btn {
        background: #ffffff;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.18);
    }

    /* 🔹 When sidebar is OPEN */
    .sidebar-container.expanded .toggle-btn {
        background: transparent;
        box-shadow: none;
    }
}
</style>