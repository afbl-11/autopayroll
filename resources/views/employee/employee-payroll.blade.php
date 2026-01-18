@vite(['resources/css/company/payroll.css'])
<link rel="stylesheet" href="{{ asset('css/payroll-filters.css') }}">

<x-app :navigation="true" navigationType="employee" :employee="$employee" :noHeader="true">
    <section class="main-content">
        <nav>
            <x-button-link :source="['employee.dashboard.payroll', ['id' => $employee->employee_id  ,'type' => 'daily']]" :noDefault="true">Daily Log</x-button-link>
            <x-button-link :source="['employee.dashboard.payroll', ['id' => $employee->employee_id, 'type' => 'semi']]" :noDefault="true">Semi Monthly</x-button-link>
            <button onclick="openPayslipWithPeriod()" class="btn-link" style="background: var(--clr-yellow); color: var(--clr-primary); padding: 8px 16px; border: none; border-radius: 8px; cursor: pointer; font-size: 13px; font-family: 'Helvetica Regular', sans-serif;">Generate Payslip</button>

          {{--  <button id="downloadPDF" class="btn-download">Download PDF</button>  --}}
        </nav>

        <!-- Period Selection Modal for Monthly Payslip -->
        <div id="periodModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
            <div style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.2); max-width: 400px; width: 90%;">
                <h3 style="color: var(--clr-primary); margin-bottom: 1.5rem; font-size: 18px;">Select Payslip Period</h3>
                
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--clr-secondary); font-size: 14px;">Period Type:</label>
                    <select id="modalPeriodFilter" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
                        <option value="1-15">1st-15th (No Deductions)</option>
                        <option value="16-30">16th-30th (With Deductions)</option>
                    </select>
                </div>

                <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 1.5rem;">
                    <button onclick="closeModal()" style="background: #e5e7eb; color: #374151; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-size: 14px;">Cancel</button>
                    <button onclick="navigateToPayslip()" style="background: var(--clr-yellow); color: var(--clr-primary); padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-size: 14px; font-weight: 600;">Continue</button>
                </div>
            </div>
        </div>

        @if($type === 'daily')
            <div class="filter-controls">
                <label for="yearFilter">Year:</label>
                <select id="yearFilter">
                    <option value="">All Years</option>
                    @php
                        $years = $payroll->map(function($item) {
                            return \Carbon\Carbon::parse($item->payroll_date)->format('Y');
                        })->unique()->sort()->values();
                    @endphp
                    @foreach($years as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>

                <label for="monthFilter">Month:</label>
                <select id="monthFilter">
                    <option value="">All Months</option>
                    <option value="01">January</option>
                    <option value="02">February</option>
                    <option value="03">March</option>
                    <option value="04">April</option>
                    <option value="05">May</option>
                    <option value="06">June</option>
                    <option value="07">July</option>
                    <option value="08">August</option>
                    <option value="09">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
            </div>
        @endif

        <div class="table-wrapper">
            <table class="custom-table" id="payrollTable">
                <x-payroll-table
                    :payroll="$payroll"
                    :type="$type"
                />
            </table>
        </div>


    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {

            const button = document.getElementById("downloadPDF");

            if (!button) return;

            button.addEventListener("click", async () => {

                const payrollTable = document.querySelector(".custom-table");
                if (!payrollTable) {
                    alert("Payroll table not found.");
                    return;
                }

                const { jsPDF } = window.jspdf;

                // Capture HTML as image
                const canvas = await html2canvas(payrollTable, { scale: 2 });
                const imgData = canvas.toDataURL("image/png");

                // Create PDF
                const pdf = new jsPDF("p", "mm", "a4");
                const pageWidth = pdf.internal.pageSize.getWidth();
                const pageHeight = pdf.internal.pageSize.getHeight();

                const imgWidth = pageWidth;
                const imgHeight = (canvas.height * imgWidth) / canvas.width;

                let heightLeft = imgHeight;
                let position = 0;

                // Add first page
                pdf.addImage(imgData, "PNG", 0, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;

                // Add additional pages if needed
                while (heightLeft > 0) {
                    position = heightLeft - imgHeight;
                    pdf.addPage();
                    pdf.addImage(imgData, "PNG", 0, position, imgWidth, imgHeight);
                    heightLeft -= pageHeight;
                }

                pdf.save("Payroll.pdf");
            });
        });

        // Filter functionality for daily payroll
        const yearFilter = document.getElementById('yearFilter');
        const monthFilter = document.getElementById('monthFilter');
        
        if (yearFilter && monthFilter) {
            const tableRows = document.querySelectorAll('#payrollTable tbody tr');
            
            function filterTable() {
                const selectedYear = yearFilter.value;
                const selectedMonth = monthFilter.value;
                
                tableRows.forEach(row => {
                    const dateCell = row.cells[0];
                    if (!dateCell) return;
                    
                    const dateText = dateCell.textContent.trim();
                    
                    // Check if row is empty state
                    if (dateText.includes('No existing payroll log')) {
                        return;
                    }
                    
                    // Parse date from the cell (format: YYYY-MM-DD)
                    const dateMatch = dateText.match(/\d{4}-\d{2}-\d{2}/);
                    if (!dateMatch) return;
                    
                    const [year, month] = dateMatch[0].split('-');
                    
                    let showRow = true;
                    
                    if (selectedYear && year !== selectedYear) {
                        showRow = false;
                    }
                    
                    if (selectedMonth && month !== selectedMonth) {
                        showRow = false;
                    }
                    
                    row.style.display = showRow ? '' : 'none';
                });
            }
            
            yearFilter.addEventListener('change', filterTable);
            monthFilter.addEventListener('change', filterTable);
        }

        // Period Modal Functions
        function openPayslipWithPeriod() {
            document.getElementById('periodModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('periodModal').style.display = 'none';
        }

        function navigateToPayslip() {
            const period = document.getElementById('modalPeriodFilter').value;
            const employeeId = '{{ $employee->employee_id }}';
            window.location.href = `/dashboard/employee/payslip/${employeeId}?period=${period}`;
        }

        // Close modal when clicking outside
        document.getElementById('periodModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</x-app>
