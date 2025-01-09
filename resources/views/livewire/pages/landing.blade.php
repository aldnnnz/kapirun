<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="KAPIR POS - Platform modern untuk pengelolaan transaksi dan bisnis Anda">
    <meta name="keywords" content="POS, sistem kasir, manajemen bisnis, transaksi digital">
    <title>@yield('title', config('app.name', 'Laravel'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="antialiased font-inter">
    <div class="flex flex-col items-center justify-center bg-gradient-to-br from-blue-100 via-white to-gray-100 min-h-screen">
    <!-- Hero Section -->
    <div class="text-center py-20 px-4" data-aos="fade-down">
        <h1 class="text-5xl md:text-7xl font-extrabold text-gray-800 mb-8 tracking-tighter leading-tight">
            Selamat Datang di <span class="text-blue-500 bg-clip-text text-transparent bg-gradient-to-r from-blue-500 via-purple-500 to-indigo-500 animate-gradient">KAPIR POS!</span>
        </h1>
        <p class="text-xl md:text-2xl text-gray-600 mb-14 max-w-3xl mx-auto leading-relaxed">
            Solusi bisnis modern yang menghadirkan kemudahan dalam mengelola transaksi dengan teknologi mutakhir dan sistem keamanan yang handal untuk kesuksesan usaha Anda.
        </p>

        <!-- Login and Register Buttons -->
        <div class="flex flex-col sm:flex-row justify-center gap-6 mb-12" data-aos="fade-up" data-aos-delay="200">
            <a href="/login" 
               class="group px-12 py-4 bg-white text-gray-800 font-semibold rounded-full border-2 border-blue-500 shadow-lg hover:bg-blue-50 hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                <i class="fas fa-sign-in-alt mr-2 group-hover:rotate-12 transition-transform"></i>Masuk
            </a>
            <a href="/register" 
               class="group px-12 py-4 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold rounded-full shadow-lg hover:from-blue-600 hover:to-indigo-700 hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                <i class="fas fa-user-plus mr-2 group-hover:rotate-12 transition-transform"></i>Daftar
            </a>
        </div>

        <!-- Features and About Buttons -->
        <div class="flex flex-col sm:flex-row justify-center gap-6" data-aos="fade-up" data-aos-delay="400">
            <a href="#features" class="group px-12 py-4 bg-gradient-to-r from-blue-600 to-blue-800 text-white font-semibold rounded-full shadow-lg hover:from-blue-700 hover:to-blue-900 hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                <i class="fas fa-star mr-2 group-hover:rotate-12 transition-transform"></i>Jelajahi Fitur
            </a>
            <a href="#about" class="group px-12 py-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold rounded-full shadow-lg hover:from-green-600 hover:to-emerald-700 hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                <i class="fas fa-info-circle mr-2 group-hover:rotate-12 transition-transform"></i>Kenali Kami
            </a>
        </div>
    </div>

    <!-- Features Section -->
    <div id="features" class="w-full max-w-7xl mx-auto py-28 px-6">
        <h3 class="text-4xl md:text-5xl font-bold text-gray-800 text-center mb-20" data-aos="fade-up">
            <span class="border-b-4 border-blue-500 pb-2">Keunggulan Kami</span>
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <div class="bg-white p-10 rounded-2xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition-all duration-300 border border-gray-100" data-aos="fade-up" data-aos-delay="200">
                <div class="flex items-center justify-center mb-8">
                    <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center transform hover:rotate-12 transition-transform">
                        <i class="fas fa-bolt text-blue-500 text-4xl"></i>
                    </div>
                </div>
                <h4 class="text-2xl font-bold text-gray-800 mb-6 text-center">Transaksi Instan</h4>
                <p class="text-gray-600 text-center leading-relaxed text-lg">
                    Nikmati kemudahan bertransaksi secara instan dengan sistem modern kami. Optimalkan efisiensi dan produktivitas bisnis Anda.
                </p>
            </div>
            <div class="bg-white p-10 rounded-2xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition-all duration-300 border border-gray-100" data-aos="fade-up" data-aos-delay="400">
                <div class="flex items-center justify-center mb-8">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center transform hover:rotate-12 transition-transform">
                        <i class="fas fa-chart-line text-green-500 text-4xl"></i>
                    </div>
                </div>
                <h4 class="text-2xl font-bold text-gray-800 mb-6 text-center">Analisis Bisnis Real-Time</h4>
                <p class="text-gray-600 text-center leading-relaxed text-lg">
                    Dapatkan wawasan mendalam tentang performa bisnis Anda melalui dashboard interaktif dan laporan yang detail secara real-time.
                </p>
            </div>
            <div class="bg-white p-10 rounded-2xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition-all duration-300 border border-gray-100" data-aos="fade-up" data-aos-delay="600">
                <div class="flex items-center justify-center mb-8">
                    <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center transform hover:rotate-12 transition-transform">
                        <i class="fas fa-shield-alt text-purple-500 text-4xl"></i>
                    </div>
                </div>
                <h4 class="text-2xl font-bold text-gray-800 mb-6 text-center">Keamanan Maksimal</h4>
                <p class="text-gray-600 text-center leading-relaxed text-lg">
                    Lindungi data bisnis Anda dengan sistem keamanan berlapis menggunakan teknologi enkripsi terkini yang terpercaya.
                </p>
            </div>
        </div>
    </div>

    <!-- About Section -->
    <div id="about" class="w-full max-w-7xl mx-auto py-28 px-6">
        <div class="bg-gradient-to-br from-white to-blue-50 rounded-3xl shadow-xl p-12 md:p-16 backdrop-blur-sm" data-aos="fade-up">
            <h3 class="text-4xl md:text-5xl font-bold text-center mb-10">
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 animate-gradient">Mengenal KAPIR POS</span>
            </h3>
            <p class="text-xl md:text-2xl text-gray-600 text-center mb-14 max-w-4xl mx-auto leading-relaxed">
                KAPIR POS hadir sebagai solusi inovatif untuk transformasi digital bisnis Anda. Dengan teknologi mutakhir dan antarmuka yang mudah digunakan, kami berkomitmen membantu Anda mengembangkan bisnis tanpa hambatan dalam pengelolaan transaksi.
            </p>
            <div class="flex justify-center">
                <a href="#contact" class="group px-14 py-5 bg-gradient-to-r from-purple-500 via-indigo-600 to-blue-600 text-white font-semibold rounded-full shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 animate-gradient">
                    <i class="fas fa-envelope mr-2 group-hover:rotate-12 transition-transform"></i>Konsultasi Gratis
                </a>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div id="contact" class="w-full max-w-7xl mx-auto py-28 px-6 text-center" data-aos="fade-up">
        <h3 class="text-4xl md:text-5xl font-bold text-gray-800 mb-10">
            <span class="border-b-4 border-red-500 pb-2">Mulai Sekarang</span>
        </h3>
        <p class="text-xl md:text-2xl text-gray-600 mb-14 max-w-3xl mx-auto leading-relaxed">
            Siap untuk mengoptimalkan bisnis Anda? Tim ahli kami siap mendampingi dan memberikan solusi terbaik untuk setiap kebutuhan bisnis Anda.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-6">
            <a href="mailto:support@kapirpos.com" class="group px-14 py-5 bg-gradient-to-r from-red-500 to-pink-500 text-white font-semibold rounded-full shadow-lg hover:from-red-600 hover:to-pink-600 hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                <i class="fas fa-envelope mr-2 group-hover:rotate-12 transition-transform"></i>Kirim Pesan
            </a>
            <a href="tel:+6281234567890" class="group px-14 py-5 bg-gradient-to-r from-green-500 to-teal-500 text-white font-semibold rounded-full shadow-lg hover:from-green-600 hover:to-teal-600 hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                <i class="fas fa-phone mr-2 group-hover:rotate-12 transition-transform"></i>Telepon Kami
            </a>
        </div>
    </div>
</div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        AOS.init({
            duration: 1200,
            once: true,
            offset: 120,
            easing: 'ease-out-cubic'
        });

        document.addEventListener('livewire:init', () => {
            Livewire.on('product-created', () => {
                console.log('Product created successfully');
            });
            
            Livewire.on('product-updated', () => {
                console.log('Product updated successfully');
            });
        });
    </script>

    <style>
        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient 8s ease infinite;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }
    </style>
</body>
</html>