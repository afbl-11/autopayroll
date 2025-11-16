
document.addEventListener("DOMContentLoaded", async () => {

    const response = await fetch('/api/employee/payroll/20250798');
    const payrollData = await response.json();

    const container = document.querySelector('#payroll-table');

    const hot = new Handsontable(container, {
        data: payrollData,
        rowHeaders: true,
        colHeaders: [
            "Employee Name",
            "Payroll Date",
            "Rate",
            "Gross Salary",
            "Net Salary",
            "Late Deductions",
            "Overtime Pay",
            "Night Diff",
            "Holiday Pay",
            "Late Time",
            "Work Hours",
            'Clock in Date',
            "Clock in",
            "Clock out Date",
            "Clock out",
        ],
        columns: [
            { data: "employee_name", readOnly: true },
            { data: "payroll_date", type: "date", dateFormat: "YYYY-MM-DD" },
            { data: "rate", type: "numeric"},
            { data: "gross_salary", type: "numeric" },
            { data: "net_salary", type: "numeric" },
            { data: "deductions", type: "numeric" },
            { data: "overtime", type: "numeric" },
            { data: "night_differential", type: "numeric" },
            { data: "holiday_pay", type: "numeric" },
            { data: "late_time", type: "numeric" },
            { data: "work_hours", type: "numeric" },
            { data: "clock_in_date", type: "date", dateFormat: "YYYY-MM-DD" },
            { data: "clock_in_time", type: "time",timeFormat: "HH:mm",  correctFormat: true, allowInvalid: false, },
            { data: "clock_out_date", type: "date", dateFormat: "YYYY-MM-DD" },
            { data: "clock_out_time", type: "time", timeFormat: "HH:mm",  correctFormat: true, allowInvalid: false,  },
        ],
        hiddenColumns: {
            columns: [10],
            indicators: false
        },
        stretchH: "all",
        height: 600,
        licenseKey: "non-commercial-and-evaluation",


        afterChange: (changes) => {
            if (!changes) return;

            changes.forEach(([row, prop, oldValue, newValue]) => {
                if (
                    ["gross_salary", "deductions", "overtime", "night_differential", "holiday_pay"]
                        .includes(prop)
                ) {
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

    // SAVE BUTTON
    document.getElementById("savePayroll").addEventListener("click", async () => {
        const updatedRows = hot.getSourceData().map(row => ({
            payroll_id: row.payroll_id,
            gross_salary: row.gross_salary,
            deductions: row.deductions,
            overtime: row.overtime,
            night_differential: row.night_differential,
            holiday_pay: row.holiday_pay,
            net_salary: row.net_salary,
        }));

        const save = await fetch("/api/web/payroll/update", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ rows: updatedRows })
        });

        const result = await save.json();

        if (result.success) alert("Saved successfully!");
    });
});
