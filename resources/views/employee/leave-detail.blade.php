@vite(['resources/css/employee_dashboard/leave-request.css'])

<x-app  :navigation="true" navigationType="employee" :employee="$employee" :noHeader="true">
    <x-attendance-navigation
        :daysActive="$reports['daysActive']"
        :totalLate="$reports['countLate']"
        :totalOvertime="$reports['totalOvertime']"
        :noClockOut="$reports['totalNoClockOut']"
        :totalAbsences="$reports['absences']"
        :leaveBalance="$reports['creditDays']"
        :id="$employee->employee_id"
    />
    @if (session('success'))
        <div class="custom-alert">
            {{ session('success') }}
        </div>
    @endif
    <section class="main-content">
        <div class="leave-wrapper">
            <div class="message">
                {{$leave->reason}}
            </div>
            
            <div class="leave-handle-wrapper">
                <div class="employee-data">
                    <x-form-input
                        label="Leave Request Number"
                        :value="$leaveCount"
                        :readOnly="true"
                    />

                    <x-form-input
                        label="Leave Type"
                        :value="$leave->leave_type"
                        :readOnly="true"
                    />

                    <x-form-input
                        label="Fillin Date"
                        :value="$leave->submission_date"
                        :readOnly="true"
                    />
                    {{--                {{dd($duration)}}--}}
                    <x-form-input
                        label="Leave Duration"
                        :value="$duration . ' days'"
                    />
                </div>

                <div class="action-buttons">
                    <form action="{{route('approve.leave', ['employeeId' => $employee->employee_id, 'leaveId' => $leave->leave_request_id])}}" method="post">
                        @csrf
                        <x-button-submit>Approve</x-button-submit>
                    </form>
                    <div class="button-rejects">
                        <form action="{{route('revise.leave', ['employeeId' => $employee->employee_id, 'leaveId' => $leave->leave_request_id])}}" method="post">
                            @csrf
                            <x-button-submit id="btn-revision">Send for Revision</x-button-submit>
                        </form>
                        <form action="{{route('reject.leave', ['employeeId' => $employee->employee_id, 'leaveId' => $leave->leave_request_id])}}" method="post">
                            @csrf
                            <x-button-submit id="btn-reject">Reject</x-button-submit>
                        </form>
                    </div>
                    
                    <div class="l">
                        <h6>Supporting Document</h6>
                            @if(!empty($leave->supporting_doc))
                            @php
                                $document = $leave->supporting_doc;
                                $extension = pathinfo($document, PATHINFO_EXTENSION);
                                $fileName = basename($document);
                            @endphp
                            <div class="documents-grid" 
                                style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; margin-top: 0px; max-width: 300px;">
                                
                                <div class="document-card" 
                                    style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 15px; background: #f9fafb; transition: all 0.3s ease;">

                                    <!-- Preview -->
                                    <div class="document-preview" 
                                        style="text-align: center; margin-bottom: 12px; cursor: pointer;" 
                                        onclick="window.open('{{ asset('storage/'.$document) }}', '_blank')">

                                        @if(in_array(strtolower($extension), ['jpg','jpeg','png']))
                                            <img src="{{ asset('storage/'.$document) }}"
                                                alt="Supporting Document"
                                                style="max-width: 100%; height: 180px; object-fit: cover; border-radius: 6px; border: 2px solid #e5e7eb;">
                                        
                                        @elseif(strtolower($extension) === 'pdf')
                                            <div style="height: 180px; display: flex; align-items: center; justify-content: center; background: white; border-radius: 6px; border: 2px solid #e5e7eb;">
                                                <!-- PDF Icon -->
                                                <svg xmlns="http://www.w3.org/2000/svg" width="72" height="72" fill="#ef4444" viewBox="0 0 16 16">
                                                    <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                                                </svg>
                                            </div>
                                        @else
                                            <!-- Generic file -->
                                            <div style="height: 180px; display:flex;align-items:center;justify-content:center;background:white;border-radius:6px;border:2px solid #e5e7eb;">
                                                <span style="font-size:14px;color:#6b7280;">File Preview</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Info -->
                                    <div class="document-info" style="text-align:center;">
                                        <p style="font-size:0.875rem;font-weight:600;margin-bottom:6px;color:#374151;word-break:break-word;">
                                            {{ strlen($fileName) > 25 ? substr($fileName,0,22).'...' : $fileName }}
                                        </p>
                                        <p style="font-size:0.75rem;color:#6b7280;text-transform:uppercase;margin-bottom:12px;font-weight:500;">
                                            {{ strtoupper($extension) }} File
                                        </p>

                                        <div style="display:flex;gap:8px;justify-content:center;">
                                            <a href="{{ asset('storage/'.$document) }}" target="_blank"
                                            style="flex:1;padding:8px 12px;background:#3b82f6;color:white;text-decoration:none;border-radius:6px;font-size:0.813rem;text-align:center;font-weight:500;">
                                                View
                                            </a>
                                            <a href="{{ asset('storage/'.$document) }}" download
                                            style="flex:1;padding:8px 12px;background:#10b981;color:white;text-decoration:none;border-radius:6px;font-size:0.813rem;text-align:center;font-weight:500;">
                                                Download
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div style="text-align:center;padding:40px;color:#6b7280;">
                                <p style="font-size:1rem;font-weight:500;">No supporting document uploaded.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app>
<style>
    .l {
        margin-top: 35px;
        margin-bottom: 35px;
        box-shadow: 2px 5px 5.9px 0 rgba(136, 125, 125, 0.25);
        display: flex;
        flex-direction: column;
        width:100%;
        height: 400px;
        background: var(--clr-card-surface);
        border-radius: 16px;
        padding:10px;
        gap:30px;
    }
    h6 {
        margin-bottom: 0;
        font-size: 18px;
    }
    .documents-grid {
        margin-left: auto;
        margin-right: auto;
    }
    @media (max-width: 900px) {
        .l {
            height: 450px;
        }
    }
    @media (max-width: 875px) {
        .l {
            height: 400px;
        }
    }
    @media (max-width: 400px) {
        .document-card {
            width: 90%;
        }
        .l {
            height: 450px;
        }
    }
</style>
