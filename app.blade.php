<!Doctype html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport"
            content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>
            @yield('title', 'Admin Dashboard') | {{ config('app.name', 'Laravel') }}
        </title>
        <link rel="icon" href="favicon.ico">
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    </head>

    <body x-data="{ page: 'ecommerce', 'loaded': true, 'darkMode': false, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }" x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'));
    $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))" :class="{ 'dark bg-gray-900': darkMode === true }">
        <!-- ===== Preloader Start ===== -->
        <div x-show="loaded" x-init="window.addEventListener('DOMContentLoaded', () => { setTimeout(() => loaded = false, 500) })"
            class="z-999999 fixed left-0 top-0 flex h-screen w-screen items-center justify-center bg-white dark:bg-black">
            <div
                class="border-brand-500 h-16 w-16 animate-spin rounded-full border-4 border-solid border-t-transparent">
            </div>
        </div>

        <!-- ===== Preloader End ===== -->

        <!-- ===== Page Wrapper Start ===== -->
        <div class="flex h-screen overflow-hidden">
            <!-- ===== Sidebar Start ===== -->
            @include('layouts.sidebar')

            <!-- ===== Sidebar End ===== -->

            <!-- ===== Content Area Start ===== -->
            <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">
                <!-- Small Device Overlay Start -->
                <div @click="sidebarToggle = false" :class="sidebarToggle ? 'block lg:hidden' : 'hidden'"
                    class="z-9 fixed h-screen w-full bg-gray-900/50"></div>
                <!-- Small Device Overlay End -->

                <!-- ===== Header Start ===== -->
                @include('layouts.header')
                <!-- ===== Header End ===== -->

                <!-- ===== Main Content Start ===== -->
                <main>
                    <div class="max-w-(--breakpoint-2xl) mx-auto p-4 md:p-6">
                        @yield('content')
                    </div>
                </main>
                <!-- ===== Main Content End ===== -->
            </div>
            <!-- ===== Content Area End ===== -->
        </div>
        <!-- ===== Page Wrapper End ===== -->
        <script defer src="{{ asset('assets/js/bundle.js') }}"></script>
    </body>

</html>
