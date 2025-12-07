
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/styles/ht-theme-main.min.css">
@vite(['resources/js/api/payroll-table.js', 'resources/css/payroll/payroll.css'])

<x-app>
    <div class="main-content">

        <nav>
            <select id="companyFilter" class="company-dropdown">
                <option value="">Select Company</option>
            </select>

            <button id="reloadPayroll" class="reload-btn">Reload Payroll</button>
            <button id="savePayroll" class="save-btn">Save Changes</button>
        </nav>

        <div id="payroll-table" class="ht-wrapper"></div>

    </div>
</x-app>
