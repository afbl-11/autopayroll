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
        <select id="filterPosition" class="nav-items-2">
            <option value="">All Roles</option>
            @foreach($employees->pluck('job_position')
                ->filter()
                ->map(fn($pos) => strtolower($pos))
                ->unique()
                ->sort()
                as $position)
                <option value="{{ $position }}">{{ ucfirst($position) }}</option>
            @endforeach
        </select>

    </div>
            
    <section class="main-content">
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
                    $attendance = $employee->attendanceLogs->first(); 
                @endphp

                <div
                    class="employee-item"
                    data-name="{{ strtolower(($employee->first_name ?? '') . ' ' . ($employee->last_name ?? '')) }}"
                    data-email="{{ strtolower($employee->email ?? '') }}"
                    data-id="{{ strtolower($employee->employee_id ?? '') }}"
                    data-position="{{ strtolower($employee->job_position ?? '') }}"
                    data-status="{{ strtolower($attendance?->status ?? '') }}"
                >
                    <x-employee-cards
                        :name="($employee->first_name ?? '') . ' ' . ($employee->last_name ?? '')"
                        :id="$employee->employee_id ?? ''"
                        :username="$employee->username ?? ''"
                        :image="'assets/default_profile.png'"
                        :date="$employee->contract_start ?? ''"
                        :phone="$employee->phone_number ?? ''"
                        :type="$employee->employment_type ?? ''"
                        :position="ucwords($employee->job_position ?? '')"
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
        const searchInput    = document.getElementById("employeeSearch");
        const filterPosition = document.getElementById("filterPosition");
        const employeeItems  = document.querySelectorAll(".employee-item");

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
                    matchesSearch && matchesPosition
                        ? "block"
                        : "none";
            });
        }

        searchInput.addEventListener("keyup", applyFilters);
        filterPosition.addEventListener("change", applyFilters);

        window.addEventListener("pageshow", function (event) {
            if (
                event.persisted ||
                performance.getEntriesByType("navigation")[0].type === "back_forward"
            ) {
                searchInput.value = "";
                filterPosition.value = "";
                employeeItems.forEach(item => item.style.display = "block");
            }
        });
    </script>
    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function showCustomAlert(message) {
                const alert = document.createElement("div");
                alert.className = "custom-alert";
                alert.textContent = message;
                document.body.appendChild(alert);
                setTimeout(() => alert.remove(), 3500);
            }
            showCustomAlert(@json(session('success')));
        });
    </script>
    @endif
</x-app>
<style>
    .custom-alert {
        position: fixed;
        top: 20px;
        right: 20px;
        background: #FFD858;
        color: black;
        padding: 14px 20px;
        border-radius: 8px;
        font-size: 14px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        z-index: 9999;
        animation: slideIn 0.4s ease, fadeOut 0.4s ease 3s forwards;
    }

    @keyframes slideIn {
        from { transform: translateX(30px); opacity: 0; }
        to   { transform: translateX(0); opacity: 1; }
    }

    @keyframes fadeOut {
        to { opacity: 0; transform: translateX(30px); }
    }
</style>