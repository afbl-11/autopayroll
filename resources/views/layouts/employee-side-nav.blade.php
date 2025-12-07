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
                    <i class="bi bi-grid-fill"></i>
                    <span class="link-text">Dashboard</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-receipt"></i>
                    <span class="link-text">Payslips</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-megaphone-fill"></i>
                    <span class="link-text">Announcements</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-sliders"></i>
                    <span class="link-text">Credit Adjustment</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-file-earmark-text-fill"></i>
                    <span class="link-text">Leave Filing</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.querySelector('.main-content');
        const toggleBtn = document.getElementById('sidebarToggle');
        const toggleIcon = document.getElementById('toggleIcon');
        
        // Updated function to use Bootstrap Icon classes
        function updateIcon(isExpanded) {
            if (isExpanded) {
                // If expanded, show 'Left' arrow to collapse
                toggleIcon.classList.remove('bi-chevron-double-right');
                toggleIcon.classList.add('bi-chevron-double-left');
            } else {
                // If collapsed, show 'Right' arrow to expand
                toggleIcon.classList.remove('bi-chevron-double-left');
                toggleIcon.classList.add('bi-chevron-double-right');
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