<!DOCTYPE html>
<html lang="en">

<head>
    @vite('resources/css/app.css')
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laravel')</title>

</head>

<body class="bg-gray-50">
    <main>
        @yield('content')
    </main>
    @vite('resources/js/app.js')
</body>

</html>