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
<body class="bg-gray-100 h-screen flex flex-col overflow-hidden">
<header class="flex justify-between items-center p-3 bg-white shadow-sm rounded-lg mx-4 mt-4">
    <div class="text-lg font-bold text-blue-700 hover:text-blue-800 transition-colors">
        <span class="bg-blue-100 px-2 py-1 rounded-full">KapirPOS</span>
    </div>
    <nav class="flex items-center gap-3">
        <a href="{{ route('auth.register') }}" class="{{ request()->routeIs('auth.login') ? 'px-3 py-1.5 bg-blue-100 text-blue-700 rounded-full hover:bg-blue-200' : 'text-gray-600 hover:text-blue-600' }} transition-colors font-medium text-sm">Register</a>
        <a href="{{ route('auth.login') }}" class="{{ request()->routeIs('auth.register') ? 'px-3 py-1.5 bg-blue-100 text-blue-700 rounded-full hover:bg-blue-200' : 'text-gray-600 hover:text-blue-600' }} transition-colors font-medium text-sm">Login</a>    </nav>
  </header>
  <main class="flex flex-col md:flex-row items-center justify-center flex-1">
    
      <!-- content -->
      <div class=" p-6 max-w-xl w-full">
        @yield('content')
      </div>
  </main>
    
  <footer class="bg-white py-3">
      <p class="text-sm text-gray-600 text-center">© 2024 GajahTerbang Team | Empowering Your Digital Journey 🚀</p>
  </footer>    
  @livewireScripts

</body>
</html>