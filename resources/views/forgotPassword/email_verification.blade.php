@vite(['resources/css/forgotPassword/email_verification.css', 'resources/css/auth/auth.css'])

<x-root>
    <nav><x-logo-expanded/></nav>

    <section class="main-content">
        <div class="form-wrapper">
            <div class="header">
                <h2>Verify Email Address</h2>
                <small>Enter your email address to send OTP codes</small>
            </div>

            <form action="{{route('send.otp.request')}}" method="post">
                @csrf
                <x-form-input
                    type="email"
                    placeholder="Enter Email Address"
                    name="email"
                    required
                />

                <x-button-submit>Confirm</x-button-submit>
            </form>
        </div>
    </section>
</x-root>
