<x-app :title="$title">
    <h2>{{ $company->name }}</h2>
    <p>Total Employees: {{ $company->employees->count() }}</p>

    <ul>
        @foreach ($company->employees as $employee)
            <li>{{ $employee->first_name }}</li>
        @endforeach
    </ul>


</x-app>
