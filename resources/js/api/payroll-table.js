document.addEventListener("DOMContentLoaded", () => {

    const table = new Tabulator("#payroll-table", {
        ajaxURL: "/api/payroll/{{ $employee_id }}",
        layout: "fitColumns",
        reactiveData: true,
        columns: [
            {title:"Description", field:"description"},
            {title:"Hours", field:"hours", editor:"input"},
            {title:"Rate", field:"rate", editor:"input"},
            {title:"Amount", field:"amount", editor:"input"},
        ],
        cellEdited:function(cell){
            const row = cell.getRow().getData();

            fetch(`/api/payroll/update/${row.id}`,{
                method:"POST",
                headers:{
                    "Content-Type":"application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body:JSON.stringify(row)
            });
        }
    });

});
