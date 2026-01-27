@vite('resources/css/settings/settings.css')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<x-root>
    @include('layouts.employee-side-nav')
    <main class="main-content p-4">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="fw-bold mb-1" style="color: var(--clr-primary);">Settings</h2>
                    <p class="text-muted mb-0">Edit your profile information here.</p>
                </div>
            </div>
            <section class="main-content">
                <div class="settings-wrapper">
                    <div class="profile-settings">

                        <h3 class="settings-title">Profile Information</h3>

                        @if(session('success'))
                            <div id="success-alert" class="custom-alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('info'))
                            <div id="success-alert" class="custom-alert">
                                {{ session('info') }}
                            </div>
                        @endif

                        <form action="{{ route('employee_web.update.profile') }}"
                              method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="profile-photo">
                                <img
                                    src="{{ auth('employee_web')->user()->profile_photo
                                    ? asset('storage/' . auth('employee_web')->user()->profile_photo)
                                    : asset('assets/no_profile_picture.jpg') }}"
                                    alt="Profile Picture"
                                    class="avatar-preview"
                                    id="avatarPreview"
                                />

                                <label class="upload-btn">
                                    Change Photo
                                    <input type="file"
                                           name="profile_photo"
                                           accept="image/*"
                                           hidden
                                           id="profile-photo-input">
                                </label>
                            </div>

                            <div class="form-grid">

                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text"
                                           name="first_name"
                                           value="{{ old('first_name', auth('employee_web')->user()->first_name) }}"
                                           required>
                                    @error('first_name')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Middle Name</label>
                                    <input type="text"
                                           name="middle_name"
                                           value="{{ old('middle_name', auth('employee_web')->user()->middle_name) }}">
                                </div>

                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text"
                                           name="last_name"
                                           value="{{ old('last_name', auth('employee_web')->user()->last_name) }}"
                                           required>
                                </div>

                                <div class="form-group">
                                    <label>Suffix</label>
                                    <select name="suffix">
                                        @php
                                            $suffixes = ['' => 'None', 'Jr.' => 'Jr.', 'Sr.' => 'Sr.'];
                                            $currentSuffix = old('suffix', auth('employee_web')->user()->suffix);
                                        @endphp
                                        @foreach($suffixes as $key => $label)
                                            <option value="{{ $key }}" {{ $currentSuffix === $key ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

{{--                                <div class="form-group">--}}
{{--                                    <label>Company Name</label>--}}
{{--                                    <input type="text"--}}
{{--                                           name="company_name"--}}
{{--                                           value="{{ old('company_name', auth('employee_web')->user()->company_name ?? '') }}">--}}
{{--                                    @error('company_name')--}}
{{--                                    <p class="error-message">{{ $message }}</p>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
                            </div>

                            <button type="submit" class="btn-save">
                                Save Changes
                            </button>
                        </form>
                    </div>

                    <div class="links">
                        <a href="{{ route('change.password.view') }}">
                            <div class="settings-row">
                                <p>Change Password</p>
                            </div>
                        </a>

{{--                        <a href="{{ route('change.location.view') }}">--}}
{{--                            <div class="settings-row">--}}
{{--                                <p>Change Location</p>--}}
{{--                            </div>--}}
{{--                        </a>--}}
                    </div>

                    <div class="delete-btn">
                        <input type="checkbox"
                               id="delete-modal-toggle"
                               class="modal-toggle hidden">

                        <label for="delete-modal-toggle"
                               class="cursor-pointer delete-label">
                            Delete Account
                        </label>

                        <div class="modal">
                            <label for="delete-modal-toggle"
                                   class="modal-overlay"></label>

                            <div class="modal-content">
                                <h2>Confirm Account Deletion</h2>
                                <p>
                                    Please enter your password to confirm.
                                    This action cannot be undone.
                                </p>

                                <form action="{{ route('delete.account') }}"
                                      method="POST">
                                    @csrf

                                    <input type="password"
                                           name="password"
                                           placeholder="Enter your password"
                                           required
                                           class="password-input">

                                    <div class="modal-buttons">
                                        <label for="delete-modal-toggle"
                                               class="btn-cancel">
                                            Cancel
                                        </label>

                                        <button type="submit"
                                                class="btn-confirm">
                                            Confirm
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const input = document.getElementById('profile-photo-input');
                    const avatar = document.getElementById('avatarPreview');
                    const originalSrc = avatar.src;

                    input.addEventListener('change', () => {
                        const file = input.files[0];

                        if (!file) {
                            avatar.src = originalSrc;
                            return;
                        }

                        if (!file.type.startsWith('image/')) {
                            input.value = '';
                            avatar.src = originalSrc;
                            return;
                        }

                        const reader = new FileReader();

                        reader.onload = e => {
                            avatar.src = e.target.result;
                        };

                        reader.readAsDataURL(file);
                    });
                    const successAlert = document.getElementById('success-alert');
                    if (successAlert) {
                        setTimeout(() => {
                            successAlert.remove();
                        }, 3500);
                    }
                });
            </script>
        </div>
    </main>
</x-root>
<style>
    :root {
        --sidebar-width-collapsed: 80px;
        --sidebar-width-expanded: 260px;
    }

    .mb-4 {
        margin-left: 15px;
    }

    .main-content {
        margin-left: var(--sidebar-width-collapsed);
        width: calc(100% - var(--sidebar-width-collapsed));
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        background: var(--clr-background);
        padding-bottom: 50px;
        transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1),
                    width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .main-content.main-content-expanded {
        margin-left: var(--sidebar-width-expanded);
        width: calc(100% - var(--sidebar-width-expanded));
    }

    @media (max-width: 768px) {
        .main-content,
        .main-content.main-content-expanded {
            margin-left: 0 !important;
            width: 100% !important;
        }
    }

    .settings-wrapper {
        max-width: 750px;
        margin: auto;
        background: #ffffff;
        border-radius: 8px;
        padding: 30px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        border: 1px solid #d1d7e2;
        margin-top: 25px;
    }

    .settings-title {
        font-size: 1.4rem;
        font-weight: 700;
        letter-spacing: 1.33px;
        color: var(--clr-primary);
        margin-bottom: 20px;
    }

    .custom-alert {
        background: rgba(255, 216, 88, 0.15);
        border: 1px solid var(--clr-yellow);
        color: var(--clr-indigo);
        padding: 12px 15px;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 20px;
    }

    .profile-photo {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 25px;
    }

    .avatar-preview {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #d1d7e2;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }

    .upload-btn {
        background: var(--clr-yellow);
        border: 1px solid #dee2e6;
        padding: 8px 14px;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--clr-indigo);
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .upload-btn:hover {
        background: var(--clr-indigo);
        color: var(--clr-yellow);
        border-color: var(--clr-indigo);
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 18px;
        margin-bottom: 25px;
    }

    .form-group label {
        letter-spacing: 0.5px;
        font-size: 0.75rem;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 6px;
        display: block;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        border-radius: 8px;
        padding: 10px 14px;
        border: 1px solid #dee2e6;
        font-size: 0.9rem;
        transition: border-color 0.2s, box-shadow 0.2s;
        background: #fff;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: var(--clr-yellow);
        box-shadow: 0 0 0 0.2rem rgba(255, 216, 88, 0.15);
    }

    .error-message {
        font-size: 0.75rem;
        color: #dc3545;
        margin-top: 4px;
        letter-spacing: 1.33px;
    }

    .btn-save {
        background: var(--clr-yellow);
        color: var(--clr-indigo);
        border: none;
        padding: 10px 22px;
        border-radius: 8px;
        font-size: 0.85rem;
        letter-spacing: 0.4px;
        transition: all 0.2s ease;
    }

    .btn-save:hover {
        box-shadow: 0 4px 10px rgba(0,0,0,0.12);
        transform: translateY(-1px);
        background: var(--clr-indigo);
        color: var(--clr-yellow);
    }

    .links {
        margin-top: 30px;
        border-top: 1px solid #f1f5f9;
        padding-top: 15px;
        text-decoration: none;
    }

    .links a {
        text-decoration: none;
        color: inherit;
    }

    .settings-row {
        padding: 12px 10px;
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--clr-primary);
        transition: background 0.2s ease;
    }

    .settings-row:hover {
        background: rgba(88, 188, 255, 0.08);
    }

    .delete-btn {
        margin-top: 30px;
        text-align: right;
    }

    .delete-label:hover {
        color: var(--clr-indigo);
    }

    .delete-label {
        font-size: 0.8rem;
        color: white;
        cursor: pointer;
    }

    .modal-toggle {
        display: none;
    }

    .modal {
        pointer-events: none;
        opacity: 0;
        position: fixed;
        inset: 0;
        z-index: 999;
        transition: opacity 0.2s ease;
    }

    .modal-toggle:checked ~ .modal {
        opacity: 1;
        pointer-events: auto;
    }

    .modal-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.4);
    }

    .modal-content {
        position: relative;
        background: #fff;
        max-width: 420px;
        margin: 12% auto;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }

    .modal-content h2 {
        font-size: 1rem;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .modal-content p {
        font-size: 0.85rem;
        color: #6c757d;
        margin-bottom: 15px;
    }

    .password-input {
        width: 100%;
        padding: 10px 14px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        font-size: 0.9rem;
        margin-bottom: 18px;
    }

    .password-input:focus {
        outline: none;
        border-color: var(--clr-yellow);
        box-shadow: 0 0 0 0.2rem rgba(255, 216, 88, 0.15);
    }

    .modal-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .btn-cancel {
        padding: 8px 14px;
        border-radius: 8px;
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-confirm {
        padding: 8px 14px;
        border-radius: 8px;
        background: #dc3545;
        color: #fff;
        border: none;
        font-size: 0.8rem;
        font-weight: 700;
    }
</style>