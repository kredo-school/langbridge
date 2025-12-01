<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} | @yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js','resources/css/style.css'])
</head>
<body style="background-color: #c1cfec;">
    <div id="app" class="d-flex">
        <x-navbar />
        <div class="main-content flex-grow-1 rounded-3" style="background-color: #ffffff; margin-top: 20px; margin-right: 20px;">
            <main class="py-4">
                @yield('content')
            </main>
        </div>
    </div>
</body>
@yield('scripts')
</html>