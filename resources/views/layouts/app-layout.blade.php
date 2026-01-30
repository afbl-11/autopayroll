@vite('resources/css/app.css')
@props(['title' => '','showProgression' => false,
        'noHeader' => false,
        'navigation' => false, 'company' => '',
        'navigationType' => 'company',
        'type' => '', 'employee' => ''])

@php
    use Illuminate\Support\Facades\Storage;

    $companyLogoPath = !empty($company?->company_logo)
        ? Storage::url($company->company_logo)
        : asset('assets/company-pic.jpg');
@endphp

<x-root>
    @include('layouts.side-nav')
    <main>
        @if(!$noHeader)
            @include('components.header', ['title' => $title, 'source' => 'admin.profile'])
        @endif
        @if($navigation)
                @include('components.dashboard-navigation', [
                'type' => $navigationType,
                'name' => $navigationType === 'company'
                    ? $company->company_name
                    : $employee->first_name . ' ' . $employee->last_name,

                'id' => $navigationType === 'company'
                    ? $company->company_id
                    : $employee->employee_id,

                'companyLogo' => $companyLogoPath,

                'employeeProfile' => $navigationType === 'employee' && $employee && $employee->profile_photo
                    ? 'storage/' . $employee->profile_photo
                    : 'assets/default_profile.jpg',

                'tin' => $company->tin_number ?? null,
                'address' => $company->country ?? null,
                'industry' => $company->industry ?? null,
                'employee_count' => $navigationType === 'company'
                    ? $company->employees->count()
                    : null,
            ])
        @endif
        @if($showProgression === true)
            <section class="progression-status">
                <x-progression-status/>
            </section>
        @endif
        {{$slot}}
    </main>

</x-root>

{{--for employee assignment checkboxes--}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const cardWrappers = document.querySelectorAll('.employee-card-wrapper');

        cardWrappers.forEach(wrapper => {
            const checkbox = wrapper.querySelector('input[type="checkbox"]');
            const card = wrapper.querySelector('.employee-card');

            if (!checkbox || !card) return;

            card.addEventListener('click', (e) => {
                e.preventDefault();
                checkbox.checked = !checkbox.checked;


                card.classList.toggle('selected', checkbox.checked);
            });
        });
    });
</script>
