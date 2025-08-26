function toggleMenu(menuId) {
var menu = document.getElementById(menuId);
menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
}

function deleteEmployee(employeeId) {
    var employeeCard = document.querySelector('.employee-card[data-employee-id="' + employeeId + '"]');
    if (employeeCard) {
        employeeCard.remove();
        alert("Employee " + employeeId + " deleted");
    }
}

document.getElementById('company-filter').addEventListener('change', filterEmployees);
document.getElementById('status-filter').addEventListener('change', filterEmployees);
document.getElementById('company-filter').addEventListener('change', updateEmployeeTitle);

function updateEmployeeTitle() {
    var companyFilter = document.getElementById('company-filter').value;
    var title = document.getElementById('employee-title'); 

    if (companyFilter === 'all') {
        title.innerText = 'All Employees'; 
    } else {
        title.innerText = companyFilter; 
    }

    filterEmployees();
}

function filterEmployees() {
    var companyFilter = document.getElementById('company-filter').value;
    var statusFilter = document.getElementById('status-filter').value;

    var employeeCards = document.querySelectorAll('.employee-card');

    employeeCards.forEach(function(card) {
        var cardCompany = card.getAttribute('data-company');
        var cardStatus = card.getAttribute('data-status');

        var showCard = true;

        // Filter by company
        if (companyFilter !== 'all' && cardCompany !== companyFilter) {
            showCard = false;
        }

        // Filter by status
        if (statusFilter !== 'all' && cardStatus !== statusFilter) {
            showCard = false;
        }

        if (showCard) {
            card.style.display = 'block'; 
        } else {
            card.style.display = 'none'; 
        }
    });
}
