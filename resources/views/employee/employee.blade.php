<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Employee</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="employee.css">
</head>
<body>

    <div class="whole-container">

        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="brand">
                <span class="brand-letter">A</span><span class="brand-letter highlight">P</span>
                <span class="full-name">Auto</span><span class="highlight">Payroll</span>
            </div>
            <nav class="nav">
                <a href="#" class="nav-item">
                    <span class="icon fa fa-home"></span>
                    <span class="label">Home</span>
                </a>
                <a href="#" class="nav-item">
                    <span class="icon fa fa-users"></span>
                    <span class="label">Employee</span>
                </a>
                <a href="#" class="nav-item">
                    <span class="icon fa fa-newspaper"></span>
                    <span class="label">Compliance</span>
                </a>
                <a href="#" class="nav-item">
                    <span class="icon fa fa-bell"></span>
                    <span class="label">Notifications</span>
                </a>
                <a href="#" class="nav-item">
                    <span class="icon fa fa-user"></span>
                    <span class="label">Admin</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main>
            <div class="employee-section">
                <h1 class="employee-title">Employee</h1>
                <div class="filters-container">
                    <div class="search-container">
                     <input type="text" class="search-input" placeholder="Search">
                     <span class="search-icon">
                     <i class="fa fa-search"></i> <!-- FontAwesome for the search icon -->
                     </span>
                    </div>  

                    <select class="company-select" id="company-filter">
                        <option disabled selected>Company</option>
                        <option value="all">All Employees</option>
                        <option value="Wilson Trading Inc.">Wilson Trading Inc.</option>
                        <option value="FreshMart Mini Grocery">FreshMart Mini Grocery</option>
                        <option value="MetroCore Legal Services">MetroCore Legal Services</option>
                        <option value="FuelHaus Marketing">FuelHaus Marketing Co.</option>
                        <option value="GrocerEase Minimart">GrocerEase Minimart</option>
                    </select>

                    <select class="company-select" id="status-filter">
                        <option disabled selected>Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>

                    <button class="add-employee">Add Employee</button>
                </div>
            </div>

          <h2 id="employee-title">All Employees</h2>

            <!-- Employee Card Grid -->
            <div class="employee-card-grid">
                <!-- Employee Cards Here -->
                <div class="employee-card" data-employee-id="1" data-company="Wilson Trading Inc." data-status="active">
                    
                    <!-- Menu Icon -->
                    <div class="menu-icon" onclick="toggleMenu('menu1')">
                        <span class="menu-circle"></span>
                        <span class="menu-circle"></span>
                        <span class="menu-circle"></span>
                    </div>

                    <!-- Dropdown Menu -->
                    <div id="menu1" class="menu">
                        <button onclick="deleteEmployee('1')" class="delete-button">Delete</button>
                    </div>

                    <!-- Employee Status -->
                    <div id="status" data-id="1" class="status" onclick="toggleStatus(this)">
                        <span id="status-circle" class="status-circle"></span>
                        <span id="status-text" class="status-text">Active</span>
                    </div>

                    <!-- Employee Image -->
                    <div class="image-container">
                        <img src="https://cdn.punchng.com/wp-content/uploads/2024/05/09102910/Bongbong-Marcos.webp" alt="Employee Image" class="employee-image">
                    </div>

                    <!-- Employee Name and Position -->
                    <h3 class="employee-name">Marc Jurell Afable</h3>
                    <p class="employee-position">Janitor</p>

                    <!-- Employee ID and Additional Info -->
                    <div class="employee-id-container">
                        <p class="employee-id">#EMP1001</p>
                        <div class="employee-details">
                            <span class="employee-role">Janitor</span>
                            <span class="employee-fulltime">
                                <img src="https://img.icons8.com/ios-filled/50/000000/clock.png" alt="Clock Icon" class="clock-icon">
                                Fulltime
                            </span>
                        </div>
                        <div class="employee-contact">
                            <img src="identification-card.png" alt="Identification Icon" class="identification-icon">
                            <a href="mailto:jurellAfable@gmail.com" class="email-link">jurellAfable@gmail.com</a>
                        </div>
                    </div>

                    <!-- Footer Section -->
                    <div class="employee-footer">
                        <p class="join-date">Joined at: July, 2024</p>
                        <a href="#" class="view-details">View Details</a>
                    </div>
                </div>

                <div class="employee-card" data-employee-id="2" data-company="FreshMart Mini Grocery" data-status="active">
                    
                    <!-- Menu Icon -->
                    <div class="menu-icon" onclick="toggleMenu('menu2')">
                        <span class="menu-circle"></span>
                        <span class="menu-circle"></span>
                        <span class="menu-circle"></span>
                    </div>

                    <!-- Dropdown Menu -->
                    <div id="menu2" class="menu">
                        <button onclick="deleteEmployee('2')" class="delete-button">Delete</button>
                    </div>

                    <!-- Employee Status -->
                    <div id="status" data-id="2" class="status" onclick="toggleStatus(this)">
                        <span id="status-circle" class="status-circle"></span>
                        <span id="status-text" class="status-text">Active</span>
                    </div>

                    <!-- Employee Image -->
                    <div class="image-container">
                        <img src="https://cdn.punchng.com/wp-content/uploads/2024/05/09102910/Bongbong-Marcos.webp" alt="Employee Image" class="employee-image">
                    </div>

                    <!-- Employee Name and Position -->
                    <h3 class="employee-name">Marc Jurell Afable</h3>
                    <p class="employee-position">Janitor</p>

                    <!-- Employee ID and Additional Info -->
                    <div class="employee-id-container">
                        <p class="employee-id">#EMP1001</p>
                        <div class="employee-details">
                            <span class="employee-role">Janitor</span>
                            <span class="employee-fulltime">
                                <img src="https://img.icons8.com/ios-filled/50/000000/clock.png" alt="Clock Icon" class="clock-icon">
                                Fulltime
                            </span>
                        </div>
                        <div class="employee-contact">
                            <img src="identification-card.png" alt="Identification Icon" class="identification-icon">
                            <a href="mailto:jurellAfable@gmail.com" class="email-link">jurellAfable@gmail.com</a>
                        </div>
                    </div>

                    <!-- Footer Section -->
                    <div class="employee-footer">
                        <p class="join-date">Joined at: July, 2024</p>
                        <a href="#" class="view-details">View Details</a>
                    </div>
                </div>

                <div class="employee-card" data-employee-id="3" data-company="MetroCore Legal Services" data-status="active">
                    
                    <!-- Menu Icon -->
                    <div class="menu-icon" onclick="toggleMenu('menu3')">
                        <span class="menu-circle"></span>
                        <span class="menu-circle"></span>
                        <span class="menu-circle"></span>
                    </div>

                    <!-- Dropdown Menu -->
                    <div id="menu3" class="menu">
                        <button onclick="deleteEmployee('3')" class="delete-button">Delete</button>
                    </div>

                    <!-- Employee Status -->
                    <div id="status" data-id="3" class="status" onclick="toggleStatus(this)">
                        <span id="status-circle" class="status-circle"></span>
                        <span id="status-text" class="status-text">Active</span>
                    </div>

                    <!-- Employee Image -->
                    <div class="image-container">
                        <img src="https://cdn.punchng.com/wp-content/uploads/2024/05/09102910/Bongbong-Marcos.webp" alt="Employee Image" class="employee-image">
                    </div>

                    <!-- Employee Name and Position -->
                    <h3 class="employee-name">Marc Jurell Afable</h3>
                    <p class="employee-position">Janitor</p>

                    <!-- Employee ID and Additional Info -->
                    <div class="employee-id-container">
                        <p class="employee-id">#EMP1001</p>
                        <div class="employee-details">
                            <span class="employee-role">Janitor</span>
                            <span class="employee-fulltime">
                                <img src="https://img.icons8.com/ios-filled/50/000000/clock.png" alt="Clock Icon" class="clock-icon">
                                Fulltime
                            </span>
                        </div>
                        <div class="employee-contact">
                            <img src="identification-card.png" alt="Identification Icon" class="identification-icon">
                            <a href="mailto:jurellAfable@gmail.com" class="email-link">jurellAfable@gmail.com</a>
                        </div>
                    </div>

                    <!-- Footer Section -->
                    <div class="employee-footer">
                        <p class="join-date">Joined at: July, 2024</p>
                        <a href="#" class="view-details">View Details</a>
                    </div>
                </div>

                <div class="employee-card" data-employee-id="8" data-company="GrocerEase Minimart" data-status="active">
                    
                    <!-- Menu Icon -->
                    <div class="menu-icon" onclick="toggleMenu('menu8')">
                        <span class="menu-circle"></span>
                        <span class="menu-circle"></span>
                        <span class="menu-circle"></span>
                    </div>

                    <!-- Dropdown Menu -->
                    <div id="menu8" class="menu">
                        <button onclick="deleteEmployee('8')" class="delete-button">Delete</button>
                    </div>

                    <!-- Employee Status -->
                    <div id="status" data-id="8" class="status" onclick="toggleStatus(this)">
                        <span id="status-circle" class="status-circle"></span>
                        <span id="status-text" class="status-text">Active</span>
                    </div>

                    <!-- Employee Image -->
                    <div class="image-container">
                        <img src="https://cdn.punchng.com/wp-content/uploads/2024/05/09102910/Bongbong-Marcos.webp" alt="Employee Image" class="employee-image">
                    </div>

                    <!-- Employee Name and Position -->
                    <h3 class="employee-name">Marc Jurell Afable</h3>
                    <p class="employee-position">Janitor</p>

                    <!-- Employee ID and Additional Info -->
                    <div class="employee-id-container">
                        <p class="employee-id">#EMP1001</p>
                        <div class="employee-details">
                            <span class="employee-role">Janitor</span>
                            <span class="employee-fulltime">
                                <img src="https://img.icons8.com/ios-filled/50/000000/clock.png" alt="Clock Icon" class="clock-icon">
                                Fulltime
                            </span>
                        </div>
                        <div class="employee-contact">
                            <img src="identification-card.png" alt="Identification Icon" class="identification-icon">
                            <a href="mailto:jurellAfable@gmail.com" class="email-link">jurellAfable@gmail.com</a>
                        </div>
                    </div>

                    <!-- Footer Section -->
                    <div class="employee-footer">
                        <p class="join-date">Joined at: July, 2024</p>
                        <a href="#" class="view-details">View Details</a>
                    </div>
                </div>

<script src="employee.js"></script>
</body>
</html>
