<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partitions.head')
</head>

<body>
    {{ $slot }}
</body>

</html>
