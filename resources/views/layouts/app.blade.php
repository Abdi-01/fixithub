<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline' fonts.bunny.net; font-src 'self' fonts.bunny.net;">

    <title>@yield('title', 'FixIt Hub')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    <!-- @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot'))) -->

    <!-- @vite('resources/css/app.css') -->
    <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) -->
    <!-- @else -->
    <link rel="stylesheet" href="{{ asset('assets/app-C1Xrcf8q.css') }}">
    <!-- @endif -->

</head>

<body class="bg-slate-200 text-gray-900">
    <x-navbar />
    <div class="container mx-auto p-4 py-24">
        @yield('content')
    </div>

</body>

</html>