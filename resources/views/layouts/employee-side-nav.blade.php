@vite(['resources/css/theme.css', 'resources/css/includes/sidebar.css'])

<aside class="sidebar-container" id="sidebar">
    <div class="sidebar-header">
        <div class="logo-wrapper">
            <x-logo-minimized></x-logo-minimized>
        </div>
        <span class="brand-name">AutoPayroll</span>
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

    function updateIcon(expanded) {
        toggleIcon.classList.toggle('bi-chevron-double-left', expanded);
        toggleIcon.classList.toggle('bi-chevron-double-right', !expanded);
    }

    const isExpanded = localStorage.getItem('sidebar-expanded') === 'true';
    if (isExpanded) {
        sidebar.classList.add('expanded');
        mainContent?.classList.add('main-content-expanded');
        updateIcon(true);
    }

    sidebar.addEventListener('click', function (e) {
        e.stopPropagation();
    });

    toggleBtn.addEventListener('click', function (e) {
        e.stopPropagation();

        sidebar.classList.toggle('expanded');
        const expanded = sidebar.classList.contains('expanded');

        mainContent?.classList.toggle('main-content-expanded');
        updateIcon(expanded);
        localStorage.setItem('sidebar-expanded', expanded);
    });

    document.addEventListener('click', function () {
        sidebar.classList.remove('expanded');
        mainContent?.classList.remove('main-content-expanded');
        updateIcon(false);
        localStorage.setItem('sidebar-expanded', false);
    });
});
</script>