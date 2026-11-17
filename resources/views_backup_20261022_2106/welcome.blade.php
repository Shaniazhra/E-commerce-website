@extends('layouts.shop')

@section('title', 'Exclusive Moslem Wear')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
@endpush

@section('content')

    {{-- ══ HERO SLIDER ══ --}}
    <section class="relative overflow-hidden bg-[#E9E9E9]">
        <div class="swiper heroSwiper">
            <div class="swiper-wrapper">
                @forelse($sliders as $slider)
                    @php
                        $hasDesktop = !empty($slider->image_path);
                        $hasMobile  = !empty($slider->image_mobile_path);
                        $hasVideo   = !empty($slider->video_path);
                        $posterUrl  = \Storage::url($slider->image_path ?? $slider->image_mobile_path);
                    @endphp
                    <div class="swiper-slide relative {{ !$hasMobile && !$hasVideo ? 'desktop-only' : '' }} {{ !$hasDesktop && !$hasVideo ? 'mobile-only' : '' }}">
                        @if($hasVideo)
                            <video autoplay muted loop playsinline webkit-playsinline preload="auto" class="main-slider-img w-full h-full object-cover">
                                <source src="{{ asset('storage/' . $slider->video_path) }}" type="video/mp4">
                                <img src="{{ $posterUrl }}" class="w-full h-full object-cover">
                            </video>
                        @else
                            <picture>
                                @if($hasMobile)<source media="(max-width: 767px)" srcset="{{ \Storage::url($slider->image_mobile_path) }}">@endif
                                <img src="{{ $posterUrl }}" alt="{{ $slider->title }}" class="main-slider-img" loading="eager">
                            </picture>
                        @endif
                        <div class="absolute inset-0 bg-black/20"></div>
                        <div class="absolute inset-0 z-10 flex flex-col items-center justify-center text-center text-white px-4">
                            <h2 class="t-label mb-6" style="letter-spacing: 0.5em;">{{ $slider->title }}</h2>
                            <h1 class="t-hero mb-8">Exclusive Collection</h1>
                            <a href="#koleksi" class="btn btn-light mt-10">Shop Now</a>
                        </div>
                    </div>
                @empty
                    <div class="swiper-slide flex items-center justify-center bg-[#E9E9E9]">
                        <p class="t-label text-gray-400">No Banners Uploaded</p>
                    </div>
                @endforelse
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section>

    {{-- ══ PRODUCT COLLECTION ══ --}}
    <section id="koleksi" class="py-24 max-w-7xl mx-auto px-4">
        <div class="text-center mb-16">
            <h3 class="t-title mb-4">Our Collection</h3>
        </div>

        {{-- Category filter: swipeable on mobile, wrapped on desktop --}}
        <div class="category-scroll flex overflow-x-auto gap-6 mb-20 pb-2 md:flex-wrap md:justify-center md:gap-8 md:overflow-x-visible"
             style="-webkit-overflow-scrolling: touch; scrollbar-width: none; -ms-overflow-style: none; padding-left: 1rem;">
            <button type="button" data-category="all" onclick="filterCategory('all')" class="category-btn active">
                All Products
            </button>
            @foreach($categories as $cat)
                <button type="button" data-category="{{ $cat->slug }}" onclick="filterCategory('{{ $cat->slug }}')" class="category-btn">
                    {{ $cat->name }}
                </button>
            @endforeach
        </div>

        <div id="product-grid" class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-5 gap-x-6 gap-y-12">
            @forelse($products as $product)
                <a href="{{ route('product.details', $product->slug) }}"
                   class="group block no-underline product-item"
                   data-category="{{ $product->category->slug }}"
                   data-name="{{ strtolower($product->name) }}"
                   data-image="{{ $product->images->first() ? asset('storage/' . $product->images->first()->image_path) : '' }}"
                   data-price="IDR {{ number_format($product->price, 0, ',', '.') }}">
                    <div class="relative overflow-hidden aspect-[3/4] bg-[#E9E9E9] mb-6" style="border-radius: var(--radius-card);">
                        @if($product->images->first())
                            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition duration-1000 group-hover:scale-105">
                        @else
                            <div class="flex items-center justify-center h-full text-gray-300 t-caption">No Image</div>
                        @endif
                    </div>
                    <div class="text-center">
                        <h4 class="product-title t-label font-bold mb-1">{{ $product->name }}</h4>
                        <p class="t-caption text-muted mb-3">{{ $product->category->name ?? 'Collection' }}</p>
                        <p class="t-body font-light tracking-widest">IDR {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-20">
                    <p class="t-label text-gray-400">The collection is currently being updated.</p>
                </div>
            @endforelse
        </div>

        <div id="no-results" class="hidden text-center py-20">
            <p class="t-label text-gray-400">No products found matching your search.</p>
        </div>
    </section>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            /* Keep only the slides that match the current screen size */
            const isMobile = window.innerWidth < 768;
            document.querySelectorAll('.swiper-slide').forEach(el => {
                if (el.querySelector('video')) return;
                if (isMobile && el.classList.contains('desktop-only')) el.remove();
                if (!isMobile && el.classList.contains('mobile-only')) el.remove();
            });

            new Swiper('.heroSwiper', {
                loop: true,
                effect: 'fade',
                fadeEffect: { crossFade: true },
                autoplay: { delay: 5000, disableOnInteraction: false },
                pagination: { el: '.swiper-pagination', clickable: true },
                observer: true,
                observeParents: true,
            });

            /* Arriving from another page: /?category=slug or /?search=term */
            const params   = new URLSearchParams(window.location.search);
            const category = params.get('category');
            const search   = params.get('search');

            if (category) filterCategory(category);

            if (search) {
                const input = document.getElementById('search-input');
                toggleSearch();
                input.value = search;
                input.dispatchEvent(new Event('input'));
            }
        });
    </script>
@endpush