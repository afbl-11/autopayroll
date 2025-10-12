@vite(['resources/css/employee_registration/accountSetup.css', 'resources/js/empOnboarding/addEmp.js'])

<x-app :title="$title" :showProgression="true">
    <section class="main-content">
        <div class="form-wrapper">
            <form class="form" action="{{route('store.employee.register.4')}}" method="post">
                @csrf
{{--                username and email--}}
                <div class="field-row">
                    <x-form-input name="username" id="username" label="User Name" required></x-form-input>
                </div>

                <div class="field-row">
                    <x-form-input type="text" name="email" id="email" label="Email" placeholder="Optional" :value="$email" :disabled="true"></x-form-input>
                </div>

{{--                password--}}
                <div class="field-row">
                    <x-form-input  type="text" name="password" id="password" label="Password" value="DefaultPassword123!" :disabled="true"></x-form-input>
                </div>

                <x-button-submit>Continue</x-button-submit>
            </form>
        </div>
    </section>
</x-app>

<script>
    const password = document.getElementById('password');
    const email = document.getElementById('email');

    password.classList.add('read-mode-only');
    email.classList.add('read-mode-only');
</script>
