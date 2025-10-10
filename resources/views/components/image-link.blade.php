@props(['source' => '#', 'image' => '', 'alt' => 'image'])

<div {{$attributes->merge(['class' => 'image-link'])}}>
    <a href="{{$source && Route::has($source) ? route($source) : '#' }}">
        {{$slot}}
        <img src="{{asset($image)}}" alt="image">
    </a>
</div>
