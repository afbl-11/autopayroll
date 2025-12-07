@vite(['resources/css/employee_web/announcement.css', 'resources/css/theme.css', 'resources/css/includes/sidebar.css'])

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<x-root>
    @include('layouts.employee-side-nav')
    
    <main class="main-content">
        <div class="container-fluid p-0">
            
            <div class="row mb-5">
                <div class="col">
                    <h2 class="fw-bold mb-2" style="color: var(--clr-primary);">Announcements</h2>
                    <p class="text-muted mb-0">View all company-wide updates, memos, and payroll notices.</p>
                </div>
            </div>

            <ul class="nav filter-tabs mb-4" id="announcementTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" data-filter="all">All</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-filter="payroll">Payroll</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-filter="admin">Admin</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-filter="memo">Memo</button>
                </li>
            </ul>

            <div class="announcement-list-wrapper">
                <div class="row g-4" id="announcementList">
                    
                    <div class="col-12 announcement-item" data-type="admin">
                        <div class="d-flex announcement-card align-items-start">
                            <div class="announcement-icon-wrapper me-4">
                                <i class="bi bi-gear-fill icon-admin"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h5 class="fw-bold mb-0">System Maintenance</h5>
                                    <span class="small text-muted">Dec 01, 2025</span>
                                </div>
                                <p class="text-muted small mb-3 text-uppercase fw-bold" style="font-size: 0.75rem;">Admin Update</p>
                                <p class="mb-0 text-secondary">The payroll system will be down tonight from 10:00 PM to 12:00 AM for scheduled server maintenance and security patches.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 announcement-item" data-type="memo">
                        <div class="d-flex announcement-card align-items-start">
                            <div class="announcement-icon-wrapper me-4">
                                <i class="bi bi-calendar-heart-fill icon-holiday"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h5 class="fw-bold mb-0">Holiday Notice</h5>
                                    <span class="small text-muted">Nov 14, 2025</span>
                                </div>
                                <p class="text-muted small mb-3 text-uppercase fw-bold" style="font-size: 0.75rem;">General Memo</p>
                                <p class="mb-0 text-secondary">The office will be closed on **November 30** for the public holiday. Regular operations resume on December 1.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 announcement-item" data-type="payroll">
                        <div class="d-flex announcement-card align-items-start">
                            <div class="announcement-icon-wrapper me-4">
                                <i class="bi bi-receipt icon-payroll"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h5 class="fw-bold mb-0">Payslip Schedule Adjustment</h5>
                                    <span class="small text-muted">Nov 10, 2025</span>
                                </div>
                                <p class="text-muted small mb-3 text-uppercase fw-bold" style="font-size: 0.75rem;">Payroll</p>
                                <p class="mb-0 text-secondary">Please note the payslip release date for the Nov 16-30 payroll period has been moved up to **Dec 15, 2025**.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </main>
</x-root>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('#announcementTabs button');
        const announcementItems = document.querySelectorAll('.announcement-item');

        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                const filterType = this.getAttribute('data-filter');
                
                announcementItems.forEach(item => {
                    const itemType = item.getAttribute('data-type');
                    
                    if (filterType === 'all' || itemType === filterType) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    });
</script>