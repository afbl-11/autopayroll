<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sidebar + Employee Header</title>
  @vite(['resources/css/employeeProfile/empLeave.css', 'resources/js/employeeProfile/empLeave.js'])
</head>
<body>
  <div class="whole-container">
    <div class="sidebar">@include('layout.sidebar')</div>
    <div class="header">@include('layout.header')</div>
    
        <div class="summary-card">
        <div class="summary-top">
            <div class="tabs">
            <a href="#">Attendance</a>
            <a href="#">Time off</a>
            <a href="#">Absence</a>
            <a href="#" class="active">Request</a>
            </div>
            <div class="date-range">{{$variable}}</div> <!-- In the design, variable here is "June 1 - 15, 2025" -->
        </div>

        <div class="summary-metrics">
            <div class="metric">
            <p class="label">Days Off</p>
            <p class="value">{{$variable}}</p> <!-- In the design, variable here is "5" -->
            <p class="delta"><span class="num negative">{{$variable}}</span> <span class="vs-text">vs last month</span></p> <!-- In the design, variable here is "-5" -->
            </div>
            <div class="metric">
            <p class="label">Late clock-in</p>
            <p class="value">{{$variable}}</p> <!-- In the design, variable here is "5" -->
            <p class="delta"><span class="num negative">{{$variable}}</span> <span class="vs-text">vs last month</span></p><!-- In the design, variable here is "-5" -->
            </div>
            <div class="metric">
            <p class="label">Overtime</p>
            <p class="value">{{$variable}}</p> <!-- In the design, variable here is "24hrs" -->
            <p class="delta"><span class="num negative">{{$variable}}</span> <span class="vs-text">vs last month</span></p> <!-- In the design, variable here is "-10" -->
            </div>
            <div class="metric">
            <p class="label">No clock-out</p>
            <p class="value">{{$variable}}</p> <!-- In the design, variable here is "2" -->
            <p class="delta"><span class="num neutral">{{$variable}}</span> <span class="vs-text">vs last month</span></p> <!-- In the design, variable here is "0" -->
            </div>
            <div class="metric">
            <p class="label">Day off balance</p>
            <p class="value">{{$variable}}</p> <!-- In the design, variable here is "10" -->
            <p class="delta"><span class="num negative">{{$variable}}</span> <span class="vs-text">vs last month</span></p> <!-- In the design, variable here is "-5" -->
            </div>
            <div class="metric">
            <p class="label">Absences</p>
            <p class="value">{{$variable}}</p> <!-- In the design, variable here is "5" -->
            <p class="delta"><span class="num negative">{{$variable}}</span> <span class="vs-text">vs last month</span></p> <!-- In the design, variable here is "-2" -->
            </div>
        </div>
        </div>
    
        <div class="leave-two-col">
            <div class="left-col">
                <section class="leave-letter-card" contenteditable="true" 
                        data-placeholder="Type your leave request here...">
                </section>

            <div class="attached-row">
                <div class="attached-icon">📎</div>
                    <input type="file" id="file-input" accept=".pdf,.doc,.docx,image/*" style="display: none" onchange="setFilePreview(event)"> <!-- This is used for experimentation purposes like for testing if the file will be viewed in "View Attached File" -->
                    <a id="attached-link" href="javascript:void(0)" class="attached-link" onclick="chooseOrViewFile()">
                        View Attached File </a>
                    <span id="seen-status" class="status unseen"> </span>
                    <div id="preview-container"> </div>
                </div>
            </div> 

            <aside class="leave-details-card">
            <div class="detail">
                <div class="label">Leave Request Number</div>
                <span class="inline-edit" contenteditable="true"
                    data-placeholder="e.g., 1000111223">{{$variable}}</span>
            </div>

            <div class="detail">
                <div class="label">Leave Type</div>
                <span class="inline-edit" contenteditable="true"
                    data-placeholder="e.g., Vacation Leave">{{$variable}}</span>
            </div>

            <div class="detail">
                <div class="label">Filing Date</div>
                <span class="inline-edit" contenteditable="true"
                    data-placeholder="e.g., June 10, 2025">{{$variable}}</span>
            </div>

            <div class="detail">
                <div class="label">Leave Duration</div>
                <span class="inline-edit" contenteditable="true"
                    data-placeholder="e.g., June 15–20, 2025 (5 Days)">
                {{$variable}}
                </span>
            </div>

            <div class="leave-actions">
                <button class="btn approve" type="button">Approve Request</button>
                <div class="row">
                <button class="btn revise" onclick="" type="button">Send for Revision</button>
                <button class="btn reject" type="button">Reject Request</button>
                </div>
            </div>
        </aside>
    </div>
</body>
</html>