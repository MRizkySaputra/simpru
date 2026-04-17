<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Permohonan Masuk - SiPinjam Ruang</title>

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
                    <h1 class="text-xl font-black text-[#002045] font-headline leading-tight">SIMPRU</h1>
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
                <a class="flex items-center gap-3 px-4 py-3 font-bold rounded-lg mx-2 transition-transform scale-100 bg-white text-[#002045] shadow-sm" href="#">
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
                    <img alt="Admin Avatar" class="w-10 h-10 rounded-full object-cover" src="https://ui-avatars.com/api/?name=Administrator&background=002045&color=fff" />
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

    <main class="ml-64 min-h-screen">

        <header class="flex justify-between items-center w-full px-8 py-4 sticky top-0 z-50 bg-white/80 backdrop-blur-md shadow-sm border-b border-slate-100">
            <div class="flex items-center gap-4 flex-1">
                <h2 class="text-lg font-extrabold text-[#002045] font-headline hidden md:block mr-4">Permohonan Masuk</h2>
                <div class="relative w-full max-w-md">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
                    <input class="w-full pl-10 pr-4 py-2 bg-slate-100 border-none rounded-lg text-sm focus:ring-2 focus:ring-[#002045] focus:bg-white outline-none transition-all" placeholder="Cari peminjam, ruangan..." type="text" />
                </div>
            </div>
            <div class="flex items-center gap-6">
                <button class="relative text-slate-600 hover:text-[#002045] transition-colors">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="absolute top-0 right-0 w-2 h-2 bg-red-600 rounded-full"></span>
                </button>
            </div>
        </header>

        <div class="p-8 max-w-[1600px] mx-auto space-y-10">

            <!-- <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between hover:shadow-md transition-all">
                    <div class="flex justify-between items-start">
                        <div class="w-12 h-12 bg-blue-50 text-[#002045] rounded-lg flex items-center justify-center">
                            <span class="material-symbols-outlined text-3xl">meeting_room</span>
                        </div>
                        <span class="text-xs font-bold text-slate-400 tracking-wider">TOTAL</span>
                    </div>
                    <div class="mt-4">
                        <p class="text-3xl font-extrabold text-[#002045] font-headline">42</p>
                        <p class="text-sm font-medium text-slate-500">Total Ruangan</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between hover:shadow-md transition-all">
                    <div class="flex justify-between items-start">
                        <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-lg flex items-center justify-center">
                            <span class="material-symbols-outlined text-3xl">pending_actions</span>
                        </div>
                        <span class="px-2 py-1 bg-amber-100 text-amber-700 text-[10px] font-bold rounded">+12%</span>
                    </div>
                    <div class="mt-4">
                        <p class="text-3xl font-extrabold text-[#002045] font-headline">18</p>
                        <p class="text-sm font-medium text-slate-500">Permohonan Hari Ini</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between hover:shadow-md transition-all">
                    <div class="flex justify-between items-start">
                        <div class="w-12 h-12 bg-green-50 text-green-600 rounded-lg flex items-center justify-center">
                            <span class="material-symbols-outlined text-3xl">verified</span>
                        </div>
                        <span class="text-xs font-bold text-slate-400 tracking-wider">BULANAN</span>
                    </div>
                    <div class="mt-4">
                        <p class="text-3xl font-extrabold text-[#002045] font-headline">124</p>
                        <p class="text-sm font-medium text-slate-500">Disetujui Bulan Ini</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between hover:shadow-md transition-all">
                    <div class="flex justify-between items-start">
                        <div class="w-12 h-12 bg-red-50 text-red-600 rounded-lg flex items-center justify-center">
                            <span class="material-symbols-outlined text-3xl">cancel</span>
                        </div>
                        <span class="text-xs font-bold text-slate-400 tracking-wider">BULANAN</span>
                    </div>
                    <div class="mt-4">
                        <p class="text-3xl font-extrabold text-[#002045] font-headline">5</p>
                        <p class="text-sm font-medium text-slate-500">Ditolak Bulan Ini</p>
                    </div>
                </div>
            </section> -->

            <section class="space-y-6">
                <div class="flex justify-between items-end">
                    <div>
                        <h2 class="text-2xl font-extrabold text-[#002045] font-headline tracking-tight">Permohonan Terbaru</h2>
                        <p class="text-slate-500 text-sm mt-1">Daftar permohonan peminjaman ruangan yang memerlukan tindakan.</p>
                    </div>
                    <!-- <div class="flex gap-2">
                        <button class="px-4 py-2 bg-white border border-slate-200 text-slate-700 text-sm font-semibold rounded-lg hover:bg-slate-50 transition-colors flex items-center gap-2">
                            <span class="material-symbols-outlined text-lg">filter_list</span> Filter
                        </button>
                        <button class="px-4 py-2 bg-primary-gradient text-white text-sm font-semibold rounded-lg shadow-sm hover:opacity-90 transition-opacity">
                            Ekspor Laporan
                        </button>
                    </div> -->
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">

                        <div class="flex bg-slate-100 p-1 rounded-lg overflow-x-auto w-full sm:w-auto">
                            <button class="px-4 py-2 bg-white text-[#002045] text-sm font-bold rounded-md shadow-sm whitespace-nowrap transition-all">
                                Semua
                            </button>
                            <button class="px-4 py-2 text-slate-600 hover:text-[#002045] hover:bg-slate-200/50 text-sm font-medium rounded-md transition-all whitespace-nowrap flex items-center gap-1.5">
                                Menunggu
                                <!-- <span class="px-1.5 py-0.5 bg-amber-100 text-amber-700 rounded-full text-[10px] font-bold">4</span> -->
                            </button>
                            <button class="px-4 py-2 text-slate-600 hover:text-[#002045] hover:bg-slate-200/50 text-sm font-medium rounded-md transition-all whitespace-nowrap">
                                Disetujui
                            </button>
                            <button class="px-4 py-2 text-slate-600 hover:text-[#002045] hover:bg-slate-200/50 text-sm font-medium rounded-md transition-all whitespace-nowrap">
                                Ditolak
                            </button>
                        </div>
                        <div class="mt-4">
                            <p class="text-sm font-medium text-slate-500">Total Pending</p>
                            <p class="text-3xl font-extrabold text-[#002045] font-headline">12 Permintaan</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-slate-200">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200">
                                    <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Peminjam & Role</th>
                                    <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Ruangan</th>
                                    <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Tanggal & Waktu</th>
                                    <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Keperluan</th>
                                    <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest text-center">Status</th>
                                    <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">

                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-800 flex items-center justify-center text-xs font-bold shrink-0">AN</div>
                                            <div class="flex flex-col">
                                                <span class="text-sm font-bold text-[#002045]">Aditya Nugraha</span>
                                                <span class="w-max mt-1 px-2 py-0.5 bg-slate-100 text-slate-600 text-[9px] font-bold rounded border border-slate-200 uppercase tracking-wider">Mahasiswa</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-sm font-medium text-slate-600">Lab. Komputer 03</td>
                                    <td class="px-6 py-5">
                                        <p class="text-sm font-semibold text-[#002045]">24 Okt 2026</p>
                                        <p class="text-xs text-slate-400">09:00 - 12:00 WIB</p>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span class="text-sm text-slate-600 truncate max-w-[150px] inline-block">Praktikum Algoritma Lanjut</span>
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        <span class="px-3 py-1 bg-amber-100 text-amber-700 text-[10px] font-bold rounded-full uppercase tracking-wider">Pending</span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="/admin/detail-permohonan" title="Lihat Detail" class="p-2 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white rounded transition-all">
                                                <span class="material-symbols-outlined text-lg">visibility</span>
                                            </a>
                                            <button title="Setujui" class="p-2 bg-green-50 text-green-600 hover:bg-green-600 hover:text-white rounded transition-all">
                                                <span class="material-symbols-outlined text-lg">check</span>
                                            </button>
                                            <button title="Tolak" class="p-2 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded transition-all">
                                                <span class="material-symbols-outlined text-lg">close</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="bg-slate-50/30 hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-purple-100 text-purple-800 flex items-center justify-center text-xs font-bold shrink-0">SR</div>
                                            <div class="flex flex-col">
                                                <span class="text-sm font-bold text-[#002045]">Siti Rahayu</span>
                                                <span class="w-max mt-1 px-2 py-0.5 bg-purple-50 text-purple-700 text-[9px] font-bold rounded border border-purple-100 uppercase tracking-wider">Dosen</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-sm font-medium text-slate-600">Ruang Teater A</td>
                                    <td class="px-6 py-5">
                                        <p class="text-sm font-semibold text-[#002045]">25 Okt 2026</p>
                                        <p class="text-xs text-slate-400">13:00 - 15:30 WIB</p>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span class="text-sm text-slate-600 truncate max-w-[150px] inline-block">Seminar Nasional Robotika</span>
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        <span class="px-3 py-1 bg-amber-100 text-amber-700 text-[10px] font-bold rounded-full uppercase tracking-wider">Pending</span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="#" title="Lihat Detail" class="p-2 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white rounded transition-all">
                                                <span class="material-symbols-outlined text-lg">visibility</span>
                                            </a>
                                            <button title="Setujui" class="p-2 bg-green-50 text-green-600 hover:bg-green-600 hover:text-white rounded transition-all">
                                                <span class="material-symbols-outlined text-lg">check</span>
                                            </button>
                                            <button title="Tolak" class="p-2 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded transition-all">
                                                <span class="material-symbols-outlined text-lg">close</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-orange-100 text-orange-800 flex items-center justify-center text-xs font-bold shrink-0">BEM</div>
                                            <div class="flex flex-col">
                                                <span class="text-sm font-bold text-[#002045]">BEM Fakultas Teknik</span>
                                                <span class="w-max mt-1 px-2 py-0.5 bg-orange-50 text-orange-700 text-[9px] font-bold rounded border border-orange-100 uppercase tracking-wider">Organisasi</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-sm font-medium text-slate-600">R. Rapat Senat</td>
                                    <td class="px-6 py-5">
                                        <p class="text-sm font-semibold text-[#002045]">26 Okt 2026</p>
                                        <p class="text-xs text-slate-400">10:00 - 11:30 WIB</p>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span class="text-sm text-slate-600 truncate max-w-[150px] inline-block">Rapat Koordinasi BEM</span>
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        <span class="px-3 py-1 bg-amber-100 text-amber-700 text-[10px] font-bold rounded-full uppercase tracking-wider">Pending</span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="#" title="Lihat Detail" class="p-2 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white rounded transition-all">
                                                <span class="material-symbols-outlined text-lg">visibility</span>
                                            </a>
                                            <button title="Setujui" class="p-2 bg-green-50 text-green-600 hover:bg-green-600 hover:text-white rounded transition-all">
                                                <span class="material-symbols-outlined text-lg">check</span>
                                            </button>
                                            <button title="Tolak" class="p-2 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded transition-all">
                                                <span class="material-symbols-outlined text-lg">close</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="bg-slate-50/30 hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center text-xs font-bold shrink-0">DL</div>
                                            <div class="flex flex-col">
                                                <span class="text-sm font-bold text-[#002045]">Diana Lestari</span>
                                                <span class="w-max mt-1 px-2 py-0.5 bg-emerald-50 text-emerald-700 text-[9px] font-bold rounded border border-emerald-100 uppercase tracking-wider">Staf Akademik</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-sm font-medium text-slate-600">Aula Utama</td>
                                    <td class="px-6 py-5">
                                        <p class="text-sm font-semibold text-[#002045]">28 Okt 2026</p>
                                        <p class="text-xs text-slate-400">08:00 - 17:00 WIB</p>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span class="text-sm text-slate-600 truncate max-w-[150px] inline-block">Wisuda Gelombang II</span>
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        <span class="px-3 py-1 bg-amber-100 text-amber-700 text-[10px] font-bold rounded-full uppercase tracking-wider">Pending</span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="#" title="Lihat Detail" class="p-2 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white rounded transition-all">
                                                <span class="material-symbols-outlined text-lg">visibility</span>
                                            </a>
                                            <button title="Setujui" class="p-2 bg-green-50 text-green-600 hover:bg-green-600 hover:text-white rounded transition-all">
                                                <span class="material-symbols-outlined text-lg">check</span>
                                            </button>
                                            <button title="Tolak" class="p-2 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded transition-all">
                                                <span class="material-symbols-outlined text-lg">close</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="px-6 py-4 bg-slate-50 flex justify-between items-center border-t border-slate-200">
                        <p class="text-xs text-slate-500 font-medium">Menampilkan 4 dari 18 permohonan tertunda</p>
                        <div class="flex gap-2">
                            <button class="p-1 hover:bg-slate-200 rounded transition-colors text-slate-400 disabled:opacity-30" disabled>
                                <span class="material-symbols-outlined">chevron_left</span>
                            </button>
                            <button class="p-1 hover:bg-slate-200 rounded transition-colors text-slate-600">
                                <span class="material-symbols-outlined">chevron_right</span>
                            </button>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

</body>

</html>