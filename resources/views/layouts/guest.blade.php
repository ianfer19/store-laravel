<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-blue-50">
        <div class="min-h-screen flex flex-col items-center justify-center">
            <!-- Logo -->
            <div class="mb-8">
                <a href="/">
                    <x-application-logo class="w-24 h-24 fill-current text-blue-300 hover:scale-105 transition transform duration-300" />
                </a>
            </div>

            <!-- Card Container -->
            <div class="w-full sm:max-w-md bg-white shadow-lg rounded-lg p-6 sm:p-8 border-t-4 border-blue-200">
                <h1 class="text-2xl font-bold text-blue-400 text-center mb-4">
                    {{ __('Welcome Back!') }}
                </h1>
                <p class="text-sm text-blue-300 text-center mb-6">
                    {{ __('Please log in to continue') }}
                </p>
                {{ $slot }}
            </div>

            <!-- Footer -->
            <footer class="mt-6 text-center text-sm text-blue-300">
                &copy; {{ date('Y') }} <span class="font-semibold">{{ config('app.name', 'Laravel') }}</span>. {{ __('All rights reserved.') }}
            </footer>
        </div>
    </body>
</html>
