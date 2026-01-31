@vite(['resources/css/employee_web/payrollViewingModule/payrollViewingModule.css', 'resources/css/theme.css', 'resources/css/includes/sidebar.css'])

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

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
                    <form action="{{ route('web.employee.payroll') }}" method="GET" class="row g-3 align-items-end">

                        <div class="col-md-3">
                            <label class="form-label text-muted small text-uppercase fw-bold ls-1">From Date</label>
                            <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted">
                                <i class="bi bi-calendar3"></i>
                            </span>
                                <input type="date" class="form-control border-start-0 ps-0" name="date_from" value="{{ request('date_from') }}">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label text-muted small text-uppercase fw-bold ls-1">To Date</label>
                            <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted">
                                <i class="bi bi-calendar3"></i>
                            </span>
                                <input type="date" class="form-control border-start-0 ps-0" name="date_to" value="{{ request('date_to') }}">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label text-muted small text-uppercase fw-bold ls-1">Status</label>
                            <select class="form-select" name="status">
                                <option value="all">All Statuses</option>
                                <option value="released">Released</option>
                                <option value="pending">Pending</option>
                                <option value="held">On Hold</option>
                            </select>
                        </div>

                        <div class="col-md-3 d-flex gap-2">
                            <button type="submit" class="btn btn-light border btn-icon-square" title="Filter">
                                <i class="bi bi-funnel"></i>
                            </button>

                            <a href="{{ route('web.employee.payroll') }}" class="btn btn-light border btn-icon-square" title="Reset">
                                <i class="bi bi-arrow-counterclockwise"></i>
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
                                <th class="ps-4 py-3 text-secondary text-uppercase small ls-1 border-0" width="15%">Reference ID</th>
                                <th class="py-3 text-secondary text-uppercase small ls-1 border-0" width="20%">Pay Period</th>
                                <th class="py-3 text-secondary text-uppercase small ls-1 border-0" width="15%">Pay Date</th>
                                <th class="py-3 text-secondary text-uppercase small ls-1 border-0" width="15%">Net Pay</th>
                                <th class="py-3 text-secondary text-uppercase small ls-1 border-0 text-center" width="15%">Status</th>
                                <th class="pe-4 py-3 text-secondary text-uppercase small ls-1 border-0 text-end" width="15%">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($payslips as $payslip)
                                <tr>
                                    <td class="ps-4">
                                        <span class="fw-bold text-muted font-monospace">#{{$payslip->reference}}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold text-dark" id="period">{{$payslip->period}}</span>
                                            <small id="year" class="text-muted" style="font-size: 0.75rem;">{{$payslip->year}}</small>
                                            <input type="hidden" id="month" value="{{$payslip->month}}">
                                        </div>
                                    </td>
                                    <td class="text-secondary">{{$payslip->pay_date}}</td>
                                    <td>
                                        <span class="fw-bold text-dark fs-6">{{$payslip->net_pay}}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2 border border-success border-opacity-25 d-inline-flex align-items-center gap-2">
                                            <i class="bi bi-check-circle-fill"></i> {{$payslip->status}}
                                        </span>
                                    </td>
                                    <td class="pe-4 text-end">
                                        <button class="btn btn-light border btn-icon-square"
                                                onclick="navigateToPayslip('{{ $payslip->period }}', '{{ $payslip->year }}', '{{ $payslip->month }}')">
                                            <i class="bi bi-eye text-primary"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="bi bi-file-earmark-text me-2" style="font-size: 1.2rem;"></i>
                                        No payslip records found
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        Showing {{ $payslips->firstItem() }} to {{ $payslips->lastItem() }} of {{ $payslips->total() }} entries
                    </small>

                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            {{-- Previous Page --}}
                            <li class="page-item {{ $payslips->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $payslips->previousPageUrl() }}">Previous</a>
                            </li>

                            {{-- Page Numbers --}}
                            @foreach ($payslips->getUrlRange(1, $payslips->lastPage()) as $page => $url)
                                <li class="page-item {{ $page == $payslips->currentPage() ? 'active' : '' }}">
                                    <a class="page-link
                        {{ $page == $payslips->currentPage() ? 'bg-theme-yellow border-theme-yellow text-dark' : 'text-dark' }}"
                                       href="{{ $url }}">
                                        {{ $page }}
                                    </a>
                                </li>
                            @endforeach

                            {{-- Next Page --}}
                            <li class="page-item {{ $payslips->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link" href="{{ $payslips->nextPageUrl() }}">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </main>
</x-root>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>


<script>
    document.addEventListener("DOMContentLoaded", () => {

        const button = document.getElementById("downloadPDF");

        if (!button) return;

        button.addEventListener("click", async () => {

            const payrollTable = document.querySelector(".custom-table");
            if (!payrollTable) {
                alert("Payroll table not found.");
                return;
            }

            const { jsPDF } = window.jspdf;

            // Capture HTML as image
            const canvas = await html2canvas(payrollTable, { scale: 2 });
            const imgData = canvas.toDataURL("image/png");

            // Create PDF
            const pdf = new jsPDF("p", "mm", "a4");
            const pageWidth = pdf.internal.pageSize.getWidth();
            const pageHeight = pdf.internal.pageSize.getHeight();

            const imgWidth = pageWidth;
            const imgHeight = (canvas.height * imgWidth) / canvas.width;

            let heightLeft = imgHeight;
            let position = 0;

            // Add first page
            pdf.addImage(imgData, "PNG", 0, position, imgWidth, imgHeight);
            heightLeft -= pageHeight;

            // Add additional pages if needed
            while (heightLeft > 0) {
                position = heightLeft - imgHeight;
                pdf.addPage();
                pdf.addImage(imgData, "PNG", 0, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;
            }

            pdf.save("Payroll.pdf");
        });
    });

    function navigateToPayslip(period, year, month) {
        const baseUrl = "{{ route('employee_web.dashboard.payslip', ['id' => $employee->employee_id]) }}";

        const url = `${baseUrl}?period=${encodeURIComponent(period)}&year=${year}&month=${month}`;

        window.location.href = url;
    }

</script>
