@vite('resources/css/company/company-cards.css')

<a href="{{route('company.dashboard.detail',['id'=> $id])}}">
    <div {{$attributes->class('company-card')}}>
        <div class="top-bar">
{{--            ...--}}
        </div>

        <div class="profile">
            <div class="profile-image">
                <img src="{{asset($logo)}}" alt="profile image">
            </div>
            <div class="profile-info">
                <p>{{$name}}</p>
                <small>{{$industry}}</small>
            </div>
        </div>

        <div class="description">
            <div class="company-id">
                <p>{{'#'. $id}}</p>
            </div>
            <div class="assigned-employee">
                <p>{{$count . ' ' . 'assigned employee'}}</p>
            </div>

            <div class="address">
                <p>{{$address}}</p>
            </div>
        </div>
    </div>
</a>
