@props(['type' => 'button', 'icon' => null])

<button type="submit" {{$attributes->merge(['class' => 'button-image'])}}>
    @if($icon)
    <img src="{{ asset($icon) }}" alt="icon" class="w-6 h-6">
    @endif
    {{$slot}}
</button>
