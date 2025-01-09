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
    <div class="flex flex-col items-center justify-center bg-gradient-to-br from-blue-100 via-white to-gray-100 min-h-screen">
    <!-- Hero Section -->
    <div class="text-center py-16">
        <h2 class="text-5xl font-extrabold text-gray-800 mb-6">
            Selamat Datang di <span class="text-blue-500">KAPIR POS!</span>
        </h2>
        <p class="text-lg text-gray-600 mb-12">
            Platform modern yang memudahkan pengelolaan transaksi dan bisnis Anda.
        </p>

        <!-- Login and Register Buttons -->
        <div class="flex justify-center gap-6 mb-10">
            <a href="/login" 
               class="px-10 py-3 bg-white text-gray-800 font-semibold rounded-full border border-blue-500 shadow-lg hover:bg-blue-100 hover:shadow-xl transition-all duration-300">
                Login
            </a>
            <a href="/register" 
               class="px-10 py-3 bg-white text-gray-800 font-semibold rounded-full border border-blue-500 shadow-lg hover:bg-blue-100 hover:shadow-xl transition-all duration-300">
                Register
            </a>
        </div>

        <!-- Features and About Buttons -->
        <div class="flex justify-center gap-6">
            <a href="#features" class="px-10 py-3 bg-blue-600 text-white font-semibold rounded-full shadow-lg hover:bg-blue-700 hover:shadow-xl transition-all duration-300">
                Lihat Fitur
            </a>
            <a href="#about" class="px-10 py-3 bg-green-500 text-white font-semibold rounded-full shadow-lg hover:bg-green-600 hover:shadow-xl transition-all duration-300">
                Tentang Kami
            </a>
        </div>
    </div>

    <!-- Features Section -->
    <div id="features" class="w-full max-w-7xl mx-auto py-20">
        <h3 class="text-4xl font-bold text-gray-800 text-center mb-12">Fitur Unggulan</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-2xl transform hover:scale-105 transition-transform duration-300">
                <div class="flex items-center justify-center mb-4">
                    <i class="fas fa-bolt text-blue-500 text-4xl"></i>
                </div>
                <h4 class="text-2xl font-semibold text-gray-800 mb-4">Transaksi Cepat</h4>
                <p class="text-gray-600">
                    Lakukan transaksi dengan cepat dan mudah menggunakan sistem yang kami tawarkan.
                </p>
            </div>
            <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-2xl transform hover:scale-105 transition-transform duration-300">
                <div class="flex items-center justify-center mb-4">
                    <i class="fas fa-chart-line text-green-500 text-4xl"></i>
                </div>
                <h4 class="text-2xl font-semibold text-gray-800 mb-4">Laporan Real-Time</h4>
                <p class="text-gray-600">
                    Dapatkan laporan transaksi secara real-time untuk memudahkan pengelolaan bisnis Anda.
                </p>
            </div>
            <div class="bg-white p-8 rounded-lg shadow-lg hover:shadow-2xl transform hover:scale-105 transition-transform duration-300">
                <div class="flex items-center justify-center mb-4">
                    <i class="fas fa-lock text-purple-500 text-4xl"></i>
                </div>
                <h4 class="text-2xl font-semibold text-gray-800 mb-4">Keamanan Terjamin</h4>
                <p class="text-gray-600">
                    Kami menjaga keamanan data transaksi Anda dengan teknologi enkripsi terbaru.
                </p>
            </div>
        </div>
    </div>

    <!-- About Section -->
    <div id="about" class="w-full max-w-7xl mx-auto py-20 bg-gray-50 rounded-lg shadow-lg">
        <h3 class="text-4xl font-bold text-gray-800 text-center mb-8">Tentang KAPIR POS</h3>
        <p class="text-lg text-gray-600 text-center mb-8">
            KAPIR POS adalah solusi perangkat lunak yang membantu Anda mengelola transaksi dengan lebih efisien. Kami berkomitmen untuk memberikan pengalaman pengguna terbaik dengan antarmuka yang sederhana dan mudah digunakan.
        </p>
        <div class="flex justify-center">
            <a href="#contact" class="px-10 py-3 bg-purple-500 text-white font-semibold rounded-full shadow-lg hover:bg-purple-600 hover:shadow-xl transition-all duration-300">
                Hubungi Kami
            </a>
        </div>
    </div>

    <!-- Contact Section -->
    <div id="contact" class="w-full max-w-7xl mx-auto py-20 text-center">
        <h3 class="text-4xl font-bold text-gray-800 mb-8">Hubungi Kami</h3>
        <p class="text-lg text-gray-600 mb-8">
            Jika Anda memiliki pertanyaan atau ingin memulai dengan KAPIR POS, jangan ragu untuk menghubungi kami.
        </p>
        <a href="mailto:support@kapirpos.com" class="px-10 py-3 bg-red-500 text-white font-semibold rounded-full shadow-lg hover:bg-red-600 hover:shadow-xl transition-all duration-300">
            Kirim Email
        </a>
    </div>
</div>
    
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