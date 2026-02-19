@vite(['resources/css/theme.css'])
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@extends('layouts.deduction-settings')

@section('deduction_content')

    <div class="container-fluid px-4 py-5">
{{--        <div class="mb-4">--}}
{{--            <h1 class="h3 mb-0 text-gray-800 fw-bold">SSS Contribution Management</h1>--}}
{{--            <p class="text-muted small">Update the system with the latest RA 11199 contribution brackets and rates.</p>--}}
{{--        </div>--}}
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row g-4">
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm overflow-hidden">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="card-title mb-0 fw-bold text-primary">
                            <i class="bi bi-cloud-arrow-up-fill me-2"></i>Update Contribution Table
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('sss.upload') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row g-3 mb-4">
                                <div class="col-md-7">
                                    <label class="form-label fw-semibold text-secondary small text-uppercase">Version Name</label>
                                    <input type="text" name="version_name" class="form-control form-control-lg" placeholder="e.g. 2026 RA 11199" required>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label fw-semibold text-secondary small text-uppercase">Effective Date</label>
                                    <input type="date" name="effective_date" class="form-control form-control-lg" required>
                                </div>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-6">
                                    <label class="form-label fw-semibold text-secondary small text-uppercase">Employee Share (%)</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" name="ee_rate" class="form-control form-control-lg" placeholder="5.0" required>
                                        <span class="input-group-text bg-light">%</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label class="form-label fw-semibold text-secondary small text-uppercase">Employer Share (%)</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" name="er_rate" class="form-control form-control-lg" placeholder="10.0" required>
                                        <span class="input-group-text bg-light">%</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold text-secondary small text-uppercase">Upload Brackets (Excel/CSV)</label>
                                <div class="p-4 border border-2 border-dashed rounded-3 bg-light text-center">
                                    <i class="bi bi-file-earmark-excel fs-1 text-muted mb-2"></i>
                                    <input type="file" name="excel_file" class="form-control mt-2" required>
                                    <div class="mt-3">
                                        <small class="text-muted d-block">Ensure columns match the system template.</small>
                                        <a href="{{ route('sss.template') }}" class="btn btn-link btn-sm fw-bold p-0 mt-1">
                                            <i class="bi bi-download me-1"></i>Download Template
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm fw-bold py-3">
                                Upload and Activate Rate
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 text-dark fw-bold">System Status</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="p-4 bg-primary bg-opacity-10 border-bottom">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white p-3 rounded-circle me-3">
                                    <i class="bi bi-shield-check fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold text-primary">
                                        Active SSS Table: {{ $latestVersion->version_name ?? 'No Active Version' }}
                                    </h6>
                                    <p class="mb-0 text-muted small">
                                        @if($latestVersion)
                                            Effective since {{ $latestVersion->effective_date->format('M d, Y') }}
                                        @else
                                            Please upload a contribution table to begin.
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 small fw-bold text-uppercase">Program</th>
                                    <th class="py-3 small fw-bold text-uppercase">Employee Share</th>
                                    <th class="py-3 small fw-bold text-uppercase">Employer Share</th>
                                    <th class="pe-4 py-3 small fw-bold text-uppercase text-end">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($latestVersion)
                                    <tr>
                                        <td class="ps-4">
                                            <span class="fw-semibold text-dark">Regular Social Security</span>
                                            <div class="text-muted extra-small">Applied to MSC up to ₱20,000</div>
                                        </td>
                                        <td>{{ number_format($latestVersion->ee_rate * 100, 2) }}%</td>
                                        <td>{{ number_format($latestVersion->er_rate * 100, 2) }}%</td>
                                        <td class="pe-4 text-end fw-bold">
                                            {{ number_format(($latestVersion->ee_rate + $latestVersion->er_rate) * 100, 2) }}%
                                        </td>
                                    </tr>
{{--                                    <tr>--}}
{{--                                        <td class="ps-4">--}}
{{--                                            <span class="fw-semibold text-dark">MPF (WISP)</span>--}}
{{--                                            <div class="text-muted extra-small">Mandatory for MSC > ₱20,000</div>--}}
{{--                                        </td>--}}
{{--                                        <td>{{ number_format($latestVersion->ee_rate * 100, 2) }}%</td>--}}
{{--                                        <td>{{ number_format($latestVersion->er_rate * 100, 2) }}%</td>--}}
{{--                                        <td class="pe-4 text-end fw-bold">--}}
{{--                                            {{ number_format(($latestVersion->ee_rate + $latestVersion->er_rate) * 100, 2) }}%--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">No configuration data available.</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

{{--            contribution table--}}
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <div>
                        <h5 class="mb-0 fw-bold text-dark">Full Bracket Reference</h5>
                        <small class="text-muted">Version: <strong>{{ $latestVersion->version_name ?? 'N/A' }}</strong></small>
                    </div>
                    <button onclick="exportTableToExcel('sss-bracket-table', 'SSS_Brackets_2026')" class="btn btn-outline-success btn-sm fw-bold">
                        <i class="bi bi-file-earmark-excel me-1"></i> Export to Excel
                    </button>
                </div>
                <div class="table-responsive" style="max-height: 500px;">
                    <table class="table table-hover align-middle mb-0" id="sss-bracket-table">
                        <thead class="bg-light sticky-top">
                        <tr class="text-secondary small text-uppercase fw-bold">
                            <th class="ps-4">Range of Compensation</th>
                            <th class="text-center">MSC</th>
                            <th class="text-end">Employer Share</th>
                            <th class="text-end">Employee Share</th>
                            <th class="text-end">EC (ER)</th>
                            <th class="pe-4 text-end">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($brackets as $bracket)
                            @php
                                $er = $bracket->msc_amount * ($latestVersion->er_rate ?? 0);
                                $ee = $bracket->msc_amount * ($latestVersion->ee_rate ?? 0);
                            @endphp
                            <tr>
                                <td class="ps-4">₱{{ number_format($bracket->min_salary, 2) }} - {{ $bracket->max_salary > 0 ? '₱'.number_format($bracket->max_salary, 2) : 'Above' }}</td>
                                <td class="text-center">₱{{ number_format($bracket->msc_amount, 2) }}</td>
                                <td class="text-end">₱{{ number_format($er, 2) }}</td>
                                <td class="text-end text-primary fw-bold">₱{{ number_format($ee, 2) }}</td>
                                <td class="text-end">₱{{ number_format($bracket->ec_er_share, 2) }}</td>
                                <td class="pe-4 text-end fw-bold">₱{{ number_format($er + $ee + $bracket->ec_er_share, 2) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function exportTableToExcel(tableID, filename = 'SSS_Contribution_Table_2026') {
        const table = document.getElementById(tableID);
        let csv = [];
        const rows = table.querySelectorAll("tr");

        for (let i = 0; i < rows.length; i++) {
            let row = [], cols = rows[i].querySelectorAll("td, th");

            for (let j = 0; j < cols.length; j++) {
                // 1. Clean the text: remove Peso signs, commas, and extra whitespace
                let data = cols[j].innerText.replace(/₱/g, '').replace(/,/g, '').trim();

                // 2. Wrap in quotes to handle any remaining commas in names/ranges
                row.push('"' + data + '"');
            }
            csv.push(row.join(","));
        }

        // 3. Create the CSV file with UTF-8 BOM for compatibility
        const csvContent = "\ufeff" + csv.join("\n");
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const url = URL.createObjectURL(blob);

        // 4. Trigger Download
        const link = document.createElement("a");
        link.setAttribute("href", url);
        link.setAttribute("download", filename + ".csv");
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>
