@vite(['resources/css/theme.css'])
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@extends('layouts.deduction-settings')

@section('deduction_content')

        <div class="container-fluid px-4 py-5">
            {{-- Header Section --}}
{{--            <div class="d-flex justify-content-between align-items-center mb-4">--}}
{{--                <div>--}}
{{--                    <h1 class="h3 mb-0 text-gray-800 fw-bold">Pag-IBIG Fund Management</h1>--}}
{{--                    <p class="text-muted small mb-0">Configure contribution rates and the monthly fund salary (MFS) cap.</p>--}}
{{--                </div>--}}
{{--                <nav aria-label="breadcrumb">--}}
{{--                    <ol class="breadcrumb mb-0">--}}
{{--                        <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Deductions</a></li>--}}
{{--                        <li class="breadcrumb-item active">Pag-IBIG</li>--}}
{{--                    </ol>--}}
{{--                </nav>--}}
{{--            </div>--}}

            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row g-4">
                {{-- Left Side: History & Versioning --}}
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h6 class="mb-0 fw-bold text-dark text-uppercase small ls-1">Policy History</h6>
                        </div>
                        <div class="list-group list-group-flush">
                            @forelse($versions as $v)
                                <a href="{{ route('pagibig.index', ['version' => $v->id]) }}"
                                   class="list-group-item list-group-item-action border-0 py-3 {{ $activeVersion?->id == $v->id ? 'bg-light border-start border-primary border-4' : '' }}">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-bold {{ $activeVersion?->id == $v->id ? 'text-primary' : 'text-dark' }}">{{ $v->name }}</div>
                                            <small class="text-muted">Eff: {{ \Carbon\Carbon::parse($v->effective_date)->format('M d, Y') }}</small>
                                        </div>
                                        @if($v->status == 'active')
                                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2">Active</span>
                                        @endif
                                    </div>
                                </a>
                            @empty
                                <div class="p-4 text-center text-muted">
                                    <small>No history found.</small>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Null-Safe Clone Section --}}
                    @if($activeVersion)
                        <div class="card border-0 shadow-sm bg-light">
                            <div class="card-body p-4">
                                <h6 class="fw-bold text-dark mb-2">Need a new policy?</h6>
                                <p class="text-muted small">Clone the current policy to a new draft.</p>
                                <form action="{{ route('pagibig.clone', $activeVersion->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-primary w-100 fw-bold">
                                        <i class="bi bi-files me-2"></i>Clone to Draft
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Right Side: Active Settings & Simulator --}}
                <div class="col-lg-8">
                    @if($activeVersion)
                        <form action="{{ route('pagibig.update', $activeVersion->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body p-4">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold text-secondary small text-uppercase">Policy Name</label>
                                            <input type="text" name="name" value="{{ $activeVersion->name }}" class="form-control" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label fw-bold text-secondary small text-uppercase">Effective Date</label>
                                            <input type="date" name="effective_date" value="{{ $activeVersion->effective_date }}" class="form-control" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label fw-bold text-secondary small text-uppercase">Status</label>
                                            <select name="status" class="form-select">
                                                <option value="active" {{ $activeVersion->status == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ $activeVersion->status == 'inactive' ? 'selected' : '' }}>Inactive/Draft</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body p-4 text-center">
                                            <div class="text-primary mb-2"><i class="bi bi-arrow-up-circle fs-1"></i></div>
                                            <h6 class="fw-bold text-dark">Monthly Fund Salary Cap</h6>
                                            <div class="input-group input-group-lg mt-3">
                                                <span class="input-group-text bg-white">₱</span>
                                                <input type="number" name="salary_cap" id="salary_cap" value="{{ $activeVersion->salary_cap }}" class="form-control fw-bold" oninput="simulatePagIbig()">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body p-4">
                                            <h6 class="fw-bold text-dark mb-3">Rates (%)</h6>
                                            <div class="mb-3">
                                                <label class="small text-muted text-uppercase fw-bold">Employee (EE)</label>
                                                <div class="input-group">
                                                    <input type="number" step="0.01" name="employee_rate_above_threshold" id="ee_rate" value="{{ $activeVersion->employee_rate_above_threshold * 100 }}" class="form-control" oninput="simulatePagIbig()">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                            <div>
                                                <label class="small text-muted text-uppercase fw-bold">Employer (ER)</label>
                                                <div class="input-group">
                                                    <input type="number" step="0.01" name="employer_rate" id="er_rate" value="{{ $activeVersion->employer_rate * 100 }}" class="form-control" oninput="simulatePagIbig()">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Simulator --}}
                            <div class="card border-0 shadow-sm bg-primary bg-opacity-10 mb-4">
                                <div class="card-body p-4">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <h6 class="fw-bold text-primary extra-small ls-1 text-uppercase">Simulator</h6>
                                            <input type="number" id="sim_salary" class="form-control mt-2" placeholder="Enter Gross Salary" oninput="simulatePagIbig()">
                                        </div>
                                        <div class="col-md-6 text-center border-start">
                                            <div class="row">
                                                <div class="col-6">
                                                    <small class="text-muted d-block extra-small fw-bold">EE</small>
                                                    <span class="h5 fw-bold mb-0" id="res_ee">₱0.00</span>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted d-block extra-small fw-bold">ER</small>
                                                    <span class="h5 fw-bold mb-0" id="res_er">₱0.00</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary btn-lg px-5 shadow fw-bold">Save Changes</button>
                            </div>
                        </form>
                    @else
                        {{-- Empty State --}}
                        <div class="text-center py-5 bg-white rounded shadow-sm">
                            <i class="bi bi-database-exclamation text-warning fs-1"></i>
                            <h4 class="mt-3">No Configuration Found</h4>
                            <p class="text-muted">You need to run the seeder or initialize the first Pag-IBIG policy.</p>
                            <button class="btn btn-primary btn-sm px-4">Initialize 2026 Standards</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
{{--    </main>--}}
@endsection
{{--</x-app>--}}

{{-- JS remains the same --}}

<script>
    function simulatePagIbig() {
        const salary = parseFloat(document.getElementById('sim_salary').value) || 0;
        const cap = parseFloat(document.getElementById('salary_cap').value) || 0;
        const eeRate = (parseFloat(document.getElementById('ee_rate').value) || 0) / 100;
        const erRate = (parseFloat(document.getElementById('er_rate').value) || 0) / 100;

        // The Logic: Calculate based on salary but cap it at the MFS Cap
        const basis = Math.min(salary, cap);

        const eeContribution = basis * eeRate;
        const erContribution = basis * erRate;

        document.getElementById('res_ee').innerText = '₱' + eeContribution.toLocaleString(undefined, {minimumFractionDigits: 2});
        document.getElementById('res_er').innerText = '₱' + erContribution.toLocaleString(undefined, {minimumFractionDigits: 2});
    }
</script>

<style>
    .ls-1 { letter-spacing: 0.05rem; }
    .extra-small { font-size: 0.7rem; }
</style>
