@vite(['resources/css/company/payroll.css'])

<x-app :navigation="true" navigationType="employee" :employee="$employee" :noHeader="true">
    <section class="main-content">
        <nav>
            <x-button-link :source="['employee.dashboard.payroll', ['id' => $employee->employee_id  ,'type' => 'daily']]" :noDefault="true">Daily Log</x-button-link>
            <x-button-link :source="['employee.dashboard.payroll', ['id' => $employee->employee_id, 'type' => 'semi']]" :noDefault="true">Semi Monthly</x-button-link>

          {{--  <button id="downloadPDF" class="btn-download">Download PDF</button>  --}}
        </nav>
            <table class="custom-table">
                <x-payroll-table
                    :payroll="$payroll"
                    :type="$type"
                />
            </table>


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
    </script>
</x-app>
