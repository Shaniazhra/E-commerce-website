{{-- ══ FOOTER ══ --}}
<footer id="about" class="bg-[#2F3526] text-white">

    <div class="w-full px-6 pt-16 pb-14">
        <div class="grid grid-cols-1 md:grid-cols-[1.5fr_1fr_1fr] gap-16 text-left items-start">

            {{-- About --}}
            <div>
                <h4 class="t-caption font-bold mb-6">About Farhana</h4>
                <p class="t-label text-white/80 leading-loose">
                    Farhana comes through a simplicity that feels calm, graceful, and meaningful.
                    We believe that modesty is not merely a way of dressing, but a way of carrying oneself with faith, serenity, and understated beauty.
                    Every collection is designed with attention to detail, comfort, and elegant silhouettes to accompany Muslim women in every step they take.
                    <br><br>
                    Luxury in Modesty.<br>
                    Elegance with Iman.
                </p>
            </div>

            {{-- Customer Care --}}
            <div>
                <h4 class="t-caption font-bold mb-6">Customer Care</h4>
                <div class="flex flex-col gap-3">
                    <button type="button" @click="openModal = 'contact'"  class="text-left t-label text-white/80 hover:text-white hover:translate-x-1 transition-all duration-200">Contact Us</button>
                    <button type="button" @click="openModal = 'shipping'" class="text-left t-label text-white/80 hover:text-white hover:translate-x-1 transition-all duration-200">Shipping &amp; Returns</button>
                    <button type="button" @click="openModal = 'howtobuy'" class="text-left t-label text-white/80 hover:text-white hover:translate-x-1 transition-all duration-200">How To Buy</button>
                    <button type="button" @click="openModal = 'faqs'"     class="text-left t-label text-white/80 hover:text-white hover:translate-x-1 transition-all duration-200">FAQs</button>
                </div>
            </div>

            {{-- Follow Us --}}
            <div>
                <h4 class="t-caption font-bold mb-6">Follow Us</h4>
                <div class="flex flex-col items-start gap-4">

                    {{-- Instagram --}}
                    <div class="flex items-center gap-3">
                        <a href="https://www.instagram.com/farhanas.id"
                           class="w-9 h-9 rounded-full bg-white flex items-center justify-center text-[#2F3526] hover:bg-[#E9E9E9] transition flex-shrink-0"
                           target="_blank" rel="noopener" aria-label="Instagram Farhana">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        <span class="t-caption text-white/80">@farhanas.id</span>
                    </div>

                    {{-- TikTok --}}
                    <div class="flex items-center gap-3">
                        <a href="https://www.tiktok.com/@farhanas.id"
                           class="w-9 h-9 rounded-full bg-white flex items-center justify-center text-[#2F3526] hover:bg-[#E9E9E9] transition flex-shrink-0"
                           target="_blank" rel="noopener" aria-label="TikTok Farhana">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.17-2.86-.6-4.12-1.31a8.52 8.52 0 0 1-1.87-1.43v6.24c-.03 2.34-.79 4.7-2.6 6.13-1.81 1.43-4.39 1.83-6.57 1.15-2.18-.68-4.05-2.48-4.66-4.67-.61-2.19-.19-4.78 1.25-6.58 1.44-1.8 3.84-2.74 6.11-2.43v4.18c-1.13-.19-2.36.03-3.23.82-.87.79-1.2 2.06-.85 3.19.35 1.13 1.43 1.99 2.61 2.08 1.18.09 2.4-.42 3.01-1.43.25-.42.36-.91.36-1.4V0z"/>
                            </svg>
                        </a>
                        <span class="t-caption text-white/80">@farhanas.id</span>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <div class="border-t border-white/10 py-4 text-center px-8">
        <p class="t-caption text-white/40 leading-relaxed">
            &copy; 2026 Farhana Official.<br class="sm:hidden"> All Rights Reserved.
        </p>
    </div>
</footer>