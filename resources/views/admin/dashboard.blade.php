<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Dashboard - SiPinjam Ruang</title>

    @vite(['resources/css/app.css', 'resources/css/admin.css', 'resources/js/app.js'])
</head>
<body class="admin-body antialiased">

    <aside class="fixed left-0 top-0 h-full z-40 flex flex-col bg-slate-100 w-64 border-r-0 shadow-sm">
        <div class="px-6 py-8 flex flex-col h-full">
            
            <div class="mb-10 flex items-center gap-3">
                <div class="w-10 h-10 bg-primary-gradient rounded flex items-center justify-center text-white shadow-md">
                    <span class="material-symbols-outlined">account_balance</span>
                </div>
                <div>
                    <h1 class="text-xl font-black text-blue-900 font-headline leading-tight">SiPinjam Ruang</h1>
                    <p class="text-xs text-slate-500 font-medium">System Management</p>
                </div>
            </div>

            <nav class="flex-1 space-y-1">
                <a class="flex items-center gap-3 px-4 py-3 font-bold rounded-lg mx-2 transition-transform scale-100 bg-white text-[#002045] shadow-sm" href="#">
                    <span class="material-symbols-outlined">analytics</span>
                    <span class="font-headline text-sm font-medium">Dashboard</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-[#002045] transition-transform hover:scale-105 group" href="/admin/ruangan">
                    <span class="material-symbols-outlined">meeting_room</span>
                    <span class="font-headline text-sm font-medium">Manajemen Ruangan</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-[#002045] transition-transform hover:scale-105 group" href="/admin/permohonan">
                    <span class="material-symbols-outlined">inbox</span>
                    <span class="font-headline text-sm font-medium">Permohonan Masuk</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-[#002045] transition-transform hover:scale-105 group" href="/admin/laporan">
                    <span class="material-symbols-outlined">assessment</span>
                    <span class="font-headline text-sm font-medium">Laporan</span>
                </a>
            </nav>

            <div class="mt-auto pt-6 border-t border-slate-200/50">
                <div class="flex items-center gap-3 px-2">
                    <img alt="Admin Avatar" class="w-10 h-10 rounded-full object-cover" src="https://ui-avatars.com/api/?name=Administrator&background=002045&color=fff"/>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-[#002045] truncate">Administrator</p>
                        <p class="text-xs text-slate-500 truncate">admin@masoem.ac.id</p>
                    </div>
                    <a class="text-slate-400 hover:text-red-600 transition-colors" href="/login">
                        <span class="material-symbols-outlined">logout</span>
                    </a>
                </div>
            </div>
        </div>
    </aside>

    <main class="ml-64 min-h-screen bg-[#f7fafc]">
        
        <header class="flex justify-between items-center w-full px-8 py-4 sticky top-0 z-50 bg-white shadow-sm">
            <div class="flex items-center gap-4 flex-1">
                <div class="relative w-full max-w-md">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
                    <input class="w-full pl-10 pr-4 py-2 bg-[#e5e9eb] border-none rounded-lg text-sm focus:ring-2 focus:ring-[#002045] focus:bg-white outline-none transition-all" placeholder="Cari jadwal atau ruangan..." type="text"/>
                </div>
            </div>
            
            <div class="flex items-center gap-6">
                <button class="relative text-slate-600 hover:text-[#002045] transition-colors">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="absolute top-0 right-0 w-2 h-2 bg-red-600 rounded-full ring-2 ring-white"></span>
                </button>
                <button class="text-slate-600 hover:text-[#002045] transition-colors">
                    <span class="material-symbols-outlined">help</span>
                </button>
                <div class="h-8 w-[1px] bg-slate-200 mx-2"></div>
                <div class="flex items-center gap-3">
                    <p class="text-sm font-semibold text-[#002045] font-headline">Administrator</p>
                    <img alt="User Avatar" class="w-8 h-8 rounded-full border border-slate-200" src="https://ui-avatars.com/api/?name=Administrator&background=002045&color=fff"/>
                </div>
            </div>
        </header>

        <div class="p-8 max-w-[1600px] mx-auto space-y-6">
            
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-xl shadow-sm border border-slate-100">
                <div class="flex items-center gap-6">
                    <h2 class="text-2xl font-extrabold text-[#002045] font-headline tracking-tight">Oktober 2026</h2>
                    <div class="flex items-center bg-slate-100 rounded-lg p-1">
                        <button class="p-2 hover:bg-white rounded-md transition-all text-slate-600">
                            <span class="material-symbols-outlined text-xl">chevron_left</span>
                        </button>
                        <button class="px-4 py-2 hover:bg-white rounded-md transition-all text-sm font-bold text-slate-700 shadow-sm">Hari Ini</button>
                        <button class="p-2 hover:bg-white rounded-md transition-all text-slate-600">
                            <span class="material-symbols-outlined text-xl">chevron_right</span>
                        </button>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="flex bg-slate-100 p-1 rounded-lg">
                        <button class="px-4 py-2 bg-white text-[#002045] font-bold rounded-md shadow-sm text-sm">Minggu</button>
                        <button class="px-4 py-2 text-slate-500 hover:text-slate-700 font-medium rounded-md text-sm transition-colors">Bulan</button>
                    </div>
                    <button class="px-4 py-2 bg-primary-gradient text-white text-sm font-semibold rounded-lg shadow-md hover:opacity-90 transition-opacity flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">add</span> Booking Baru
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-slate-200">
                
                <div class="calendar-grid bg-slate-50 border-b border-slate-200">
                    <div class="p-4 border-r border-slate-200"></div>
                    <div class="p-4 border-r border-slate-200 text-center">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Sen</p>
                        <p class="text-xl font-extrabold text-[#002045] font-headline">23</p>
                    </div>
                    <div class="p-4 border-r border-slate-200 text-center bg-blue-50">
                        <p class="text-[10px] font-bold text-blue-600 uppercase tracking-widest">Sel</p>
                        <p class="text-xl font-extrabold text-[#002045] font-headline">24</p>
                    </div>
                    <div class="p-4 border-r border-slate-200 text-center">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Rab</p>
                        <p class="text-xl font-extrabold text-[#002045] font-headline">25</p>
                    </div>
                    <div class="p-4 border-r border-slate-200 text-center">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Kam</p>
                        <p class="text-xl font-extrabold text-[#002045] font-headline">26</p>
                    </div>
                    <div class="p-4 border-r border-slate-200 text-center">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Jum</p>
                        <p class="text-xl font-extrabold text-[#002045] font-headline">27</p>
                    </div>
                    <div class="p-4 border-r border-slate-200 text-center text-slate-400">
                        <p class="text-[10px] font-bold uppercase tracking-widest">Sab</p>
                        <p class="text-xl font-extrabold font-headline">28</p>
                    </div>
                    <div class="p-4 text-center text-slate-400">
                        <p class="text-[10px] font-bold uppercase tracking-widest">Min</p>
                        <p class="text-xl font-extrabold font-headline">29</p>
                    </div>
                </div>

                <div class="calendar-grid overflow-y-auto max-h-[600px]">
                    
                    <div class="bg-slate-50">
                        @for ($i = 7; $i <= 21; $i++)
                            <div class="time-cell flex items-center justify-center text-[11px] font-bold text-slate-400">
                                {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00
                            </div>
                        @endfor
                    </div>

                    <div class="relative bg-white border-r border-slate-100">
                        @for ($i = 7; $i <= 21; $i++) <div class="time-cell"></div> @endfor
                    </div>

                    <div class="relative bg-blue-50/30 border-r border-slate-100">
                        <div class="booking-block bg-[#002045] text-white shadow-md" style="top: 200px; height: 300px;">
                            <p class="font-bold mb-1">Lab. Komputer 03</p>
                            <p class="text-[10px] opacity-90">Praktikum Algoritma Lanjut</p>
                            <div class="mt-2 flex items-center gap-1 opacity-80 text-[9px]">
                                <span class="material-symbols-outlined text-[12px]">schedule</span>
                                09:00 - 12:00
                            </div>
                        </div>
                        <div class="booking-block bg-emerald-100 text-emerald-800 border border-emerald-200" style="top: 700px; height: 200px;">
                            <p class="font-bold text-[10px] uppercase tracking-wide">Tersedia</p>
                            <p class="text-[10px]">Aula Utama</p>
                        </div>
                        @for ($i = 7; $i <= 21; $i++) <div class="time-cell"></div> @endfor
                    </div>

                    <div class="relative bg-white border-r border-slate-100">
                        <div class="booking-block bg-[#002045] text-white shadow-md" style="top: 600px; height: 250px;">
                            <p class="font-bold mb-1">Ruang Teater A</p>
                            <p class="text-[10px] opacity-90">Seminar Nasional Robotika</p>
                        </div>
                        @for ($i = 7; $i <= 21; $i++) <div class="time-cell"></div> @endfor
                    </div>

                    <div class="relative bg-white border-r border-slate-100">
                        <div class="booking-block bg-[#002045] text-white shadow-md" style="top: 300px; height: 150px;">
                            <p class="font-bold mb-1">R. Rapat Senat</p>
                            <p class="text-[10px] opacity-90">Rapat Koordinasi Prodi</p>
                        </div>
                        @for ($i = 7; $i <= 21; $i++) <div class="time-cell"></div> @endfor
                    </div>

                    <div class="relative bg-white border-r border-slate-100">
                        <div class="booking-block bg-emerald-100 text-emerald-800 border border-emerald-200" style="top: 100px; height: 200px;">
                            <p class="font-bold text-[10px] uppercase tracking-wide">Tersedia</p>
                            <p class="text-[10px]">Lab Komputer - R.301</p>
                        </div>
                        @for ($i = 7; $i <= 21; $i++) <div class="time-cell"></div> @endfor
                    </div>

                    <div class="relative bg-white border-r border-slate-100">
                        <div class="booking-block bg-[#002045] text-white shadow-md" style="top: 100px; height: 900px;">
                            <p class="font-bold mb-1">Aula Utama</p>
                            <p class="text-[10px] opacity-90">Wisuda Gelombang II</p>
                        </div>
                        @for ($i = 7; $i <= 21; $i++) <div class="time-cell"></div> @endfor
                    </div>

                    <div class="relative bg-white">
                        @for ($i = 7; $i <= 21; $i++) <div class="time-cell"></div> @endfor
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-6 pt-4 px-2">
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 rounded bg-[#002045]"></div>
                    <span class="text-xs font-semibold text-slate-600">Terisi (Booked)</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 rounded bg-emerald-100 border border-emerald-200"></div>
                    <span class="text-xs font-semibold text-slate-600">Tersedia (Available)</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 rounded bg-blue-50 border border-blue-200"></div>
                    <span class="text-xs font-semibold text-slate-600">Hari Terpilih</span>
                </div>
            </div>
            
        </div>
    </main>

</body>
</html>