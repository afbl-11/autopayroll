{{-- Handsontable CSS FIRST --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/styles/handsontable.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/styles/ht-theme-main.min.css" />

{{-- Handsontable JS FIRST --}}
<script src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>

{{-- Now load your Vite JS --}}
@vite(['resources/js/api/payroll-table.js', 'resources/css/payroll/payroll.css'])
<x-app>
    <div id="payroll-table" style="width: 100%; height: 600px;"></div>

</x-app>
