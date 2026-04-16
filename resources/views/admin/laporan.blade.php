<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Laporan & Analitik - SiPinjam Ruang</title>

    @vite(['resources/css/app.css', 'resources/css/admin.css', 'resources/js/app.js'])
</head>
<body class="admin-body antialiased bg-[#f7fafc]">

    <aside class="fixed left-0 top-0 h-full z-40 flex flex-col bg-slate-100 w-64 border-r-0 shadow-sm">
        <div class="px-6 py-8 flex flex-col h-full">
            
            <div class="mb-10 flex items-center gap-3">
                <div class="w-10 h-10 bg-primary-gradient rounded flex items-center justify-center text-white shadow-md">
                    <span class="material-symbols-outlined">account_balance</span>
                </div>
                <div>
                    <h1 class="text-xl font-black text-[#002045] font-headline leading-tight">SiPinjam Ruang</h1>
                    <p class="text-xs text-slate-500 font-medium">System Management</p>
                </div>
            </div>

            <nav class="flex-1 space-y-1">
                <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-[#002045] transition-transform hover:scale-105 group" href="/admin/dashboard">
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
                <a class="flex items-center gap-3 px-4 py-3 font-bold rounded-lg mx-2 transition-transform scale-100 bg-white text-[#002045] shadow-sm" href="#">
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
                </div>
            </div>
        </div>
    </aside>

    <main class="ml-64 min-h-screen">
        
        <header class="flex justify-between items-center w-full px-8 py-4 sticky top-0 z-30 bg-white/80 backdrop-blur-md shadow-sm border-b border-slate-100">
            <div class="flex items-center gap-4 flex-1">
                <h2 class="text-xl font-extrabold text-[#002045] font-headline mr-4 hidden md:block">Laporan Sistem</h2>
                <div class="relative w-full max-w-md">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
                    <input class="w-full bg-slate-100 border-none rounded-lg pl-10 pr-4 py-2 text-sm focus:bg-white focus:ring-2 focus:ring-[#002045] transition-all outline-none" placeholder="Cari laporan..." type="text"/>
                </div>
            </div>
            
            <div class="flex items-center gap-6">
                <button class="relative text-slate-600 hover:text-[#002045] transition-colors">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="absolute top-0 right-0 w-2 h-2 bg-red-600 rounded-full"></span>
                    </button>
                <!-- <div class="h-8 w-[1px] bg-slate-200 mx-2"></div>
                <button class="bg-primary-gradient text-white px-5 py-2 rounded-lg text-sm font-bold font-headline shadow-md hover:opacity-90 transition-opacity flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">download</span> Ekspor Laporan
                </button> -->
            </div>
        </header>

        <div class="p-8 max-w-[1600px] mx-auto">
            
            <section class="mb-10">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                    <div>
                        <h3 class="text-3xl font-extrabold font-headline text-[#002045] tracking-tight">Analitik Peminjaman</h3>
                        <p class="text-slate-500 mt-2 text-sm">Pantau penggunaan ruangan dan status permohonan secara real-time.</p>
                    </div>
                    <div class="flex flex-wrap items-center gap-3">
                        <div class="bg-white p-1 rounded-xl shadow-sm flex items-center border border-slate-200">
                            <div class="px-4 py-1">
                                <span class="text-[10px] font-bold text-slate-400 block uppercase tracking-wider">Mulai</span>
                                <input class="border-none p-0 text-sm font-bold text-[#002045] focus:ring-0 bg-transparent outline-none" type="date" value="2026-10-01"/>
                            </div>
                            <div class="w-[1px] h-8 bg-slate-200"></div>
                            <div class="px-4 py-1">
                                <span class="text-[10px] font-bold text-slate-400 block uppercase tracking-wider">Selesai</span>
                                <input class="border-none p-0 text-sm font-bold text-[#002045] focus:ring-0 bg-transparent outline-none" type="date" value="2026-10-31"/>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button class="bg-white border border-slate-200 text-slate-600 px-4 py-2.5 rounded-lg text-sm font-bold flex items-center gap-2 hover:bg-slate-50 transition-colors shadow-sm">
                                <span class="material-symbols-outlined text-sm text-red-500">picture_as_pdf</span> PDF
                            </button>
                            <button class="bg-white border border-slate-200 text-slate-600 px-4 py-2.5 rounded-lg text-sm font-bold flex items-center gap-2 hover:bg-slate-50 transition-colors shadow-sm">
                                <span class="material-symbols-outlined text-sm text-green-600">table_view</span> Excel
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <section class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-10">
                
                <div class="lg:col-span-8 bg-white p-8 rounded-xl shadow-sm border border-slate-200">
                    <div class="flex justify-between items-center mb-8">
                        <h4 class="font-headline text-lg font-bold text-[#002045]">Volume Peminjaman per Tipe Ruangan</h4>
                        <span class="material-symbols-outlined text-slate-400 cursor-pointer">more_horiz</span>
                    </div>
                    <div class="h-64 flex items-end justify-between gap-4">
                        <div class="flex-1 flex flex-col items-center gap-3">
                            <div class="w-full bg-[#002045]/10 rounded-t-lg relative group h-[40%] transition-all hover:bg-[#002045]/20">
                                <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-[#002045] text-white text-[10px] px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">42</div>
                            </div>
                            <span class="text-[10px] font-bold text-slate-500 uppercase text-center">Lab Komputer</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-3">
                            <div class="w-full bg-[#002045]/10 rounded-t-lg relative group h-[75%] transition-all hover:bg-[#002045]/20">
                                <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-[#002045] text-white text-[10px] px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">86</div>
                            </div>
                            <span class="text-[10px] font-bold text-slate-500 uppercase text-center">Auditorium</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-3">
                            <div class="w-full bg-[#002045] rounded-t-lg relative group h-[100%] transition-all hover:opacity-90 shadow-md">
                                <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-[#002045] text-white text-[10px] px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">124</div>
                            </div>
                            <span class="text-[10px] font-extrabold text-[#002045] uppercase text-center">R. Seminar</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-3">
                            <div class="w-full bg-[#002045]/10 rounded-t-lg relative group h-[55%] transition-all hover:bg-[#002045]/20">
                                <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-[#002045] text-white text-[10px] px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">64</div>
                            </div>
                            <span class="text-[10px] font-bold text-slate-500 uppercase text-center">R. Kelas Reguler</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-3">
                            <div class="w-full bg-[#002045]/10 rounded-t-lg relative group h-[30%] transition-all hover:bg-[#002045]/20">
                                <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-[#002045] text-white text-[10px] px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">28</div>
                            </div>
                            <span class="text-[10px] font-bold text-slate-500 uppercase text-center">R. Rapat</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-3">
                            <div class="w-full bg-[#002045]/10 rounded-t-lg relative group h-[65%] transition-all hover:bg-[#002045]/20">
                                <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-[#002045] text-white text-[10px] px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">78</div>
                            </div>
                            <span class="text-[10px] font-bold text-slate-500 uppercase text-center">Lab Bahasa</span>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-4 bg-white p-8 rounded-xl shadow-sm border border-slate-200 flex flex-col">
                    <h4 class="font-headline text-lg font-bold text-[#002045] mb-6">Distribusi Status</h4>
                    <div class="flex-1 flex flex-col justify-center items-center">
                        
                        <div class="relative w-40 h-40 rounded-full bg-slate-100 overflow-hidden flex items-center justify-center shadow-inner">
                            <div class="absolute inset-0" style="background: conic-gradient(#002045 0% 65%, #fcd34d 65% 85%, #f87171 85% 100%);"></div>
                            <div class="absolute w-28 h-28 bg-white rounded-full flex flex-col items-center justify-center shadow-sm">
                                <span class="text-2xl font-black font-headline text-[#002045]">342</span>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total</span>
                            </div>
                        </div>

                        <div class="mt-8 w-full space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-[#002045]"></span>
                                    <span class="text-sm font-medium text-slate-700">Disetujui</span>
                                </div>
                                <span class="text-sm font-bold text-[#002045]">65%</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-amber-300"></span>
                                    <span class="text-sm font-medium text-slate-700">Pending (Menunggu)</span>
                                </div>
                                <span class="text-sm font-bold text-amber-600">20%</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-red-400"></span>
                                    <span class="text-sm font-medium text-slate-700">Ditolak</span>
                                </div>
                                <span class="text-sm font-bold text-red-600">15%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-6 border-b border-slate-200 flex justify-between items-center bg-white">
                    <h4 class="font-headline text-lg font-bold text-[#002045]">Daftar Riwayat Lengkap</h4>
                    <div class="flex items-center gap-2">
                        <button class="p-2 hover:bg-slate-100 rounded-lg transition-colors border border-transparent hover:border-slate-200 text-slate-500">
                            <span class="material-symbols-outlined text-sm">filter_list</span>
                        </button>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th class="px-8 py-4 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Peminjam</th>
                                <th class="px-6 py-4 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Ruangan</th>
                                <th class="px-6 py-4 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-4 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Waktu</th>
                                <th class="px-6 py-4 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Status</th>
                                <th class="px-8 py-4 text-[11px] font-bold text-slate-500 uppercase tracking-wider text-right">Detail</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-800 font-bold text-xs">AS</div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-800">Aditya Saputra</p>
                                            <p class="text-[10px] text-slate-500">NIM: 11223344</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <p class="text-sm font-medium text-slate-700">R. Seminar 1</p>
                                    <p class="text-[10px] text-slate-500">Gedung Dekanat</p>
                                </td>
                                <td class="px-6 py-5">
                                    <p class="text-sm font-medium text-slate-700">24 Okt 2026</p>
                                </td>
                                <td class="px-6 py-5">
                                    <p class="text-sm font-medium text-slate-700">08:00 - 12:00</p>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="px-3 py-1 bg-emerald-100 text-[10px] font-bold text-emerald-700 border border-emerald-200 rounded-full flex items-center w-max gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Disetujui
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <a href="admin/detail-permohonan" class="inline-block p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                        <span class="material-symbols-outlined text-sm">visibility</span>
                                    </a>
                                </td>
                            </tr>

                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center text-purple-800 font-bold text-xs">RM</div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-800">Rina Marlina</p>
                                            <p class="text-[10px] text-slate-500">NIDN: 19880112</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <p class="text-sm font-medium text-slate-700">Lab Komputer 3</p>
                                    <p class="text-[10px] text-slate-500">Gedung Teknik</p>
                                </td>
                                <td class="px-6 py-5">
                                    <p class="text-sm font-medium text-slate-700">25 Okt 2026</p>
                                </td>
                                <td class="px-6 py-5">
                                    <p class="text-sm font-medium text-slate-700">13:00 - 15:00</p>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="px-3 py-1 bg-amber-100 text-[10px] font-bold text-amber-700 border border-amber-200 rounded-full flex items-center w-max gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Menunggu
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <a href="#" class="inline-block p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                        <span class="material-symbols-outlined text-sm">visibility</span>
                                    </a>
                                </td>
                            </tr>

                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center text-red-800 font-bold text-xs">BP</div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-800">Bambang Pamungkas</p>
                                            <p class="text-[10px] text-slate-500">NIM: 11223355</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <p class="text-sm font-medium text-slate-700">Auditorium Lt. 4</p>
                                    <p class="text-[10px] text-slate-500">Gedung Utama</p>
                                </td>
                                <td class="px-6 py-5">
                                    <p class="text-sm font-medium text-slate-700">26 Okt 2026</p>
                                </td>
                                <td class="px-6 py-5">
                                    <p class="text-sm font-medium text-slate-700">10:00 - 17:00</p>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="px-3 py-1 bg-red-100 text-[10px] font-bold text-red-700 border border-red-200 rounded-full flex items-center w-max gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span> Ditolak
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <a href="#" class="inline-block p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                        <span class="material-symbols-outlined text-sm">visibility</span>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="px-8 py-6 bg-slate-50 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p class="text-xs font-medium text-slate-500">Menampilkan 1-3 dari 342 entri</p>
                    <div class="flex items-center gap-1">
                        <button class="p-2 rounded-lg text-slate-400 border border-slate-200 bg-white disabled:opacity-50" disabled>
                            <span class="material-symbols-outlined text-sm">chevron_left</span>
                        </button>
                        <button class="w-8 h-8 rounded-lg bg-[#002045] text-white text-xs font-bold shadow-sm">1</button>
                        <button class="w-8 h-8 rounded-lg border border-slate-200 bg-white hover:bg-slate-100 text-slate-600 text-xs font-bold transition-colors">2</button>
                        <button class="w-8 h-8 rounded-lg border border-slate-200 bg-white hover:bg-slate-100 text-slate-600 text-xs font-bold transition-colors">3</button>
                        <span class="px-2 text-slate-400">...</span>
                        <button class="w-8 h-8 rounded-lg border border-slate-200 bg-white hover:bg-slate-100 text-slate-600 text-xs font-bold transition-colors">86</button>
                        <button class="p-2 rounded-lg text-slate-600 border border-slate-200 bg-white hover:bg-slate-100 transition-colors">
                            <span class="material-symbols-outlined text-sm">chevron_right</span>
                        </button>
                    </div>
                </div>
            </section>
        </div>
    </main>

</body>
</html>