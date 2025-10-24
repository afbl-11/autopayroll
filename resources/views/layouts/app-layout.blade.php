@vite('resources/css/app.css')
@props(['title' => '','showProgression' => false,
        'noHeader' => false,
        'navigation' => false, 'company' => '',
        'navigationType' => 'company',
        'type' => '', 'employee' => ''])
<x-root>
    @include('layouts.side-nav')
    <main>
        @if(!$noHeader)
            @include('components.header', ['title' => $title, 'source' => 'admin.profile'])
        @endif
        @if($navigation)
            @include('components.dashboard-navigation', [
                'type' => $navigationType,
                'name' => $navigationType === 'company'? $company->company_name : $employee->first_name . ' ' . $employee->last_name,
                'id' =>  $navigationType === 'company' ? $company->company_id : $employee->employee_id,
                'image' => 'assets/company-pic.jpg',
//                 $company->logo ?? $employee->avatar ?? 'assets/default.jpg',
                'tin' => $company->tin_number ?? null,
                'address' => $company->country ?? null,
                'industry' => $company->industry ?? null,
                'latitude' => $company->latitude ?? null,
                'longitude' => $company->longitude ?? null,
                'employee_count' => $navigationType === 'company' ? $company->employees->count()  : null,
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
