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
                <a href="#" class="nav-link active">
                    <i class="fas fa-th-large"></i>
                    <span class="link-text">Dashboard</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-file-invoice-dollar"></i>
                    <span class="link-text">Payslips</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-user-clock"></i>
                    <span class="link-text">Attendance</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-sliders-h"></i>
                    <span class="link-text">Credit Adjustment</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-file-signature"></i>
                    <span class="link-text">Leave Filing</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-cog"></i>
                    <span class="link-text">Settings</span>
                </a>
            </li>
        </ul>
    </nav>

    <div class="sidebar-footer">
        
        <form action="{{ route('logout') }}" method="post" class="logout-form">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </form>

        <button id="sidebarToggle" class="toggle-btn">
            <i class="fas fa-angle-double-right" id="toggleIcon"></i>
        </button>
    </div>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.querySelector('.main-content');
        const toggleBtn = document.getElementById('sidebarToggle');
        const toggleIcon = document.getElementById('toggleIcon');
        

        function updateIcon(isExpanded) {
            if (isExpanded) {

                toggleIcon.classList.remove('fa-angle-double-right');
                toggleIcon.classList.add('fa-angle-double-left');
            } else {

                toggleIcon.classList.remove('fa-angle-double-left');
                toggleIcon.classList.add('fa-angle-double-right');
            }
        }


        const isExpanded = localStorage.getItem('sidebar-expanded') === 'true';
        
        if (isExpanded) {
            sidebar.classList.add('expanded');

            if (mainContent) mainContent.classList.add('main-content-expanded');
            updateIcon(true);
        }


        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('expanded');
            
            const expanded = sidebar.classList.contains('expanded');
            

            if (mainContent) {
                mainContent.classList.toggle('main-content-expanded');
            }
            
            updateIcon(expanded);
            

            localStorage.setItem('sidebar-expanded', expanded);
        });
    });
</script>