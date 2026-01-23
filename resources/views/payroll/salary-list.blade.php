<x-app title="Salary Management">
    <link rel="stylesheet" href="{{ asset('css/salary-list.css') }}">
    
    <div class="main-content">
        <div class="salary-list-container">
            <div class="salary-header">
                <h1 class="salary-page-title"></h1>
                
                <div class="salary-filter-controls">
                    <input type="text" 
                           id="searchInput"
                           class="salary-search-input" 
                           placeholder="Search employee..." 
                           value="{{ $searchTerm }}">
                    
                    <select id="companyFilter" class="filter-dropdown">
                        <option value="">All Companies</option>
                        <option value="part-time" {{ $companyFilter === 'part-time' ? 'selected' : '' }}>Part-time Employees</option>
                        @foreach($companies as $company)
                            <option value="{{ $company }}" {{ $companyFilter === $company ? 'selected' : '' }}>
                                {{ $company }}
                            </option>
                        @endforeach
                    </select>
                    
                    <button onclick="filterSalary()" class="btn-search">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
            </div>

            <div class="salary-table-wrapper">
                <table class="salary-table">
                    <thead>
                        <tr>
                            <th>Employee ID</th>
                            <th>Employee Name</th>
                            <th>Company</th>
                            <th>Employment Type</th>
                            <th>Current Daily Rate</th>
                            <th>Effective From</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $employee)
                            <tr>
                                <td class="employee-id">{{ $employee->employee_id }}</td>
                                <td class="employee-name">{{ $employee->first_name }} {{ $employee->last_name }}</td>
                                <td>
                                    @if($employee->employment_type === 'part-time')
                                        Part-time
                                    @else
                                        {{ $employee->company->company_name ?? 'N/A' }}
                                    @endif
                                </td>
                                <td>
                                    {{ ucfirst($employee->employment_type) }}
                                </td>
                                <td>
                                    @if($employee->currentRate)
                                        <span class="salary-amount">₱{{ number_format($employee->currentRate->rate, 2) }}</span>
                                    @else
                                        <span class="salary-not-set">Not Set</span>
                                    @endif
                                </td>
                                <td>
                                    @if($employee->currentRate)
                                        <span class="salary-date">{{ \Carbon\Carbon::parse($employee->currentRate->effective_from)->format('M d, Y') }}</span>
                                    @else
                                        <span class="salary-not-set">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($employee->currentRate)
                                        <a href="#" 
                                           onclick="openSalaryModal('{{ $employee->employee_id }}', '{{ $employee->first_name }} {{ $employee->last_name }}', '{{ $employee->currentRate->rate }}', '{{ $employee->currentRate->employee_rate_id }}'); return false;"
                                           class="btn-action">
                                            Update
                                        </a>
                                    @else
                                        <a href="#" 
                                           onclick="openSalaryModal('{{ $employee->employee_id }}', '{{ $employee->first_name }} {{ $employee->last_name }}', '', ''); return false;"
                                           class="btn-action">
                                            Set Salary
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    <div class="empty-state-icon">📋</div>
                                    <p>No employees found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="salary-footer">
                <p class="salary-footer-text">
                    <strong>Total Employees:</strong> {{ $employees->count() }}
                </p>
            </div>
        </div>
    </div>

    <!-- Salary Modal -->
    <div id="salaryModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
        <div style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.2); max-width: 500px; width: 90%;">
            <h3 style="color: var(--clr-primary); margin-bottom: 1.5rem; font-size: 18px;" id="modalTitle">Set Salary Rate</h3>
            
            <form id="salaryForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="admin_id" value="{{ auth('admin')->id() }}">
                
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--clr-secondary); font-size: 14px; font-weight: 600;">Employee:</label>
                    <input type="text" 
                           id="employeeName" 
                           readonly
                           style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; background: #f9fafb;">
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--clr-secondary); font-size: 14px; font-weight: 600;">Daily Rate (₱):</label>
                    <input type="number" 
                           name="rate" 
                           id="salaryRate" 
                           step="0.01" 
                           min="0" 
                           required
                           style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--clr-secondary); font-size: 14px; font-weight: 600;">Effective From:</label>
                    <input type="date" 
                           name="effective_from" 
                           id="effectiveFrom" 
                           required
                           value="{{ date('Y-m-d') }}"
                           style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
                </div>

                <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 1.5rem;">
                    <button type="button" onclick="closeSalaryModal()" style="background: #e5e7eb; color: #374151; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-size: 14px;">Cancel</button>
                    <button type="submit" style="background: #fbbf24; color: var(--clr-primary); padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-size: 14px; font-weight: 600;">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openSalaryModal(employeeId, employeeName, currentRate, rateId) {
            const modal = document.getElementById('salaryModal');
            const form = document.getElementById('salaryForm');
            const title = document.getElementById('modalTitle');
            const nameInput = document.getElementById('employeeName');
            const rateInput = document.getElementById('salaryRate');
            
            nameInput.value = employeeName;
            rateInput.value = currentRate;
            
            if (rateId) {
                // Update existing rate
                title.textContent = 'Update Salary Rate';
                form.action = "{{ url('/employee') }}/" + employeeId + "/rate/" + rateId + "/edit";
            } else {
                // Create new rate
                title.textContent = 'Set Salary Rate';
                form.action = "{{ url('/employee') }}/" + employeeId + "/rate/update";
            }
            
            modal.style.display = 'flex';
        }

        function closeSalaryModal() {
            document.getElementById('salaryModal').style.display = 'none';
        }

        // Close modal when clicking outside
        document.getElementById('salaryModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeSalaryModal();
            }
        });

        function filterSalary() {
            const search = document.getElementById('searchInput').value;
            const company = document.getElementById('companyFilter').value;
            
            const params = new URLSearchParams();
            if (search) params.append('search', search);
            if (company) params.append('company', company);
            
            window.location.href = "{{ route('salary.list') }}" + (params.toString() ? '?' + params.toString() : '');
        }

        // Allow Enter key to trigger search
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                filterSalary();
            }
        });
    </script>
    
    <style>
        @media (max-width: 1500px) {
            .main-content {
                margin-left: 25px;
                width: 95%;
            }
        }
            
        @media (max-width: 1200px) {
            .main-content {
                width: 94%;
                margin-left: 45px;
            }

            button {
                justify-content: center;
            }

            .salary-table {
                font-size: 13px;
            }

            .btn-action {
                padding: 6px 10px;
                font-size: 12px;
            }
        }

        @media (max-width: 900px) {
            .main-content {
                width: 92%; 
                margin-left: 50px;
            }
        }

        @media (max-width: 800px) {
            .main-content {
                width: 87%; 
                margin-left: 60px;
            }
        }

        @media (max-width: 700px) {
            .main-content {
                width: 85%; 
                margin-left: 70px;
            }
        }

        @media (max-width: 480px) {
            .main-content {
                width: 80%; 
                margin-left: 72px;
            }
  
            .salary-search-input, .filter-dropdown {
                min-width: 30px;
            }

            .filter-dropdown {
                font-size: 13px;
            }

            .salary-search-input {
                font-size: 12.5px;
            }
        }
    </style>
</x-app>