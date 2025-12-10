@vite(['resources/css/employee_dashboard/employeeDashboard.css'])
<x-app :title="$title">

    <nav>
        <div class="btn-link">
            <x-button-link source="employee.register.1" :noDefault="true">
                Add Employee
            </x-button-link>
        </div>
    </nav>
   
    <div class="nav-group">

        <input
            type="text"
            id="employeeSearch"
            placeholder="Search Employee..."
            class="nav-items"
        >

    </div>

    <section class="main-content">
        <div id="employee-cards-container">
            <div class="employee-header">
            <div class="eh-col eh-employee">Employee</div>
            <div class="eh-col eh-username">Username</div>
            <div class="eh-col eh-position">Position</div>
            <div class="eh-col eh-type">Type</div>
            <div class="eh-col eh-status">Status</div>
            </div>

            @foreach($employees as $employee)
                @php
                    $attendance = $employee->attendanceLogs->first();
                @endphp

                <div
                    class="employee-item"
                    data-name="{{ strtolower(($employee->first_name ?? '') . ' ' . ($employee->last_name ?? '')) }}"
                    data-email="{{ strtolower($employee->email ?? '') }}"
                    data-id="{{ strtolower($employee->employee_id ?? '') }}"
                >
                    <x-employee-cards
                        :name="($employee->first_name ?? '') . ' ' . ($employee->last_name ?? '')"
                        :id="$employee->employee_id ?? ''"
                        :username="$employee->username ?? ''"
                        :image="'assets/default_profile.png'"
                        :date="$employee->contract_start ?? ''"
                        :phone="$employee->phone_number ?? ''"
                        :type="$employee->employment_type ?? ''"
                        :position="$employee->job_position ?? ''"
                        :email="$employee->email ?? ''"
                        :status="$attendance?->status"
                    ></x-employee-cards>
                </div>
            @endforeach

        </div>

        @if($employees->isEmpty())
            <p class="no-results">No employees found.</p>
        @endif
    </section>

    <script>
        const searchInput = document.getElementById("employeeSearch");
        const employeeItems = document.querySelectorAll(".employee-item");

        searchInput.addEventListener("keyup", function () {
            const searchValue = this.value.toLowerCase();

            employeeItems.forEach(item => {
                const name  = item.dataset.name || "";
                const email = item.dataset.email || "";
                const id    = item.dataset.id || "";

                const matches =
                    name.includes(searchValue) ||
                    email.includes(searchValue) ||
                    id.includes(searchValue);

                item.style.display = matches ? "block" : "none";
            });
        });

        window.addEventListener("pageshow", function (event) {
            if (
                event.persisted ||
                performance.getEntriesByType("navigation")[0].type === "back_forward"
            ) {
                searchInput.value = "";
                employeeItems.forEach(item => item.style.display = "block");
            }
        });
    </script>
</x-app>