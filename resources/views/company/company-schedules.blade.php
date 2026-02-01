@vite('resources/css/company/company-schedule.css')

@php
    $daysOfWeek = [
           'Mon' => 'Mon',
           'Tue' => 'Tue',
           'Wed' => 'Wed',
           'Thu' => 'Thu',
           'Fri' => 'Fri',
           'Sat' => 'Sat',
           'Sun' => 'Sun'];
@endphp
{{--    script for the checkboxes
   added here and in the root layout so that responses have no delay
--}}
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const checkboxes = document.querySelectorAll('.custom-checkbox');
            const employeeCards = document.querySelectorAll('.card-wrapper');
            const selectedEmployeeId = document.getElementById('selected_employee_id');
            const selectedEmployeeInfo = document.getElementById('selected-employee-info');
            const employeeNameDisplay = document.getElementById('employee-name');
            const employeeTypeDisplay = document.getElementById('employee-type');
            const startTimeInput = document.getElementById('start_time');
            const endTimeInput = document.getElementById('end_time');
            const scheduleForm = document.getElementById('scheduleForm');

            checkboxes.forEach(label => {
                label.addEventListener('click', e => {
                    const input = label.querySelector('input[type="checkbox"]');
                    if (!input) return;

                    input.checked = !input.checked;
                    label.classList.toggle('active', input.checked);
                    e.preventDefault();
                });
            });

            // Handle employee card click
            employeeCards.forEach(card => {
                card.addEventListener('click', function() {
                    // Remove active class from all cards
                    employeeCards.forEach(c => c.classList.remove('active'));

                    // Add active class to clicked card
                    this.classList.add('active');

                    // Get employee data
                    const employeeId = this.dataset.id;
                    const employeeName = this.dataset.name;
                    const employeeType = this.dataset.type;
                    const startTime = this.dataset.start || '';
                    const endTime = this.dataset.end || '';
                    const workingDays = JSON.parse(this.dataset.days || '[]');
                    const availableDays = JSON.parse(this.dataset.availableDays || '[]');

                    // Set hidden input
                    selectedEmployeeId.value = employeeId;

                    // Display selected employee info
                    selectedEmployeeInfo.style.display = 'block';
                    employeeNameDisplay.textContent = employeeName;

                    // Format employment type display
                    let typeLabel = '';
                    if (employeeType === 'part-time') {
                        if (availableDays.length > 0) {
                            const dayNames = availableDays.join(', ');
                            typeLabel = `Part-Time Employee (Hired Days: ${dayNames})`;
                        } else {
                            typeLabel = 'Part-Time Employee (Fixed Days)';
                        }
                    } else if (employeeType === 'contractual') {
                        typeLabel = 'Contractual Employee';
                    } else if (employeeType === 'full-time') {
                        typeLabel = 'Full-Time Employee';
                    } else {
                        typeLabel = employeeType;
                    }
                    employeeTypeDisplay.textContent = typeLabel;

                    // Populate schedule form with employee's current schedule
                    startTimeInput.value = startTime;
                    endTimeInput.value = endTime;

                    // For part-time employees, show only hired days (READ-ONLY)
                    if (employeeType === 'part-time') {
                        // Map full day names to short names
                        const dayMap = {
                            'Monday': 'Mon',
                            'Tuesday': 'Tue',
                            'Wednesday': 'Wed',
                            'Thursday': 'Thu',
                            'Friday': 'Fri',
                            'Saturday': 'Sat',
                            'Sunday': 'Sun'
                        };

                        // Convert available days to short format (these are the HIRED days for this company)
                        const hiredDaysShort = Array.isArray(availableDays)
                            ? availableDays.map(day => dayMap[day] || day)
                            : [];

                        // For part-time: Show only hired days (checked and read-only), disable all others
                        checkboxes.forEach(label => {
                            const input = label.querySelector('input[type="checkbox"]');
                            if (input) {
                                const isHiredDay = hiredDaysShort.includes(input.value);

                                if (isHiredDay) {
                                    // This day is hired by this company - check and make read-only
                                    input.checked = true;
                                    label.classList.add('active');
                                    label.style.opacity = '1';
                                    label.style.cursor = 'not-allowed';
                                    label.style.pointerEvents = 'none';
                                    input.disabled = true;
                                } else {
                                    // Not hired by this company - uncheck and disable
                                    input.checked = false;
                                    label.classList.remove('active');
                                    label.style.opacity = '0.3';
                                    label.style.cursor = 'not-allowed';
                                    label.style.pointerEvents = 'none';
                                    input.disabled = true;
                                }
                            }
                        });
                    } else {
                        // For full-time and contractual, enable all checkboxes and check working days
                        checkboxes.forEach(label => {
                            const input = label.querySelector('input[type="checkbox"]');
                            if (input) {
                                label.style.opacity = '1';
                                label.style.cursor = 'pointer';
                                label.style.pointerEvents = 'auto';

                                if (workingDays.includes(input.value)) {
                                    input.checked = true;
                                    label.classList.add('active');
                                } else {
                                    input.checked = false;
                                    label.classList.remove('active');
                                }
                            }
                        });
                    }
                });
            });

            // Form validation and submission handling
            scheduleForm.addEventListener('submit', function(e) {
                if (!selectedEmployeeId.value) {
                    e.preventDefault();
                    alert('Please select an employee first!');
                    return;
                }

                // For part-time employees, ensure only checked (hired) days are submitted
                const selectedCard = document.querySelector('.card-wrapper.active');
                if (selectedCard && selectedCard.dataset.type === 'part-time') {
                    // Remove disabled attribute from checked inputs so they submit
                    checkboxes.forEach(label => {
                        const input = label.querySelector('input[type="checkbox"]');
                        if (input && input.checked) {
                            input.disabled = false;
                        }
                    });
                }
            });
        });
    </script>
@endpush

<x-app :noHeader="true" :navigation="true" :company="$company">

    <section class="main-content">
        <div class="content-wrapper">
            <div class="schedule-wrapper">
                <form action="{{ route('company.create.schedule', ['id' => $company->company_id]) }}" method="post" id="scheduleForm">
                    @csrf
                    <input type="hidden" name="employee_id" id="selected_employee_id" required>

                    <h6>Schedules</h6>

                    <div id="selected-employee-info" style="background: #f3f4f6; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; display: none;">
                        <p style="margin: 0; font-weight: 600; color: #374151;">Selected Employee:</p>
                        <p id="employee-name" style="margin: 0.25rem 0; color: #059669;"></p>
                        <p id="employee-type" style="margin: 0; font-size: 0.875rem; color: #6b7280;"></p>
                    </div>

                    <div class="checkbox-group">
                        @foreach($daysOfWeek as $days => $daysLabel)
                            <x-form-checkbox
                                :label="$daysLabel"
                                name="working_days"
                                :id="$days"
                                :value="$days"
                            />
                        @endforeach
                    </div>

                    <p>Set working hours</p>
                    <div class="field-row">
                        <x-form-input
                            type="time"
                            id="start_time"
                            name="start_time"
                            label="Start Time"
                        />
                        <x-form-input
                            type="time"
                            id="end_time"
                            name="end_time"
                            label="End Time"
                        />
                    </div>

                    <div class="button-wrapper">
                        <x-button-submit>Save Schedule</x-button-submit>
                    </div>

            </form>
            </div>
                <div class="employee-card-wrapper">
                    @foreach($company->employees as $employee)
                        @php
                            $schedule = $employee->employeeSchedule->first();
                            $employmentType = ucfirst($employee->employment_type ?? 'N/A');
                            $workingDays = $schedule ? $schedule->working_days : [];
                            $startTime = $schedule && $schedule->start_time ? substr($schedule->start_time, 0, 5) : '';
                            $endTime = $schedule && $schedule->end_time ? substr($schedule->end_time, 0, 5) : '';

                            // For part-time employees hired this week, use company-specific assigned days
                            // Otherwise use their full days_available
                            if ($employee->employment_type === 'part-time' && isset($employee->days_available_for_company)) {
                                $daysAvailable = $employee->days_available_for_company;
                                // Create label showing hired days
                                $employmentType = 'Part-Time (Hired: ' . implode(', ', $daysAvailable) . ')';
                            } else {
                                $daysAvailable = $employee->days_available ?? [];
                            }
                        @endphp
                        <div class="card-content-wrapper">
                            <x-schedule-cards
                                :image="$employee->profile_photo
                                ? 'storage/' . $employee->profile_photo
                                : 'assets/default_profile.jpg'"
                                :name="$employee->first_name . ' ' . $employee->last_name"
                                :id="$employee->employee_id"
                                :start="$startTime"
                                :end="$endTime"
                                :scheduleDays="json_encode($workingDays)"
                                :description="$schedule ? 'Current shift' : 'No schedule assigned'"
                                :labels="$employmentType"
                                :data-type="$employee->employment_type"
                                :data-name="$employee->first_name . ' ' . $employee->last_name"
                                :data-days="json_encode($workingDays)"
                                :data-available-days="json_encode($daysAvailable)"
                            />
                        </div>
                    @endforeach
                </div>
        </div>
    </section>
</x-app>


{{--todo:fetch the latest schedule of the employee--}}
