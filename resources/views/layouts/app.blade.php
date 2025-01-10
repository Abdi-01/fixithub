<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'FixIt Hub')</title>

    @if (app()->environment('local'))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
    <link rel="stylesheet" href="{{ asset('assets/app-C8h9l1WO.css') }}">
    @endif

    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="text-gray-900">
    <x-navbar />
    <div class="container min-h-screen mx-auto p-4 py-24">
        @yield('content')
    </div>
    <x-footer />
</body>

</html>