@vite('resources/css/company/company-employee.css')

<x-app :noHeader="true" :navigation="true" :company="$company">
    <section  class="main-content">
        <form action="{{route('company.employee.assign.save', $company->company_id)}}" method="post">
            @csrf
            <nav>
                <x-button-submit id="button">Save Selection</x-button-submit>
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
                <div class="employee-header">
                <div class="eh-col eh-employee">Employee</div>
                <div class="eh-col eh-username">Username</div>
                <div class="eh-col eh-position">Position</div>
                <div class="eh-col eh-type">Type</div>
                <div class="eh-col eh-status">Status</div>
                </div>
                @foreach($employees as $employee)
                    <div
                    class="employee-item"
                    data-name="{{ strtolower(($employee->first_name ?? '') . ' ' . ($employee->last_name ?? '')) }}"
                    data-email="{{ strtolower($employee->email ?? '') }}"
                    data-id="{{ strtolower($employee->employee_id ?? '') }}"
                    >  
                    <label class="employee-card-wrapper">
                        <input
                            type="checkbox"
                            name="employees[]"
                            value="{{ $employee->employee_id }}"
                            class="hidden peer"
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
                            :clickable="false"
                        />
                    </label>
                </div>
                @endforeach
            </div>
        </form>
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
{{--todo: make a counter to how many employees have been selected--}}
