<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partitions.head')
    @vite('resources/css/theme.css')
</head>
<body>
@stack('scripts')
{{ $slot }}
</body>

</html>
