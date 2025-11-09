@if($type === 'daily')
    <thead>
    <tr>
        <th>Pay Date</th>
        <th>Work Hours</th>
        <th>Net Pay</th>
        <th>Gross Earning</th>
        <th>Overtime</th>
        <th>Minutes Late</th>
        <th>Deduction</th>
        <th>Holiday Pay</th>
        <th>Night Differential</th>
    </tr>
    </thead>

    <tbody>
    @forelse($payroll as $summary)
        <tr>
            <td>{{$summary->payroll_date}}</td>
            <td>{{$summary->work_hours}}</td>
            <td>{{$summary->net_salary}}</td>
            <td>{{$summary->gross_salary}}</td>
            <td>{{$summary->overtime}}</td>
            <td>{{$summary->late_time}}</td>
            <td>{{$summary->deduction}}</td>
            <td>{{$summary->holiday_pay}}</td>
            <td>{{$summary->night_differential}}</td>
        </tr>
    @empty
        <tr>
            <td colspan="10">No existing payroll log</td>
        </tr>
    @endforelse
    </tbody>
@elseif($type === 'semi')
    <thead>
    <tr>
        <th>Pay Date</th>
        <th>Rate</th>
        <th>Pag Ibig</th>
        <th>Phil-Health</th>
        <th>SSS</th>
        <th>Late Deduction</th>
        <th>Holiday</th>
        <th>Night Differential</th>
        <th>Overtime</th>
        <th>Gross Salary</th>
        <th>Net Salary</th>
        <th>Status</th>

    </tr>
    </thead>

    <tbody>
    @forelse($payroll as $summary)
        <tr>
            <td>{{$summary->pay_date}}</td>
            <td>{{$summary->rate}}</td>
            <td>{{$summary->pag_ibig_deductions}}</td>
            <td>{{$summary->phil_health_deductions}}</td>
            <td>{{$summary->sss_deductions}}</td>
            <td>{{$summary->late_deductions}}</td>
            <td>{{$summary->holiday}}</td>
            <td>{{$summary->night_differential}}</td>
            <td>{{$summary->overtime}}</td>
            <td>{{$summary->gross_salary}}</td>
            <td>{{$summary->net_pay}}</td>
            <td>{{$summary->status}}</td>
        </tr>
    @empty
        <tr>
            <td colspan="12">No existing payroll log</td>
        </tr>
    @endforelse
    </tbody>

@endif
