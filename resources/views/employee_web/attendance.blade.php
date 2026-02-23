@vite('resources/css/employee_dashboard/attendance.css')
<x-app  :noHeader="true" :adminNav="false">

    @include('layouts.employee-side-nav')
    <section class="main-content">
        <div class="attendanceHeader">
            <h3 class="h">Attendance</h3>
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
<style>
    .attendanceHeader {
        width: 100%;
    }
    .h {
        margin-left: 60px;
    }
    @media (max-width: 1150px) {
        .h {
            margin-top: 15px;
            margin-left: 80px;
        }
    }
    @media (max-width: 800px) {
        .h {
            margin-left: 90px;
        }
    }
    @media (max-width: 480px) {
        .h {
            margin-left: 70px;
            margin-top: 25px;
        }
        .logs-wrapper {
            width: 90%;
            margin-left: -15px;
        }
    }
</style>
