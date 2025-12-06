@vite(['resources/css/employee_web/payrollViewingModule/style.css', 'resources/css/theme.css', 'resources/css/includes/sidebar.css'])

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<x-root>
    @include('layouts.employee-side-nav')
    
    <main class="main-content p-4">
        <div class="container-fluid">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1" style="color: var(--clr-primary);">My Payslips</h2>
                    <p class="text-muted mb-0">View and download your payment history.</p>
                </div>
                </div>

            <div class="card card-theme border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <form action="" method="GET" class="row g-3 align-items-end">
                        
                        <div class="col-md-3">
                            <label class="form-label text-muted small text-uppercase fw-bold ls-1">From Date</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="far fa-calendar-alt text-muted"></i></span>
                                <input type="date" class="form-control border-start-0 ps-0" name="date_from" value="{{ request('date_from') }}">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label text-muted small text-uppercase fw-bold ls-1">To Date</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="far fa-calendar-alt text-muted"></i></span>
                                <input type="date" class="form-control border-start-0 ps-0" name="date_to" value="{{ request('date_to') }}">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label text-muted small text-uppercase fw-bold ls-1">Status</label>
                            <select class="form-select" name="status">
                                <option value="all">All Statuses</option>
                                <option value="paid">Paid</option>
                                <option value="pending">Pending</option>
                                <option value="held">Held</option>
                            </select>
                        </div>

                        <div class="col-md-3 d-flex gap-2">
                            <button type="submit" class="button-ghost w-100 fw-bold">
                                Filter
                            </button>
                            <a href="#" class="btn btn-light border w-25 d-flex align-items-center justify-content-center" title="Reset">
                                <i class="fas fa-undo text-muted"></i>
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card card-theme border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light border-bottom">
                                <tr>
                                    <th class="ps-4 py-3 text-secondary text-uppercase small ls-1 border-0">Reference ID</th>
                                    <th class="py-3 text-secondary text-uppercase small ls-1 border-0">Pay Period</th>
                                    <th class="py-3 text-secondary text-uppercase small ls-1 border-0">Pay Date</th>
                                    <th class="py-3 text-secondary text-uppercase small ls-1 border-0">Net Pay</th>
                                    <th class="py-3 text-secondary text-uppercase small ls-1 border-0 text-center">Status</th>
                                    <th class="pe-4 py-3 text-secondary text-uppercase small ls-1 border-0 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">#PAY-2025-012</td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold">Nov 01 - Nov 15</span>
                                            <small class="text-muted">2025</small>
                                        </div>
                                    </td>
                                    <td>Nov 30, 2025</td>
                                    <td class="fw-bold text-dark fs-5">₱ 15,000.00</td>
                                    <td class="text-center">
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2 border border-success border-opacity-25">
                                            <i class="fas fa-check-circle me-1"></i> Released
                                        </span>
                                    </td>
                                    <td class="pe-4 text-end">
                                        <button class="btn btn-sm btn-light border me-1" title="View Details">
                                            <i class="fas fa-eye text-primary"></i>
                                        </button>
                                        <button class="btn btn-sm btn-light border" title="Download PDF">
                                            <i class="fas fa-download text-muted"></i>
                                        </button>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="ps-4 fw-bold text-muted">#PAY-2025-013</td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold">Nov 16 - Nov 30</span>
                                            <small class="text-muted">2025</small>
                                        </div>
                                    </td>
                                    <td>Dec 15, 2025</td>
                                    <td class="fw-bold text-muted fs-5">₱ 6,824.01</td>
                                    <td class="text-center">
                                        <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-2 border border-warning border-opacity-25">
                                            <i class="fas fa-clock me-1"></i> Processing
                                        </span>
                                    </td>
                                    <td class="pe-4 text-end">
                                        <button class="btn btn-sm btn-light border me-1" disabled>
                                            <i class="fas fa-eye-slash text-muted"></i>
                                        </button>
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="card-footer bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <small class="text-muted">Showing 1 to 10 of 24 entries</small>
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                            <li class="page-item active"><a class="page-link bg-theme-yellow border-theme-yellow text-dark" href="#">1</a></li>
                            <li class="page-item"><a class="page-link text-dark" href="#">2</a></li>
                            <li class="page-item"><a class="page-link text-dark" href="#">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>

        </div>
    </main>
</x-root>