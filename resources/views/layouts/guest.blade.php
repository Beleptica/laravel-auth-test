<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen bg-gray-100">
        <div class="fixed top-0 right-0 p-6 text-right">
            @auth
                <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 underline">Dashboard</a>
            @else
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 underline {{ request()->routeIs('login') ? 'font-semibold' : '' }}">Log in</a>
                @endif
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="ms-4 text-sm text-gray-700 underline {{ request()->routeIs('register') ? 'font-semibold' : '' }}">Register</a>
                @endif
            @endauth
        </div>

        <div class="flex flex-col sm:justify-center items-center pt-24 sm:pt-0">
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
