@vite('resources/css/company/header.css')

<div {{$attributes->merge(['class'=> 'header'])}}>
    <div class="company-information">
        <div class="company-logo">
            <img src="{{asset($logo)}}" alt="company logo">
        </div>
        <div>
            <h6>{{$name}}</h6>
            <p>{{'#'.$id}}</p>
        </div>
    </div>
    <nav>
        <ul>
            <li><a href="{{route('company.dashboard.detail', ['id' => $id])}}">Company Information</a></li>
            <li><a href="{{route('company.dashboard.employees', ['id' => $id])}}">Employees</a></li>
            <li><a href="{{route('company.dashboard.schedules', ['id' => $id])}}">Schedules</a></li>
            <li><a href="{{route('company.dashboard.location', ['id' => $id])}}">Location</a></li>
        </ul>
    </nav>
</div>
