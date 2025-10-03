<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Employee Payroll Page</title> 
  @vite(['resources/css/employeeProfile/empTablePayroll.css', 'resources/js/employeeProfile/empPayroll.js'])
</head>
<body>   
  <div class="sidebar">@include('layout.sidebar')</div>   
    <main class="page">
        @include('layout.header')
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
              <td>June 1 – 15, 2025</td>
              <td class="num">15</td>
              <td class="num">3,086.9</td>
              <td class="num">8,981.9</td>
              <td class="num">5,000.00</td>
              <td class="num">25,000.00</td>
              <td class="status-cell processing">Processing</td>
            </tr>
            <tr>
              <td>May 15 – 30, 2025</td>
              <td class="num">9</td>
              <td class="num">3,086.9</td>
              <td class="num">8,981.9</td>
              <td class="num">5,000.00</td>
              <td class="num">25,000.00</td>
              <td class="status-cell settled">Settled</td>
            </tr>
            <tr>
              <td>May 1 – 15, 2025</td>
              <td class="num">9</td>
              <td class="num">3,086.9</td>
              <td class="num">8,981.9</td>
              <td class="num">5,000.00</td>
              <td class="num">25,000.00</td>
              <td class="status-cell settled">Settled</td>
            </tr>
            <tr>
              <td>April 15 – 30, 2025</td>
              <td class="num">9</td>
              <td class="num">3,086.9</td>
              <td class="num">8,981.9</td>
              <td class="num">5,000.00</td>
              <td class="num">25,000.00</td>
              <td class="status-cell settled">Settled</td>
            </tr>
            <tr>
              <td>April 1 – 15, 2025</td>
              <td class="num">9</td>
              <td class="num">3,086.9</td>
              <td class="num">8,981.9</td>
              <td class="num">5,000.00</td>
              <td class="num">25,000.00</td>
              <td class="status-cell settled">Settled</td>
            </tr>
            <tr>
              <td>March 15 – 30, 2025</td>
              <td class="num">9</td>
              <td class="num">3,086.9</td>
              <td class="num">8,981.9</td>
              <td class="num">5,000.00</td>
              <td class="num">25,000.00</td>
              <td class="status-cell settled">Settled</td>
            </tr>
            <tr>
              <td>March 1 – 15, 2025</td>
              <td class="num">9</td>
              <td class="num">3,086.9</td>
              <td class="num">8,981.9</td>
              <td class="num">5,000.00</td>
              <td class="num">25,000.00</td>
              <td class="status-cell settled">Settled</td>
            </tr>
            <tr>
              <td>Feb 15 – 30, 2025</td>
              <td class="num">9</td>
              <td class="num">3,086.9</td>
              <td class="num">8,981.9</td>
              <td class="num">5,000.00</td>
              <td class="num">25,000.00</td>
              <td class="status-cell settled">Settled</td>
            </tr>
            <tr>
              <td>Feb 1 – 15, 2025</td>
              <td class="num">9</td>
              <td class="num">3,086.9</td>
              <td class="num">8,981.9</td>
              <td class="num">5,000.00</td>
              <td class="num">25,000.00</td>
              <td class="status-cell settled">Settled</td>
            </tr>
            <tr>
              <td>Jan 15 – 30, 2025</td>
              <td class="num">9</td>
              <td class="num">3,086.9</td>
              <td class="num">8,981.9</td>
              <td class="num">5,000.00</td>
              <td class="num">25,000.00</td>
              <td class="status-cell settled">Settled</td>
            </tr>
            <tr>
              <td>Jan 1 – 15, 2025</td>
              <td class="num">9</td>
              <td class="num">3,086.9</td>
              <td class="num">8,981.9</td>
              <td class="num">5,000.00</td>
              <td class="num">25,000.00</td>
              <td class="status-cell settled">Settled</td>
            </tr>
            <tr>
              <td>Dec 15 – 30, 2024</td>
              <td class="num">9</td>
              <td class="num">3,086.9</td>
              <td class="num">8,981.9</td>
              <td class="num">5,000.00</td>
              <td class="num">25,000.00</td>
              <td class="status-cell settled">Settled</td>
            </tr>
            <tr>
              <td>Dec 1 – 25, 2024</td>
              <td class="num">9</td>
              <td class="num">3,086.9</td>
              <td class="num">8,981.9</td>
              <td class="num">5,000.00</td>
              <td class="num">25,000.00</td>
              <td class="status-cell settled">Settled</td>
            </tr>
            <tr>
              <td>Nov 15 – 30, 2024</td>
              <td class="num">9</td>
              <td class="num">3,086.9</td>
              <td class="num">8,981.9</td>
              <td class="num">5,000.00</td>
              <td class="num">25,000.00</td>
              <td class="status-cell settled">Settled</td>
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