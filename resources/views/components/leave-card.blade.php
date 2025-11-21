@vite(['resources/css/components/leave-card.css'])

{{--{{dd($leaveId)}}--}}
<div {{$attributes->class('leave-card')}} onclick="window.location.href='{{ route($source, ['leaveId' => $leaveId, 'employeeId' => $employeeId]) }}'">
    <div class="leave-type">
       {{$leaveType}}
    </div>
    <div class="leave-message">
        <p>{{$message}}</p>
    </div>
    <div class="leave-date">{{$date}}</div>
    <div class="status">{{$status}}</div>
</div>
