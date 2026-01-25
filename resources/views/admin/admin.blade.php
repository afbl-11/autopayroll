    @vite(['resources/css/admin_dashboard/dashboard.css','resources/css/employee_dashboard/leave-request.css', 'resources/js/app.js', 'resources/css/theme.css','resources/css/includes/sidebar.css'])
<x-app title="Dashboard" :user="$data['adminFirstName']" :admin="true" >
        <div class="main">
                <div class="summary-wrapper">
                    <div class="header">
                        <h6>Payroll Summary</h6>
                    </div>
                    <div class="table-data">
                        <div class="data-wrapper">
                            <div class="table-item">
                                <h6>Employees</h6>
                                <div class="data">
                                    <h4>{{$data['employee_count']}}</h4>
                                </div>
                            </div>
                            <div class="table-item">
                                <h6>Total Payroll</h6>
                                <div class="data">
                                    <h4>{{$data['total_payroll']}}</h4>
                                </div>
                            </div>
                            <div class="table-item">
                                <h6>Total Deductions</h6>
                                <div class="data">
                                    <h4>{{$data['total_deductions']}}</h4>
                                </div>
                            </div>
                            <div class="table-item">
                                <h6>Upcoming Pay Date</h6>
                                <div class="data">
                                    <h4>{{ \Carbon\Carbon::parse($data['end_period'])->addDays(10)->format('Y-m-d') }}</h4> {{-- Lagay ko lang dito --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section">
                    <div class="attendance-overview">
                        <h6>Attendance Overview</h6>
                        <div class="attendance-list">
                            @forelse($attendance as $log)
                                @php
                                    $attendance = $log->attendanceLogs->first();
                                @endphp
                                <x-attendance-overview
                                    source="employee.dashboard.attendance"
                                    :employeeId="$log->employee_id"
                                    :name="$log->first_name .' ' . $log->last_name"
                                    :profile="$log->profile_photo
                                    ? 'storage/' . $log->profile_photo
                                    : 'assets/no_profile_picture.jpg'"
                                    :status="$attendance?->status"
                                />
                            @empty
                                <p>No Record Found</p>
                            @endforelse
                        </div>
                    </div>
                    <div class="manpower-distribution">
                        <h6>Manpower Distribution</h6>

                        <div class="table-headers">
                            <p>Company</p>
                            <p>Industry</p>
                            <p>Manpower</p>
                            <p>Payroll</p>
                        </div>

                        <div class="company-cards-wrapper">
                            @foreach($data['company'] as $companies)
                                <div class="company-cards" onclick="window.location.href='{{route('company.dashboard.detail', ['id' => $companies->company_id])}}'">
                                    <div class="card-data">{{ $companies->company_name }}</div>
                                    <div class="card-data">{{ $companies->industry }}</div>
                                    <div class="card-data">{{ $companies->employees_count }}</div>
                                    <div class="card-data">{{ $companies->companyPayroll}}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

                <div class="requests">
                    <div class="leave-requests">
                        <h6>Leave Requests</h6>
                        <div class="requests-wrapper">
                            <div class="request-cards">
                            @forelse($employee as $leaves)
                                <x-leave-card
                                    source="employee.leave.detail"
                                    :leaveId="$leaves->leave_request_id"
                                    :employeeId="$leaves->employee_id"
                                    :leave_type="$leaves->leave_type"
                                    :message="$leaves->reason"
                                    :date="\Carbon\Carbon::parse($leaves->submission_date)->format('Y-m-d')"
{{--                                    :status="$leaves->status"--}}
                                />
                            @empty
                                <p id="empty" >Employee currently don't have a request</p>
                            @endforelse
                            </div>
                        </div>
                    </div>
{{--                    credit adjustments request--}}
                    <div class="leave-requests">
                        <h6>Adjustment Requests</h6>
                        <div class="requests-wrapper">
                            <div class="request-cards">
                                @forelse($adjustment as $request)
                                    <x-leave-card
                                        source="adjustments"
                                        :leaveId="$request->adjustment_id"
                                        :employeeId="$request->employee_id"
                                        :leave_type="$request->adjustment_type"
                                        :message="$request->reason"
                                        :date="\Carbon\Carbon::parse($request->created_at)->format('Y-m-d')"
{{--                                        :status="$request->status"--}}
                                    />
                                @empty
                                    <p id="empty" >Employee currently don't have a request</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

        </div>
</x-app>

