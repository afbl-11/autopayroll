@vite('resources/css/app.css')
@props(['title' => '','showProgression' => false])
<x-root>
    @include('layouts.side-nav')
    <main>
    @include('components.header', ['title' => $title, 'source' => 'admin.profile'])
        @if($showProgression === true)
            <section class="progression-status">
                <x-progression-status/>
            </section>
        @endif
        {{$slot}}
    </main>

</x-root>
