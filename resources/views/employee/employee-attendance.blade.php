@vite('resources/css/employee_dashboard/attendance.css')
<x-app :navigation="true" navigationType="employee" :employee="$employee" :noHeader="true">
    <x-attendance-navigation
        :daysActive="$daysActive"
        :totalLate="$countLate"
        :totalOvertime="$totalOvertime"
        :noClockOut="$totalNoClockOut"
        :totalAbsences="$absences"
        leaveBalance="15"
    />
    <section class="main-content">


        @forelse ($attendance['logs'] as $log)
            <x-attendance-logs
                :clockIn="$log->clock_in_time"
                :clockOut="$log->clock_out_time"
{{--                :dayDate=""--}}
{{--                :dayWeek=""--}}
{{--                :duration=""--}}
                :late="$attendance['late']"
{{--                :overtime=""--}}
{{--                :regularHours--}}
            />
            @empty
                <h6>No Log Data</h6>
        @endforelse
    </section>

</x-app>
