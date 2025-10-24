@vite('resources/css/employee_dashboard/attendance.css')

<x-app :navigation="true" navigationType="employee" :employee="$employee" :noHeader="true">
    <x-attendance-navigation/>
    <section class="main-content">
        {{$daysActive}}
        {{$absences}}

    </section>

</x-app>
