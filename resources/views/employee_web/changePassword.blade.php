@vite('resources/css/settings/settings.css')
<style>
    .main-content {
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
    }
</style>
<x-root >

    @include('layouts.employee-side-nav')
    <section class="main-content">
        <div class="password-wrapper">
            <form action="{{route('employee_web.settings.changePassword.success')}}" method="post">
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
</x-root>
