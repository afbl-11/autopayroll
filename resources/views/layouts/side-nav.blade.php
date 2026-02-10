@vite(['resources/css/theme.css', 'resources/css/includes/sidebar.css'])

<aside class="sidebar-container" id="sidebar">
    {{-- HEADER --}}
    <div class="sidebar-header">
        <div class="logo-wrapper">
            <x-logo-minimized />
        </div>
        <span class="brand-name">Auto<span style="color:#FFD858;">Payroll</span>
        </span>
    </div>

    {{-- NAVIGATION --}}
    <div class="nav-menu">
        <ul class="nav-list">

            <li class="nav-item-4">
                <a href="{{ route('dashboard') }}"
                   class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <img src="{{ asset('assets/navigations/home.png') }}" alt="Home">
                    <span class="link-text">Home</span>
                </a>
            </li>

            <li class="nav-item-4">
                <a href="{{ route('employee.dashboard') }}"
                   class="nav-link {{ request()->routeIs('employee.*') ? 'active' : '' }}">
                    <img src="{{ asset('assets/navigations/employee.png') }}" alt="Employees">
                    <span class="link-text">Employees</span>
                </a>
            </li>

            <li class="nav-item-4">
                <a href="{{ route('company.dashboard') }}"
                   class="nav-link {{ request()->routeIs('company.*') ? 'active' : '' }}">
                    <img src="{{ asset('assets/navigations/Building.png') }}" alt="Companies">
                    <span class="link-text">Companies</span>
                </a>
            </li>

            <li class="nav-item-4">
                <a href="{{ route('adjustments') }}"
                   class="nav-link {{ request()->routeIs('adjustments') ? 'active' : '' }}">
                    <img src="{{ asset('assets/navigations/compliance.png') }}" alt="Compliance">
                    <span class="link-text">Compliance</span>
                </a>
            </li>

            <li class="nav-item-4">
                <a href="{{ route('announcements') }}"
                   class="nav-link {{ request()->routeIs('announcements') ? 'active' : '' }}">
                    <img src="{{ asset('assets/navigations/bell.png') }}" alt="Notifications">
                    <span class="link-text">Notifications</span>
                </a>
            </li>

            <li class="nav-item-4">
                <a href="{{ route('salary.list') }}"
                   class="nav-link {{ request()->routeIs('salary.*') ? 'active' : '' }}">
                    <img src="{{ asset('assets/navigations/salary.png') }}" alt="Salary">
                    <span class="link-text">Salary</span>
                </a>
            </li>

            <li class="nav-item-4">
                <a href="{{ route('new.payroll') }}"
                   class="nav-link {{ request()->routeIs('new.payroll') ? 'active' : '' }}">
                    <img src="{{ asset('assets/navigations/payroll.png') }}" alt="Payroll">
                    <span class="link-text">Payroll</span>
                </a>
            </li>

            <li class="nav-item-4">
                <a href="{{ route('edit.deductions-sss') }}"
                   class="nav-link {{ request()->routeIs('edit.deductions-sss') ? 'active' : '' }}">
                    <img src="{{ asset('assets/navigations/SSS.png') }}" alt="Payroll">
                    <span class="link-text">SSS</span>
                </a>
            </li>

            <li class="nav-item-4">
                <a href="{{ route('edit.deductions-pagibig') }}"
                   class="nav-link {{ request()->routeIs('edit.deductions-pagibig') ? 'active' : '' }}">
                    <img src="{{ asset('assets/navigations/pag-ibig.png') }}" alt="Payroll">
                    <span class="link-text">Pag-Ibig</span>
                </a>
            </li>

            <li class="nav-item-4">
                <a href="{{ route('edit.deductions-philhealth') }}"
                   class="nav-link {{ request()->routeIs('edit.deductions-philhealth') ? 'active' : '' }}">
                    <img src="{{ asset('assets/navigations/philhealth.png') }}" alt="Payroll">
                    <span class="link-text">PhilHealth</span>
                </a>
            </li>

            <li class="nav-item-4">
                <a href="{{ route('attendance.manual') }}"
                   class="nav-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}">
                    <img src="{{ asset('assets/navigations/attendance.png') }}" alt="Attendance">
                    <span class="link-text">Attendance</span>
                </a>
            </li>

        </ul>
    </div>

    {{-- FOOTER --}}
    <div class="sidebar-footer">

        <a href="{{ route('admin.settings') }}"
           class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
            <img src="{{ asset('assets/navigations/settings.png') }}" alt="Settings">
            <span class="link-text">Settings</span>
        </a>

        <form action="{{ route('logout') }}" method="POST" class="logout-form">
            @csrf
            <button type="submit" class="logout-btn">
                <img src="{{ asset('assets/navigations/exit.png') }}" alt="Logout">
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