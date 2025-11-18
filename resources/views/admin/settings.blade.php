@vite('resources/css/settings/settings.css')

<x-app :title="$title">

    <section class="main-content">
        <div class="settings-wrapper">
            <div class="links">
                <a href="{{route('change.password.view')}}">
                    <div class="settings-row">
                        <p>Change Password</p>
                    </div>
                </a>
                <a href="{{route('change.location.view')}}">
                    <div class="settings-row">
                        <p>Change Location</p>
                    </div>
                </a>
            </div>


            <!-- Delete Account Button -->
            <div class="delete-btn">
                <!-- Hidden checkbox to toggle modal -->
                <input type="checkbox" id="delete-modal-toggle" class="modal-toggle hidden">

                <label for="delete-modal-toggle" class="cursor-pointer">
                    Delete Account
                </label>

                <!-- Modal -->
                <div class="modal">
                    <label for="delete-modal-toggle" class="modal-overlay"></label>
                    <div class="modal-content">
                        <h2>Confirm Account Deletion</h2>
                        <p>Please enter your password to confirm. This action cannot be undone.</p>

                        <form action="{{ route('delete.account') }}" method="POST">
                            @csrf
                            <input type="password" name="password" placeholder="Enter your password" required
                                   class="password-input">

                            <div class="modal-buttons">
                                <label for="delete-modal-toggle" class="btn-cancel">Cancel</label>
                                <button type="submit" class="btn-confirm">Confirm</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>
</x-app>
