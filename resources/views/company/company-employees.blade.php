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
            @foreach($company->employees as $employee)
                @php
                    $attendance = $employee->attendanceLogs->first();
                    $employeeName = $employee->first_name . ' ' . $employee->last_name;
                    // Add (PT) label for part-time employees
                    if ($employee->employment_type === 'part-time') {
                        $employeeName .= ' (PT)';
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
                    :status="$attendance?->status"
                ></x-employee-cards>

            </div>
            @endforeach
            
            {{-- Part-time hired employees for this week --}}
            @foreach($company->part_time_hired as $employee)
                @php
                    $attendance = $employee->attendanceLogs->first();
                    $daysString = implode(', ', $employee->assigned_days_for_company ?? []);
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
                    :name="$employee->first_name . ' ' . $employee->last_name . ' (PT: ' . $daysString . ')'"
                    :id="$employee->employee_id"
                    :username="$employee->username"
                    :image="'assets/default_profile.png'"
                    :date="$employee->contract_start"
                    :phone="$employee->phone_number"
                    :type="'part-time'"
                    :position="$employee->job_position"
                    :email="$employee->email"
                    :status="$attendance?->status"
                ></x-employee-cards>

            </div>
            @endforeach
        </div>
        @if($company->employees->isEmpty() && $company->part_time_hired->isEmpty())
            <p class="no-results">No employees found.</p>
        @endif

        <!-- Available Part-Time Employees Section -->
        @if($availablePartTimeEmployees->isNotEmpty())
        <div class="available-part-time-section">
            <h3>Available Part-Time Employees</h3>
            
            <div id="part-time-cards-container">
                <div class="part-time-employee-header" style="display: grid; grid-template-columns: 1.4fr 1fr 1fr 1fr 0.7fr; padding: 10px 18px; background: #f3f6ff; border-radius: 10px; border: 1px solid #d9dff7; margin-bottom: 10px; width: 100%; margin-left: 0;">
                    <div class="eh-col eh-employee">Employee</div>
                    <div class="eh-col eh-username">Username</div>
                    <div class="eh-col eh-position">Role</div>
                    <div class="eh-col eh-type">Available Days</div>
                    <div class="eh-col eh-status">Action</div>
                </div>
                
                @foreach($availablePartTimeEmployees as $employee)
                    @php
                        $remainingDays = $employee->remaining_days ?? [];
                        $daysString = count($remainingDays) > 0 ? implode(', ', $remainingDays) : 'No days available';
                    @endphp
                    
                    <div class="part-time-row" data-employee-id="{{ $employee->employee_id }}">
                        <div class="pt-col pt-employee">
                            <img src="{{ asset('assets/default_profile.png') }}" alt="{{ $employee->first_name }}" class="pt-profile-pic">
                            <div class="pt-employee-info">
                                <p class="pt-name">{{ $employee->first_name }} {{ $employee->last_name }}</p>
                                <p class="pt-id">#{{ $employee->employee_id }}</p>
                            </div>
                        </div>
                        <div class="pt-col pt-username">{{ $employee->username }}</div>
                        <div class="pt-col pt-position">{{ $employee->job_position }}</div>
                        <div class="pt-col pt-days">
                            <span class="days-badge">{{ $daysString }}</span>
                        </div>
                        <div class="pt-col pt-action">
                            <button class="hire-part-time-btn" 
                                data-employee-id="{{ $employee->employee_id }}"
                                data-employee-name="{{ $employee->first_name }} {{ $employee->last_name }}"
                                data-available-days='@json($remainingDays)'>
                                Hire
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </section>

    <!-- Part-Time Hiring Modal -->
    <div id="partTimeModal">
        <div class="modal-content">
            <h3>Hire Part-Time Employee</h3>
            <p>Employee: <strong id="modalEmployeeName"></strong></p>
            <p>Select the day(s) to hire this employee:</p>
            
            <div id="daySelectionContainer">
                <!-- Days will be inserted here dynamically -->
            </div>
            
            <div class="modal-actions">
                <button id="cancelHireBtn">
                    Cancel
                </button>
                <button id="confirmHireBtn">
                    Confirm Hire
                </button>
            </div>
        </div>
    </div>

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

        // Part-Time Hiring Modal Logic
        const modal = document.getElementById('partTimeModal');
        const modalEmployeeName = document.getElementById('modalEmployeeName');
        const daySelectionContainer = document.getElementById('daySelectionContainer');
        const cancelHireBtn = document.getElementById('cancelHireBtn');
        const confirmHireBtn = document.getElementById('confirmHireBtn');
        let selectedEmployeeId = null;
        let selectedDays = [];
        let availableDays = [];

        // Open modal when "Hire" button is clicked
        document.querySelectorAll('.hire-part-time-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                selectedEmployeeId = this.dataset.employeeId;
                const employeeName = this.dataset.employeeName;
                availableDays = JSON.parse(this.dataset.availableDays || '[]');
                
                modalEmployeeName.textContent = employeeName;
                selectedDays = [];
                
                // Build day selection checkboxes
                daySelectionContainer.innerHTML = '';
                availableDays.forEach(day => {
                    const dayOption = document.createElement('div');
                    dayOption.className = 'day-option';
                    dayOption.innerHTML = `
                        <input type="checkbox" id="day-${day}" value="${day}">
                        <label for="day-${day}">${day}</label>
                    `;
                    
                    const checkbox = dayOption.querySelector('input');
                    checkbox.addEventListener('change', function() {
                        if (this.checked) {
                            selectedDays.push(this.value);
                            dayOption.classList.add('selected');
                        } else {
                            selectedDays = selectedDays.filter(d => d !== this.value);
                            dayOption.classList.remove('selected');
                        }
                    });
                    
                    daySelectionContainer.appendChild(dayOption);
                });
                
                modal.style.display = 'flex';
            });
        });

        // Close modal
        cancelHireBtn.addEventListener('click', () => {
            modal.style.display = 'none';
            selectedDays = [];
        });

        // Confirm hire
        confirmHireBtn.addEventListener('click', async () => {
            if (selectedDays.length === 0) {
                alert('Please select at least one day.');
                return;
            }

            try {
                const response = await fetch('{{ route("company.hire.parttime", ["id" => $company->company_id]) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        employee_id: selectedEmployeeId,
                        selected_days: selectedDays
                    })
                });

                const data = await response.json();
                
                if (data.success) {
                    alert(data.message);
                    window.location.reload();
                } else {
                    alert(data.message || 'Failed to hire employee.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            }
        });
    </script>
</x-app>
