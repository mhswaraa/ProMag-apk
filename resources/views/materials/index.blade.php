<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-indigo-600 rounded-xl shadow-lg shadow-indigo-500/30">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
            <h2 class="font-bold text-xl text-gray-800 dark:text-white leading-tight">
                {{ __('Materi & Roadmap Belajar') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen" x-data="{ activeMaterial: null }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- TOP HEADER SECTION -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
                <div>
                    <h3 class="text-3xl font-extrabold text-slate-800 dark:text-white tracking-tight">Roadmap Magang</h3>
                    <p class="text-slate-500 mt-2 text-base max-w-2xl">
                        Pantau progres pembelajaran hard-skill dan soft-skill Anda secara terstruktur.
                    </p>
                </div>
                <button onclick="document.getElementById('modalAddMaterial').showModal()" 
                        class="inline-flex items-center justify-center px-6 py-3 text-sm font-bold text-white transition-all duration-200 bg-indigo-600 rounded-xl hover:bg-indigo-700 hover:shadow-lg hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Materi Baru
                </button>
            </div>

            <!-- MAIN CONTENT: CARD LIST -->
            <div class="grid grid-cols-1 gap-6">
                
                @forelse($materials as $material)
                    <!-- Single Material Card -->
                    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden transition-all duration-300 hover:shadow-md"
                         :class="activeMaterial === {{ $material->id }} ? 'ring-2 ring-indigo-500' : ''">
                        
                        <!-- CARD HEADER (Always Visible) -->
                        <div @click="activeMaterial = activeMaterial === {{ $material->id }} ? null : {{ $material->id }}" 
                             class="cursor-pointer relative p-6 sm:p-8 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                            
                            <div class="flex flex-col sm:flex-row gap-6 items-start sm:items-center">
                                
                                <!-- Icon Category (Left) -->
                                <div class="flex-shrink-0">
                                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-2xl font-bold shadow-sm
                                        {{ $material->category == 'Hard Skill' ? 'bg-blue-50 text-blue-600 dark:bg-blue-900/20' : 
                                          ($material->category == 'Soft Skill' ? 'bg-purple-50 text-purple-600 dark:bg-purple-900/20' : 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20') }}">
                                        {{ substr($material->category, 0, 1) }}
                                    </div>
                                </div>

                                <!-- Main Info (Middle) -->
                                <div class="flex-grow space-y-2 w-full">
                                    <div class="flex flex-wrap items-center justify-between gap-2">
                                        <div class="flex items-center gap-3">
                                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border
                                                {{ $material->category == 'Hard Skill' ? 'bg-blue-50 text-blue-600 border-blue-100' : 
                                                  ($material->category == 'Soft Skill' ? 'bg-purple-50 text-purple-600 border-purple-100' : 'bg-emerald-50 text-emerald-600 border-emerald-100') }}">
                                                {{ $material->category }}
                                            </span>
                                            <span class="text-xs text-slate-400 font-medium">{{ $material->steps->count() }} Langkah Pembelajaran</span>
                                        </div>
                                        
                                        <!-- Progress Percentage Text -->
                                        <div class="text-right">
                                            <span class="text-2xl font-black {{ $material->progress == 100 ? 'text-emerald-500' : 'text-slate-800 dark:text-white' }}">{{ $material->progress }}%</span>
                                        </div>
                                    </div>

                                    <h4 class="text-xl font-bold text-slate-800 dark:text-white leading-tight">{{ $material->title }}</h4>
                                    <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-1">{{ $material->description }}</p>
                                    
                                    <!-- Progress Bar -->
                                    <div class="w-full bg-slate-100 dark:bg-slate-700 rounded-full h-2 mt-3 overflow-hidden">
                                        <div class="h-full rounded-full transition-all duration-1000 ease-out {{ $material->progress == 100 ? 'bg-emerald-500' : 'bg-indigo-600' }}" 
                                             style="width: {{ $material->progress }}%"></div>
                                    </div>
                                </div>

                                <!-- Chevron (Right) -->
                                <div class="hidden sm:flex flex-shrink-0 items-center justify-center w-10 h-10 rounded-full bg-white border border-slate-200 shadow-sm text-slate-400">
                                    <svg class="w-5 h-5 transform transition-transform duration-300" 
                                         :class="activeMaterial === {{ $material->id }} ? 'rotate-180 text-indigo-600' : ''"
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <!-- EXPANDED DETAIL (Timeline) -->
                        <div x-show="activeMaterial === {{ $material->id }}" x-collapse class="border-t border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/30">
                            <div class="p-6 sm:p-8">
                                
                                <!-- Description Full -->
                                <div class="mb-8 p-4 bg-blue-50/50 dark:bg-blue-900/10 rounded-2xl border border-blue-100 dark:border-blue-800/30">
                                    <h5 class="text-xs font-bold text-blue-500 uppercase mb-1">Deskripsi & Tujuan</h5>
                                    <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">{{ $material->description }}</p>
                                </div>

                                <!-- Add Sub-Point Input -->
                                <div class="mb-10 relative">
                                    <div class="absolute left-6 top-10 bottom-0 w-px bg-slate-300 dark:bg-slate-600 border-l border-dashed border-slate-300"></div>
                                    
                                    <form action="{{ route('materials.step.store') }}" method="POST" class="flex gap-4 items-start relative z-10">
                                        @csrf
                                        <input type="hidden" name="material_id" value="{{ $material->id }}">
                                        
                                        <div class="flex-shrink-0 w-12 h-12 bg-white dark:bg-slate-800 rounded-full border-2 border-indigo-100 flex items-center justify-center text-indigo-500 shadow-sm">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        </div>
                                        
                                        <div class="flex-grow">
                                            <div class="flex gap-2">
                                                <input type="text" name="title" 
                                                    class="w-full px-5 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-800 dark:text-white placeholder:text-slate-400 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all shadow-sm"
                                                    placeholder="Tulis langkah pembelajaran baru..." required>
                                                <button type="submit" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-sm shadow-md transition-transform hover:-translate-y-0.5">
                                                    Simpan
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <!-- Timeline Items -->
                                <div class="space-y-8 relative">
                                    <!-- Vertical Line -->
                                    <div class="absolute left-6 top-0 bottom-8 w-0.5 bg-slate-200 dark:bg-slate-700"></div>

                                    @forelse($material->steps as $step)
                                        <div class="relative pl-16 group" x-data="{ isCompleted: '{{ $step->status }}' === 'completed', isEditing: false }">
                                            
                                            <!-- Timeline Dot -->
                                            <div class="absolute left-3 top-0 -translate-x-1/2 w-6 h-6 rounded-full border-4 border-white dark:border-slate-800 shadow-sm z-10 transition-colors duration-300"
                                                 :class="isCompleted ? 'bg-emerald-500' : 'bg-slate-300'"></div>

                                            <!-- Content Box -->
                                            <div class="bg-white dark:bg-slate-800 p-5 rounded-2xl border shadow-sm transition-all duration-300 hover:shadow-md"
                                                 :class="isCompleted ? 'border-emerald-200 dark:border-emerald-900/50' : 'border-slate-200 dark:border-slate-700'">
                                                
                                                <div class="flex justify-between items-start mb-4">
                                                    <h5 class="text-base font-bold text-slate-800 dark:text-white" 
                                                        :class="{'line-through text-slate-400': isCompleted}">
                                                        {{ $step->title }}
                                                    </h5>
                                                    
                                                    <!-- Reset Action -->
                                                    <form x-show="isCompleted" action="{{ route('materials.step.update', $step->id) }}" method="POST">
                                                        @csrf @method('PUT')
                                                        <input type="hidden" name="status" value="todo">
                                                        <input type="hidden" name="user_notes" value="{{ $step->user_notes }}">
                                                        <button type="submit" class="text-[10px] uppercase font-bold text-slate-400 hover:text-red-500 tracking-wider flex items-center gap-1 transition-colors bg-slate-50 px-2 py-1 rounded">
                                                            Reset Status
                                                        </button>
                                                    </form>
                                                </div>

                                                <!-- 1. FORM CATATAN (Belum Selesai / Edit) -->
                                                <div x-show="!isCompleted || isEditing">
                                                    <form action="{{ route('materials.step.update', $step->id) }}" method="POST">
                                                        @csrf @method('PUT')
                                                        <input type="hidden" name="status" value="completed">
                                                        
                                                        <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Catatan Hasil Belajar</label>
                                                        <textarea name="user_notes" rows="3" required
                                                                  class="w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-white p-3 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all mb-3"
                                                                  placeholder="Apa poin penting yang Anda pelajari?">{{ $step->user_notes }}</textarea>
                                                        
                                                        <div class="flex justify-end gap-2">
                                                            <button type="button" x-show="isEditing" @click="isEditing = false" class="px-3 py-2 text-xs font-bold text-slate-500 hover:bg-slate-100 rounded-lg">Batal</button>
                                                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-xs font-bold shadow-md transition flex items-center gap-2">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                                Tandai Selesai
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>

                                                <!-- 2. HASIL CATATAN (Sudah Selesai) -->
                                                <div x-show="isCompleted && !isEditing">
                                                    <div class="bg-emerald-50 dark:bg-emerald-900/10 rounded-xl p-4 border border-emerald-100 dark:border-emerald-800/30 flex gap-3 items-start">
                                                        <svg class="w-5 h-5 text-emerald-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                        <div class="flex-grow">
                                                            <p class="text-sm text-slate-700 dark:text-slate-300 leading-relaxed">"{{ $step->user_notes }}"</p>
                                                            <button @click="isEditing = true" class="mt-2 text-[10px] font-bold text-indigo-600 hover:underline">Edit Catatan</button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-4 ml-10">
                                            <p class="text-slate-400 text-sm italic">Belum ada langkah pembelajaran.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Empty State -->
                    <div class="text-center py-20 bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700">
                        <div class="w-20 h-20 bg-indigo-50 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white">Materi Masih Kosong</h3>
                        <p class="text-slate-500 mb-6">Mulai tambahkan topik pertama untuk roadmap belajarmu.</p>
                        <button onclick="document.getElementById('modalAddMaterial').showModal()" class="px-6 py-2 bg-indigo-600 text-white rounded-xl font-bold shadow hover:bg-indigo-700 transition">
                            Buat Topik Pertama
                        </button>
                    </div>
                @endforelse
            </div>

        </div>
    </div>

    <!-- MODAL ADD MATERIAL -->
    <dialog id="modalAddMaterial" class="modal rounded-3xl shadow-2xl p-0 w-full max-w-lg backdrop:bg-slate-900/60 backdrop-blur-sm">
        <div class="bg-white dark:bg-slate-800 p-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-2xl text-slate-800 dark:text-white">Tambah Topik Materi</h3>
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost text-slate-400 hover:text-slate-600 bg-slate-100 hover:bg-slate-200 border-none">✕</button>
                </form>
            </div>
            
            <form action="{{ route('materials.store') }}" method="POST">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Judul Materi / SOP</label>
                        <input type="text" name="title" class="w-full rounded-xl border border-slate-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 dark:bg-slate-700 dark:border-slate-600 dark:text-white py-3 px-4 font-semibold text-slate-800 shadow-sm" required placeholder="Contoh: Alur Penerimaan Barang (GR)">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Kategori Skill</label>
                        <div class="grid grid-cols-3 gap-3">
                            <label class="cursor-pointer group">
                                <input type="radio" name="category" value="Hard Skill" class="peer sr-only" checked>
                                <div class="text-center py-3 rounded-xl border border-slate-300 peer-checked:border-indigo-500 peer-checked:bg-indigo-50 peer-checked:text-indigo-700 text-slate-500 text-sm font-bold transition-all group-hover:border-indigo-300">
                                    Hard Skill
                                </div>
                            </label>
                            <label class="cursor-pointer group">
                                <input type="radio" name="category" value="Soft Skill" class="peer sr-only">
                                <div class="text-center py-3 rounded-xl border border-slate-300 peer-checked:border-indigo-500 peer-checked:bg-indigo-50 peer-checked:text-indigo-700 text-slate-500 text-sm font-bold transition-all group-hover:border-indigo-300">
                                    Soft Skill
                                </div>
                            </label>
                            <label class="cursor-pointer group">
                                <input type="radio" name="category" value="Tools" class="peer sr-only">
                                <div class="text-center py-3 rounded-xl border border-slate-300 peer-checked:border-indigo-500 peer-checked:bg-indigo-50 peer-checked:text-indigo-700 text-slate-500 text-sm font-bold transition-all group-hover:border-indigo-300">
                                    Tools
                                </div>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Deskripsi Singkat</label>
                        <textarea name="description" rows="4" class="w-full rounded-xl border border-slate-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 dark:bg-slate-700 dark:border-slate-600 dark:text-white py-3 px-4 shadow-sm" placeholder="Jelaskan tujuan dari mempelajari materi ini..."></textarea>
                    </div>
                </div>
                <div class="mt-8 flex justify-end gap-3 pt-6 border-t border-slate-100 dark:border-slate-700">
                    <button type="button" onclick="document.getElementById('modalAddMaterial').close()" class="px-6 py-3 rounded-xl text-slate-500 hover:bg-slate-50 font-bold text-sm transition">Batal</button>
                    <button type="submit" class="px-8 py-3 rounded-xl bg-indigo-600 text-white font-bold text-sm hover:bg-indigo-700 shadow-lg shadow-indigo-200 hover:shadow-xl transition-all transform active:scale-95">Simpan Topik</button>
                </div>
            </form>
        </div>
    </dialog>

</x-app-layout>