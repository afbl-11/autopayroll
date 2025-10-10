@vite('resources/css/app.css')
@props(['title' => ''])
<x-root>
    @include('layouts.side-nav');
    @include('components.header', ['title' => $title, 'source' => 'admin.profile'])
    <main>
        {{$slot}}
    </main>

</x-root>
