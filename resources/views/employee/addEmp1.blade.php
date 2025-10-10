@vite(['resources/css/theme.css', 'resources/css/employee_registration/basicInformation.css'])

<x-app title="{{$title}}" :showProgression="true">

    <section class="main-content">
        <div class="form-wrapper">
            <form action="{{route('store.employee.register.1')}}" method="post">
                @csrf
        {{--        first and last name--}}
                <div class="field-row">
                    <x-form-input  name="first_name" id="first_name"  label="First Name"></x-form-input>
                    <x-form-input name="last_name" id="last_name"  label="Last Name"></x-form-input>
                </div>

{{--                birthdate and age--}}
                <div class="field-row">
                    <x-form-input type="date" name="birthdate" id="birthdate"  label="Birth Date"></x-form-input>
                    <x-form-input name="age" id="age"  label="Age" value='10'></x-form-input>
                </div>
            </form>

            <div class="field-row">
                x-form-s
            </div>
        </div>
    </section>

</x-app>
