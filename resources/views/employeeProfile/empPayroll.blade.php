<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sidebar + Employee Header</title> 
  @vite(['resources/css/employeeProfile/empPayroll.css', 'resources/js/app.js'])
</head>
<body>   
  <div class="sidebar">@include('layout.sidebar')</div>   
    <main>
        @include('layout.header')
        <section class="payroll-history">
          <div class="period-bar">June 1 - June 15, 2025</div>
          <div class="payroll-card kpi-card">
            <div class="kpi-grid">
              <div class="kpi">
                <div class="kpi-label">Days of Work</div>
                <div class="kpi-value">15</div>
              </div>
              <div class="kpi">
                <div class="kpi-label">Rate</div>
                <div class="kpi-value">645.00</div>
              </div>
              <div class="kpi">
                <div class="kpi-label">Total Regular Rate</div>
                <div class="kpi-value">5,895.00</div>
              </div>
              <div class="kpi">
                <div class="kpi-label">Overtime Pay</div>
                <div class="kpi-value">3,086.9</div>
              </div>
              <div class="kpi">
                <div class="kpi-label">Gross Salary</div>
                <div class="kpi-value">8,981.9</div>
              </div>
              <div class="kpi">
                <div class="kpi-label">Deductions</div>
                <div class="kpi-value">3,635.75</div>
              </div>
              <div class="kpi">
                <div class="kpi-label">Net Salary</div>
                <div class="kpi-value strong">5,346.15</div>
              </div>
            </div>
          </div>

          <div class="payroll-grid-2">
            <div class="payroll-card list-card">
              <h3 class="card-title" id="deductions">Deductions</h3>
              <div class="list two-col">  
                <div>
                  <div class="row">
                    <div class="label">Phil-Health</div>
                    <div class="amount-wrap"><input type="text" class="amount-input" value="354.75" readonly></div>
                  </div>

                  <div class="row">
                    <div class="label">Cash Bond</div>
                    <div class="amount-wrap"><input type="text" class="amount-input" value="354.75" readonly></div>
                  </div>

                  <div class="row">
                    <div class="label">Social Security System (SSS)</div>
                    <div class="amount-wrap"><input type="text" class="amount-input" value="354.75" readonly></div>
                  </div>

                  <div class="row total">
                    <div class="label">TOTAL</div>
                    <div class="amount-wrap"><input type="text" class="amount-input" value="3,635.75" readonly></div>
                  </div>
                </div>

                <div>
                  <div class="row">
                    <div class="label">Pag Ibig Loan</div>
                    <div class="amount-wrap"><input type="text" class="amount-input" value="354.75" readonly></div>
                  </div>

                  <div class="row">
                    <div class="label">Late</div>
                    <div class="amount-wrap"><input type="text" class="amount-input" value="354.75" readonly></div>
                  </div>
                </div>
              </div>
            </div>

            <div class="payroll-card list-card" id="additional-hours">
                <div class="card-header">
                    <h3 class="card-title">Additional Hours Compensation</h3>
                    <button onclick="toggleEdit()" class="edit-btn">
                      <img src="{{ asset('images/edit_icon.png') }}"> Edit Payroll
                    </button>
                </div>
              <div class="list single-col">
                <div class="row">
                  <div class="label">Overtime Pay</div>
                  <div class="amount-wrap"><input type="text" class="amount-input" value="1,171.9" readonly></div>
                </div>

                <div class="row">
                  <div class="label">Night Differential</div>
                  <div class="amount-wrap"><input type="text" class="amount-input" value="625.00" readonly></div>
                </div>

                <div class="row">
                  <div class="label">Holiday</div>
                  <div class="amount-wrap"><input type="text" class="amount-input" value="1,290.00" readonly></div>
                </div>

                <div class="row total">
                  <div class="label">TOTAL</div>
                  <div class="amount-wrap"><input type="text" class="amount-input" value="3,086.9" readonly></div>
                </div>
              </div>
            </div>
                  </main>
          </div>

  <script>
    function toggleEdit() {
      const section = document.getElementById("additional-hours");
      const inputs = section.querySelectorAll("input.amount-input");

      inputs.forEach(input => {
    input.readOnly = !input.readOnly;

    if (!input.readOnly) {
      input.addEventListener("input", function () {
        this.value = this.value.replace(/[^0-9.]/g, ""); 
      });

      input.addEventListener("blur", function () {
            let num = parseFloat(this.value.replace(/,/g, ""));
            if (!isNaN(num)) {
              this.value = num.toLocaleString("en-US", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
              });
            } else {
              this.value = "0.00"; 
            }
          });
        }
      });

      const btn = section.querySelector(".edit-btn");
      btn.innerHTML = inputs[0].readOnly
        ? "<img src='{{ asset('images/edit_icon.png') }}'> Edit Payroll"
        : "Save Changes";
    }
  </script>
</body>
</html>