<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>{{ config('app.name', 'FLO Azerbaijan') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="min-h-screen overflow-x-hidden bg-[#f8f8f8] pb-24 font-sans text-gray-900 antialiased md:pb-0">
        <header x-data="{ menuOpen: false, searchOpen: false }" class="bg-white">
            <div class="border-b border-gray-200 bg-gray-100">
                <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-2 text-xs text-gray-600">
                    <div class="flex items-center gap-4">
                        <a href="#" class="hover:text-[#ff7a00]">{{ __('common.help') }}</a>
                        <a href="#" class="hover:text-[#ff7a00]">{{ __('common.order_tracking') }}</a>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-gray-400">{{ __('common.language') }}:</span>
                        <a
                            href="{{ route('locale.switch', ['locale' => 'az']) }}"
                            class="font-semibold {{ app()->getLocale() === 'az' ? 'text-[#ff7a00]' : 'text-gray-700 hover:text-[#ff7a00]' }}"
                        >
                            AZ
                        </a>
                        <span class="text-gray-300">|</span>
                        <a
                            href="{{ route('locale.switch', ['locale' => 'ru']) }}"
                            class="font-semibold {{ app()->getLocale() === 'ru' ? 'text-[#ff7a00]' : 'text-gray-700 hover:text-[#ff7a00]' }}"
                        >
                            RU
                        </a>
                    </div>
                </div>
            </div>

            <div class="sticky top-0 z-30 border-b border-gray-200 bg-white shadow-sm">
                <div class="mx-auto max-w-7xl px-4">
                    <div class="flex items-center gap-4 py-4">
                        <button
                            type="button"
                            class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-gray-200 bg-white text-sm font-semibold text-gray-800 transition hover:bg-gray-50 md:hidden"
                            @click="menuOpen = !menuOpen"
                            aria-label="Menu"
                        >
                            ☰
                        </button>

                        <div class="flex flex-1 items-center justify-center md:flex-none md:justify-start">
                            <a href="/" class="flex items-center">
                                <img src="{{ asset('assets/images/logo.svg') }}" alt="FLO" class="h-9 w-auto" />
                            </a>
                        </div>

                        <div class="flex-1 hidden md:block">
                            <form action="/" method="get">
                                <label class="relative block">
                                    <span class="sr-only">{{ __('common.search') }}</span>
                                    <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">⌕</span>
                                    <input
                                        name="q"
                                        value="{{ request('q', '') }}"
                                        type="search"
                                        placeholder="{{ __('common.search_placeholder') }}"
                                        class="w-full rounded-full border border-gray-200 bg-white py-3 pl-11 pr-4 text-sm outline-none transition focus:border-[#ff7a00] focus:ring-2 focus:ring-[#ff7a00]/15"
                                    />
                                </label>
                            </form>
                        </div>

                        <div class="flex items-center gap-2">
                            <button
                                type="button"
                                class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-gray-200 bg-white text-sm font-semibold text-gray-800 transition hover:bg-gray-50 md:hidden"
                                @click="searchOpen = !searchOpen"
                                aria-label="{{ __('common.search') }}"
                            >
                                ⌕
                            </button>
                            <a href="/admin" class="hidden items-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold text-gray-800 hover:bg-gray-50 sm:inline-flex">
                                <span class="text-base">👤</span>
                                <span>{{ __('common.login') }}</span>
                            </a>
                            <button type="button" class="hidden items-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold text-gray-800 hover:bg-gray-50 sm:inline-flex">
                                <span class="text-base">♡</span>
                                <span>{{ __('common.favorites') }}</span>
                            </button>
                            <button
                                type="button"
                                onclick="window.Livewire?.dispatch('cart:open')"
                                class="hidden items-center gap-2 rounded-lg bg-[#ff7a00] px-3 py-2 text-sm font-semibold text-white transition hover:bg-[#ff7a00]/90 md:inline-flex"
                            >
                                <span class="text-base">🛒</span>
                                <span>{{ __('common.cart') }}</span>
                            </button>
                        </div>
                    </div>

                    <div
                        x-show="searchOpen"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-1"
                        x-cloak
                        class="pb-4 md:hidden"
                    >
                        <form action="/" method="get">
                            <label class="relative block">
                                <span class="sr-only">{{ __('common.search') }}</span>
                                <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">⌕</span>
                                <input
                                    name="q"
                                    value="{{ request('q', '') }}"
                                    type="search"
                                    placeholder="{{ __('common.search_placeholder') }}"
                                    class="w-full rounded-full border border-gray-200 bg-white py-3 pl-11 pr-4 text-sm outline-none transition focus:border-[#ff7a00] focus:ring-2 focus:ring-[#ff7a00]/15"
                                />
                            </label>
                        </form>
                    </div>
                </div>
            </div>

            <nav class="hidden border-b border-gray-200 bg-white md:block">
                <div class="mx-auto max-w-7xl px-4">
                    <div class="flex items-center gap-6 overflow-x-auto py-3 text-sm font-bold tracking-wide text-gray-900">
                        <a href="#" class="whitespace-nowrap hover:text-[#ff7a00]">{{ __('common.women') }}</a>
                        <a href="#" class="whitespace-nowrap hover:text-[#ff7a00]">{{ __('common.men') }}</a>
                        <a href="#" class="whitespace-nowrap hover:text-[#ff7a00]">{{ __('common.kids') }}</a>
                        <a href="#" class="whitespace-nowrap hover:text-[#ff7a00]">{{ __('common.sport') }}</a>
                        <a href="#" class="whitespace-nowrap hover:text-[#ff7a00]">{{ __('common.brands') }}</a>
                    </div>
                </div>
            </nav>

            <div
                x-show="menuOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-1"
                x-cloak
                class="border-b border-gray-200 bg-white md:hidden"
            >
                <div class="mx-auto max-w-7xl px-4 py-4">
                    <div class="grid gap-2 text-sm font-semibold text-gray-900">
                        <a href="#" class="rounded-lg px-3 py-2 hover:bg-gray-50" @click="menuOpen = false">{{ __('common.women') }}</a>
                        <a href="#" class="rounded-lg px-3 py-2 hover:bg-gray-50" @click="menuOpen = false">{{ __('common.men') }}</a>
                        <a href="#" class="rounded-lg px-3 py-2 hover:bg-gray-50" @click="menuOpen = false">{{ __('common.kids') }}</a>
                        <a href="#" class="rounded-lg px-3 py-2 hover:bg-gray-50" @click="menuOpen = false">{{ __('common.sport') }}</a>
                        <a href="#" class="rounded-lg px-3 py-2 hover:bg-gray-50" @click="menuOpen = false">{{ __('common.brands') }}</a>
                    </div>

                    <div class="mt-4 flex items-center justify-between rounded-xl border border-gray-200 bg-gray-50 px-3 py-3 text-xs text-gray-700">
                        <span class="font-semibold">{{ __('common.language') }}</span>
                        <div class="flex items-center gap-2">
                            <a
                                href="{{ route('locale.switch', ['locale' => 'az']) }}"
                                class="font-semibold {{ app()->getLocale() === 'az' ? 'text-[#ff7a00]' : 'text-gray-700 hover:text-[#ff7a00]' }}"
                                @click="menuOpen = false"
                            >
                                AZ
                            </a>
                            <span class="text-gray-300">|</span>
                            <a
                                href="{{ route('locale.switch', ['locale' => 'ru']) }}"
                                class="font-semibold {{ app()->getLocale() === 'ru' ? 'text-[#ff7a00]' : 'text-gray-700 hover:text-[#ff7a00]' }}"
                                @click="menuOpen = false"
                            >
                                RU
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="mx-auto w-full max-w-7xl px-4 pb-24 pt-6 md:pb-6">
            {{ $slot }}
        </main>

        @php
            $isHome = request()->routeIs('home');
            $isCategories = request()->routeIs('categories');
            $isProfile = request()->routeIs('profile');
        @endphp

        <nav class="fixed inset-x-0 bottom-0 z-50 border-t border-gray-200 bg-white shadow-lg md:hidden pb-[env(safe-area-inset-bottom)]">
            <div class="mx-auto flex h-16 max-w-7xl items-center justify-around px-2">
                <a
                    href="{{ route('home') }}"
                    class="flex h-14 w-20 flex-col items-center justify-center gap-1 rounded-xl transition {{ $isHome ? 'text-[#ff7a00]' : 'text-gray-600' }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.44 1.152-.44 1.591 0L21.75 12M4.5 9.75V19.875c0 .621.504 1.125 1.125 1.125H9.75v-6.75c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75" />
                    </svg>
                    <span class="text-[10px] font-semibold tracking-wide">Ana səhifə</span>
                </a>

                <a
                    href="{{ route('categories') }}"
                    class="flex h-14 w-20 flex-col items-center justify-center gap-1 rounded-xl transition {{ $isCategories ? 'text-[#ff7a00]' : 'text-gray-600' }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75A3 3 0 016.75 3.75h2.5a3 3 0 013 3v2.5a3 3 0 01-3 3h-2.5a3 3 0 01-3-3v-2.5zM3.75 17.25a3 3 0 013-3h2.5a3 3 0 013 3v2.5a3 3 0 01-3 3h-2.5a3 3 0 01-3-3v-2.5zM14.25 6.75a3 3 0 013-3h2.5a3 3 0 013 3v2.5a3 3 0 01-3 3h-2.5a3 3 0 01-3-3v-2.5zM14.25 17.25a3 3 0 013-3h2.5a3 3 0 013 3v2.5a3 3 0 01-3 3h-2.5a3 3 0 01-3-3v-2.5z" />
                    </svg>
                    <span class="text-[10px] font-semibold tracking-wide">Kateqoriyalar</span>
                </a>

                <button
                    type="button"
                    onclick="window.Livewire?.dispatch('cart:open')"
                    class="flex h-14 w-20 flex-col items-center justify-center gap-1 rounded-xl text-gray-600 transition"
                    aria-label="{{ __('common.cart') }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.836L5.91 8.25m0 0l1.3 6.5a1.125 1.125 0 001.102.9h8.98a1.125 1.125 0 001.102-.9l1.2-6.5H5.91zM9 21a.75.75 0 100-1.5A.75.75 0 009 21zm9 0a.75.75 0 100-1.5A.75.75 0 0018 21z" />
                    </svg>
                    <span class="text-[10px] font-semibold tracking-wide">Səbətim</span>
                </button>

                <a
                    href="{{ route('profile') }}"
                    class="flex h-14 w-20 flex-col items-center justify-center gap-1 rounded-xl transition {{ $isProfile ? 'text-[#ff7a00]' : 'text-gray-600' }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.118a7.5 7.5 0 0115 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.5-1.632z" />
                    </svg>
                    <span class="text-[10px] font-semibold tracking-wide">Hesabım</span>
                </a>
            </div>
        </nav>

        <footer class="mt-10 border-t border-gray-200 bg-white">
            <div class="mx-auto max-w-7xl px-4 pb-28 pt-10 md:py-10">
                <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                    <div>
                        <h4 class="text-sm font-extrabold text-gray-900">{{ __('common.footer_categories') }}</h4>
                        <ul class="mt-4 space-y-2 text-sm text-gray-600">
                            <li><a href="#" class="hover:text-[#ff7a00]">{{ __('common.women') }}</a></li>
                            <li><a href="#" class="hover:text-[#ff7a00]">{{ __('common.men') }}</a></li>
                            <li><a href="#" class="hover:text-[#ff7a00]">{{ __('common.kids') }}</a></li>
                            <li><a href="#" class="hover:text-[#ff7a00]">{{ __('common.sport') }}</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-sm font-extrabold text-gray-900">{{ __('common.footer_help') }}</h4>
                        <ul class="mt-4 space-y-2 text-sm text-gray-600">
                            <li><a href="#" class="hover:text-[#ff7a00]">{{ __('common.help') }}</a></li>
                            <li><a href="#" class="hover:text-[#ff7a00]">{{ __('common.order_tracking') }}</a></li>
                            <li><a href="#" class="hover:text-[#ff7a00]">{{ __('common.footer_contact') }}</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-sm font-extrabold text-gray-900">{{ __('common.footer_corporate') }}</h4>
                        <ul class="mt-4 space-y-2 text-sm text-gray-600">
                            <li><a href="#" class="hover:text-[#ff7a00]">{{ __('common.footer_about') }}</a></li>
                            <li><a href="#" class="hover:text-[#ff7a00]">{{ __('common.footer_stores') }}</a></li>
                            <li><a href="#" class="hover:text-[#ff7a00]">{{ __('common.footer_terms') }}</a></li>
                            <li><a href="#" class="hover:text-[#ff7a00]">{{ __('common.footer_privacy') }}</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-sm font-extrabold text-gray-900">{{ __('common.footer_apps') }}</h4>
                        <div class="mt-4 space-y-3">
                            <a href="#" class="flex items-center justify-center rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-gray-800 hover:bg-gray-50">
                                {{ __('common.app_store') }}
                            </a>
                            <a href="#" class="flex items-center justify-center rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-gray-800 hover:bg-gray-50">
                                {{ __('common.google_play') }}
                            </a>
                        </div>
                    </div>
                </div>

                <div class="mt-10 flex flex-col items-start justify-between gap-3 border-t border-gray-200 pt-6 text-sm text-gray-500 sm:flex-row sm:items-center">
                    <p>© {{ date('Y') }} FLO Azerbaijan</p>
                    <p>
                        Developed by
                        <a
                            href="https://github.com/RealMrNovember"
                            target="_blank"
                            rel="noreferrer"
                            class="font-semibold text-gray-700 hover:text-[#ff7a00]"
                        >
                            Cicibyte Corp
                        </a>
                    </p>
                </div>
            </div>
        </footer>

        <livewire:cart-slideover />

        @livewireScripts
    </body>
</html>
