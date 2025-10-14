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
                    <x-form-input type="password" name="password" id="password" label="Password" class="toggleEye" required></x-form-input>

                    <a href="{{route('forgot.password')}}"><small>Forgot Password</small></a>
                </div>

                <x-button-submit>Sign in</x-button-submit>
            </form>
        </div>

    </section>
</x-root>
  <script>
    function togglePassword() {
    const passwordInput = document.getElementById("password");
    const icon = document.querySelector(".toggleEye");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        icon.textContent = "⌣";
    } else {
        passwordInput.type = "password";
        icon.textContent = "👁";
    }
}
 </script>
