<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sidebar + Employee Header</title>
  @vite(['resources/css/employeeProfile/empLeave.css', 'resources/js/app.js'])
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
            <div class="date-range">June 1 - June 15, 2025</div>
        </div>

        <div class="summary-metrics">
            <div class="metric">
            <p class="label">Days Off</p>
            <p class="value">5</p>
            <p class="delta"><span class="num negative">-5</span> <span class="vs-text">vs last month</span></p>
            </div>
            <div class="metric">
            <p class="label">Late clock-in</p>
            <p class="value">5</p>
            <p class="delta"><span class="num negative">-5</span> <span class="vs-text">vs last month</span></p>
            </div>
            <div class="metric">
            <p class="label">Overtime</p>
            <p class="value">24hrs</p>
            <p class="delta"><span class="num negative">-10</span> <span class="vs-text">vs last month</span></p>
            </div>
            <div class="metric">
            <p class="label">No clock-out</p>
            <p class="value">2</p>
            <p class="delta"><span class="num neutral">0</span> <span class="vs-text">vs last month</span></p>
            </div>
            <div class="metric">
            <p class="label">Day off balance</p>
            <p class="value">10</p>
            <p class="delta"><span class="num negative">-5</span> <span class="vs-text">vs last month</span></p>
            </div>
            <div class="metric">
            <p class="label">Absences</p>
            <p class="value">5</p>
            <p class="delta"><span class="num negative">-2</span> <span class="vs-text">vs last month</span></p>
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
                    
                    <!-- This is used for experimentation purposes like for testing if the file will be viewed in "View Attached File" -->
                    <input type="file" id="file-input" style="display: none" onchange="setFilePreview(event)">
                    
                    <a id="attached-link" href="javascript:void(0)" class="attached-link" onclick="chooseOrViewFile()">
                        View Attached File
                    </a>
                </div>
            </div>

            <aside class="leave-details-card">
            <div class="detail">
                <div class="label">Leave Request Number</div>
                <span class="inline-edit" contenteditable="true"
                    data-placeholder="e.g., 1000111223">1000111223</span>
            </div>

            <div class="detail">
                <div class="label">Leave Type</div>
                <span class="inline-edit" contenteditable="true"
                    data-placeholder="e.g., Vacation Leave">Vacation Leave</span>
            </div>

            <div class="detail">
                <div class="label">Filing Date</div>
                <span class="inline-edit" contenteditable="true"
                    data-placeholder="e.g., June 10, 2025">June 10, 2025</span>
            </div>

            <div class="detail">
                <div class="label">Leave Duration</div>
                <span class="inline-edit" contenteditable="true"
                    data-placeholder="e.g., June 15–20, 2025 (5 Days)">
                June 15 - 20, 2025 (5 Days)
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
<script>
    let fileUrl = null; 
        function chooseOrViewFile() {
        if (fileUrl) {
            window.open(fileUrl, '_blank');
        } else {
            alert("Employee doesn't have any attached file.");
        }
        }

        function setFilePreview(event) {
        const fileInput = event.target;

        if (fileInput.files.length > 0) {
            const file = fileInput.files[0];
            fileUrl = URL.createObjectURL(file);
            document.getElementById('attached-link').textContent = file.name;
        } else {
            fileUrl = null;
            document.getElementById('attached-link').textContent = "View Attached File";
        }
        }
</script>
</body>
</html>
