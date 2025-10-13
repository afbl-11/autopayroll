@vite('resources/css/employees/employee_card.css')

<div {{$attributes->merge(['class' => 'employee-card'])}}>
        <div class="top-bar">
            <x-state></x-state>
            ...
        </div>

        <div class="profile">
            <div class="profile-image">
                <img src="" alt="">
            </div>
            <p>name</p>
            <small>position</small>
        </div>

        <div class="description">
            <div class="employee-id"></div>
            <div class="position"></div>
            <div class="email"></div>
            <div class="contact"></div>
        </div>

    <div class="date-start"></div>
</div>

{{--TODO: declare variables in the component class and set styling--}}
