<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

@vite('resources/css/employee_dashboard/attendance.css')

<x-app :navigation="true" navigationType="employee" :employee="$employee" :noHeader="true">
    <x-attendance-navigation
        :daysActive="$daysActive"
        :totalLate="$countLate"
        :totalOvertime="$totalOvertime"
        :noClockOut="$totalNoClockOut"
        :totalAbsences="$absences"
        :leaveBalance="$creditDays"
        :id="$employee->employee_id"
    />

    <section class="main-content">
        @forelse ($attendance['logs'] as $log)
            <x-attendance-logs
                :clockIn="$log['time_in']"
                :clockOut="$log['time_out']"
                :dayDate="$log['log_date']"
                :dateWeek="$log['date']"
                :duration="$log['work_hours']"
                :late="$attendance['late']"
                :timeline="$log['timeline']"
                :status="$log['status']"
            />
        @empty
            <div class="text-center py-5">
                <h6 class="text-muted">No Log Data</h6>
            </div>
        @endforelse

            <div class="attendance-pagination d-flex flex-column align-items-center w-full py-10 mt-8 border-t border-gray-100">
                {!! $attendance['logs']->links('pagination::bootstrap-5') !!}
            </div>
    </section>
</x-app>

<style>
    /* Space out the individual numbers */
    .attendance-pagination .page-item {
        margin: 0 4px; /* Gives each number a little gap */
    }

    /* Style the links to be rounded and clean */
    .attendance-pagination .page-link {
        border-radius: 8px !important; /* Makes them soft squares/circles */
        border: 1px solid #e5e7eb;
        color: var(--clr-primary);
        padding: 8px 16px;
        transition: all 0.2s ease;
    }

    /* Make the active page pop */
    .attendance-pagination .page-item.active .page-link {
        background-color: var(--clr-primary) !important;
        border-color: var(--clr-primary) !important;
        color: white !important;
        box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.4);
    }

    /* Hide that "Showing 1 to 10" text if you want it super clean */
    .attendance-pagination nav > div:first-child {
        display: none !important;
    }
</style>

{{--TODO: fool proof everything--}}
