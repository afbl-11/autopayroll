@vite('resources/css/company/schedule-card.css')

<div {{$attributes->class('card-wrapper')}} data-id="{{$id}}" onclick="openScheduleModal(this)">
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
            <small>{{'starts at:' . ' ' . $start }}</small>
            <small>{{'ends at:' . ' ' . $end }}</small>
        </div>
{{--        changed to working days--}}
        <div class="schedule-wrapper">
            <small>{{$description}}</small>
        </div>
    </div>
</div>
{{--TODO: make desctiption message--}}
<script>
    function openScheduleModal(card) {
        const scheduleId = card.dataset.id;
        console.log('Opening modal for schedule:', scheduleId);
        const modal = document.getElementById('scheduleModal');
        modal.classList.add('open');
    }
</script>
