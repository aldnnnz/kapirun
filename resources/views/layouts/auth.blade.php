<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Laravel'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full space-y-8 p-8 bg-white rounded-2xl shadow-xl">
            <div class="text-center">
                <img src="https://mystickermania.com/cdn/stickers/spongebob/sb-krabs-lies-money-512x512.png" alt="Logo" class="mx-auto h-32 w-auto ">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    @yield('auth-title')
                </h2>
            </div>
            
            <div class="mt-8">
                @yield('content')
            </div>
            
            {{-- <div class="text-center text-sm text-gray-600 mt-4">
                @yield('auth-footer')
            </div> --}}
        </div>
    </div>
    
    @livewireScripts
</body>
</html>