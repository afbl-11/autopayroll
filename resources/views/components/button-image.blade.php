@props(['type' => 'submit', 'icon' => null])

<button type="{{$type}}" {{$attributes->merge(['class' => 'button-image'])}}>
    @if($icon)
    <img src="{{ asset($icon) }}" alt="icon" class="w-6 h-6">
    @endif
    {{$slot}}
</button>
