@vite(['resources/css/company/manual-attendance.css'])

<x-app>
<div class="main-content">

<h2 class="page-title">Manual Attendance</h2>

{{-- LEGEND --}}
<div class="attendance-legend">
    <strong>Legend:</strong>
    <span><b>8</b> – Present (8 Hours)</span>
    <span><b>O</b> – Overtime</span>
    <span><b>LT</b> – Late / Undertime</span>
    <span><b>A</b> – Absent</span>
    <span><b>DO</b> – Day Off</span>
    <span><b>R</b> – Regular Holiday</span>
    <span><b>S</b> – Special Holiday</span>
    <span><b>L</b> – Legal Holiday</span>
    <span><b>CO</b> – Change Day Off</span>
    <span><b>CDO</b> – Cancel Day Off</span>
</div>

{{-- CONTROLS --}}
<div class="attendance-controls">
    <select id="companySelect">
        <option value="">Select Company</option>
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
const tableBody = document.querySelector("#attendanceGrid tbody");
const modeLabel = document.getElementById("modeLabel");

let employees = [];
let attendance = {};
let attendanceByDate = {};
let mode = "view";

/* ==========================
   COMPANY CHANGE
========================== */
companySelect.addEventListener("change", async () => {
    // Reset everything if no company selected
    if (!companySelect.value) {
        resetAll();
        return;
    }

    try {
        // Load employees
        const empRes = await fetch(`/api/company/${companySelect.value}/employees`);
        if (!empRes.ok) throw new Error("Failed to fetch employees");
        
        const empData = await empRes.json();
        employees = empData.data || [];

        // Render empty grid
        renderGrid();

        // Load attendance dates
        const dateRes = await fetch(`/api/company/${companySelect.value}/attendance-dates`);
        if (!dateRes.ok) throw new Error("Failed to fetch dates");
        
        const dateData = await dateRes.json();
        const dates = dateData.data || [];

        // Populate date select
        dateSelect.innerHTML = `<option value="">Select Date</option>`;
        dates.forEach(d => {
            if (d.date) {
                dateSelect.innerHTML += `<option value="${d.date}">${d.date}</option>`;
            }
        });

        // Reset attendance data cache
        attendanceByDate = {};

        // Enable/disable controls
        dateSelect.disabled = false;
        createDateBtn.disabled = false;
        editBtn.disabled = true;
        deleteBtn.disabled = true;
        saveBtn.disabled = true;

        // Reset mode
        mode = "view";
        setModeUI();

    } catch (error) {
        console.error("Error loading company data:", error);
        alert("Failed to load company data");
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
        mode = "view";
        setModeUI();
        return;
    }

    const selectedDate = dateSelect.value;

    try {
        // Load attendance for selected date if not already cached
        if (!attendanceByDate[selectedDate]) {
            const response = await fetch(`/api/company/${companySelect.value}/attendance/${selectedDate}`);
            if (!response.ok) throw new Error("Failed to fetch attendance");
            
            const data = await response.json();
            attendanceByDate[selectedDate] = data.data || {};
        }

        // Set attendance data
        attendance = structuredClone(attendanceByDate[selectedDate]) || {};

        // Initialize empty records for employees without attendance
        employees.forEach(emp => {
            if (!attendance[emp.employee_id]) {
                attendance[emp.employee_id] = {
                    status: "8",
                    time_in: "",
                    time_out: ""
                };
            }
        });

        // Render grid with attendance data
        renderAttendanceGrid();

        // Enable edit/delete buttons
        editBtn.disabled = false;
        deleteBtn.disabled = false;
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
createDateBtn.addEventListener("click", async () => {
    const input = prompt("Enter date (YYYY-MM-DD)");
    if (!input) return;

    // Validate date format
    if (!/^\d{4}-\d{2}-\d{2}$/.test(input)) {
        alert("Invalid date format. Please use YYYY-MM-DD");
        return;
    }

    // Check if date already exists
    if ([...dateSelect.options].some(o => o.value === input)) {
        alert("Date already exists");
        return;
    }

    try {
        const response = await fetch("/api/attendance/create-date", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                company_id: companySelect.value,
                date: input
            })
        });

        if (!response.ok) throw new Error("Failed to create date");

        // Add to date select
        const option = new Option(input, input);
        dateSelect.add(option);
        dateSelect.value = input;

        // Initialize empty attendance
        attendance = {};
        employees.forEach(emp => {
            attendance[emp.employee_id] = {
                status: "8",
                time_in: "",
                time_out: ""
            };
        });

        attendanceByDate[input] = structuredClone(attendance);

        // Render with new data
        renderAttendanceGrid();

        // Set mode to create
        mode = "create";
        lockControls(true);
        setModeUI();

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
        const response = await fetch("/api/attendance/delete-date", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                company_id: companySelect.value,
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
        
        row.innerHTML = `
            <td>${emp.employee_id}</td>
            <td>${emp.employee_name}</td>
            <td>
                ${["8","O","LT","A","DO","R","S","L","CO","CDO"]
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
    if (!tableBody.querySelector('tr[data-id]')) {
        renderGrid();
    }

    document.querySelectorAll("tr[data-id]").forEach(row => {
        const id = row.dataset.id;
        const data = attendance[id];
        
        if (!data) {
            // Set default if no data
            row.querySelector('[data-status="8"]').classList.add("active");
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

    // Update attendance data
    if (!attendance[id]) {
        attendance[id] = { status: newStatus, time_in: "", time_out: "" };
    } else {
        attendance[id].status = newStatus;
        
        // Clear times if status doesn't require them
        if (!["O", "LT"].includes(newStatus)) {
            attendance[id].time_in = "";
            attendance[id].time_out = "";
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
        attendance[id] = { status: "8", time_in: "", time_out: "" };
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

    // Validate data (optional - add more validation as needed)
    const invalidRecords = [];
    Object.entries(attendance).forEach(([id, record]) => {
        if (["O", "LT"].includes(record.status)) {
            if (!record.time_in || !record.time_out) {
                invalidRecords.push(id);
            }
        }
    });

    if (invalidRecords.length > 0 && !confirm(`Some records (${invalidRecords.length}) have Overtime/Late status but missing time entries. Save anyway?`)) {
        return;
    }

    try {
        const response = await fetch("/api/attendance/manual/bulk-save", {
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

        if (!response.ok) throw new Error("Failed to save attendance");

        // Update cache
        attendanceByDate[dateSelect.value] = structuredClone(attendance);
        
        alert("Attendance saved successfully!");

        // Switch back to view mode
        mode = "view";
        lockControls(false);
        editBtn.disabled = false;
        deleteBtn.disabled = false;
        saveBtn.disabled = true;
        
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
    employees = [];
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

    mode = "view";
    setModeUI();
}

function resetAttendanceGrid() {
    attendance = {};
    
    document.querySelectorAll("tr[data-id]").forEach(row => {
        // Reset status to default
        row.querySelectorAll(".status-btn").forEach(btn => {
            btn.classList.toggle("active", btn.dataset.status === "8");
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
        const defaultBtn = row.querySelector('[data-status="8"]');
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
        // In edit/create mode, enable time inputs only for O/LT statuses
        if (["O", "LT"].includes(status)) {
            timeIn.disabled = false;
            timeOut.disabled = false;
        } else {
            timeIn.disabled = true;
            timeOut.disabled = true;
            timeIn.value = "";
            timeOut.value = "";
        }
    }
}

function updateTimeInputsState() {
    document.querySelectorAll("tr[data-id]").forEach(row => {
        const id = row.dataset.id;
        const data = attendance[id];
        const status = data ? data.status : "8";
        
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

});
</script>
</x-app> 