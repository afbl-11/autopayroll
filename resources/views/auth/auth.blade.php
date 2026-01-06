@vite(['resources/css/auth/auth.css', 'resources/js/app.js', "resources/css/theme.css"])
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<x-root>
    <nav><x-logo-expanded/></nav>
    <section class="main-content">
        <div class="form-wrapper">
            <h3 class="header">Welcome Back!</h3>

            <form class="form" action="{{route('login.admin')}}" method="post">
                @csrf
                <div class="field-row">
                    <x-form-input type="pass" name="email" id="email" label="Email Address" required></x-form-input>
                </div>

                <div class="field-row">
                    <x-form-input type="password" name="password" id="password" label="Password" class="toggleEye" required togglePassword="true"></x-form-input>

                    <a href="{{ route('forgot.password') }}"><small>Forgot Password</small></a>
                </div>

                    {{-- CAPTCHA --}}
                <div class="field-row captcha-row">
                    <div class="g-recaptcha"
                        data-sitekey="{{ config('services.recaptcha.site_key') }}">
                    </div>
                </div>

                <x-button-submit>Sign in</x-button-submit>
            </form>
        </div>

    </section>
</x-root>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll(".toggle-eye").forEach((eye) => {
            eye.addEventListener("click", function () {
                const input = document.getElementById(this.dataset.target);
                if (!input) return;

                const eyeIcon = this.querySelector(".eye-icon");
                const eyeOffIcon = this.querySelector(".eye-off-icon");

                if (input.type === "password") {
                    input.type = "text";
                    eyeIcon.style.display = "none";
                    eyeOffIcon.style.display = "block";
                } else {
                    input.type = "password";
                    eyeIcon.style.display = "block";
                    eyeOffIcon.style.display = "none";
                }
            });
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
<style>
    .captcha-row {
        display: flex;
        justify-content: center;
        margin: 15px 0;
    }

    .error {
        color: #dc2626;
        font-size: 0.75rem;
    }
</style>