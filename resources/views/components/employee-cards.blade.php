@vite('resources/css/employees/employee_card.css')

@if($clickable)
<a href="{{ route('employee.dashboard.detail', ['id' => $id]) }}">
<div class="employee-row">

    {{-- EMPLOYEE BASIC INFO --}}
    <div class="er-col er-employee">
        <img src="{{ asset($image) }}" alt="Employee Photo" class="employee-photo">
        <div class="employee-text">
            <p class="employee-name">{{ $name }}</p>
            <small class="employee-id">#{{ $id }}</small>
        </div>
    </div>

    {{-- USERNAME --}}
    <div class="er-col er-username">
        {{ '@' . $username }}
    </div>

    {{-- POSITION --}}
    <div class="er-col er-position">
        {{ $position }}
    </div>

    {{-- EMPLOYMENT TYPE --}}
    <div class="er-col er-type">
        <img src="{{ asset('assets/employeeProfile/Time.png') }}" class="employee-icon">
        <span>{{ $type }}</span>
    </div>

    {{-- STATUS --}}
    <div class="er-col er-status">
        <x-state status="{{ $status }}"></x-state>
    </div>

</div>
</a>
@else
<div class="employee-row">

    {{-- EMPLOYEE BASIC INFO --}}
    <div class="er-col er-employee">
        <img src="{{ asset($image) }}" alt="Employee Photo" class="employee-photo">
        <div class="employee-text">
            <p class="employee-name">{{ $name }}</p>
            <small class="employee-id">#{{ $id }}</small>
        </div>
    </div>

    {{-- USERNAME --}}
    <div class="er-col er-username">
        {{ '@' . $username }}
    </div>

    {{-- POSITION --}}
    <div class="er-col er-position">
        {{ $position }}
    </div>

    {{-- EMPLOYMENT TYPE --}}
    <div class="er-col er-type">
        <img src="{{ asset('assets/employeeProfile/Time.png') }}" class="employee-icon">
        <span>{{ $type }}</span>
    </div>

    {{-- STATUS --}}


        @if($status)
    <div class="er-col er-status">
        <x-state status="{{ $status }}"></x-state>
    </div>
        @endif

</div>
@endif
