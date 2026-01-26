@vite(['resources/css/company/manual-attendance.css'])

<x-app title="Manual Attendance">
<div class="main-content">

<h2 class="page-title"></h2>

{{-- LEGEND --}}
<div class="attendance-legend">
    <strong>Legend:</strong>
    <span><b>P</b> – Present (8 hours)</span>
    <span><b>O</b> – Overtime</span>
    <span><b>LT</b> – Late / Undertime</span>
    <span><b>A</b> – Absent</span>
    <span><b>DO</b> – Day Off</span>
    <span><b>RH</b> – Regular Holiday</span>
    <span><b>SH</b> – Special Holiday</span>
    <span><b>CD</b> – Change Day Off</span>
    <span><b>CDO</b> – Cancel Day Off</span>
</div>

{{-- CONTROLS --}}
<div class="attendance-controls">
    <select id="companySelect">
        <option value="">Select Company</option>
        <option value="part-time">Part Time Employee</option>
        @foreach($companies as $company)
            <option value="{{ $company->company_id }}">
                {{ $company->company_name }}
            </option>
        @endforeach
    </select>

    <select id="attendanceDate" disabled>
        <option value="">Select Date</option>
    </select>

    <button id="createDateBtn" disabled>Create Date</button>
    <button id="editBtn" disabled>Edit</button>
    <button id="deleteDateBtn" disabled>Delete Date</button>
    <button id="saveAllBtn" disabled>Save All</button>
    
    <button id="dayOffBtn" class="day-off-btn" disabled>Day Off</button>
    <button id="manualInputBtn" class="manual-input-btn" style="display: none;">Manual Input</button>

    <span id="modeLabel" class="mode-label"></span>
</div>

{{-- TABLE --}}
<div class="table-wrapper">
<table id="attendanceGrid">
<thead>
<tr>
    <th>Emp ID</th>
    <th>Name</th>
    <th>Status</th>
    <th>Time In</th>
    <th>Time Out</th>
</tr>
</thead>
<tbody>
<tr>
    <td colspan="5" class="empty-state">Select a company</td>
</tr>
</tbody>
</table>
</div>

{{-- MANUAL ATTENDANCE FORM MODAL --}}
<div id="attendanceFormModal" class="modal" style="display: none;">
    <div class="modal-content modal-large">
        <h3>Manual Attendance Entry</h3>
        <p id="selectedCompanyName" class="company-info"></p>
        
        <form id="manualAttendanceForm">
            @csrf
            <input type="hidden" id="form_company_id" name="company_id">
            
            <div class="form-group">
                <label for="employee_select">Select Employee *</label>
                <select id="employee_select" name="employee_id" required>
                    <option value="">-- Select Employee --</option>
                </select>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="datetime_in">Date & Time In *</label>
                    <input type="datetime-local" id="datetime_in" name="datetime_in" required>
                </div>
                
                <div class="form-group">
                    <label for="datetime_out">Date & Time Out</label>
                    <input type="datetime-local" id="datetime_out" name="datetime_out">
                </div>
            </div>
            
            <div class="form-group">
                <label>Status</label>
                <p id="attendance_status" class="status-display">Status will be calculated based on schedule</p>
            </div>
            
            <div class="modal-actions">
                <button type="submit" id="submitAttendanceBtn" class="btn-primary">Submit Attendance</button>
                <button type="button" id="closeFormBtn" class="btn-secondary">Close</button>
            </div>
        </form>
    </div>
</div>

{{-- DAY OFF SETUP MODAL --}}
<div id="dayOffModal" class="modal" style="display: none;">
    <div class="modal-content modal-large">
        <h3>Day Off Setup</h3>
        <p class="company-info">Set day off status for employees on selected date</p>
        
        <form id="dayOffForm">
            @csrf
            <input type="hidden" id="dayoff_company_id" name="company_id">
            <input type="hidden" id="dayoff_date" name="date">
            
            <div class="dayoff-list">
                <table class="dayoff-table">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Current Status</th>
                            <th>Set Day Off</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="dayOffEmployeeList">
                        <!-- Will be populated dynamically -->
                    </tbody>
                </table>
            </div>
            
            <div class="modal-actions">
                <button type="submit" id="saveDayOffBtn" class="btn-primary">Save Day Off</button>
                <button type="button" id="closeDayOffBtn" class="btn-secondary">Close</button>
            </div>
        </form>
    </div>
</div>

{{-- CREATE DATE MODAL --}}
<div id="createDateModal" class="modal" style="display: none;">
    <div class="modal-content">
        <h3>Create New Date</h3>
        <p class="company-info">Enter date (YYYY-MM-DD)</p>
        
        <form id="createDateForm">
            <div class="form-group">
                <label for="new_date_input">Date *</label>
                <input type="date" id="new_date_input" name="date" required class="date-input">
            </div>
            
            <div class="modal-actions">
                <button type="submit" class="btn-primary">Create Date</button>
                <button type="button" id="closeCreateDateBtn" class="btn-secondary">Cancel</button>
            </div>
        </form>
    </div>
</div>

</div>

<style>
.mode-view .status-btn { opacity:.4; cursor:not-allowed; }
.mode-view .time-in, .mode-view .time-out { background-color:#f3f4f6; cursor:not-allowed; }
.mode-edit .status-btn { background:#f59e0b;color:#fff; cursor:pointer; }
.mode-edit .status-btn:hover { background:#d97706; }
.mode-create .status-btn { background:#22c55e;color:#fff; cursor:pointer; }
.mode-create .status-btn:hover { background:#16a34a; }
.mode-label { font-size:13px;font-weight:600;margin-left:10px; padding: 4px 8px; border-radius: 4px; }
.mode-view .mode-label { background: #FFD858; color: black; } 
.mode-edit .mode-label { background: #f59e0b; color: white; }
.mode-create .mode-label { background: #22c55e; color: white; }
.status-btn.active { outline:2px solid #000; }
.status-btn { padding:2px 6px; margin:0 2px; border-radius:3px; border:1px solid #d1d5db; }
.empty-state { text-align: center; padding: 40px; color: #6b7280; }
.table-wrapper { overflow-x: auto; margin-top: 20px; }
#attendanceGrid { width: 100%; border-collapse: collapse; }
#attendanceGrid th, #attendanceGrid td { padding: 10px; border: 1px solid #e5e7eb; text-align: left; }
#attendanceGrid th { background-color: #f9fafb; font-weight: 600; }
.attendance-controls { display: flex; gap: 10px; align-items: center; margin: 20px 0; flex-wrap: wrap; }
.attendance-controls select, .attendance-controls button { padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 4px; }
.attendance-controls button { cursor: pointer; }
.attendance-controls button:disabled { opacity: 0.5; cursor: not-allowed; }
.attendance-legend { background: #f3f4f6; padding: 12px; border-radius: 6px; margin-bottom: 20px; display: flex; flex-wrap: wrap; gap: 15px; }
.attendance-legend span { margin-right: 15px; }
.time-in, .time-out { width: 100px; padding: 6px; border: 1px solid #d1d5db; border-radius: 4px; }
.time-in:disabled, .time-out:disabled { background-color: #f3f4f6; }

/* Checkbox */
.checkbox-container {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    user-select: none;
}
.checkbox-container input[type="checkbox"] {
    width: 18px;
    height: 18px;
    cursor: pointer;
}
.checkbox-container input[type="checkbox"]:disabled {
    cursor: not-allowed;
}
.checkbox-container span {
    font-size: 14px;
    font-weight: 500;
}

/* Manual Input Button */
.manual-input-btn {
    background: #FFD858 !important;
    color: black !important;
    font-weight: 600;
    border: none !important;
}
.manual-input-btn:hover {
    background: #f5c945 !important;
}
.day-off-btn {
    background: #10b981 !important;
    color: white !important;
    font-weight: 600;
    border: none !important;
}
.day-off-btn:hover {
    background: #059669 !important;
}
.day-off-btn:disabled {
    background: #6b7280 !important;
    cursor: not-allowed;
    opacity: 0.5;
}

/* Modal Styles */
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.modal-content {
    background: white;
    padding: 30px;
    border-radius: 12px;
    width: 90%;
    max-width: 500px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
}

.date-input {
    width: 100%;
    padding: 12px;
    border: 2px solid #d1d5db;
    border-radius: 8px;
    font-size: 16px;
    margin-top: 8px;
}

.date-input:focus {
    outline: none;
    border-color: #3b82f6;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-weight: 600;
    margin-bottom: 5px;
    color: #374151;
}

.modal-large {
    max-width: 700px;
}

.modal h3 {
    margin: 0 0 15px 0;
    color: #1f2937;
}

.code-input {
    width: 100%;
    padding: 12px;
    border: 2px solid #d1d5db;
    border-radius: 8px;
    font-size: 16px;
    margin: 15px 0;
}

.modal-actions {
    display: flex;
    gap: 10px;
    margin-top: 20px;
    justify-content: flex-end;
}

.btn-primary {
    background: #3b82f6;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
}

.btn-primary:hover {
    background: #2563eb;
}

.btn-secondary {
    background: #6b7280;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

.btn-secondary:hover {
    background: #4b5563;
}

.error-message {
    color: #dc2626;
    margin-top: 10px;
    font-size: 14px;
}

.company-info {
    background: #f3f4f6;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 20px;
    font-weight: 600;
    color: #374151;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #374151;
}

.form-group input, .form-group select {
    width: 100%;
    padding: 10px;
    border: 2px solid #d1d5db;
    border-radius: 6px;
    font-size: 14px;
}

.form-group input:disabled {
    background: #f3f4f6;
    cursor: not-allowed;
}

.form-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
}

.camera-container {
    border: 2px solid #d1d5db;
    border-radius: 8px;
    overflow: hidden;
    background: #000;
    max-width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}

#camera, #capturedImage {
    width: 100%;
    max-width: 400px;
    height: auto;
    display: block;
}

.camera-actions {
    display: flex;
    gap: 10px;
    margin-top: 10px;
}

.status-display {
    background: #fef3c7;
    padding: 10px;
    border-radius: 6px;
    color: #92400e;
    font-weight: 600;
}

.status-present {
    background: #d1fae5 !important;
    color: #065f46 !important;
}

.status-late {
    background: #fee2e2 !important;
    color: #991b1b !important;
}

/* Day Off Modal Styles */
.dayoff-table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
}
.dayoff-table th,
.dayoff-table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #e5e7eb;
}
.dayoff-table th {
    background: #f3f4f6;
    font-weight: 600;
}
.dayoff-table select {
    padding: 6px 10px;
    border: 1px solid #d1d5db;
    border-radius: 4px;
    min-width: 150px;
}
.dayoff-table .btn-cancel {
    background: #ef4444;
    color: white;
    border: none;
    padding: 6px 12px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 13px;
}
.dayoff-table .btn-cancel:hover {
    background: #dc2626;
}
.dayoff-table .btn-cancel:disabled {
    background: #9ca3af;
    cursor: not-allowed;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", () => {

/* ==========================
   ELEMENTS
========================== */
const companySelect = document.getElementById("companySelect");
const dateSelect = document.getElementById("attendanceDate");
const createDateBtn = document.getElementById("createDateBtn");
const editBtn = document.getElementById("editBtn");
const deleteBtn = document.getElementById("deleteDateBtn");
const saveBtn = document.getElementById("saveAllBtn");
const leaveBtn = document.getElementById("leaveBtn");
const tableBody = document.querySelector("#attendanceGrid tbody");
const modeLabel = document.getElementById("modeLabel");

let employees = []; // Permanent employees
let partTimeEmployees = []; // Part-time employees
let allPartTimeEmployees = []; // Store all part-time employees before filtering
let currentCompanyId = null; // Currently selected company
let selectedPartTimeEmployee = false; // Flag: true when viewing all part-time employees
let isUpdatingDropdown = false; // Flag to prevent recursive dropdown updates
let attendance = {};
let attendanceByDate = {};
let mode = "view";

// Helper function to get day of week full name
function getDayOfWeek(dateString) {
    const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    const date = new Date(dateString);
    return days[date.getDay()];
}

// Filter part-time employees based on date (for dropdown filtering)
function getAvailablePartTimeEmployees(selectedDate) {
    if (!selectedDate) return partTimeEmployees;
    
    const dayOfWeek = getDayOfWeek(selectedDate);
    
    return partTimeEmployees.filter(emp => {
        if (emp.days_available) {
            const availableDays = typeof emp.days_available === 'string' 
                ? JSON.parse(emp.days_available) 
                : emp.days_available;
            return availableDays.includes(dayOfWeek);
        }
        return true;
    });
}

// Filter if part-time or contractual are in contract.
function isWithinContract(emp, selectedDate) {
    if (!emp.contract_end) return true; // NO END DATE = ACTIVE

    const contractEnd = new Date(emp.contract_end);
    const date = new Date(selectedDate);

    contractEnd.setHours(0, 0, 0, 0);
    date.setHours(0, 0, 0, 0);

    return date <= contractEnd;
}

/* ==========================
   COMPANY CHANGE
========================== */
companySelect.addEventListener("change", async () => {
    // Ignore if we're programmatically updating the dropdown
    if (isUpdatingDropdown) return;
    
    // Reset everything if no selection
    if (!companySelect.value) {
        resetAll();
        return;
    }
    
    // Check if this is a part-time employee selection
    if (companySelect.value === 'part-time') {
        selectedPartTimeEmployee = true; // Flag to indicate part-time mode
        
        try {
            // Fetch ALL part-time employees
            const partTimeRes = await fetch('/all-part-time-employees');
            if (!partTimeRes.ok) {
                throw new Error("Failed to fetch part-time employees");
            }
            const partTimeData = await partTimeRes.json();
            allPartTimeEmployees = partTimeData.data || []; // Store original list
            partTimeEmployees = allPartTimeEmployees; // Start with all employees
            
            console.log('Loaded all part-time employees:', allPartTimeEmployees);
            
            if (allPartTimeEmployees.length === 0) {
                alert('No part-time employees found');
                resetAll();
                return;
            }
            
            // Use the first part-time employee's company_id as the currentCompanyId
            currentCompanyId = allPartTimeEmployees[0]?.company_id;
            
            // Render all part-time employees in the grid
            renderPartTimeEmployeesGrid();
            
            // Enable date controls for part-time employees
            dateSelect.disabled = false;
            createDateBtn.disabled = false;
            
            // Load attendance dates for the first part-time employee's company
            if (currentCompanyId) {
                const dateRes = await fetch(`/company/${currentCompanyId}/attendance-dates`);
                if (dateRes.ok) {
                    const dateData = await dateRes.json();
                    const dates = dateData.data || [];
                    
                    dateSelect.innerHTML = `<option value="">Select Date</option>`;
                    dates.forEach(d => {
                        if (d.date) {
                            dateSelect.innerHTML += `<option value="${d.date}">${d.date}</option>`;
                        }
                    });
                }
            }
            
        } catch (error) {
            console.error("Error loading part-time employees:", error);
            alert("Failed to load part-time employees");
            resetAll();
        }
        
        return;
    }
    
    // It's a company selection
    selectedPartTimeEmployee = false;
    currentCompanyId = companySelect.value;

    try {
        // Load permanent employees
        const empRes = await fetch(`/company/${currentCompanyId}/employees`);
        if (!empRes.ok) {
            const errorText = await empRes.text();
            console.error('Employee fetch error:', errorText);
            throw new Error("Failed to fetch employees");
        }
        
        const empData = await empRes.json();
        employees = empData.data || [];
        
        // Load part-time employees from part_time_assignments
        const partTimeRes = await fetch(`/company/${currentCompanyId}/part-time-employees`);
        if (!partTimeRes.ok) {
            console.warn('Failed to fetch part-time employees, continuing without them');
            partTimeEmployees = [];
        } else {
            const partTimeData = await partTimeRes.json();
            partTimeEmployees = partTimeData.data || [];
        }
        
        console.log('Loaded permanent employees:', employees);
        console.log('Loaded part-time employees:', partTimeEmployees);

        // Clear date selection first
        dateSelect.value = '';
        
        // Reset attendance data
        attendance = {};
        attendanceByDate = {};

        // Populate date select first
        const dateRes = await fetch(`/company/${currentCompanyId}/attendance-dates`);
        if (!dateRes.ok) throw new Error("Failed to fetch dates");
        
        const dateData = await dateRes.json();
        const dates = dateData.data || [];

        dateSelect.innerHTML = `<option value="">Select Date</option>`;
        dates.forEach(d => {
            if (d.date) {
                dateSelect.innerHTML += `<option value="${d.date}">${d.date}</option>`;
            }
        });

        // Enable/disable controls
        dateSelect.disabled = false;
        createDateBtn.disabled = false;
        editBtn.disabled = true;
        deleteBtn.disabled = true;
        saveBtn.disabled = true;
        dayOffBtn.disabled = true;

        // Reset mode
        mode = "view";
        setModeUI();
        
        // Render grid with all employees
        renderGrid();

    } catch (error) {
        console.error("Error loading company data:", error);
        alert("Failed to load company data. Please check the console for details.");
        resetAll();
    }
});

/* ==========================
   DATE CHANGE
========================== */
dateSelect.addEventListener("change", async () => {
    if (!dateSelect.value) {
        resetAttendanceGrid();
        editBtn.disabled = true;
        deleteBtn.disabled = true;
        saveBtn.disabled = true;
        dayOffBtn.disabled = true;
        mode = "view";
        setModeUI();
        return;
    }

    const selectedDate = dateSelect.value;

    try {
        // If part-time mode, filter employees by the selected date's day of week
        if (selectedPartTimeEmployee) {
            const dayOfWeek = getDayOfWeek(selectedDate);
            partTimeEmployees = allPartTimeEmployees.filter(emp => {

                // ❌ CONTRACT ALREADY ENDED
                if (!isWithinContract(emp, selectedDate)) return false;

                // ❌ NOT ASSIGNED ON THIS DAY
                if (emp.days_available) {
                    const availableDays = typeof emp.days_available === 'string'
                        ? JSON.parse(emp.days_available)
                        : emp.days_available;

                    return availableDays.includes(dayOfWeek);
                }

                return false;
            });
            console.log(`Filtered to ${partTimeEmployees.length} employees for ${dayOfWeek} (${selectedDate})`);
        }
        
        // Determine which company ID to use for fetching attendance
        const fetchCompanyId = selectedPartTimeEmployee ? currentCompanyId : companySelect.value;
        
        // Load attendance for selected date if not already cached
        if (!attendanceByDate[selectedDate]) {
            const response = await fetch(`/company/${fetchCompanyId}/attendance/${selectedDate}`);
            if (!response.ok) throw new Error("Failed to fetch attendance");
            
            const data = await response.json();
            attendanceByDate[selectedDate] = data.data || {};
        }

        // Set attendance data
        attendance = structuredClone(attendanceByDate[selectedDate]) || {};

        // Check if selected date is in the past
        const selectedDateObj = new Date(selectedDate);
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        selectedDateObj.setHours(0, 0, 0, 0);
        const isPastDate = selectedDateObj.getTime() < today.getTime();

        // Initialize empty records for employees without attendance
        const currentEmployees = selectedPartTimeEmployee ? partTimeEmployees : employees;
        currentEmployees.forEach(emp => {
            if (!attendance[emp.employee_id]) {
                // Only set default status if there's truly no attendance record
                attendance[emp.employee_id] = {
                    status: isPastDate ? "A" : "P",
                    time_in: "",
                    time_out: ""
                };
            }
            // Don't override existing attendance status - it was already loaded from server
        });

        // Render grid with attendance data
        renderAttendanceGrid();

        // Enable edit/delete/day off buttons
        editBtn.disabled = false;
        deleteBtn.disabled = false;
        dayOffBtn.disabled = false;
        saveBtn.disabled = true;

        mode = "view";
        setModeUI();

    } catch (error) {
        console.error("Error loading attendance:", error);
        alert("Failed to load attendance data");
    }
});

/* ==========================
   CREATE DATE
========================== */
const createDateModal = document.getElementById('createDateModal');
const createDateForm = document.getElementById('createDateForm');
const closeCreateDateBtn = document.getElementById('closeCreateDateBtn');
const newDateInput = document.getElementById('new_date_input');

createDateBtn.addEventListener("click", () => {
    // Set today's date as default
    const today = new Date();
    today.setMinutes(today.getMinutes() - today.getTimezoneOffset());
    newDateInput.value = today.toISOString().split('T')[0];
    
    // Show modal
    createDateModal.style.display = 'flex';
});

closeCreateDateBtn.addEventListener('click', () => {
    createDateModal.style.display = 'none';
});

createDateForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const input = newDateInput.value;
    if (!input) return;

    // Check if date already exists
    if ([...dateSelect.options].some(o => o.value === input)) {
        alert("Date already exists");
        return;
    }

    try {
        // Use appropriate company ID based on mode
        const createCompanyId = selectedPartTimeEmployee ? currentCompanyId : companySelect.value;
        
        const response = await fetch("/attendance/create-date", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                company_id: createCompanyId,
                date: input
            })
        });

        if (!response.ok) throw new Error("Failed to create date");

        // Add to date select
        const option = new Option(input, input);
        dateSelect.add(option);
        dateSelect.value = input;

        // Initialize empty attendance ONLY for employees available on this day
        attendance = {};
        const currentEmployees = selectedPartTimeEmployee ? partTimeEmployees : employees;
        const availableEmployees = getAvailablePartTimeEmployees(input);
        let employeesToInit = selectedPartTimeEmployee
        ? getAvailablePartTimeEmployees(input)
        : currentEmployees;


        // Filter out expired part-time and contractual
        employeesToInit = employeesToInit.filter(emp => {
            if (emp.employment_type === 'part-time' || emp.employment_type === 'contractual') {
                return isWithinContract(emp, input);
            }
            return true; // full-time always allowed
        });

        //Restrict employees that are not assigned on that particular day to be given attendance.
        if (selectedPartTimeEmployee) {
            partTimeEmployees = availableEmployees;
        }
        employeesToInit.forEach(emp => {
            attendance[emp.employee_id] = {
                status: "P",
                time_in: "",
                time_out: ""
            };
        });

        attendanceByDate[input] = structuredClone(attendance);

        // Render with new data (will filter by available employees)
        renderAttendanceGrid();

        // Set mode to create
        mode = "create";
        lockControls(true);
        
        // Enable status buttons in create mode
        document.querySelectorAll(".status-btn").forEach(btn => {
            btn.style.pointerEvents = "auto";
            btn.style.cursor = "pointer";
        });
        
        setModeUI();
        
        // Close modal
        createDateModal.style.display = 'none';

    } catch (error) {
        console.error("Error creating date:", error);
        alert("Failed to create date");
    }
});

/* ==========================
   EDIT
========================== */
editBtn.addEventListener("click", () => {
    mode = "edit";
    lockControls(true);
    setModeUI();
    
    // Enable all status buttons
    document.querySelectorAll(".status-btn").forEach(btn => {
        btn.style.pointerEvents = "auto";
        btn.style.cursor = "pointer";
    });
    
    updateTimeInputsState(); // Enable time inputs for LT/O statuses
});

/* ==========================
   DELETE
========================== */
deleteBtn.addEventListener("click", async () => {
    if (!dateSelect.value) return;
    
    if (!confirm(`Are you sure you want to delete attendance for ${dateSelect.value}?`)) {
        return;
    }

    try {
        // Use appropriate company ID based on mode
        const deleteCompanyId = selectedPartTimeEmployee ? currentCompanyId : companySelect.value;
        
        const response = await fetch("/attendance/delete-date", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                company_id: deleteCompanyId,
                date: dateSelect.value
            })
        });

        if (!response.ok) throw new Error("Failed to delete date");

        // Remove from cache
        delete attendanceByDate[dateSelect.value];
        
        // Remove from select
        const option = dateSelect.querySelector(`option[value="${dateSelect.value}"]`);
        if (option) option.remove();
        
        dateSelect.value = "";

        // Reset grid
        resetAttendanceGrid();

        // Reset controls
        editBtn.disabled = true;
        deleteBtn.disabled = true;
        saveBtn.disabled = true;

        mode = "view";
        setModeUI();

    } catch (error) {
        console.error("Error deleting date:", error);
        alert("Failed to delete date");
    }
});

/* ==========================
   GRID RENDERING
========================== */
function renderGrid() {
    tableBody.innerHTML = "";
    
    // Show permanent employees from company dropdown
    if (employees.length === 0) {
        tableBody.innerHTML = `
            <tr>
                <td colspan="5" class="empty-state">No employees found</td>
            </tr>`;
        return;
    }

    employees.forEach(emp => {
        const row = document.createElement('tr');
        row.dataset.id = emp.employee_id;
        
        const empName = emp.first_name && emp.last_name 
            ? `${emp.first_name} ${emp.last_name}` 
            : (emp.employee_name || 'Unknown');
        
        row.innerHTML = `
            <td>${emp.employee_id}</td>
            <td>${empName}</td>
            <td>
                ${["P","O","LT","A","DO","RH","SH","CD","CDO"]
                    .map(s => `<button class="status-btn" data-status="${s}">${s}</button>`).join("")}
            </td>
            <td><input type="time" class="time-in" disabled></td>
            <td><input type="time" class="time-out" disabled></td>
        `;
        
        tableBody.appendChild(row); 
    });

    // Initialize status buttons
    activateStatusButtons();
}

function renderSingleEmployeeGrid(employee) {
    tableBody.innerHTML = "";
    
    const row = document.createElement('tr');
    row.dataset.id = employee.employee_id;
    
    const empName = employee.first_name && employee.last_name 
        ? `${employee.first_name} ${employee.last_name}` 
        : (employee.employee_name || 'Unknown');
    
    row.innerHTML = `
        <td>${employee.employee_id}</td>
        <td>${empName}</td>
        <td>
            ${["P","O","LT","A","DO","RH","SH","CD","CDO"]
                .map(s => `<button class="status-btn" data-status="${s}">${s}</button>`).join("")}
        </td>
        <td><input type="time" class="time-in" disabled></td>
        <td><input type="time" class="time-out" disabled></td>
    `;
    
    tableBody.appendChild(row);

    // Initialize status buttons
    activateStatusButtons();
}

function renderPartTimeEmployeesGrid() {
    tableBody.innerHTML = "";
    
    if (partTimeEmployees.length === 0) {
        tableBody.innerHTML = `
            <tr>
                <td colspan="5" class="empty-state">No part-time employees found</td>
            </tr>`;
        return;
    }

    // Used for assurance.
    const selectedDate = dateSelect.value;

    // Assure if part-time is in contract.
    partTimeEmployees.filter(emp => isWithinContract(emp, selectedDate)).forEach(emp => {
        const row = document.createElement('tr');
        row.dataset.id = emp.employee_id;
        
        const empName = emp.first_name && emp.last_name 
            ? `${emp.first_name} ${emp.last_name}` 
            : (emp.employee_name || 'Unknown');
        
        // Show available days in the name
        const days = emp.days_available ? 
            (typeof emp.days_available === 'string' ? JSON.parse(emp.days_available) : emp.days_available).join(', ') 
            : 'All days';
        
        row.innerHTML = `
            <td>${emp.employee_id}</td>
            <td>${empName} <small>(${days})</small></td>
            <td>
                ${["P","O","LT","A","DO","RH","SH","CD","CDO"]
                    .map(s => `<button class="status-btn" data-status="${s}">${s}</button>`).join("")}
            </td>
            <td><input type="time" class="time-in" disabled></td>
            <td><input type="time" class="time-out" disabled></td>
        `;
        
        tableBody.appendChild(row); 
    });

    // Initialize status buttons
    activateStatusButtons();
}

function renderAttendanceGrid() {
    // Always re-render part-time grid when date changes (for day filtering)
    // or if no rows exist yet
    if (selectedPartTimeEmployee && dateSelect.value) {
        renderPartTimeEmployeesGrid();
    } else if (!tableBody.querySelector('tr[data-id]') || !dateSelect.value) {
        // Render appropriate grid based on mode
        if (selectedPartTimeEmployee) {
            renderPartTimeEmployeesGrid();
        } else {
            renderGrid();
        }
    }
    
    // If no date selected, don't populate attendance data
    if (!dateSelect.value) {
        return;
    }

    document.querySelectorAll("tr[data-id]").forEach(row => {
        const id = row.dataset.id;
        const data = attendance[id];
        
        if (!data) {
            // Set default if no data
            row.querySelector('[data-status="P"]').classList.add("active");
            row.querySelector(".time-in").value = "";
            row.querySelector(".time-out").value = "";
            return;
        }

        // Set active status button
        row.querySelectorAll(".status-btn").forEach(btn => {
            btn.classList.toggle("active", btn.dataset.status === data.status);
        });

        // Set time values
        const timeIn = row.querySelector(".time-in");
        const timeOut = row.querySelector(".time-out");
        
        timeIn.value = data.time_in || "";
        timeOut.value = data.time_out || "";

        // Update time input states based on mode and status
        updateTimeInputState(row, data.status);
    });
    
    // Disable status buttons in view mode
    if (mode === "view") {
        document.querySelectorAll(".status-btn").forEach(btn => {
            btn.style.pointerEvents = "none";
            btn.style.cursor = "default";
        });
    }
}

/* ==========================
   STATUS CLICK HANDLER
========================== */
tableBody.addEventListener("click", e => {
    if (!e.target.classList.contains("status-btn")) return;
    if (mode === "view") return;

    const row = e.target.closest("tr");
    const id = row.dataset.id;
    const newStatus = e.target.dataset.status;
    
    const timeIn = row.querySelector(".time-in");
    const timeOut = row.querySelector(".time-out");

    // Update attendance data
    if (!attendance[id]) {
        attendance[id] = { status: newStatus, time_in: "", time_out: "" };
    } else {
        attendance[id].status = newStatus;
        
        // Clear times if status doesn't require them
        if (!["O", "LT"].includes(newStatus)) {
            attendance[id].time_in = "";
            attendance[id].time_out = "";
            timeIn.value = "";
            timeOut.value = "";
        } else {
            // Preserve current time values when switching to O or LT
            attendance[id].time_in = timeIn.value || "";
            attendance[id].time_out = timeOut.value || "";
        }
    }

    // Update UI
    row.querySelectorAll(".status-btn").forEach(btn => {
        btn.classList.toggle("active", btn.dataset.status === newStatus);
    });

    // Update time input states
    updateTimeInputState(row, newStatus);
});

/* ==========================
   TIME INPUT HANDLERS
========================== */
tableBody.addEventListener("input", e => {
    if (mode === "view") return;
    
    const input = e.target;
    if (!input.classList.contains("time-in") && !input.classList.contains("time-out")) return;

    const row = input.closest("tr");
    const id = row.dataset.id;

    if (!attendance[id]) {
        attendance[id] = { status: "P", time_in: "", time_out: "" };
    }

    if (input.classList.contains("time-in")) {
        attendance[id].time_in = input.value;
    } else if (input.classList.contains("time-out")) {
        attendance[id].time_out = input.value;
    }
});

/* ==========================
   SAVE ALL
========================== */
saveBtn.addEventListener("click", async () => {
    if (!dateSelect.value || mode === "view") return;
            // Avoid saving if employees aren't displayed.
            const visibleRows = document.querySelectorAll(
                '#attendanceGrid tbody tr[data-id]'
            );

            if (visibleRows.length === 0) {
                alert("No employees available for the selected date. Cannot save attendance.");
                return;
            }
    // Validate data
    const invalidRecords = [];
    const eightHourViolation = [];
    const overtimeViolation = [];
    const lateViolation = [];

    function toMinutes(time) {
    const [h, m] = time.split(':').map(Number);
    return h * 60 + m;
    }

    Object.entries(attendance).forEach(([id, record]) => {

        // Statuses that never require time
        const noTimeRequiredStatuses = ["A", "DO"];

        // Statuses that must be exactly 8 hours
        const mustBeEightHoursStatuses = ["P", "CD", "CDO"];

        // No time required (A, DO)
        if (noTimeRequiredStatuses.includes(record.status)) {
            return;
        }

        // Restrict missing time
        if (!record.time_in || !record.time_out) {
            invalidRecords.push(id);
            return;
        }

        // Calculate worked minutes
        const workedMinutes =
            toMinutes(record.time_out) - toMinutes(record.time_in);

        // Don't have time (covers late too)
        if (workedMinutes <= 0 || Number.isNaN(workedMinutes)) {
            invalidRecords.push(id);
            return;
        }

        // They must be exactly 8 hours.
        if (mustBeEightHoursStatuses.includes(record.status)) {
            if (workedMinutes < 480 || workedMinutes >= 510) {
                eightHourViolation.push(id);
            }
        }

        // Overtime
        if (record.status === "O") {
            if (workedMinutes < 510) {
                overtimeViolation.push(id);
                return;
            }
        }

        // Late
        if (record.status === "LT") {
            if (workedMinutes >= 480) {
                lateViolation.push(id);
                return;
            }
        }
    });

    if (invalidRecords.length > 0) {
        alert(
            "Cannot save attendance."
        );
        return;
    }

    if (eightHourViolation.length > 0) {
        alert(
            "It must be 8 hours."
        );
        return;
    }

    if (overtimeViolation.length > 0) {
        alert("Overtime must exceed 8 hours and 30 minutes.");
        return;
    }

    if (lateViolation.length > 0) {
        alert("Late/Undertime must be less than 8 hours.");
        return;
    }

    try {
        // Use appropriate company ID based on mode
        const saveCompanyId = selectedPartTimeEmployee ? currentCompanyId : companySelect.value;
        
        const response = await fetch("/attendance/manual/bulk-save", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                company_id: saveCompanyId,
                date: dateSelect.value,
                records: attendance
            })
        });

        if (!response.ok) {
            const errorData = await response.json();
            console.error('Save error details:', errorData);
            throw new Error(errorData.error || "Failed to save attendance");
        }

        // Update cache
        attendanceByDate[dateSelect.value] = structuredClone(attendance);
        
        alert("Attendance saved successfully!");

        // Switch back to view mode
        mode = "view";
        lockControls(false);
        editBtn.disabled = false;
        deleteBtn.disabled = false;
        saveBtn.disabled = true;
        
        // Disable status buttons in view mode
        document.querySelectorAll(".status-btn").forEach(btn => {
            btn.style.pointerEvents = "none";
            btn.style.cursor = "default";
        });
        
        // Update time inputs to readonly state
        updateTimeInputsState();
        
        setModeUI();

    } catch (error) {
        console.error("Error saving attendance:", error);
        alert("Failed to save attendance");
    }
});

/* ==========================
   HELPER FUNCTIONS
========================== */
function resetAll() {
    isUpdatingDropdown = true;
    
    employees = [];
    partTimeEmployees = [];
    allPartTimeEmployees = [];
    selectedPartTimeEmployee = false;
    currentCompanyId = null;
    attendance = {};
    attendanceByDate = {};

    tableBody.innerHTML = `
        <tr>
            <td colspan="5" class="empty-state">Select a company</td>
        </tr>`;

    dateSelect.innerHTML = `<option value="">Select Date</option>`;
    dateSelect.disabled = true;

    createDateBtn.disabled = true;
    editBtn.disabled = true;
    deleteBtn.disabled = true;
    saveBtn.disabled = true;
    dayOffBtn.disabled = true;

    mode = "view";
    setModeUI();
    
    isUpdatingDropdown = false;
}

function resetAttendanceGrid() {
    attendance = {};
    
    document.querySelectorAll("tr[data-id]").forEach(row => {
        // Reset status to default
        row.querySelectorAll(".status-btn").forEach(btn => {
            btn.classList.toggle("active", btn.dataset.status === "P");
        });

        // Reset and disable time inputs
        const timeIn = row.querySelector(".time-in");
        const timeOut = row.querySelector(".time-out");
        
        timeIn.value = "";
        timeOut.value = "";
        timeIn.disabled = true;
        timeOut.disabled = true;
    });
}

function activateStatusButtons() {
    document.querySelectorAll("tr[data-id]").forEach(row => {
        const defaultBtn = row.querySelector('[data-status="P"]');
        if (defaultBtn) {
            defaultBtn.classList.add("active");
        }
    });
}

function updateTimeInputState(row, status) {
    const timeIn = row.querySelector(".time-in");
    const timeOut = row.querySelector(".time-out");
    const id = row.dataset.id;

    if (mode === "view") {
        // In view mode, only show times if they exist, but inputs are disabled
        timeIn.disabled = true;
        timeOut.disabled = true;
        
        // Ensure values are set from attendance data
        if (attendance[id]) {
            timeIn.value = attendance[id].time_in || "";
            timeOut.value = attendance[id].time_out || "";
        }
    } else if (mode === "edit" || mode === "create") {
        // In edit/create mode, enable time inputs for statuses that need time tracking
        if (["P", "O", "LT", "RH", "SH", "CD", "CDO"].includes(status)) {
            timeIn.disabled = false;
            timeOut.disabled = false;
            // Preserve existing time values
            if (attendance[id]) {
                timeIn.value = attendance[id].time_in || "";
                timeOut.value = attendance[id].time_out || "";
            }
        } else {
            timeIn.disabled = true;
            timeOut.disabled = true;
            // Don't clear times in edit mode - preserve existing values
            if (attendance[id] && mode === "edit") {
                timeIn.value = attendance[id].time_in || "";
                timeOut.value = attendance[id].time_out || "";
            } else if (mode === "create") {
                // Only clear in create mode for non-time statuses
                timeIn.value = "";
                timeOut.value = "";
            }
        }
    }
}

function updateTimeInputsState() {
    document.querySelectorAll("tr[data-id]").forEach(row => {
        const id = row.dataset.id;
        const data = attendance[id];
        const status = data ? data.status : "P";
        
        updateTimeInputState(row, status);
    });
}

function lockControls(lock) {
    companySelect.disabled = lock;
    dateSelect.disabled = lock;
    createDateBtn.disabled = lock;
    editBtn.disabled = lock;
    deleteBtn.disabled = lock;
    saveBtn.disabled = !lock; // Save button is enabled when locked (in edit/create mode)
}

function setModeUI() {
    document.body.classList.remove("mode-view", "mode-edit", "mode-create");
    document.body.classList.add(`mode-${mode}`);
    
    modeLabel.textContent =
        mode === "view" ? "VIEW MODE (Read-only)" :
        mode === "edit" ? "EDIT MODE" :
        mode === "create" ? "CREATE MODE" : "";
}

// Initialize
setModeUI();

// ==========================================
// MANUAL INPUT FUNCTIONALITY
// ==========================================

const manualInputBtn = document.getElementById('manualInputBtn');
const attendanceFormModal = document.getElementById('attendanceFormModal');
const closeFormBtn = document.getElementById('closeFormBtn');
const employeeSelect = document.getElementById('employee_select');
const datetimeInInput = document.getElementById('datetime_in');
const datetimeOutInput = document.getElementById('datetime_out');
const attendanceStatus = document.getElementById('attendance_status');

let selectedCompanyId = null;
let selectedCompanyName = null;

// Set current datetime as default
const now = new Date();
now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
datetimeInInput.value = now.toISOString().slice(0, 16);

// Manual Input Button Click
manualInputBtn.addEventListener('click', async () => {
    let selectedCompanyId = companySelect.value;
    
    // Auto-select first company if none selected but only one company exists
    if (!selectedCompanyId) {
        const companyOptions = Array.from(companySelect.options).filter(opt => opt.value);
        if (companyOptions.length === 1) {
            selectedCompanyId = companyOptions[0].value;
            companySelect.value = selectedCompanyId;
        } else {
            alert('Please select a company from the dropdown first');
            companySelect.focus();
            return;
        }
    }
    
    // For part-time, use the selected date to filter employees
    const selectedDate = dateSelect.value || new Date().toISOString().split('T')[0];
    
    // Load employees for selected company
    await loadEmployees(selectedCompanyId, selectedDate);
    
    // Open attendance form
    const companyName = companySelect.options[companySelect.selectedIndex].text;
    document.getElementById('selectedCompanyName').textContent = `Company: ${companyName}`;
    document.getElementById('form_company_id').value = selectedCompanyId === 'part-time' ? currentCompanyId : selectedCompanyId;
    attendanceFormModal.style.display = 'flex';
    resetForm();
});

// Load Employees for Selected Company
async function loadEmployees(companyId, selectedDate = null) {
    try {
        let url = `/attendance/manual/employees/${companyId}`;
        if (selectedDate && companyId === 'part-time') {
            url += `?date=${selectedDate}`;
        }
        const response = await fetch(url);
        const employees = await response.json();
        
        employeeSelect.innerHTML = '<option value="">-- Select Employee --</option>';
        employees.forEach(emp => {
            const option = document.createElement('option');
            option.value = emp.employee_id;
            option.textContent = `${emp.first_name} ${emp.last_name} (${emp.employee_id})`;
            option.dataset.scheduleStart = emp.schedule_start || '';
            option.dataset.scheduleEnd = emp.schedule_end || '';
            employeeSelect.appendChild(option);
        });
    } catch (error) {
        console.error('Error loading employees:', error);
        alert('Error loading employees');
    }
}

// Close Form
closeFormBtn.addEventListener('click', () => {
    attendanceFormModal.style.display = 'none';
    resetForm();
});

// Reset Form
function resetForm() {
    document.getElementById('manualAttendanceForm').reset();
    const now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    datetimeInInput.value = now.toISOString().slice(0, 16);
    attendanceStatus.textContent = 'Status will be calculated based on schedule';
    attendanceStatus.className = 'status-display';
}

// DateTime and Status Calculation
datetimeInInput.addEventListener('change', calculateStatus);
datetimeOutInput.addEventListener('change', calculateStatus);

// Calculate Attendance Status
function calculateStatus() {
    const selectedOption = employeeSelect.options[employeeSelect.selectedIndex];
    
    if (!selectedOption || !selectedOption.value || !datetimeInInput.value) {
        return;
    }
    
    const scheduleStart = selectedOption.dataset.scheduleStart;
    const scheduleEnd = selectedOption.dataset.scheduleEnd;
    const datetimeIn = new Date(datetimeInInput.value);
    const timeIn = datetimeIn.toTimeString().slice(0, 5);
    
    if (!scheduleStart) {
        attendanceStatus.textContent = 'No schedule assigned';
        attendanceStatus.className = 'status-display';
        return;
    }
    
    // Convert times to minutes for comparison
    const scheduleStartMin = timeToMinutes(scheduleStart);
    const timeInMin = timeToMinutes(timeIn);
    
    let status = 'P'; // Present
    let statusText = 'Present (P)';
    let statusClass = 'status-display status-present';
    
    // Check if late (more than 5 minutes after schedule start)
    if (timeInMin > scheduleStartMin + 5) {
        status = 'LT';
        statusText = 'Late (LT)';
        statusClass = 'status-display status-late';
    }
    
    // Check undertime if datetime out is provided
    if (datetimeOutInput.value && scheduleEnd) {
        const datetimeOut = new Date(datetimeOutInput.value);
        const timeOut = datetimeOut.toTimeString().slice(0, 5);
        const scheduleEndMin = timeToMinutes(scheduleEnd);
        const timeOutMin = timeToMinutes(timeOut);
        
        if (timeOutMin < scheduleEndMin - 5) {
            status = 'LT';
            statusText = 'Undertime (LT)';
            statusClass = 'status-display status-late';
        }
    }
    
    attendanceStatus.textContent = statusText;
    attendanceStatus.className = statusClass;
}

function timeToMinutes(time) {
    const [hours, minutes] = time.split(':').map(Number);
    return hours * 60 + minutes;
}

// Employee Selection Change
employeeSelect.addEventListener('change', calculateStatus);

// Form Submission
document.getElementById('manualAttendanceForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    
    // Debug: Log form data
    console.log('Submitting form with data:');
    for (let [key, value] of formData.entries()) {
        console.log(key + ':', value.substring ? value.substring(0, 50) : value);
    }
    
    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        console.log('CSRF token found:', !!csrfToken, csrfToken?.content);
        
        const response = await fetch('/attendance/manual/save', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken ? csrfToken.content : ''
            },
            body: formData
        });
        
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers.get('content-type'));
        
        const responseText = await response.text();
        console.log('Response text:', responseText);
        
        const result = JSON.parse(responseText);
        
        if (result.success) {
            alert('Attendance recorded successfully!');
            attendanceFormModal.style.display = 'none';
            resetForm();
            
            // Reload attendance data for current date if viewing
            if (dateSelect.value) {
                // Invalidate cache and reload
                delete attendanceByDate[dateSelect.value];
                dateSelect.dispatchEvent(new Event('change'));
            }
        } else {
            alert(result.message || 'Error saving attendance');
        }
    } catch (error) {
        console.error('Full error:', error);
        alert('Error submitting form: ' + error.message);
    }
});

// ==========================================
// DAY OFF SETUP FUNCTIONALITY
// ==========================================

const dayOffModal = document.getElementById('dayOffModal');
const dayOffForm = document.getElementById('dayOffForm');
const closeDayOffBtn = document.getElementById('closeDayOffBtn');
const dayOffEmployeeList = document.getElementById('dayOffEmployeeList');
const dayOffBtn = document.getElementById('dayOffBtn');

// Day Off Button Click
dayOffBtn.addEventListener('click', () => {
    if (!dateSelect.value) {
        alert('Please select a date first');
        return;
    }
    
    // Use appropriate company ID based on mode
    const dayOffCompanyId = selectedPartTimeEmployee ? currentCompanyId : companySelect.value;
    
    // Set company and date
    document.getElementById('dayoff_company_id').value = dayOffCompanyId;
    document.getElementById('dayoff_date').value = dateSelect.value;
    
    // Populate employee list
    populateDayOffList();
    
    // Show modal
    dayOffModal.style.display = 'flex';
});

// Close Day Off Modal
closeDayOffBtn.addEventListener('click', () => {
    dayOffModal.style.display = 'none';
});

// Populate Day Off List
function populateDayOffList() {
    dayOffEmployeeList.innerHTML = '';
    
    // Determine which employees to show based on mode
    const currentEmployees = selectedPartTimeEmployee ? partTimeEmployees : employees;
    
    // Only permanent employees (full-time and contractual) can take day off
    // Part-time employees can also take day off when in part-time mode
    const eligibleEmployees = selectedPartTimeEmployee 
        ? currentEmployees // All part-time employees are eligible
        : currentEmployees.filter(emp => 
            emp.employment_type === 'full-time' || emp.employment_type === 'contractual'
          );
    
    if (eligibleEmployees.length === 0) {
        dayOffEmployeeList.innerHTML = `
            <tr>
                <td colspan="4" style="text-align: center; padding: 20px;">
                    No eligible employees for day off
                </td>
            </tr>
        `;
        return;
    }
    
    eligibleEmployees.forEach(emp => {
        const currentStatus = attendance[emp.employee_id]?.status || 'P';
        const isOnDayOff = ['DO'].includes(currentStatus); // Check if already on day off
        
        // Use employee_name if first_name/last_name not available
        const empName = emp.first_name && emp.last_name 
            ? `${emp.first_name} ${emp.last_name}` 
            : (emp.employee_name || 'Unknown');
        
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${empName}</td>
            <td><strong>${currentStatus}</strong></td>
            <td>
                <select class="dayoff-status-select" data-employee-id="${emp.employee_id}">
                    <option value="">-- No Change --</option>
                    <option value="DO" ${currentStatus === 'DO' ? 'selected' : ''}>Day Off (DO)</option>
                    <option value="CDO" ${currentStatus === 'CDO' ? 'selected' : ''}>Cancel Day Off (CDO)</option>
                    <option value="P">Present (P)</option>
                </select>
            </td>
            <td>
                <button type="button" class="btn-cancel cancel-dayoff-btn" data-employee-id="${emp.employee_id}" ${currentStatus === 'DO' ? '' : 'disabled'}>
                    Cancel Day Off
                </button>
            </td>
        `;
        dayOffEmployeeList.appendChild(row);
    });
    
    // Add cancel day off button listeners
    document.querySelectorAll('.cancel-dayoff-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const empId = this.dataset.employeeId;
            const select = document.querySelector(`select[data-employee-id="${empId}"]`);
            select.value = 'CDO'; // Set to Cancel Day Off
            this.disabled = true;
        });
    });
}

// Save Day Off Form
dayOffForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const updates = [];
    document.querySelectorAll('.dayoff-status-select').forEach(select => {
        if (select.value) {
            updates.push({
                employee_id: select.dataset.employeeId,
                status: select.value
            });
        }
    });
    
    if (updates.length === 0) {
        alert('No changes to save');
        return;
    }
    
    // Update local attendance data
    updates.forEach(update => {
        if (!attendance[update.employee_id]) {
            attendance[update.employee_id] = { status: 'P', time_in: '', time_out: '' };
        }
        attendance[update.employee_id].status = update.status;
    });
    
    // Save to database immediately
    try {
        const response = await fetch("/attendance/manual/bulk-save", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                company_id: companySelect.value,
                date: dateSelect.value,
                records: attendance
            })
        });

        if (!response.ok) {
            const errorData = await response.json();
            console.error('Day off save error details:', errorData);
            throw new Error(errorData.error || "Failed to save day off");
        }

        // Update cache
        attendanceByDate[dateSelect.value] = structuredClone(attendance);
        
        // Refresh grid
        renderAttendanceGrid();
        
        // Close modal
        dayOffModal.style.display = 'none';
        
        alert('Day Off status updated successfully!');

    } catch (error) {
        console.error("Error saving day off:", error);
        alert("Failed to save day off status");
    }
});

/* ==========================
   INITIALIZATION ON PAGE LOAD
========================== */
// If company select has a value (e.g., after page reload), trigger change event to load data
if (companySelect.value) {
    companySelect.dispatchEvent(new Event('change'));
}

});
</script>
</x-app> 