@props(['source' => '#', 'alt' => 'Profile Picture', 'image' => null])

@php
    $adminUser = auth('admin')->user();

    if ($adminUser && $adminUser->profile_photo) {
        // Add cache-busting
        $imgSrc = asset( $adminUser->profile_photo
                    ? 'storage/' . $adminUser->profile_photo
                    : 'assets/default_profile.jpg') . '?t=' . now()->timestamp;
    } else {
        $imgSrc = asset( $adminUser->profile_photo
                    ? 'storage/' . $adminUser->profile_photo
                    : 'assets/default_profile.jpg');
    }
@endphp

<div {{ $attributes->merge(['class' => 'image-link']) }}>
    <a href="{{ $source && Route::has($source) ? route($source) : $source }}">
        {{ $slot }}
        <img src="{{ $imgSrc }}" alt="{{ $alt }}">
    </a>
</div>
