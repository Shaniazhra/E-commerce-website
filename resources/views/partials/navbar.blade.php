@php
    // Works on every page: uses $categories if the controller passed it, otherwise loads it here.
    $categories = $categories ?? \App\Models\Category::orderBy('name')->get();
@endphp

{{-- ══ NAVBAR ══ --}}
<header class="sticky top-0 z-50">
    <nav class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">

                {{-- Left: burger + logo --}}
                <div class="flex items-center">
                    <div class="flex items-center md:hidden mr-2 ml-2 relative z-20">
                        <button id="mobile-menu-button" aria-label="Open menu" class="text-gray-600 hover:text-black focus:outline-none p-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                    </div>
                    <a href="{{ route('home') }}" class="shrink-0 flex items-center">
                        <img src="{{ Storage::url('LOGO-FARHANA-NEW-TRANSPARENT.png') }}"
                             alt="Farhana"
                             class="h-14 md:h-20 w-auto object-contain">
                    </a>
                </div>

                {{-- Center: desktop links --}}
                <div class="hidden md:flex space-x-10 items-center">
                    <a href="{{ route('home') }}#koleksi" class="nav-link">Shop All</a>

                    <div class="group relative">
                        <button type="button" class="nav-link flex items-center">
                            Collections
                            <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div class="mega-menu pt-10 pb-12 shadow-2xl animate-fade-in-down">
                            <div class="max-w-7xl mx-auto px-8 grid grid-cols-4 gap-12">
                                @foreach($categories as $cat)
                                    <div>
                                        <h4 class="t-label font-bold text-gray-900 mb-5 border-b pb-2">{{ $cat->name }}</h4>
                                        <button type="button" onclick="filterCategory('{{ $cat->slug }}')"
                                                class="t-caption text-gray-500 hover:text-black transition">
                                            {{ $cat->name }}
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <a href="#about" class="nav-link">About</a>
                </div>

                {{-- Right: search, cart, account --}}
                <div class="flex items-center space-x-1 md:space-x-4">
                    <button type="button" onclick="toggleSearch()" aria-label="Search" class="p-1.5 text-gray-600 hover:text-black transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                    <div class="p-1.5"><x-cart-count /></div>
                    @auth
                        <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}" aria-label="Account" class="p-1.5 text-gray-600 hover:text-black transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('login') }}" aria-label="Login" class="p-1.5 text-gray-600 hover:text-black transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                            </svg>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Search bar --}}
    <div id="search-container">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center flex-1 min-w-0 pl-5 md:pl-0">
                <div class="text-gray-400 mr-4 shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" id="search-input" autocomplete="off" placeholder="Search for..."
                       class="t-label w-full bg-transparent border-none focus:ring-0 focus:outline-none font-light placeholder-gray-300 py-0 leading-none">
            </div>
            <button type="button" onclick="toggleSearch()" aria-label="Close search" class="text-gray-400 hover:text-black transition ml-4 pr-8 md:pr-0 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div id="search-results-overlay" class="pb-12 animate-fade-in-down">
            <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-12 mt-8">
                <div class="md:col-span-1">
                    <h5 class="t-caption font-bold text-gray-400 mb-6 border-b pb-2">Suggestions</h5>
                    <ul id="suggestion-list" class="space-y-3"></ul>
                </div>
                <div class="md:col-span-3">
                    <h5 class="t-caption font-bold text-gray-400 mb-6 border-b pb-2">Products</h5>
                    <div id="suggestion-products" class="grid grid-cols-2 md:grid-cols-4 gap-6"></div>
                </div>
            </div>
        </div>
    </div>
</header>

{{-- ══ MOBILE MENU ══ --}}
<div id="mobile-menu" class="fixed inset-0 bg-white z-[60] md:hidden flex flex-col p-8 space-y-8">
    <div class="flex justify-end">
        <button id="close-menu-button" aria-label="Close menu" class="text-gray-500 p-2">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    <nav class="flex flex-col space-y-6">
        <a href="{{ route('home') }}#koleksi" onclick="toggleMenu()" class="nav-link border-b pb-2">Shop All</a>
        <div class="space-y-4">
            <p class="t-caption text-gray-400">Collections</p>
            <div class="grid grid-cols-1 gap-4 pl-4">
                @foreach($categories as $cat)
                    <button type="button" onclick="filterCategory('{{ $cat->slug }}'); toggleMenu();"
                            class="text-left t-label hover:text-gray-500">
                        {{ $cat->name }}
                    </button>
                @endforeach
            </div>
        </div>
        <a href="#about" onclick="toggleMenu()" class="nav-link border-b pb-2">About</a>
    </nav>
</div>

<script>
    (function () {
        const homeUrl = @json(route('home'));

        const esc = s => s.replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
        const productItems = () => Array.from(document.querySelectorAll('.product-item'));

        /* Mobile menu */
        const mobileMenu = document.getElementById('mobile-menu');
        window.toggleMenu = function () { mobileMenu.classList.toggle('open'); };
        document.getElementById('mobile-menu-button').addEventListener('click', toggleMenu);
        document.getElementById('close-menu-button').addEventListener('click', toggleMenu);

        /* Search */
        const searchBox   = document.getElementById('search-container');
        const searchInput = document.getElementById('search-input');
        const overlay     = document.getElementById('search-results-overlay');
        const sugList     = document.getElementById('suggestion-list');
        const sugProducts = document.getElementById('suggestion-products');

        window.toggleSearch = function () {
            searchBox.classList.toggle('active');
            if (searchBox.classList.contains('active')) {
                setTimeout(() => searchInput.focus(), 300);
            } else {
                searchInput.value = '';
                overlay.classList.remove('show');
            }
        };

        function renderSuggestions(term) {
            sugList.innerHTML = '';
            sugProducts.innerHTML = '';

            const matches = productItems().filter(i => i.dataset.name.includes(term));

            if (!matches.length) {
                sugList.innerHTML = '<li class="t-caption text-gray-400">No matching found</li>';
                return;
            }

            // Show the product's real name (original capitalisation); matching uses the lowercase data-name
            const titles = [...new Set(matches.map(m => m.querySelector('.product-title').innerText.trim()))].slice(0, 5);
            titles.forEach(title => {
                const at = title.toLowerCase().indexOf(term);
                const li = document.createElement('li');
                li.className = 't-caption cursor-pointer hover:text-gray-400 transition';
                li.innerHTML = at === -1
                    ? esc(title)
                    : esc(title.slice(0, at)) + '<span class="font-bold text-black">' + esc(title.slice(at, at + term.length)) + '</span>' + esc(title.slice(at + term.length));
                li.onclick = () => { searchInput.value = title; renderSuggestions(title.toLowerCase()); };
                sugList.appendChild(li);
            });

            matches.slice(0, 4).forEach(item => {
                const div = document.createElement('div');
                div.innerHTML = `
                    <a href="${esc(item.getAttribute('href'))}" class="block group">
                        <div class="aspect-[3/4] bg-gray-100 overflow-hidden mb-3">
                            <img src="${esc(item.dataset.image)}" alt="" class="w-full h-full object-cover transition duration-700 group-hover:scale-105">
                        </div>
                        <h6 class="t-caption font-bold mb-1">${esc(item.querySelector('.product-title').innerText)}</h6>
                        <p class="t-caption text-gray-400">${esc(item.dataset.price)}</p>
                    </a>`;
                sugProducts.appendChild(div);
            });
        }

        searchInput.addEventListener('input', function (e) {
            const term = e.target.value.toLowerCase().trim();
            // Product list only exists on the home page; elsewhere Enter sends the visitor there.
            if (term && productItems().length) {
                overlay.classList.add('show');
                renderSuggestions(term);
            } else {
                overlay.classList.remove('show');
            }
        });

        searchInput.addEventListener('keydown', function (e) {
            const term = searchInput.value.trim();
            if (e.key === 'Enter' && term && !productItems().length) {
                window.location.href = homeUrl + '?search=' + encodeURIComponent(term) + '#koleksi';
            }
        });

        /* Category filter (on other pages it sends the visitor to the home page) */
        window.filterCategory = function (category) {
            if (!document.getElementById('product-grid')) {
                window.location.href = homeUrl + '?category=' + encodeURIComponent(category) + '#koleksi';
                return;
            }

            document.querySelectorAll('.category-btn').forEach(btn => {
                btn.classList.toggle('active', btn.dataset.category === category);
            });
            productItems().forEach(p => {
                p.style.display = (category === 'all' || p.dataset.category === category) ? 'block' : 'none';
            });
            document.getElementById('koleksi').scrollIntoView({ behavior: 'smooth', block: 'start' });
        };
    })();
</script>