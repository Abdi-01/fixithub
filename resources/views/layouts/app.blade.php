<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'FixIt Hub')</title>

    <link rel="stylesheet" href="{{ \App\Helpers\ViteHelper::asset('resources/css/app.css') }}">

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