@vite('resources/css/components/attendance-logs.css')

<div {{$attributes->class('logs-wrapper')}}>
    <div class="data-wrapper">
{{--        date--}}
        <p>{{ $dateWeek && $dayDate ? $dateWeek . ', ' . $dayDate : 'no data' }}</p>
        <div class="stats">
            <div class="stats-wrapper">
                <p>Clock-in</p>
                <p>{{$clockIn ? : 'no data'}}</p>
            </div>
            <div class="stats-wrapper">
                <p>Clock out</p>
                <p>{{$clockOut ? : 'no data'}}</p>
            </div>
        </div>
    </div>
    <div class="data-wrapper" id="work-hours">
        @if(!$regularHours)
            <h6>No data</h6>
        @endif
{{--        the time range should depend on what time the employees start is--}}
    </div>
    <div class="data-wrapper">
        <div class="stats-wrapper">
            <p>Duration</p>
            <p>{{$duration ? : 'no data'}}</p>
        </div>
    </div>

</div>
