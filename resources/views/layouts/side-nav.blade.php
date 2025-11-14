@vite(['resources/css/theme.css', 'resources/css/includes/sidebar.css' ])

<aside>
    <x-logo-minimized></x-logo-minimized>
    <div class="nav-menu">
        <div class="nav-wrapper">
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
                    <a href="{{route('company.dashboard')}}">
                        <img src="{{asset('assets/navigations/Building.png')}}" alt="Company">
                    </a>
                </li>
                <li>
                    <a href="{{route('adjustments')}}">
                        <img src="{{ asset('assets/navigations/compliance.png') }}" alt="Compliance Icon">
                    </a>
                </li>
                <li>
                    <a href="{{route('announcements')}}">
                        <img src="{{ asset('assets/navigations/bell.png') }}" alt="Notifications Icon">
                    </a>
                </li>
            </ul>
        </div>


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
                @csrf
                <x-button-submit icon="assets/navigations/exit.png"></x-button-submit>
            </form>
        </div>

</aside>




