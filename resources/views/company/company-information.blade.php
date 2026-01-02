@vite(['resources/css/company/company-info.css', 'resources/js/company/company-info.js'])

<x-app :noHeader="true" :navigation="true" :company="$company">
    <section class="main-content">
        <nav>
            <a href="{{ route('company.edit', $company->company_id) }}"
            class="btn-edit">
                Edit Profile
            </a>
        </nav>
        <div class="information-card">

            {{-- HEADER --}}
            <div class="card-header">
                <h6>Company Information</h6>
            </div>

                <div class="input-wrapper">
                    <x-form-input
                        class="form-input"
                        label="Company Owner"
                        id="owner"
                        name="owner"
                        :value="old('owner', trim($company->first_name . ' ' . $company->last_name))"
                        readonly
                    />

                    <x-form-input
                        class="form-input"
                        label="TIN"
                        id="tin"
                        name="tin_number"
                        :value="old('tin_number', $company->tin_number)"
                        readonly
                    />
                </div>

                <div class="input-wrapper">
                    <x-form-input
                        class="form-input"
                        label="Type of Industry"
                        id="industry"
                        name="industry"
                        :value="old('industry', $company->industry)"
                        readonly
                    />

                    <x-form-input
                        class="form-input"
                        label="Assigned employees"
                        id="employee-count"
                        :value="$company->employees->count()"
                        readonly
                        data-no-edit
                    />
                </div>

            <h6 class="title-address">Address</h6>
            <div class="input-wrapper">
                <x-form-input
                    class="form-input"
                    label="Full address"
                    id="address"
                    :value="$company->address"
                    readonly
                    data-no-edit
                />
            </div>

            <div class="field-row">
                <x-form-input
                    class="form-input"
                    label="Longitude"
                    id="longitude"
                    value="43.1233"
                    readonly
                    data-no-edit
                />
                <x-form-input
                    class="form-input"
                    label="Latitude"
                    id="latitude"
                    value="123.4567"
                    readonly
                    data-no-edit
                />
            </div>
        </div>
        <div class="delete-company-wrapper">
            @if($company->employees->count() > 0)
                <button
                    class="btn-delete disabled"
                    disabled
                    title="Unassign all employees before deleting this company">
                    Delete Company
                </button>
            @else
                <form action="{{ route('company.destroy', $company->company_id) }}"
                    method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this company? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn-delete">
                        Delete Company
                    </button>
                </form>
            @endif

            @if($errors->has('delete'))
                <p class="delete-error">
                    {{ $errors->first('delete') }}
                </p>
            @endif
        </div>
    </section>
</x-app>
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
    .btn-delete {
        background: var(--clr-red);
        color: var(--clr-background);
        padding: 10px 15px;
        border-radius: 8px;
        font-weight: 400;
        cursor: pointer;
        margin-top: 35px;
        box-shadow: 2px 5px 5px 0 rgba(136, 125, 125, 0.25);
        letter-spacing: 1.33px;
        margin-bottom: 50px;
        border: none;
    }
    .btn-delete:hover {
        background: var(--clr-yellow);
        color: var(--clr-primary);
    }
    .btn-delete.disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }
    @media (max-width: 1150px){
        .btn-delete {
            margin-left: 50px;
        }
    }

    @media (max-width: 650px){
        .btn-delete {
            margin-left: 75px;
        }
    }

    @media (max-width: 500px){
        .btn-delete {
            margin-left: 70px;
        }
    }
</style>