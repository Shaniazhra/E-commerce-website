{{-- Global modals (opened from the footer via Alpine: openModal = 'contact' | 'shipping' | 'howtobuy' | 'faqs') --}}
<template x-if="openModal">
    <div class="fixed inset-0 z-[400] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
         @click.self="openModal = null"
         @keydown.escape.window="openModal = null">
        <div class="bg-white w-full max-w-[900px] max-h-[85vh] overflow-y-auto shadow-2xl relative text-gray-800"
             style="border-radius: var(--radius-modal); scrollbar-width: none;">
            <button @click="openModal = null"
                    aria-label="Close"
                    class="absolute top-6 right-6 text-gray-400 hover:text-black z-50 bg-white/80 backdrop-blur rounded-full p-2 transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <div class="prose prose-sm max-w-none">
                <template x-if="openModal === 'contact'"><div>@include('includes.contact')</div></template>
                <template x-if="openModal === 'shipping'"><div>@include('includes.shipping')</div></template>
                <template x-if="openModal === 'howtobuy'"><div>@include('includes.how-to-buy')</div></template>
                <template x-if="openModal === 'faqs'"><div>@include('includes.faqs')</div></template>
            </div>
        </div>
    </div>
</template>