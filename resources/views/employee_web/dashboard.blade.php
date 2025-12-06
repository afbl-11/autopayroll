@vite(['resources/css/employee_web/dashboard.css', 'resources/css/theme.css'])

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<x-root>
    @include('layouts.employee-side-nav')
    
    <main class="main-content p-4">
        <div class="container-fluid">
            
            <div class="row mb-4 align-items-center">
                <div class="col-md-8">
                    <h2 class="fw-bold mb-1">Good Evening, Marc Jurell!</h2>
                    <p class="text-muted mb-0">Developer • Jurell Company</p>
                </div>
                <div class="col-md-4 text-end">
                    <span class="badge bg-theme-yellow text-dark fs-6 px-3 py-2 rounded-3">
                        ID: 20253698
                    </span>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-4 col-xl-2">
                    <div class="card card-theme h-100 shadow-sm">
                        <div class="card-body text-center">
                            <h6 class="text-muted text-uppercase small ls-1">Regular</h6>
                            <h3 class="mb-0 fw-bold">9</h3>
                            <small class="text-muted">hours</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-xl-2">
                    <div class="card card-theme h-100 shadow-sm">
                        <div class="card-body text-center">
                            <h6 class="text-muted text-uppercase small ls-1">Overtime</h6>
                            <h3 class="mb-0 fw-bold">0</h3>
                            <small class="text-muted">hours</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-xl-2">
                    <div class="card card-theme h-100 shadow-sm">
                        <div class="card-body text-center">
                            <h6 class="text-muted text-uppercase small ls-1">Late</h6>
                            <h3 class="mb-0 fw-bold text-danger">0</h3>
                            <small class="text-muted">mins</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card card-theme h-100 shadow-sm border-start-theme-yellow">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted text-uppercase small ls-1">Leave Balance</h6>
                                <h3 class="mb-0 fw-bold">15</h3>
                            </div>
                            <div class="icon-box bg-white text-warning rounded-circle shadow-sm">
                                <i class="fas fa-plane-departure"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card card-theme h-100 shadow-sm border-start-theme-red">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted text-uppercase small ls-1">Absences</h6>
                                <h3 class="mb-0 fw-bold">3</h3>
                            </div>
                            <div class="icon-box bg-white text-danger rounded-circle shadow-sm">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                
                <div class="col-lg-8">
                    <div class="card card-theme shadow-sm h-100">
                        <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                            <h5 class="mb-0 fw-bold">Most Recent Payslip</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light-custom">
                                        <tr>
                                            <th class="ps-3 text-secondary text-uppercase small">Net Earning</th>
                                            <th class="text-secondary text-uppercase small">Pay Date</th>
                                            <th class="text-secondary text-uppercase small">Status</th>
                                            <th class="text-end pe-3 text-secondary text-uppercase small">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="ps-3 fw-bold">PHP 15,000.00</td>
                                            <td>Nov 30, 2025</td>
                                            <td><span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Paid</span></td>
                                            <td class="text-end pe-3">
                                                <button class="button-ghost btn-sm" style="width: auto; padding: 5px 15px; height: auto;">View</button>
                                            </td>
                                        </tr>
                                        <tr class="d-none">
                                            <td colspan="4" class="text-center py-5 text-muted">
                                                No payslip to show.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card card-theme shadow-sm h-100">
                        <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                            <h5 class="mb-0 fw-bold">My Schedule</h5>
                        </div>
                        <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                            <div class="py-2">
                                <p class="text-muted mb-4 small text-uppercase ls-1">Shift Schedule</p>
                                <div class="d-flex align-items-center justify-content-center gap-3">
                                    <div>
                                        <h2 class="mb-0 fw-bold">07:00</h2>
                                        <small class="text-uppercase fw-bold text-muted">AM</small>
                                    </div>
                                    <div class="text-warning">
                                        <i class="fas fa-long-arrow-alt-right fa-2x"></i>
                                    </div>
                                    <div>
                                        <h2 class="mb-0 fw-bold">05:00</h2>
                                        <small class="text-uppercase fw-bold text-muted">PM</small>
                                    </div>
                                </div>
                            </div>
                            <hr class="w-100 my-4" style="opacity: 0.1">
                            <button class="button-filled w-100 justify-content-center">
                                Request Change
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </main>
</x-root>