<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sidebar + Employee Header</title>
  @vite(['resources/css/employeeProfile/empLeave.css', 'resources/js/app.js'])
</head>
<body class="rev-body">
  <div class="rev-wrap">
    <div class="rev-card">
      <button class="rev-close" aria-label="Close" onclick="window.history.back()">✕</button>

      <h1 class="rev-title">Revision Request</h1>

      <label class="rev-label" for="rev-reason">Reason for revision</label>
      <div class="rev-select-wrap">
        <select id="rev-reason" class="rev-select">
          <option>Missing Attachment</option>
          <option>Unclear Reason for Leave</option>
          <option>Policy Violations</option>
          <option>Incorrect Leave Dates</option>
        </select>
        <span class="rev-caret">▾</span>
      </div>

      <textarea 
        class="rev-textarea" 
        rows="8" 
        placeholder="Type your message to the requester here...">
Your leave request is missing the required supporting document, a medical certificate or official letter. Please upload the necessary file and resubmit for review. <!-- default text -->
      </textarea>

      <button class="rev-send" type="button" onclick="submitRevision()">
        <span>Send</span>
        <span class="rev-arrow">➜</span>
      </button>
    </div>
  </div>

  <script>
    function submitRevision() {
      alert('Revision sent!');
      window.history.back(); 
    }
    document.querySelectorAll('.rev-side-item').forEach(btn => {
      btn.addEventListener('click', () => {
        document.getElementById('rev-reason').value = btn.textContent;
      });
    });
  </script>
</body>
</html>