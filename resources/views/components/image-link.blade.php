@props(['source' => '#', 'alt' => 'Profile Picture'])

@php
    $adminUser = auth('admin')->user();

    if ($adminUser && $adminUser->profile_photo) {
        // Add cache-busting
        $imgSrc = asset('storage/' . $adminUser->profile_photo) . '?t=' . now()->timestamp;
    } else {
        $imgSrc = asset('images/default-avatar.png');
    }
@endphp

<div {{ $attributes->merge(['class' => 'image-link']) }}>
    <a href="{{ $source && Route::has($source) ? route($source) : $source }}">
        {{ $slot }}
        <img src="{{ $imgSrc }}" alt="{{ $alt }}">
    </a>
</div>