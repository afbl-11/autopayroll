@vite('resources/css/employee_dashboard/employee-information.css')

<x-app :navigation="true" navigationType="employee" :employee="$employee" :noHeader="true">
        <div class="content-wrapper">
            <section class="main-content">
                @if (session('success'))
                    <div class="custom-alert">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="card-wrapper">
                    <a href="{{ route('employee.edit.personal', $employee->employee_id) }}" class="btn-edit">Edit</a>
                    <h6>Personal Information</h6>
{{--                    name and gender--}}
                    <div class="field-row">
                        <x-form-input
                            label="Full Name"
                            id="full-name"
                            name="full-name"
                            :value="$fullName"
                        />
                        <x-form-input
                            label="Gender"
                            id="gender"
                            name="gender"
                            :value="$employee->gender"
                        />
                    </div>
                    <div class="field-row">
{{--                        civil status and blood type--}}
                        <x-form-input
                            label="Civil Status"
                            id="status"
                            name="status"
                            :value="$employee->marital_status"
                        />
                        <x-form-input
                            label="Blood Type"
                            id="blood-type"
                            name="blood-type"
                            :value="$employee->blood_type"
                        />
                    </div>
{{--                    place of birth--}}
{{--                    <div class="field-row">--}}
{{--                        <x-form-input--}}
{{--                            label="Place of Birth"--}}
{{--                            name="address"--}}
{{--                            id="address"--}}
{{--                            :value="$res_address"--}}
{{--                        />--}}
{{--                    </div>--}}
{{--                    birthdate and age--}}
                    <div class="field-row">
                        <x-form-input
                            label="Date of Birth"
                            id="birthdate"
                            name="birthdate"
                            :value="$employee->birthdate->format('F j, Y')"
                        />
                        <x-form-input
                            label="Age"
                            id="age"
                            name="age"
                            :value="$age"
                        />
                    </div>
                </div>
                <div class="card-wrapper">
                    <a href="{{ route('employee.edit.address', $employee->employee_id) }}" class="btn-edit">Edit</a>
                    <h6>Address Information</h6>
{{--                    nav and button--}}
                    <div class="field-row">
                        <x-form-input
                            label="Residential Address"
                            name="res_address"
                            id="res_address"
                            :value="$res_address"
                        />
                    </div>
                    <div class="field-row">
                        <x-form-input
                            label="Address on Id"
                            name="id_address"
                            id="id_address"
                            :value="$id_address"
                        />
                    </div>
                </div>
                <div class="card-wrapper">
                    <a href="{{ route('employee.edit.government', $employee->employee_id) }}" class="btn-edit">Edit</a>
                    <h6>Government & Bank Information</h6>

                    <div class="field-row">
                        <x-form-input
                            label="Bank Account Number"
                            id="bank_account_number"
                            name="bank_account_number"
                            :value="$employee->bank_account_number"
                        />
                        <x-form-input
                            label="SSS Number"
                            id="sss_number"
                            name="sss_number"
                            :value="$employee->sss_number"
                        />
                    </div>

                    <div class="field-row">
                        <x-form-input
                            label="PhilHealth Number"
                            id="philhealth_number"
                            name="philhealth_number"
                            :value="$employee->phil_health_number"
                        />
                        <x-form-input
                            label="Pag-IBIG Number"
                            id="pag_ibig_number"
                            name="pag_ibig_number"
                            :value="$employee->pag_ibig_number"
                        />
                    </div>

                    <div class="field-row">
                        <x-form-input
                            label="TIN Number"
                            id="tin_number"
                            name="tin_number"
                            :value="$employee->tin_number"
                        />
                    </div>
                </div>
            </section>

            <section class="side-content">
                <div class="card-wrapper">
                    <a href="{{ route('employee.edit.account', $employee->employee_id) }}" class="btn-edit">Edit</a>
                    <h6>Contact Information</h6>
                    <div class="field-row"> 
                        <x-form-input
                            label="Phone Number"
                            id="phone_num"
                            name="phone_num"
                            :value="$employee->phone_number"
                        />
                        <x-form-input
                            label="Email"
                            id="email"
                            name="email"
                            :value="$employee->email"
                        />
                    </div>
                </div>
                <div class="card-wrapper">
                    <a href="{{ route('employee.edit.job', $employee->employee_id) }}" class="btn-edit">Edit</a>
                    <h6>Employment Overview</h6>
                    <div class="field-row">
                        <x-form-input
                            label="Date Started"
                            id="start_date"
                            name="start_date"
                            :value="$employee->contract_start->format('F j, Y')"
                        />

                        <x-form-input
                            label="Job Role"
                            id="job_position"
                            name="job_position"
                            :value="$employee->job_position"
                        />
                    </div>
                    <div class="field-row">
                        <x-form-input
                            label="Employment Status"
                            id="employment_status"
                            name="employment_status"
                            :value="$employee->employment_type"
                        />
                    </div>
                </div>
                {{-- <div class="card-wrapper"> --}}
                {{--    <a href="#" onclick="openEditRateModal(); return false;" class="btn-edit">Edit</a> --}}
                {{--    <h6>Salary Information</h6> --}}
                {{--    <div class="field-row"> --}}
                {{--        <x-form-input 
                                label="Daily Salary Rate"
                                id="daily_salary"
                                name="daily_salary"
                                :value="$employee->currentRate ? '₱' . number_format($employee->currentRate->rate, 2) : 'Not Set'"
                        /> --}}
                {{--    </div> --}}
                {{--    @if($employee->currentRate) --}}
                {{--    <div class="field-row"> --}}
                {{--        <x-form-input
                                label="Effective From"
                                id="effective_from"
                                name="effective_from"
                                :value="\Carbon\Carbon::parse($employee->currentRate->effective_from)->format('F j, Y')"
                        /> --}}
                {{--    </div> --}}
                {{--    @endif --}}
                {{-- </div> --}}
                <div class="notes">
{{--                    optional--}}
                </div>
            </section>
        </div>
        
        {{-- Salary History Section --}}
        <div class="content-wrapper" style="margin-top: 20px;">
            <section class="main-content">
                <div class="card-wrapper">
                    <a href="#" onclick="openEditRateModal(); return false;" class="btn-edit">Add New Rate</a>
                    <h6>Salary History</h6>
                    
                    @if($salaryHistory && $salaryHistory->count() > 0)
                    <div style="overflow-x: auto; margin-top: 1rem;">
                        <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                            <thead>
                                <tr style="background: var(--clr-card-inner); color: var(--clr-primary);">
                                    <th style="padding: 12px; text-align: left; border: 1px solid #ddd; font-weight: 600;">Daily Rate</th>
                                    <th style="padding: 12px; text-align: left; border: 1px solid #ddd; font-weight: 600;">Effective From</th>
                                    <th style="padding: 12px; text-align: left; border: 1px solid #ddd; font-weight: 600;">Effective To</th>
                                    <th style="padding: 12px; text-align: left; border: 1px solid #ddd; font-weight: 600;">Status</th>
                                    <th style="padding: 12px; text-align: center; border: 1px solid #ddd; font-weight: 600;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($salaryHistory as $rate)
                                <tr style="background: white;">
                                    <td style="padding: 10px 12px; border: 1px solid #ddd; font-family: 'Courier New', monospace;">
                                        ₱{{ number_format($rate->rate, 2) }}
                                    </td>
                                    <td style="padding: 10px 12px; border: 1px solid #ddd;">
                                        {{ \Carbon\Carbon::parse($rate->effective_from)->format('F j, Y') }}
                                    </td>
                                    <td style="padding: 10px 12px; border: 1px solid #ddd;">
                                        {{ $rate->effective_to ? \Carbon\Carbon::parse($rate->effective_to)->format('F j, Y') : 'Present' }}
                                    </td>
                                    <td style="padding: 10px 12px; border: 1px solid #ddd;">
                                        @php
                                            $isCurrent = \Carbon\Carbon::parse($rate->effective_from)->lte(now()) && 
                                                        ($rate->effective_to === null || \Carbon\Carbon::parse($rate->effective_to)->gte(now()));
                                        @endphp
                                        <span style="padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600; 
                                                     background: {{ $isCurrent ? '#dcfce7' : '#f3f4f6' }}; 
                                                     color: {{ $isCurrent ? '#166534' : '#6b7280' }};">
                                            {{ $isCurrent ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td style="padding: 10px 12px; border: 1px solid #ddd; text-align: center;">
                                        <button onclick="openEditSalaryModal('{{ $rate->employee_rate_id }}', '{{ $rate->rate }}', '{{ $rate->effective_from }}', '{{ $rate->effective_to }}')" 
                                                style="background: var(--clr-yellow); color: var(--clr-primary); padding: 6px 16px; border: none; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600;">
                                            Edit
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p style="margin-top: 1rem; color: var(--clr-secondary); font-size: 14px;">No salary history available.</p>
                    @endif
                </div>
            </section>
        </div>
        
        {{-- Documents Section --}}
        <div class="content-wrapper" style="margin-top: 20px;">
            <section class="main-content">
                <div class="card-wrapper">
                    <h6>Uploaded Documents</h6>
                    @if(!empty($employee->uploaded_documents))
                        @php
                            $documents = is_string($employee->uploaded_documents) 
                                ? json_decode($employee->uploaded_documents, true) 
                                : $employee->uploaded_documents;
                        @endphp
                        <p class="note">Note: Change the uploaded documents in the Employment Overview Card.</p>
                        @if(is_array($documents) && count($documents) > 0)
                            <div class="documents-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; margin-top: 20px;">
                                @foreach($documents as $index => $document)
                                    @php
                                        $extension = pathinfo($document, PATHINFO_EXTENSION);
                                        $fileName = basename($document);
                                    @endphp
                                    <div class="document-card" style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 15px; background: #f9fafb; transition: all 0.3s ease;">
                                        <div class="document-preview" style="text-align: center; margin-bottom: 12px; cursor: pointer;" onclick="window.open('{{ asset('storage/' . $document) }}', '_blank')">
                                            @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png']))
                                                <img src="{{ asset('storage/' . $document) }}" 
                                                     alt="Document {{ $index + 1 }}" 
                                                     style="max-width: 100%; height: 180px; object-fit: cover; border-radius: 6px; border: 2px solid #e5e7eb;">
                                            @elseif(strtolower($extension) === 'pdf')
                                                <div style="height: 180px; display: flex; align-items: center; justify-content: center; background: white; border-radius: 6px; border: 2px solid #e5e7eb;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="72" height="72" fill="#ef4444" viewBox="0 0 16 16">
                                                        <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                                                        <path d="M4.603 14.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.697 19.697 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.188-.012.396-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.066.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.712 5.712 0 0 1-.911-.95 11.651 11.651 0 0 0-1.997.406 11.307 11.307 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.266.266 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.71 12.71 0 0 1 1.01-.193 11.744 11.744 0 0 1-.51-.858 20.801 20.801 0 0 1-.5 1.05zm2.446.45c.15.163.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.876 3.876 0 0 0-.612-.053zM8.078 7.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="document-info" style="text-align: center;">
                                            <p style="font-size: 0.875rem; font-weight: 600; margin-bottom: 6px; color: #374151; word-break: break-word;">
                                                {{ strlen($fileName) > 25 ? substr($fileName, 0, 22) . '...' : $fileName }}
                                            </p>
                                            <p style="font-size: 0.75rem; color: #6b7280; text-transform: uppercase; margin-bottom: 12px; font-weight: 500;">
                                                {{ $extension }} File
                                            </p>
                                            <div style="display: flex; gap: 8px; justify-content: center;">
                                                <a href="{{ asset('storage/' . $document) }}" 
                                                   target="_blank" 
                                                   style="flex: 1; padding: 8px 12px; background: #3b82f6; color: white; text-decoration: none; border-radius: 6px; font-size: 0.813rem; text-align: center; font-weight: 500; transition: background 0.2s;"
                                                   onmouseover="this.style.background='#2563eb'" 
                                                   onmouseout="this.style.background='#3b82f6'">
                                                    View
                                                </a>
                                                <a href="{{ asset('storage/' . $document) }}" 
                                                   download 
                                                   style="flex: 1; padding: 8px 12px; background: #10b981; color: white; text-decoration: none; border-radius: 6px; font-size: 0.813rem; text-align: center; font-weight: 500; transition: background 0.2s;"
                                                   onmouseover="this.style.background='#059669'" 
                                                   onmouseout="this.style.background='#10b981'">
                                                    Download
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div style="text-align: center; padding: 40px; color: #6b7280;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" viewBox="0 0 16 16" style="margin-bottom: 16px; opacity: 0.5;">
                                    <path d="M5 4a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zM5 8a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1H5z"/>
                                    <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm10-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1z"/>
                                </svg>
                                <p style="font-size: 1rem; font-weight: 500;">No documents uploaded yet.</p>
                            </div>
                        @endif
                    @else
                        <div style="text-align: center; padding: 40px; color: #6b7280;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" viewBox="0 0 16 16" style="margin-bottom: 16px; opacity: 0.5;">
                                <path d="M5 4a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zM5 8a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1H5z"/>
                                <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm10-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1z"/>
                            </svg>
                            <p style="font-size: 1rem; font-weight: 500;">No documents to show.</p>
                        </div>
                    @endif
                </div>
            </section>
        </div>

        <div class="delete-employee-wrapper">
            @if(!is_null($employee->company_id))
                <button
                    class="btn-delete disabled"
                    disabled
                    title="Unassign employee from company before deleting">
                    Delete Employee
                </button>
            @else
                <form action="{{ route('employee.destroy', $employee->employee_id) }}"
                    method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this employee? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn-delete">
                        Delete Employee
                    </button>
                </form>
            @endif
</div>

<!-- Edit Rate Modal -->
<div id="editRateModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.2); max-width: 500px; width: 90%;">
        <h3 style="color: var(--clr-primary); margin-bottom: 1.5rem; font-size: 18px;">Add New Salary Rate</h3>
        
        <form id="updateRateForm" method="POST" action="{{ route('employee.rate.update', $employee->employee_id) }}">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: var(--clr-secondary); font-size: 14px; font-weight: 600;">New Daily Rate (₱):</label>
                <input type="number" 
                       name="rate" 
                       id="new_rate" 
                       step="0.01" 
                       min="0" 
                       required
                       value="{{ $employee->currentRate ? $employee->currentRate->rate : '' }}"
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: var(--clr-secondary); font-size: 14px; font-weight: 600;">Effective From:</label>
                <input type="date" 
                       name="effective_from" 
                       id="effective_from_date" 
                       required
                       value="{{ date('Y-m-d') }}"
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
            </div>

            <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 1.5rem;">
                <button type="button" onclick="closeEditRateModal()" style="background: #e5e7eb; color: #374151; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-size: 14px;">Cancel</button>
                <button type="submit" style="background: var(--clr-yellow); color: var(--clr-primary); padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-size: 14px; font-weight: 600;">Add Rate</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Salary Modal (for editing existing rates) -->
<div id="editSalaryModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.2); max-width: 500px; width: 90%;">
        <h3 style="color: var(--clr-primary); margin-bottom: 1.5rem; font-size: 18px;">Edit Salary Rate</h3>
        
        <form id="editSalaryForm" method="POST">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: var(--clr-secondary); font-size: 14px; font-weight: 600;">Daily Rate (₱):</label>
                <input type="number" 
                       name="rate" 
                       id="edit_rate" 
                       step="0.01" 
                       min="0" 
                       required
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: var(--clr-secondary); font-size: 14px; font-weight: 600;">Effective From:</label>
                <input type="date" 
                       name="effective_from" 
                       id="edit_effective_from" 
                       required
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: var(--clr-secondary); font-size: 14px; font-weight: 600;">Effective To (Optional):</label>
                <input type="date" 
                       name="effective_to" 
                       id="edit_effective_to"
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
                <small style="color: var(--clr-secondary); font-size: 12px; margin-top: 4px; display: block;">Leave empty for current/ongoing rate</small>
            </div>

            <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 1.5rem;">
                <button type="button" onclick="closeEditSalaryModal()" style="background: #e5e7eb; color: #374151; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-size: 14px;">Cancel</button>
                <button type="submit" style="background: var(--clr-yellow); color: var(--clr-primary); padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-size: 14px; font-weight: 600;">Update Rate</button>
            </div>
        </form>
    </div>
</div>

</x-app>
<script>
    setTimeout(() => {
        const alert = document.querySelector('.custom-alert');
        if (alert) alert.remove();
    }, 3500);

    function openEditRateModal() {
        document.getElementById('editRateModal').style.display = 'flex';
    }

    function closeEditRateModal() {
        document.getElementById('editRateModal').style.display = 'none';
    }

    function openEditSalaryModal(rateId, rate, effectiveFrom, effectiveTo) {
        const employeeId = '{{ $employee->employee_id }}';
        const form = document.getElementById('editSalaryForm');
        
        // Set form action with rate ID
        form.action = `/dashboard/employee/${employeeId}/rate/${rateId}/edit`;
        
        // Populate form fields
        document.getElementById('edit_rate').value = rate;
        document.getElementById('edit_effective_from').value = effectiveFrom;
        document.getElementById('edit_effective_to').value = effectiveTo === 'null' || !effectiveTo ? '' : effectiveTo;
        
        // Show modal
        document.getElementById('editSalaryModal').style.display = 'flex';
    }

    function closeEditSalaryModal() {
        document.getElementById('editSalaryModal').style.display = 'none';
    }

    // Close modals when clicking outside
    document.getElementById('editRateModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeEditRateModal();
        }
    });

    document.getElementById('editSalaryModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeEditSalaryModal();
        }
    });

    // Personal Information Modal Functions
    function openPersonalModal() {
        document.getElementById('personalModal').style.display = 'flex';
    }
    function closePersonalModal() {
        document.getElementById('personalModal').style.display = 'none';
    }

    // Address Modal Functions
    function openAddressModal() {
        document.getElementById('addressModal').style.display = 'flex';
    }
    function closeAddressModal() {
        document.getElementById('addressModal').style.display = 'none';
    }

    // Government Modal Functions
    function openGovernmentModal() {
        document.getElementById('governmentModal').style.display = 'flex';
    }
    function closeGovernmentModal() {
        document.getElementById('governmentModal').style.display = 'none';
    }

    // Contact Modal Functions
    function openContactModal() {
        document.getElementById('contactModal').style.display = 'flex';
    }
    function closeContactModal() {
        document.getElementById('contactModal').style.display = 'none';
    }

    // Employment Modal Functions
    function openEmploymentModal() {
        document.getElementById('employmentModal').style.display = 'flex';
    }
    function closeEmploymentModal() {
        document.getElementById('employmentModal').style.display = 'none';
    }

    // Close modals when clicking outside
    ['personalModal', 'addressModal', 'governmentModal', 'contactModal', 'employmentModal'].forEach(modalId => {
        document.getElementById(modalId).addEventListener('click', function(e) {
            if (e.target === this) {
                this.style.display = 'none';
            }
        });
    });
</script>

<!-- Personal Information Modal -->
<div id="personalModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; overflow-y: auto;">
    <div style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.2); max-width: 600px; width: 90%; margin: 2rem auto;">
        <h3 style="color: var(--clr-primary); margin-bottom: 1.5rem; font-size: 18px;">Edit Personal Information</h3>
        
        <form method="POST" action="{{ route('employee.update.personal', $employee) }}">
            @csrf
            @method('PUT')
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--clr-secondary); font-size: 14px; font-weight: 600;">First Name:</label>
                    <input type="text" name="first_name" value="{{ $employee->first_name }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--clr-secondary); font-size: 14px; font-weight: 600;">Middle Name:</label>
                    <input type="text" name="middle_name" value="{{ $employee->middle_name }}" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--clr-secondary); font-size: 14px; font-weight: 600;">Last Name:</label>
                    <input type="text" name="last_name" value="{{ $employee->last_name }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--clr-secondary); font-size: 14px; font-weight: 600;">Suffix:</label>
                    <input type="text" name="suffix" value="{{ $employee->suffix }}" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--clr-secondary); font-size: 14px; font-weight: 600;">Gender:</label>
                    <select name="gender" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
                        <option value="male" {{ $employee->gender == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ $employee->gender == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--clr-secondary); font-size: 14px; font-weight: 600;">Blood Type:</label>
                    <input type="text" name="blood_type" value="{{ $employee->blood_type }}" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--clr-secondary); font-size: 14px; font-weight: 600;">Civil Status:</label>
                    <select name="marital_status" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
                        <option value="single" {{ $employee->marital_status == 'single' ? 'selected' : '' }}>Single</option>
                        <option value="married" {{ $employee->marital_status == 'married' ? 'selected' : '' }}>Married</option>
                        <option value="widowed" {{ $employee->marital_status == 'widowed' ? 'selected' : '' }}>Widowed</option>
                        <option value="separated" {{ $employee->marital_status == 'separated' ? 'selected' : '' }}>Separated</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--clr-secondary); font-size: 14px; font-weight: 600;">Date of Birth:</label>
                    <input type="date" name="birthdate" value="{{ $employee->birthdate->format('Y-m-d') }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
                </div>
            </div>

            <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 1.5rem;">
                <button type="button" onclick="closePersonalModal()" style="background: #e5e7eb; color: #374151; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-size: 14px;">Cancel</button>
                <button type="submit" style="background: #fbbf24; color: var(--clr-primary); padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-size: 14px; font-weight: 600;">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<!-- Address Information Modal -->
<div id="addressModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; overflow-y: auto;">
    <div style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.2); max-width: 600px; width: 90%; margin: 2rem auto;">
        <h3 style="color: var(--clr-primary); margin-bottom: 1.5rem; font-size: 18px;">Edit Address Information</h3>
        
        <form method="POST" action="{{ route('employee.update.address', $employee) }}">
            @csrf
            @method('PUT')
            
            <p style="font-weight: 600; color: var(--clr-primary); margin-bottom: 1rem;">Residential Address</p>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--clr-secondary); font-size: 14px; font-weight: 600;">House Number:</label>
                    <input type="text" name="house_number" value="{{ $employee->house_number }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--clr-secondary); font-size: 14px; font-weight: 600;">Street:</label>
                    <input type="text" name="street" value="{{ $employee->street }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--clr-secondary); font-size: 14px; font-weight: 600;">Barangay:</label>
                    <input type="text" name="barangay_name" value="{{ $employee->barangay_name }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--clr-secondary); font-size: 14px; font-weight: 600;">City:</label>
                    <input type="text" name="city_name" value="{{ $employee->city_name }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--clr-secondary); font-size: 14px; font-weight: 600;">Province:</label>
                    <input type="text" name="province_name" value="{{ $employee->province_name }}" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--clr-secondary); font-size: 14px; font-weight: 600;">ZIP Code:</label>
                    <input type="text" name="zip" value="{{ $employee->zip }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
                </div>
            </div>

            <p style="font-weight: 600; color: var(--clr-primary); margin-bottom: 1rem; margin-top: 1.5rem;">Address on ID</p>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--clr-secondary); font-size: 14px; font-weight: 600;">House Number:</label>
                    <input type="text" name="id_house_number" value="{{ $employee->id_house_number }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--clr-secondary); font-size: 14px; font-weight: 600;">Street:</label>
                    <input type="text" name="id_street" value="{{ $employee->id_street }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--clr-secondary); font-size: 14px; font-weight: 600;">Barangay:</label>
                    <input type="text" name="id_barangay_name" value="{{ $employee->id_barangay_name }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--clr-secondary); font-size: 14px; font-weight: 600;">City:</label>
                    <input type="text" name="id_city_name" value="{{ $employee->id_city_name }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--clr-secondary); font-size: 14px; font-weight: 600;">Province:</label>
                    <input type="text" name="id_province_name" value="{{ $employee->id_province_name }}" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--clr-secondary); font-size: 14px; font-weight: 600;">ZIP Code:</label>
                    <input type="text" name="id_zip" value="{{ $employee->id_zip }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
                </div>
            </div>

            <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 1.5rem;">
                <button type="button" onclick="closeAddressModal()" style="background: #e5e7eb; color: #374151; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-size: 14px;">Cancel</button>
                <button type="submit" style="background: #fbbf24; color: var(--clr-primary); padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-size: 14px; font-weight: 600;">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<!-- Government & Bank Information Modal -->
<div id="governmentModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; overflow-y: auto;">
    <div style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.2); max-width: 600px; width: 90%; margin: 2rem auto;">
        <h3 style="color: var(--clr-primary); margin-bottom: 1.5rem; font-size: 18px;">Edit Government & Bank Information</h3>
        
        <form method="POST" action="{{ route('employee.update.government', $employee) }}">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: var(--clr-secondary); font-size: 14px; font-weight: 600;">Bank Account Number:</label>
                <input type="text" name="bank_account_number" value="{{ $employee->bank_account_number }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: var(--clr-secondary); font-size: 14px; font-weight: 600;">SSS Number:</label>
                <input type="text" name="sss_number" value="{{ $employee->sss_number }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: var(--clr-secondary); font-size: 14px; font-weight: 600;">PhilHealth Number:</label>
                <input type="text" name="phil_health_number" value="{{ $employee->phil_health_number }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: var(--clr-secondary); font-size: 14px; font-weight: 600;">Pag-IBIG Number:</label>
                <input type="text" name="pag_ibig_number" value="{{ $employee->pag_ibig_number }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: var(--clr-secondary); font-size: 14px; font-weight: 600;">TIN Number:</label>
                <input type="text" name="tin_number" value="{{ $employee->tin_number }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
            </div>

            <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 1.5rem;">
                <button type="button" onclick="closeGovernmentModal()" style="background: #e5e7eb; color: #374151; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-size: 14px;">Cancel</button>
                <button type="submit" style="background: #fbbf24; color: var(--clr-primary); padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-size: 14px; font-weight: 600;">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<!-- Contact Information Modal -->
<div id="contactModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.2); max-width: 500px; width: 90%;">
        <h3 style="color: var(--clr-primary); margin-bottom: 1.5rem; font-size: 18px;">Edit Contact Information</h3>
        
        <form method="POST" action="{{ route('employee.update.account', $employee) }}">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: var(--clr-secondary); font-size: 14px; font-weight: 600;">Phone Number:</label>
                <input type="text" name="phone_number" value="{{ $employee->phone_number }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: var(--clr-secondary); font-size: 14px; font-weight: 600;">Email:</label>
                <input type="email" name="email" value="{{ $employee->email }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: var(--clr-secondary); font-size: 14px; font-weight: 600;">Username:</label>
                <input type="text" name="username" value="{{ $employee->username }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
            </div>

            <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 1.5rem;">
                <button type="button" onclick="closeContactModal()" style="background: #e5e7eb; color: #374151; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-size: 14px;">Cancel</button>
                <button type="submit" style="background: #fbbf24; color: var(--clr-primary); padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-size: 14px; font-weight: 600;">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<!-- Employment Overview Modal -->
<div id="employmentModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.2); max-width: 500px; width: 90%;">
        <h3 style="color: var(--clr-primary); margin-bottom: 1.5rem; font-size: 18px;">Edit Employment Information</h3>
        
        <form method="POST" action="{{ route('employee.update.job', $employee) }}">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: var(--clr-secondary); font-size: 14px; font-weight: 600;">Job Position:</label>
                <input type="text" name="job_position" value="{{ $employee->job_position }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: var(--clr-secondary); font-size: 14px; font-weight: 600;">Contract Start:</label>
                <input type="date" name="contract_start" value="{{ $employee->contract_start->format('Y-m-d') }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: var(--clr-secondary); font-size: 14px; font-weight: 600;">Contract End:</label>
                <input type="date" name="contract_end" value="{{ $employee->contract_end ? $employee->contract_end->format('Y-m-d') : '' }}" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: var(--clr-secondary); font-size: 14px; font-weight: 600;">Employment Type:</label>
                <select name="employment_type" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
                    <option value="full-time" {{ $employee->employment_type == 'full-time' ? 'selected' : '' }}>Full-time</option>
                    <option value="part-time" {{ $employee->employment_type == 'part-time' ? 'selected' : '' }}>Part-time</option>
                    <option value="contractual" {{ $employee->employment_type == 'contractual' ? 'selected' : '' }}>Contractual</option>
                </select>
            </div>

            <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 1.5rem;">
                <button type="button" onclick="closeEmploymentModal()" style="background: #e5e7eb; color: #374151; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-size: 14px;">Cancel</button>
                <button type="submit" style="background: #fbbf24; color: var(--clr-primary); padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-size: 14px; font-weight: 600;">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<style>
    .note {
        font-size: 11.75px; 
        margin-top: -7px;
        color: #4B5563;
        margin-bottom: 20px;
        letter-spacing: 1.33px;
        width: 100%;
    }
    .btn-delete {
        background: var(--clr-red);
        color: var(--clr-background);
        padding: 10px 15px;
        border-radius: 8px;
        font-weight: 400;
        cursor: pointer;
        margin-top: 20px;
        box-shadow: 2px 5px 5px 0 rgba(136, 125, 125, 0.25);
        letter-spacing: 1.33px;
        margin-bottom: 50px;
        border: none;
    }
    .btn-delete:hover {
        background: var(--clr-yellow);
        color: var(--clr-primary);
    }
    .btn-delete.disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }
    @media (max-width: 1150px){
        .btn-delete {
            margin-left: 50px;
        }
    }

    @media (max-width: 650px){
        .btn-delete {
            margin-left: 75px;
        }
    }

    @media (max-width: 500px){
        .btn-delete {
            margin-left: 70px;
        }
    }
</style>