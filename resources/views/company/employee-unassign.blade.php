@vite('resources/css/company/company-employee.css')

<x-app :noHeader="true" :navigation="true" :company="$company">
    <section class="main-content">
        <form id="unassignForm" action="{{ route('company.employee.unassign.save', $company->company_id) }}" method="post">
            @csrf
            <nav>
                <x-button-submit id="button">Save Selection</x-button-submit>
                <span id="selectedCount" style="margin-left:15px; font-size:14px;">Selected: 0</span>
            </nav>

            <div class="nav-group-1">
                <input
                    type="text"
                    id="employeeSearch"
                    placeholder="Search Employee..."
                    class="nav-items"
                >
                <select id="filterPosition" class="nav-items-2">
                    <option value="">All Roles</option>
                    @foreach($company->employees->pluck('job_position')
                        ->filter()
                        ->map(fn($pos) => strtolower($pos))
                        ->unique()
                        ->sort()
                        as $position)
                        <option value="{{ $position }}">{{ ucfirst($position) }}</option>
                    @endforeach
                </select>
            </div>

            <div id="employee-cards-container">
                <div class="employee-header">
                    <div class="eh-col eh-employee">Employee</div>
                    <div class="eh-col eh-username">Username</div>
                    <div class="eh-col eh-position">Role</div>
                    <div class="eh-col eh-type">Type</div>
                    <div class="eh-col eh-status">Status</div>
                </div>

                @foreach($employees as $employee)
                @php
                    $employeeName = $employee->first_name . ' ' . $employee->last_name;
                    // Add (PT) label and hired days for part-time employees
                    if ($employee->employment_type === 'part-time' && isset($employee->hired_days)) {
                        $daysString = implode(', ', $employee->hired_days);
                        $employeeName .= ' (PT: ' . $daysString . ')';
                    }
                @endphp
                <div
                    class="employee-item"
                    data-name="{{ strtolower(($employee->first_name ?? '') . ' ' . ($employee->last_name ?? '')) }}"
                    data-email="{{ strtolower($employee->email ?? '') }}"
                    data-id="{{ strtolower($employee->employee_id ?? '') }}"
                    data-position="{{ strtolower($employee->job_position ?? '') }}"
                    data-status="{{ strtolower($attendance?->status ?? '') }}"
                >
                    <label class="employee-card-wrapper">
                        <input
                            type="checkbox"
                            name="employees[]"
                            value="{{ $employee->employee_id }}"
                            class="hidden peer employee-checkbox"
                        >
                        <x-employee-cards
                            :name="$employeeName"
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
                        <div class="selection-indicator">✓</div>
                    </label>
                </div>
                @endforeach
            </div>
        </form>
    </section>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput    = document.getElementById("employeeSearch");
        const filterPosition = document.getElementById("filterPosition");
        const employeeItems  = document.querySelectorAll(".employee-item");
        const checkboxes     = document.querySelectorAll(".employee-checkbox");
        const selectedCount  = document.getElementById("selectedCount");
        const form           = document.getElementById("unassignForm");

        function applyFilters() {
            const searchValue   = searchInput.value.toLowerCase();
            const positionValue = filterPosition.value.toLowerCase();

            employeeItems.forEach(item => {
                const name     = item.dataset.name;
                const email    = item.dataset.email;
                const id       = item.dataset.id;
                const position = item.dataset.position;

                const matchesSearch =
                    name.includes(searchValue) ||
                    email.includes(searchValue) ||
                    id.includes(searchValue);

                const matchesPosition =
                    positionValue === "" || position === positionValue;

                item.style.display =
                    matchesSearch && matchesPosition ? "block" : "none";
            });
        }

        searchInput.addEventListener("keyup", applyFilters);
        filterPosition.addEventListener("change", applyFilters);

        function updateSelectedCount() {
            const checked = document.querySelectorAll(".employee-checkbox:checked").length;
            selectedCount.textContent = `Selected: ${checked}`;
        }

        checkboxes.forEach(cb => cb.addEventListener("change", updateSelectedCount));

        function showCustomAlert(message) {
            const alert = document.createElement("div");
            alert.className = "custom-alert";
            alert.textContent = message;
            document.body.appendChild(alert);
            setTimeout(() => alert.remove(), 3500);
        }

        form.addEventListener("submit", function(e) {
            const checkedEmployees = document.querySelectorAll(".employee-checkbox:checked");

            if (checkedEmployees.length === 0) {
                e.preventDefault();
                showCustomAlert("Please select at least one employee to unassign.");
            } else {
                const message = checkedEmployees.length === 1
                    ? `${checkedEmployees.length} employee is unassigned.`
                    : `${checkedEmployees.length} employees are unassigned.`;
                showCustomAlert(message);
            }
        });

        window.addEventListener("pageshow", function(event) {
            if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
                searchInput.value = "";
                filterPosition.value = "";
                employeeItems.forEach(item => item.style.display = "block");
                updateSelectedCount();
            }
        });

        updateSelectedCount();
    });
    </script>
</x-app>