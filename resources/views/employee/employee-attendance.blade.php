@vite('resources/css/employee_dashboard/attendance.css')

<x-app :navigation="true" navigationType="employee" :employee="$employee" :noHeader="true">
    <x-attendance-navigation
        :daysActive="$daysActive"
        :totalLate="$countLate"
        :totalOvertime="$totalOvertime"
        :noClockOut="$totalNoClockOut"
        :totalAbsences="$absences"
        leaveBalance="15"
    />
    <section class="main-content">

    </section>

</x-app>
