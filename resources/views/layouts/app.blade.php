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
<body>
    @livewire('components.sidebar')
    <div class="p-4 sm:ml-64">
        <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
            {{ $slot }}
        </div>
    </div>
    @livewireScripts
    @stack('scripts')
    
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('product-created', () => {
                console.log('Product created');
            });
            
            Livewire.on('product-updated', () => {
                console.log('Product updated');
            });
        });
    </script>
</body>
</html>