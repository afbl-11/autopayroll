@props( ['icon' => null])

@php
    $btnClass = $icon ? 'button-image' : 'button-filled'
 @endphp
<button type="submit" {{$attributes->merge(['class' => $btnClass])}}>
    @if($icon)
        <img src="{{ asset($icon) }}" alt="icon" >
    @endif
    {{$slot}}
</button>

