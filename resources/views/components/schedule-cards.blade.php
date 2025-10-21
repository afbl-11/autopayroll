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
                :options="$options"
                :id="$id"
                :name="$id"
                :default="'current-' . $labels">

            </x-form-select>
{{--time should also be dynamic--}}
            <small>{{'starts at:' . ' ' . $start }}</small>
            <small>{{'ends at:' . ' ' . $end }}</small>
        </div>
        <div class="schedule-wrapper">
            <x-form-select class="input-form"/>
            <small>{{$description}}</small>
        </div>
    </div>
</div>
{{--TODO: make desctiption message--}}
