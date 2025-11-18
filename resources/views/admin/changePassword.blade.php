@vite('resources/css/settings/settings.css')

<x-app :title="$title">
    <section class="main-content">
        <div class="password-wrapper">
            <form action="{{route('change.password')}}" method="post">
                @csrf
                <x-form-input
                    type="password"
                    label="Current Password"
                    name="password"
                    id="password"
                />
                <x-form-input
                    type="password"
                    label="New Password"
                    name="new_password"
                    id="new_password"
                />

                <x-form-input
                    type="password"
                    label="Confirm Password"
                    name="new_password_confirmation"
                    id="password_confirmation"
                />

                <x-button-submit>Confirm</x-button-submit>
            </form>
        </div>
    </section>
</x-app>
