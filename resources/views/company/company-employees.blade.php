@vite('resources/css/company/company-employee.css')

<x-app :noHeader="true" :navigation="true" :company="$company">
    <section class="main-content">
        <nav>
            <x-button-link :source="['company.employee.unassign', ['id' =>  $company->company_id]]" :noDefault="true">Unassign Employee</x-button-link>
            <x-button-link :source="['company.employee.assign', ['id' => $company->company_id]]" :noDefault="true">Assign Employee</x-button-link>
        </nav>

         <div class="nav-group-1">

        <input
            type="text"
            id="employeeSearch"
            placeholder="Search Employee..."
            class="nav-items"
        >

        </div>

        <div id="employee-cards-container">
            @foreach($company->employees as $employee)
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
                    :name="$employee->first_name . ' ' . $employee->last_name"
                    :id="$employee->employee_id"
                    :username="$employee->username"
                    :image="'assets/default_profile.png'"
                    :date="$employee->contract_start"
                    :phone="$employee->phone_number"
                    :type="$employee->employment_type"
                    :position="$employee->job_position"
                    :email="$employee->email"
                    :status="$attendance?->status"
                ></x-employee-cards>

            </div>
            @endforeach
        </div>
        @if($company->employees->isEmpty())
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
