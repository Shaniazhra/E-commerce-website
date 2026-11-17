@props(['title' => null])
@php
    $hideSidebar = request()->routeIs('admin.dashboard');
    $nav = [
        'Utama' => [
            ['label' => 'Dashboard',       'route' => 'admin.dashboard',         'match' => 'admin.dashboard'],
        ],
        'Transaksi' => [
            ['label' => 'Kelola Order',    'route' => 'admin.orders.index',      'match' => 'admin.orders.*'],
        ],
        'Katalog' => [
            ['label' => 'Kelola Kategori', 'route' => 'admin.categories.index', 'match' => 'admin.categories.*'],
            ['label' => 'Kelola Produk',   'route' => 'admin.products.index',    'match' => 'admin.products.*'],
            ['label' => 'Size Guide',      'route' => 'admin.size-guides.index', 'match' => 'admin.size-guides.*'],
            ['label' => 'Kelola Banner',   'route' => 'admin.sliders.index',     'match' => 'admin.sliders.*'],
        ],
    ];
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin' }} - Farhana</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('farhana.svg') }}">

    @vite(['resources/css/app.css', 'resources/css/theme.css', 'resources/js/app.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak] { display: none !important; }</style>
    @stack('styles')
</head>
<body class="antialiased bg-brand-light" x-data="{ menu: false }">
<div class="flex min-h-screen">

    @unless($hideSidebar)
        <div x-show="menu" x-cloak @click="menu = false"
             class="fixed inset-0 z-40 bg-brand-primary/60 backdrop-blur-sm md:hidden"></div>

        <aside :class="{ '!translate-x-0': menu }"
               class="fixed inset-y-0 left-0 z-50 flex w-64 shrink-0 -translate-x-full flex-col bg-brand-primary transition-transform duration-300 md:sticky md:top-0 md:h-screen md:translate-x-0">

            <div class="flex items-center justify-between border-b border-white/10 px-7 py-7">
                <div>
                    <span class="block text-[13px] font-black uppercase tracking-[.35em] text-white">Farhana</span>
                    <span class="mt-0.5 block text-[8px] uppercase tracking-[.4em] text-white/40">Admin Panel</span>
                </div>
                <button type="button" @click="menu = false" aria-label="Tutup menu"
                        class="flex h-8 w-8 items-center justify-center rounded-full bg-white/10 text-lg text-white md:hidden">&times;</button>
            </div>

            <nav class="flex-1 space-y-1 overflow-y-auto px-4 py-6">
                @foreach($nav as $group => $links)
                    <p class="mb-3 px-3 text-[8px] font-black uppercase tracking-[.35em] text-white/35 {{ $loop->first ? '' : 'mt-6' }}">{{ $group }}</p>
                    @foreach($links as $link)
                        <a href="{{ route($link['route']) }}"
                           class="block rounded-xl px-4 py-2.5 text-[11px] font-bold uppercase tracking-[.15em] transition-colors {{ request()->routeIs($link['match']) ? 'bg-white/15 text-white' : 'text-white/60 hover:bg-white/10 hover:text-white' }}">
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                @endforeach
            </nav>
        </aside>
    @endunless

    <div class="flex min-w-0 flex-1 flex-col">
        <header class="sticky top-0 z-30 flex items-center gap-3 border-b border-brand-light bg-white px-4 py-4 md:px-8">
            @unless($hideSidebar)
                <button type="button" @click="menu = true" aria-label="Buka menu"
                        class="rounded-xl p-2 text-brand-olive hover:bg-brand-light md:hidden">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            @endunless

            <div class="min-w-0 flex-1">{{ $header ?? '' }}</div>

            <a href="{{ route('home') }}" target="_blank"
               class="text-[10px] font-bold uppercase tracking-[.2em] text-brand-olive transition-colors hover:text-brand-primary">Lihat Toko</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="text-[10px] font-bold uppercase tracking-[.2em] text-red-500/70 transition-colors hover:text-red-600">Logout</button>
            </form>
        </header>

        <main class="flex-1">
            {{ $slot }}
        </main>
    </div>
</div>
@stack('scripts')
</body>
</html>