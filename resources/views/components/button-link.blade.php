@props(['source' => '#', 'noDefault' => false])

<div @if(!$noDefault){{ $attributes->merge(['class' => 'field-input']) }} @endif>
    <a href="{{route($source)}}">
            {{$slot}}
    </a>
</div>
