<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'FixIt Hub')</title>

    @vite('resources/css/app.css')


</head>

<body class="bg-slate-200 text-gray-900">
    <x-navbar />
    <div class="container mx-auto p-4 py-24">
        @yield('content')
    </div>

</body>

</html>