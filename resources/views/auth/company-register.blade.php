
@vite(['resources/css/employee_registration/address.css', 'resources/js/api/address-picker.js'])
<x-app :title="$title">

    <section class="main-content">

        <div class="form-wrapper">
            <form action="{{route('store.register.client')}}" method="post">
                @csrf
                <h5>Company Information</h5>

                <div class="field-row">
                    <x-form-input name="company_name" id="company_name" label="Company Name"></x-form-input>

                </div>

                <div class="field-row">
                   <x-form-input name="first_name" id="first_name" label="Owner First Name"></x-form-input>
                   <x-form-input name="last_name" id="last_name" label="Owner Last Name"></x-form-input>
                </div>
                {{--                tin and industry--}}
                <div class="field-row">
                    <x-form-input name="tin_number" id="tin_number" label="TIN" placeholder="9-12 digits"></x-form-input>
                    <x-form-input name="industry" id="industry" label="Industry" placeholder="e.g. Finance"></x-form-input>
                </div>
               <x-button-submit>Add Client</x-button-submit>
            </form>
        </div>
    </section>
</x-app>
