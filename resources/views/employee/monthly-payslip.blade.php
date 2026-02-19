@vite(['resources/css/company/payroll.css'])
<link rel="stylesheet" href="{{ asset('css/payroll-filters.css') }}">

<style>
.payslip-container {
    width: 95%;
    margin: 2rem auto;
    background: white;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.payslip-header {
    text-align: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 3px solid var(--clr-yellow);
}

.payslip-header h1 {
    color: var(--clr-primary);
    font-family: 'Helvetica Regular', sans-serif;
    font-size: 24px;
    margin-bottom: 0.5rem;
}

.employee-info {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
    margin-bottom: 2rem;
    padding: 1rem;
    background: var(--clr-background);
    border-radius: 8px;
}

.employee-info .info-item {
    display: flex;
    gap: 0.5rem;
}

.employee-info .info-label {
    font-weight: bold;
    color: var(--clr-secondary);
    font-size: 13px;
}

.employee-info .info-value {
    color: var(--clr-primary);
    font-size: 13px;
}

.payslip-table {
    width: 100%;
    margin-bottom: 2rem;
    border-collapse: collapse;
}

.payslip-table th {
    background: var(--clr-card-inner);
    color: var(--clr-primary);
    padding: 12px;
    text-align: left;
    font-size: 14px;
    font-weight: bold;
    border: 1px solid var(--clr-card-inner);
}

.payslip-table td {
    padding: 10px 12px;
    border: 1px solid #ddd;
    font-size: 13px;
}

.payslip-table .amount {
    text-align: right;
    font-family: 'Courier New', monospace;
}

.payslip-table .section-header {
    background: var(--clr-yellow);
    color: var(--clr-primary);
    font-weight: bold;
    font-size: 14px;
}

.payslip-table .total-row {
    background: var(--clr-card-surface);
    font-weight: bold;
}

.net-pay-section {
    background: var(--clr-yellow);
    padding: 1.5rem;
    border-radius: 8px;
    text-align: center;
    margin-bottom: 2rem;
}

.net-pay-section .label {
    color: var(--clr-primary);
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.net-pay-section .amount {
    color: var(--clr-primary);
    font-size: 32px;
    font-weight: bold;
    font-family: 'Courier New', monospace;
}

.actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
}

.btn-download-pdf {
    background: var(--clr-yellow);
    color: var(--clr-primary);
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    font-family: 'Helvetica Regular', sans-serif;
    font-size: 13px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
}

.btn-download-pdf:hover {
    background: var(--clr-indigo);
    color: var(--clr-yellow);
}

@media (max-width: 700px) {
    .filter-controls {
        flex-direction: column;
        align-items: flex-start;
        margin-top: 30px;
    }
}

@media (max-width: 650px) {
    .employee-info {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 600px) {
    .filter-controls {
        margin-top: 15px;
    }
}

@media (max-width: 550px) {
    .payslip-header h1 {
        font-size: 18px;
    }

    .payslip-table th,
    .payslip-table td {
        font-size: 12px;
        padding: 8px;
    }

    .net-pay-section .amount {
        font-size: 24px;
    }

    .employee-info .info-label,
    .employee-info .info-value {
        font-size: 12px;
    }
}

@media (max-width: 400px) {
    .payslip-header h1 {
        font-size: 14px;
    }

    .payslip-table th,
    .payslip-table td {
        font-size: 10px;
        padding: 6px;
    }

    .net-pay-section .amount {
        font-size: 16px;
    }

    .employee-info .info-label,
    .employee-info .info-value {
        font-size: 10px;
    }
}
</style>

<x-app :navigation="true" navigationType="employee" :employee="$employee" :noHeader="true">
    <section class="main-content">
        <nav>
            <x-button-link :source="['employee.dashboard.payroll', ['id' => $employee->employee_id]]" :noDefault="true">Back to Payroll</x-button-link>
        </nav>

        <div class="filter-controls">
            <label for="yearFilter">Year:</label>
            <select id="yearFilter" onchange="filterPayslip()">
                @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                    <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>

            <label for="monthFilter">Month:</label>
            <select id="monthFilter" onchange="filterPayslip()">
                @for($m = 1; $m <= 12; $m++)
                    <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}" {{ str_pad($m, 2, '0', STR_PAD_LEFT) == $month ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create(null, $m, 1)->format('F') }}
                    </option>
                @endfor
            </select>

            <label for="periodFilter">Period:</label>
            <select id="periodFilter" onchange="filterPayslip()">
                <option value="1-15" {{ ($period ?? '1-15') == '1-15' ? 'selected' : '' }}>1st-15th</option>
                <option value="16-30" {{ ($period ?? '1-15') == '16-30' ? 'selected' : '' }}>16th-30th</option>
            </select>
        </div>

        @if($payslipData)
        <div class="payslip-container">
            <div class="payslip-header">
                <h1>NET PAY (Semi-Monthly Payslip)</h1>
                <p style="color: var(--clr-secondary); font-size: 14px;">
                    {{ $payslipData['period']['period_label']}}
                </p>
                <p style="color: var(--clr-secondary); font-size: 13px;">
                    Pay Period: {{ $payslipData['period']['start_date'] }} - {{ $payslipData['period']['end_date'] }}
                </p>
            </div>

            <div class="employee-info">
                <div class="info-item">
                    <span class="info-label">Employee Name:</span>
                    <span class="info-value">{{ $payslipData['employee']->first_name }} {{ $payslipData['employee']->middle_name }} {{ $payslipData['employee']->last_name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Employee ID:</span>
                    <span class="info-value">{{ $payslipData['employee']->employee_id }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Position:</span>
                    <span class="info-value">{{ $payslipData['employee']->job_position }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Days Worked:</span>
                    <span class="info-value">{{ $payslipData['work_summary']['total_days'] }} days</span>
                </div>
            </div>

            <table class="payslip-table">
                <tr class="section-header">
                    <th colspan="2">TAXABLE SALARY</th>
                    <th class="amount">AMOUNT</th>
                </tr>
                <tr>
                    <td colspan="2">Basic Semi-Monthly Salary ({{ $payslipData['work_summary']['total_days'] }} days × ₱{{ number_format($payslipData['rates']['daily'], 2) }})</td>
                    <td class="amount">₱{{ number_format($payslipData['earnings']['basic_salary'], 2) }}</td>
                </tr>
                <tr>
                    <td colspan="2">Daily Rate (₱{{ number_format($payslipData['rates']['daily'], 2) }} × 22 days)</td>
                    <td class="amount">₱{{ number_format($payslipData['rates']['monthly'], 2) }}</td>
                </tr>
                <tr>
                    <td colspan="2">Hourly Rate</td>
                    <td class="amount">₱{{ number_format($payslipData['rates']['hourly'], 2) }}</td>
                </tr>
                <tr>
                    @php
                        $employeeId = $payslipData['employee']->employee_id;

                        $startOfMonth = \Carbon\Carbon::now()->startOfMonth();
                        $endOfMonth =\Carbon\Carbon::now()->endOfMonth();

                        $logs = \App\Models\AttendanceLogs::where('employee_id', $employeeId)
                        ->whereBetween('log_date',[$startOfMonth, $endOfMonth])
                        ->get();

                        $sched = \App\Models\EmployeeSchedule::where('employee_id', $employeeId)
                        ->whereNull('end_date')
                        ->first();

                        $start_time = \Carbon\Carbon::parse($sched->start_time);
                        $end_time = \Carbon\Carbon::parse($sched->end_time);

                        $regularHour = $start_time->floatDiffInMinutes($end_time, true);

                        $totalOvertimeHours = 0;
                        $workHours = 0;


                        foreach ($logs as $log) {
                            $time_in = Carbon\Carbon::parse($log->clock_in_time);
                            $time_out =  Carbon\Carbon::parse($log->clock_out_time);

                            $workHours = $time_in->floatDiffInMinutes($time_out, true);

                            if($workHours > $regularHour) {
                                $totalOvertimeHours += abs($workHours - $regularHour);
                            }
                        }
                        $otHours = floor($totalOvertimeHours / 60); // Full hours
                        $otMinutes = $totalOvertimeHours % 60;
                    @endphp

                    @if($payslipData['earnings']['overtime_pay'])

                        @if($totalOvertimeHours < 60)
                            <td colspan="2">Total Overtime (in minutes)</td>
                            <td class="amount">{{$totalOvertimeHours}}</td>
                        @else
                            <td colspan="2">Total Overtime</td>
                            <td class="amount">{{ $otHours }}h {{ $otMinutes }}m</td>
                        @endif
                    @endif

                </tr>
                <tr>
                    <td colspan="2">Overtime Pay</td>
                    <td class="amount">₱{{ number_format($payslipData['earnings']['overtime_pay'], 2) }}</td>
                </tr>
                <tr>
                    <td colspan="2">Holiday Pay</td>
                    <td class="amount">{{ $payslipData['earnings']['holiday_pay'] > 0 ? '₱' . number_format($payslipData['earnings']['holiday_pay'], 2) : '-' }}</td>
                </tr>
                <tr>
                    <td colspan="2">Night Differentials</td>
                    <td class="amount">{{ $payslipData['earnings']['night_differential'] > 0 ? '₱' . number_format($payslipData['earnings']['night_differential'], 2) : '-' }}</td>
                </tr>
                @if($payslipData['work_summary']['late_minutes'] > 0)
                <tr>
                    <td colspan="2">Tardiness ({{ $payslipData['work_summary']['late_minutes'] }} minutes accumulated)</td>
                    <td class="amount" style="color: var(--clr-red);">(₱{{ number_format($payslipData['deductions']['late_deductions'], 2) }})</td>
                </tr>
                @endif
                <tr class="total-row">
                    <td colspan="2"><strong>GROSS SALARY</strong></td>
                    <td class="amount"><strong>₱{{ number_format($payslipData['earnings']['gross_taxable_salary'], 2) }}</strong></td>
                </tr>
            </table>
            @if($payslipData['period']['start_date'] != \Carbon\Carbon::now()->startOfMonth()->toDateString())
                <table class="payslip-table">
                    <tr class="section-header">
                        <th colspan="2">PREVIOUS PAYROLL</th>
                        <th class="amount">AMOUNT</th>
                    </tr>
                    <tr>
                        <td colspan="2">Late Deductions</td>
                        <td class="amount">₱{{ number_format($payslipData['previous_payroll']['previousLateDeductions'], 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Overtime Pay</td>
                        <td class="amount">₱{{ number_format($payslipData['previous_payroll']['previousOvertimePay'], 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Holiday Pay</td>
                        <td class="amount">₱{{ number_format($payslipData['previous_payroll']['previousHolidayPay'], 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Night Differentials</td>
                        <td class="amount">₱{{ number_format($payslipData['previous_payroll']['previousNightDifferential'], 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Previous Gross Salary</td>
                        <td class="amount">₱{{ number_format($payslipData['previous_payroll']['previousGrossSalary'], 2) }}</td>
                    </tr>

                    <tr class="total-row">
                        <td colspan="2"><strong>PREVIOUS NET SALARY</strong></td>
                        <td class="amount"><strong>₱{{ number_format($payslipData['previous_payroll']['previousNet'], 2) }}</strong></td>
                    </tr>
                </table>
            @endif
            <table class="payslip-table">
                <tr class="section-header">
                    <th colspan="2">STATUTORY DEDUCTIONS</th>
                    <th class="amount">AMOUNT</th>
                </tr>
                <tr>
                    <td colspan="2">SSS Monthly Contribution</td>
                    <td class="amount">₱{{ number_format($payslipData['deductions']['sss'], 2) }}</td>
                </tr>
                <tr>
                    <td colspan="2">PhilHealth Monthly Contributions</td>
                    <td class="amount">₱{{ number_format($payslipData['deductions']['philhealth'], 2) }}</td>
                </tr>
                <tr>
                    <td colspan="2">Pag-IBIG Fund Monthly Contributions</td>
                    <td class="amount">₱{{ number_format($payslipData['deductions']['pagibig'], 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td colspan="2"><strong>TOTAL STATUTORY DEDUCTIONS</strong></td>
                    <td class="amount"><strong>₱{{ number_format($payslipData['deductions']['total_statutory'], 2) }}</strong></td>
                </tr>
            </table>

            <table class="payslip-table">
                <tr>
                    <td colspan="2"><strong>Net Taxable Income (Gross Taxable Salary - Statutory Contributions)</strong></td>
                    <td class="amount"><strong>₱{{ number_format($payslipData['net_taxable_income'], 2) }}</strong></td>
                </tr>
                <tr>
                    <td colspan="2">Tax Bracket Applied (Based on Active Law Version)</td>
                    <td class="amount">₱{{ number_format($payslipData['deductions']['withholding_tax'], 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td colspan="2"><strong>WITHHOLDING TAX</strong></td>
                    <td class="amount"><strong>₱{{ number_format($payslipData['deductions']['withholding_tax'], 2) }}</strong></td>
                </tr>
            </table>

            <table class="payslip-table">
                <tr class="section-header">
                    <th colspan="2">SUMMARY</th>
                    <th class="amount">AMOUNT</th>
                </tr>
                <tr>
                    <td colspan="2">GROSS PAY</td>
                    <td class="amount">₱{{ number_format($payslipData['earnings']['gross_taxable_salary'], 2) }}</td>
                </tr>
                <tr>
                    <td colspan="2">GROSS DEDUCTIONS</td>
                    <td class="amount">₱{{ number_format($payslipData['deductions']['total_deductions'], 2) }}</td>
                </tr>
            </table>

            <div class="net-pay-section">
                <div class="label">NET PAY</div>
                <div class="amount">₱{{ number_format($payslipData['net_pay'], 2) }}</div>
            </div>

            <div class="actions">
                <a href="{{ route('employee.dashboard.payslip.print', ['id' => $employee->employee_id, 'year' => $year, 'month' => $month, 'period' => $period ?? 'monthly']) }}"
                   target="_blank"
                   class="btn-download-pdf">
                    <i class="fas fa-print"></i> Print Payslip
                </a>
            </div>
        </div>
        @endif
    </section>

    <script>
        function filterPayslip() {
            const year = document.getElementById('yearFilter').value;
            const month = document.getElementById('monthFilter').value;
            const period = document.getElementById('periodFilter').value;
            const employeeId = '{{ $employee->employee_id }}';

            window.location.href = `/dashboard/employee/payslip/${employeeId}?year=${year}&month=${month}&period=${period}`;
        }
    </script>
</x-app>
