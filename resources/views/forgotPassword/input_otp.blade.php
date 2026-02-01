@vite(['resources/css/forgotPassword/email_verification.css', 'resources/css/auth/auth.css'])

<x-root>
    <nav><x-logo-expanded/></nav>

    <section class="main-content">
        <div class="form-wrapper">
            <div class="header">
                <h2>Enter OTP Code</h2>
                <small>An OTP code was sent to your email {{$email}}</small>
            </div>

            <form action="{{route('verify.otp')}}" method="post">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <x-form-input
                    type="text"
                    name="otp"
                    id="otp"
                    placeholder="XXXXXX"
                    required
                />

                <x-button-submit>Confirm</x-button-submit>
            </form>
            <form action="{{ route('send.otp.request') }}" method="POST" style="display:inline;">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                Did not receive an email?
                <button type="submit" style="background:none;border:none;color:#4A90E2;text-decoration:underline;cursor:pointer;">
                    Click here to resend OTP
                </button>
            </form>

        </div>
    </section>
</x-root>
