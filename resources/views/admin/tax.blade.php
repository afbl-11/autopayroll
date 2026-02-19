@vite(['resources/css/theme.css'])
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

@extends('layouts.deduction-settings')
@section('deduction_content')
        <div class="container-fluid px-4 py-5">
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- START OF MAIN UPDATE FORM --}}
            @if($activeVersion)
                <form action="{{ route('tax.update', $activeVersion->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        {{-- Left Side: Version Management --}}
                        <div class="col-lg-5">
                            <div class="card border-0 shadow-sm overflow-hidden mb-4">
                                <div class="card-header bg-white py-3 border-bottom">
                                    <h5 class="card-title mb-0 fw-bold text-primary">
                                        <i class="bi bi-layers-fill me-2"></i>Tax Law Version
                                    </h5>
                                </div>
                                <div class="card-body p-4">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold text-secondary small text-uppercase">Law / Version Name</label>
                                        <input type="text" name="name" value="{{ $activeVersion->name }}" class="form-control form-control-lg" required>
                                    </div>

                                    <div class="row g-3 mb-4">
                                        <div class="col-6">
                                            <label class="form-label fw-semibold text-secondary small text-uppercase">Effective Date</label>
                                            <input type="date" name="effective_date" value="{{ $activeVersion->effective_date }}" class="form-control" required>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label fw-semibold text-secondary small text-uppercase">Status</label>
                                            <select name="status" class="form-select">
                                                <option value="active" {{ $activeVersion->status == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ $activeVersion->status == 'inactive' ? 'selected' : '' }}>Inactive/Draft</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary btn-lg shadow-sm fw-bold">
                                            <i class="bi bi-check-all me-2"></i>Update Version Info & Brackets
                                        </button>
                                    </div>
                </form> {{-- Close main form here temporarily to place the Clone button correctly --}}

                <hr class="my-4 opacity-50">

                {{-- Clone form is separate to avoid conflict --}}
                <form action="{{ route('tax.clone', $activeVersion->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary w-100 fw-bold">
                        <i class="bi bi-files me-2"></i>Clone to New Draft
                    </button>
                </form>
        </div>
        </div>

        {{-- Version History List --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="mb-0 fw-bold text-dark text-uppercase small ls-1">Configuration History</h6>
            </div>
            <div class="list-group list-group-flush">
                @foreach($versions as $v)
                    <a href="{{ route('tax.index', ['version' => $v->id]) }}"
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
                @endforeach
            </div>
        </div>
        </div>

        {{-- Right Side: Simulator --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm bg-primary bg-opacity-10 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary text-white p-3 rounded-circle me-3 shadow-sm">
                            <i class="bi bi-calculator fs-4"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-primary text-uppercase small ls-1">Tax Simulator</h5>
                            <p class="mb-0 text-muted small">Test the current table against a gross monthly salary.</p>
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col-md-8">
                            <div class="input-group input-group-lg shadow-sm">
                                <span class="input-group-text bg-white border-0">₱</span>
                                <input type="number" id="test_salary" class="form-control border-0" placeholder="Enter Monthly Taxable Income">
                                <button type="button" onclick="simulateTax()" class="btn btn-primary px-4 fw-bold">Calculate</button>
                            </div>
                        </div>
                    </div>

                    <div id="simulation_display" class="mt-4 p-3 bg-white rounded-3 shadow-sm d-none">
                        <div class="row text-center">
                            <div class="col-4 border-end">
                                <small class="text-muted d-block text-uppercase extra-small fw-bold">Base Tax</small>
                                <span class="h6 fw-bold mb-0" id="res_base">₱0.00</span>
                            </div>
                            <div class="col-4 border-end">
                                <small class="text-muted d-block text-uppercase extra-small fw-bold">Tax on Excess</small>
                                <span class="h6 fw-bold mb-0 text-primary" id="res_excess">₱0.00</span>
                            </div>
                            <div class="col-4">
                                <small class="text-muted d-block text-uppercase extra-small fw-bold">Total Withholding</small>
                                <span class="h5 fw-bold mb-0 text-success" id="res_total">₱0.00</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-dark mb-2 small text-uppercase ls-1">Note on Setup B</h6>
                    <p class="text-muted small mb-0">
                        This system uses <strong>Setup B</strong>: Statutory deductions are deducted from the 2nd half-month gross. Simulator expects <strong>Monthly Taxable Income</strong>.
                    </p>
                </div>
            </div>
        </div>

        {{-- Bottom: Editable Table (Re-opening the update form context) --}}
        <div class="col-12">
            {{-- Re-opening form for the brackets table --}}
            <form action="{{ route('tax.update', $activeVersion->id) }}" method="POST">
                @csrf
                @method('PUT')
                {{-- We need these hidden inputs because we closed the form above to handle the clone button --}}
                <input type="hidden" name="name" id="hidden_name">
                <input type="hidden" name="effective_date" id="hidden_date">
                <input type="hidden" name="status" id="hidden_status">

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                        <div>
                            <h5 class="mb-0 fw-bold text-dark">Full Bracket Reference</h5>
                            <small class="text-muted">Version: <strong>{{ $activeVersion->name }}</strong></small>
                        </div>
                        <span class="badge bg-light text-secondary border fw-normal">Values are in Philippine Peso (₱)</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-secondary">
                            <tr class="small text-uppercase fw-bold">
                                <th class="ps-4 py-3">Monthly Taxable Income Range</th>
                                <th class="py-3">Base Tax</th>
                                <th class="py-3">Excess Over</th>
                                <th class="py-3" width="15%">Rate (%)</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($activeVersion->brackets as $bracket)
                                <tr>
                                    <td class="ps-4">
                                        <div class="input-group input-group-sm w-75">
                                            <input type="number" name="brackets[{{$bracket->id}}][min_income]" value="{{ $bracket->min_income }}" class="form-control">
                                            <span class="input-group-text bg-light border-0">—</span>
                                            <input type="number" name="brackets[{{$bracket->id}}][max_income]" value="{{ $bracket->max_income }}" placeholder="Above" class="form-control">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm w-75">
                                            <span class="input-group-text bg-light border-0">₱</span>
                                            <input type="number" step="0.01" name="brackets[{{$bracket->id}}][base_tax]" value="{{ $bracket->base_tax }}" class="form-control fw-semibold">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm w-75">
                                            <span class="input-group-text bg-light border-0">₱</span>
                                            <input type="number" step="0.01" name="brackets[{{$bracket->id}}][excess_over]" value="{{ $bracket->excess_over }}" class="form-control">
                                        </div>
                                    </td>
                                    <td class="pe-4">
                                        <div class="input-group input-group-sm">
                                            <input type="number" step="0.1" name="brackets[{{$bracket->id}}][percentage]" value="{{ $bracket->percentage * 100 }}" class="form-control fw-bold text-primary">
                                            <span class="input-group-text bg-primary bg-opacity-10 text-primary border-0">%</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mt-3 text-end">
                    <button type="submit" class="btn btn-primary px-5 btn-lg shadow fw-bold" onclick="syncFormValues()">Save All Changes</button>
                </div>
            </form>
        </div>
        </div>
        @else
            <div class="text-center py-5 bg-white rounded shadow-sm">
                <i class="bi bi-exclamation-circle text-warning fs-1"></i>
                <h4 class="mt-3">No Configuration Selected</h4>
                <p class="text-muted">Please select a version from the history or initialize a new one.</p>
            </div>
            @endif
            </div>
@endsection

<script>
    // To ensure the data from the top inputs (Name, Date, Status) is sent
    // even if the user clicks the "Save" button at the bottom table.
    function syncFormValues() {
        document.getElementById('hidden_name').value = document.querySelector('input[name="name"]').value;
        document.getElementById('hidden_date').value = document.querySelector('input[name="effective_date"]').value;
        document.getElementById('hidden_status').value = document.querySelector('select[name="status"]').value;
    }

    function simulateTax() {
        const income = parseFloat(document.getElementById('test_salary').value);
        const display = document.getElementById('simulation_display');

        if (!income || income <= 0) {
            display.classList.add('d-none');
            return;
        }

        let found = false;
        const rows = document.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const min = parseFloat(row.querySelector('input[name*="[min_income]"]').value) || 0;
            const maxVal = row.querySelector('input[name*="[max_income]"]').value;
            const max = (maxVal === "" || !maxVal) ? Infinity : parseFloat(maxVal);

            if (income >= min && income <= max) {
                const baseTax = parseFloat(row.querySelector('input[name*="[base_tax]"]').value) || 0;
                const percent = (parseFloat(row.querySelector('input[name*="[percentage]"]').value) || 0) / 100;
                const excessOver = parseFloat(row.querySelector('input[name*="[excess_over]"]').value) || 0;

                const taxOnExcess = Math.max(0, (income - excessOver) * percent);
                const totalTax = baseTax + taxOnExcess;

                document.getElementById('res_base').innerText = "₱" + baseTax.toLocaleString(undefined, {minimumFractionDigits: 2});
                document.getElementById('res_excess').innerText = "₱" + taxOnExcess.toLocaleString(undefined, {minimumFractionDigits: 2});
                document.getElementById('res_total').innerText = "₱" + totalTax.toLocaleString(undefined, {minimumFractionDigits: 2});

                found = true;
            }
        });

        if (found) {
            display.classList.remove('d-none');
        } else {
            display.classList.add('d-none');
        }
    }
</script>

<style>
    .ls-1 { letter-spacing: 0.05rem; }
    .extra-small { font-size: 0.7rem; }
</style>
