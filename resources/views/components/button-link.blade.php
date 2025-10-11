@props(['source' => '#'])

<div {{$attributes->merge(['class' => 'button-filled'])}}>
    <a href="{{route($source)}}">
            {{$slot}}
    </a>
</div>
