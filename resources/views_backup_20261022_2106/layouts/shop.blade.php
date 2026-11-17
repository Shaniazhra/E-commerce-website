<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Farhana - @yield('title', 'Exclusive Moslem Wear')</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('farhana.svg') }}">

    @vite(['resources/css/app.css', 'resources/css/theme.css', 'resources/js/app.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('styles')
</head>
<body class="antialiased" x-data="{ openModal: null }">

    @include('partials.modals')
    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    @stack('scripts')
</body>
</html>