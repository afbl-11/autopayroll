<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AutoPayroll Notification Module</title>
         @vite(['resources/css/notification/notificationCenter.css', 'resources/js/app.js'])
</head>
<body>
  @include('layout.sidebarAdmin')
  <div class ="container">
    <div class = "header">
        <h2>Notification Center</h2>
    </div>

    <div class="navBar">
        <div class = "item">
            <img src = "{{ asset('images/Dashboard.png') }}">
            <span>Dashboard</span>
        </div>

        <div class = "item">
            <img src = "{{ asset('images/Company_and_Broadcast.png') }}">
            <span>Company Broadcast</span>
        </div>

        <div class = "item">
            <img src = "{{ asset('images/Notif_and_Alerts.png') }}">
            <span>Notifications & Alerts</span>
        </div>
    </div>

    <hr class="divider">
    
        <div class="dateDropdown">
            <button class="dateButton">Date ᐁ</button>
            <div class="dates">
                <a href="#">Link 1</a>
                <a href="#">Link 2</a>
                <a href="#">Link 3</a>
            </div>
        </div>
                    
                  
        <div class="notifications">
                <div class="notificationName">
                    <p id="notifName">Company Policy Updates</p>
                </div>
                <div class = "notificationContent">
                    <p id="notifContent">Dear Team, We would like to inform you that starting July 1, 2025, several updates to our company policies will take effect. These changes are part of our ongoing efforts to improve workplace transparency, employee well-being, and operational efficiency.</p>
                </div>
                <div class = "rightSide">
                    <div class="notifDate">
                        <p id="date">6 - 2 - 2025</p>
                    </div>
                    <div class="details">
                        <a href=""><span class="textUnderline">View Detail</span><span class="arrow">></span></a> 
                    </div>
                </div>
            </div>

             <div class="notifications">
                <div class="notificationName">
                    <p id="notifName">Company Policy Updates</p>
                </div>
                <div class = "notificationContent">
                    <p id="notifContent">Dear Team, We would like to inform you that starting July 1, 2025, several updates to our company policies will take effect. These changes are part of our ongoing efforts to improve workplace transparency, employee well-being, and operational efficiency.</p>
                </div>
                <div class = "rightSide">
                    <div class="notifDate">
                        <p id="date">6 - 2 - 2025</p>
                    </div>
                    <div class="details">
                        <a href=""><span class="textUnderline">View Detail</span><span class="arrow">></span></a>
                    </div>
                </div>
            </div>

             <div class="notifications">
                <div class="notificationName">
                    <p id="notifName">Company Policy Updates</p>
                </div>
                <div class = "notificationContent">
                    <p id="notifContent">Dear Team, We would like to inform you that starting July 1, 2025, several updates to our company policies will take effect. These changes are part of our ongoing efforts to improve workplace transparency, employee well-being, and operational efficiency.</p>
                </div>
                <div class = "rightSide">
                    <div class="notifDate">
                        <p id="date">6 - 2 - 2025</p>
                    </div>
                    <div class="details">
                        <a href=""><span class="textUnderline">View Detail</span><span class="arrow">></span></a>
                    </div>
                </div>
            </div>

             <div class="notifications">
                <div class="notificationName">
                    <p id="notifName">Company Policy Updates</p>
                </div>
                <div class = "notificationContent">
                    <p id="notifContent">Dear Team, We would like to inform you that starting July 1, 2025, several updates to our company policies will take effect. These changes are part of our ongoing efforts to improve workplace transparency, employee well-being, and operational efficiency.</p>
                </div>
                <div class = "rightSide">
                    <div class="notifDate">
                        <p id="date">6 - 2 - 2025</p>
                    </div>
                    <div class="details">
                        <a href=""><span class="textUnderline">View Detail</span><span class="arrow">></span></a>
                    </div>
                </div>
            </div>
        </div>
</body>
</html>

