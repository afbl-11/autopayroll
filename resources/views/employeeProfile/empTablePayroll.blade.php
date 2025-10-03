<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Employee Payroll Page</title> 
  @vite(['resources/css/employeeProfile/empTablePayroll.css', 'resources/js/employeeProfile/app.js'])
</head>
<body>   
  <div class="sidebar">@include('layout.sidebar')</div>   
  <div class="header">@include('layout.header')</div>
    <main class="page">
        
    <section class="card">
      <div class="table-wrap" role="region" aria-label="Payroll history table" tabindex="0">
        <table class="payroll-table">
          <thead>
            <tr>
              <th scope="col">Pay Date</th>
              <th scope="col">Days of Work</th>
              <th scope="col">Overtime</th>
              <th scope="col">Gross Earning</th>
              <th scope="col">Deductions</th>
              <th scope="col">Net Pay</th>
              <th scope="col">Status</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>{{$variable}}</td> <!-- In the design, variable here is "June 1 - 15, 2025" -->
              <td class="num">{{$variable}}</td> <!-- In the design, variable here is "15" -->
              <td class="num">{{$variable}}</td> <!-- In the design, variable here is "3,086.9" -->
              <td class="num">{{$variable}}</td> <!-- In the design, variable here is "8,981.9" -->
              <td class="num">{{$variable}}</td> <!-- In the design, variable here is "5,000.00" -->
              <td class="num">{{$variable}}</td> <!-- In the design, variable here is "25,000.00" -->
              <td class="status-cell processing">{{$variable}}</td> <!-- In the design, variable here is "Processing/Settled" (code for processing: "status-cell processing", code for settled: "status-cell settled") -->
            </tr>
          </tbody>
        </table>
      </div>
    </section>
    <div class="pager-wrap">
      <button class="pager" type="button" aria-label="Next page">
        <span>Next Page</span>
        <span class="arrow" aria-hidden="true">›</span>
      </button>
    </div>
  </main>

</body>
</html>