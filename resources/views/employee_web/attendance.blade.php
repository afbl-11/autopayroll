@vite('resources/css/employee_dashboard/attendance.css')
<style>
    .attendanceHeader {
        width: 100%;
        margin-left: 10%;
    }
</style>
<x-app  :noHeader="true" :adminNav="false">

    @include('layouts.employee-side-nav')
    <section class="main-content">
        <div class="attendanceHeader">
            <h3>Attendance</h3>
        </div>
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
