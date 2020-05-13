<?php

/** @var \App\User $user */

?>

<html>
<head>
    {{--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tailwindcss/ui@latest/dist/tailwind-ui.min.css">--}}
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    @yield('title')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{--<link rel="shortcut icon" type="image/png" href="/img/favicon.ico"/>--}}
</head>
<body>
    <div id="app">
        @if (isset($error) && $error == 'not_logged_in')
            <div class="rounded-md bg-yellow-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm leading-5 font-medium text-yellow-800">
                            Please login
                        </h3>
                        <div class="mt-2 text-sm leading-5 text-yellow-700">
                            <p>
                                You tried to access a page on the site without being logged in
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (isset($success) && $success == 'logged_out')
            <div class="rounded-md bg-green-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm leading-5 font-medium text-green-800">
                            You're signed out!
                        </h3>
                        <div class="mt-2 text-sm leading-5 text-green-700">
                            <p>
                                Come back again soon! 😉
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="relative bg-gray-50 overflow-hidden">
            <div class="hidden sm:block sm:absolute sm:inset-y-0 sm:h-full sm:w-full">
                <div class="relative h-full max-w-screen-xl mx-auto">
                    <svg class="absolute left-full transform -translate-y-3/4 -translate-x-1/4 md:-translate-y-1/2 lg:-translate-x-1/2" width="404" height="784" fill="none" viewBox="0 0 404 784">
                        <defs>
                            <pattern id="5d0dd344-b041-4d26-bec4-8d33ea57ec9b" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                                <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor"/>
                            </pattern>
                        </defs>
                        <rect width="404" height="784" fill="url(#5d0dd344-b041-4d26-bec4-8d33ea57ec9b)"/>
                    </svg>
                </div>
            </div>

            <div class="relative pt-6 pb-12 sm:pb-16 md:pb-20 lg:pb-28 xl:pb-32">
                <div class="max-w-screen-xl mx-auto px-4 sm:px-6">
                    <nav class="relative flex items-center justify-between sm:h-10 md:justify-center">
                        <div class="flex items-center flex-1 md:absolute md:inset-y-0 md:left-0">
                            <div class="flex items-center justify-between w-full md:w-auto">
                                <a href="/">
                                    @include('svg.logo', ['classes' => 'h-8 w-auto sm:h-10 text-indigo-500'])
                                </a>
                                <div class="-mr-2 flex items-center md:hidden">
                                    <button @click="toggleMobileMenu" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                        @include('svg.menu', ['classes' => 'h-6 w-6'])
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="hidden md:block">
                            <a href="#link1" class="font-medium text-gray-500 hover:text-gray-900 focus:outline-none focus:text-gray-900 transition duration-150 ease-in-out">
                                Link 1
                            </a>
                            <a href="#link2" class="ml-10 font-medium text-gray-500 hover:text-gray-900 focus:outline-none focus:text-gray-900 transition duration-150 ease-in-out">
                                Link 2
                            </a>
                            <a href="#" class="ml-10 font-medium text-indigo-500 hover:text-indigo-900 focus:outline-none focus:text-indigo-900 transition duration-150 ease-in-out">
                                Call to action
                            </a>
                        </div>
                        <div class="hidden z-10 md:absolute md:flex md:items-center md:justify-end md:inset-y-0 md:right-0">
                            @if ($user)
                                <span class="inline-flex">
                                    <div class="relative inline-block text-left">
                                        <div>
                                            <button @click="toggleAccountMenu" class="max-w-xs flex items-center text-sm rounded-full text-white focus:outline-none focus:shadow-solid" id="user-menu" aria-label="User menu" aria-haspopup="true">
                                                <img class="header-avatar h-8 w-8 rounded-full"
                                                     src="{{ $user->avatar() }}" alt=""/>
                                            </button>
                                        </div>

                                        <!--
                                          Dropdown panel, show/hide based on dropdown state.

                                          Entering: "transition ease-out duration-100"
                                            From: "transform opacity-0 scale-95"
                                            To: "transform opacity-100 scale-100"
                                          Leaving: "transition ease-in duration-75"
                                            From: "transform opacity-100 scale-100"
                                            To: "transform opacity-0 scale-95"
                                        -->
                                        <div v-if="showAccountMenu" class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg">
                                            <div class="rounded-md bg-white shadow-xs">
                                                <div class="py-1">
                                                    <a href="/account/settings" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">Settings</a>
                                                    <a href="/logout" class="block w-full text-left px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">
                                                        Sign out
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </span>
                            @else
                                <span class="inline-flex rounded-md shadow">
                                    <a href="/auth" class="inline-flex items-center px-4 py-2 border border-transparent text-base leading-6 font-medium rounded-md text-indigo-600 bg-white hover:text-indigo-500 focus:outline-none focus:shadow-outline-blue active:bg-gray-50 active:text-indigo-700 transition duration-150 ease-in-out">
                                        Log in
                                    </a>
                                </span>
                            @endif
                        </div>
                    </nav>
                </div>

                <!--
                  Mobile menu, show/hide based on menu open state.

                  Entering: "duration-150 ease-out"
                    From: "opacity-0 scale-95"
                    To: "opacity-100 scale-100"
                  Leaving: "duration-100 ease-in"
                    From: "opacity-100 scale-100"
                    To: "opacity-0 scale-95"
                -->
                <div v-if="showMobileMenu" class="z-10 absolute top-0 inset-x-0 p-2 transition transform origin-top-right md:hidden">
                    <div class="rounded-lg shadow-md">
                        <div class="rounded-lg bg-white shadow-xs overflow-hidden">
                            <div class="px-5 pt-4 flex items-center justify-between">
                                <div>
                                    <a href="/">
                                        @include('svg.logo', ['classes' => 'h-8 w-auto'])
                                    </a>
                                </div>
                                <div class="-mr-2">
                                    <button @click="toggleMobileMenu" type="button" class="mobile-menu-button inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                        @include('svg.close', ['classes' => 'h-6 w-6'])
                                    </button>
                                </div>
                            </div>
                            <div class="px-2 pt-2 pb-3">
                                <a href="#link1" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-50 transition duration-150 ease-in-out">
                                    Link 1
                                </a>
                                <a href="#link2" class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-50 transition duration-150 ease-in-out">
                                    Link 2
                                </a>
                                <a href="#cta" class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-indigo-700 hover:text-indigo-900 hover:bg-gray-50 focus:outline-none focus:text-gray-900 focus:bg-gray-50 transition duration-150 ease-in-out">
                                    Call to action
                                </a>
                            </div>
                            <div>
                                <a href="/auth" class="block w-full px-5 py-3 text-center font-medium text-indigo-600 bg-gray-50 hover:bg-gray-100 hover:text-indigo-700 focus:outline-none focus:bg-gray-100 focus:text-indigo-700 transition duration-150 ease-in-out">
                                    Log in
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @yield('content')

            </div>
        </div>

        @include('footer')
    </div>

    <script>
        pageMethods = {
            toggleAccountMenu: function() {
                this.showAccountMenu = ! this.showAccountMenu;
            },
            toggleMobileMenu: function() {
                this.showMobileMenu = ! this.showMobileMenu;
            }
        };

        pageData = {
            showAccountMenu: false,
            showMobileMenu: false,
        };
    </script>
    @yield('scripts')
    <script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>