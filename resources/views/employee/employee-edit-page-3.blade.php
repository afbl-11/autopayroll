@vite(['resources/css/employee_registration/designation.css', 'resources/js/empOnboarding/addEmp.js'])

<x-app title="Edit Employment Information">
    <section class="main-content">
        <div class="form-wrapper">
            <form method="POST" action="{{ route('employee.update.job', $employee) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="radio-group">
                    <label>Employment Type</label><br>
                    <x-form-radio
                        name="employment_type"
                        value="full-time" 
                        label="Full-Time"
                        :selected="old('employment_type', $employee->employment_type)"
                        required
                    />

                    <x-form-radio
                        name="employment_type"
                        value="part-time"
                        label="Part-Time"
                        :selected="old('employment_type', $employee->employment_type)"
                        required
                    />

                    <x-form-radio
                        name="employment_type"
                        value="contractual"
                        label="Contractual"
                        :selected="old('employment_type', $employee->employment_type)"
                        required
                    />
                </div>
                            
{{--                company and add company button (hidden for part-time)--}}
            <div class="field-row" id="company-field">
                <x-form-select  name="company_id" id="company_id" label="Company" :options="$companies" :value="old('company_id', $employee->company_id)" useValue></x-form-select>
                <x-button-link source="show.register.client" class="button-link" :noDefault="true" id="add-client-btn">Add Client</x-button-link>
            </div>

{{--            Days Available (only for part-time)--}}
            <div class="field-row days-available-field" id="days-available-field" style="display: none;">
                <div class="days-container">
                    <label>Days Available</label>
                    <p class="note">Note: Changes made in the existing data here will only update the employee's available days and will not impact their assigned days.</p>
                    <div class="days-buttons">
                        <button type="button" class="day-btn" data-day="Monday">Mon</button>
                        <button type="button" class="day-btn" data-day="Tuesday">Tue</button>
                        <button type="button" class="day-btn" data-day="Wednesday">Wed</button>
                        <button type="button" class="day-btn" data-day="Thursday">Thu</button>
                        <button type="button" class="day-btn" data-day="Friday">Fri</button>
                        <button type="button" class="day-btn" data-day="Saturday">Sat</button>
                        <button type="button" class="day-btn" data-day="Sunday">Sun</button>
                    </div>
                    <input type="hidden" name="days_available" id="days_available" value="{{ old('days_available', $employee->days_available) }}">
                </div>
            </div>

{{--            start and end date--}}
            <div class="field-row">
                <x-form-input type="date" name="contract_start" id="contract_start" label="Starting Date" :value="old('contract_start', optional($employee->contract_start)->format('Y-m-d'))"></x-form-input>
                <div id="contract-end-wrapper">
                    <x-form-input type="date" name="contract_end" id="contract_end" label="Termination Date" :value="old('contract_end', optional($employee->contract_end)->format('Y-m-d'))"></x-form-input>
                </div>
            </div>
{{--           upload documents --}}
            <div class="field-row">
                <x-form-input name="job_position" id="job_position" label="Position" :value="old('job_position', $employee->job_position)"></x-form-input>
                <div style="flex: 1;">
                    <x-form-input type="file" name="uploaded_documents[]" id="uploaded_documents" label="Upload Documents" accept=".pdf,.jpg,.jpeg,.png" :multiple="true"></x-form-input>
                    <small style="color: #666; margin-top: 5px; display: block;">Allowed formats: PDF, JPG, PNG (Max 5MB per file). You can select multiple files.</small>
                    
                    {{-- File Preview Area --}}
                    <div id="file-preview-container" style="margin-top: 15px; display: none;">
                        <h4 style="margin-bottom: 10px; font-size: 0.9rem; color: #374151;">Selected Files:</h4>
                        <div id="file-previews" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 15px;"></div>
                    </div>
                </div>
            </div>
            
            <x-button-submit>Continue</x-button-submit>
        </form>
    </div>
</section>
</x-app>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const employmentTypeRadios = document.querySelectorAll('input[name="employment_type"]');
    const companyField = document.getElementById('company-field');
    const companySelect = document.getElementById('company_id');
    const daysAvailableField = document.getElementById('days-available-field');
    const contractEndWrapper = document.getElementById('contract-end-wrapper');
    const contractEndInput = document.getElementById('contract_end');
    const daysAvailableInput = document.getElementById('days_available');
    const dayButtons = document.querySelectorAll('.day-btn');
    let selectedDays = [];
    if (daysAvailableInput.value) {
        try {
            selectedDays = JSON.parse(daysAvailableInput.value);
        } catch(e) {
            selectedDays = [];
        }
    }

    // Initialize buttons to match existing days
    function renderDayButtons() {
        dayButtons.forEach(button => {
            const day = button.getAttribute('data-day');
            button.classList.toggle('active', selectedDays.includes(day));
        });
        daysAvailableInput.value = JSON.stringify(selectedDays);
    }

    renderDayButtons();

    // Handle day button clicks
    dayButtons.forEach(button => {
        button.addEventListener('click', function() {
            const day = this.getAttribute('data-day');
            if (selectedDays.includes(day)) {
                selectedDays = selectedDays.filter(d => d !== day);
            } else {
                selectedDays.push(day);
            }
            renderDayButtons();
        });
    });

    // Handle employment type change
    function handleEmploymentTypeChange() {
        const selectedType = document.querySelector('input[name="employment_type"]:checked')?.value;
        
        if (selectedType === 'part-time') {
            // Part-time: hide company, show days, show termination date
            companyField.style.display = 'none';
            companySelect.removeAttribute('required');
            companySelect.value = '';
            daysAvailableField.style.display = 'flex';
            contractEndWrapper.style.display = 'block';
            contractEndInput.setAttribute('required', 'required');
        } else if (selectedType === 'full-time') {
            // Full-time: show company, hide days, hide termination date
            companyField.style.display = 'flex';
            companySelect.setAttribute('required', 'required');
            daysAvailableField.style.display = 'none';
            daysAvailableInput.value = '';
            selectedDays = [];
            dayButtons.forEach(btn => btn.classList.remove('active'));
            contractEndWrapper.style.display = 'none';
            contractEndInput.removeAttribute('required');
            contractEndInput.value = '';
        } else if (selectedType === 'contractual') {
            // Contractual: show company, hide days, show termination date
            companyField.style.display = 'flex';
            companySelect.setAttribute('required', 'required');
            daysAvailableField.style.display = 'none';
            daysAvailableInput.value = '';
            selectedDays = [];
            dayButtons.forEach(btn => btn.classList.remove('active'));
            contractEndWrapper.style.display = 'block';
            contractEndInput.setAttribute('required', 'required');
        }
    }

    // Add event listeners to employment type radios
    employmentTypeRadios.forEach(radio => {
        radio.addEventListener('change', handleEmploymentTypeChange);
    });

    // Initialize on page load
    handleEmploymentTypeChange();

    // File upload preview code
    const fileInput = document.getElementById('uploaded_documents');
    const previewContainer = document.getElementById('file-preview-container');
    const previewsDiv = document.getElementById('file-previews');
    const maxFileSize = 5 * 1024 * 1024; // 5MB in bytes
    
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const files = e.target.files;
            previewsDiv.innerHTML = '';
            
            if (files.length === 0) {
                previewContainer.style.display = 'none';
                return;
            }
            
            // Validate file sizes
            const oversizedFiles = [];
            Array.from(files).forEach(file => {
                if (file.size > maxFileSize) {
                    oversizedFiles.push(file.name);
                }
            });
            
            if (oversizedFiles.length > 0) {
                alert('The following files exceed 5MB and cannot be uploaded:\n\n' + oversizedFiles.join('\n') + '\n\nPlease select smaller files.');
                fileInput.value = ''; // Clear the file input
                previewContainer.style.display = 'none';
                return;
            }
            
            previewContainer.style.display = 'block';
            
            Array.from(files).forEach((file, index) => {
                const fileCard = document.createElement('div');
                fileCard.style.cssText = 'border: 1px solid #e5e7eb; border-radius: 8px; padding: 10px; background: #f9fafb; text-align: center;';
                
                const extension = file.name.split('.').pop().toLowerCase();
                
                // Preview area
                const previewDiv = document.createElement('div');
                previewDiv.style.cssText = 'height: 100px; display: flex; align-items: center; justify-content: center; margin-bottom: 8px; background: white; border-radius: 4px;';
                
                if (['jpg', 'jpeg', 'png'].includes(extension)) {
                    const img = document.createElement('img');
                    img.style.cssText = 'max-width: 100%; max-height: 100px; object-fit: contain;';
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        img.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                    previewDiv.appendChild(img);
                } else if (extension === 'pdf') {
                    previewDiv.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="#ef4444" viewBox="0 0 16 16">
                            <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                            <path d="M4.603 14.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.697 19.697 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.188-.012.396-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.066.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.712 5.712 0 0 1-.911-.95 11.651 11.651 0 0 0-1.997.406 11.307 11.307 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.266.266 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.71 12.71 0 0 1 1.01-.193 11.744 11.744 0 0 1-.51-.858 20.801 20.801 0 0 1-.5 1.05zm2.446.45c.15.163.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.876 3.876 0 0 0-.612-.053zM8.078 7.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z"/>
                        </svg>
                    `;
                }
                
                fileCard.appendChild(previewDiv);
                
                // File info
                const fileName = document.createElement('p');
                fileName.textContent = file.name.length > 20 ? file.name.substring(0, 17) + '...' : file.name;
                fileName.style.cssText = 'font-size: 0.75rem; margin: 0 0 4px 0; word-break: break-all; color: #374151; font-weight: 500;';
                fileCard.appendChild(fileName);
                
                const fileSize = document.createElement('p');
                fileSize.textContent = (file.size / 1024).toFixed(2) + ' KB';
                fileSize.style.cssText = 'font-size: 0.7rem; margin: 0; color: #6b7280;';
                fileCard.appendChild(fileSize);
                
                previewsDiv.appendChild(fileCard);
            });
        });
    }
});
</script>
<style>
    .note {
        font-size: 11.75px; 
        margin-top: -7px;
        color: #4B5563;
        margin-bottom: 20px;
        letter-spacing: 1.33px;
        width: 65%;
    }
</style>