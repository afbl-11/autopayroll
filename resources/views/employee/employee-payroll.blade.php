@vite(['resources/css/company/payroll.css'])

<x-app :navigation="true" navigationType="employee" :employee="$employee" :noHeader="true">
    <section class="main-content">
        <nav>
            <x-button-link :source="['employee.dashboard.payroll', ['id' => $employee->employee_id  ,'type' => 'daily']]" :noDefault="true">Daily Log</x-button-link>
            <x-button-link :source="['employee.dashboard.payroll', ['id' => $employee->employee_id, 'type' => 'semi']]" :noDefault="true">Semi Monthly</x-button-link>
        </nav>
            <table class="custom-table">
                <x-payroll-table
                    :payroll="$payroll"
                    :type="$type"
                />
            </table>


    </section>
</x-app>
