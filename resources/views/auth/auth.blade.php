@vite(['resources/css/auth/auth.css', 'resources/js/app.js', "resources/css/theme.css"])
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

                    <a href="{{route('forgot.password')}}"><small>Forgot Password</small></a>
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
