@vite('resources/css/settings/settings.css')

<x-app :title="$title">

    <section class="main-content">
        <div class="settings-wrapper">
            <div class="profile-settings">

                <h3 class="settings-title">Profile Information</h3>

                @if(session('success'))
                    <div id="success-alert" class="custom-alert">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('admin.profile.update') }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="profile-photo">
                        <img
                            src="{{ auth('admin')->user()->profile_photo
                                    ? asset('storage/' . auth('admin')->user()->profile_photo)
                                    : asset('images/default-avatar.png') }}"
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
                                   value="{{ old('first_name', auth('admin')->user()->first_name) }}"
                                   required>
                        </div>

                        <div class="form-group">
                            <label>Middle Name</label>
                            <input type="text"
                                   name="middle_name"
                                   value="{{ old('middle_name', auth('admin')->user()->middle_name) }}">
                        </div>

                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text"
                                   name="last_name"
                                   value="{{ old('last_name', auth('admin')->user()->last_name) }}"
                                   required>
                        </div>

                        <div class="form-group">
                            <label>Suffix</label>
                            <select name="suffix">
                                @php
                                    $suffixes = ['' => 'None', 'Jr.' => 'Jr.', 'Sr.' => 'Sr.'];
                                    $currentSuffix = old('suffix', auth('admin')->user()->suffix);
                                @endphp
                                @foreach($suffixes as $key => $label)
                                    <option value="{{ $key }}" {{ $currentSuffix === $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Company Name</label>
                            <input type="text"
                                   name="company_name"
                                   value="{{ old('company_name', auth('admin')->user()->company_name ?? '') }}">
                        </div>
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

                <a href="{{ route('change.location.view') }}">
                    <div class="settings-row">
                        <p>Change Location</p>
                    </div>
                </a>
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
</x-app>