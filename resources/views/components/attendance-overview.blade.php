@vite('resources/css/components/attendance-overview.css')

<div class="status-overview-card" onclick="window.location.href='{{route($source, ['id' => $employeeId ])}}'">
   <div class="profile">
       <img src="{{asset($profile)}}" alt="">
   </div>
    <div class="name">
        <p>{{$name}}</p>
    </div>
    <x-state status="{{$status}}"></x-state>
</div>
