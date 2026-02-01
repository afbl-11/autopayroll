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
                <h6>No Log Data</h6>
        @endforelse
    </section>

</x-app>

{{--TODO: fool proof everything--}}
