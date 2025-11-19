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
{{--            {{dd($timeline)}}--}}
            <x-attendance-logs
                :clockIn="$log['clock_in_time']"
                :clockOut="$log['clock_out_time']"
                :dayDate="$log['day']"
                :dateWeek="$log['date']"
                :duration="$log['duration']"
                :late="$attendance['late']"
                :timeline="$timeline"
            />
            @empty
                <h6>No Log Data</h6>
        @endforelse
    </section>

</x-app>

{{--TODO: fool proof everything--}}
