<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Binary Tree View</title>
    @vite('resources/css/app.css') <!-- Include your CSS -->
</head>
<body class="bg-gray-100">
    <div id="app">
        @yield('content')
    </div>
    @vite('resources/js/app.js') <!-- Include your JS -->
</body>
</html>
