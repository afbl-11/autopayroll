@vite(['resources/css/employee_registration/address.css', 'resources/js/api/address-picker.js'])
@php
    $logoPath = !empty($company->company_logo) && file_exists(public_path('storage/' . $company->company_logo))
        ? asset('storage/' . $company->company_logo)
        : asset('assets/default_establishment_picture.png');
@endphp

<x-app :title="$title">
    <section class="main-content">
        <div class="form-wrapper">
            <form action="{{ route('company.update', $company->company_id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <h5>Company Information</h5>
                <div class="field-row">
                    <div class="logo-upload-wrapper">
                        <div class="logo-preview">
                            <img id="logoPreview" src="{{ $logoPath }}" alt="Company Logo">
                        </div>

                        <label for="company_logo" class="upload-btn">
                            Change Logo
                            <input
                                type="file"
                                name="company_logo"
                                id="company_logo"
                                accept="image/png,image/jpeg,image/jpg,image/webp"
                                hidden
                            >
                        </label>
                    </div>
                </div>
                <div class="field-row">
                   <x-form-input name="company_name" id="company_name" label="Company Name" :value="$company->company_name"></x-form-input>
                      @error('first_name')
                          <p class="error-message">{{ $message }}</p>
                      @enderror
                </div>
                <div class="field-row">
                   <x-form-input name="first_name" id="first_name" label="Owner First Name" :value="$company->first_name"></x-form-input>
                   <x-form-input name="last_name" id="last_name" label="Owner Last Name" :value="$company->last_name"></x-form-input>
                </div>
                {{--                tin and industry--}}
                <div class="field-row">
                    <x-form-input name="tin_number" id="tin_number" label="TIN" placeholder="9-12 digits" :value="$company->tin_number"></x-form-input>
                    <x-form-input name="industry" id="industry" label="Industry" placeholder="e.g. Finance" :value="$company->industry"></x-form-input>
                </div>
               <x-button-submit>Save</x-button-submit>
            </form>
        </div>
    </section>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tinField = document.getElementById('tin_number');

        if (tinField) {
            tinField.addEventListener('input', function () {
                let value = this.value.replace(/\D/g, '');
                value = value.substring(0, 12);

                if (value.length > 9) {
                    value = value.replace(/(\d{3})(\d{3})(\d{3})(\d+)/, '$1-$2-$3-$4');
                } else if (value.length > 6) {
                    value = value.replace(/(\d{3})(\d{3})(\d+)/, '$1-$2-$3');
                } else if (value.length > 3) {
                    value = value.replace(/(\d{3})(\d+)/, '$1-$2');
                }

                this.value = value;
            });
        }

        const input = document.getElementById('company_logo');
        const preview = document.getElementById('logoPreview');

        input.addEventListener('change', () => {
            const file = input.files[0];
            if (!file || !file.type.startsWith('image/')) return;

            const reader = new FileReader();
            reader.onload = e => preview.src = e.target.result;
            reader.readAsDataURL(file);
        });
    });
</script>
<style>
    .logo-upload-wrapper {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .logo-preview img {
        width: 110px;
        height: 110px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid var(--clr-muted);
        background: #fff;
    }

    .upload-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 42px;
        padding: 0 18px;
        border-radius: 10px;
        background: #0f172a;
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 2px 5px 5px 0 rgba(136, 125, 125, 0.25);
    }

    .upload-btn:hover {
        background: #FFD858;
        color: #020617;
    }

    .error-message {
        color: #BA2A2A;
        font-size: 0.875rem;
        letter-spacing: 1.33px;
    }
</style>
</x-app>