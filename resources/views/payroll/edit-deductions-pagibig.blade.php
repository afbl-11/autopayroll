<x-app title="Edit Pag-Ibig Deductions">
<link rel="stylesheet" href="{{ asset('css/salary-list.css') }}">

<div class="main-content">
    <div class="salary-list-containers">

        <div class="salary-table-wrapper">

            <form method="POST" action="">
                @csrf
                @method('PUT')
                <div class="table-responsive">
                    <table class="deduction-table">

                        <thead>
                            <tr>
                                <th>From</th>
                                <th>To</th>
                                <th>Employee Share (%)</th>
                                <th>Employer Share (%)</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>
                                    <input type="number" placeholder="From"
                                        name="bracket_min">
                                </td>
                                
                                <td>
                                    <input type="number" placeholder="To"
                                    name="bracket_max">
                                </td>

                                <td>
                                    <input type="number" step="0.01"
                                        name="pagibig_employee_percent"
                                        value="{{ $settings->pagibig_employee_percent ?? '' }}">
                                </td>

                                <td>
                                    <input type="number" step="0.01"
                                        name="pagibig_employer_percent"
                                        value="{{ $settings->pagibig_employer_percent ?? '' }}">
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <input type="number" placeholder="From"
                                        name="bracket_min">
                                </td>

                                <td>
                                    <input type="number" placeholder="To"
                                    name="bracket_max">
                                </td>

                                <td>
                                    <input type="number" step="0.01"
                                        name="pagibig_employee_percent"
                                        value="{{ $settings->pagibig_employee_percent ?? '' }}">
                                </td>

                                <td>
                                    <input type="number" step="0.01"
                                        name="pagibig_employer_percent"
                                        value="{{ $settings->pagibig_employer_percent ?? '' }}">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>


                <!-- SAVE BUTTON -->
                <div style="display:flex; justify-content:flex-end; margin-top:15px;">
                    <button type="submit"
                        style="
                            background:#fbbf24;
                            color:var(--clr-primary);
                            padding:10px 25px;
                            border:none;
                            border-radius:8px;
                            font-weight:600;
                            cursor:pointer;
                        ">
                        Save
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<style>
.table input{
    border-radius:8px;
    border:1px solid #ccc;
    padding:6px;
}
.deduction-table{
    width:100%;
    border-collapse: collapse;
    background:white;
}

/* HEADER */
.deduction-table th{
    background:black;
    color:white;
    padding:12px;
    border:1px solid #d1d5db;
    font-weight:600;
}

/* CELLS */
.deduction-table td{
    border:1px solid #e5e7eb;
    padding:12px;
    vertical-align:middle;
}

/* TYPE COLUMN */
.type-cell{
    font-weight:600;
    color:#4b5563;
    width:180px;
}

/* NORMAL INPUT SIZE */
.deduction-table input{
    width:100%;
    height:40px;
    border:1px solid #d1d5db;
    border-radius:8px;
    padding:6px 10px;
    font-size:14px;
}

/* SALARY BRACKET LAYOUT */
.bracket-cell{
    display:grid;
    grid-template-columns: 1fr 1px 1fr;
    align-items:center;
    gap:12px;
}

/* DIVIDER BETWEEN MIN MAX */
.divider{
    width:1px;
    height:40px;
    background:#e5e7eb;
}
input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Firefox */
input[type="number"] {
    -moz-appearance: textfield;
}
.salary-table-wrapper {
    border-radius: 12px;
}
@media (max-width: 1150px) {
    .salary-table-wrapper {
        width: 90%;
        margin-left: 60px;
    }
}

@media (max-width: 900px) {
    .salary-table-wrapper {
        margin-left: 75px;
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

@media (max-width:600px) {
    .salary-table-wrapper {
        margin-left: 60px;
        width: 110%;
    }
}

@media (max-width:480px) {
    .salary-table-wrapper {
        margin-left: 80px;
        width: 150%;       
    }
}
</style>

</x-app>
