@vite('resources/css/employees/employee_card.css')

@if($clickable)
    <a href="{{route('employee.dashboard.detail', ['id' => $id])}}" >
        <div {{$attributes->merge(['class' => 'employee-card'])}}>
            <div class="top-bar">
                <x-state status="{{$status}}"></x-state>
                ...
                {{--                TODO: replace this--}}
            </div>

            <div class="profile">
                <div class="profile-image">
                    <img src="{{asset($image)}}" alt="profile image">
                </div>
                <div class="profile-info">
                    <p>{{$name}}</p>
                    <strong>#{{$id}}</strong>
                </div>
            </div>

            <div class="description">
                <div class="username">
                    <p>{{"@" . $username}}</p>
                </div>
                <div class="type">
                    <p>{{$position}}</p>
                    <div class="type-wrapper">
                        <img src="{{asset('assets/employeeProfile/Time.png')}}" alt="icon">
                        <p>{{$type}}</p>
                    </div>
                </div>
                <div class="email">
                    <img src="{{asset('assets/employeeProfile/Contact.png')}}" alt="icon">
                    <div class="email-wrapper">
                        <p>{{$email}}</p>
                    </div>
                </div>
                <div class="contact">
                    <p>{{$phone}}</p>
                </div>
            </div>

            <div class="employment_date">
                <small>{{$date}}</small>
            </div>
        </div>
    </a>
@else
        <div {{$attributes->merge(['class' => 'employee-card'])}}>
            <div class="top-bar">
                <x-state status="{{$status}}"></x-state>
                ...
                {{--                TODO: replace this--}}
            </div>

            <div class="profile">
                <div class="profile-image">
                    <img src="{{asset($image)}}" alt="profile image">
                </div>
                <div class="profile-info">
                    <p>{{$name}}</p>
                    <strong>#{{$id}}</strong>
                </div>
            </div>

            <div class="description">
                <div class="username">
                    <p>{{"@" . $username}}</p>
                </div>
                <div class="type">
                    <p>{{$position}}</p>
                    <div class="type-wrapper">
                        <img src="{{asset('assets/employeeProfile/Time.png')}}" alt="icon">
                        <p>{{$type}}</p>
                    </div>
                </div>
                <div class="email">
                    <img src="{{asset('assets/employeeProfile/Contact.png')}}" alt="icon">
                    <div class="email-wrapper">
                        <p>{{$email}}</p>
                    </div>
                </div>
                <div class="contact">
                    <p>{{$phone}}</p>
                </div>
            </div>

            <div class="employment_date">
                <small>{{$date}}</small>
            </div>
        </div>
@endif

{{--TODO: declare variables in the component class and set styling--}}
