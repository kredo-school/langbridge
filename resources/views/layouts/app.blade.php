<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} | @yield('title')</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="/fontawesome/css/all.min.css">
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!--Localize CDN after finally decided which font we will use-->

    <!-- Scripts -->
    @vite([
    'resources/sass/app.scss',
    'resources/js/app.js',
    'resources/css/style.css',
    'resources/js/profile.js',
    'resources/js/vocabulary-modal.js'
    ])
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="lang-blue">
    <div id="app" class="d-flex">
        <x-navbar />
        <div class="main-content flex-grow-1 rounded-3">
            <main class="py-4">
                @yield('content')
            </main>
        </div>
    </div>
</body>
@yield('scripts')

</html>