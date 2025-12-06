<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kalender Presensi') }}
        </h2>
    </x-slot>

    <!-- 1. Wrapper Utama dengan Alpine Data untuk Modal -->
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
                
                <!-- Card 1: Progress Masa Magang (Timeline) -->
                <div class="bg-gradient-to-br from-indigo-900 to-slate-900 p-6 rounded-3xl shadow-lg text-white relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full blur-2xl -mr-10 -mt-10"></div>
                    <div class="relative z-10 flex flex-col justify-between h-full">
                        <div>
                            <p class="text-xs font-bold text-indigo-200 uppercase tracking-wider">Periode Magang</p>
                            <div class="flex items-baseline gap-1 mt-1">
                                <h3 class="text-3xl font-black">{{ $magangProgress }}%</h3>
                                <span class="text-xs text-indigo-300">Selesai</span>
                            </div>
                        </div>
                        <div>
                            <div class="w-full bg-slate-700/50 rounded-full h-1.5 mt-3 mb-2">
                                <div class="bg-indigo-400 h-1.5 rounded-full transition-all duration-1000" style="width: {{ $magangProgress }}%"></div>
                            </div>
                            <div class="flex justify-between text-[10px] text-indigo-300 font-mono mb-1">
                                <span>24 Nov 2025</span>
                                <span>23 Mei 2026</span>
                            </div>
                            <p class="text-[10px] text-indigo-200 font-light text-center bg-white/10 rounded py-0.5">
                                {{ $daysPassed }} / {{ $totalDaysInternship }} Hari Berjalan
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Performa Jam Kerja -->
                <div class="bg-white dark:bg-slate-800 p-6 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 relative overflow-hidden group hover:border-blue-300 transition-colors">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Performa Bulan Ini</p>
                    <div class="flex items-baseline gap-1 mt-2">
                        <h3 class="text-3xl font-black text-slate-800 dark:text-white">{{ $totalHours }}</h3>
                        <span class="text-sm font-medium text-slate-500">Jam</span>
                    </div>
                    <div class="mt-3 flex items-center gap-2">
                        <span class="px-2.5 py-1 rounded-lg bg-blue-50 text-blue-600 border border-blue-100 text-xs font-bold">
                            Avg: {{ $avgHours }} Jam/hari
                        </span>
                    </div>
                </div>

                <!-- Card 3: Statistik Aktivitas (Materi vs Praktek) -->
                <div class="bg-white dark:bg-slate-800 p-6 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700 relative overflow-hidden group hover:border-purple-300 transition-colors">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Aktivitas</p>
                    <div class="flex items-center justify-between mt-3 px-1">
                        <div class="text-center">
                            <span class="block text-2xl font-black text-purple-600">{{ $totalLearning }}</span>
                            <span class="text-[10px] font-bold text-slate-400 uppercase">Materi</span>
                        </div>
                        <div class="h-8 w-px bg-slate-200 dark:bg-slate-700"></div>
                        <div class="text-center">
                            <span class="block text-2xl font-black text-emerald-600">{{ $totalExecution }}</span>
                            <span class="text-[10px] font-bold text-slate-400 uppercase">Praktek</span>
                        </div>
                    </div>
                </div>

                <!-- Card 4: Quick Action (Status Hari Ini) -->
                <div class="bg-gradient-to-br from-blue-600 to-indigo-700 p-6 rounded-3xl shadow-lg shadow-blue-500/30 text-white flex flex-col justify-between relative overflow-hidden">
                    <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 mix-blend-soft-light"></div>
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            @if($attendances->has(\Carbon\Carbon::today()->format('Y-m-d')))
                                <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                                <span class="text-[10px] font-bold text-blue-100 uppercase tracking-wider">Sudah Absen</span>
                            @else
                                <span class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse"></span>
                                <span class="text-[10px] font-bold text-blue-100 uppercase tracking-wider">Belum Absen</span>
                            @endif
                        </div>
                        <h4 class="font-bold text-sm leading-tight mt-1">
                            {{ \Carbon\Carbon::now()->translatedFormat('l, d M Y') }}
                        </h4>
                    </div>
                    @if(!$attendances->has(\Carbon\Carbon::today()->format('Y-m-d')))
                        <a href="{{ route('attendances.create') }}" class="mt-3 bg-white/20 hover:bg-white/30 backdrop-blur border border-white/20 text-center py-2 rounded-xl text-xs font-bold transition flex items-center justify-center gap-2">
                            + Input Presensi
                        </a>
                    @else
                        <button disabled class="mt-3 bg-white/10 text-white/50 border border-white/10 text-center py-2 rounded-xl text-xs font-bold cursor-not-allowed flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Data Tersimpan
                        </button>
                    @endif
                </div>

            </div>

            <!-- 3. CALENDAR SECTION -->
            <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] p-8 shadow-xl border border-slate-100 dark:border-slate-700">
                
                <!-- Calendar Header -->
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-2xl font-black text-slate-800 dark:text-white">
                        {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
                    </h3>
                    <div class="flex gap-2">
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
                    $startOfMonth = \Carbon\Carbon::now()->startOfMonth();
                    $endOfMonth = \Carbon\Carbon::now()->endOfMonth();
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
                            $currentDate = \Carbon\Carbon::createFromDate(null, null, $day)->format('Y-m-d');
                            $attendance = $attendances[$currentDate] ?? null;
                            $isToday = $currentDate == \Carbon\Carbon::now()->format('Y-m-d');
                            $isWeekend = \Carbon\Carbon::createFromDate(null, null, $day)->isWeekend();
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
                            @elseif(!$isWeekend && $currentDate <= \Carbon\Carbon::now()->format('Y-m-d'))
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

        <!-- 4. MODAL POP UP (Detail & Edit) -->
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
                                        <div class="space-y-3 max-h-60 overflow-y-auto pr-2">
                                            <template x-for="activity in detail.daily_activities">
                                                <div class="p-3 border border-slate-100 dark:border-slate-700 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700/50 transition">
                                                    <div class="flex items-start gap-3">
                                                        <div class="p-1.5 rounded-lg" :class="activity.type === 'learning' ? 'bg-purple-100 text-purple-600' : 'bg-emerald-100 text-emerald-600'">
                                                            <svg x-show="activity.type === 'learning'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                                            <svg x-show="activity.type !== 'learning'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                        </div>
                                                        <div>
                                                            <p class="text-sm font-bold text-slate-800 dark:text-white" x-text="activity.title"></p>
                                                            <p class="text-xs text-slate-500 mt-1 leading-relaxed" x-text="activity.description"></p>
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