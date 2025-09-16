<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di Book Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif'],
                    },
                    colors: {
                        'kemendikbud': {
                            primary: '#1e40af',
                            secondary: '#3b82f6', 
                            accent: '#0ea5e9',
                            dark: '#1e3a8a',
                        }
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'fadeInUp': 'fadeInUp 0.8s ease-out',
                        'slideInLeft': 'slideInLeft 0.8s ease-out',
                        'slideInRight': 'slideInRight 0.8s ease-out',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' }
                        },
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(30px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        },
                        slideInLeft: {
                            '0%': { opacity: '0', transform: 'translateX(-30px)' },
                            '100%': { opacity: '1', transform: 'translateX(0)' }
                        },
                        slideInRight: {
                            '0%': { opacity: '0', transform: 'translateX(30px)' },
                            '100%': { opacity: '1', transform: 'translateX(0)' }
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .parallax-bg {
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        .glass-effect {
            backdrop-filter: blur(16px);
            background: rgba(255, 255, 255, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .book-card {
            transition: all 0.3s ease;
        }
        .book-card:hover {
            transform: translateY(-8px) scale(1.02);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 overflow-x-hidden">
    <!-- Decorative Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-r from-blue-400/20 to-purple-400/20 rounded-full blur-3xl animate-float"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-r from-indigo-400/20 to-blue-400/20 rounded-full blur-3xl animate-float" style="animation-delay: -3s;"></div>
    </div>

    <!-- Header Section -->
    <header class="relative z-10 glass-effect border-b border-white/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4 animate-slideInLeft">
                    <div class="relative">
                        <div class="w-12 h-12 bg-gradient-to-r from-kemendikbud-primary via-kemendikbud-secondary to-kemendikbud-accent rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z"></path>
                            </svg>
                        </div>
                        <div class="absolute -top-1 -right-1 w-4 h-4 bg-yellow-400 rounded-full animate-pulse"></div>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold bg-gradient-to-r from-kemendikbud-primary to-kemendikbud-accent bg-clip-text text-transparent">Book Store</h1>
                        <p class="text-sm text-gray-600 font-medium">Platform Literasi Digital Indonesia</p>
                    </div>
                </div>
                <div class="hidden lg:flex items-center space-x-6 animate-slideInRight">
                    <nav class="flex space-x-6">
                        <a href="#beranda" class="text-gray-700 hover:text-kemendikbud-primary font-medium transition-colors">Beranda</a>
                        <a href="#kategori" class="text-gray-700 hover:text-kemendikbud-primary font-medium transition-colors">Kategori</a>
                        <a href="#tentang" class="text-gray-700 hover:text-kemendikbud-primary font-medium transition-colors">Tentang</a>
                    </nav>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('login') }}" class="text-kemendikbud-primary hover:text-kemendikbud-dark font-semibold transition-colors">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-kemendikbud-primary to-kemendikbud-secondary hover:from-kemendikbud-dark hover:to-kemendikbud-primary text-white px-6 py-2.5 rounded-full font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                            Daftar Gratis
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="beranda" class="relative z-10 py-20 lg:py-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="text-center lg:text-left animate-fadeInUp">
                    <div class="mb-6">
                        <span class="inline-block bg-gradient-to-r from-kemendikbud-primary/10 to-kemendikbud-accent/10 text-kemendikbud-primary px-4 py-2 rounded-full text-sm font-semibold border border-kemendikbud-primary/20">
                            🚀 Platform Terpercaya #1 di Indonesia
                        </span>
                    </div>
                    
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                        Jelajahi Dunia
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-kemendikbud-primary via-kemendikbud-secondary to-kemendikbud-accent">
                            Literasi Digital
                        </span>
                        Terbaik
                    </h1>

                    <p class="text-xl text-gray-600 mb-8 leading-relaxed max-w-2xl lg:max-w-none">
                        Temukan lebih dari <span class="font-bold text-kemendikbud-primary">50,000+ buku digital</span> 
                        berkualitas tinggi dari berbagai kategori. Mulai dari sejarah nusantara, sains modern, 
                        hingga karya sastra terbaik dunia.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 mb-8">
                        <a href="{{ url('/shop') }}" 
                           class="group inline-flex items-center justify-center bg-gradient-to-r from-kemendikbud-primary to-kemendikbud-secondary hover:from-kemendikbud-dark hover:to-kemendikbud-primary text-white font-bold px-8 py-4 rounded-2xl transition-all duration-300 transform hover:scale-105 shadow-2xl hover:shadow-3xl">
                            <svg class="w-5 h-5 mr-2 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Mulai Jelajahi Sekarang
                        </a>
                        <a href="#kategori" 
                           class="inline-flex items-center justify-center border-2 border-kemendikbud-primary text-kemendikbud-primary hover:bg-kemendikbud-primary hover:text-white font-bold px-8 py-4 rounded-2xl transition-all duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            Lihat Kategori
                        </a>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-6 pt-8 border-t border-gray-200">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-kemendikbud-primary">50K+</div>
                            <div class="text-sm text-gray-600">Buku Digital</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-kemendikbud-primary">100K+</div>
                            <div class="text-sm text-gray-600">Pembaca Aktif</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-kemendikbud-primary">4.8★</div>
                            <div class="text-sm text-gray-600">Rating Pengguna</div>
                        </div>
                    </div>
                </div>

                <!-- Right Content - Hero Image -->
                <div class="relative animate-slideInRight">
                    <div class="relative z-10">
                        <div class="bg-gradient-to-r from-kemendikbud-primary/10 to-kemendikbud-accent/10 rounded-3xl p-8 glass-effect">
                            <div class="grid grid-cols-2 gap-4">
                                <!-- Featured Books Preview -->
                                <div class="space-y-4">
                                    <div class="h-32 bg-gradient-to-br from-red-400 to-pink-500 rounded-lg shadow-lg flex items-center justify-center transform rotate-3 hover:rotate-0 transition-transform">
                                        <span class="text-white font-bold text-sm text-center px-2">Sejarah Nusantara</span>
                                    </div>
                                    <div class="h-24 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-lg shadow-lg flex items-center justify-center transform -rotate-2 hover:rotate-0 transition-transform">
                                        <span class="text-white font-bold text-xs text-center px-2">Fisika Modern</span>
                                    </div>
                                </div>
                                <div class="space-y-4 pt-8">
                                    <div class="h-24 bg-gradient-to-br from-green-400 to-emerald-500 rounded-lg shadow-lg flex items-center justify-center transform rotate-2 hover:rotate-0 transition-transform">
                                        <span class="text-white font-bold text-xs text-center px-2">Sastra Indonesia</span>
                                    </div>
                                    <div class="h-32 bg-gradient-to-br from-purple-400 to-violet-500 rounded-lg shadow-lg flex items-center justify-center transform -rotate-1 hover:rotate-0 transition-transform">
                                        <span class="text-white font-bold text-sm text-center px-2">Biografi Tokoh</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Floating elements -->
                    <div class="absolute -top-6 -right-6 w-12 h-12 bg-yellow-400 rounded-full animate-bounce shadow-lg"></div>
                    <div class="absolute -bottom-4 -left-4 w-8 h-8 bg-pink-400 rounded-full animate-pulse shadow-lg"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Book Categories Section -->
    <section id="kategori" class="py-20 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 animate-fadeInUp">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    Jelajahi Kategori 
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-kemendikbud-primary to-kemendikbud-accent">Favorit</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Dengan variasi tema menarik, temukan bacaan yang sesuai dengan minat dan kebutuhan belajar Anda
                </p>
            </div>

            <!-- Featured Categories Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 mb-16">
                <!-- Sejarah -->
                <div class="group book-card glass-effect rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl">
                    <div class="bg-gradient-to-br from-amber-400 to-orange-500 h-48 flex items-center justify-center relative overflow-hidden">
                        <div class="absolute inset-0 bg-black/20"></div>
                        <svg class="w-16 h-16 text-white z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <div class="absolute top-4 right-4 bg-white/20 rounded-full px-3 py-1 text-white text-sm font-semibold">
                            2.5K+ Buku
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Sejarah & Budaya</h3>
                        <p class="text-gray-600 mb-4 text-sm">Pelajari perjalanan bangsa Indonesia dari masa ke masa</p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="bg-amber-100 text-amber-800 px-2 py-1 rounded-full text-xs">Sejarah Indonesia</span>
                            <span class="bg-amber-100 text-amber-800 px-2 py-1 rounded-full text-xs">Budaya Nusantara</span>
                        </div>
                        <a href="{{ url('/shop?category=sejarah') }}" class="text-kemendikbud-primary font-semibold group-hover:text-kemendikbud-dark transition-colors">
                            Jelajahi →
                        </a>
                    </div>
                </div>

                <!-- Sains & Teknologi -->
                <div class="group book-card glass-effect rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl">
                    <div class="bg-gradient-to-br from-blue-400 to-indigo-500 h-48 flex items-center justify-center relative overflow-hidden">
                        <div class="absolute inset-0 bg-black/20"></div>
                        <svg class="w-16 h-16 text-white z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                        <div class="absolute top-4 right-4 bg-white/20 rounded-full px-3 py-1 text-white text-sm font-semibold">
                            3.2K+ Buku
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Sains & Teknologi</h3>
                        <p class="text-gray-600 mb-4 text-sm">Eksplorasi dunia sains dan teknologi terdepan</p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">Fisika</span>
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">Teknologi</span>
                        </div>
                        <a href="{{ url('/shop?category=sains') }}" class="text-kemendikbud-primary font-semibold group-hover:text-kemendikbud-dark transition-colors">
                            Jelajahi →
                        </a>
                    </div>
                </div>

                <!-- Sastra & Bahasa -->
                <div class="group book-card glass-effect rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl">
                    <div class="bg-gradient-to-br from-emerald-400 to-teal-500 h-48 flex items-center justify-center relative overflow-hidden">
                        <div class="absolute inset-0 bg-black/20"></div>
                        <svg class="w-16 h-16 text-white z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                        <div class="absolute top-4 right-4 bg-white/20 rounded-full px-3 py-1 text-white text-sm font-semibold">
                            1.8K+ Buku
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Sastra & Bahasa</h3>
                        <p class="text-gray-600 mb-4 text-sm">Karya sastra terbaik dan pembelajaran bahasa</p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="bg-emerald-100 text-emerald-800 px-2 py-1 rounded-full text-xs">Novel</span>
                            <span class="bg-emerald-100 text-emerald-800 px-2 py-1 rounded-full text-xs">Puisi</span>
                        </div>
                        <a href="{{ url('/shop?category=sastra') }}" class="text-kemendikbud-primary font-semibold group-hover:text-kemendikbud-dark transition-colors">
                            Jelajahi →
                        </a>
                    </div>
                </div>

                <!-- Biografi & Motivasi -->
                <div class="group book-card glass-effect rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl">
                    <div class="bg-gradient-to-br from-purple-400 to-pink-500 h-48 flex items-center justify-center relative overflow-hidden">
                        <div class="absolute inset-0 bg-black/20"></div>
                        <svg class="w-16 h-16 text-white z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <div class="absolute top-4 right-4 bg-white/20 rounded-full px-3 py-1 text-white text-sm font-semibold">
                            950+ Buku
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Biografi & Motivasi</h3>
                        <p class="text-gray-600 mb-4 text-sm">Kisah inspiratif tokoh-tokoh besar dunia</p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded-full text-xs">Tokoh Dunia</span>
                            <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded-full text-xs">Inspirasi</span>
                        </div>
                        <a href="{{ url('/shop?category=biografi') }}" class="text-kemendikbud-primary font-semibold group-hover:text-kemendikbud-dark transition-colors">
                            Jelajahi →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Popular Books Section -->
            <div class="bg-gradient-to-r from-kemendikbud-primary/5 to-kemendikbud-accent/5 rounded-3xl p-8 glass-effect">
                <div class="text-center mb-12">
                    <h3 class="text-3xl font-bold text-gray-900 mb-4">📚 Buku Populer Minggu Ini</h3>
                    <p class="text-gray-600">Buku-buku pilihan yang paling banyak dibaca pembaca kami</p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-5 gap-6">
                    <!-- Popular Book 1 -->
                    <div class="group cursor-pointer">
                        <div class="bg-gradient-to-br from-red-500 to-pink-600 h-48 rounded-2xl shadow-lg group-hover:shadow-xl transition-all duration-300 flex items-center justify-center transform group-hover:scale-105">
                            <div class="text-center text-white p-4">
                                <div class="text-sm font-bold mb-2">Sejarah Majapahit</div>
                                <div class="text-xs opacity-80">Prof. Dr. Slamet Mulyana</div>
                            </div>
                        </div>
                        <div class="mt-3 text-center">
                            <div class="flex justify-center mb-1">
                                <span class="text-yellow-400">★★★★★</span>
                            </div>
                            <div class="text-sm text-gray-600">4.9 • 2.3K pembaca</div>
                        </div>
                    </div>

                    <!-- Popular Book 2 -->
                    <div class="group cursor-pointer">
                        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 h-48 rounded-2xl shadow-lg group-hover:shadow-xl transition-all duration-300 flex items-center justify-center transform group-hover:scale-105">
                            <div class="text-center text-white p-4">
                                <div class="text-sm font-bold mb-2">Fisika Kuantum</div>
                                <div class="text-xs opacity-80">Dr. Bambang Hidayat</div>
                            </div>
                        </div>
                        <div class="mt-3 text-center">
                            <div class="flex justify-center mb-1">
                                <span class="text-yellow-400">★★★★★</span>
                            </div>
                            <div class="text-sm text-gray-600">4.8 • 1.8K pembaca</div>
                        </div>
                    </div>

                    <!-- Popular Book 3 -->
                    <div class="group cursor-pointer">
                        <div class="bg-gradient-to-br from-green-500 to-emerald-600 h-48 rounded-2xl shadow-lg group-hover:shadow-xl transition-all duration-300 flex items-center justify-center transform group-hover:scale-105">
                            <div class="text-center text-white p-4">
                                <div class="text-sm font-bold mb-2">Laskar Pelangi</div>
                                <div class="text-xs opacity-80">Andrea Hirata</div>
                            </div>
                        </div>
                        <div class="mt-3 text-center">
                            <div class="flex justify-center mb-1">
                                <span class="text-yellow-400">★★★★★</span>
                            </div>
                            <div class="text-sm text-gray-600">4.9 • 5.2K pembaca</div>
                        </div>
                    </div>

                    <!-- Popular Book 4 -->
                    <div class="group cursor-pointer">
                        <div class="bg-gradient-to-br from-purple-500 to-violet-600 h-48 rounded-2xl shadow-lg group-hover:shadow-xl transition-all duration-300 flex items-center justify-center transform group-hover:scale-105">
                            <div class="text-center text-white p-4">
                                <div class="text-sm font-bold mb-2">Bung Karno</div>
                                <div class="text-xs opacity-80">Cindy Adams</div>
                            </div>
                        </div>
                        <div class="mt-3 text-center">
                            <div class="flex justify-center mb-1">
                                <span class="text-yellow-400">★★★★★</span>
                            </div>
                            <div class="text-sm text-gray-600">4.7 • 3.1K pembaca</div>
                        </div>
                    </div>

                    <!-- Popular Book 5 -->
                    <div class="group cursor-pointer">
                        <div class="bg-gradient-to-br from-orange-500 to-red-600 h-48 rounded-2xl shadow-lg group-hover:shadow-xl transition-all duration-300 flex items-center justify-center transform group-hover:scale-105">
                            <div class="text-center text-white p-4">
                                <div class="text-sm font-