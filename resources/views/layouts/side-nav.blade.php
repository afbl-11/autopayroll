@vite(['resources/css/theme.css', 'resources/css/includes/sidebar.css' ])

<aside>
    <x-logo-minimized></x-logo-minimized>
    <div class="nav-menu">
        <ul>
            <li>
                <a href="{{route('dashboard')}}">
                    <img src="{{ asset('assets/navigations/home.png') }}" alt="Home Icon">
                </a>
            </li>
            <li>
                <a href="{{route('employee.dashboard')}}">
                    <img src="{{ asset('assets/navigations/employee.png') }}" alt="Employee Icon">
                </a>
            </li>
            <li>
                <a href="#">
                    <img src="{{ asset('assets/navigations/compliance.png') }}" alt="Compliance Icon">
                </a>
            </li>
            <li>
                <a href="#">
                    <img src="{{ asset('assets/navigations/bell.png') }}" alt="Notifications Icon">
                </a>
            </li>
        </ul>

    </div>
        <div class="logout">
            <ul>
                <li>
                    <a href="#">
                        <img src="{{ asset('assets/navigations/settings.png') }}" alt="Settings Icon">
                    </a>
                </li>
            </ul>
            <form action="{{route('logout')}}" method="post">
                <x-button-image icon="assets/navigations/exit.png"></x-button-image>
            </form>
        </div>

</aside>




