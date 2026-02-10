<x-app title="Edit SSS Deductions">
<link rel="stylesheet" href="{{ asset('css/salary-list.css') }}">

<div class="main-content">
<div class="salary-list-containers">
<div class="salary-table-wrapper">

<form method="POST" action="{{ route('sss.import') }}" enctype="multipart/form-data">
@csrf
@method('PUT')

<!-- IMPORT FILE -->
<div style="margin-bottom:15px;">
<label style="font-weight:600;">Import CSV / Excel</label><br>
<input type="file" name="csv_file" accept=".csv,.xlsx,.xls" id="csvUpload">
</div>

<!-- SHARE TABLE -->
<div class="table-responsive-2">
    <table class="deduction-table-2">
        <thead>
            <tr>
            <th>Employee Share (%)</th>
            <th>Employer Share (%)</th>
            </tr>
        </thead>

    <tbody>
        <tr>
            <td>
                <input type="number" step="0.01" name="sss_employee_percent[]">
            </td>
            <td>
                <input type="number" step="0.01" name="sss_employer_percent[]">
            </td>
        </tr>
    </tbody>
    </table>
    </div>

    <!-- RANGE TABLE -->
    <div class="table-responsive">
        <table class="deduction-table">
            <thead>
                <tr>
                    <th>From</th>
                    <th>To</th>
                    <th>Monthly Salary Credit</th>
                </tr>
            </thead>

            <tbody>

                @for($i=0; $i<20; $i++)
                    <tr>
                        <td>
                            <input type="number" step="0.01" name="bracket_min[]" class="min" placeholder="From">
                        </td>
                        <td>
                            <input type="number" step="0.01" name="bracket_max[]" class="max" placeholder="To">
                        </td>
                        <td>
                            <input type="number" step="0.01" name="msc[]" class="msc">
                        </td>
                    </tr>
                @endfor

            </tbody>
        </table>
</div>

<!-- SAVE -->
<div style="display:flex; justify-content:flex-end; margin-top:15px;">
    <button type="submit" style="
        background:#fbbf24;
        color:var(--clr-primary);
        padding:10px 25px;
        border:none;
        border-radius:8px;
        font-weight:600;
        cursor:pointer;">
            Save / Import
    </button>
</div>

</form>

</div>
</div>
</div>

<!-- STYLE -->
<style>
    .table-responsive-2{margin-bottom:25px;}
    .deduction-table,.deduction-table-2{
        width:100%;
        border-collapse:collapse;
        background:white;
    }
    .deduction-table th,.deduction-table-2 th{
        background:black;
        color:white;
        padding:12px;
        border:1px solid #d1d5db;
    }
    .deduction-table td,.deduction-table-2 td{
        border:1px solid #e5e7eb;
        padding:12px;
    }
    .deduction-table input,.deduction-table-2 input{
        width:100%;
        height:38px;
        border:1px solid #d1d5db;
        border-radius:8px;
        padding:6px 10px;
    }
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type="number"] {
        -moz-appearance: textfield;
    }

@media (max-width: 1150px) {
    .salary-table-wrapper {
        width: 90%;
        margin-left: 50px;
    }
}

@media (max-width: 900px) {
    .salary-table-wrapper {
        margin-left: 70px;
        width: 85%;
    }
}
@media (max-width:800px){

    .salary-list-containers{
        padding:5px;
    }

    .deduction-table th,
    .deduction-table-2 th{
        padding:8px;
        font-size:13px;
    }

    .deduction-table td,
    .deduction-table-2 td{
        padding:6px;
    }

    .deduction-table input,
    .deduction-table-2 input{
        height:34px;
        font-size:13px;
        padding:5px 8px;
    }

}

@media (max-width:700px) {
    .salary-table-wrapper {
        margin-left: 75px;
        width: 82%;
    }
}
@media (max-width:480px) {
    .salary-table-wrapper {
        margin-left: 150px;
        width: 75%;
    }
}

</style>

<!-- AUTO IMPORT SCRIPT -->
<script>

    document.getElementById('csvUpload').addEventListener('change', function(){

    let file = this.files[0];

    let formData = new FormData();
    formData.append('csv_file', file);
    formData.append('_token', '{{ csrf_token() }}');

    fetch("{{ route('sss.preview') }}",{
    method:'POST',
    body:formData
    })
    .then(res=>res.json())
    .then(data=>{

    let mins = document.querySelectorAll('.min');
    let maxs = document.querySelectorAll('.max');
    let mscs = document.querySelectorAll('.msc');

    data.forEach((row,i)=>{
    if(mins[i]) mins[i].value = row.min;
    if(maxs[i]) maxs[i].value = row.max;
    if(mscs[i]) mscs[i].value = row.msc;
    });

});

});

</script>

</x-app>
