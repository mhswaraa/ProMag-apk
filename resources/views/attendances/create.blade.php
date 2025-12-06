<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Input Logbook Harian') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 dark:bg-gray-900 min-h-screen" x-data="logbookForm()">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <form action="{{ route('attendances.store') }}" method="POST">
                @csrf
                
                <!-- 1. STATUS PRESENSI CARD -->
                <div class="bg-white dark:bg-slate-800 rounded-3xl p-8 shadow-sm border border-slate-100 dark:border-slate-700 mb-8">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">1</span>
                        Status Kehadiran
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Pilihan Hadir -->
                        <label class="cursor-pointer">
                            <input type="radio" name="status" value="hadir" x-model="status" class="peer sr-only">
                            <div class="p-4 rounded-xl border-2 border-slate-100 dark:border-slate-700 peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20 transition-all hover:bg-slate-50 dark:hover:bg-slate-700">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-bold text-slate-700 dark:text-slate-200">Hadir / WFO</span>
                                    <div class="w-4 h-4 rounded-full border border-slate-300 peer-checked:bg-blue-500 peer-checked:border-blue-500"></div>
                                </div>
                                <p class="text-xs text-slate-400">Saya masuk kerja hari ini</p>
                            </div>
                        </label>

                        <!-- Pilihan Izin -->
                        <label class="cursor-pointer">
                            <input type="radio" name="status" value="izin" x-model="status" class="peer sr-only">
                            <div class="p-4 rounded-xl border-2 border-slate-100 dark:border-slate-700 peer-checked:border-amber-500 peer-checked:bg-amber-50 dark:peer-checked:bg-amber-900/20 transition-all hover:bg-slate-50 dark:hover:bg-slate-700">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-bold text-slate-700 dark:text-slate-200">Izin</span>
                                    <div class="w-4 h-4 rounded-full border border-slate-300 peer-checked:bg-amber-500 peer-checked:border-amber-500"></div>
                                </div>
                                <p class="text-xs text-slate-400">Ada keperluan mendesak</p>
                            </div>
                        </label>

                        <!-- Pilihan Sakit -->
                        <label class="cursor-pointer">
                            <input type="radio" name="status" value="sakit" x-model="status" class="peer sr-only">
                            <div class="p-4 rounded-xl border-2 border-slate-100 dark:border-slate-700 peer-checked:border-red-500 peer-checked:bg-red-50 dark:peer-checked:bg-red-900/20 transition-all hover:bg-slate-50 dark:hover:bg-slate-700">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-bold text-slate-700 dark:text-slate-200">Sakit</span>
                                    <div class="w-4 h-4 rounded-full border border-slate-300 peer-checked:bg-red-500 peer-checked:border-red-500"></div>
                                </div>
                                <p class="text-xs text-slate-400">Tidak enak badan</p>
                            </div>
                        </label>
                    </div>

                    <!-- Input Jam (Hanya Muncul Jika Hadir) -->
                    <div x-show="status === 'hadir'" x-transition class="mt-6 grid grid-cols-2 gap-6 p-6 bg-slate-50 dark:bg-slate-900/50 rounded-2xl border border-slate-200 dark:border-slate-700">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Jam Masuk</label>
                            <input type="time" name="check_in" value="{{ date('08:00') }}" class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-800 dark:border-slate-600 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Jam Pulang</label>
                            <input type="time" name="check_out" value="{{ date('17:00') }}" class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-800 dark:border-slate-600 dark:text-white">
                        </div>
                    </div>

                    <!-- Input Keterangan (Hanya Muncul Jika Izin/Sakit) -->
                    <div x-show="status !== 'hadir'" x-transition class="mt-6">
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Keterangan / Alasan</label>
                        <textarea name="notes" rows="3" placeholder="Jelaskan alasan izin atau sakit..." class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-800 dark:border-slate-600 dark:text-white"></textarea>
                    </div>
                </div>

                <!-- 2. AKTIVITAS & LOGBOOK CARD (Dynamic Form) -->
                <div x-show="status === 'hadir'" x-transition>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white flex items-center gap-2">
                            <span class="w-8 h-8 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center">2</span>
                            Aktivitas & Logbook
                        </h3>
                        <button type="button" @click="addActivity()" class="text-sm font-bold text-blue-600 bg-blue-50 px-4 py-2 rounded-xl hover:bg-blue-100 transition flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Aktivitas
                        </button>
                    </div>

                    <div class="space-y-4">
                        <template x-for="(activity, index) in activities" :key="index">
                            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 shadow-sm border border-slate-100 dark:border-slate-700 relative group hover:border-blue-300 transition-colors">
                                <!-- Tombol Hapus -->
                                <button type="button" @click="removeActivity(index)" class="absolute top-4 right-4 text-slate-300 hover:text-red-500 transition" x-show="activities.length > 1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>

                                <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                                    <!-- Kolom Kiri: Jenis & Judul -->
                                    <div class="md:col-span-4 space-y-4">
                                        <div>
                                            <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Jenis Aktivitas</label>
                                            <select :name="`activities[${index}][type]`" class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-800 dark:border-slate-600 dark:text-white">
                                                <option value="learning">Pembelajaran Materi</option>
                                                <option value="execution">Praktek / Jobdesk</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Judul Kegiatan</label>
                                            <input type="text" :name="`activities[${index}][title]`" placeholder="Contoh: Belajar Laravel Eloquent" class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-800 dark:border-slate-600 dark:text-white" required>
                                        </div>
                                    </div>

                                    <!-- Kolom Kanan: Deskripsi -->
                                    <div class="md:col-span-8">
                                        <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Deskripsi & Output</label>
                                        <textarea :name="`activities[${index}][description]`" rows="4" placeholder="Jelaskan detail materi yang dipelajari atau hasil dari pekerjaan yang dilakukan..." class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-800 dark:border-slate-600 dark:text-white"></textarea>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- SUBMIT BUTTON -->
                <div class="mt-8 flex justify-end">
                    <button type="submit" class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold py-4 px-8 rounded-2xl shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:-translate-y-1 transition-all transform flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Simpan Presensi Hari Ini
                    </button>
                </div>

            </form>
        </div>
    </div>

    <!-- Alpine JS Logic -->
    <script>
        function logbookForm() {
            return {
                status: 'hadir',
                activities: [
                    { type: 'learning', title: '', description: '' }
                ],
                addActivity() {
                    this.activities.push({ type: 'learning', title: '', description: '' });
                },
                removeActivity(index) {
                    this.activities.splice(index, 1);
                }
            }
        }
    </script>
</x-app-layout>