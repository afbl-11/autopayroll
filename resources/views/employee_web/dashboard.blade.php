@vite(['resources/css/employee_web/dashboard.css', 'resources/css/theme.css', 'resources/css/includes/sidebar.css'])




<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<x-root>
    @include('layouts.employee-side-nav')

    <main class="main-content p-4">
        <div class="container-fluid">

            <div class="row mb-4 align-items-center">
                <div class="col-md-8">
                    <h2 class="fw-bold mb-1" style="color: var(--clr-primary);">Good Evening, {{$employee['first_name']}}!</h2>
                    <p class="text-muted mb-0">{{ ucwords(strtolower($employee->job_position)) }} • {{$company->company_name ?? 'Unassigned'}}</p>
                </div>
            </div>
            <div class="row g-3 mb-4">
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="card card-theme h-100 shadow-sm">
                        <div class="card-body text-center py-4">
                            <h6 class="text-muted text-uppercase small ls-1 mb-2">Regular</h6>
                            <h2 class="mb-0 fw-bold display-6">{{$attendanceSummary['hoursWorked'] ?? 0}}</h2>
                            <small class="text-muted">hours</small>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="card card-theme h-100 shadow-sm">
                        <div class="card-body text-center py-4">
                            <h6 class="text-muted text-uppercase small ls-1 mb-2">Overtime</h6>
                            <h2 class="mb-0 fw-bold display-6">{{$attendanceSummary['overtime'] ?? 0}}</h2>
                            <small class="text-muted">hours</small>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="card card-theme h-100 shadow-sm">
                        <div class="card-body text-center py-4">
                            <h6 class="text-muted text-uppercase small ls-1 mb-2">Late</h6>
                            <h2 class="mb-0 fw-bold text-danger display-6">{{$attendanceSummary['late'] ?? 0}}</h2>
                            <small class="text-muted">mins</small>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-sm-6">
                    <div class="card card-theme h-100 shadow-sm border-start-theme-yellow">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted text-uppercase small ls-1 mb-1">Leave Balance</h6>
                                <h2 class="mb-0 fw-bold display-6">{{$leaveBalance}}</h2>
                            </div>
                            <div class="icon-box bg-white text-warning shadow-sm">
                                <i class="bi bi-person-walking"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-sm-6">
                    <div class="card card-theme h-100 shadow-sm border-start-theme-red">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted text-uppercase small ls-1 mb-1">Absences</h6>
                                <h2 class="mb-0 fw-bold display-6">{{$absences}}</h2>
                            </div>
                            <div class="icon-box bg-white text-danger shadow-sm">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-lg-8">
                    <div class="card card-theme shadow-sm h-100">
                        <div class="card-header bg-transparent border-0 pt-4 px-4">
                            <h5 class="fw-bold mb-0">Most Recent Payslip</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead class="text-secondary small text-uppercase">
                                        <tr>
                                            <th class="ps-3">Net Earning</th>
                                            <th>Pay Date</th>
                                            <th>Status</th>
{{--                                            <th class="text-end pe-3">Action</th>--}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            @if($payslips)
                                                <td class="fw-bold ps-3">PHP {{$payslips->net_pay}}</td>
                                                <td>{{ \Carbon\Carbon::parse($payslips->pay_date)->format('M d, Y') }}
                                                </td>
                                                <td><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">{{$payslips->status}}</span></td>

                                                @else
                                                <td colspan="3"> <!-- span all columns -->
                                                    <p>No Payslip Record</p>
                                                </td>
                                            @endif
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card card-theme shadow-sm h-100">
                        <div class="card-header bg-transparent border-0 pt-4 px-4">
                            <h5 class="fw-bold mb-0">My Schedule</h5>
                        </div>
                        <div class="card-body text-center d-flex flex-column justify-content-center">
                            <p class="small text-uppercase text-muted mb-3">Shift Schedule</p>
                            <div class="d-flex justify-content-center align-items-center gap-3 mb-3">
                                <div><h2 class="fw-bold mb-0">{{$timeIn}}</h2><small>AM</small></div>
                                <i class="bi bi-arrow-right text-warning fs-4"></i>
                                <div><h2 class="fw-bold mb-0">{{$timeOut}}</h2><small>PM</small></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card card-theme shadow-sm h-100">
                        <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between">
                            <h5 class="fw-bold mb-0">Recent Attendance</h5>
                            <a href="#" class="text-muted small text-decoration-none">View All</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-middle table-hover">
                                    <thead class="text-secondary small text-uppercase">
                                        <tr>
                                            <th class="ps-3">Date</th>
                                            <th>Time In</th>
                                            <th>Time Out</th>
                                            <th>Total</th>
                                            <th class="text-end pe-3">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tbody>
                                    @forelse ($attendance as $log)
                                        <tr>
                                            <td class="ps-3 fw-bold">
                                                {{ \Carbon\Carbon::parse($log->log_date)->format('M d, Y') }}
                                            </td>

                                            <td>
                                                {{ $log->time_in ? \Carbon\Carbon::parse($log->time_in)->format('h:i A') : 'N/A' }}
                                            </td>

                                            <td>
                                                {{ $log->time_out ? \Carbon\Carbon::parse($log->time_out)->format('h:i A') : 'N/A' }}
                                            </td>
                                            @if($log->time_in && $log->time_out)
                                            <td>
                                                {{ \Carbon\Carbon::parse($log->time_in)->diffInHours(\Carbon\Carbon::parse($log->time_out)) ?? '-' }}
                                            </td>
                                            @else
                                                <td>
                                                    N/A
                                                </td>
                                            @endif

                                            <td class="text-end pe-3">

                                                @php
                                                    $statusLabel = 'N/A';

                                                    switch($log->status) {
                                                        case 'A':
                                                            $statusLabel = 'Absent';
                                                            break;
                                                        case 'P':
                                                            $statusLabel  = 'Present';
                                                            break;
                                                        case 'LT':
                                                            $statusLabel = 'Late/Under time';
                                                            break;
                                                        case 'DO':
                                                            $statusLabel = 'Day Off';
                                                            break;
                                                        case 'O':
                                                            $statusLabel = 'Overtime';
                                                            break;
                                                        case 'RH':
                                                            $statusLabel = 'Regular Holiday';
                                                            break;
                                                        case 'SH':
                                                            $statusLabel = 'Special Holiday';
                                                            break;
                                                        case 'CD':
                                                            $statusLabel = 'Change Day Off';
                                                            break;
                                                        case 'CDO':
                                                            $statusLabel = 'Cancel Day Off';
                                                            break;
                                                    }

                                                    @endphp
                                            <span class="badge bg-theme-yellow rounded-pill">
                                                {{ $statusLabel ?? 'Present' }}
                                            </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">
                                                No attendance records yet.
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card card-theme shadow-sm h-100">
                        <div class="card-header bg-transparent border-0 pt-4 px-4">
                            <h5 class="fw-bold mb-0">Company Updates</h5>
                        </div>
                        <div class="card-body">
                            @foreach($announcement as $post)
                                <div class="d-flex gap-3 mb-4">
                                    <div class="bg-light rounded p-2 text-center" style="width: 50px;">
                                        <span class="d-block fw-bold text-danger small">{{ \Carbon\Carbon::parse($post->start_date)->format('M') }}</span>
                                        <span class="d-block h5 mb-0 fw-bold">{{ \Carbon\Carbon::parse($post->start_date)->format('d') }}</span>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">{{$post->title}}</h6>
                                        <p class="text-muted small mb-0">{{$post->subject}}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
</x-root>
