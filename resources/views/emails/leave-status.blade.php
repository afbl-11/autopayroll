@extends('emails.layout')

@section('content')
    <p>Dear {{ $leave->employee->first_name }},</p>

    @if($leave->status === 'approved')
        <p>
            We are pleased to inform you that your leave request has been
            <strong>approved</strong>.
        </p>

        <p>
            <strong>Leave Details:</strong><br>
            Type: {{ ucfirst($leave->leave_type) }}<br>
            Duration: {{ \Carbon\Carbon::parse($leave->end_date)->format('F d, Y') }}
        </p>

        <p>
            Please ensure that any necessary work handovers are completed
            prior to the start of your leave.
        </p>

        <p>
            Should you have any questions, feel free to contact the HR
            department.
        </p>
    @else
        <p>
            Thank you for submitting your leave request. After careful review,
            we regret to inform you that your request has been
            <strong>not approved</strong> at this time.
        </p>

        <p>
            <strong>Leave Details:</strong><br>
            Type: {{ ucfirst($leave->leave_type) }}<br>
            Requested Dates: {{ \Carbon\Carbon::parse($leave->end_date)->format('F d, Y') }}
        </p>

        @if($leave->remarks)
            <p>
                <strong>Remarks:</strong><br>
                {{ $leave->remarks }}
            </p>
        @endif

        <p>
            You may submit a new leave request or reach out to HR if you
            require further clarification.
        </p>
    @endif

    <p>
        Kind regards,<br>
        <strong>{{ config('app.name') }} HR Team</strong>
    </p>
@endsection
