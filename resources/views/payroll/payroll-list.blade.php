<x-app title="Payroll Management">
    <div class="main-content">
        <nav class="payroll-nav">
            <h1 class="page-title"></h1>
            
            <div class="filter-controls">
                <select id="companyFilter" class="filter-dropdown" onchange="filterPayroll()">
                    <option value="">All Companies</option>
                    <option value="part-time" {{ $companyFilter == 'part-time' ? 'selected' : '' }}>Part-time</option>
                    @foreach($companies as $comp)
                        <option value="{{ $comp }}" {{ $companyFilter == $comp ? 'selected' : '' }}>{{ $comp }}</option>
                    @endforeach
                </select>

                <select id="yearFilter" class="filter-dropdown" onchange="filterPayroll()">
                    @foreach($years as $y)
                        <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>

                <select id="monthFilter" class="filter-dropdown" onchange="filterPayroll()">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}" {{ $m == $month ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                        </option>
                    @endfor
                </select>

                <select id="periodFilter" class="filter-dropdown" onchange="togglePeriod()">
                    <option value="1-15">1st-15th</option>
                    <option value="16-30">16th-30th</option>
                </select>
            </div>
        </nav>

        <div class="payroll-table-wrapper">
        <div id="period-1-15">
            <h3 class="period-title">1st - 15th Period</h3>
            <table class="payroll-table">
                <thead>
                    <tr>
                        <th>Employee Name</th>
                        <th>Company</th>
                        <th>Daily Rate</th>
                        <th>Days Worked</th>
                        <th>Gross Pay</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $employee)
                    <tr>
                        <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>
                        <td>
                            @if($employee->employment_type === 'part-time')
                                Part-time
                            @else
                                {{ $employee->company->company_name ?? 'N/A' }}
                            @endif
                        </td>
                        <td>₱{{ number_format($employee->currentRate->rate ?? 0, 2) }}</td>
                        <td>{{ $employee->days_worked_1to15 }}</td>
                        <td>₱{{ number_format($employee->gross_pay_1to15, 2) }}</td>
                        <td>
                            <a href="#" 
                               onclick="printPayslip('{{ $employee->employee_id }}', '{{ $year }}', '{{ $month }}', '1-15'); return false;" 
                               class="btn-print">
                                <i class="fas fa-print"></i> Print Payslip
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No payroll data found for the selected period</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div id="period-16-30" style="display: none;">
            <h3 class="period-title">16th - 31st Period</h3>
            <table class="payroll-table">
                <thead>
                    <tr>
                        <th>Employee Name</th>
                        <th>Company</th>
                        <th>Daily Rate</th>
                        <th>Days Worked</th>
                        <th>Gross Pay</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $employee)
                    <tr>
                        <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>
                        <td>
                            @if($employee->employment_type === 'part-time')
                                Part-time
                            @else
                                {{ $employee->company->company_name ?? 'N/A' }}
                            @endif
                        </td>
                        <td>₱{{ number_format($employee->currentRate->rate ?? 0, 2) }}</td>
                        <td>{{ $employee->days_worked_16to31 }}</td>
                        <td>₱{{ number_format($employee->gross_pay_16to31, 2) }}</td>
                        <td>
                            <a href="#" 
                               onclick="printPayslip('{{ $employee->employee_id }}', '{{ $year }}', '{{ $month }}', '16-30'); return false;" 
                               class="btn-print">
                                <i class="fas fa-print"></i> Print Payslip
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No payroll data found for the selected period</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        </div>
    </div>
</x-app>

<style>
.main-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
    padding-bottom: 40px;
    margin-left: 20px;
}

.payroll-nav {
    width: 95%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    margin-top: 1.5rem;
}

.page-title {
    font-size: 28px;
    font-weight: 600;
    color: var(--clr-primary);
    margin: 0;
}

.filter-controls {
    display: flex;
    gap: 1rem;
}

.filter-dropdown {
    padding: 8px 12px;
    border-radius: 6px;
    border: 1px solid #ccc;
    background: white;
    cursor: pointer;
    font-size: 14px;
}

.payroll-table-wrapper {
    width: 95%;
    margin-top: 1rem;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    padding: 1.5rem;
}

.period-title {
    font-size: 20px;
    font-weight: 600;
    color: var(--clr-primary);
    margin: 1.5rem 0 1rem 0;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--clr-primary);
}

.period-title:first-of-type {
    margin-top: 0;
}

.payroll-table {
    width: 100%;
    border-collapse: collapse;
}

.payroll-table thead {
    background: var(--clr-primary);
}

.payroll-table thead th {
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    color: white;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.payroll-table tbody tr {
    border-bottom: 1px solid #e5e7eb;
}

.payroll-table tbody tr:hover {
    background-color: #f9fafb;
}

.payroll-table tbody td {
    padding: 1rem;
    font-size: 14px;
    color: #374151;
}

.text-muted {
    color: #9ca3af;
    font-style: italic;
}

.text-center {
    text-align: center;
    padding: 3rem 2rem;
    color: #6b7280;
    font-size: 15px;
}

.btn-print {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 8px 15px;
    background: #FFD858;
    color: #222;
    border: none;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    box-shadow: 2px 4px 6px rgba(0,0,0,0.15);
}

.btn-print:hover {
    background: #4B5563;
    color: #fff;
}

.btn-print i {
    font-size: 14px;
}

@media (max-width: 1450px) {
    .main-content {
        margin-left: 25px;
        width: 90%;
    }

    .payroll-table-wrapper {
        overflow-x: auto;
    }
}

@media (max-width: 1150px) {
    .main-content {
        margin-left: 30px;
        width: 85%;
    }
}

@media (max-width: 950px) {
    .main-content {
        margin-left: 50px;
        width: 80%;
    }
}

@media (max-width: 800px){
    #companyFilter {
        width: 150px;
    }
}

@media (max-width: 700px) {
    .main-content {
        margin-left: 65px;
    }

    #monthFilter, #periodFilter {
        width: 100px;
    }
}

@media (max-width: 680px){
    .filter-controls {
        flex-direction: column;
        align-items: flex-end;
    }
}

@media (max-width: 600px) {
    .main-content {
        margin-left: 70px;
    }
}

@media (max-width: 480px) {
    .main-content {
        width: 75%;
    }
}

@media (max-width: 420px) {
    .main-content {
        width: 70%;
        margin-left: 72px;
    }
}
</style>

<script>
function filterPayroll() {
    const company = document.getElementById('companyFilter').value;
    const year = document.getElementById('yearFilter').value;
    const month = document.getElementById('monthFilter').value;
    let url = `{{ route('new.payroll') }}?year=${year}&month=${month}`;
    if (company) {
        url += `&company=${encodeURIComponent(company)}`;
    }
    window.location.href = url;
}

function togglePeriod() {
    const period = document.getElementById('periodFilter').value;
    const period1to15 = document.getElementById('period-1-15');
    const period16to30 = document.getElementById('period-16-30');
    
    if (period === '1-15') {
        period1to15.style.display = 'block';
        period16to30.style.display = 'none';
    } else {
        period1to15.style.display = 'none';
        period16to30.style.display = 'block';
    }
}

function printPayslip(employeeId, year, month, period) {
    const url = `{{ url('dashboard/employee/payslip') }}/${employeeId}/print?year=${year}&month=${month}&period=${period}`;
    window.open(url, '_blank');
}
</script>