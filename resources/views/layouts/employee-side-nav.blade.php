@vite(['resources/css/theme.css', 'resources/css/includes/sidebar.css'])

<aside>
    <x-logo-minimized></x-logo-minimized>
    <div class="nav-menu">
        {{-- Navigation links will go here in the future --}}
    </div>
    <div class="logout">
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <x-button-submit icon="assets/navigations/exit.png"></x-button-submit>
        </form>
    </div>
</aside>
