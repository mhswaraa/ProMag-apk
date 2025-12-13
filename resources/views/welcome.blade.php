<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Sistem Monitoring Magang - PT. Prima Sejati Sejahtera</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600,700&display=swap" rel="stylesheet" />

        <!-- Tailwind CSS (CDN untuk kemudahan pengembangan) -->
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- Custom Style untuk Carousel Fade Effect -->
        <style>
            body { font-family: 'Figtree', sans-serif; }
            .carousel-slide {
                position: absolute;
                inset: 0;
                transition: opacity 1000ms ease-in-out;
                opacity: 0;
                z-index: 0;
            }
            .carousel-slide.active {
                opacity: 1;
                z-index: 10;
            }
            /* Overlay gradient agar teks terbaca jelas */
            .hero-overlay {
                background: linear-gradient(to right, rgba(0, 0, 0, 0.85) 0%, rgba(0, 0, 0, 0.4) 100%);
            }
        </style>
    </head>
    <body class="antialiased bg-gray-50 text-gray-800">

        <!-- NAVBAR / HEADER -->
        <header class="fixed w-full z-50 transition-all duration-300 bg-white/95 backdrop-blur-md shadow-sm" id="navbar">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <!-- Logo / Brand -->
                    <div class="flex items-center gap-3">
                        <!-- Placeholder Logo (Ganti dengan logo perusahaan Anda nanti) -->
                        <img src="{{ asset('images/images.png') }}" 
                     alt="Logo Perusahaan" 
                     class="w-12 h-12 mr-3 object-contain bg-white rounded-lg p-1 shadow-md">
                        <div class="leading-tight">
                            <h1 class="font-bold text-gray-900 text-lg">Internship Monitor</h1>
                            <p class="text-xs text-gray-500 font-semibold tracking-wide">PT. PAN BROTHERS Tbk</p>
                        </div>
                    </div>

                    <!-- Auth Links (Logika Laravel) -->
                    <div class="flex items-center gap-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-full transition shadow-md hover:shadow-lg">
                                    Dashboard Saya
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-blue-600 transition">Log in</a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="ml-4 px-5 py-2.5 bg-gray-900 hover:bg-gray-800 text-white font-semibold rounded-full transition">Register</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </header>

        <!-- HERO SECTION WITH CAROUSEL -->
        <div class="relative h-screen min-h-[600px] flex items-center">
            
            <!-- Carousel Container -->
            <div class="absolute inset-0 w-full h-full overflow-hidden bg-gray-900">
                <!-- SLIDE 1: GANTI URL GAMBAR DI SINI -->
                <div class="carousel-slide active">
                    <img src="{{ asset('images/Carousel1.jpg') }}" 
                         class="w-full h-full object-cover" alt="Factory Image">
                </div>
                <!-- SLIDE 2 -->
                <div class="carousel-slide">
                    <img src="{{ asset('images/Carousel2.jpg') }}" 
                         class="w-full h-full object-cover" alt="Meeting Image">
                </div>
                <!-- SLIDE 3 -->
                <div class="carousel-slide">
                    <img src="{{ asset('images/Carousel3.jpg') }}" 
                         class="w-full h-full object-cover" alt="Working Image">
                </div>
                
                <!-- Overlay Gradient -->
                <div class="absolute inset-0 hero-overlay z-20"></div>
            </div>

            <!-- Hero Content Text -->
            <div class="relative z-30 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                <div class="max-w-3xl">
                    <span class="inline-block py-1 px-3 rounded-full bg-blue-600/20 border border-blue-400 text-blue-300 text-sm font-semibold mb-6 backdrop-blur-sm">
                        Program Pemagangan Dalam Negeri
                    </span>
                    <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 leading-tight">
                        Membangun Kompetensi <br>
                        <span class="text-blue-400">Siap Kerja</span> di Industri
                    </h1>
                    <p class="text-lg text-gray-300 mb-8 leading-relaxed max-w-2xl">
                        Selamat datang di portal monitoring magang <strong>PT. Prima Sejati Sejahtera</strong> (Member of PT. Pan Brothers Tbk). Platform ini didedikasikan untuk memantau progress, logbook, dan penilaian peserta magang sesuai standar Kemnaker.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#about" class="px-8 py-4 bg-white text-blue-900 font-bold rounded-lg hover:bg-gray-100 transition shadow-lg text-center">
                            Tentang Program
                        </a>
                        <a href="{{ route('login') }}" class="px-8 py-4 border border-white/30 bg-white/10 backdrop-blur-sm text-white font-bold rounded-lg hover:bg-white/20 transition text-center">
                            Masuk ke Sistem
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- ABOUT SYSTEM SECTION -->
        <section id="about" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-blue-600 font-bold tracking-wide uppercase text-sm mb-2">Platform Monitoring</h2>
                    <h3 class="text-3xl md:text-4xl font-bold text-gray-900">Sistem Terintegrasi & Transparan</h3>
                    <p class="mt-4 text-gray-600 max-w-2xl mx-auto">
                        Website ini dirancang untuk memudahkan Peserta Magang dan Mentor dalam melakukan pencatatan dan evaluasi kegiatan harian.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="p-8 bg-gray-50 rounded-2xl border border-gray-100 hover:border-blue-200 hover:shadow-xl transition duration-300 group">
                        <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center mb-6 group-hover:bg-blue-600 transition duration-300">
                            <svg class="w-7 h-7 text-blue-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-3">Logbook Digital</h4>
                        <p class="text-gray-600 leading-relaxed">Peserta dapat mengisi laporan kegiatan harian secara online yang langsung terhubung dengan dashboard mentor.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="p-8 bg-gray-50 rounded-2xl border border-gray-100 hover:border-blue-200 hover:shadow-xl transition duration-300 group">
                        <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center mb-6 group-hover:bg-green-600 transition duration-300">
                            <svg class="w-7 h-7 text-green-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z"></path></svg>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-3">Progress Tracking</h4>
                        <p class="text-gray-600 leading-relaxed">Visualisasi capaian kompetensi magang untuk memastikan peserta mencapai target kurikulum industri.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="p-8 bg-gray-50 rounded-2xl border border-gray-100 hover:border-blue-200 hover:shadow-xl transition duration-300 group">
                        <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center mb-6 group-hover:bg-purple-600 transition duration-300">
                            <svg class="w-7 h-7 text-purple-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-3">Sertifikasi Kemnaker</h4>
                        <p class="text-gray-600 leading-relaxed">Mendukung validasi data untuk keperluan penerbitan sertifikat pemagangan setelah program selesai.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- COMPANY PROFILE & PROGRAM INFO -->
        <section class="py-20 bg-gray-900 text-white relative overflow-hidden">
            <div class="absolute inset-0 z-0">
            <!-- Gambar Background -->
            <img src="{{ asset('images/PSS.jpg') }}" 
                 class="w-full h-full object-cover" 
                 alt="Background Factory">
            
            <!-- 2. DARK OVERLAY (Agar teks terbaca) -->
            <!-- Menggunakan gradient agar gambar tetap terlihat samar-samar tapi teks kontras -->
            <div class="absolute inset-0 bg-gradient-to-r from-slate-900/95 via-slate-900/90 to-slate-900/80"></div>
        </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    
                    <!-- Text Content -->
                    <div>
                        <div class="flex items-center gap-2 mb-6">
                            <div class="h-1 w-12 bg-blue-500 rounded"></div>
                            <span class="text-blue-400 font-bold uppercase tracking-wider text-sm">Profil Perusahaan</span>
                        </div>
                        
                        <h2 class="text-3xl md:text-4xl font-bold mb-6">PT. Prima Sejati Sejahtera</h2>
                        <h3 class="text-xl text-gray-400 mb-6 font-medium">Member of PT. Pan Brothers Tbk</h3>
                        
                        <p class="text-gray-300 mb-6 leading-relaxed">
                            Kami merupakan bagian strategis dari <strong>PT. Pan Brothers Tbk</strong>, perusahaan garmen manufaktur terbesar di Indonesia. Berfokus pada inovasi, kualitas, dan keberlanjutan, kami memproduksi pakaian untuk merek-merek ternama global.
                        </p>
                        
                        <div class="space-y-4 mb-8">
                            <div class="flex items-start">
                                <svg class="w-6 h-6 text-green-400 mt-1 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <p class="text-gray-300 text-sm">Lingkungan kerja berstandar internasional dengan teknologi garmen modern.</p>
                            </div>
                            <div class="flex items-start">
                                <svg class="w-6 h-6 text-green-400 mt-1 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <p class="text-gray-300 text-sm">Komitmen terhadap pengembangan SDM melalui program pemagangan terstruktur.</p>
                            </div>
                        </div>

                        <a href="https://panbrothers.com" target="_blank" class="inline-flex items-center text-white font-semibold hover:text-blue-400 transition">
                            Kunjungi Website Resmi 
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>

                    <!-- Program Info Box -->
                    <div class="bg-white rounded-2xl p-8 text-gray-800 shadow-2xl transform lg:translate-x-4">
                        <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-100">
                            <!-- Placeholder Logo Kemnaker -->
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center text-xs font-bold text-gray-500">
                                <img src="{{ asset('images/logo_kemnaker.png') }}" 
                         class="w-full h-full object-cover" alt="Logo Kemenaker">
                            </div>
                            <div>
                                <h4 class="font-bold text-xl text-gray-900">Program Pemagangan</h4>
                                <p class="text-sm text-gray-500">Kementerian Ketenagakerjaan RI</p>
                            </div>
                        </div>
                        
                        <p class="text-gray-600 mb-6 text-sm">
                            Program ini bertujuan untuk meningkatkan kompetensi tenaga kerja muda agar siap terjun ke dunia industri garmen, mencakup aspek:
                        </p>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-blue-50 p-4 rounded-lg text-center">
                                <span class="block text-2xl font-bold text-blue-600 mb-1">70%</span>
                                <span class="text-xs font-semibold text-gray-600">Praktek (OJT)</span>
                            </div>
                            <div class="bg-blue-50 p-4 rounded-lg text-center">
                                <span class="block text-2xl font-bold text-blue-600 mb-1">30%</span>
                                <span class="text-xs font-semibold text-gray-600">Teori</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- FOOTER -->
        <footer class="bg-gray-50 border-t border-gray-200 pt-12 pb-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="text-center md:text-left mb-4 md:mb-0">
                        <p class="font-bold text-gray-800">Sistem Monitoring Magang</p>
                        <p class="text-sm text-gray-500">PT. Prima Sejati Sejahtera &copy; {{ date('Y') }}</p>
                    </div>
                    
                    <div class="flex gap-6 text-sm font-medium text-gray-500">
                        <span class="hover:text-blue-600 cursor-pointer">Panduan</span>
                        <span class="hover:text-blue-600 cursor-pointer">Kontak Mentor</span>
                        <span class="hover:text-blue-600 cursor-pointer">Login Admin</span>
                    </div>
                </div>
            </div>
        </footer>

        <!-- SCRIPTS -->
        <script>
            // Logic Carousel Sederhana (Vanilla JS)
            document.addEventListener('DOMContentLoaded', () => {
                const slides = document.querySelectorAll('.carousel-slide');
                let currentSlide = 0;
                const totalSlides = slides.length;

                // Ganti slide setiap 5 detik
                setInterval(() => {
                    // Sembunyikan slide saat ini
                    slides[currentSlide].classList.remove('active');
                    
                    // Pindah ke slide berikutnya (looping)
                    currentSlide = (currentSlide + 1) % totalSlides;
                    
                    // Tampilkan slide baru
                    slides[currentSlide].classList.add('active');
                }, 5000);

                // Navbar Scroll Effect
                const navbar = document.getElementById('navbar');
                window.addEventListener('scroll', () => {
                    if (window.scrollY > 50) {
                        navbar.classList.add('shadow-md');
                        navbar.classList.replace('h-20', 'h-16');
                    } else {
                        navbar.classList.remove('shadow-md');
                        navbar.classList.replace('h-16', 'h-20');
                    }
                });
            });
        </script>
    </body>
</html>