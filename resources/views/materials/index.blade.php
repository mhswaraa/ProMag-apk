<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-blue-600 rounded-xl shadow-lg shadow-blue-500/30">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
            <h2 class="font-bold text-xl text-gray-800 dark:text-white leading-tight">
                {{ __('Learning Roadmap') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 dark:bg-gray-900 min-h-screen h-full" 
         x-data="{ 
            activeMaterial: localStorage.getItem('promag_active_material') ? parseInt(localStorage.getItem('promag_active_material')) : {{ $materials->count() > 0 ? $materials->first()->id : 'null' }} 
         }"
         x-init="$watch('activeMaterial', value => localStorage.setItem('promag_active_material', value))">
        
        <!-- STATS SUMMARY CARDS -->
            @php
                $totalTopics = $materials->count();
                $allSteps = $materials->pluck('steps')->flatten();
                $totalSteps = $allSteps->count();
                $completedSteps = $allSteps->where('status', 'completed')->count();
                $globalProgress = $totalSteps > 0 ? round(($completedSteps / $totalSteps) * 100) : 0;

                // Hitung Statistik Kategori
                $countHardSkill = $materials->where('category', 'Hard Skill')->count();
                $countSoftSkill = $materials->where('category', 'Soft Skill')->count();
                $countTools = $materials->where('category', 'Tools')->count();
            @endphp
            
            <!-- Row 1: General Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                <!-- Card 1 -->
                <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700">
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Topik</div>
                    <div class="text-2xl font-black text-slate-800 dark:text-white">{{ $totalTopics }}</div>
                </div>
                <!-- Card 2 -->
                <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700">
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Sub-Poin</div>
                    <div class="text-2xl font-black text-slate-800 dark:text-white">{{ $totalSteps }}</div>
                </div>
                <!-- Card 3 -->
                <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700">
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Selesai</div>
                    <div class="text-2xl font-black text-emerald-500">{{ $completedSteps }}</div>
                </div>
                <!-- Card 4 -->
                <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700">
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Progress Global</div>
                    <div class="text-2xl font-black text-blue-600">{{ $globalProgress }}%</div>
                </div>
            </div>

            <!-- Row 2: Category Stats (Hard Skill, Soft Skill, Tools) -->
            <div class="grid grid-cols-3 gap-4 mb-8">
                <!-- Hard Skill -->
                <div class="bg-blue-50/50 dark:bg-blue-900/10 p-3 rounded-2xl border border-blue-100 dark:border-blue-800/30 text-center">
                    <p class="text-[10px] font-bold text-blue-400 uppercase tracking-wider mb-1">Hard Skill</p>
                    <p class="text-xl font-black text-blue-700 dark:text-blue-300">{{ $countHardSkill }}</p>
                </div>
                <!-- Soft Skill -->
                <div class="bg-purple-50/50 dark:bg-purple-900/10 p-3 rounded-2xl border border-purple-100 dark:border-purple-800/30 text-center">
                    <p class="text-[10px] font-bold text-purple-400 uppercase tracking-wider mb-1">Soft Skill</p>
                    <p class="text-xl font-black text-purple-700 dark:text-purple-300">{{ $countSoftSkill }}</p>
                </div>
                <!-- Tools -->
                <div class="bg-orange-50/50 dark:bg-orange-900/10 p-3 rounded-2xl border border-orange-100 dark:border-orange-800/30 text-center">
                    <p class="text-[10px] font-bold text-orange-400 uppercase tracking-wider mb-1">Tools</p>
                    <p class="text-xl font-black text-orange-700 dark:text-orange-300">{{ $countTools }}</p>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-6 h-[calc(100vh-180px)]">
            
                
                <!-- LEFT COLUMN: LIST MATERI -->
                <div class="w-full lg:w-1/3 flex flex-col h-full bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                    <div class="p-5 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center bg-slate-50/50 dark:bg-slate-900/50">
                        <h3 class="font-black text-slate-800 dark:text-white uppercase tracking-wider text-sm">Daftar Topik</h3>
                        <button onclick="document.getElementById('modalAddMaterial').showModal()" class="text-xs font-bold bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg transition-all flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Baru
                        </button>
                    </div>

                    <div class="flex-1 overflow-y-auto p-3 space-y-2 custom-scrollbar">
                        @forelse($materials as $material)
                            <div @click="activeMaterial = {{ $material->id }}" 
                                 class="cursor-pointer p-4 rounded-xl border transition-all duration-200 relative group"
                                 :class="activeMaterial === {{ $material->id }} 
                                    ? 'bg-blue-50 dark:bg-slate-700 border-blue-500 ring-1 ring-blue-500 shadow-sm' 
                                    : 'bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 hover:border-blue-300 hover:bg-slate-50 dark:hover:bg-slate-700/50'">
                                
                                <div class="flex justify-between items-center">
                                    <div class="flex-1 pr-4">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded text-slate-500 bg-slate-200 dark:bg-slate-900 dark:text-slate-300">
                                                {{ $material->category }}
                                            </span>
                                            @if($material->progress == 100)
                                                <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                            @endif
                                        </div>
                                        <h4 class="font-bold text-slate-800 dark:text-white text-sm leading-snug group-hover:text-blue-600 transition-colors line-clamp-2">
                                            {{ $material->title }}
                                        </h4>
                                    </div>
                                    <div class="radial-progress text-[10px] font-bold" 
                                         style="--value:{{ $material->progress }}; --size:2.2rem; --thickness: 3px;" 
                                         :class="{{ $material->progress }} == 100 ? 'text-emerald-500' : 'text-blue-600'">
                                        {{ $material->progress }}%
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10 px-4">
                                <p class="text-slate-400 text-sm">Belum ada materi.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- RIGHT COLUMN: DETAIL CONTENT -->
                <div class="w-full lg:w-2/3 bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden flex flex-col h-full relative">
                
                    
                    @if($materials->count() > 0)
                        @foreach($materials as $material)
                            <div x-show="activeMaterial === {{ $material->id }}" 
                                 class="flex flex-col h-full absolute inset-0 w-full bg-white dark:bg-slate-800"
                                 style="display: none;"> 
                                
                                <!-- Detail Header -->
                                <div class="p-6 border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/30">
                                    <div class="flex justify-between items-start gap-4">
                                        <div>
                                            <div class="flex items-center gap-3 mb-2">
                                                <h2 class="text-2xl md:text-3xl font-black text-slate-800 dark:text-white">{{ $material->title }}</h2>
                                            </div>
                                            <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed max-w-2xl">{{ $material->description }}</p>
                                        </div>

                                        <!-- DELETE BUTTON (TOPIC) -->
                                        <form action="{{ route('materials.destroy', $material->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus topik ini beserta seluruh isinya?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-all" title="Hapus Topik">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                    
                                    <div class="mt-6 flex items-center gap-4">
                                        <div class="flex-grow bg-slate-200 dark:bg-slate-700 rounded-full h-2">
                                            <div class="h-2 rounded-full transition-all duration-1000 {{ $material->progress == 100 ? 'bg-emerald-500' : 'bg-blue-600' }}" style="width: {{ $material->progress }}%"></div>
                                        </div>
                                        <span class="text-sm font-bold text-slate-600 dark:text-slate-300">{{ $material->progress }}%</span>
                                    </div>
                                </div>

                                <!-- Detail Content -->
                                <div class="flex-1 overflow-y-auto p-6 custom-scrollbar bg-white dark:bg-slate-800">
                                    
                                    <!-- Add Form -->
                                    <div class="relative mb-8 pl-14">
                                        <div class="absolute left-0 top-1 w-14 flex justify-center">
                                            <div class="w-3 h-3 bg-blue-500 rounded-full ring-4 ring-white dark:ring-slate-800"></div>
                                        </div>
                                        <form action="{{ route('materials.step.store') }}" method="POST" class="flex gap-2">
                                            @csrf
                                            <input type="hidden" name="material_id" value="{{ $material->id }}">
                                            <input type="text" name="title" required
                                                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                placeholder="Tambah langkah pembelajaran baru...">
                                            <button type="submit" class="bg-slate-900 dark:bg-white text-white dark:text-slate-900 px-4 py-2.5 rounded-xl text-sm font-bold hover:shadow-lg transition-transform active:scale-95">
                                                Simpan
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Timeline Steps -->
                                    <div class="relative pl-6 border-l-2 border-slate-100 dark:border-slate-700 space-y-8">
                                        @forelse($material->steps as $step)
                                            <div class="relative pl-14 pb-8 group" x-data="{ isCompleted: '{{ $step->status }}' === 'completed', isEditing: false }">
                                                
                                                <!-- Timeline Dot -->
                                                <div class="absolute left-0 top-0 w-14 flex justify-center z-10">
                                                    <div class="w-8 h-8 rounded-full border-2 flex items-center justify-center transition-colors duration-300 bg-white dark:bg-slate-800"
                                                         :class="isCompleted ? 'border-emerald-500 text-emerald-500 shadow-md shadow-emerald-100' : 'border-slate-300 dark:border-slate-600 text-slate-400'">
                                                        <span x-show="!isCompleted" class="text-xs font-bold">{{ $loop->iteration }}</span>
                                                        <svg x-show="isCompleted" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                    </div>
                                                </div>

                                                <!-- Content Box -->
                                                <div class="bg-white dark:bg-slate-800 p-5 rounded-2xl border shadow-sm transition-all duration-300 hover:shadow-md"
                                                     :class="isCompleted ? 'border-emerald-200 dark:border-emerald-900/50 bg-emerald-50/20' : 'border-slate-200 dark:border-slate-700'">
                                                    
                                                    <div class="flex justify-between items-start mb-4">
                                                        <h5 class="text-sm font-bold text-slate-800 dark:text-white" :class="isCompleted ? 'line-through text-slate-400' : ''">
                                                            {{ $step->title }}
                                                        </h5>
                                                        
                                                        <div class="flex items-center gap-2">
                                                            <!-- Reset Button -->
                                                            <form x-show="isCompleted" action="{{ route('materials.step.update', $step->id) }}" method="POST">
                                                                @csrf @method('PUT')
                                                                <input type="hidden" name="status" value="todo">
                                                                <input type="hidden" name="user_notes" value="{{ $step->user_notes }}">
                                                                <input type="hidden" name="obstacles" value="{{ $step->obstacles }}">
                                                                <button class="text-[10px] font-bold text-slate-400 hover:text-blue-500 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 px-2 py-1 rounded shadow-sm" title="Kembalikan status">
                                                                    RESET
                                                                </button>
                                                            </form>

                                                            <!-- DELETE BUTTON (STEP) -->
                                                            <form action="{{ route('materials.step.destroy', $step->id) }}" method="POST" onsubmit="return confirm('Hapus poin ini?');">
                                                                @csrf @method('DELETE')
                                                                <button type="submit" class="text-slate-300 hover:text-red-500 transition-colors p-1" title="Hapus Poin">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>

                                                    <!-- Form Input Catatan -->
                                                    <div x-show="!isCompleted || isEditing">
                                                        <form action="{{ route('materials.step.update', $step->id) }}" method="POST">
                                                            @csrf @method('PUT')
                                                            <input type="hidden" name="status" value="completed">
                                                            
                                                            <!-- Input Hasil Belajar -->
                                                            <div class="mb-4">
                                                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Catatan Hasil Belajar</label>
                                                                <textarea name="user_notes" rows="4" required 
                                                                        class="w-full rounded-lg border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-sm p-3 focus:ring-2 focus:ring-blue-500 text-slate-700 dark:text-slate-300 resize-none mb-1 shadow-inner placeholder:text-slate-300"
                                                                        placeholder="Apa hasil belajarmu? (Contoh:&#10;1. Poin satu&#10;2. Poin dua)">{{ $step->user_notes }}</textarea>
                                                            </div>

                                                            <!-- Input Kendala -->
                                                            <div class="mb-4">
                                                                <label class="block text-[10px] font-bold text-red-400 uppercase tracking-wider mb-2">Kendala di Lapangan (Opsional)</label>
                                                                <textarea name="obstacles" rows="2" 
                                                                        class="w-full rounded-lg border-red-200 dark:border-red-900/30 bg-red-50/50 dark:bg-red-900/10 text-sm p-3 focus:ring-2 focus:ring-red-500 focus:border-red-500 text-slate-700 dark:text-slate-300 resize-none shadow-inner placeholder:text-red-300/50"
                                                                        placeholder="Apakah ada kesulitan atau hambatan saat mempraktekkan ini?">{{ $step->obstacles }}</textarea>
                                                            </div>
                                                            
                                                            <div class="flex justify-end gap-2 pt-2 border-t border-slate-100 dark:border-slate-700">
                                                                <button type="button" x-show="isEditing" @click="isEditing = false" class="text-xs font-bold text-slate-500 px-3 py-2 rounded-lg hover:bg-slate-100">Batal</button>
                                                                <button type="submit" class="bg-blue-600 text-white text-xs font-bold px-4 py-2 rounded-lg hover:bg-blue-700 shadow-md transition">
                                                                    Simpan & Selesai
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>

                                                    <!-- View Catatan & Kendala -->
                                                    <div x-show="isCompleted && !isEditing" class="space-y-3">
                                                        <!-- Hasil Belajar -->
                                                        <div class="bg-emerald-50/50 dark:bg-emerald-900/10 p-4 rounded-xl border border-emerald-100 dark:border-emerald-800/30 relative">
                                                            <span class="absolute top-2 right-2 text-[10px] font-bold text-emerald-400 uppercase tracking-wider bg-white dark:bg-slate-800 px-2 py-0.5 rounded border border-emerald-100">Result</span>
                                                            <div class="text-sm text-slate-700 dark:text-slate-300 whitespace-pre-wrap leading-relaxed">{{ $step->user_notes }}</div>
                                                        </div>

                                                        <!-- Kendala (Jika Ada) -->
                                                        @if($step->obstacles)
                                                            <div class="bg-red-50/50 dark:bg-red-900/10 p-4 rounded-xl border border-red-100 dark:border-red-800/30 flex gap-3 items-start">
                                                                <div class="mt-0.5 p-1 bg-red-100 dark:bg-red-900/50 rounded-md text-red-500 flex-shrink-0">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                                </div>
                                                                <div>
                                                                    <p class="text-xs font-bold text-red-500 uppercase tracking-wider mb-1">Kendala / Masalah</p>
                                                                    <p class="text-sm text-slate-600 dark:text-slate-300 italic">"{{ $step->obstacles }}"</p>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        <div class="flex justify-end pt-2">
                                                            <button @click="isEditing = true" class="text-[10px] font-bold text-blue-600 hover:text-blue-800 hover:underline uppercase tracking-wide flex items-center gap-1">
                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                                Edit Data
                                                            </button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        @empty
                                            <div class="ml-14 py-8 text-center bg-slate-50 dark:bg-slate-900/50 rounded-2xl border border-dashed border-slate-200 dark:border-slate-700">
                                                <p class="text-slate-400 text-sm italic">Belum ada langkah pembelajaran.</p>
                                                <p class="text-xs text-slate-300">Tambahkan pada form di atas.</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <!-- Empty State Global -->
                        <div class="flex flex-col items-center justify-center h-full text-center p-8">
                            <div class="w-20 h-20 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-800 dark:text-white">Siap Belajar?</h3>
                            <p class="text-slate-500 mt-2 max-w-xs mx-auto">Mulai tambahkan topik pertamamu di kolom sebelah kiri.</p>
                        </div>
                    @endif
                </div>
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
                        <input type="text" name="title" class="w-full rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:bg-slate-700 dark:border-slate-600 dark:text-white py-3 px-4 font-semibold text-slate-800 shadow-sm" required placeholder="Contoh: Alur Penerimaan Barang (GR)">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Kategori Skill</label>
                        <div class="grid grid-cols-3 gap-3">
                            <label class="cursor-pointer group">
                                <input type="radio" name="category" value="Hard Skill" class="peer sr-only" checked>
                                <div class="text-center py-3 rounded-xl border border-slate-300 peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 text-slate-500 text-sm font-bold transition-all group-hover:border-blue-300">
                                    Hard Skill
                                </div>
                            </label>
                            <label class="cursor-pointer group">
                                <input type="radio" name="category" value="Soft Skill" class="peer sr-only">
                                <div class="text-center py-3 rounded-xl border border-slate-300 peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 text-slate-500 text-sm font-bold transition-all group-hover:border-blue-300">
                                    Soft Skill
                                </div>
                            </label>
                            <label class="cursor-pointer group">
                                <input type="radio" name="category" value="Tools" class="peer sr-only">
                                <div class="text-center py-3 rounded-xl border border-slate-300 peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-700 text-slate-500 text-sm font-bold transition-all group-hover:border-blue-300">
                                    Tools
                                </div>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Deskripsi Singkat</label>
                        <textarea name="description" rows="4" class="w-full rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:bg-slate-700 dark:border-slate-600 dark:text-white py-3 px-4 shadow-sm" placeholder="Jelaskan tujuan dari mempelajari materi ini..."></textarea>
                    </div>
                </div>
                <div class="mt-8 flex justify-end gap-3 pt-6 border-t border-slate-100 dark:border-slate-700">
                    <button type="button" onclick="document.getElementById('modalAddMaterial').close()" class="px-6 py-3 rounded-xl text-slate-500 hover:bg-slate-50 font-bold text-sm transition">Batal</button>
                    <button type="submit" class="px-8 py-3 rounded-xl bg-blue-600 text-white font-bold text-sm hover:bg-blue-700 shadow-lg shadow-blue-200 hover:shadow-xl transition-all transform active:scale-95">Simpan Topik</button>
                </div>
            </form>
        </div>
    </dialog>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #475569; }
        
        .radial-progress {
            position: relative; display: inline-grid; width: var(--size); height: var(--size);
            place-content: center; border-radius: 9999px; background-color: transparent;
            vertical-align: middle; box-sizing: content-box;
        }
        .radial-progress:before, .radial-progress:after {
            content: ""; position: absolute; border-radius: 9999px;
        }
        .radial-progress:before {
            top: 0; right: 0; bottom: 0; left: 0;
            background: radial-gradient(farthest-side, currentColor 98%, #0000) top/var(--thickness) var(--thickness) no-repeat,
            conic-gradient(currentColor calc(var(--value) * 1%), #0000 0);
            -webkit-mask: radial-gradient(farthest-side, #0000 calc(99% - var(--thickness)), #000 calc(100% - var(--thickness)));
            mask: radial-gradient(farthest-side, #0000 calc(99% - var(--thickness)), #000 calc(100% - var(--thickness)));
        }
        .radial-progress:after {
            inset: calc(50% - var(--thickness) / 2);
            transform: rotate(calc(var(--value) * 3.6deg - 90deg)) translate(calc(var(--size) / 2 - 50%));
        }
    </style>

</x-app-layout>