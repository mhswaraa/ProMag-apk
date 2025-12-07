<aside class="w-64 bg-white dark:bg-gray-800 border-r border-gray-100 dark:border-gray-700 hidden md:block flex-shrink-0">
    <div class="h-full flex flex-col justify-between">
        <!-- Top Section -->
        <div class="px-3 py-4 overflow-y-auto">
            <div class="flex items-center mb-8 pl-3 mt-2">
                <!-- LOGO IMAGE (Menggantikan Icon SVG) -->
                <!-- Pastikan file ada di public/images/logo.png -->
                <img src="{{ asset('images/images.png') }}" 
                     alt="Logo Perusahaan" 
                     class="w-12 h-12 mr-3 object-contain bg-white rounded-lg p-1 shadow-md">
                
                <div>
                    <span class="block text-xl font-bold whitespace-nowrap dark:text-white text-gray-800 tracking-tight">
                        INTERNSHIP APP
                    </span>
                    <span class="block text-[10px] font-medium text-gray-400 uppercase tracking-wider leading-tight">
                        PT. Pan Brothers Tbk
                    </span>
                </div>
            </div>

            <!-- Menu List -->
            <ul class="space-y-1 font-medium">
                
                <!-- Dashboard -->
                <li>
                    <a href="{{ route('dashboard') }}" 
                       class="flex items-center p-3 rounded-lg group transition-all duration-200 
                       {{ request()->routeIs('dashboard') 
                          ? 'bg-blue-50 text-blue-600 dark:bg-gray-700 dark:text-blue-400 border-r-4 border-blue-600 font-bold shadow-sm' 
                          : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-blue-600' }}">
                        
                        <svg class="w-5 h-5 transition duration-75 {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-gray-400 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        <span class="ml-3">Dashboard</span>
                    </a>
                </li>

                <!-- Presensi & Logbook (UPDATED) -->
                <li>
                    <a href="{{ route('attendances.index') }}" 
                       class="flex items-center p-3 rounded-lg group transition-all duration-200 
                       {{ request()->routeIs('attendances.*') 
                          ? 'bg-blue-50 text-blue-600 dark:bg-gray-700 dark:text-blue-400 border-r-4 border-blue-600 font-bold shadow-sm' 
                          : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-blue-600' }}">
                        
                        <svg class="w-5 h-5 transition duration-75 {{ request()->routeIs('attendances.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="ml-3">Presensi & Logbook</span>
                    </a>
                </li>

                <!-- Materi -->
                <li>
                    <a href="{{ route('materials.index') }}" 
                    class="flex items-center p-3 rounded-lg group transition-all duration-200 
                       {{ request()->routeIs('materials.*') 
                          ? 'bg-blue-50 text-blue-600 dark:bg-gray-700 dark:text-blue-400 border-r-4 border-blue-600 font-bold shadow-sm' 
                          : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-blue-600' }}">
                        
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <span class="ml-3">Materi & Progress</span>
                    </a>
                </li>

                <!-- Skill -->
                <li>
                    <a href="#" class="flex items-center p-3 rounded-lg group transition-all duration-200 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-blue-600">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        <span class="ml-3">Skill Upgrade</span>
                    </a>
                </li>

                <!-- KPI -->
                <li>
                    <a href="#" class="flex items-center p-3 rounded-lg group transition-all duration-200 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-blue-600">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        <span class="ml-3">Target KPI</span>
                    </a>
                </li>
            </ul>
        </div>
        
        <!-- User Info Bottom -->
        <div class="p-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold shadow-md">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">Mahasiswa Magang</p>
                </div>
            </div>
        </div>
    </div>
</aside>