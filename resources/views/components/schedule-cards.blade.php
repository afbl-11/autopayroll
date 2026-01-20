@vite('resources/css/company/schedule-card.css')

<div
    {{$attributes->class('card-wrapper')}}
    data-id="{{$id}}"
    data-name="{{$name}}"
    data-start="{{$start ?? ''}}"
    data-end="{{$end ?? ''}}"
    data-type="{{$attributes->get('data-type', '')}}"
    data-days='{{$attributes->get('data-days', '[]')}}'
    data-available-days='{{$attributes->get('data-available-days', '[]')}}'
>
    <div class="profile">
        <div class="image-wrapper">
            <img src="{{asset($image)}}" alt="profile-pic">
        </div>
        <div class="name-wrapper">
            <p>{{$name}}</p>
            <small>{{$id}}</small>
        </div>
    </div>

    <div class="input-wrapper">
        <div class="shift-wrapper">
            <small>Starts at: {{ $start ?: '—' }}</small>
            <small>Ends at: {{ $end ?: '—' }}</small>
        </div>
        <div class="schedule-wrapper">
            <small>{{ $description ?: 'No schedule assigned' }}</small> <br>
            @php
                $days = json_decode($scheduleDays, true);
                // Flatten nested arrays if needed (e.g., [["Mon"],["Tues"]] becomes ["Mon","Tues"])
                if (is_array($days) && count($days) > 0) {
                    $flatDays = array_map(function($day) {
                        return is_array($day) ? $day[0] : $day;
                    }, $days);
                    $displayDays = implode(', ', $flatDays);
                } else {
                    $displayDays = 'No days assigned';
                }
            @endphp
            <small>{{ $displayDays }}</small>
        </div>
    </div>
</div>