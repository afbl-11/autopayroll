@vite('resources/css/app.css')
@props(['title' => '','showProgression' => false, 'noHeader' => false,'companyHeader' => false, 'company' => ''])
<x-root>
    @include('layouts.side-nav')
    <main>
        @if(!$noHeader)
            @include('components.header', ['title' => $title, 'source' => 'admin.profile'])
        @endif
        @if($companyHeader)
                @include('components.company-header', [
        'name' => $company->company_name,
        'id' => $company->company_id,
        'logo' => 'assets/company-pic.jpg',
        'tin' => $company->tin_number,
        'address' => $company->country,
        'industry' => $company->industry,
        'latitude' => '',
        'longitude' => '',
        'employee_count' => $company->employees->count(),
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
