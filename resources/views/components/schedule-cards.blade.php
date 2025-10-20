@vite('resources/css/company/schedule-card.css')

<div {{$attributes->class('card-wrapper')}}>
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
            <x-form-select
                class="input-form"
                option
                id="shift"
                :value="$shift"/>

            <p>{{'starts at:' . ' ' . $start }}</p>
            <p>{{'ends at:' . ' ' . $end }}</p>
        </div>
        <div class="schedule-wrapper">
            <x-form-select class="input-form"/>
            <p>{{$description}}</p>
        </div>
    </div>
</div>
{{--TODO: make desctiption message--}}
