

@props(['header' => '', 'title' => '', 'user' => '', 'admin' => false, 'image' => '#','source' => '#', 'showProgression' => false])

<header>
    <h3>{{$title}}</h3>
    @if($admin === true)
        <div class="user-profile">
            <x-image-link :image="$image" :source="$source"> <h6>{{"HELLO," ." ". $user . " " . "!"}}</h6></x-image-link>
        </div>
    @endif
</header>
@if($showProgression === true)
    <section class="progression-status">
        <x-progression-status/>
    </section>
@endif
