<div class="sidebar">
    <div class="sidebar-logo">
        A<span>P</span>
    </div>

    <nav class="nav-menu">
        <ul>
            <li>
                <a href="#">
                    <img src="{{ asset('assets/navigations/home.png') }}" alt="Home Icon">
                </a>
            </li>
            <li>
                <a href="{{route('employee.register')}}">
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
            <li>
                <a href="#">
                    <img src="{{ asset('assets/navigations/settings.png') }}" alt="Settings Icon">
                </a>
            </li>
        </ul>
    </nav>

    <div class="logout">
        <form action="{{route('logout')}}" method="post">
        <button type="submit" class="button-logout">Logout</button>
        </form>
    </div>
</div>
