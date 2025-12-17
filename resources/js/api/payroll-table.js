import Handsontable from "handsontable";
import "handsontable/dist/handsontable.full.min.css";

document.addEventListener("DOMContentLoaded", async () => {

    const companyDropdown = document.getElementById("companyFilter");
    const reloadBtn = document.getElementById("reloadPayroll");
    const saveBtn = document.getElementById("savePayroll");
    const downloadBtn = document.getElementById("downloadPayroll"); // ⬅ ADDED
    const container = document.getElementById("payroll-table");

    let hot = null;

    /** -------------------------------
     * LOAD COMPANIES
     --------------------------------*/
    async function loadCompanies() {
        try {
            const res = await fetch("/api/companies");
            const companies = await res.json();

        companies.forEach(c => {
            const opt = document.createElement("option");
            opt.value = c.company_id; 
            opt.textContent = c.company_name || c.name;
            companyDropdown.appendChild(opt);
        });

        } catch (err) {
            console.error("Error loading companies:", err);
        }
    }

    /** -------------------------------
     * LOAD PAYROLL TABLE
     --------------------------------*/
    async function loadPayroll(companyId) {
        if (!companyId) {
            container.innerHTML = "<p style='margin:1rem;'>Select a company to load payroll data.</p>";
            return;
        }

        const response = await fetch(`/api/payroll/company/${companyId}`);

        const payrollData = await response.json();

        if (hot) hot.destroy();

        hot = new Handsontable(container, {
            data: payrollData,
            rowHeaders: true,
            colHeaders: [
                "Employee Name", "Payroll Date", "Rate", "Gross Salary",
                "Net Salary", "Deductions", "Overtime", "Night Diff",
                "Holiday Pay", "Late Time", "Work Hours"
            ],
            columns: [
                { data: "employee_name", readOnly: true },
                { data: "payroll_date", type: "date", dateFormat: "YYYY-MM-DD" },
                { data: "rate", type: "numeric" },
                { data: "gross_salary", type: "numeric" },
                { data: "net_salary", type: "numeric", readOnly: true },
                { data: "deductions", type: "numeric" },
                { data: "overtime", type: "numeric" },
                { data: "night_differential", type: "numeric" },
                { data: "holiday_pay", type: "numeric" },
                { data: "late_time", type: "numeric" },
                { data: "work_hours", type: "numeric" },
            ],
            stretchH: "all",
            height: 600,
            licenseKey: "non-commercial-and-evaluation",

            /** Auto-calc Net Salary */
            afterChange(changes) {
                if (!changes) return;

                changes.forEach(([row, prop]) => {
                    if (["gross_salary","deductions","overtime","night_differential","holiday_pay"].includes(prop)) {
                        const rowData = hot.getSourceDataAtRow(row);

                        const net =
                            Number(rowData.gross_salary || 0) -
                            Number(rowData.deductions || 0) +
                            Number(rowData.overtime || 0) +
                            Number(rowData.night_differential || 0) +
                            Number(rowData.holiday_pay || 0);

                        hot.setDataAtRowProp(row, "net_salary", net);
                    }
                });
            }
        });
    }

    /** -------------------------------
     * EVENT LISTENERS
     --------------------------------*/
    companyDropdown.addEventListener("change", (e) => loadPayroll(e.target.value));

    reloadBtn.addEventListener("click", () => {
        const id = companyDropdown.value;
        if (id) loadPayroll(id);
    });

    saveBtn.addEventListener("click", async () => {
        if (!hot) return alert("No payroll data available.");

        const rows = hot.getSourceData();

        const save = await fetch("/api/payroll/update", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ rows }),
        });

        const result = await save.json();
        alert(result.success ? "Payroll saved successfully!" : "Failed to save.");
    });

    /** -------------------------------
     * DOWNLOAD PAYROLL (CSV)
     --------------------------------*/
    downloadBtn.addEventListener("click", () => {
        if (!hot) return alert("No payroll data to download.");

        const data = hot.getData();           // table values
        const headers = hot.getColHeader();   // column names

        const csvRows = [];

        // Header row
        csvRows.push(headers.join(","));

        // Data rows
        data.forEach(row => {
            csvRows.push(row.map(v => `"${v ?? ''}"`).join(","));
        });

        const csvContent = csvRows.join("\n");

        // Create file
        const blob = new Blob([csvContent], { type: "text/csv" });
        const url = URL.createObjectURL(blob);

        const a = document.createElement("a");
        a.href = url;
        a.download = `payroll_${companyDropdown.value || 'data'}.csv`;
        a.click();

        URL.revokeObjectURL(url);
    });

    /** Init */
    await loadCompanies();
});