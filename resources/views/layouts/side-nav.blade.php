@vite(['resources/css/theme.css', 'resources/css/includes/sidebar.css' ])

<aside>
    <div class="logo-container">
        <div class="logo minimized">
            <x-logo-minimized />
        </div>

        <div class="logo expanded">
            <x-logo-expand />
        </div>
    </div>
    <div class="nav-menu">
        <div class="nav-wrapper">
            <ul>
                <li>
                    <a href="{{route('dashboard')}}">
                        <img src="{{ asset('assets/navigations/home.png') }}" alt="Home Icon">
                        <span>Home</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('employee.dashboard')}}">
                        <img src="{{ asset('assets/navigations/employee.png') }}" alt="Employee Icon">
                        <span>Employees</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('company.dashboard')}}">
                        <img src="{{asset('assets/navigations/Building.png')}}" alt="Company">
                        <span>Companies</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('adjustments')}}">
                        <img src="{{ asset('assets/navigations/compliance.png') }}" alt="Compliance Icon">
                        <span>Compliance</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('announcements')}}">
                        <img src="{{ asset('assets/navigations/bell.png') }}" alt="Notifications Icon">
                        <span>Notifications</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('new.payroll')}}">
                        <img src="{{ asset('assets/navigations/payroll.png') }}">
                        <span>Payroll</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="logout">
        <ul>
            <li>
                <a href="{{route('admin.settings')}}">
                    <img src="{{ asset('assets/navigations/settings.png') }}" alt="Settings Icon">
                    <span>Settings</span>
                </a>
            </li>
        </ul>

        <form action="{{route('logout')}}" method="post" class="logout-btn">
            @csrf
            <button type="submit">
                <img src="{{ asset('assets/navigations/exit.png') }}" alt="Logout Icon">
                <span>Logout</span>
            </button>
        </form>

    </div>
</aside>
