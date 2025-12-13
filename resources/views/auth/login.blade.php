<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ProMag') }} - Login</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        
        <!-- Main Container with Background -->
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative overflow-hidden">
            
            <!-- 1. Background Image Full Screen -->
            <div class="absolute inset-0 z-0">
                <!-- Menggunakan gambar PSS.jpg agar senada dengan Welcome Page -->
                <img src="{{ asset('images/Carousel1.jpg') }}" alt="Background" class="w-full h-full object-cover">
                <!-- Overlay Gradient Gelap supaya form kontras -->
                <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm bg-gradient-to-br from-slate-900/50 to-blue-900/50"></div>
            </div>

            <!-- 2. Login Card -->
            <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white dark:bg-slate-800 shadow-2xl overflow-hidden sm:rounded-[2rem] relative z-10 border border-white/20">
                
                <!-- Header: Logo & Title -->
                <div class="text-center mb-10">
                    <div class="flex justify-center mb-6">
                        <div class="p-4 bg-blue-50 dark:bg-slate-700/50 rounded-3xl shadow-inner ring-1 ring-blue-100 dark:ring-slate-600">
                            <!-- Logo Perusahaan -->
                            <img src="{{ asset('images/images.png') }}" alt="Logo" class="w-16 h-16 object-contain drop-shadow-sm">
                        </div>
                    </div>
                    
                    <h2 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Selamat Datang</h2>
                    <p class="text-slate-500 dark:text-slate-400 mt-2 text-sm font-medium">Masuk untuk mengakses sistem monitoring.</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div class="group">
                        <label for="email" class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1 group-focus-within:text-blue-600 transition-colors">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                            </div>
                            <input id="email" class="block w-full pl-11 pr-4 py-3.5 rounded-2xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-900/50 text-slate-800 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-medium sm:text-sm" 
                                          type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@email.com" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="group">
                        <label for="password" class="block text-xs font-bold text-slate-500 uppercase mb-2 ml-1 group-focus-within:text-blue-600 transition-colors">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <input id="password" class="block w-full pl-11 pr-4 py-3.5 rounded-2xl border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-900/50 text-slate-800 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-medium sm:text-sm"
                                            type="password"
                                            name="password"
                                            required autocomplete="current-password" placeholder="••••••••" />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                            <input id="remember_me" type="checkbox" class="rounded-lg border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 w-4 h-4 cursor-pointer" name="remember">
                            <span class="ms-2 text-sm text-gray-500 dark:text-gray-400 font-medium group-hover:text-blue-600 transition-colors">{{ __('Ingat saya') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm font-bold text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition-colors" href="{{ route('password.request') }}">
                                {{ __('Lupa password?') }}
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit" class="w-full py-4 px-4 bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white font-bold rounded-2xl shadow-lg shadow-blue-500/30 transition-all transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 flex justify-center items-center gap-2">
                            <span>Masuk ke Dashboard</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                    
                    <!-- Register Link -->
                    <div class="text-center mt-6 pt-6 border-t border-slate-100 dark:border-slate-700">
                        <p class="text-sm text-slate-500">Belum memiliki akun? 
                            <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:underline hover:text-blue-700 ml-1">Daftar Magang</a>
                        </p>
                    </div>
                </form>
            </div>
            
            <!-- Footer Text -->
            <div class="relative z-10 mt-8 text-white/60 text-xs font-medium">
                &copy; {{ date('Y') }} PT. Prima Sejati Sejahtera. All rights reserved.
            </div>
        </div>
    </body>
</html>