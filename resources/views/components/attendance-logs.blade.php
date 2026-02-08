@vite('resources/css/components/attendance-logs.css')
@php
    switch ($status) {
        case 'A':
            $statusLabel = "Absent";
            break;
        case 'CDO':
        case 'DO':
            $statusLabel = "Day Off";
            break;
        case 'RH':
        case 'SH':
            $statusLabel = "Holiday";
            break;
        default:
            $statusLabel = "";
    }
@endphp

<div {{$attributes->class('logs-wrapper')}}>

    {{-- DATE & CLOCK-IN/CLOCK-OUT --}}
    <div class="data-wrapper">
        <p>{{ \Carbon\Carbon::parse($dayDate)->format('M d, Y (l)') }}</p>

        <div class="stats">
            <div class="stats-wrapper">
                <p>Clock-in</p>
                <p>{{ $clockIn ?? 'no data' }}</p>
            </div>

            <div class="stats-wrapper">
                <p>Clock out</p>
                <p>{{ $clockOut ?? 'no data' }}</p>
            </div>
        </div>
    </div>

    {{-- WORK HOURS TIMELINE --}}
    <div class="data-wrapper" id="work-hours">

        @if(empty($timeline) || is_null($timeline['startPercent']))
            <h6>{{$statusLabel}}</h6>
        @else
            <div class="timeline-wrapper">
                <div class="timeline">
                    <div class="timeline-track"></div>

                    <div class="timeline-progress"
                         style="left: {{ $timeline['startPercent'] }}%; width: {{ $timeline['workedPercent'] }}%;">
                    </div>
                </div>

                <div class="timeline-labels">
{{--                    {{dd($timeline['labels'])}}--}}
                    @foreach ($timeline['labels'] as $label)
                        <span>{{ $label }}</span>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <div class="data-wrapper">
        <div class="stats-wrapper">
            <p>Duration</p>
            <p>{{ $duration . ' Hours' ?? 'no data' }}</p>
        </div>
    </div>

</div>
