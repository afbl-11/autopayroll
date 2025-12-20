@vite(['resources/css/company/company-info.css', 'resources/js/company/company-info.js'])

<x-app :noHeader="true" :navigation="true" :company="$company">
    <section class="main-content">
        <div class="information-card">

            {{-- HEADER --}}
            <div class="card-header">
                <h6>Company Information</h6>

                <div class="action-buttons">
                    <button type="button" id="editBtn" class="btn-edit">
                        Edit
                    </button>

                    <button type="submit"
                            form="companyForm"
                            id="saveBtn"
                            class="btn-save hidden">
                        Save
                    </button>
                </div>
            </div>

            <form id="companyForm"
                  method="POST"
                  action="{{ route('company.info.update', $company->getKey()) }}">
                @csrf
                @method('PUT')

                <div class="input-wrapper editable">
                    <x-form-input
                        class="form-input"
                        label="Company Owner"
                        id="owner"
                        name="owner"
                        :value="old('owner', trim($company->first_name . ' ' . $company->last_name))"
                        readonly
                    />

                    <div class="tin-field-wrapper">
                        <x-form-input
                            class="form-input {{ $errors->has('tin_number') ? 'tin-error' : '' }}"
                            label="TIN"
                            id="tin"
                            name="tin_number"
                            :value="old('tin_number', $company->tin_number)"
                            minlength="9"
                            maxlength="12"
                            readonly
                        />
                        @error('tin_number')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="input-wrapper editable">
                    <x-form-input
                        class="form-input"
                        label="Type of Industry"
                        id="industry"
                        name="industry"
                        :value="old('industry', $company->industry)"
                        readonly
                    />

                    <x-form-input
                        class="form-input"
                        label="Assigned employees"
                        id="employee-count"
                        :value="$company->employees->count()"
                        readonly
                        data-no-edit
                    />
                </div>
            </form>

            <h6 class="title-address">Address</h6>
            <div class="input-wrapper">
                <x-form-input
                    class="form-input"
                    label="Full address"
                    id="address"
                    :value="$company->address"
                    readonly
                    data-no-edit
                />
            </div>

            <div class="field-row">
                <x-form-input
                    class="form-input"
                    label="Longitude"
                    id="longitude"
                    value="43.1233"
                    readonly
                    data-no-edit
                />
                <x-form-input
                    class="form-input"
                    label="Latitude"
                    id="latitude"
                    value="123.4567"
                    readonly
                    data-no-edit
                />
            </div>
        </div>
    </section>
</x-app>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const editBtn = document.getElementById('editBtn');
    const saveBtn = document.getElementById('saveBtn');
    const form    = document.getElementById('companyForm');
    const tinField = document.getElementById('tin');
    if (tinField) {
        tinField.addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '');
        });
    }
    const hasErrors = @json($errors->has('tin_number'));
    if (!editBtn || !saveBtn || !form) return;

    const editableIds = ['owner', 'tin', 'industry'];

    function showCustomAlert(message) {
        const alert = document.createElement("div");
        alert.className = "custom-alert";
        alert.textContent = message;
        document.body.appendChild(alert);
        setTimeout(() => alert.remove(), 3500);
    }
    document.querySelectorAll('input, textarea, select').forEach(el => {
        el.style.pointerEvents = 'none';
        el.setAttribute('readonly', true);
    });

    function enableEditMode(reason = "edit") {
        editableIds.forEach(id => {
            const field = document.getElementById(id);
            if (!field) return;

            field.removeAttribute('readonly');
            field.style.pointerEvents = 'auto';
            field.classList.add('editing');
        });
        editBtn.classList.add('hidden');
        saveBtn.classList.remove('hidden');
        if (reason === "manual") {
            showCustomAlert("Edit mode enabled. You can now update company information.");
        }
    }

    editBtn.addEventListener('click', () => enableEditMode("manual"));
    if (hasErrors) {
        enableEditMode("error");
        const tinField = document.getElementById('tin');
        if (tinField) tinField.focus();
        showCustomAlert("You are still in Edit mode.");
    }

    form.addEventListener('submit', function () {
        showCustomAlert("Saving company information...");
    });
});

</script>
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function showCustomAlert(message) {
            const alert = document.createElement("div");
            alert.className = "custom-alert";
            alert.textContent = message;
            document.body.appendChild(alert);
            setTimeout(() => alert.remove(), 3500);
        }
        showCustomAlert(@json(session('success')));
    });
</script>
@endif