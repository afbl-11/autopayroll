@vite(['resources/css/employee_web/leaveModule/leaveModule.css', 'resources/css/theme.css', 'resources/css/includes/sidebar.css'])

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const approvedLeaves = @json($approved);
    const pendingLeaves  = @json($pending);
</script>
<x-root>
    @include('layouts.employee-side-nav')

    <main class="main-content">
        @if (session('success'))
            <div class="custom-alert">
                {{ session('success') }}
            </div>
        @endif
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
                        <h3 class="fw-bold mb-0">{{$log['vacation']}} <small class="fs-6 text-muted fw-normal">days</small></h3>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 col-sm-6">
                    <div class="card-credit credit-sick">
                        <div class="credit-icon bg-sick-light">
                            <i class="bi bi-bandaid-fill"></i>
                        </div>
                        <h6 class="text-muted text-uppercase small fw-bold mb-1">Sick</h6>
                        <h3 class="fw-bold mb-0">{{$log['sick']}} <small class="fs-6 text-muted fw-normal">days</small></h3>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 col-sm-6">
                    <div class="card-credit credit-maternity">
                        <div class="credit-icon bg-maternity-light">
                            <i class="bi bi-balloon-heart-fill"></i>
                        </div>
                        <h6 class="text-muted text-uppercase small fw-bold mb-1">Maternity</h6>
                        @if(isset($log['maternity']) && $log['maternity'] > 0)
                                <h3 class="fw-bold mb-0">{{$log['maternity']}} <small class="fs-6 text-muted fw-normal">days</small></h3>
                            @if(empty($log['maternity']))
                            <h3 class="fw-bold mb-0">0<small class="fs-6 text-muted fw-normal">days</small></h3>
                            @endif
                        @endif

                        @if(isset($log['paternity']) && $log['paternity'] > 0)
                                <h3 class="fw-bold mb-0">{{$log['paternity']}} <small class="fs-6 text-muted fw-normal">days</small></h3>
                            @if(empty($log['paternity']))

                            <h3 class="fw-bold mb-0">0<small class="fs-6 text-muted fw-normal">days</small></h3>
                            @endif
                        @endif

                    </div>
                </div>

                <div class="col-xl-3 col-md-6 col-sm-6">
                    <div class="card-credit credit-bereavement">
                        <div class="credit-icon bg-bereavement-light">
                            <i class="bi bi-heartbreak-fill"></i>
                        </div>
                        <h6 class="text-muted text-uppercase small fw-bold mb-1">Bereavement</h6>
                        <h3 class="fw-bold mb-0">{{$log['bereavement']}} <small class="fs-6 text-muted fw-normal">days</small></h3>
                    </div>
                </div>
            </div>

            <div class="row g-4">

                <div class="col-xl-8 col-lg-7">

                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <form class="row g-3" action="{{route('employee_web.filter.leave')}}" method="get">

                                    {{-- Date Range --}}
                                    <div class="col-lg-3 col-md-6">
                                        <label class="form-label text-muted small fw-bold">Date Range</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control" name="from"
                                                   value="{{ request('from') }}">
                                            <span class="input-group-text bg-white border-start-0 border-end-0 text-muted">-</span>
                                            <input type="date" class="form-control border-start-0" name="to"
                                                   value="{{ request('to') }}">
                                        </div>
                                    </div>


                                <div class="col-md-2">
                                    <label class="form-label">Leave Type</label>
                                    <select class="form-select" name="type">
                                        <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>All Types</option>
                                        <option value="Vacation" {{ request('type') == 'Vacation' ? 'selected' : '' }}>Vacation</option>
                                        <option value="Sick" {{ request('type') == 'Sick' ? 'selected' : '' }}>Sick</option>
                                    </select>
                                </div>

                                <div class="col-md-6 d-flex flex-wrap gap-2 align-items-end">
                                    <div class="flex-grow-1">
                                        <label class="form-label">Status</label>
                                        <select class="form-select" name="status">
                                            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Statuses</option>
                                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-light border" style="height: 42px; width: 42px;" title="Filter">
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
{{--                    Leave Requests--}}
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
                                    @forelse($requests as $request)
                                        <tr>
                                            <td class="ps-4 text-muted">  {{ \Carbon\Carbon::parse($request['created_at'])->format('F d, Y') }}</td>
                                            <td class="fw-bold">
                                                {{ \Carbon\Carbon::parse($request['start_date'])->format('M d') }} -
                                                {{ \Carbon\Carbon::parse($request['end_date'])->format('M d') }}
                                            </td>

                                            <td>{{$request['leave_type']}}</td>
                                            <td class="text-center"><span class="badge-status status-approved">{{$request['status']}}</span></td>
                                            <td class="pe-4 text-end">
                                                <button
                                                    class="btn btn-sm btn-light view-leave-btn"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#viewLeaveModal"
                                                    data-type="{{ $request['leave_type'] }}"
                                                    data-start="{{ $request['start_date'] }}"
                                                    data-end="{{ $request['end_date'] }}"
                                                    data-status="{{ $request['status'] }}"
                                                    data-reason="{{ $request['reason'] }}"
                                                    data-submitted="{{ $request['created_at'] }}"
                                                    data-attachment="{{ $request['supporting_doc'] ? asset('storage/' . $request['supporting_doc']) : '' }}"
                                                    title="View Details">
                                                    <i class="bi bi-eye"></i>
                                                </button>

                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">
                                                No leave requests found.
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                                <div class="mt-3">
                                    {{ $requests->links('pagination::bootstrap-5') }}
                                </div>
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
                        <form action="{{route('employee_web.request.leave')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-floating mb-3">
                                <select class="form-select border-secondary-subtle" id="leaveType" name="leave_type" aria-label="Leave Type" style="border-radius: 10px;">
                                    <option selected>None</option>
                                    <option value="Vacation">Vacation Leave</option>
                                    <option value="Sick">Sick Leave</option>
                                    <option value="Maternity">Maternity Leave</option>
                                    <option value="Paternity">Paternity Leave</option>
                                    <option value="Bereavement">Bereavement Leave</option>
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
                                <button type="submit" class="btn text-white py-3 fw-bold" style="background-color: #1a202c; border-radius: 25px;">
                                    SUBMIT
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        </main>

    <div class="modal fade" id="viewLeaveModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">

                <!-- Modal Header -->
                <div class="modal-header bg-warning-subtle text-white p-4" style="border-bottom: none;">
                    <h5 class="modal-title fw-bold">Leave Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <p><strong>Type:</strong> <span id="modalLeaveType" class="text-dark"></span></p>
                            <p><strong>Period:</strong> <span id="modalLeavePeriod" class="text-dark"></span></p>
                            <p><strong>Status:</strong>
                                <span id="modalLeaveStatus" class="badge rounded-pill"></span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Submitted:</strong> <span id="modalLeaveSubmitted" class="text-dark"></span></p>
                            <p><strong>Reason:</strong></p>
                            <p id="modalLeaveReason" class="text-dark" style="white-space: pre-line;"></p>
                        </div>
                    </div>

                    <hr>

                    <!-- Attachment Preview -->
                    <div id="modalAttachmentWrapper">
                        <strong>Attachment:</strong>
                        <div id="modalLeaveAttachment" class="mt-2 d-flex justify-content-center align-items-center" style="min-height: 200px; border: 1px dashed #ced4da; border-radius: 10px; padding: 10px; overflow: hidden;">
                            <span class="text-muted">No attachment</span>
                        </div>
                        <div id="modalAttachmentActions" class="mt-2 text-center" style="display: none;">
                            <a id="modalAttachmentDownload" href="#" class="btn btn-outline-primary" download>Download File</a>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer border-0 p-4">
                    <button type="button" class="btn btn-secondary fw-bold" data-bs-dismiss="modal" style="border-radius: 25px; padding: 8px 30px;">Close</button>
                </div>
            </div>
        </div>
    </div>



</x-root>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const grid = document.getElementById('calendarGrid');
        const monthLabel = document.getElementById('currentMonthYear');
        let date = new Date();

        const leaveEvents = {};

        function expandRanges(leaves, statusClass) {
            leaves.forEach(leave => {
                let start = new Date(leave.start_date);
                let end   = new Date(leave.end_date);

                while (start <= end) {
                    const dateKey = start.toISOString().split('T')[0];
                    leaveEvents[dateKey] = statusClass;
                    start.setDate(start.getDate() + 1);
                }
            });
        }

// Build event map
        expandRanges(approvedLeaves, 'event-approved');
        expandRanges(pendingLeaves, 'event-pending');


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

    const successAlert = document.getElementById('success-alert');
    if (successAlert) {
        setTimeout(() => {
            successAlert.remove();
        }, 3500);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const leaveButtons = document.querySelectorAll('.view-leave-btn');

        leaveButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const type = this.dataset.type;
                const start = this.dataset.start;
                const end = this.dataset.end;
                const status = this.dataset.status;
                const reason = this.dataset.reason;
                const submitted = this.dataset.submitted;
                const attachment = this.dataset.attachment; // URL or null

                document.getElementById('modalLeaveType').innerText = type;
                document.getElementById('modalLeavePeriod').innerText =
                    new Date(start).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) +
                    ' - ' +
                    new Date(end).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                document.getElementById('modalLeaveSubmitted').innerText =
                    new Date(submitted).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                document.getElementById('modalLeaveReason').innerText = reason;

                // Status badge
                const statusBadge = document.getElementById('modalLeaveStatus');
                statusBadge.innerText = status;
                statusBadge.className = 'badge rounded-pill ' +
                    (status === 'approved' ? 'bg-success' : (status === 'pending' ? 'bg-warning text-dark' : 'bg-danger'));

                // Attachment handling
                const wrapper = document.getElementById('modalLeaveAttachment');
                const actions = document.getElementById('modalAttachmentActions');
                const downloadLink = document.getElementById('modalAttachmentDownload');

                wrapper.innerHTML = '';
                actions.style.display = 'none';

                if (attachment) {
                    const ext = attachment.split('.').pop().toLowerCase();
                    if (['png','jpg','jpeg','gif'].includes(ext)) {
                        const img = document.createElement('img');
                        img.src = attachment;
                        img.style.maxWidth = '100%';
                        img.style.maxHeight = '300px';
                        img.style.borderRadius = '10px';
                        wrapper.appendChild(img);
                        actions.style.display = 'block';
                        downloadLink.href = attachment;
                    } else if (ext === 'pdf') {
                        const embed = document.createElement('embed');
                        embed.src = attachment;
                        embed.type = 'application/pdf';
                        embed.style.width = '100%';
                        embed.style.height = '300px';
                        wrapper.appendChild(embed);
                        actions.style.display = 'block';
                        downloadLink.href = attachment;
                    } else {
                        // Other files: just a download button
                        wrapper.innerHTML = '<span class="text-muted">File available for download</span>';
                        actions.style.display = 'block';
                        downloadLink.href = attachment;
                    }
                } else {
                    wrapper.innerHTML = '<span class="text-muted">No attachment</span>';
                }
            });
        });
    });



</script>

<style>
    .custom-alert {
        position: fixed;
        top: 20px;
        right: 20px;
        background: rgba(255, 216, 88, 0.15);
        border: 1px solid var(--clr-yellow);
        color: var(--clr-indigo);
        padding: 12px 15px;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        z-index: 9999;
        animation: slideIn 0.4s ease, fadeOut 0.4s ease 3s forwards;
    }

    @keyframes slideIn {
        from { transform: translateX(30px); opacity: 0; }
        to   { transform: translateX(0); opacity: 1; }
    }

    @keyframes fadeOut {
        to { opacity: 0; transform: translateX(30px); }
    }
</style>
