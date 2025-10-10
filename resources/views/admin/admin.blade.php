    @vite(['resources/css/admin_dashboard/dashboard.css', 'resources/js/app.js', 'resources/css/theme.css','resources/css/includes/sidebar.css'])
<x-app title="Dashboard" :user="$adminFirstName" :admin="true" >
        <div class="main">
            <div class="content">
                <div class="summary-wrapper">
                    <div class="header">
                        <h5>Payroll Summary</h5>
                    </div>

                    <div class="table-data">
                        <div class="data-wrapper">
                            <div class="table-item">
                                <h6>Paid Employees</h6>
                                <div class="data">
                                    <h4>{{$employee_count}}</h4>
                                </div>
                            </div>
                            <div class="table-item">
                                <h6>Total Payroll</h6>
                                <div class="data">
                                    <h4>{{$total_payroll}}</h4>
                                </div>
                            </div>
                            <div class="table-item">
                                <h6>Total Deductions</h6>
                                <div class="data">
                                    <h4>{{$total_deductions}}</h4>
                                </div>
                            </div>
                            <div class="table-item">
                                <h6>Upcoming Pay Date</h6>
                                <div class="data">
                                    <h4>{{$end_period}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section">

                    <div class="attendance-overview">
                        <h5>Attendance Overview</h5>
                        <div class="attendance-data">
                            <h6>Number of Absences</h6>
                            <h6 class="value">-</h6>
                        </div>
                        <div class="attendance-data">
                            <h6>Early Clock-ins</h6>
                            <h6 class="value">-</h6>
                        </div>
                        <div class="attendance-data">
                            <h6>Late Cock-ins</h6>
                            <h6 class="value">-</h6>
                        </div>
                        <div class="attendance-data">
                            <h6>Overtimes Logged</h6>
                            <h6 class="value">-</h6>
                        </div>

                    </div>
                    <div class="manpower-distribution">
                        <h5>Manpower Distribution</h5>

                        <div class="table-headers">
                            <p>Company</p>
                            <p>Address</p>
                            <p>Manpower</p>
                        </div>

                        <div class="company-cards-wrapper">
                            @foreach($company as $companies)
                                <div class="company-cards">
                                    <div class="card-data">{{ $companies->company_name }}</div>
                                    <div class="card-data" id="company_address">
                                        <small>{{ $companies->city . ', ' . $companies->barangay }}</small>
                                    </div>
                                    <div class="card-data">{{ $companies->employees_count }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

                <div class="leave-requests">
                    <h5>Leave Requests</h5>
                    <div class="requests-wrapper">
                        <p>No Leave Requests</p>
                    </div>
                    <small id="small">End of List</small>
                </div>
            </div>
        </div>
</x-app>

