<x-app title="Edit Philhealth Deductions">
<link rel="stylesheet" href="{{ asset('css/salary-list.css') }}">

<div class="main-content">
    <div class="salary-list-containers">

        <div class="salary-table-wrapper">

            <form method="POST" action="">
                @csrf
                @method('PUT')
                <div class="table-responsive">
                    <table class="deduction-table">


                        <tbody>
                            <tr>
                                <td class="type-cell">Contribution Rate</td>
                                <td>
                                    <input type="number" step="0.01"
                                        name="philhealth_rate"
                                        value="{{ $settings->sss_employee_percent ?? '' }}">
                                </td>
                            </tr>

                                
                            <tr>
                                <td class="type-cell">Employee Share (%)</td>
                                
                                <td>
                                    <input type="number" step="0.01"
                                        name="sss_employee_percent"
                                        value="{{ $settings->sss_employee_percent ?? '' }}">
                                </td>
                            </tr>

                                
                            <tr>
                                <td class="type-cell">Employeer Share (%)</td>
                                <td>
                                    <input type="number" step="0.01"
                                        name="sss_employer_percent"
                                        value="{{ $settings->sss_employer_percent ?? '' }}">
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
    background: #7a7a7a;
    color:white;
    padding:12px;
    border:1px solid #d1d5db;
    font-weight:600;
}

/* CELLS */
.deduction-table td{
    border:1px solid #f1f1f1;
    padding:12px;
    vertical-align:middle;
}

/* TYPE COLUMN */
.type-cell{
    font-weight:600;
    color:black;
    background: #e7e7e7;
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
/* ---------- MOBILE (TABLE STACK STYLE) ---------- */
@media (max-width:800px){
    .salary-table-wrapper {
        margin-left: 50px;
    }
    .deduction-table{
        min-width:unset;
    }

    .deduction-table td{
        padding:10px;
        font-size:14px;
    }

    .type-cell{
        width:45%;
        font-size:14px;
    }

    .deduction-table input{
        height:36px;
        font-size:14px;
    }

    .save-btn-container{
        justify-content:center;
    }

    .save-btn{
        width:100%;
    }
}

@media (max-width: 700px) {
    .salary-table-wrapper {
        margin-left: 90px;
        width: 75%;
    }
}

/* ---------- EXTRA SMALL DEVICES ---------- */
@media (max-width:480px){
    .salary-table-wrapper {
        width: 70%;
    }
    /* Make rows stack */
    .deduction-table,
    .deduction-table tbody,
    .deduction-table tr,
    .deduction-table td{
        display:block;
        width:100%;
    }

    .deduction-table tr{
        border:1px solid #e5e7eb;
        border-radius:10px;
        margin-bottom:12px;
        overflow:hidden;
    }

    .type-cell{
        background:#e7e7e7;
        border-bottom:1px solid #e5e7eb;
        width:100%;
    }

    .deduction-table td{
        border:none;
        border-bottom:1px solid #f1f1f1;
    }

    .deduction-table td:last-child{
        border-bottom:none;
    }
}

</style>

</x-app>
