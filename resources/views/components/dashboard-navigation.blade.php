@vite('resources/css/company/header.css')

<div {{$attributes->merge(['class'=> 'header'])}}>
    <div class="company-information">
        <div class="company-logo">
            @if($type === 'company')
                <img src="{{asset($companyLogo)}}" alt="company logo">
                @else
                <img src="{{asset($employeeProfile)}}" alt="employee image">
            @endif
        </div>
        <div>
            <h6>{{$name}}</h6>
            <p>{{'#'.$id}}</p>
        </div>
    </div>
    <nav>
        @if($type === 'company')
            <ul>
                <li><a href="{{route('company.dashboard.detail', ['id' => $id])}}">Company Information</a></li>
                <li><a href="{{route('company.dashboard.employees', ['id' => $id])}}">Employees</a></li>
                <li><a href="{{route('company.dashboard.schedules', ['id' => $id])}}">Schedules</a></li>
                <li><a href="{{route('company.qr.management', ['id' => $id])}}">QR Management</a></li>
            </ul>
        @elseif($type === 'employee')
            <ul>
                <li><a href="{{route('employee.dashboard.detail', ['id' => $id])}}">Personal Information</a></li>
                <li><a href="{{route('employee.dashboard.attendance', ['id' => $id])}}">Attendance</a></li>
                <li><a href="{{route('employee.dashboard.payroll', ['id' => $id])}}">Payroll</a></li>
                <li><a href="{{route('employee.dashboard.documents', ['id' => $id])}}">Documents</a></li>
                <li><a href="{{route('employee.dashboard.contract', ['id' => $id])}}">Contract</a></li>
            </ul>
        @endif
    </nav>
</div>
