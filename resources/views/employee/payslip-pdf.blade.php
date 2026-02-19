<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semi-Monthly Payslip - {{ date('F Y', strtotime("$year-$month-01")) }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @page {
            size: A4;
            margin-top: 0.33in;
            margin-right: 0.63in;
            margin-bottom: 0.19in;
            margin-left: 0.63in;
        }

        @media print {
            body {
                width: 210mm;
                height: 297mm;
            }
            .no-print {
                display: none;
            }
            .page-break {
                page-break-after: always;
            }
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 9pt;
            line-height: 1.2;
            color: #000;
            background: #fff;
            padding: 10px;
            max-width: 210mm;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
        }

        .header h1 {
            font-size: 16pt;
            font-weight: bold;
            margin-bottom: 3px;
            text-transform: uppercase;
        }

        .header h2 {
            font-size: 12pt;
            font-weight: normal;
            margin-bottom: 5px;
        }

        .header .period {
            font-size: 10pt;
            font-weight: bold;
            margin-top: 5px;
        }

        .info-section {
            margin-bottom: 10px;
        }

        .info-grid {
            display: table;
            width: 100%;
            border: 1px solid #000;
            margin-bottom: 8px;
        }

        .info-row {
            display: table-row;
        }

        .info-cell {
            display: table-cell;
            padding: 4px 8px;
            border: 1px solid #000;
            font-size: 8pt;
        }

        .info-label {
            font-weight: bold;
            width: 25%;
            background: #f5f5f5;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            font-size: 8pt;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 4px 6px;
            text-align: left;
        }

        table th {
            background: #f5f5f5;
            font-weight: bold;
            text-align: center;
        }

        table td.amount {
            text-align: right;
            font-family: 'Courier New', monospace;
        }

        .section-title {
            font-size: 10pt;
            font-weight: bold;
            margin: 10px 0 5px 0;
            text-transform: uppercase;
            border-bottom: 2px solid #000;
            padding-bottom: 3px;
        }

        .summary-box {
            border: 2px solid #000;
            padding: 8px;
            margin: 10px 0;
            background: #fffef0;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 4px 0;
            font-size: 9pt;
        }

        .summary-row.total {
            font-size: 11pt;
            font-weight: bold;
            border-top: 2px solid #000;
            margin-top: 5px;
            padding-top: 8px;
        }

        .net-pay-section {
            text-align: center;
            margin: 10px 0;
            padding: 10px;
            background: #ffeb3b;
            border: 3px solid #000;
        }

        .net-pay-section .label {
            font-size: 11pt;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .net-pay-section .amount {
            font-size: 18pt;
            font-weight: bold;
            font-family: 'Courier New', monospace;
        }

        .footer {
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px solid #000;
            font-size: 7pt;
            text-align: center;
            color: #666;
        }

        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .signature-box {
            width: 45%;
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #000;
            margin-top: 30px;
            padding-top: 3px;
            font-size: 8pt;
        }

        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 24px;
            background: #4f46e5;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            z-index: 1000;
        }

        .print-button:hover {
            background: #4338ca;
        }

        .text-right {
            text-align: right;
        }

        .font-bold {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <button onclick="window.print()" class="print-button no-print">Print / Save as PDF</button>

    <div class="header">
        <h1>PAYSLIP</h1>
        @php

        $employee = $payslipData['employee'];
        $companyName = \App\Models\Company::where('company_id', $employee->company_id)
        ->pluck('company_name')
        ->first();
        @endphp


        <h2>{{$companyName}}</h2>

        <div class="period">
            {{ $payslipData['period']['period_label'] }}
        </div>
    </div>

    <!-- Employee Information -->
    <div class="info-section">
        <h3 class="section-title">Employee Information</h3>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-cell info-label">Employee Name:</div>
                <div class="info-cell">{{ $payslipData['employee']->first_name }} {{ $payslipData['employee']->last_name }}</div>
                <div class="info-cell info-label">Employee ID:</div>
                <div class="info-cell">{{ $payslipData['employee']->employee_id }}</div>
            </div>
            <div class="info-row">
                <div class="info-cell info-label">Position:</div>
                <div class="info-cell">{{ $payslipData['employee']->job_position ?? 'N/A' }}</div>
                <div class="info-cell info-label">Days Worked:</div>
                <div class="info-cell">{{ $payslipData['work_summary']['total_days'] }} days</div>
            </div>
        </div>
    </div>

    <!-- Taxable Salary -->
    <h3 class="section-title">Taxable Salary</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 50%">Description</th>
                <th style="width: 25%">Rate</th>
                <th style="width: 25%">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Basic Salary (Monthly)</td>
                <td class="amount">₱{{ number_format($payslipData['rates']['monthly'], 2) }}</td>
                <td class="amount">₱{{ number_format($payslipData['earnings']['basic_salary'], 2) }}</td>
            </tr>
            <tr>
                <td>Daily Rate</td>
                <td class="amount">₱{{ number_format($payslipData['rates']['daily'], 2) }}</td>
                <td class="amount">-</td>
            </tr>
            <tr>
                <td>Hourly Rate</td>
                <td class="amount">₱{{ number_format($payslipData['rates']['hourly'], 2) }}</td>
                <td class="amount">-</td>
            </tr>
            <tr>
                <td>Overtime Pay</td>
                <td class="amount">-</td>
                <td class="amount">₱{{ number_format($payslipData['earnings']['overtime_pay'], 2) }}</td>
            </tr>
            <tr>
                <td>Holiday Pay</td>
                <td class="amount">-</td>
                <td class="amount">₱{{ number_format($payslipData['earnings']['holiday_pay'], 2) }}</td>
            </tr>
            <tr>
                <td>Night Differential</td>
                <td class="amount">-</td>
                <td class="amount">₱{{ number_format($payslipData['earnings']['night_differential'], 2) }}</td>
            </tr>
            <tr>
                <td>Tardiness / Undertime</td>
                <td class="amount">-</td>
                <td class="amount">(₱{{ number_format($payslipData['deductions']['late_deductions'], 2) }})</td>
            </tr>
            <tr class="font-bold">
                <td colspan="2" style="text-align: right;">Gross Salary:</td>
                <td class="amount">₱{{ number_format($payslipData['earnings']['gross_taxable_salary'], 2) }}</td>
            </tr>
        </tbody>
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
    <!-- Statutory Deductions -->
    <h3 class="section-title">Statutory Deductions</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 50%">Deduction Type</th>
                <th style="width: 25%">Employee Share</th>
                <th style="width: 25%">Employer Share</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>SSS Contribution</td>
                <td class="amount">₱{{ number_format($payslipData['deductions']['sss'], 2) }}</td>
                <td class="amount">₱{{ number_format($payslipData['deductions']['employer_sss'], 2) }}</td>
            </tr>
            <tr>
                <td>PhilHealth Contribution</td>
                <td class="amount">₱{{ number_format($payslipData['deductions']['philhealth'], 2) }}</td>
                <td class="amount">₱{{ number_format($payslipData['deductions']['employer_philhealth'], 2) }}</td>
            </tr>
            <tr>
                <td>Pag-IBIG Contribution</td>
                <td class="amount">₱{{ number_format($payslipData['deductions']['pagibig'], 2) }}</td>
                <td class="amount">₱{{ number_format($payslipData['deductions']['employer_pagibig'], 2) }}</td>
            </tr>
            <tr class="font-bold">
                <td style="text-align: right;">Total Statutory Deductions:</td>
                <td class="amount">₱{{ number_format($payslipData['deductions']['total_statutory'], 2) }}</td>
                <td class="amount">₱{{ number_format($payslipData['deductions']['total_employer'], 2) }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Tax Computation -->
    <div class="summary-box">
        <div class="summary-row">
            <span>Net Taxable Income:</span>
            <span>₱{{ number_format($payslipData['net_taxable_income'], 2) }}</span>
        </div>
        <div class="summary-row">
            <span>Withholding Tax (15% over ₱20,833):</span>
            <span>₱{{ number_format($payslipData['deductions']['withholding_tax'], 2) }}</span>
        </div>
    </div>

    <!-- Summary -->
    <h3 class="section-title">Summary</h3>
    <table>
        <tbody>
            <tr>
                <td class="font-bold" style="width: 50%">Gross Pay</td>
                <td class="amount font-bold">₱{{ number_format($payslipData['earnings']['gross_taxable_salary'], 2) }}</td>
            </tr>
            <tr>
                <td class="font-bold">Total Deductions</td>
                <td class="amount font-bold">₱{{ number_format($payslipData['deductions']['total_deductions'], 2) }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Net Pay -->
    <div class="net-pay-section">
        <div class="label">NET PAY</div>
        <div class="amount">₱{{ number_format($payslipData['net_pay'], 2) }}</div>
    </div>

    <!-- Signatures -->
    <div class="signature-section">
        <div class="signature-box">
            <div class="signature-line">
                Employee Signature
            </div>
            <div style="margin-top: 5px; font-size: 9pt;">
                Date: _________________
            </div>
        </div>
        <div class="signature-box">
            <div class="signature-line">
                Authorized Signature
            </div>
            <div style="margin-top: 5px; font-size: 9pt;">
                Date: _________________
            </div>
        </div>
    </div>

    <div class="footer">
        <p>This is a computer-generated payslip. No signature is required.</p>
        <p>Generated on: {{ date('F d, Y') }}</p>
    </div>
</body>
</html>
