@vite(['resources/css/components/leave-card.css'])

<div {{$attributes->class('leave-card')}} onclick="window.location.href='{{ route('employee.leave.detail', ['leaveId' => $leaveId, 'employeeId' => $employeeId]) }}'">
    <div class="leave-type">
       {{$leaveType}}
    </div>
    <div class="leave-message">
        {{$message}}
    </div>
    <div class="leave-date">{{$date}}</div>
    <div class="status">{{$status}}</div>
</div>
