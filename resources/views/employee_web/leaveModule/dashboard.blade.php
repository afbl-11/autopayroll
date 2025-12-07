@vite(['resources/css/employee_web/leaveModule/leaveModule.css', 'resources/css/theme.css', 'resources/css/includes/sidebar.css'])

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<x-root>
    @include('layouts.employee-side-nav')
    
    <main class="main-content">
        <div class="container-fluid p-0">
            
            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="fw-bold mb-1" style="color: var(--clr-primary);">Leave Filing</h2>
                    <p class="text-muted mb-0">Manage and track your leave requests and credits.</p>
                </div>
            </div>

            <div class="row g-3 mb-5">
                <div class="col-xl-3 col-md-6 col-sm-6">
                    <div class="card-credit credit-vacation">
                        <div class="credit-icon bg-vacation-light">
                            <i class="bi bi-airplane-fill"></i>
                        </div>
                        <h6 class="text-muted text-uppercase small fw-bold mb-1">Vacation</h6>
                        <h3 class="fw-bold mb-0">5 <small class="fs-6 text-muted fw-normal">days</small></h3>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 col-sm-6">
                    <div class="card-credit credit-sick">
                        <div class="credit-icon bg-sick-light">
                            <i class="bi bi-bandaid-fill"></i>
                        </div>
                        <h6 class="text-muted text-uppercase small fw-bold mb-1">Sick</h6>
                        <h3 class="fw-bold mb-0">4 <small class="fs-6 text-muted fw-normal">days</small></h3>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 col-sm-6">
                    <div class="card-credit credit-maternity">
                        <div class="credit-icon bg-maternity-light">
                            <i class="bi bi-balloon-heart-fill"></i>
                        </div>
                        <h6 class="text-muted text-uppercase small fw-bold mb-1">Maternity</h6>
                        <h3 class="fw-bold mb-0">90 <small class="fs-6 text-muted fw-normal">days</small></h3>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 col-sm-6">
                    <div class="card-credit credit-bereavement">
                        <div class="credit-icon bg-bereavement-light">
                            <i class="bi bi-heartbreak-fill"></i>
                        </div>
                        <h6 class="text-muted text-uppercase small fw-bold mb-1">Bereavement</h6>
                        <h3 class="fw-bold mb-0">7 <small class="fs-6 text-muted fw-normal">days</small></h3>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                
                <div class="col-xl-8 col-lg-7">
                    
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <form class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Date Range</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" placeholder="From">
                                        <span class="input-group-text bg-white border-start-0 border-end-0 text-muted">-</span>
                                        <input type="date" class="form-control border-start-0" placeholder="To">
                                    </div>
                                </div>
                                
                                <div class="col-md-2">
                                    <label class="form-label">Leave Type</label>
                                    <select class="form-select">
                                        <option value="all">All Types</option>
                                        <option value="vl">Vacation</option>
                                        <option value="sl">Sick</option>
                                        <option value="ml">Maternity</option>
                                        <option value="bl">Bereavement</option>
                                    </select>
                                </div>

                                <div class="col-md-6 d-flex gap-2 align-items-end">
                                    <div class="flex-grow-1">
                                        <label class="form-label">Status</label>
                                        <select class="form-select">
                                            <option value="all">All Statuses</option>
                                            <option value="pending">Pending</option>
                                            <option value="approved">Approved</option>
                                            <option value="rejected">Rejected</option>
                                        </select>
                                    </div>

                                    <button type="button" class="btn btn-light border" style="height: 42px; width: 42px;" title="Filter">
                                        <i class="bi bi-funnel"></i>
                                    </button>
                                    
                                    <button type="button" class="btn fw-bold d-flex align-items-center gap-2" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#fileLeaveModal"
                                            style="height: 42px; background-color: var(--clr-yellow); color: var(--clr-indigo); white-space: nowrap;">
                                        <i class="bi bi-plus-circle-fill"></i> 
                                        <span>File Leave</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold mb-0">Leave Requests</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="ps-4 py-3 text-secondary small text-uppercase">Filed Date</th>
                                            <th class="py-3 text-secondary small text-uppercase">Leave Date(s)</th>
                                            <th class="py-3 text-secondary small text-uppercase">Type</th>
                                            <th class="py-3 text-secondary small text-uppercase text-center">Status</th>
                                            <th class="pe-4 py-3 text-secondary small text-uppercase text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="ps-4 text-muted">Dec 01, 2025</td>
                                            <td class="fw-bold">Dec 24 - Dec 26</td>
                                            <td>Vacation Leave</td>
                                            <td class="text-center"><span class="badge-status status-approved">Approved</span></td>
                                            <td class="pe-4 text-end">
                                                <button class="btn btn-sm btn-light" title="View Details"><i class="bi bi-eye"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="ps-4 text-muted">Dec 05, 2025</td>
                                            <td class="fw-bold">Jan 02, 2026</td>
                                            <td>Sick Leave</td>
                                            <td class="text-center"><span class="badge-status status-pending">Pending</span></td>
                                            <td class="pe-4 text-end">
                                                <button class="btn btn-sm btn-light" title="View Details"><i class="bi bi-eye"></i></button>
                                                <button class="btn btn-sm btn-light text-danger" title="Cancel Request"><i class="bi bi-x-circle"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="ps-4 text-muted">Nov 20, 2025</td>
                                            <td class="fw-bold">Nov 21</td>
                                            <td>Bereavement</td>
                                            <td class="text-center"><span class="badge-status status-revision">Revision</span></td>
                                            <td class="pe-4 text-end">
                                                <button class="btn btn-sm btn-light text-primary" title="Edit"><i class="bi bi-pencil-square"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-5">
                    <div class="calendar-widget shadow-sm sticky-top" style="top: 20px; z-index: 1;">
                        
                        <div class="calendar-header">
                            <button class="btn btn-sm text-white" id="prevMonth"><i class="bi bi-chevron-left"></i></button>
                            <span class="fw-bold" id="currentMonthYear">December 2025</span>
                            <button class="btn btn-sm text-white" id="nextMonth"><i class="bi bi-chevron-right"></i></button>
                        </div>

                        <div class="calendar-days">
                            <div class="day-name">Sun</div>
                            <div class="day-name">Mon</div>
                            <div class="day-name">Tue</div>
                            <div class="day-name">Wed</div>
                            <div class="day-name">Thu</div>
                            <div class="day-name">Fri</div>
                            <div class="day-name">Sat</div>
                        </div>

                        <div class="calendar-grid" id="calendarGrid">
                            </div>

                        <div class="p-3 border-top bg-light">
                            <div class="d-flex justify-content-center gap-3">
                                <div class="d-flex align-items-center">
                                    <span class="legend-dot" style="background: #2ecc71;"></span>
                                    <small class="text-muted">Approved</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="legend-dot" style="background: #f1c40f;"></span>
                                    <small class="text-muted">Pending</small>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <div class="modal fade" id="fileLeaveModal" tabindex="-1" aria-labelledby="fileLeaveModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                    
                    <div class="modal-header border-0 pb-0">
                        <button type="button" class="btn p-0 text-dark fw-bold fs-5" data-bs-dismiss="modal" style="border: none; background: none;">
                            <i class="bi bi-arrow-left"></i> File a Leave
                        </button>
                    </div>

                    <div class="modal-body p-4">
                        <form action="#" method="POST" enctype="multipart/form-data">
                            @csrf 

                            <div class="form-floating mb-3">
                                <select class="form-select border-secondary-subtle" id="leaveType" name="leave_type" aria-label="Leave Type" style="border-radius: 10px;">
                                    <option selected>Sick Leave</option>
                                    <option value="vacation">Vacation Leave</option>
                                    <option value="maternity">Maternity Leave</option>
                                    <option value="emergency">Bereavement Leave</option>
                                </select>
                                <label for="leaveType" class="text-muted">Leave Type</label>
                            </div>

                            <div class="mb-3">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control border-secondary-subtle" id="startDate" name="start_date" style="border-radius: 10px;">
                                    <label for="startDate" class="text-muted">Start Date</label>
                                </div>

                                <div class="form-floating">
                                    <input type="date" class="form-control border-secondary-subtle" id="endDate" name="end_date" style="border-radius: 10px;">
                                    <label for="endDate" class="text-muted">End Date</label>
                                </div>
                            </div>

                            <div class="form-floating mb-4">
                                <textarea class="form-control border-secondary-subtle" placeholder="Reason" id="leaveReason" name="reason" style="height: 120px; border-radius: 10px;"></textarea>
                                <label for="leaveReason" class="text-muted">Reason</label>
                            </div>

                            <div class="mb-4">
                                <label for="attachment" class="w-100 cursor-pointer">
                                    <div class="btn w-100 d-flex align-items-center justify-content-center py-2 text-dark" 
                                        style="border-radius: 25px; border: 1px solid #ced4da; background-color: white;">
                                        <i class="bi bi-paperclip me-2 fs-5"></i> 
                                        <span id="fileName" class="fw-normal">Attach Image / File</span>
                                    </div>
                                    <input type="file" id="attachment" name="attachment" class="d-none" onchange="updateFileName(this)">
                                </label>
                            </div>

                            <div class="d-grid">
                                <button type="button" class="btn text-white py-3 fw-bold" style="background-color: #1a202c; border-radius: 25px;">
                                    SUBMIT
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        </main>
</x-root>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const grid = document.getElementById('calendarGrid');
        const monthLabel = document.getElementById('currentMonthYear');
        let date = new Date(); 

        const leaveEvents = {
            '2025-12-24': 'event-approved',
            '2025-12-25': 'event-approved',
            '2025-12-26': 'event-approved',
            '2026-01-02': 'event-pending'
        };

        function renderCalendar() {
            grid.innerHTML = '';
            const year = date.getFullYear();
            const month = date.getMonth();
            const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            monthLabel.innerText = `${monthNames[month]} ${year}`;
            const firstDayIndex = new Date(year, month, 1).getDay();
            const lastDay = new Date(year, month + 1, 0).getDate();
            const prevLastDay = new Date(year, month, 0).getDate();
            
            for (let x = firstDayIndex; x > 0; x--) {
                const dayDiv = document.createElement('div');
                dayDiv.classList.add('calendar-date', 'other-month');
                dayDiv.innerText = prevLastDay - x + 1;
                grid.appendChild(dayDiv);
            }

            for (let i = 1; i <= lastDay; i++) {
                const dayDiv = document.createElement('div');
                dayDiv.classList.add('calendar-date');
                dayDiv.innerText = i;
                if (i === new Date().getDate() && month === new Date().getMonth() && year === new Date().getFullYear()) {
                    dayDiv.classList.add('today');
                }
                const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
                if (leaveEvents[dateString]) {
                    dayDiv.classList.add('date-has-event', leaveEvents[dateString]);
                }
                grid.appendChild(dayDiv);
            }
        }

        document.getElementById('prevMonth').addEventListener('click', () => {
            date.setMonth(date.getMonth() - 1);
            renderCalendar();
        });

        document.getElementById('nextMonth').addEventListener('click', () => {
            date.setMonth(date.getMonth() + 1);
            renderCalendar();
        });

        renderCalendar();
    });

    // FUNCTION FOR FILE ATTACHMENT NAME UPDATE
    function updateFileName(input) {
        if (input.files && input.files.length > 0) {
            var fileName = input.files[0].name;
            document.getElementById('fileName').innerText = fileName;
            
            // Visual feedback: change border to green/solid
            const btn = input.parentElement.querySelector('.btn');
            btn.classList.remove('btn-outline-secondary');
            btn.classList.add('btn-outline-success');
            btn.style.borderStyle = 'solid';
        }
    }
</script>