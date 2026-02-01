@extends('emails.layout')

@section('content')
    <h3>
        {{ $adjustment->status === 'approved' ? 'Your Adjustment Has Been Approved ✅' : 'Update on Your Adjustment Request ❌' }}
    </h3>

    <p>
        Dear {{ $adjustment->employee->first_name }},<br>
        We are writing to inform you that your adjustment request has been
        <strong>{{ ucfirst($adjustment->status) }}</strong>.
    </p>

    <p>
        <strong>Adjustment Details:</strong><br>
        Type: {{ ucfirst($adjustment->adjustment_type) }}<br>
        @if($adjustment->subtype)
            Subtype: {{ $adjustment->subtype }}<br>
        @endif
        @if($adjustment->start_date && $adjustment->end_date)
            Period: {{ \Carbon\Carbon::parse($adjustment->start_date)->format('F d, Y') }}
            to {{ \Carbon\Carbon::parse($adjustment->end_date)->format('F d, Y') }}<br>
        @elseif($adjustment->affected_date)
            Date: {{ \Carbon\Carbon::parse($adjustment->affected_date)->format('F d, Y') }}<br>
        @endif
        Reason: {{ $adjustment->reason ?? 'N/A' }}<br>
        @if($adjustment->attachment_path)
            Attachment: <a href="{{ asset('storage/' . $adjustment->attachment_path) }}">View</a>
        @endif
    </p>

    @if($adjustment->status === 'approved')
        <p>
            The approved adjustment will be reflected in your upcoming payroll or as applicable.
            Please review your payslip after processing to confirm the changes.
        </p>
        <p>
            <strong>Next Steps:</strong><br>
            • No action is required on your part.<br>
            • If you notice any discrepancy, contact your admin immediately.
        </p>
    @else
        <p>
            Your adjustment request was not approved at this time. For more details, you may contact your admin.
        </p>
        <p>
            <strong>Next Steps:</strong><br>
            • Review your request and consider resubmission if needed.<br>
            • Reach out to your admin for clarification.
        </p>
    @endif

    <p>
        Submitted on: {{ \Carbon\Carbon::parse($adjustment->created_at)->format('F d, Y H:i A') }}
    </p>

    <p>Thank you,<br>The Payroll Team</p>
@endsection
