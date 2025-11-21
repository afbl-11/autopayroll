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

        <div class="request-list">
            <nav>
                <h6>Request List</h6>
            </nav>
            <div class="request-cards">
                @forelse($leave as $leaves)
                    <x-leave-card
                        source="employee.leave.detail"
                        :leaveId="$leaves->leave_request_id"
                        :employeeId="$employee->employee_id"
                        :leave_type="$leaves->leave_type"
                        :message="$leaves->reason"
                        :date="\Carbon\Carbon::parse($leaves->submission_date)->format('Y-m-d')"
                        :status="$leaves->status"
                    />
                    @empty
                    <p id="empty" >Employee currently don't have a request</p>
                @endforelse
            </div>
        </div>


    </section>
</x-app>
