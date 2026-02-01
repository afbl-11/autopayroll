@vite('resources/css/company/company-cards.css')

@php
    $logoPath = !empty($logo) && file_exists(public_path('storage/' . $logo))
        ? asset('storage/' . $logo)
        : asset('assets/default_establishment_picture.png');
@endphp

<a href="{{ route('company.dashboard.detail', ['id'=> $id]) }}" class="company-row-link">
    <div class="company-row">

        <div class="col col-id">
            #{{ $id }}
        </div>

        <div class="col col-company">
            <img src="{{ $logoPath }}" class="company-logo">
            <div class="company-text">
                <p class="company-name">{{ $name }}</p>
                <span class="company-industry">{{ $industry }}</span>
            </div>
        </div>

        <div class="col col-address">
            {{ $address }}
        </div>

        <div class="col col-employees">
            {{ $count }} employees
        </div>

    </div>
</a>
