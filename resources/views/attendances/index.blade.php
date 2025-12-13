<x-app-layout>
    {{-- TYPE HINTING UNTUK VS CODE (Agar tidak error merah) --}}
    @php
        /** @var \Carbon\Carbon $currentDate */
        /** @var \Carbon\Carbon $prevMonth */
        /** @var \Carbon\Carbon $nextMonth */
    @endphp

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kalender Presensi') }}
        </h2>
    </x-slot>

    <!-- Wrapper Utama dengan Alpine Data untuk Modal -->
    <div class="py-12 bg-slate-50 dark:bg-gray-900 min-h-screen" x-data="{ showModal: false, detail: {} }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- ALERT SUKSES -->
            @if(session('success'))
                <div class="mb-6 bg-green-500/10 border border-green-500/50 text-green-600 dark:text-green-400 p-4 rounded-2xl backdrop-blur-sm flex items-center gap-3 shadow-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            <!-- 2. KPI SECTION (Top Cards - UPDATED) -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                
                <!-- CARD 1: PROGRESS & SISA WAKTU -->
                <div class="bg-gradient-to-br from-indigo-900 to-slate-900 p-6 rounded-3xl shadow-lg text-white relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/20 rounded-full blur-3xl -mr-16 -mt-16"></div>
                    <div class="relative z-10 h-full flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <p class="text-xs font-bold text-indigo-200 uppercase tracking-wider">Masa Magang</p>
                                <span class="bg-indigo-500/20 text-indigo-300 text-[10px] font-bold px-2 py-0.5 rounded">
                                    {{ $daysRemaining }} Hari Tersisa
                                </span>
                            </div>
                            <div class="flex items-end gap-2 mt-2">
                                <h3 class="text-4xl font-black text-white">{{ $magangProgress }}<span class="text-xl">%</span></h3>
                                <span class="text-xs text-slate-400 mb-1.5 font-medium">Selesai</span>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <div class="w-full bg-slate-700/50 rounded-full h-2 mb-2 overflow-hidden">
                                <div class="bg-gradient-to-r from-indigo-500 to-purple-500 h-2 rounded-full shadow-[0_0_10px_rgba(99,102,241,0.5)] transition-all duration-1000" style="width: {{ $magangProgress }}%"></div>
                            </div>
                            <div class="flex justify-between text-[10px] font-mono text-slate-400">
                                <span>{{ $daysPassed }} Hari Berjalan</span>
                                <span>Total {{ $totalDaysInternship }} Hari</span>
                            </div>
                            <p class="text-[10px] text-slate-500 mt-2 text-center border-t border-slate-700/50 pt-2">
                                24 Nov 2025 - 23 Mei 2026
                            </p>
                        </div>
                    </div>
                </div>

                <!-- CARD 2: DETAIL STATISTIK KEHADIRAN -->
                <div class="bg-white dark:bg-slate-800 p-6 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 relative overflow-hidden group hover:border-blue-300 transition-colors">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Statistik Kehadiran</p>
                    
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <span class="text-3xl font-black text-slate-800 dark:text-white">{{ $totalHadir }}</span>
                            <span class="text-xs font-bold text-slate-500 block">Hadir</span>
                        </div>
                        <div class="h-10 w-px bg-slate-100 dark:bg-slate-700"></div>
                        <div class="text-right">
                            <span class="text-lg font-bold text-blue-600">{{ $attendanceRate }}%</span>
                            <span class="text-[10px] text-slate-400 block">Rate Kehadiran</span>
                        </div>
                    </div>

                    <!-- Breakdown Mini -->
                    <div class="grid grid-cols-3 gap-2">
                        <div class="bg-amber-50 dark:bg-amber-900/10 rounded-xl p-2 text-center border border-amber-100 dark:border-amber-800/30">
                            <span class="block text-sm font-black text-amber-600">{{ $totalIzin }}</span>
                            <span class="text-[9px] font-bold text-amber-500 uppercase">Izin</span>
                        </div>
                        <div class="bg-red-50 dark:bg-red-900/10 rounded-xl p-2 text-center border border-red-100 dark:border-red-800/30">
                            <span class="block text-sm font-black text-red-600">{{ $totalSakit }}</span>
                            <span class="text-[9px] font-bold text-red-500 uppercase">Sakit</span>
                        </div>
                        <div class="bg-slate-100 dark:bg-slate-700 rounded-xl p-2 text-center border border-slate-200 dark:border-slate-600">
                            <span class="block text-sm font-black text-slate-600 dark:text-slate-300">{{ $totalAlpa }}</span>
                            <span class="text-[9px] font-bold text-slate-400 uppercase">Alpa</span>
                        </div>
                    </div>
                </div>

                <!-- CARD 3: PRODUKTIVITAS & AKTIVITAS -->
                <div class="bg-white dark:bg-slate-800 p-6 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 relative overflow-hidden group hover:border-emerald-300 transition-colors">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Produktivitas & Output</p>
                    
                    <div class="flex items-end gap-2 mb-4">
                        <h3 class="text-3xl font-black text-slate-800 dark:text-white">{{ $totalHours }}</h3>
                        <div class="mb-1">
                            <span class="text-xs font-bold text-slate-500 block">Jam Kerja</span>
                            <span class="text-[10px] text-emerald-600 font-bold bg-emerald-50 px-1.5 py-0.5 rounded">Avg: {{ $avgHours }} /hari</span>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <!-- Progress Materi -->
                        <div>
                            <div class="flex justify-between text-[10px] font-bold mb-1">
                                <span class="text-purple-600">Pembelajaran ({{ $totalLearning }})</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-1.5">
                                <div class="bg-purple-500 h-1.5 rounded-full" style="width: {{ ($totalLearning + $totalExecution) > 0 ? ($totalLearning / ($totalLearning + $totalExecution) * 100) : 0 }}%"></div>
                            </div>
                        </div>
                        <!-- Progress Praktek -->
                        <div>
                            <div class="flex justify-between text-[10px] font-bold mb-1">
                                <span class="text-emerald-600">Praktek Jobdesk ({{ $totalExecution }})</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-1.5">
                                <div class="bg-emerald-500 h-1.5 rounded-full" style="width: {{ ($totalLearning + $totalExecution) > 0 ? ($totalExecution / ($totalLearning + $totalExecution) * 100) : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CARD 4: STATUS HARI INI (QUICK ACTION) -->
                @php
                    $isAttendedToday = $attendances->has(\Carbon\Carbon::today()->format('Y-m-d'));
                    $todayData = $isAttendedToday ? $attendances[\Carbon\Carbon::today()->format('Y-m-d')] : null;
                @endphp
                <div class="bg-gradient-to-br {{ $isAttendedToday ? 'from-emerald-600 to-teal-700' : 'from-blue-600 to-indigo-700' }} p-6 rounded-3xl shadow-lg shadow-blue-500/20 text-white flex flex-col justify-between relative overflow-hidden group">
                    <!-- Background Pattern -->
                    <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-10 mix-blend-soft-light"></div>
                    <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-white/20 rounded-full blur-xl group-hover:scale-150 transition-transform"></div>

                    <div class="relative z-10">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="w-2.5 h-2.5 bg-white rounded-full {{ $isAttendedToday ? '' : 'animate-pulse' }}"></span>
                            <span class="text-[10px] font-bold text-white/90 uppercase tracking-wider">
                                {{ $isAttendedToday ? 'SUDAH ABSEN' : 'BELUM ABSEN' }}
                            </span>
                        </div>
                        <h4 class="font-bold text-lg leading-tight mb-1">
                            {{ \Carbon\Carbon::now()->translatedFormat('l, d M Y') }}
                        </h4>
                        
                        @if($isAttendedToday)
                            <div class="mt-3 bg-white/20 backdrop-blur rounded-xl p-2 text-center border border-white/10">
                                <p class="text-[10px] text-white/80 uppercase font-bold">Jam Kerja</p>
                                <p class="text-sm font-mono font-bold">
                                    {{ \Carbon\Carbon::parse($todayData->check_in)->format('H:i') }} - {{ $todayData->check_out ? \Carbon\Carbon::parse($todayData->check_out)->format('H:i') : '??:??' }}
                                </p>
                            </div>
                        @endif
                    </div>
                    
                    <div class="relative z-10 mt-4">
                        @if(!$isAttendedToday)
                            <a href="{{ route('attendances.create') }}" class="w-full bg-white text-blue-600 hover:bg-blue-50 border border-transparent text-center py-3 rounded-xl text-xs font-bold transition shadow-md flex items-center justify-center gap-2 transform active:scale-95">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Input Presensi
                            </a>
                        @else
                            <button disabled class="w-full bg-black/20 text-white/70 border border-white/10 text-center py-3 rounded-xl text-xs font-bold cursor-not-allowed flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Data Tersimpan
                            </button>
                        @endif
                    </div>
                </div>

            </div>
            
            <!-- BUTTON DOWNLOAD PDF -->
            <div class="bg-white dark:bg-slate-800 p-4 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 mb-8">
                <form action="{{ route('attendances.pdf') }}" method="GET" class="flex flex-col md:flex-row items-center gap-4 justify-between">
                    <div class="flex items-center gap-4 w-full md:w-auto">
                        <div class="flex flex-col">
                            <label class="text-[10px] font-bold text-slate-400 uppercase mb-1">Dari Tanggal</label>
                            <input type="date" name="start_date" value="{{ \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d') }}" class="rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-slate-700 dark:text-white">
                        </div>
                        <div class="flex flex-col">
                            <label class="text-[10px] font-bold text-slate-400 uppercase mb-1">Sampai Tanggal</label>
                            <input type="date" name="end_date" value="{{ \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d') }}" class="rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-slate-700 dark:text-white">
                        </div>
                    </div>
                    
                    <button type="submit" class="w-full md:w-auto px-6 py-2.5 bg-slate-800 text-white rounded-xl text-sm font-bold hover:bg-slate-700 transition flex items-center justify-center gap-2 shadow-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Download Laporan PDF
                    </button>
                </form>
            </div>

            <!-- 3. CALENDAR SECTION -->
            <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] p-8 shadow-xl border border-slate-100 dark:border-slate-700">
                
                <!-- Calendar Header (With Navigation) -->
                <div class="flex flex-col md:flex-row items-center justify-between mb-8 gap-4">
                    <div class="flex items-center gap-4 order-2 md:order-1">
                        <!-- Prev Button -->
                        <a href="{{ route('attendances.index', ['month' => $prevMonth->month, 'year' => $prevMonth->year]) }}" 
                           class="p-2 rounded-xl bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-blue-100 hover:text-blue-600 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </a>
                        
                        <!-- Month Title -->
                        <h3 class="text-2xl font-black text-slate-800 dark:text-white min-w-[180px] text-center">
                            {{ $currentDate->translatedFormat('F Y') }}
                        </h3>

                        <!-- Next Button -->
                        <a href="{{ route('attendances.index', ['month' => $nextMonth->month, 'year' => $nextMonth->year]) }}" 
                           class="p-2 rounded-xl bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-blue-100 hover:text-blue-600 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>

                    <div class="flex gap-2 order-1 md:order-2">
                        <span class="flex items-center gap-1 text-xs font-bold text-slate-500">
                            <span class="w-2 h-2 rounded-full bg-green-500"></span> Hadir
                        </span>
                        <span class="flex items-center gap-1 text-xs font-bold text-slate-500">
                            <span class="w-2 h-2 rounded-full bg-amber-500"></span> Izin
                        </span>
                        <span class="flex items-center gap-1 text-xs font-bold text-slate-500">
                            <span class="w-2 h-2 rounded-full bg-red-500"></span> Sakit
                        </span>
                    </div>
                </div>

                <!-- Calendar Grid -->
                @php
                    $startOfMonth = $currentDate->copy()->startOfMonth();
                    $daysInMonth = $startOfMonth->daysInMonth;
                    $startDayOfWeek = $startOfMonth->dayOfWeekIso; // 1 (Mon) - 7 (Sun)
                @endphp

                <div class="grid grid-cols-7 gap-4">
                    <!-- Day Headers -->
                    @foreach(['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'] as $day)
                        <div class="text-center text-sm font-bold text-slate-400 uppercase tracking-wider py-2">
                            {{ $day }}
                        </div>
                    @endforeach

                    <!-- Empty Cells for start padding -->
                    @for($i = 1; $i < $startDayOfWeek; $i++)
                        <div class="h-32 rounded-2xl bg-slate-50/50 dark:bg-slate-900/50 border border-transparent"></div>
                    @endfor

                    <!-- Date Cells -->
                    @for($day = 1; $day <= $daysInMonth; $day++)
                        @php
                            $loopDate = $currentDate->copy()->day($day)->format('Y-m-d');
                            $attendance = $attendances[$loopDate] ?? null;
                            $isToday = $loopDate == \Carbon\Carbon::now()->format('Y-m-d');
                            $isWeekend = $currentDate->copy()->day($day)->isWeekend();
                        @endphp

                        <div 
                            @if($attendance)
                                @click="showModal = true; detail = {{ $attendance->toJson() }}"
                            @endif
                            class="relative h-32 group {{ $isToday ? 'ring-2 ring-blue-500 ring-offset-2 dark:ring-offset-slate-800' : '' }} rounded-2xl bg-slate-50 dark:bg-slate-900 border {{ $attendance ? 'border-slate-200 dark:border-slate-600 cursor-pointer hover:border-blue-400' : 'border-slate-100 dark:border-slate-800' }} hover:shadow-lg transition-all p-3 flex flex-col justify-between overflow-hidden">
                            
                            <!-- Date Number -->
                            <div class="flex justify-between items-start">
                                <span class="text-lg font-bold {{ $isToday ? 'text-blue-600' : ($isWeekend ? 'text-red-400' : 'text-slate-700 dark:text-slate-300') }}">
                                    {{ $day }}
                                </span>
                                
                                @if($attendance)
                                    <!-- Status Indicator Dot -->
                                    @if($attendance->status == 'hadir')
                                        <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center">
                                            <svg class="w-3.5 h-3.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                    @elseif($attendance->status == 'izin')
                                        <div class="w-6 h-6 rounded-full bg-amber-100 flex items-center justify-center">
                                            <span class="text-[10px] font-bold text-amber-600">IZ</span>
                                        </div>
                                    @else
                                        <div class="w-6 h-6 rounded-full bg-red-100 flex items-center justify-center">
                                            <span class="text-[10px] font-bold text-red-600">SK</span>
                                        </div>
                                    @endif
                                @endif
                            </div>

                            <!-- Content Area -->
                            @if($attendance)
                                <div class="mt-2">
                                    @if($attendance->status == 'hadir')
                                        <div class="text-xs font-medium text-slate-500 dark:text-slate-400 flex items-center gap-1">
                                            <svg class="w-3 h-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                                            {{ \Carbon\Carbon::parse($attendance->check_in)->format('H:i') }}
                                        </div>
                                        <div class="text-xs font-medium text-slate-500 dark:text-slate-400 flex items-center gap-1 mt-0.5">
                                            <svg class="w-3 h-3 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                                            {{ \Carbon\Carbon::parse($attendance->check_out)->format('H:i') }}
                                        </div>
                                        <!-- Activities Count -->
                                        @if($attendance->daily_activities->count() > 0)
                                            <div class="mt-2 text-[10px] bg-blue-50 text-blue-600 px-1.5 py-0.5 rounded inline-block font-bold">
                                                {{ $attendance->daily_activities->count() }} Aktivitas
                                            </div>
                                        @endif
                                    @else
                                        <p class="text-[10px] text-slate-400 leading-tight line-clamp-2">
                                            {{ $attendance->notes }}
                                        </p>
                                    @endif
                                </div>
                            @elseif(!$isWeekend && $loopDate <= \Carbon\Carbon::now()->format('Y-m-d'))
                                <!-- Button Input for Past/Current Empty Days -->
                                <a href="{{ route('attendances.create') }}" class="absolute inset-0 flex items-center justify-center bg-slate-100/50 opacity-0 group-hover:opacity-100 transition-opacity backdrop-blur-[1px]">
                                    <div class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center shadow-lg transform translate-y-2 group-hover:translate-y-0 transition-transform">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    </div>
                                </a>
                            @endif

                        </div>
                    @endfor
                </div>
            </div>
            
            <!-- Legend / Footer Info -->
            <div class="mt-6 text-center text-xs text-slate-400">
                Klik tombol <span class="font-bold text-blue-500">+</span> pada tanggal kosong untuk mengisi logbook susulan. Klik tanggal terisi untuk lihat detail.
            </div>

        </div>

        <!-- 4. MODAL POP UP (Detail & Edit - UPDATED WITH OBSTACLES) -->
        <div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <!-- Backdrop -->
            <div x-show="showModal" 
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
                 class="fixed inset-0 bg-slate-900/75 backdrop-blur-sm transition-opacity" @click="showModal = false"></div>

            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <!-- Modal Panel -->
                <div x-show="showModal" 
                     x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     class="relative transform overflow-hidden rounded-3xl bg-white dark:bg-slate-800 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    
                    <div class="bg-white dark:bg-slate-800 px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                                <h3 class="text-xl font-bold leading-6 text-slate-900 dark:text-white" id="modal-title">
                                    Detail Presensi & Logbook
                                </h3>
                                <div class="mt-4 space-y-4">
                                    
                                    <!-- Status Header -->
                                    <div class="flex justify-between items-center p-4 bg-slate-50 dark:bg-slate-700 rounded-xl">
                                        <div>
                                            <p class="text-xs text-slate-500 uppercase font-bold">Status</p>
                                            <p class="text-lg font-bold uppercase" :class="{
                                                'text-green-600': detail.status === 'hadir',
                                                'text-amber-600': detail.status === 'izin',
                                                'text-red-600': detail.status === 'sakit'
                                            }" x-text="detail.status"></p>
                                        </div>
                                        <div class="text-right" x-show="detail.status === 'hadir'">
                                            <p class="text-xs text-slate-500 uppercase font-bold">Jam Kerja</p>
                                            <p class="text-slate-800 dark:text-white font-mono font-bold">
                                                <span x-text="detail.check_in?.substring(0,5)"></span> - <span x-text="detail.check_out?.substring(0,5)"></span>
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Notes (For Izin/Sakit) -->
                                    <div x-show="detail.status !== 'hadir'" class="p-4 border border-slate-100 dark:border-slate-700 rounded-xl">
                                        <p class="text-xs text-slate-400 uppercase font-bold mb-1">Keterangan</p>
                                        <p class="text-slate-700 dark:text-slate-300" x-text="detail.notes || '-'"></p>
                                    </div>

                                    <!-- Activities List (For Hadir) -->
                                    <div x-show="detail.status === 'hadir'">
                                        <p class="text-xs text-slate-400 uppercase font-bold mb-3">Aktivitas Harian</p>
                                        <div class="space-y-3 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                                            <template x-for="activity in detail.daily_activities">
                                                <div class="p-3 border border-slate-100 dark:border-slate-700 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700/50 transition mb-3">
                                                    <div class="flex items-start gap-3">
                                                        <div class="p-1.5 rounded-lg" :class="activity.type === 'learning' ? 'bg-purple-100 text-purple-600' : 'bg-emerald-100 text-emerald-600'">
                                                            <svg x-show="activity.type === 'learning'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                                            <svg x-show="activity.type !== 'learning'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                        </div>
                                                        <div class="flex-1">
                                                            <p class="text-sm font-bold text-slate-800 dark:text-white" x-text="activity.title"></p>
                                                            <p class="text-xs text-slate-500 mt-1 leading-relaxed whitespace-pre-wrap" x-text="activity.description"></p>
                                                            
                                                            <!-- NEW SECTION: Obstacles & Improvements -->
                                                            <div class="mt-3 grid gap-2" x-show="activity.obstacles || activity.improvements">
                                                                 <!-- Obstacles -->
                                                                 <div x-show="activity.obstacles" class="flex gap-2 items-start bg-red-50 dark:bg-red-900/10 p-2 rounded-lg border border-red-100 dark:border-red-900/30">
                                                                    <span class="text-[10px] font-bold text-red-500 uppercase tracking-wide mt-0.5 min-w-[60px]">Kendala:</span>
                                                                    <p class="text-xs text-slate-600 dark:text-slate-300 italic whitespace-pre-wrap" x-text="activity.obstacles"></p>
                                                                 </div>
                                                                 <!-- Improvements -->
                                                                 <div x-show="activity.improvements" class="flex gap-2 items-start bg-green-50 dark:bg-green-900/10 p-2 rounded-lg border border-green-100 dark:border-green-900/30">
                                                                    <span class="text-[10px] font-bold text-green-600 uppercase tracking-wide mt-0.5 min-w-[60px]">Solusi:</span>
                                                                    <p class="text-xs text-slate-600 dark:text-slate-300 italic whitespace-pre-wrap" x-text="activity.improvements"></p>
                                                                 </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                            <div x-show="!detail.daily_activities?.length" class="text-center text-slate-400 text-sm py-4">
                                                Tidak ada detail aktivitas.
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- FOOTER MODAL: Tombol Edit & Tutup -->
                    <div class="bg-slate-50 dark:bg-slate-700/50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-2">
                        <!-- TOMBOL EDIT -->
                        <a :href="'/attendances/' + detail.id + '/edit'" class="mt-3 inline-flex w-full justify-center rounded-xl bg-blue-600 px-4 py-2 text-sm font-bold text-white shadow-sm hover:bg-blue-500 sm:mt-0 sm:w-auto items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Edit Logbook
                        </a>
                        
                        <!-- TOMBOL TUTUP -->
                        <button type="button" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-3 py-2 text-sm font-bold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0 sm:w-auto" @click="showModal = false">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>