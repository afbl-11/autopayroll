@vite(['resources/css/employee_web/creditAdjustmentModule/creditAdjustmentModule.css', 'resources/css/theme.css', 'resources/css/includes/sidebar.css'])

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<x-root>
    @include('layouts.employee-side-nav')
    
    <main class="main-content">
        <div class="container-fluid p-0">
            
            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="fw-bold mb-1" style="color: var(--clr-primary);">Payroll Credit Adjustment</h2>
                    <p class="text-muted mb-0">Easily request and track payroll credit adjustments.</p>
                </div>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-xl-4 col-md-6">
                    <div class="card-stat border-bottom-orange shadow-sm">
                        <div class="card-body d-flex align-items-center p-4">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="bi bi-hourglass-split text-warning fs-3"></i>
                            </div>
                            <div>
                                <h6 class="text-muted text-uppercase small fw-bold mb-1">Pending Requests</h6>
                                <h2 class="fw-bold mb-0">0</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6">
                    <div class="card-stat border-bottom-blue shadow-sm">
                        <div class="card-body d-flex align-items-center p-4">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="bi bi-clock-history text-primary fs-3"></i>
                            </div>
                            <div class="overflow-hidden">
                                <h6 class="text-muted text-uppercase small fw-bold mb-1">Latest Adjustment</h6>
                                <div class="text-truncate text-muted fst-italic small">No requests found</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-4 col-md-12">
                    <div class="card-stat border-bottom-green shadow-sm">
                        <div class="card-body d-flex align-items-center p-4">
                            <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="bi bi-check-circle-fill text-success fs-3"></i>
                            </div>
                            <div>
                                <h6 class="text-muted text-uppercase small fw-bold mb-1">Approved This Month</h6>
                                <h2 class="fw-bold mb-0">0</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-12">
                    
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <form class="row g-3 align-items-end">
                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label text-muted small fw-bold">Date Range</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" placeholder="From">
                                        <span class="input-group-text bg-white border-start-0 border-end-0 text-muted">-</span>
                                        <input type="date" class="form-control border-start-0" placeholder="To">
                                    </div>
                                </div>
                                
                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label text-muted small fw-bold">Adjustment Type</label>
                                    <select class="form-select">
                                        <option value="all">All Types</option>
                                        <option value="Attendance">Attendance</option>
                                        <option value="Official Business">Official Business</option>
                                        <option value="Leave">Leave</option>
                                        <option value="Payroll">Payroll</option>
                                    </select>
                                </div>

                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label text-muted small fw-bold">Status</label>
                                    <select class="form-select">
                                        <option value="all">All Statuses</option>
                                        <option value="pending">Pending</option>
                                        <option value="approved">Approved</option>
                                        <option value="rejected">Rejected</option>
                                    </select>
                                </div>

                                <div class="col-lg-3 col-md-6 d-flex gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light border" style="height: 42px; width: 42px;" title="Filter">
                                        <i class="bi bi-funnel"></i>
                                    </button>
                                    
                                    <button type="button" class="btn fw-bold d-flex align-items-center gap-2 shadow-sm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#fileAdjustmentModal"
                                            style="height: 42px; background-color: var(--clr-yellow); color: var(--clr-indigo); white-space: nowrap;">
                                        <i class="bi bi-plus-circle-fill"></i> 
                                        <span>File Request</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 pt-4 px-4">
                            <h5 class="fw-bold mb-0">Adjustment History</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="ps-4 py-3 text-secondary small text-uppercase">Filed Date</th>
                                            <th class="py-3 text-secondary small text-uppercase">Type</th>
                                            <th class="py-3 text-secondary small text-uppercase">Sub-Type</th>
                                            <th class="py-3 text-secondary small text-uppercase text-center">Status</th>
                                            <th class="pe-4 py-3 text-secondary small text-uppercase text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">
                                                <div class="d-flex flex-column align-items-center justify-content-center my-4">
                                                    <i class="bi bi-inbox fs-1 mb-3 opacity-25"></i>
                                                    <p class="mb-0">No adjustment requests found.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="fileAdjustmentModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                    <div class="modal-header border-0 pb-0">
                        <button type="button" class="btn p-0 text-dark fw-bold fs-5" data-bs-dismiss="modal" style="border: none; background: none;">
                            <i class="bi bi-arrow-left me-2"></i> Request Filing
                        </button>
                    </div>
                    <div class="modal-body p-4">
                        <form action="#" method="POST" enctype="multipart/form-data">
                            @csrf 
                            
                            <div class="form-floating mb-3">
                                <select class="form-select border-secondary-subtle" id="adjustmentType" name="adjustment_type" onchange="updateSubTypes()" style="border-radius: 10px;">
                                    <option selected disabled value="">Select Type</option>
                                    <option value="Attendance">Attendance</option>
                                    <option value="Official Business">Official Business</option>
                                    <option value="Leave">Leave</option>
                                    <option value="Payroll">Payroll</option>
                                </select>
                                <label for="adjustmentType">Adjustment Type</label>
                            </div>

                            <div class="form-floating mb-3">
                                <select class="form-select border-secondary-subtle" id="adjustmentSubType" name="adjustment_sub_type" style="border-radius: 10px;" disabled>
                                    <option selected disabled>Select Type first</option>
                                </select>
                                <label for="adjustmentSubType">Adjustment Sub-type</label>
                            </div>

                            <div class="mb-3">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control border-secondary-subtle" id="startDate" name="start_date" style="border-radius: 10px;">
                                    <label for="startDate">Start Date</label>
                                </div>
                                <div class="form-floating">
                                    <input type="date" class="form-control border-secondary-subtle" id="endDate" name="end_date" style="border-radius: 10px;">
                                    <label for="endDate">End Date</label>
                                </div>
                            </div>

                            <div class="form-floating mb-4">
                                <textarea class="form-control border-secondary-subtle" placeholder="Reason" id="reason" name="reason" style="height: 100px; border-radius: 10px;"></textarea>
                                <label for="reason">Reason for Adjustment</label>
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
                                <button type="button" class="btn text-white py-3 fw-bold" style="background-color: #1a202c; border-radius: 25px;">SUBMIT</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </main>
</x-root>

<script>
    const subTypes = {
        'Attendance': ['Time Correction', 'Official Business Marking', 'Missing Log Entry', 'Late Correction', 'DTR Correction', 'Absence Correction'],
        'Official Business': ['Official Business Filing', 'Official Business Correction'],
        'Leave': ['Leave Type Change', 'Leave Cancellation', 'Post-Approval Filing', 'Leave Status Correction', 'Leave Credit Adjustment'],
        'Payroll': ['Leave Pay Correction', 'Payroll Difference Adjustment', 'Bonus or Allowance Correction', 'Holiday Pay Correction', 'Deduction Correction', 'Overtime Correction']
    };

    function updateSubTypes() {
        const typeSelect = document.getElementById('adjustmentType');
        const subTypeSelect = document.getElementById('adjustmentSubType');
        const selectedType = typeSelect.value;
        
        subTypeSelect.innerHTML = '<option selected disabled>Select Sub-type</option>';
        if (selectedType && subTypes[selectedType]) {
            subTypeSelect.disabled = false;
            subTypes[selectedType].forEach(sub => {
                const option = document.createElement('option');
                option.value = sub;
                option.textContent = sub;
                subTypeSelect.appendChild(option);
            });
        } else {
            subTypeSelect.disabled = true;
        }
    }

    function updateFileName(input) {
        if (input.files && input.files.length > 0) {
            document.getElementById('fileName').innerText = input.files[0].name;
            const btn = input.parentElement.querySelector('.btn');
            btn.classList.add('border-success', 'text-success');
        }
    }
</script>