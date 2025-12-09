@vite('resources/css/employees/employee_card.css')

@if($clickable)
<a href="{{ route('employee.dashboard.detail', ['id' => $id]) }}">
    <table class="employee-table-row">

        {{-- PROFILE (IMAGE + NAME + ID) --}}
        <tr>
            <th>Employee</th>
            <td class="employee-info-cell">
                <img src="{{ asset($image) }}" alt="Profile Image" class="employee-table-photo">
                <div class="employee-info-text">
                    <p class="employee-name">{{ $name }}</p>
                    <small class="employee-id">#{{ $id }}</small>
                </div>
            </td>
        </tr>

        {{-- USERNAME --}}
        <tr>
            <th>Username</th>
            <td>{{ '@' . $username }}</td>
        </tr>

        {{-- POSITION + TYPE --}}
        <tr>
            <th>Job Position</th>
            <td>
                <div class="employee-position-wrapper">
                    <span>{{ $position }}</span>
                </div>
            </td>
        </tr>

                <tr>
            <th>Employment Type</th>
            <td>
                <div class="employee-type-wrapper">
                    <img src="{{ asset('assets/employeeProfile/Time.png') }}" alt="icon" class="table-icon">
                    <span>{{ $type }}</span>
                </div>
            </td>
        </tr>

        {{-- EMAIL --}}
        <tr>
            <th>Email</th>
            <td class="employee-email-cell">
                <img src="{{ asset('assets/employeeProfile/Contact.png') }}" alt="icon" class="table-icon">
                <span>{{ $email }}</span>
            </td>
        </tr>

        {{-- CONTACT --}}
        <tr>
            <th>Phone</th>
            <td>{{ $phone }}</td>
        </tr>

        {{-- EMPLOYMENT DATE --}}
        <tr>
            <th>Employment Date</th>
            <td>{{ $date }}</td>
        </tr>

    </table>
</a>
@else
<table class="employee-table-row">

        {{-- PROFILE (IMAGE + NAME + ID) --}}
        <tr>
            <th>Employee</th>
            <td class="employee-info-cell">
                <img src="{{ asset($image) }}" alt="Profile Image" class="employee-table-photo">
                <div class="employee-info-text">
                    <p class="employee-name">{{ $name }}</p>
                    <small class="employee-id">#{{ $id }}</small>
                </div>
            </td>
        </tr>

        {{-- USERNAME --}}
        <tr>
            <th>Username</th>
            <td>{{ '@' . $username }}</td>
        </tr>

        {{-- POSITION + TYPE --}}
        <tr>
            <th>Job Position</th>
            <td>
                <div class="employee-position-wrapper">
                    <span>{{ $position }}</span>
                </div>
            </td>
        </tr>

                <tr>
            <th>Employment Type</th>
            <td>
                <div class="employee-type-wrapper">
                    <img src="{{ asset('assets/employeeProfile/Time.png') }}" alt="icon" class="table-icon">
                    <span>{{ $type }}</span>
                </div>
            </td>
        </tr>

        {{-- EMAIL --}}
        <tr>
            <th>Email</th>
            <td class="employee-email-cell">
                <img src="{{ asset('assets/employeeProfile/Contact.png') }}" alt="icon" class="table-icon">
                <span>{{ $email }}</span>
            </td>
        </tr>

        {{-- CONTACT --}}
        <tr>
            <th>Phone</th>
            <td>{{ $phone }}</td>
        </tr>

        {{-- EMPLOYMENT DATE --}}
        <tr>
            <th>Employment Date</th>
            <td>{{ $date }}</td>
        </tr>

</table>
@endif
