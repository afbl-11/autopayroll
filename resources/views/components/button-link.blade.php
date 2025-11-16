@props(['source' => '#', 'noDefault' => false])

@php
    // If $source is an array, the first element is the route name and the rest are params
    $url = is_array($source)
        ? route($source[0], $source[1] ?? [])
        : ($source !== '#' ? route($source) : '#');
@endphp

<div @if(!$noDefault){{ $attributes->class('field-input') }} @endif>
    <a href="{{ $url }}">
        {{ $slot }}
    </a>
</div>
