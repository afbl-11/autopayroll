@vite(['resources/css/employee_dashboard/leave-request.css'])

<x-app  :navigation="true" navigationType="employee" :employee="$employee" :noHeader="true">
    <x-attendance-navigation
        :daysActive="$reports['daysActive']"
        :totalLate="$reports['countLate']"
        :totalOvertime="$reports['totalOvertime']"
        :noClockOut="$reports['totalNoClockOut']"
        :totalAbsences="$reports['absences']"
        :leaveBalance="$reports['creditDays']"
        :id="$employee->employee_id"
    />

    <section class="main-content">
        <div class="leave-wrapper">
            <div class="message">
                {{$leave->reason}}
            </div>
            <div class="leave-handle-wrapper">
                <div class="employee-data">
                    <x-form-input
                        label="Leave Request Number"
                        :value="$leaveCount"
                        :readOnly="true"
                    />

                    <x-form-input
                        label="Leave Type"
                        :value="$leave->leave_type"
                        :readOnly="true"
                    />

                    <x-form-input
                        label="Fillin Date"
                        :value="$leave->submission_date"
                        :readOnly="true"
                    />
                    {{--                {{dd($duration)}}--}}
                    <x-form-input
                        label="Leave Duration"
                        :value="$duration . ' days'"
                    />
                </div>

                <div class="action-buttons">
                    <form action="{{route('approve.leave', ['employeeId' => $employee->employee_id, 'leaveId' => $leave->leave_request_id])}}" method="post">
                        @csrf
                        <x-button-submit>Approve</x-button-submit>
                    </form>
                    <div class="button-rejects">
                        <form action="{{route('revise.leave', ['employeeId' => $employee->employee_id, 'leaveId' => $leave->leave_request_id])}}" method="post">
                            @csrf
                            <x-button-submit id="btn-revision">Send for Revision</x-button-submit>
                        </form>
                        <form action="{{route('reject.leave', ['employeeId' => $employee->employee_id, 'leaveId' => $leave->leave_request_id])}}" method="post">
                            @csrf
                            <x-button-submit id="btn-reject">Reject</x-button-submit>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
</x-app>
