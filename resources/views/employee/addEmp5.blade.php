@vite(['resources/css/employee_registration/reviewDetails.css', 'resources/js/empOnboarding/addEmp.js'])

<x-app :title="$title" :showProgression="false">
    <section class="main-content">
        <div class="form-wrapper">
            <form class="form" action="{{route('employee.create')}}" method="post">
                @csrf

                <section class="basic_information">
                    <h5>Basic Information</h5>
    {{--                first and middle name--}}
                    <div class="field-row">
                        <x-form-input id="first_name" label="First Name" :value="$data['first_name'] ?? null"></x-form-input>
                        <x-form-input id="middle_name" label="Middle Name" :value="$data['middle_name'] ?? null"></x-form-input>
                    </div>
    {{--                last and suffix--}}
                    <div class="field-row">
                        <x-form-input id="last_name" label="Last Name" :value="$data['last_name'] ?? null"></x-form-input>
                        <x-form-input id="suffix" label="Suffix" :value="$data['suffix'] ?? 'N/A'"></x-form-input>
                    </div>
    {{--                place of birth--}}
                    <div class="field-row">
                        <x-form-input id="birthplace" label="Place of Birth" :value="$address"></x-form-input>
                    </div>
    {{--                bday and civil status--}}
                    <div class="field-row">
                        <x-form-input id="birthdate" label="Date of Birth" :value="$data['birthdate']"></x-form-input>
                        <x-form-input id="age" label="Age" :value="$data['age']"></x-form-input>
                    </div>
    {{--                gender and status--}}
                    <div class="field-row">
                        <x-form-input id="gender" label="Gender" :value="$data['gender']"></x-form-input>
                        <x-form-input id="civil_status" label="Civil Status" :value="$data['marital_status']"></x-form-input>
                    </div>

                    <div class="field-row">
                        <x-form-input id="blood_type" label="Blood Type" :value="$data['blood_type']"></x-form-input>
                    </div>
                </section>

                <section class="contact_address">
                    <h5>Contact & Address</h5>
{{--                    res address--}}
                    <div class="field-row">
                        <x-form-input id="res_address" label="Residential Address" :value="$address"></x-form-input>
                    </div>
{{--                    id address--}}
                    <div class="field-row">
                        <x-form-input id="id_address" label="Address on Id" :value="$idAddress"></x-form-input>
                    </div>
{{--                    phone and email--}}
                    <div class="field-row">
                        <x-form-input id="phone_num" label="Personal Contact Number" :value="$data['phone_number']"></x-form-input>
                        <x-form-input id="email" label="Email Address" :value="$data['email']"></x-form-input>
                    </div>

                    <div class="field-row">
                        <x-form-input id="other_contact" label="Other Contacts" value="N/A"></x-form-input>
                    </div>
                </section>

{{--                employment overview--}}
                <section class="employment_overview">
                    <h5>Employment Overview</h5>

{{--                    Company--}}
                    @if(isset($data['company_id']) && $data['company_id'])
                    <div class="field-row">
                        <x-form-input id="company_id" label="Company Designation" :value="$data['company_id']"></x-form-input>
                    </div>
                    @endif
{{--                    employment type and position--}}
                    <div class="field-row">
                        <x-form-input id="employment_type" label="Employment Type" :value="$data['employment_type']"></x-form-input>
                        <x-form-input id="position" label="Position" :value="$data['job_position']"></x-form-input>
                    </div>
{{--                    Days Available (for part-time)--}}
                    @if(isset($data['days_available']) && $data['days_available'])
                    <div class="field-row">
                        <x-form-input id="days_available" label="Days Available" :value="implode(', ', json_decode($data['days_available'], true) ?? [])"></x-form-input>
                    </div>
                    @endif
{{--                    starting and end date--}}
                    <div class="field-row">
                        <x-form-input id="contract_start" label="Starting Date" :value="$data['contract_start']"></x-form-input>
                        @if(isset($data['contract_end']) && $data['contract_end'])
                        <x-form-input id="contract_end" label="Termination Date" :value="$data['contract_end']"></x-form-input>
                        @endif
                    </div>
{{--                    uploaded docs preview--}}
                    @if(isset($data['temp_uploaded_documents']) && is_array($data['temp_uploaded_documents']) && count($data['temp_uploaded_documents']) > 0)
                        <div class="field-row documents-wrapper">
                            <label class="documents-label">Uploaded Documents</label>
                            <div class="documents-grid">
                                @foreach($data['temp_uploaded_documents'] as $index => $tempPath)
                                    @php
                                        $extension = pathinfo($tempPath, PATHINFO_EXTENSION);
                                        $fileName = basename($tempPath);
                                    @endphp
                                    <div class="document-card">
                                        <div class="document-preview">
                                            @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png']))
                                                <img src="{{ asset('storage/' . $tempPath) }}" 
                                                     alt="Document {{ $index + 1 }}">
                                            @elseif(strtolower($extension) === 'pdf')
                                                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="#ef4444" viewBox="0 0 16 16">
                                                    <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                                                    <path d="M4.603 14.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.697 19.697 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.188-.012.396-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.066.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.712 5.712 0 0 1-.911-.95 11.651 11.651 0 0 0-1.997.406 11.307 11.307 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.266.266 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.71 12.71 0 0 1 1.01-.193 11.744 11.744 0 0 1-.51-.858 20.801 20.801 0 0 1-.5 1.05zm2.446.45c.15.163.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.876 3.876 0 0 0-.612-.053zM8.078 7.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z"/>
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="document-info">
                                            <p class="document-name">
                                                Uploaded File {{ $index + 1 }}
                                            </p>
                                            <p class="document-type">
                                                {{ strtoupper($extension) }} File
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="field-row">
                            <x-form-input id="documents" label="Uploaded Documents" value="No documents uploaded"></x-form-input>
                        </div>
                    @endif

                    <section class="account_setup">
                        <h5>Account Information</h5>

                        <div class="field-row">
                            <x-form-input id="username" label="User Name" :value="$data['username']"></x-form-input>
                            <x-form-input id="setup_email" label="Email Address" :value="$data['email']"></x-form-input>
                        </div>

                        <div class="field-row">
                            <x-form-input id="password" label="password" value="DefaultPassword123!"></x-form-input>
                        </div>
                    </section>
                </section>
                <x-button-submit>Create Employee</x-button-submit>
            </form>
        </div>

    </section>
</x-app>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const inputs = document.querySelectorAll('input, textarea, select');

        inputs.forEach(input => {
            input.classList.add('read-mode-only');
        });
    });
</script>

