<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Employee Payroll Page</title> 
  @vite(['resources/css/employeeProfile/empPayroll.css', 'resources/js/employeeProfile/empPayroll.js'])
</head>
<body>   
  <div class="sidebar">@include('layout.sidebar')</div>   
    <main>
        @include('layout.header')
        <section class="payroll-history">
          <div class="period-bar">{{$variable}}</div> <!-- In the design, variable here is "June 1 - June 15, 2025" -->
          <div class="payroll-card kpi-card">
            <div class="kpi-grid">
              <div class="kpi">
                <div class="kpi-label">Days of Work</div>
                <div class="kpi-value">{{$variable}}</div> <!-- In the design, variable here is "15" -->
              </div>
              <div class="kpi">
                <div class="kpi-label">Rate</div>
                <div class="kpi-value">{{$variable}}</div> <!-- In the design, variable here is "645.00" -->
              </div>
              <div class="kpi">
                <div class="kpi-label">Total Regular Rate</div>
                <div class="kpi-value">{{$variable}}</div> <!-- In the design, variable here is "5,895.00" -->
              </div>
              <div class="kpi">
                <div class="kpi-label">Overtime Pay</div>
                <div class="kpi-value">{{$variable}}</div> <!-- In the design, variable here is "3,086.9" -->
              </div>
              <div class="kpi">
                <div class="kpi-label">Gross Salary</div>
                <div class="kpi-value">{{$variable}}</div> <!-- In the design, variable here is "8,981.9" -->
              </div>
              <div class="kpi">
                <div class="kpi-label">Deductions</div>
                <div class="kpi-value">{{$variable}}</div> <!-- In the design, variable here is "3,635.75" -->
              </div>
              <div class="kpi">
                <div class="kpi-label">Net Salary</div>
                <div class="kpi-value strong">{{$variable}}</div> <!-- In the design, variable here is "5,346.15" -->
              </div>
            </div>
          </div>

          <div class="payroll-grid-2">
            <div class="payroll-card list-card" id="deductions-card">
              <div class="card-header">
                    <h3 class="card-title">Deductions</h3>
                      <div class="top-buttons">
                        <button onclick="toggleEdit('deductions-card')" id="btn" class="edit-btn">
                          <img src="{{ asset('images/edit_icon.png') }}"> Edit Payroll
                        </button>
                        <button onclick="undoChange('deductions-card')" id="btn" class="undo-btn" style="display:none;">
                          <img src="{{ asset('images/undo.png') }}"> Undo</button>
                        <button onclick="redoChange('deductions-card')" id="btn" class="redo-btn" style="display:none;">
                          <img src="{{ asset('images/redo.png') }}"> Redo</button>
                      </div>
                </div>
              <div class="list two-col">  
                <div>
                  <div class="row">
                    <div class="label">Phil-Health</div>
                    <div class="amount-wrap"><input type="text" class="amount-input" value="{{$variable}}" readonly></div>
                  </div>

                  <div class="row">
                    <div class="label">Cash Bond</div>
                    <div class="amount-wrap"><input type="text" class="amount-input" value="{{$variable}}" readonly></div>
                  </div>

                  <div class="row">
                    <div class="label">Social Security System (SSS)</div>
                    <div class="amount-wrap"><input type="text" class="amount-input" value="{{$variable}}" readonly></div>
                  </div>
                </div>

                <div>
                  <div class="row">
                    <div class="label">Pag Ibig Loan</div>
                    <div class="amount-wrap"><input type="text" class="amount-input" value="{{$variable}}" readonly></div>
                  </div>

                  <div class="row">
                    <div class="label">Late</div>
                    <div class="amount-wrap"><input type="text" class="amount-input" value="{{$variable}}" readonly></div>
                  </div>
                </div>

                <div class="last-row">
                <div class="row total">
                      <div class="label">TOTAL</div>
                      <div class="amount-wrap"><input type="text" class="amount-input" value="{{$variable}}" readonly></div>
                </div>
              </div>
              </div>
              <div class="bottom-buttons" style="display: none;">
                <button onclick="saveChanges('deductions-card')" id="btn" class="save-btn">
                  <img src="{{ asset('images/save_icon.png') }}"> Save</button> 
                <button onclick="cancelEdit('deductions-card')" id="btn" class="cancel-btn">Cancel</button>
              </div>
            </div>

            <div class="payroll-card list-card" id="additional-hours">
                <div class="card-header">
                    <h3 class="card-title">Additional Hours Compensation</h3>
                    <div class="top-buttons">
                        <button onclick="toggleEdit('additional-hours')" id="btn" class="edit-btn">
                          <img src="{{ asset('images/edit_icon.png') }}"> Edit Payroll
                        </button>
                        <button onclick="undoChange('additional-hours')" id="btn" class="undo-btn" style="display:none;">
                          <img src="{{ asset('images/undo.png') }}"> Undo</button>
                        <button onclick="redoChange('additional-hours')" id="btn" class="redo-btn" style="display:none;">
                          <img src="{{ asset('images/redo.png') }}"> Redo</button>
                      </div>
                </div>
              <div class="list single-col">
                <div class="row">
                  <div class="label">Overtime Pay</div>
                  <div class="amount-wrap"><input type="text" class="amount-input" value="{{$variable}}" readonly></div>
                </div>

                <div class="row">
                  <div class="label">Night Differential</div>
                  <div class="amount-wrap"><input type="text" class="amount-input" value="{{$variable}}" readonly></div>
                </div>

                <div class="row">
                  <div class="label">Holiday</div>
                  <div class="amount-wrap"><input type="text" class="amount-input" value="{{$variable}}" readonly></div>
                </div>

                <div class="row total">
                  <div class="label">TOTAL</div>
                  <div class="amount-wrap"><input type="text" class="amount-input" value="{{$variable}}" readonly></div>
                </div>
              </div>
              <div class="bottom-buttons" style="display: none;">
                <button onclick="saveChanges('additional-hours')" id="btn" class="save-btn">
                  <img src="{{ asset('images/save_icon.png') }}"> Save</button>
                <button onclick="cancelEdit('additional-hours')" id="btn" class="cancel-btn">Cancel</button>
              </div>
            </div>
                  </main>
          </div>
</body>
</html>