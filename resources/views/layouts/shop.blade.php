<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Farhana - @yield('title', $title ?? 'Exclusive Moslem Wear')</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('farhana.svg') }}">

    @vite(['resources/css/app.css', 'resources/css/theme.css', 'resources/js/app.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('styles')
</head>
<body class="antialiased" x-data="{ openModal: null }">

    @include('partials.modals')
    @include('partials.navbar')

    @isset($header)
        <div class="max-w-7xl mx-auto px-6 lg:px-8 pt-10">{{ $header }}</div>
    @endisset

    <main>
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    @include('partials.footer')

    @stack('scripts')
</body>
</html>