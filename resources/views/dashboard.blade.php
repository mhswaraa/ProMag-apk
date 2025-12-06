<x-app-layout>

    <!-- Main Content Wrapper -->
    <div class="pb-12 bg-slate-50 dark:bg-gray-900 min-h-screen">
        
        <!-- 1. HERO BANNER SECTION (FUTURISTIC THEME) -->
        <!-- Gradient Deep Space & Cyberpunk Accents -->
        <div class="relative bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 pb-36 pt-16 rounded-b-[3rem] shadow-2xl shadow-purple-900/20 overflow-hidden">
            
            <!-- Grid Pattern Overlay -->
            <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 mix-blend-soft-light"></div>
            
            <!-- Futuristic Glows -->
            <div class="absolute top-0 left-1/4 -mt-20 w-96 h-96 rounded-full bg-blue-600/30 blur-[100px] animate-pulse"></div>
            <div class="absolute bottom-0 right-1/4 -mb-20 w-80 h-80 rounded-full bg-purple-600/30 blur-[100px]"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 flex flex-col md:flex-row justify-between items-center">
                <div class="text-white mb-8 md:mb-0 text-center md:text-left">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 backdrop-blur-md mb-4">
                        <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                        <span class="text-xs font-medium tracking-wider text-green-300 uppercase">System Online</span>
                    </div>
                    <h1 class="text-4xl md:text-5xl font-black tracking-tight mb-2 text-transparent bg-clip-text bg-gradient-to-r from-white via-blue-100 to-blue-200 drop-shadow-sm">
                        Halo, {{ Str::words(Auth::user()->name, 1, '') }}! 🚀
                    </h1>
                    <p class="text-blue-200/80 text-lg max-w-xl font-light leading-relaxed">
                        Dashboard monitoring aktif. Siap untuk mencetak progress baru hari ini?
                    </p>
                </div>
                
                <!-- Quick Action Button (Glassmorphism & Neon) -->
                <div class="flex gap-4">
                    <button class="group relative px-6 py-3 rounded-2xl bg-slate-800/50 text-white border border-white/10 backdrop-blur-md overflow-hidden transition-all hover:border-blue-400/50 hover:shadow-[0_0_20px_rgba(59,130,246,0.3)]">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-600/20 to-purple-600/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <span class="relative flex items-center gap-2 font-semibold">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Logbook Baru
                        </span>
                    </button>
                    <button class="relative px-6 py-3 rounded-2xl bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold shadow-lg shadow-blue-600/30 transition-all hover:scale-105 hover:shadow-[0_0_25px_rgba(99,102,241,0.5)] flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        Presensi Masuk
                    </button>
                </div>
            </div>
        </div>

        <!-- 2. FLOATING STATS CARDS (Cyber-style) -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-24 relative z-20">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Card 1: Total Kehadiran -->
                <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 shadow-xl shadow-slate-200/50 dark:shadow-black/50 border border-white/50 dark:border-slate-700/50 backdrop-blur-xl hover:-translate-y-2 transition-transform duration-300 group relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/10 rounded-full blur-3xl -mr-16 -mt-16 group-hover:bg-blue-500/20 transition-all"></div>
                    
                    <div class="flex justify-between items-start relative">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total Kehadiran</p>
                            <h3 class="text-4xl font-black text-slate-800 dark:text-white mt-2 group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-blue-600 group-hover:to-cyan-500 transition-all">
                                {{ $totalHadir ?? 0 }} <span class="text-lg font-semibold text-slate-400">Hari</span>
                            </h3>
                        </div>
                        <div class="p-3.5 bg-blue-50 dark:bg-blue-900/30 rounded-2xl group-hover:scale-110 transition-transform duration-300 ring-1 ring-blue-100 dark:ring-blue-800">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    </div>
                    <div class="mt-6 flex items-center gap-2">
                        <div class="flex-1 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-blue-500 w-3/4 rounded-full"></div>
                        </div>
                        <div class="text-[10px] font-bold text-slate-400">DETAIL</div>
                    </div>
                    <div class="mt-2 flex gap-2">
                         <span class="text-xs font-medium px-2.5 py-1 bg-green-50 text-green-600 rounded-lg border border-green-100">Izin: {{ $totalIzin ?? 0 }}</span>
                         <span class="text-xs font-medium px-2.5 py-1 bg-amber-50 text-amber-600 rounded-lg border border-amber-100">Sakit: {{ $totalSakit ?? 0 }}</span>
                    </div>
                </div>

                <!-- Card 2: Progress KPI -->
                <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 shadow-xl shadow-slate-200/50 dark:shadow-black/50 border border-white/50 dark:border-slate-700/50 backdrop-blur-xl hover:-translate-y-2 transition-transform duration-300 group relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/10 rounded-full blur-3xl -mr-16 -mt-16 group-hover:bg-emerald-500/20 transition-all"></div>

                    <div class="flex justify-between items-start relative">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Capaian KPI</p>
                            <h3 class="text-4xl font-black text-slate-800 dark:text-white mt-2 group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-emerald-600 group-hover:to-teal-500 transition-all">
                                {{ $kpiProgress ?? 0 }}%
                            </h3>
                        </div>
                        <div class="p-3.5 bg-emerald-50 dark:bg-emerald-900/30 rounded-2xl group-hover:scale-110 transition-transform duration-300 ring-1 ring-emerald-100 dark:ring-emerald-800">
                            <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    
                    <!-- Futuristic Progress Bar -->
                    <div class="relative w-full bg-slate-100 dark:bg-slate-700 rounded-full h-3 mt-6 overflow-hidden box-border border border-slate-200 dark:border-slate-600">
                        <!-- Glow effect behind bar -->
                        <div class="absolute top-0 left-0 h-full bg-emerald-400 blur-sm opacity-50" style="width: {{ $kpiProgress ?? 0 }}%"></div>
                        <div class="absolute top-0 left-0 h-full bg-gradient-to-r from-emerald-500 to-teal-400 rounded-full" style="width: {{ $kpiProgress ?? 0 }}%"></div>
                    </div>
                    <p class="mt-3 text-xs font-medium text-slate-400 text-right">{{ $totalKpi ?? 0 }} Target ditetapkan</p>
                </div>

                <!-- Card 3: Sisa Waktu -->
                <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 shadow-xl shadow-slate-200/50 dark:shadow-black/50 border border-white/50 dark:border-slate-700/50 backdrop-blur-xl hover:-translate-y-2 transition-transform duration-300 group relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-purple-500/10 rounded-full blur-3xl -mr-16 -mt-16 group-hover:bg-purple-500/20 transition-all"></div>

                    <div class="flex justify-between items-start relative">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Sisa Waktu</p>
                            <h3 class="text-4xl font-black text-slate-800 dark:text-white mt-2 group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-purple-600 group-hover:to-pink-500 transition-all">
                                5 <span class="text-lg font-semibold text-slate-400">Bulan</span>
                            </h3>
                        </div>
                        <div class="p-3.5 bg-purple-50 dark:bg-purple-900/30 rounded-2xl group-hover:scale-110 transition-transform duration-300 ring-1 ring-purple-100 dark:ring-purple-800">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    <div class="mt-6 flex items-center gap-3 p-3 bg-slate-50 dark:bg-slate-700/50 rounded-xl border border-slate-100 dark:border-slate-600">
                        <div class="relative">
                            <span class="absolute w-3 h-3 rounded-full bg-purple-500 animate-ping opacity-75"></span>
                            <span class="relative block w-3 h-3 rounded-full bg-purple-500"></span>
                        </div>
                        <div class="flex flex-col">
                             <span class="text-[10px] font-bold text-slate-400 uppercase">Deadline</span>
                             <span class="text-xs font-bold text-slate-700 dark:text-slate-200">Mei 2026</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- 3. MAIN GRID SECTION -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- LEFT COLUMN (2/3): Activity Chart / Logbook -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Chart / Activity Section -->
                    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 p-8 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-slate-50 dark:bg-slate-700/20 rounded-full blur-3xl -mr-32 -mt-32 pointer-events-none"></div>
                        
                        <div class="flex justify-between items-center mb-8 relative z-10">
                            <h4 class="text-xl font-bold text-slate-800 dark:text-white flex items-center gap-3">
                                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-100 text-blue-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                                </span>
                                Aktivitas & Produktivitas
                            </h4>
                            <select class="text-sm bg-slate-50 border-none ring-1 ring-slate-200 rounded-xl px-4 py-2 shadow-sm focus:ring-2 focus:ring-blue-500 text-slate-600 font-medium">
                                <option>Minggu Ini</option>
                                <option>Bulan Ini</option>
                            </select>
                        </div>
                        
                        <!-- Placeholder Chart / Empty State -->
                        <div class="bg-slate-50/50 dark:bg-slate-900/50 rounded-2xl border-2 border-dashed border-slate-200 dark:border-slate-600 h-72 flex flex-col items-center justify-center text-center p-6 relative overflow-hidden group hover:border-blue-300 transition-colors">
                            <div class="relative z-10">
                                <div class="w-20 h-20 bg-gradient-to-tr from-blue-100 to-indigo-100 dark:from-slate-700 dark:to-slate-600 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-inner group-hover:scale-110 transition-transform duration-300 rotate-3 group-hover:rotate-6">
                                    <svg class="w-10 h-10 text-blue-500 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                </div>
                                <h5 class="text-slate-800 dark:text-white font-bold text-lg">Data Belum Tersedia</h5>
                                <p class="text-slate-500 dark:text-slate-400 mt-2 max-w-sm mx-auto leading-relaxed">
                                    Sistem akan menampilkan analitik performa secara otomatis setelah Anda menginput logbook harian.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- RIGHT COLUMN (1/3): Skills & Notification -->
                <div class="space-y-8">
                    
                    <!-- Skill Upgrade Card -->
                    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 p-8">
                        <div class="flex justify-between items-center mb-6">
                            <h4 class="text-xl font-bold text-slate-800 dark:text-white flex items-center gap-3">
                                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-purple-100 text-purple-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                </span>
                                Skill Upgrade
                            </h4>
                            <a href="#" class="text-sm text-purple-600 hover:text-purple-700 font-bold hover:underline">View All</a>
                        </div>

                        @if($skills->isEmpty())
                            <div class="text-center py-10 bg-slate-50 dark:bg-slate-900/50 rounded-2xl border border-dashed border-slate-200">
                                <div class="w-14 h-14 bg-purple-50 rounded-full flex items-center justify-center mx-auto mb-4 ring-4 ring-purple-50/50">
                                    <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                </div>
                                <p class="text-sm font-medium text-slate-500">Belum ada skill terdata.</p>
                                <button class="mt-4 text-xs font-bold bg-purple-600 text-white px-4 py-2 rounded-xl hover:bg-purple-700 transition shadow-lg shadow-purple-200">
                                    + Tambah Skill
                                </button>
                            </div>
                        @else
                            <div class="space-y-6">
                                @foreach($skills as $skill)
                                <div class="group">
                                    <div class="flex justify-between mb-2">
                                        <span class="text-sm font-bold text-slate-700 dark:text-gray-300">{{ $skill->name }}</span>
                                        <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-md">{{ $skill->current_level }}%</span>
                                    </div>
                                    <div class="w-full bg-slate-100 rounded-full h-2.5 dark:bg-slate-700 overflow-hidden">
                                        <div class="bg-gradient-to-r from-blue-500 to-indigo-500 h-2.5 rounded-full transition-all duration-500 group-hover:from-blue-400 group-hover:to-indigo-400 relative" style="width: {{ $skill->current_level }}%">
                                            <div class="absolute inset-0 bg-white/30 w-full h-full animate-[shimmer_2s_infinite]"></div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Mini Card: Mentor Info (Dark Glassmorphism) -->
                    <div class="relative rounded-3xl p-6 overflow-hidden shadow-2xl group">
                         <!-- Background Image / Gradient -->
                         <div class="absolute inset-0 bg-slate-900">
                             <div class="absolute inset-0 bg-gradient-to-br from-indigo-600/20 to-purple-600/20 mix-blend-overlay"></div>
                         </div>
                         
                         <!-- Decorative Blurs -->
                         <div class="absolute -top-10 -right-10 w-32 h-32 bg-purple-500/30 rounded-full blur-2xl group-hover:bg-purple-500/40 transition-all"></div>
                         <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-blue-500/30 rounded-full blur-2xl group-hover:bg-blue-500/40 transition-all"></div>

                         <div class="relative z-10 text-white">
                             <div class="flex justify-between items-start mb-4">
                                 <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Mentor Lapangan</h4>
                                 <span class="px-2 py-1 rounded bg-white/10 backdrop-blur text-[10px] font-bold border border-white/10">ONLINE</span>
                             </div>
                             
                             <div class="flex items-center gap-4">
                                 <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-slate-700 to-slate-800 flex items-center justify-center font-bold text-lg border border-slate-600 shadow-inner">
                                     M
                                 </div>
                                 <div>
                                     <p class="font-bold text-lg leading-tight">Bpk. Mentor</p>
                                     <p class="text-xs text-slate-300 font-medium">Head of IT Division</p>
                                 </div>
                             </div>
                             
                             <div class="mt-6 flex gap-2">
                                 <button class="flex-1 py-2 rounded-xl bg-white/10 hover:bg-white/20 border border-white/10 backdrop-blur-sm text-xs font-bold transition">Message</button>
                                 <button class="flex-1 py-2 rounded-xl bg-blue-600/80 hover:bg-blue-600 border border-transparent text-xs font-bold transition shadow-lg shadow-blue-900/50">Schedule</button>
                             </div>
                         </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>