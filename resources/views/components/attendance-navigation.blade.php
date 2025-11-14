@vite('resources/css/employee_dashboard/attendance-nav.css')

<div {{$attributes->class('content-wrapper')}}>
    <div class="links">
        <ul>
            <li><a href="{{route('employee.dashboard.attendance', ['id' => $id])}}">Attendance</a></li>
{{--            <li><a href=""></a>Absences</li>--}}
            <li><a href="{{route('employee.leave.request', ['id' => $id])}}">Leave Request</a></li>
        </ul>
    </div>
    <div class="summary-content">
        <div class="content-cards">
            <p>Days active</p>
            <strong>{{$daysActive}}</strong>
        </div>
        <div class="content-cards">
            <p>Absences</p>
            <strong>{{$totalAbsences}}</strong>
        </div>
        <div class="content-cards">
            <p>Total overtime</p>
            <strong>{{$totalOvertime}}</strong>
        </div>
        <div class="content-cards">
            <p>No clock-out</p>
            <strong>{{$noClockOut}}</strong>
        </div>
        <div class="content-cards">
            <p>Leave balance</p>
            <strong>{{$leaveBalance}}</strong>
        </div>
        <div class="content-cards">
            <p>Lates</p>
            <strong>{{$totalLate}}</strong>
        </div>
    </div>
</div>
