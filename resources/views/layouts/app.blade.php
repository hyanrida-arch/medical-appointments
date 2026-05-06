<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Anti-FOUC: applique la classe dark IMMÉDIATEMENT, avant tout rendu -->
        <script>
            (function () {
                if (localStorage.getItem('darkMode') === 'true') {
                    document.documentElement.classList.add('dark');
                }
            })();
        </script>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900 transition-colors">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow-soft transition-colors">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 dark:text-gray-200">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <x-toast-notifications />

        <!-- Dark mode toggle: vanilla JavaScript -->
        <script>
            window.toggleDarkMode = function() {
                const html = document.documentElement;
                const isDark = html.classList.toggle('dark');
                localStorage.setItem('darkMode', isDark);
                updateDarkModeIcon();
            };

            window.updateDarkModeIcon = function() {
                const isDark = document.documentElement.classList.contains('dark');
                const sunIcon = document.getElementById('sun-icon');
                const moonIcon = document.getElementById('moon-icon');
                if (sunIcon && moonIcon) {
                    if (isDark) {
                        sunIcon.classList.remove('hidden');
                        moonIcon.classList.add('hidden');
                    } else {
                        sunIcon.classList.add('hidden');
                        moonIcon.classList.remove('hidden');
                    }
                }
            };

            document.addEventListener('DOMContentLoaded', updateDarkModeIcon);
        </script>
    </body>
</html>
