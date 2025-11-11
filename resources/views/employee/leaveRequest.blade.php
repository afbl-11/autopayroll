@vite(['resources/css/employee_dashboard/leave-request.css'])

<x-app  :navigation="true" navigationType="employee" :employee="$employee" :noHeader="true">
    <x-attendance-navigation
        daysActive=""
        totalLate=""
        totalOvertime=""
        noClockOut=""
        totalAbsences=""
        leaveBalance=""
        :id="$employee->employee_id"
    />

    <section class="main-content">

        <div class="request-list">
            <nav>
                <h6>Request List</h6>
            </nav>
            <div class="request-cards">
                @foreach($leave as $leaves)
                    <x-leave-card
                        :leaveId="$leaves->leave_request_id"
                        :employeeId="$employee->employee_id"
                        :leave_type="$leaves->leave_type"
                        :message="$leaves->reason"
                        :date="\Carbon\Carbon::parse($leaves->submission_date)->format('Y-m-d')"
                        :status="$leaves->status"
                    />
                @endforeach
            </div>
        </div>


    </section>
</x-app>
