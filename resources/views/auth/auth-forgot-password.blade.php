@vite(['resources/css/auth/auth.css', 'resources/js/app.js', "resources/css/theme.css"])
<x-root>
    <nav><x-logo-expanded/></nav>
        <section class="main-content">
            <div class="form-wrapper">
                <h3 class="header">Reset Your Password</h3>
                <p id="description">Please enter a new password</p>

                <form class="form" action="{{ route('forgot.password.update') }}" method="POST">
                    @csrf
                    <input type="email" name="email" id="email" hidden value="{{$email}}">

                    <div class="field-row">
                        <x-form-input
                            type="password"
                            name="password"
                            id="password"
                            label="New Password"
                            required
                            togglePassword="true"
                        />
                    </div>

                    <div class="field-row">
                        <x-form-input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            label="Confirm Password"
                            required
                            togglePassword="true"
                        />
                    </div>

                    <div class="buttons">
                        <a href="{{ route('login') }}" class="btn-secondary">Cancel</a>
                        <x-button-submit>Continue</x-button-submit>
                    </div>
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
<style>
    .buttons {
        display: flex;
        gap: 20px;
        justify-content: space-between;
        margin-top: 30px;
    }

    .buttons a,
    .buttons button {
        flex: 1;
        height: 56px;
        font-size: 15px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        cursor: pointer;
        margin-bottom: 75px;
    }

    .btn-secondary {
        background-color: #fff;
        color: #1f2937;
        border: 2px solid #facc15;
        font-weight: 500;
        letter-spacing: 1.33px;
    }

    .btn-secondary:hover {
        background-color: #fefce8;
    }

    #description {
        margin-top: -35px;
        margin-bottom: 50px;
        letter-spacing: 1.33px;
    }

    @media (max-width: 600px){
        .header {
            font-size: 28px;
        }
    }

    @media (max-width: 480px){
        .header {
            font-size: 25px;
        }
    }
</style>
